<?php

namespace App\Tibia;

use App\Support\Guzzle\RateLimiterMiddleware;
use Dom\Element;
use Dom\HTMLDocument;
use Dom\XPath;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\RedirectMiddleware;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Uri;

class Crawler
{
    private const string LOGIN_URL = 'https://www.tibia.com/account/';

    private const string COIN_HISTORY_URL = 'https://www.tibia.com/account/?subtopic=accountmanagement&page=tibiacoinshistory';

    private const string GUILDS_SUBTOPIC_URL = 'https://www.tibia.com/community/?subtopic=guilds';

    private readonly Client $client;

    private bool $isLoggedIn = false;

    public function __construct()
    {
        $this->client = $this->buildStealthClient();
    }

    /**.
     * @throws ConnectionException
     * @throws Exception
     */
    public function login(
        string $email,
        string $password,
        ?string $token = null
    ): void {
        if ($this->isLoggedIn) {
            return;
        }

        $res = Http::setClient($this->client)
            ->asForm()
            ->post(self::LOGIN_URL, [
                'loginemail' => $email,
                'loginpassword' => $password,
            ]);

        $redirectedUri = $this->getRedirectedUri($res);
        if ($redirectedUri?->query()->get('page') === 'twofactor') {
            if (! $token) {
                // TODO: use custom exception
                throw new Exception('Account requires TOTP token but none was provided');
            }

            $res = Http::setClient($this->client)
                ->asForm()
                ->post($redirectedUri, [
                    'totp' => $token,
                    'step' => 'authenticatelogin',
                ]);
        }

        $this->isLoggedIn = str_contains($res->getBody(), 'Logout');
        if (! $this->isLoggedIn) {
            // TODO: use custom exception
            throw new Exception('Login failed');
        }
    }

    /**
     * @param  positive-int  $page
     * @return array<array<string, string>>
     *
     * @throws ConnectionException
     * @throws Exception
     */
    public function getCoinHistoryPage(int $page = 1): array
    {
        $this->checkLogin();

        $url = Uri::of(self::COIN_HISTORY_URL)
            ->withQuery(['currentpage' => $page]);

        $res = Http::setClient($this->client)
            ->get($url);

        return $this->extractTableData($res, 'Coins History');
    }

    /**
     * @param  positive-int  $lastKnownEntry
     * @return array<array<string, string>>
     *
     * @throws ConnectionException
     */
    public function getCoinHistoryUntil(int $lastKnownEntry = 1): array
    {
        $data = $this->getCoinHistoryPage();

        for ($i = 2; intval(Arr::last($data)['#']) > $lastKnownEntry; $i++) {
            $pageData = $this->getCoinHistoryPage($i);
            $data = [
                ...$data,
                ...$pageData,
            ];
        }

        return $data;
    }

    /**
     * @param  positive-int  $rank
     *
     * @throws ConnectionException
     * @throws Exception
     */
    public function setCharacterRank(string $guildName, string $characterName, int $rank): void
    {
        $this->checkLogin();

        $res = Http::setClient($this->client)
            ->asForm()
            ->post(self::GUILDS_SUBTOPIC_URL, [
                'page' => 'promote',
                'action' => 'setrank',
                'GuildName' => $guildName,
                'character' => $characterName,
                'newrank' => $rank,
            ]);
    }

    /**
     * @throws ConnectionException
     * @throws Exception
     */
    public function excludeCharacter(string $guildName, string $characterName): void
    {
        $this->checkLogin();

        $res = Http::setClient($this->client)
            ->asForm()
            ->post(self::GUILDS_SUBTOPIC_URL, [
                'page' => 'promote',
                'action' => 'exclude',
                'GuildName' => $guildName,
                'character' => $characterName,
            ]);
    }

    /**
     * @return array<array<string, string>>
     */
    private function extractTableData(Response $response, string $tableCaption): array
    {
        $dom = HTMLDocument::createFromString($response->getBody(), LIBXML_NOERROR);
        $rows = new XPath($dom)->query(
            // for any .TableContainer ...
            '//*[@class="TableContainer"]'
            // which has a child element with matching text ...
            .'[.//*[@class="CaptionInnerContainer"]//*[@class="Text"][text()="'.$tableCaption.'"]]'
            // find all its child row elements
            .'//*[@class="TableContent"]/*/*'
        );

        $headers = [];
        $data = [];
        /** @var Element $row */
        foreach ($rows as $row) {
            $rowData = [];
            foreach ($row->childNodes as $col) {
                $rowData[] = trim($col->textContent);
            }

            // last column is always empty
            array_pop($rowData);

            if (empty($headers)) {
                $headers = $rowData;

                continue;
            }

            if (count($headers) !== count($rowData)) {
                continue;
            }

            $data[] = array_combine($headers, $rowData);
        }

        return $data;
    }

    private function buildStealthClient(): Client
    {
        $stack = (new PendingRequest)->buildHandlerStack();
        $stack->push(RateLimiterMiddleware::perSeconds(1, 2.5));

        return new Client([
            'handler' => $stack,
            'cookies' => true,
            'allow_redirects' => ['track_redirects' => true],

            // this is explicitly set to prevent Guzzle from
            // setting the 'Accept-Encoding' header later on
            'curl' => [CURLOPT_ENCODING => ''],
            '_conditional' => [],
        ]);
    }

    private function getRedirectedUri(Response $response): ?Uri
    {
        $headers = $response->getHeader(RedirectMiddleware::HISTORY_HEADER);
        if (empty($headers)) {
            return null;
        }

        return Uri::of($headers[0]);
    }

    /**
     * @throws Exception
     */
    private function checkLogin(): void
    {
        if (! $this->isLoggedIn) {
            // TODO: use custom exception
            throw new Exception('You need to login first');
        }
    }
}

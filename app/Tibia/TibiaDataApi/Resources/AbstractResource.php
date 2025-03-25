<?php

namespace App\Tibia\TibiaDataApi\Resources;

use GuzzleHttp\Client;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

abstract class AbstractResource
{
    public readonly Client $client;

    public function __construct()
    {
        $this->client = (new PendingRequest)->buildClient();
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    protected function request(string $url): Response
    {
        $client = Http::setClient($this->client)
            ->withUrlParameters([
                'baseUrl' => 'https://api.tibiadata.com',
                'version' => 'v4',
            ])
            ->baseUrl('{+baseUrl}/{version}');

        $response = $client->get($url);

        if ($response->failed()) {
            $response->throw();
        }

        return $response;
    }
}

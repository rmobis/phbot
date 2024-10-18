<?php

namespace App\Tibia\TibiaDataApi\Resources;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

abstract class AbstractResource
{
    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function request(string $url): Response
    {
        $client = Http::withUrlParameters([
            'baseUrl' => 'https://api.tibiadata.com',
            'version' => 'v4',
            'url' => $url,
        ])->baseUrl('{+baseUrl}/{version}');

        $response = $client->get($url);

        if ($response->failed()) {
            $response->throw();
        }

        return $response;
    }
}

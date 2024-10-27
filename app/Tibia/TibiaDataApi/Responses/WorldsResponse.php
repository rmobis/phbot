<?php

namespace App\Tibia\TibiaDataApi\Responses;

use App\Tibia\Data\WorldsData;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;

class WorldsResponse extends AbstractResponse
{
    public readonly WorldsData $worlds;

    public function __construct(Response $response)
    {
        parent::__construct($response);

        $json = $response->json('worlds');

        if (Arr::get($json, 'tournament_worlds') === null) {
            Arr::set($json, 'tournament_worlds', []);
        }

        $this->worlds = WorldsData::from($json);
    }
}

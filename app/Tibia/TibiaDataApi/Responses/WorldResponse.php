<?php

namespace App\Tibia\TibiaDataApi\Responses;

use App\Tibia\Data\WorldData;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;

class WorldResponse extends AbstractResponse
{
    public readonly WorldData $world;

    public function __construct(Response $response)
    {
        parent::__construct($response);

        $json = $response->json('world');

        if (Arr::get($json, 'world_quest_titles') === null) {
            Arr::set($json, 'world_quest_titles', []);
        }

        $this->world = WorldData::from($json);
    }
}

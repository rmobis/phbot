<?php

namespace App\Tibia\TibiaDataApi\Responses;

use App\Tibia\Data\GuildsData;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;

class GuildsResponse extends AbstractResponse
{
    public readonly GuildsData $guilds;

    public function __construct(Response $response)
    {
        parent::__construct($response);

        $json = $response->json('guilds');

        if (Arr::get($json, 'active') === null) {
            Arr::set($json, 'active', []);
        }

        if (Arr::get($json, 'formation') === null) {
            Arr::set($json, 'formation', []);
        }

        $this->guilds = GuildsData::from($json);
    }
}

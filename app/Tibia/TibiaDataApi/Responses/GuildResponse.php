<?php

namespace App\Tibia\TibiaDataApi\Responses;

use App\Tibia\Data\GuildData;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;

class GuildResponse extends AbstractResponse
{
    public readonly GuildData $guild;

    public function __construct(Response $response)
    {
        parent::__construct($response);

        $json = $response->json('guild');

        if (Arr::get($json, 'invites') === null) {
            Arr::set($json, 'invites', []);
        }

        $this->guild = GuildData::from($json);
    }
}

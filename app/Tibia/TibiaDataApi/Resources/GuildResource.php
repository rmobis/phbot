<?php

namespace App\Tibia\TibiaDataApi\Resources;

use App\Tibia\TibiaDataApi\Responses\GuildResponse;
use App\Tibia\TibiaDataApi\Responses\GuildsResponse;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;

class GuildResource extends AbstractResource
{
    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function get(string $guild): GuildResponse
    {
        $response = $this->request("/guild/$guild");

        return new GuildResponse($response);
    }

    /**
     * @throws ConnectionException
     * @throws RequestException
     */
    public function fromWorld(string $world): GuildsResponse
    {
        $response = $this->request("/guilds/$world");

        return new GuildsResponse($response);
    }
}

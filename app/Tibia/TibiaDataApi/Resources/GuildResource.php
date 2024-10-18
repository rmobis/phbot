<?php

namespace App\Tibia\TibiaDataApi\Resources;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use stdClass;

class GuildResource extends AbstractResource
{
    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function get(string $guild): stdClass
    {
        return $this->request("/guild/$guild")
            ->object()
            ->guild;
    }

    /**
     * @return Collection<stdClass>
     *
     * @throws RequestException
     * @throws ConnectionException
     */
    public function activeInWorld(string $world): Collection
    {
        return collect(
            $this->request("/guilds/$world")
                ->object()
                ->guilds
                ->active
        );
    }
}

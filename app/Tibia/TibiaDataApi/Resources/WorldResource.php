<?php

namespace App\Tibia\TibiaDataApi\Resources;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use stdClass;

class WorldResource extends AbstractResource
{
    /**
     * @return Collection<stdClass>
     *
     * @throws RequestException
     * @throws ConnectionException
     */
    public function all(): Collection
    {
        return collect(
            $this->request('/worlds')
                ->object()
                ->worlds
                ->regular_worlds
        );
    }
}

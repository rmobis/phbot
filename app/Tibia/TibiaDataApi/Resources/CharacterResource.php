<?php

namespace App\Tibia\TibiaDataApi\Resources;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;

class CharacterResource extends AbstractResource
{
    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function get(string $name): \stdClass
    {
        return $this->request("/character/$name")
            ->object()
            ->character;
    }
}

<?php

namespace App\Tibia\TibiaDataApi\Resources;

use App\Tibia\TibiaDataApi\Responses\CharacterResponse;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;

class CharacterResource extends AbstractResource
{
    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function get(string $name): CharacterResponse
    {
        $response = $this->request("/character/$name");

        return new CharacterResponse($response);
    }
}

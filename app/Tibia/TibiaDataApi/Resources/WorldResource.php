<?php

namespace App\Tibia\TibiaDataApi\Resources;

use App\Tibia\TibiaDataApi\Responses\WorldResponse;
use App\Tibia\TibiaDataApi\Responses\WorldsResponse;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;

class WorldResource extends AbstractResource
{
    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function all(): WorldsResponse
    {
        $response = $this->request('/worlds');

        return new WorldsResponse($response);
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function get(string $world): WorldResponse
    {
        $response = $this->request("/world/$world");

        return new WorldResponse($response);
    }
}

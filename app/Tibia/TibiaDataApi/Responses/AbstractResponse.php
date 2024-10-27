<?php

namespace App\Tibia\TibiaDataApi\Responses;

use App\Tibia\Data\InformationData;
use Illuminate\Http\Client\Response;

abstract class AbstractResponse extends Response
{
    public readonly InformationData $information;

    public function __construct(Response $response)
    {
        parent::__construct($response->response);

        $this->information = InformationData::from(
            $this->json('information')
        );
    }
}

<?php

namespace App\Tibia\TibiaDataApi\Responses;

use App\Tibia\Data\CharacterData;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;

class CharacterResponse extends AbstractResponse
{
    public readonly CharacterData $character;

    public function __construct(Response $response)
    {
        parent::__construct($response);

        $json = $response->json('character');
        // I honestly don't know why the fuck this works that way, but when the character
        // is not in a guild or is a hidden character which displays no account information,
        // instead of omitting the data for that section - which is weird behavior but at least
        // consistent with the rest of the API - or passing in null, it passes an empty object;
        // that breaks the data object creation, so we patch it
        if (Arr::get($json, 'account_information') === []) {
            Arr::forget($json, 'account_information');
        }

        if (Arr::get($json, 'character.guild') === []) {
            Arr::forget($json, 'character.guild');
        }

        if (Arr::get($json, 'account_badges') === null) {
            Arr::set($json, 'account_badges', []);
        }

        if (Arr::get($json, 'achievements') === null) {
            Arr::set($json, 'achievements', []);
        }

        if (Arr::get($json, 'deaths') === null) {
            Arr::set($json, 'deaths', []);
        }

        if (Arr::get($json, 'other_characters') === null) {
            Arr::set($json, 'other_characters', []);
        }

        if (Arr::get($json, 'character.former_names') === null) {
            Arr::set($json, 'character.former_names', []);
        }

        if (Arr::get($json, 'character.former_worlds') === null) {
            Arr::set($json, 'character.former_worlds', []);
        }

        if (Arr::get($json, 'character.houses') === null) {
            Arr::set($json, 'character.houses', []);
        }

        try {

            $this->character = CharacterData::from($json);
        } catch (\Throwable $exception) {
            dd($json, $exception);
        }
    }
}

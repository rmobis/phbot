<?php

namespace App\Tibia;

use App\Models\Character;
use App\Models\Guild;
use App\Models\World;
use App\Support\Enum\Region;
use App\Support\Enum\Vocation;
use App\Support\Enum\WorldType;
use App\Tibia\TibiaDataApi\Resources\GuildResource;
use App\Tibia\TibiaDataApi\Resources\WorldResource;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;

class TibiaService
{
    public function __construct(
        protected WorldResource $worldResource,
        protected GuildResource $guildResource,
    ) {}

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function importWorlds(): void
    {
        $apiWorlds = $this->worldResource->all()
            ->keyBy('name');

        foreach ($apiWorlds as $apiWorld) {
            World::updateOrCreate(
                ['name' => $apiWorld->name],
                [
                    'region' => Region::from($apiWorld->location),
                    'type' => WorldType::from($apiWorld->pvp_type),
                ]
            );
        }
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function importGuilds(World $world): void
    {
        $apiGuilds = $this->guildResource->activeInWorld($world->name)
            ->keyBy('name');

        foreach ($apiGuilds as $apiGuild) {
            Guild::updateOrCreate(
                ['name' => $apiGuild->name],
                [
                    'description' => $apiGuild->description,
                    'logo' => $apiGuild->logo_url,
                    'world_id' => $world->id,
                ]
            );
        }
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function importGuildCharacters(Guild $guild): void
    {
        $apiGuild = $this->guildResource->get($guild->name);
        $apiGuildCharacters = $apiGuild->members;

        foreach ($apiGuildCharacters as $apiGuildCharacter) {
            Character::updateOrCreate(
                ['name' => $apiGuildCharacter->name],
                [
                    'level' => $apiGuildCharacter->level,
                    'vocation' => Vocation::from($apiGuildCharacter->vocation),
                    'world_id' => $guild->world_id,
                    'guild_id' => $guild->id,
                    'guild_rank' => $apiGuildCharacter->rank,
                ]
            );
        }
    }
}

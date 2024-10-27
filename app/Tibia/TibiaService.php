<?php

namespace App\Tibia;

use App\Models\Character;
use App\Models\Guild;
use App\Models\World;
use App\Support\Enum\Region;
use App\Support\Enum\Vocation;
use App\Support\Enum\WorldType;
use App\Tibia\Data\Guild\MemberData;
use App\Tibia\Data\Guilds\GuildData;
use App\Tibia\Data\Worlds\WorldData;
use App\Tibia\TibiaDataApi\Resources\CharacterResource;
use App\Tibia\TibiaDataApi\Resources\GuildResource;
use App\Tibia\TibiaDataApi\Resources\WorldResource;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;

class TibiaService
{
    public function __construct(
        protected WorldResource $worldResource,
        protected GuildResource $guildResource,
        protected CharacterResource $characterResource,
    ) {}

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function importWorlds(): void
    {
        $response = $this->worldResource->all();
        $apiWorlds = $response->worlds->regularWorlds;

        /** @var WorldData $apiWorld */
        foreach ($apiWorlds as $apiWorld) {
            World::updateOrCreate(
                ['name' => $apiWorld->name],
                [
                    'region' => Region::from($apiWorld->location),
                    'type' => WorldType::from($apiWorld->pvpType),
                ],
            );
        }
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function importGuildsFromWorld(World $world): void
    {
        $response = $this->guildResource->fromWorld($world->name);
        $apiGuilds = $response->guilds->active;

        /** @var GuildData $apiGuild */
        foreach ($apiGuilds as $apiGuild) {
            Guild::updateOrCreate(
                ['name' => $apiGuild->name],
                [
                    'description' => $apiGuild->description,
                    'logo' => $apiGuild->logoUrl,
                    'world_id' => $world->id,
                ],
            );
        }
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function importCharactersFromGuild(Guild $guild): void
    {
        $response = $this->guildResource->get($guild->name);
        $apiMembers = $response->guild->members;

        /** @var MemberData $apiMember */
        foreach ($apiMembers as $apiMember) {
            echo "Importing $apiMember->name".PHP_EOL;
            $this->importCharacter($apiMember->name);
        }
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function importCharacter(string $name): void
    {
        $response = $this->characterResource->get($name);
        $apiCharacter = $response->character->character;

        $possibleNames = [
            $apiCharacter->name,
            ...$apiCharacter->formerNames,
        ];

        $worldId = $this->getWorldId($apiCharacter->world);
        $guildId = $this->getGuildId($apiCharacter->guild?->name);

        $existingCharacter = Character::whereAnyName($possibleNames)->first();
        $attributes = [
            'name' => $apiCharacter->name,
            'level' => $apiCharacter->level,
            'vocation' => Vocation::from($apiCharacter->vocation),
            'world_id' => $worldId,
            'guild_id' => $guildId,
            'guild_rank' => $apiCharacter->guild?->rank,
        ];

        if ($existingCharacter instanceof Character) {
            $existingCharacter
                ->updateTimestamps()
                ->update($attributes);

            return;
        }

        Character::create($attributes);
    }

    protected function getWorldId(string $name): int
    {
        $world = World::whereName($name)
            ->firstOrFail();

        return $world->id;
    }

    protected function getGuildId(?string $name): ?int
    {
        if (! is_string($name)) {
            return null;
        }

        $guild = Guild::whereName($name)
            ->firstOrFail();

        return $guild->id;
    }
}

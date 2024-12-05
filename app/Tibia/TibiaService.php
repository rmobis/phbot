<?php

namespace App\Tibia;

use App\Models\Character;
use App\Models\Guild;
use App\Models\World;
use App\Support\Enums\Region;
use App\Support\Enums\Vocation;
use App\Support\Enums\WorldType;
use App\Tibia\Data\Guild\MemberData;
use App\Tibia\Data\Guilds\GuildData;
use App\Tibia\Data\Worlds\WorldData;
use App\Tibia\TibiaDataApi\Resources\CharacterResource;
use App\Tibia\TibiaDataApi\Resources\GuildResource;
use App\Tibia\TibiaDataApi\Resources\WorldResource;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;

class TibiaService
{
    public function __construct(
        protected WorldResource $worldResource,
        protected GuildResource $guildResource,
        protected CharacterResource $characterResource,
    ) {}

    /**
     * @return Collection<World>
     *
     * @throws RequestException
     * @throws ConnectionException
     */
    public function importWorlds(): Collection
    {
        $response = $this->worldResource->all();
        $apiWorlds = $response->worlds->regularWorlds;

        return $apiWorlds->map(
            static fn (WorldData $apiWorld) => World::updateOrCreate(
                ['name' => $apiWorld->name],
                [
                    'region' => Region::from($apiWorld->location),
                    'type' => WorldType::from($apiWorld->pvpType),
                ],
            )
        );
    }

    /**
     * @return Collection<Guild>
     *
     * @throws RequestException
     * @throws ConnectionException
     */
    public function importGuildsFromWorld(World $world): Collection
    {
        $response = $this->guildResource->fromWorld($world->name);
        $apiGuilds = $response->guilds->active;

        return $apiGuilds->map(
            static fn (GuildData $apiGuild) => Guild::updateOrCreate(
                ['name' => $apiGuild->name],
                [
                    'description' => $apiGuild->description,
                    'logo' => $apiGuild->logoUrl,
                    'world_id' => $world->id,
                ],
            )
        );
    }

    /**
     * @return Collection<Character>
     *
     * @throws RequestException
     * @throws ConnectionException
     */
    public function importCharactersFromGuild(Guild $guild): Collection
    {
        $response = $this->guildResource->get($guild->name);
        $apiMembers = $response->guild->members;

        return $apiMembers->map(
            static fn (MemberData $apiMember) => $this->importCharacter($apiMember->name)
        );
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function importCharacter(string $name): Character
    {
        $response = $this->characterResource->get($name);
        $apiCharacter = $response->character->character;

        $possibleNames = [
            $apiCharacter->name,
            ...$apiCharacter->formerNames,
        ];

        $world = $this->getWorld($apiCharacter->world);
        $guild = $this->getGuild($world, $apiCharacter->guild?->name);

        $existingCharacter = Character::whereAnyName($possibleNames)->first();
        $attributes = [
            'name' => $apiCharacter->name,
            'level' => $apiCharacter->level,
            'vocation' => Vocation::from($apiCharacter->vocation),
            'world_id' => $world->id,
            'guild_id' => $guild?->id,
            'guild_rank' => $apiCharacter->guild?->rank,
        ];

        if ($existingCharacter instanceof Character) {
            $existingCharacter
                ->updateTimestamps()
                ->update($attributes);

            return $existingCharacter;
        }

        return Character::create($attributes);
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    protected function getWorld(string $name): World
    {
        $world = World::whereName($name)
            ->first(['id', 'name']);

        if (! $world instanceof World) {
            $worlds = $this->importWorlds();
            $world = $worlds->firstWhere('name', $name);
        }

        return $world;
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    protected function getGuild(World $world, ?string $name): ?Guild
    {
        if (! is_string($name)) {
            return null;
        }

        $guild = Guild::whereName($name)
            ->first(['id', 'name']);

        if (! $guild instanceof Guild) {
            $guilds = $this->importGuildsFromWorld($world);
            $guild = $guilds->firstWhere('name', $name);
        }

        return $guild;
    }
}

<?php

namespace App\Observers;

use App\Models\Character;
use App\Models\CharacterEvent;
use App\Models\Guild;
use App\Models\World;
use App\Support\Enums\CharacterEventType;
use Carbon\Carbon;
use Exception;

class CharacterObserver
{
    /**
     * Handles creating character events when the character is created.
     *
     * @throws Exception
     */
    public function created(Character $char): void
    {
        $this->createEvent($char, CharacterEventType::FirstSeen, payload: $char->toArray());
    }

    /**
     * Handles creating character events when the character is updated.
     *
     * @throws Exception
     */
    public function updated(Character $char): void
    {
        if ($char->isDirty('name')) {
            $this->createEvent($char, CharacterEventType::NameChange, $char->getOriginal('name'), $char->name);
        }

        if ($char->isDirty('level')) {
            $oldLevel = $char->getOriginal('level');
            $newLevel = $char->level;
            $eventType = $newLevel > $oldLevel ? CharacterEventType::LevelUp : CharacterEventType::LevelDown;

            $this->createEvent($char, $eventType, (string) $oldLevel, (string) $newLevel);
        }

        if ($char->isDirty('world_id')) {
            $oldWorld = World::whereId($char->getOriginal('world_id'))->firstOrFail();
            $newWorld = $char->load('world')->world;

            $this->createEvent($char, CharacterEventType::WorldTransfer, $oldWorld->name, $newWorld->name);
        }

        if ($char->isDirty('guild_id')) {
            $oldGuildId = $char->getOriginal('guild_id');
            $oldGuild = $oldGuildId ? Guild::whereId($oldGuildId)->firstOrFail() : null;
            $newGuild = $char->load('guild')->guild;

            if ($oldGuild instanceof Guild) {
                $this->createEvent(
                    $char,
                    CharacterEventType::LeaveGuild,
                    $oldGuild->name,
                    null,
                    ['rank' => $char->getOriginal('guild_rank')]
                );
            }

            if ($newGuild instanceof Guild) {
                $this->createEvent(
                    $char,
                    CharacterEventType::JoinGuild,
                    null,
                    $newGuild->name,
                    ['rank' => $char->guild_rank]
                );
            }
        }

        if (! $char->isDirty('guild_id') && $char->isDirty('guild_rank')) {
            $this->createEvent(
                $char,
                CharacterEventType::PromotedDemoted,
                $char->getOriginal('guild_rank'),
                $char->guild_rank
            );
        }

        $this->createEvent($char, CharacterEventType::FullUpdate, $char->getOriginal('updated_at'), $char->updated_at);
    }

    /**
     * @throws Exception
     */
    protected function getHappenedAt(Character $character): Carbon
    {
        $happenedAt = $character->updated_at ?? $character->created_at;
        if (! $happenedAt instanceof Carbon) {
            throw new Exception('Missing both timestamps on saved character');
        }

        return $happenedAt;
    }

    /**
     * @throws Exception
     */
    protected function createEvent(
        Character $character,
        CharacterEventType $type,
        ?string $oldValue = null,
        ?string $newValue = null,
        ?array $payload = null
    ): void {
        $happenedAt = $this->getHappenedAt($character);

        CharacterEvent::create([
            'character_id' => $character->id,
            'happened_at' => $happenedAt,
            'type' => $type,
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'payload' => json_encode($payload),
        ]);
    }
}

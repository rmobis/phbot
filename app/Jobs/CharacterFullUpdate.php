<?php

namespace App\Jobs;

use App\Tibia\TibiaService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;

class CharacterFullUpdate implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly string $characterName,
    ) {}

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function handle(
        TibiaService $tibiaService,
    ): void {
        $tibiaService->importCharacter($this->characterName);
        info("Character {$this->characterName} updated");
    }
}

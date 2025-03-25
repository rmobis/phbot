<?php

namespace App\Console\Commands;

use App\Jobs\CharacterFullUpdate;
use App\Models\Character;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class UpdateStaleCharacters extends Command
{
    /**
     * @var string
     */
    protected $signature = 'app:update-stale-characters
                            {seconds=3600 : How many seconds until a character is considered stale}
                            {--s|sync : Skips the queue and updates synchronously}';

    /**
     * @var string
     */
    protected $description = 'Updates all characters that have not been updated for a given amount of time';

    public function handle(): int
    {
        $seconds = intval($this->argument('seconds'));
        $useQueue = ! $this->option('sync');
        $staleDate = Carbon::now()->subSeconds($seconds);

        $this->info('Fetching characters for update...');
        $characters = Character::where('updated_at', '<', $staleDate)
            ->limit(30)
            ->get();

        if ($characters->isEmpty()) {
            $this->warn('No characters found for update.');

            return 0;
        }

        $this->info($useQueue ? 'Pushing jobs...' : 'Updating characters...');
        $this->withProgressBar($characters, fn (Character $character) => $this->updateCharacter($character));

        return 0;
    }

    private function updateCharacter(Character $character): void
    {
        $useQueue = ! $this->option('sync');

        if ($useQueue) {
            CharacterFullUpdate::dispatch($character->name);
        } else {
            CharacterFullUpdate::dispatchSync($character->name);
        }
    }
}

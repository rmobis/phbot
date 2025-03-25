<?php

namespace App\Console\Commands;

use App\Models\Guild;
use App\Tibia\TibiaService;
use Illuminate\Console\Command;

class ImportCharacters extends Command
{
    /**
     * @var string
     */
    protected $signature = 'app:import-characters
                            {guild : Name of the guild to import characters from}';

    /**
     * @var string
     */
    protected $description = 'Imports all characters from given guild';

    /**
     * Execute the console command.
     */
    public function handle(
        TibiaService $tibiaService,
    ) {
        $guildName = $this->argument('guild');
        $guild = Guild::where('name', $guildName)->firstOrFail();

        $this->info("Importing characters from guild {$guild->name}...");
        $tibiaService->importCharactersFromGuild($guild);
    }
}

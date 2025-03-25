<?php

namespace App\Console\Commands;

use App\Models\World;
use App\Tibia\TibiaService;
use Illuminate\Console\Command;

class ImportGuilds extends Command
{
    /**
     * @var string
     */
    protected $signature = 'app:import-guilds
                            {world : Name of the world to import guilds from}';

    /**
     * @var string
     */
    protected $description = 'Imports all guilds from given world';

    /**
     * Execute the console command.
     */
    public function handle(
        TibiaService $tibiaService,
    ) {
        $worldName = $this->argument('world');
        $world = World::where('name', $worldName)->firstOrFail();

        $this->info("Importing guilds from world {$world->name}...");
        $tibiaService->importGuildsFromWorld($world);
    }
}

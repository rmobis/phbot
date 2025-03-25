<?php

namespace App\Console\Commands;

use App\Tibia\TibiaService;
use Illuminate\Console\Command;

class ImportWorlds extends Command
{
    /**
     * @var string
     */
    protected $signature = 'app:import-worlds';

    /**
     * @var string
     */
    protected $description = 'Imports all worlds';

    /**
     * Execute the console command.
     */
    public function handle(
        TibiaService $tibiaService,
    ) {
        $this->info('Importing worlds...');
        $tibiaService->importWorlds();
    }
}

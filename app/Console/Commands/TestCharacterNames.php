<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class TestCharacterNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-character-names';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $regex = '/^([ÄÖÜA-Z][ÄÖÜA-zäöü\-\'.]*(?: [ÄÖÜA-zäöü\-\'.]+){,5})$/';
        $data = collect(Storage::json('charnames.json'));
        $nomatch = $data->filter(static fn ($item) => ! preg_match($regex, $item));
        dd($nomatch->values());
    }
}

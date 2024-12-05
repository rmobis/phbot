<?php

use App\Models\World;
use App\Tibia\TibiaService;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

Route::get('/test/{name}', function (
    string $name,
    TibiaService $tibiaService
) {
    set_time_limit(3000);
    $tibiaService->importWorlds();

    $etebra = World::whereName('Etebra')->firstOrFail();
    $tibiaService->importGuildsFromWorld($etebra);

    $exalted = Guild::whereName('Exalted')->firstOrFail();
    $tibiaService->importCharactersFromGuild($exalted);

    return 'hi';
});

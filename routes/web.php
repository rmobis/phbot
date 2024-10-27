<?php

use App\Models\Guild;
use App\Models\World;
use App\Tibia\TibiaService;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

Route::get('/test/{name}', function (
    string $name,
    TibiaService $tibiaService
) {
    $tibiaService->importWorlds();

    $etebra = World::whereName('Etebra')->firstOrFail();
    $tibiaService->importGuildsFromWorld($etebra);

    $exalted = Guild::whereName('Exalted')->firstOrFail();
    $tibiaService->importCharactersFromGuild($exalted);

    return 'hi';
});

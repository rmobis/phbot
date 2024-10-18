<?php

use App\Models\Guild;
use App\Models\World;
use App\Tibia\TibiaDataApi\Resources\CharacterResource;
use App\Tibia\TibiaService;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

Route::get('/test/{name}', function (
    string $name,
    CharacterResource $characterResource,
    TibiaService $tibiaService
) {
    $tibiaService->importWorlds();

    $etebra = World::whereName('Etebra')->firstOrFail();
    $tibiaService->importGuilds($etebra);

    $exalted = Guild::whereName('Exalted')->firstOrFail();
    $tibiaService->importGuildCharacters($exalted);

    return 'hi';
});

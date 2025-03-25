<?php

use App\Tibia\TibiaService;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

Route::get('/test/{name}', function (
    string $name,
    TibiaService $tibiaService
) {

    //
    //    $x = Http::withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36')
    //        ->get('https://www.tibia.com/account/?subtopic=accountmanagement');
    //
    //    dd((string) $x->getBody());
    //    exit();

    //    $browser = new HttpBrowser(HttpClient::create());
    //    $x = $browser->request('POST', 'https://www.tibia.com/account/?subtopic=accountmanagement', [
    //        'loginemail' => 'r.mobis@gmail.com',
    //        'loginpassword' => 'BqA4z8gLd$C#Q#e',
    //    ]);

});

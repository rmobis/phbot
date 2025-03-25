<?php

use App\Tibia\Crawler;
use Illuminate\Support\Facades\Artisan;

Artisan::command('app:test', function (Crawler $crawler) {
    $crawler->login('r.mo.b.is@gmail.com', 'jpq0VTD*tzn-zhz!jgv');

    $fkers = ['Pudoka Pewpewpew', 'Rhadow', 'Sorc kann', 'Don Arte', 'Felktoxico', 'Homiizao', 'Junin semaxe', 'Lilly san', 'Paliteiro Etebra', 'Real Edaddy', 'Lex One'];
    foreach ($fkers as $fker) {
        $crawler->excludeCharacter('Exalted', $fker);
    }

    //        $token = TOTP::createFromSecret('KENUL4DRVIJ3L73U')->now();
    //        //        $crawler->login('r.mobis@gmail.com', 'BqA4z8gLd$C#Q#e', $token);
    //        $crawler->login('exaltedbanco@hotmail.com', 'Exaltedbank1234@@@', '476703');
    //
    //        $data = $crawler->getCoinHistoryUntil();
    //        Storage::write('bank-coinhistory.json', json_encode($data, JSON_PRETTY_PRINT));

    // $data = collect(Storage::json('bank-coinhistory.json'));
    //        $this->table(array_keys($data[0]), $data->reverse());

    // $data = $data->map(function (array $entry) {
    //     $id = intval($entry['#']);
    //     $normalizedDate = str_replace("\u{00A0}", '', $entry['Date']);
    //     $date = Carbon::createFromFormat('M d Y, H:i:s e', $normalizedDate);
    //     $description = $entry['Description'];
    //     $rawCharacter = $entry['Character'] ?: null;
    //     $balance = intval(str_replace(',', '', $entry['Balance']));
    //     $type = CoinHistoryEntryType::fromDescription($description);
    //
    //     return [
    //         'id' => $id,
    //         'date' => $date,
    //         'description' => $description,
    //         'rawCharacter' => $rawCharacter,
    //         'balance' => $balance,
    //         'type' => $type->value,
    //     ];
    // });
    // Storage::write('bank-coinhistory-treated.json', json_encode($data, JSON_PRETTY_PRINT));
    //
    // $data = $data->filter(fn ($entry) => $entry['type'] === CoinHistoryEntryType::Unknown->value);
    // $this->table(array_keys($data->first()), $data->reverse());

    return 0;
});

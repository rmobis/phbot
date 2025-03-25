<?php

namespace App\Models;

use App\Support\Enums\CoinHistoryEntryType;
use Illuminate\Database\Eloquent\Model;

class CoinHistory extends Model
{
    protected $casts = [
        'type' => CoinHistoryEntryType::class,
    ];

    //
}

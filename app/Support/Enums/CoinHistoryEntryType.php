<?php

namespace App\Support\Enums;

use App\Support\Traits\ArrayableEnum;

enum CoinHistoryEntryType: string
{
    use ArrayableEnum;

    case Transfer = 'transfer';
    case Unknown = 'unknown';
    // case Service = 'service';
    // case Store = 'store';
    // case Market = 'market';
    // case Bazaar = 'bazaar';
    // case Internal = 'internal';

    private const string CHAR_NAME_REGEX = '([ÄÖÜA-Z][ÄÖÜA-zäöü\-\'.]*(?: [ÄÖÜA-zäöü\-\'.]+){,5})';

    private const string RELAXED_CHAR_NAME_REGEX = '([ÄÖÜA-zäöü\-\'.]+(?: [ÄÖÜA-zäöü\-\'.]+){,5})';

    private const array TRANSFER_REGEXES = [
        self::CHAR_NAME_REGEX.' (gifted|transferr?ed) to '.self::RELAXED_CHAR_NAME_REGEX,
    ];

    // private const array SERVICE_REGEXES = [
    //     'XP Boost',
    //     '(30|90|180|360) days',
    //     '(5|20)x Prey Wildcard',
    //     '30x Instant Reward Access',
    //     '(Express )?(South America )?World Transfer',
    //
    //     'Gold Pouch',
    //     'Charm Expansion',
    //     'Permanent (Prey|Hunting Task) Slot',
    //     '(Name|Sex|Main Character) Change',
    //     'Temple Teleport',
    //
    //     // Deprecated
    //     'Prey Bonus Reroll',
    // ];
    //
    // private const array STORE_REGEXES = [
    //     // House Furniture
    //     '(Demon|Ferumbras|Monk) Exercise Dummy',
    //     '(Ornate )?Mailbox',
    //     '(Shiny )?Daily Reward Shrine',
    //     '(Gilded )?Imbuing Shrine',
    //     '(\d+)x (.* Carpet)',
    //
    //     // NPCs
    //     'Hireling Apprentice',
    //     'Cook',
    //     'Banker',
    //     'Trader',
    //     'Hireling Name Change',
    //
    //     // Consumables
    //     '(Magic )?Gold Converter',
    //     '(\d+)x (.+ Rune)',
    //     '((Strong|Great|Ultimate|Supreme) )?(Health|Mana|Spirit) (Cask|Keg)',
    //     '(\d+)x ((Strong|Great|Ultimate|Supreme) )?(Health|Mana|Spirit) Potion',
    //     '(Durable |Lasting )?Exercise (Axe|Club|Show|Bow|Wand|Rod|Shield)',
    // ];
    //
    // private const array MARKET_REGEXES = [
    //     'Transferred via the Market', // accepted buy offer
    //     'Purchased via the Market', // accepted sell offer
    //     'Sell Offer Placed in the Market', // placed sell offer
    //     'Sell Offer Cancelled or Expired', // cancelled/expired sell offer
    // ];

    // private const array BAZAAR_REGEXES = [
    //     'Auction Fee for Character Trade of '.self::CHAR_NAME_REGEX,
    //     '(Sale|Purchase) of Character '.self::CHAR_NAME_REGEX.'( \(delayed payment\))?',
    // ];
    //
    // private const array INTERNAL_REGEXES = [
    //     'Internal Transaction',
    //     'Transaction Refunded',
    //     'Account Recruiter Outfit',
    // ];

    public static function fromDescription(string $description): self
    {
        // if (self::anyRegexMatches(self::SERVICE_REGEXES, $description)) {
        //     return self::Service;
        // }
        //
        // if (self::anyRegexMatches(self::STORE_REGEXES, $description)) {
        //     return self::Store;
        // }
        //
        // if (self::anyRegexMatches(self::MARKET_REGEXES, $description)) {
        //     return self::Market;
        // }

        if (self::anyRegexMatches(self::TRANSFER_REGEXES, $description)) {
            return self::Transfer;
        }

        // if (self::anyRegexMatches(self::BAZAAR_REGEXES, $description)) {
        //     return self::Bazaar;
        // }
        //
        // if (self::anyRegexMatches(self::INTERNAL_REGEXES, $description)) {
        //     return self::Internal;
        // }

        return self::Unknown;
    }

    private static function anyRegexMatches(iterable $regexes, string $description): bool
    {
        return collect($regexes)
            ->some(static fn ($regex) => preg_match('/^'.$regex.'$/', $description));
    }
}

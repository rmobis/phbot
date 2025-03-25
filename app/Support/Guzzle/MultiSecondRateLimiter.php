<?php

namespace App\Support\Guzzle;

use Spatie\GuzzleRateLimiterMiddleware\Deferrer;
use Spatie\GuzzleRateLimiterMiddleware\RateLimiter;
use Spatie\GuzzleRateLimiterMiddleware\Store;

class MultiSecondRateLimiter extends RateLimiter
{
    public function __construct(int $limit, private readonly float $seconds, Store $store, Deferrer $deferrer)
    {
        parent::__construct($limit, self::TIME_FRAME_SECOND, $store, $deferrer);
    }

    protected function timeFrameLengthInMilliseconds(): int
    {
        return $this->seconds * parent::timeFrameLengthInMilliseconds();
    }
}

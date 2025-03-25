<?php

namespace App\Support\Guzzle;

use Spatie\GuzzleRateLimiterMiddleware\Deferrer;
use Spatie\GuzzleRateLimiterMiddleware\InMemoryStore;
use Spatie\GuzzleRateLimiterMiddleware\RateLimiterMiddleware as BaseRateLimiterMiddleware;
use Spatie\GuzzleRateLimiterMiddleware\SleepDeferrer;
use Spatie\GuzzleRateLimiterMiddleware\Store;

class RateLimiterMiddleware extends BaseRateLimiterMiddleware
{
    private function __construct(MultiSecondRateLimiter $rateLimiter)
    {
        $this->rateLimiter = $rateLimiter;
    }

    public static function perSeconds(int $limit, float $seconds, ?Store $store = null, ?Deferrer $deferrer = null): RateLimiterMiddleware
    {
        $rateLimiter = new MultiSecondRateLimiter(
            $limit,
            $seconds,
            $store ?? new InMemoryStore,
            $deferrer ?? new SleepDeferrer
        );

        return new static($rateLimiter);
    }
}

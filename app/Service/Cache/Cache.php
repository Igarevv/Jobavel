<?php

declare(strict_types=1);

namespace App\Service\Cache;

use Carbon\CarbonInterval;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Support\Facades\Cache as LaravelCache;

final class Cache
{
    public function __construct(private readonly CacheRepository $cache)
    {
    }

    public function getCacheKey(string $prefix, string|int|null $identifier = null): string
    {
        $configKey = config('cache.keys.'.$prefix);

        if ($configKey === null) {
            throw new \InvalidArgumentException('Cache key prefix must be defined in cache config in \'keys\' array');
        }

        return $identifier === null ? $configKey : sprintf($configKey, $identifier);
    }

    public static function forgetKey(string $prefix, string|int|null $identifier = null): void
    {
        if ($identifier === null) {
            LaravelCache::forget(config('cache.keys'.$prefix));
        } else {
            LaravelCache::forget(sprintf(config('cache.keys.'.$prefix), $identifier));
        }
    }

    public function repository(): CacheRepository
    {
        return $this->cache;
    }

    public function secondsInHour(): float
    {
        return CarbonInterval::hour()->totalSeconds;
    }

    public function secondsInMonth(): float
    {
        return CarbonInterval::month()->totalSeconds;
    }

    public function secondsInYear(): float
    {
        return CarbonInterval::year()->totalSeconds;
    }

    public function secondsInMonths(int $number): float
    {
        return CarbonInterval::months($number)->totalSeconds;
    }

    public function secondsInHours(int $number): float
    {
        return CarbonInterval::hours($number)->totalSeconds;
    }

    public function secondsInYears(int $number): float
    {
        return CarbonInterval::years($number)->totalSeconds;
    }

}
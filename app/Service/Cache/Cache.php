<?php

declare(strict_types=1);

namespace App\Service\Cache;

use Illuminate\Cache\TaggedCache;
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

    public function tags(mixed $names): TaggedCache
    {
        return LaravelCache::tags($names);
    }

    public function repository(): CacheRepository
    {
        return $this->cache;
    }

}
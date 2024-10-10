<?php

namespace Zappzerapp\LaravelDbVault\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Zappzerapp\LaravelDbVault\Models\VaultItem;

class DbVaultService
{
    private array $config;

    private const CACHE_PREFIX = 'db-vault';
    private const DEFAULT_CACHE_TTL = 3600;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function get(string $context, string $key): ?VaultItem
    {
        if (!Arr::get($this->config, 'cache_items.enabled')) {
            return $this->getByContextAndKey($context, $key);
        }

        return Cache::remember(
            $this->cacheKey($context, $key),
            Arr::get($this->config, 'cache_items.ttl', self::DEFAULT_CACHE_TTL),
            fn() => $this->getByContextAndKey($context, $key)
        );
    }

    public function getAll(string $context): Collection
    {
        if (!Arr::get($this->config, 'cache_items.enabled')) {
            return $this->getByContext($context);
        }

        return Cache::remember(
            $this->cacheKey($context),
            Arr::get($this->config, 'cache_items.ttl', self::DEFAULT_CACHE_TTL),
            fn() => $this->getByContext($context)
        );
    }

    public function set(string $context, string $key, mixed $value, bool $encrypted = false): VaultItem
    {
        return VaultItem::updateOrCreate([
            'context' => $context,
            'key' => $key,
            'encrypted' => $encrypted,
        ], [
            'value' => $value,
        ]);
    }

    public function clearCache(VaultItem $vaultItem): void
    {
        if (!Arr::get($this->config, 'cache_items.enabled')) {
            return;
        }

        Cache::forget($this->cacheKey($vaultItem->context));
        Cache::forget($this->cacheKey($vaultItem->context, $vaultItem->key));
    }

    public function cacheKey(string $context, ?string $key = null): string
    {
        return implode('.', array_filter([
            self::CACHE_PREFIX,
            $context,
            $key
        ]));
    }

    private function getByContextAndKey(string $context, string $key): ?VaultItem
    {
        return VaultItem::firstWhere([
            'context' => $context,
            'key' => $key,
        ]);
    }

    private function getByContext(string $context): Collection
    {
        return VaultItem::whereContext($context)->pluck('value', 'key');
    }
}

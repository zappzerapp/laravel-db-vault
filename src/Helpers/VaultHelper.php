<?php

use Zappzerapp\LaravelDbVault\Models\VaultItem;
use Zappzerapp\LaravelDbVault\Services\DbVaultService;

if (!function_exists('vault_service')) {
    function vault_service(): DbVaultService
    {
        return app(DbVaultService::class);
    }
}

if (!function_exists('vault')) {
    function vault(string $context, ?string $key = null, mixed $default = null): mixed
    {
        if (!$key) {
            return vault_service()->getAll($context) ?? $default;
        }

        $vaultItem = vault_service()->get($context, $key);

        return $vaultItem ? $vaultItem->value : $default;
    }
}

if (!function_exists('vault_set')) {
    function vault_set(string $context, string $key, mixed $value, bool $encrypted = false): VaultItem
    {
        return vault_service()->set($context, $key, $value, $encrypted);
    }
}

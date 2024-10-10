<?php

namespace Zappzerapp\LaravelDbVault;

use Illuminate\Support\ServiceProvider;
use Zappzerapp\LaravelDbVault\Services\DbVaultService;

class DbVaultServiceProvider extends ServiceProvider
{
    private const CONFIG_KEY = 'db-vault';

    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/db-vault.php', self::CONFIG_KEY);
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->app->singleton(DbVaultService::class, fn() => new DbVaultService(config(self::CONFIG_KEY)));
    }
}
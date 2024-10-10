<?php

namespace Tests\Zappzerapp\LaravelDbVault;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Zappzerapp\LaravelDbVault\DbVaultServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            DbVaultServiceProvider::class,
        ];
    }
}

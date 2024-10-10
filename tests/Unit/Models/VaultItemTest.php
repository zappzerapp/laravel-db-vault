<?php

namespace Tests\Zappzerapp\LaravelDbVault\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Zappzerapp\LaravelDbVault\Models\VaultItem;

uses(RefreshDatabase::class);

it('has a key column', function () {
    $vault = VaultItem::factory()->create(['key' => 'test']);

    expect($vault->key)->toBe('test');
});

it('has a context column', function () {
    $vault = VaultItem::factory()->create(['context' => 'test']);

    expect($vault->context)->toBe('test');
});

it('has a value column', function () {
    $vault = VaultItem::factory()->create(['value' => 'test']);

    expect($vault->value)->toBe('test');
});

it('has encrypted column', function () {
    $vault = VaultItem::factory()->create(['encrypted' => false]);
    $encryptedVault = VaultItem::factory()->create(['encrypted' => true]);

    expect($vault->encrypted)->toBe(false)
        ->and($encryptedVault->encrypted)->toBe(true);
});

it('updates the cache after saving', function () {
    $context = 'foo';
    $key = 'bar';
    $vault = VaultItem::factory()->create(compact('context', 'key'));
    vault($context, $key);

    expect(Cache::has(vault_service()->cacheKey($vault->context, $vault->key)))->toBeTrue();

    $vault->update(['value' => 'updated']);

    expect(Cache::has(vault_service()->cacheKey($vault->context, $vault->key)))->toBeFalse();
});


it('updates the context cache after saving', function () {
    $context = 'foo';
    $key = 'bar';
    $vault = VaultItem::factory()->create(compact('context', 'key'));
    vault($context);

    expect(Cache::has(vault_service()->cacheKey($vault->context)))->toBeTrue();

    $vault->update(['value' => 'updated']);

    expect(Cache::has(vault_service()->cacheKey($vault->context)))->toBeFalse();
});

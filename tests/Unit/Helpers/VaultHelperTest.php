<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Zappzerapp\LaravelDbVault\Models\VaultItem;

uses(RefreshDatabase::class);

it('returns the service', function () {
    expect(vault_service())->toBeInstanceOf(\Zappzerapp\LaravelDbVault\Services\DbVaultService::class);
});

it('returns a value', function () {
    $vault = VaultItem::factory()->create(['value' => 'test']);
    $value = vault($vault->context, $vault->key);

    expect($value)->toBe('test');
});

it('returns a default value', function () {
    $value = vault('invalid', 'key', 'test');

    expect($value)->toBe('test');
});

it('creates a vault item', function () {
    $context = 'foo';
    $key = 'bar';
    vault_set($context, $key, 'test');
    $vault = VaultItem::firstWhere(compact('context', 'key'));

    expect($vault->value)->toBe('test');
});

it('creates a encrypted vault item', function () {
    $context = 'foo';
    $key = 'bar';

    vault_set($context, $key, 'secret', true);

    $vault = VaultItem::firstWhere(compact('context', 'key'));
    $rawVault = VaultItem::where(compact('context', 'key'))->pluck('value');

    expect($vault->value)->toBe('secret')
        ->and($rawVault[0])->not->toBe('secret');
});

it('returns items by context', function () {
    $context = 'foo';
    vault_set($context, 'key1', 'test1');
    vault_set($context, 'key2', 'test2');

    $vaultItems = vault($context);

    expect($vaultItems)->toBeInstanceOf(\Illuminate\Support\Collection::class)
        ->and($vaultItems->toArray())->toBe([
            'key1' => 'test1',
            'key2' => 'test2',
        ]);
});
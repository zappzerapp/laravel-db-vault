<?php

namespace Zappzerapp\LaravelDbVault\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaultItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'context',
        'value',
        'encrypted',
    ];

    protected $primaryKey = 'key';
    protected $keyType = 'string';
    public $incrementing = false;

    public static function boot(): void
    {
        parent::boot();

        static::saved(fn(self $vaultItem) => vault_service()->clearCache($vaultItem));
    }

    protected function value(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->encrypted ? decrypt($value) : $value,
            set: fn($value) => $this->encrypted ? encrypt($value) : $value,
        );
    }
}
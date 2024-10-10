<?php

namespace Database\Factories\Zappzerapp\LaravelDbVault\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Zappzerapp\LaravelDbVault\Models\VaultItem;

class VaultItemFactory extends Factory
{
    protected $model = VaultItem::class;

    public function definition(): array
    {
        return [
            'key' => $this->faker->word(),
            'context' => $this->faker->word(),
            'value' => $this->faker->words(asText: true),
        ];
    }
}

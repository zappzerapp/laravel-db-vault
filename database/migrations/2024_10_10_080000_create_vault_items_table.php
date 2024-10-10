<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vault_items', function (Blueprint $table) {
            $table->string('key');
            $table->string('context')->nullable();
            $table->string('value');
            $table->boolean('encrypted')->default(false);
            $table->timestamps();

            $table->primary(['key', 'context']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vault_items');
    }
};

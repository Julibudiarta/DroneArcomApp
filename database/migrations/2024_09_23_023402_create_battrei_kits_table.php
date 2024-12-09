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
        Schema::create('battrei_kits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kits_id')->constrained('kits')->cascadeOnDelete();
            $table->foreignId('battrei_id')->constrained('battreis')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('battrei_kits');
    }
};

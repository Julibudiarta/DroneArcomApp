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
        Schema::table('planned_missions', function (Blueprint $table) {
            $table->string('status')->nullable()->default(null)->after('fuel_used');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('planned_missions', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};

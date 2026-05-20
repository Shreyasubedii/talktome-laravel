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
            Schema::table('day_logs', function (Blueprint $table) {
        $table->tinyInteger('mood_score')->nullable();
        $table->string('mood_label')->nullable();
        $table->string('emotion')->nullable();
        $table->string('impact_area')->nullable();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
                        Schema::table('day_logs', function (Blueprint $table) {
        $table->dropColumn([
            'mood_score',
            'mood_label',
            'emotion',
            'impact_area'
        ]);
    });


    }
};
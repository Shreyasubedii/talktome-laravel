<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedule', function (Blueprint $table) {
            if (!Schema::hasColumn('schedule', 'start_time')) {
                $table->time('start_time')->nullable()->after('scheduletime');
            }
            if (!Schema::hasColumn('schedule', 'end_time')) {
                $table->time('end_time')->nullable()->after('start_time');
            }
            if (!Schema::hasColumn('schedule', 'status')) {
                $table->string('status')->default('available')->after('end_time');
            }
            if (!Schema::hasColumn('schedule', 'remaining_capacity')) {
                $table->integer('remaining_capacity')->default(0)->after('status');
            }
            if (!Schema::hasColumn('schedule', 'is_full')) {
                $table->boolean('is_full')->default(false)->after('remaining_capacity');
            }
        });
    }

    public function down(): void
    {
        Schema::table('schedule', function (Blueprint $table) {
            $table->dropColumn(['start_time', 'end_time', 'status', 'remaining_capacity', 'is_full']);
        });
    }
};

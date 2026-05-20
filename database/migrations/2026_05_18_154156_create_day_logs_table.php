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
        Schema::create('day_logs', function (Blueprint $table) {
    $table->id();

    $table->unsignedBigInteger('patient_id');

    $table->string('mood')->nullable();

    $table->text('notes')->nullable();

    $table->date('log_date');

    $table->timestamps();

    $table->foreign('patient_id')
          ->references('pid')
          ->on('patient')
          ->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('day_logs');
    }
};
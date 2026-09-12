<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('appointment_id')->unique();
            $table->integer('patient_id');
            $table->string('payment_method', 20);
            $table->string('payment_status', 20);
            $table->decimal('amount', 10, 2);
            $table->string('esewa_transaction_id')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->timestamps();
            $table->index('patient_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
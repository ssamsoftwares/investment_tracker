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
        Schema::create('call_trades', function (Blueprint $table) {
            $table->id();
            $table->string('trade_name',255);
            $table->float('amount');
            $table->text('customer_ids');
            $table->float('commission');
            $table->enum('status',['paid','unpaid'])->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('call_trades');
    }
};

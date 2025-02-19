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
        Schema::create('order_trackings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("order_id");
            $table->string("carrier");
            $table->string("contact");
            $table->string("status");
            $table->text("remarks")->nullable();
            $table->date("expected_delivery_date");
            $table->time("expected_delivery_time");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_trackings');
    }
};

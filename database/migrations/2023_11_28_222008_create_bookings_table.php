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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer("numero_personas");
            $table->date("fecha_llegada");
            $table->integer("cantidad_noche");
            $table->integer("valor_reserva");
            $table->string("estado_reserva", 45)->default('provisional');
            $table->unsignedBigInteger("hotels_id");
            $table->unsignedBigInteger("clients_id");
            $table->foreign('hotels_id')->references('id')->on("hotels");
            $table->foreign('clients_id')->references('id')->on("clients");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

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
        //turnos
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('placa')->nullable();
            $table->bigInteger('state_id')->nullable()->unsigned();
            $table->bigInteger('setresidencial_id')->nullable()->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};

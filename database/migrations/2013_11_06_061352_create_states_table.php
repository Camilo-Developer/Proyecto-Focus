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
        //tabla de estados
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('Nombre del estado');
            $table->enum('type_state',[1,2])->nullable()->comment('Tipo del estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};

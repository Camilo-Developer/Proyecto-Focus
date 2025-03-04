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
        //Porterias
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->bigInteger('state_id')->nullable()->unsigned();
            $table->bigInteger('setresidencial_id')->nullable()->unsigned();//Conjunto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};

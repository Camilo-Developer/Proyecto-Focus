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
        //torerres
        Schema::create('agglomerations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('type_agglomeration')->nullable();
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
        Schema::dropIfExists('agglomerations');
    }
};

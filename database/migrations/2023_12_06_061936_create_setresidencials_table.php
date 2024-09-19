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
        //Conjunto
        Schema::create('setresidencials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('imagen');
            $table->string('address');
            $table->string('nit')->nullable()->unique();

            $table->bigInteger('state_id')->nullable()->unsigned();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setresidencials');
    }
};

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
        //ingreso de elemntos
        Schema::create('elemententries', function (Blueprint $table) {
            $table->id();
            $table->date('admission_date');
            $table->date('departure_date');
            $table->string('note');
            $table->bigInteger('element_id')->nullable()->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elemententries');
    }
};

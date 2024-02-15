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
        //ingreso de visitantes
        Schema::create('visitorentries', function (Blueprint $table) {
            $table->id();
            $table->date('admission_date')->nullable();
            $table->date('departure_date')->nullable();
            $table->string('visit_type')->nullable();
            $table->longText('note')->nullable();
            $table->bigInteger('unit_id')->nullable()->unsigned();//apartamentos
            $table->bigInteger('state_id')->nullable()->unsigned();//estados
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitorentries');
    }
};

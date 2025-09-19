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
        Schema::create('employeeincomes_has_vehicles_has_visitors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employeeincome_id')->nullable();
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->unsignedBigInteger('visitor_id')->nullable();

            // Foreign keys con nombres cortos
            $table->foreign('employeeincome_id', 'fk_empinc')
                  ->references('id')->on('employeeincomes')
                  ->onUpdate('cascade');

            $table->foreign('vehicle_id', 'fk_vehicle')
                  ->references('id')->on('vehicles')
                  ->onUpdate('cascade');

            $table->foreign('visitor_id', 'fk_visitor')
                  ->references('id')->on('visitors')
                  ->onUpdate('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employeeincomes_has_vehicles_has_visitors', function (Blueprint $table) {
            // Eliminar primero las foreign keys con sus nombres
            $table->dropForeign('fk_empinc');
            $table->dropForeign('fk_vehicle');
            $table->dropForeign('fk_visitor');
        });

        Schema::dropIfExists('employeeincomes_has_vehicles_has_visitors');
    }
};

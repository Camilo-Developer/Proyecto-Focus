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
        Schema::create('exit_entries_has_vehicles_has_visitors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exit_entry_id')->nullable();
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->unsignedBigInteger('visitor_id')->nullable();

            // Foreign keys con nombres cortos
            $table->foreign('exit_entry_id', 'fk_exit_entry')
                  ->references('id')->on('exit_entries')
                  ->onUpdate('cascade');

            $table->foreign('vehicle_id', 'fk_exit_vehicle')
                  ->references('id')->on('vehicles')
                  ->onUpdate('cascade');

            $table->foreign('visitor_id', 'fk_exit_visitor')
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
        Schema::table('exit_entries_has_vehicles_has_visitors', function (Blueprint $table) {
            // Eliminar primero las foreign keys con los nombres definidos
            $table->dropForeign('fk_exit_entry');
            $table->dropForeign('fk_exit_vehicle');
            $table->dropForeign('fk_exit_visitor');
        });

        Schema::dropIfExists('exit_entries_has_vehicles_has_visitors');
    }
};

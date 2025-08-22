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
        Schema::table('exit_entries', function (Blueprint $table) {
            $table->enum('type_income',[1,2])->nullable()->after('id');
            $table->unsignedBigInteger('employeeincomevehicle_id')->nullable()->after('employeeincome_id');
            $table->unsignedBigInteger('visitor_id')->nullable()->after('employeeincomevehicle_id');
            $table->unsignedBigInteger('vehicle_id')->nullable()->after('visitor_id');

            $table->foreign('employeeincomevehicle_id')->references('id')->on('employeeincomes')->onDelete('cascade');
            $table->foreign('visitor_id')->references('id')->on('visitors')->onDelete('cascade');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

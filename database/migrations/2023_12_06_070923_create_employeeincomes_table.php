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
        //ingreso de empleados
        Schema::create('employeeincomes', function (Blueprint $table) {
            $table->id();
            $table->enum('type_income',[1,2])->nullable();
            $table->dateTime('admission_date')->nullable();
            $table->longText('nota')->nullable();
            $table->bigInteger('visitor_id')->nullable()->unsigned();
            $table->bigInteger('setresidencial_id')->nullable()->unsigned();
            $table->bigInteger('agglomeration_id')->nullable()->unsigned();
            $table->bigInteger('unit_id')->nullable()->unsigned();
            $table->bigInteger('goal_id')->nullable()->unsigned();
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->bigInteger('vehicle_id')->nullable()->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employeeincomes');
    }
};

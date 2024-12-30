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
        Schema::table('users', function ($table){
            $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade');
        });

        Schema::table('setresidencials', function ($table){
            $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade');
        });

        Schema::table('agglomerations', function ($table){
            $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade');
            $table->foreign('setresidencial_id')->references('id')->on('setresidencials')->onUpdate('cascade');
        });

        Schema::table('units', function ($table){
            $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade');
            $table->foreign('agglomeration_id')->references('id')->on('agglomerations')->onUpdate('cascade');
        });

        Schema::table('goals', function ($table){
            $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade');
            $table->foreign('setresidencial_id')->references('id')->on('setresidencials')->onUpdate('cascade');
        });

        Schema::table('visitors', function ($table){
            $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade');
            $table->foreign('type_user_id')->references('id')->on('type_users')->onUpdate('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onUpdate('cascade');
        });


        Schema::table('employeeincomes', function ($table){
            $table->foreign('visitor_id')->references('id')->on('visitors')->onUpdate('cascade');
        });

        Schema::table('vehicles', function ($table){
            $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade');
            $table->foreign('visitor_id')->references('id')->on('visitors')->onUpdate('cascade');
        });

        Schema::table('user_has_goal', function ($table){
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('goal_id')->references('id')->on('goals')->onUpdate('cascade');
        });

        Schema::table('element_has_employeeincome', function ($table){
            $table->foreign('element_id')->references('id')->on('elements')->onUpdate('cascade');
            $table->foreign('employeeincome_id')->references('id')->on('employeeincomes')->onUpdate('cascade');
        });

        Schema::table('unit_has_vehicle', function ($table){
            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('cascade');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onUpdate('cascade');
        });

        Schema::table('visitor_has_unit', function ($table){
            $table->foreign('visitor_id')->references('id')->on('visitors')->onUpdate('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('cascade');
        });

        Schema::table('setresidencials_has_users', function ($table){
            $table->foreign('setresidencial_id')->references('id')->on('setresidencials')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relationships');
    }
};

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

        Schema::table('visitorentries', function ($table){
            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade');
        });

        Schema::table('contractors', function ($table){
            $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade');
            $table->foreign('setresidencial_id')->references('id')->on('setresidencials')->onUpdate('cascade');
        });

        Schema::table('contractoremployees', function ($table){
            $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade');
            $table->foreign('contractor_id')->references('id')->on('contractors')->onUpdate('cascade');
        });

        Schema::table('vehicles', function ($table){
            $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade');
        });

        Schema::table('elements', function ($table){
            $table->foreign('contractoremployee_id')->references('id')->on('contractoremployees')->onUpdate('cascade');
        });

        Schema::table('elemententries', function ($table){
            $table->foreign('element_id')->references('id')->on('elements')->onUpdate('cascade');
        });

        Schema::table('employeeincomes', function ($table){
            $table->foreign('contractoremployee_id')->references('id')->on('contractoremployees')->onUpdate('cascade');
        });

        Schema::table('shifts', function ($table){
            $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade');
            $table->foreign('setresidencial_id')->references('id')->on('setresidencials')->onUpdate('cascade');
        });

        Schema::table('unit_has_user', function ($table){
            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
        });

        Schema::table('visitorentry_has_visitor', function ($table){
            $table->foreign('visitorentry_id')->references('id')->on('visitorentries')->onUpdate('cascade');
            $table->foreign('visitor_id')->references('id')->on('visitors')->onUpdate('cascade');
        });

        Schema::table('unit_has_vehicle', function ($table){
            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('cascade');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onUpdate('cascade');
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

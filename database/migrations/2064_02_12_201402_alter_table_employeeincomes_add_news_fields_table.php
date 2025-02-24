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
        Schema::table('employeeincomes', function (Blueprint $table){
            if (!Schema::hasColumn('employeeincomes', 'unit_id')) {

                $table->bigInteger('unit_id')->nullable()->after('user_id')->unsigned();
                $table->bigInteger('agglomeration_id')->nullable()->after('unit_id')->unsigned();
                $table->bigInteger('goal2_id')->nullable()->after('agglomeration_id')->unsigned();

                $table->foreign('unit_id')->references('id')->on('units')->onUpdate('cascade');
                $table->foreign('agglomeration_id')->references('id')->on('agglomerations')->onUpdate('cascade');
                $table->foreign('goal2_id')->references('id')->on('goals')->onUpdate('cascade');

            }
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

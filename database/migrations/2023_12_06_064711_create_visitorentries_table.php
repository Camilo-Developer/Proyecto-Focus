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
        Schema::create('visitorentries', function (Blueprint $table) {
            $table->id();
            $table->date('admission_date');
            $table->date('departure_date');
            $table->string('visit_type');
            $table->string('note');
            $table->bigInteger('unit_id')->nullable()->unsigned();
            $table->bigInteger('state_id')->nullable()->unsigned();
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

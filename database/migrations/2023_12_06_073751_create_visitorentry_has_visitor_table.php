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
        Schema::create('visitorentry_has_visitor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visitorentry_id')->nullable();
            $table->unsignedBigInteger('visitor_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitorentry_has_visitor');
    }
};

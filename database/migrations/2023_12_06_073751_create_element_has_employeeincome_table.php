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
        Schema::create('element_has_employeeincome', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('element_id')->nullable();
            $table->unsignedBigInteger('employeeincome_id')->nullable();
            $table->string('imagen')->nullable();
            $table->longText('nota')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('element_has_employeeincome');
    }
};

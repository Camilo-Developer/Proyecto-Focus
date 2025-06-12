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
        Schema::create('exit_entry_has_element', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exit_entry_id')->nullable();
            $table->unsignedBigInteger('element_id')->nullable();
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
        Schema::dropIfExists('exit_entry_has_element');
    }
};

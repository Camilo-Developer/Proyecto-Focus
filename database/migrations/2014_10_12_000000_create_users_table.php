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
        //residentes
        Schema::create('users', function (Blueprint $table) {
            #$table->string('name')->comment('Nombre del estado');
            $table->id();
            $table->string('name')->comment('');
            $table->string('lastname')->comment('');
            $table->string('type_document')->comment('');
            $table->string('document_number')->comment('');
            $table->string('email')->unique()->comment('');
            $table->string('password')->comment('');
            $table->string('note')->nullable()->comment('');

            $table->bigInteger('state_id')->nullable()->unsigned();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

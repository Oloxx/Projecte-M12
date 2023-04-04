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
        Schema::create('empreses', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->integer('telefon');
            $table->string('web');
            $table->string('email');

            $table->unsignedBigInteger('poblacio_id');
            $table->foreign('poblacio_id')->references('id')->on('poblacions');

            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categories');

            $table->unsignedBigInteger('sector_id')->nullable();
            $table->foreign('sector_id')->references('id')->on('sectors');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empreses');
    }
};

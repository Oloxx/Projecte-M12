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
        Schema::create('poblacions', function (Blueprint $table) {
            $table->id();
            $table->string('nom');

            $table->unsignedBigInteger('comarca_id');
            $table->foreign('comarca_id')->references('id')->on('comarcas');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poblacions');
    }
};

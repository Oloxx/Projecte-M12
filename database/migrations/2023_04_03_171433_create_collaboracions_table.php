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
        Schema::create('collaboracions', function (Blueprint $table) {
            $table->id();

            $table->year('any');

            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empreses')->onDelete('cascade');

            $table->unsignedBigInteger('contacte_id');
            $table->foreign('contacte_id')->references('id')->on('contactes')->onDelete('cascade');;

            $table->unsignedBigInteger('cicle_id');
            $table->foreign('cicle_id')->references('id')->on('cicles');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->longText('comentaris')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collaboracions');
    }
};

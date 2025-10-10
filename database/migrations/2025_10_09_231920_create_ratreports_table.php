<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratreports', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->unsignedMediumInteger('idUser');
            $table->unsignedMediumInteger('idRat');
            $table->unsignedMediumInteger('reviewedBy')->nullable();
            $table->string('comment', 500)->nullable();
            $table->tinyInteger('resolved')->default(1)->comment('0 Yes / 1 No');
            $table->unsignedTinyInteger('status')->default(1)->comment('0 inactive / 1 good / 2 sick / 3 lost');
            $table->timestamps();

            $table->foreign('idUser')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('no action')
                  ->onDelete('no action');

            $table->foreign('idRat')
                  ->references('id')
                  ->on('rats')
                  ->onUpdate('no action')
                  ->onDelete('no action');

            $table->foreign('reviewedBy')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('no action')
                  ->onDelete('no action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratreports');
    }
};

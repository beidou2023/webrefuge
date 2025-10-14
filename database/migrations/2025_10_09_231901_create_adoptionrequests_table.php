<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adoptionrequests', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->unsignedMediumInteger('idUser');
            $table->unsignedMediumInteger('idSpecialRat')->nullable();
            $table->string('imgUrl', 255);
            $table->string('reason', 100);
            $table->string('experience', 500);
            $table->unsignedSmallInteger('quantityExpected')->default(0);
            $table->tinyInteger('couple')->comment('1 Yes / 2 No')->default(2);
            $table->unsignedMediumInteger('aprovedBy')->nullable();
            $table->string('contactTravel', 255)->nullable();
            $table->string('contactReturn', 255)->nullable();
            $table->tinyInteger('noReturn')->comment('1 Yes / 2 No');
            $table->tinyInteger('care')->comment('1 Yes / 2 No');
            $table->tinyInteger('followUp')->comment('1 Yes / 2 No');
            $table->tinyInteger('hasPets')->comment('1 Yes / 2 No');
            $table->string('petsInfo', 500)->nullable();
            $table->tinyInteger('canPayVet')->comment('1 Yes / 2 No');
            $table->unsignedTinyInteger('status')->default(2)->comment('0 rejected / 1 accepted / 2 pending');
            $table->timestamps();

            $table->foreign('idUser')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('no action')
                  ->onDelete('no action');

            $table->foreign('aprovedBy')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('no action')
                  ->onDelete('no action');

            $table->foreign('idSpecialRat')
                ->references('id')
                ->on('specialrats') 
                ->onUpdate('no action')
                ->onDelete('no action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adoptionrequests');
    }
};

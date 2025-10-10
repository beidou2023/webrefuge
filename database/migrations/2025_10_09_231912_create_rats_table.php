<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rats', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->unsignedMediumInteger('idAdoptiondelivery')->nullable();
            $table->unsignedMediumInteger('idUser')->nullable();
            $table->string('name', 45)->nullable();
            $table->string('color', 45)->nullable();
            $table->char('sex', 1)->nullable();
            $table->tinyInteger('ageMonths')->nullable();
            $table->unsignedTinyInteger('type')->default(1)->comment('1 normal / 2 special');
            $table->timestamp('adoptedAt')->nullable();
            $table->unsignedTinyInteger('status')->default(1)->comment('0 inactive / 1 active');
            $table->timestamps(); 
            $table->unsignedMediumInteger('idSpecialrat')->nullable();

            $table->foreign('idAdoptiondelivery')
                  ->references('id')
                  ->on('adoptiondeliveries')
                  ->onUpdate('no action')
                  ->onDelete('no action');

            $table->foreign('idUser')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('no action')
                  ->onDelete('no action');

            $table->foreign('idSpecialrat')
                  ->references('id')
                  ->on('specialrats')
                  ->onUpdate('no action')
                  ->onDelete('no action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rats');
    }
};

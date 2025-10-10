<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('specialrats', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->unsignedMediumInteger('idRefuge');
            $table->string('name', 45);
            $table->string('description', 500);
            $table->char('sex', 1);
            $table->string('imgUrl', 255);
            $table->unsignedTinyInteger('status')->default(1)->comment('0 inactive / 1 active / 2 adopted');
            $table->timestamps(); 

            $table->foreign('idRefuge')
                  ->references('id')
                  ->on('refuges')
                  ->onUpdate('no action')
                  ->onDelete('no action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('specialrats');
    }
};

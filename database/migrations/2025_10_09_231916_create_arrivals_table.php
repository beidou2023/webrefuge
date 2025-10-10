<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arrivals', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->smallInteger('maleCount')->nullable()->default(0);
            $table->smallInteger('femaleCount')->nullable()->default(0);
            $table->string('origin', 45);
            $table->string('notes', 500)->nullable();
            $table->unsignedMediumInteger('idRefuge');
            $table->unsignedTinyInteger('status')->default(1)->comment('0 inactive / 1 active');
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
        Schema::dropIfExists('arrivals');
    }
};

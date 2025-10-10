<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adoptiondeliveries', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->unsignedMediumInteger('deliveredBy');
            $table->unsignedMediumInteger('idAdoptionrequest');
            $table->tinyInteger('maleCount')->default(0);
            $table->tinyInteger('femaleCount')->default(0);
            $table->unsignedTinyInteger('status')->default(1)->comment('0 inactive / 1 active');
            $table->timestamps();


            $table->foreign('deliveredBy')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('no action')
                  ->onDelete('no action');

            $table->foreign('idAdoptionrequest')
                  ->references('id')
                  ->on('adoptionrequests')
                  ->onUpdate('no action')
                  ->onDelete('no action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adoptiondeliveries');
    }
};

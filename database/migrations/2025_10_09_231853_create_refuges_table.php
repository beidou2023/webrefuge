<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('refuges', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->unsignedMediumInteger('idManager');
            $table->string('name', 45);
            $table->string('address', 500);
            $table->smallInteger('maleCount');
            $table->smallInteger('femaleCount');
            $table->unsignedTinyInteger('status')->default(1)->comment('0 inactive\n1 active');
            $table->timestamps();

            $table->foreign('idManager')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('no action')
                  ->onDelete('no action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refuges');
    }
};

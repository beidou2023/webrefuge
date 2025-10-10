<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('firstName', 45);
            $table->string('lastName', 45);
            $table->string('email', 80);
            $table->char('password', 60);
            $table->string('phone', 20);
            $table->string('address', 500);
            $table->tinyInteger('role')->default(1)->comment('1 user / 2 manager / 3 admin');
            $table->unsignedTinyInteger('status')->default(2)->comment('0 inactive / 1 active / 2 pending / 3 banned');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumInteger('performedBy');
            $table->string('tableName', 45);
            $table->char('crud', 1)->comment('C create / U update / D delete');
            $table->string('detail', 500);
            $table->timestamp('created_at')->useCurrent();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};

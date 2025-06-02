<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('farewell_messages', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->boolean('is_active')->default(true);
            $table->integer('usage_count')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('farewell_messages');
    }
};
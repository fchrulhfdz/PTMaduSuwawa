<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_galleries_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['photo', 'video']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path'); // Untuk menyimpan path file
            $table->string('thumbnail_path')->nullable(); // Untuk video thumbnail
            $table->integer('order')->default(0); // Untuk mengurutkan tampilan
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('galleries');
    }
};
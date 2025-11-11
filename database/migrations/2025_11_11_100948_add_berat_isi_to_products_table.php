<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('berat_isi')->nullable()->after('stock');
            $table->string('satuan_berat')->default('gram')->after('berat_isi');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['berat_isi', 'satuan_berat']);
        });
    }
};
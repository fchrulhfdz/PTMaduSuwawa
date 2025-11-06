<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('profit_calculations', function (Blueprint $table) {
            $table->text('description')->nullable()->after('calculation_details');
        });
    }

    public function down()
    {
        Schema::table('profit_calculations', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
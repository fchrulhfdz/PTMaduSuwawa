<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuantityToTransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('quantity')->default(0)->after('customer_name');
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('quantity');
        });
    }
}
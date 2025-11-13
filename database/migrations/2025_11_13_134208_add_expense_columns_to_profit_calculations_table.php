<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('profit_calculations', function (Blueprint $table) {
            $table->string('type')->default('profit_calculation')->after('id');
            $table->date('expense_date')->nullable()->after('type');
            $table->decimal('expense_amount', 15, 2)->default(0)->after('expense_date');
            $table->text('expense_description')->nullable()->after('expense_amount');
        });
    }

    public function down()
    {
        Schema::table('profit_calculations', function (Blueprint $table) {
            $table->dropColumn(['type', 'expense_date', 'expense_amount', 'expense_description']);
        });
    }
};
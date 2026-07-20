<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delegates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->integer('account_number')->default(0);
            $table->integer('city_id')->nullable();
            $table->integer('start_balance');
            $table->tinyInteger('start_balance_status');
            $table->integer('current_balance');
            $table->integer('delegate_code');
            $table->boolean('commission_type'); // عموله ثابته او عموله بنسبه على الفاتوره
            $table->decimal('percent_Wholesale_commission'); // عموله على الحاجات الجمله
            $table->decimal('percent_half_wholesale_commission'); // عموله على الحاجات النص الجمله
            $table->decimal('percent_retail_commission'); // عموله على الحاجات الفطاعى
            $table->decimal('percent_collect_commission'); // عموله على التحصيل
            $table->integer('added_by');
            $table->integer('updated_by')->nullable();
            $table->date('date');
            $table->boolean('active')->default(1);
            $table->integer('com_code');
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delegates');
    }
};
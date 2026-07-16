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
        Schema::create('sales_bills_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_auto_serial');
            $table->tinyInteger('order_type');
            $table->integer('com_code');
            $table->decimal('quantity', 10, 2);
            $table->boolean('isparentunit');
            $table->integer('unit_id');
            $table->integer('unit_price');
            $table->integer('total_price');
            $table->date('invoice_date');
            $table->date('end_date')->nullable();
            $table->date('production_date')->nullable();
            $table->integer('added_by');
            $table->integer('updated_by')->nullable();
            $table->integer('item_code');
            $table->tinyInteger('item_card_type');
            $table->integer('batch_id')->nullable();
            $table->integer('sale_type')->nullable();
            $table->tinyInteger('normal_sale')->nullable(); // بيع عادى او بونص بدون سعر او دعايه بدون سعر
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
        Schema::dropIfExists('sales_bills_details');
    }
};
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
        Schema::create('suppliers_orders_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_auto_serial');
            $table->tinyInteger('order_type');
            $table->integer('com_code');
            $table->decimal('delivered_quantity', 10, 2);
            $table->boolean('main_or_retail_unit');
            $table->integer('unit_id');
            $table->integer('unit_price');
            $table->integer('total_price');
            $table->date('order_date');
            $table->integer('added_by');
            $table->integer('updated_by');
            $table->integer('item_code');
            $table->integer('batch_id');
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
        Schema::dropIfExists('suppliers_orders_details');
    }
};
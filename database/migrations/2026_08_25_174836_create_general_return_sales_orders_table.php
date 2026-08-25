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
        Schema::create('general_return_sales_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('auto_serial');
            $table->boolean('return_type')->nullable();
            $table->integer('customer_code');
            $table->integer('delegate_code');
            $table->integer('delegate_auto_invoice')->default(0);
            $table->integer('account_number')->nullable();
            $table->integer('sales_material_type_id');
            $table->date('invoice_date');
            $table->boolean('is_approved')->default(0);
            $table->integer('com_code');
            $table->integer('total_before_discount')->default(0);
            $table->integer('discount_percent')->default(0);
            $table->integer('discount_value')->default(0);
            $table->integer('tax_percent')->default(0);
            $table->integer('tax_value')->default(0);
            $table->integer('total_cost')->default(0);
            $table->integer('money_for_account')->default(0);
            $table->boolean('bill_type')->nullable();
            $table->integer('what_paid')->default(0);
            $table->integer('what_remain')->default(0);
            $table->integer('treasuries_transaction_id')->nullable();
            $table->integer('customer_balance_before_bill')->nullable();
            $table->integer('customer_balance_after_bill')->nullable();
            $table->string('notes')->nullable();
            $table->integer('added_by');
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('general_return_sales_orders');
    }
};
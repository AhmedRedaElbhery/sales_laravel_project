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
        Schema::create('sales_bills', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('auto_serial');
            $table->string('doc_number')->nullable();
            $table->integer('customer_code');
            $table->integer('delegate_code');
            $table->integer('delegate_auto_invoice')->default(0); //عدد الفواتير للمندوب باليوم
            $table->integer('account_number')->nullable();
            $table->integer('sales_material_type_id');
            $table->date('invoice_date');
            $table->boolean('is_approved')->default(0);
            $table->integer('com_code');
            $table->integer('total_before_discount')->default(0);
            $table->integer('discount_percent')->default(0); //نسبه الخصم 15%
            $table->integer('discount_value')->default(0); //قيمه الخصم
            $table->integer('tax_percent')->default(0);
            $table->integer('tax_value')->default(0);
            $table->integer('total_cost')->default(0);
            $table->integer('money_for_account')->default(0); //الفلوس الى هتدخل او تخرج من حساب العميل
            $table->boolean('pill_type')->nullable(); //نوع الفاتوره كاش او ااجل
            $table->integer('what_paid')->default(0); //اى الفيمه الى اتدفعت وقت الفاتوره
            $table->integer('what_remain')->default(0); //لو دفعت جزء ومتبقى جزء يبقى كم المتبقى
            $table->integer('treasuries_transaction_id')->nullable();
            $table->integer('customer_balance_before_pill')->nullable();
            $table->integer('customer_balance_after_pill')->nullable();
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
        Schema::dropIfExists('sales_bills');
    }
};
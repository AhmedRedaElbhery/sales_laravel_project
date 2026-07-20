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
        Schema::create('suppliers_orders', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('order_type'); //فاتوره شراء او مرتجع من الفاتوره او مرتجع عام
            $table->bigInteger('auto_serial');
            $table->string('doc_number')->nullable();
            $table->integer('supplier_code');
            $table->integer('account_number');
            $table->date('order_date');
            $table->boolean('is_approved')->default(0);
            $table->integer('com_code');
            $table->integer('total_before_discount')->default(0);
            $table->boolean('discount_type')->nullable(); // خصم قيمه او خصم يدوى
            $table->decimal('discount_percent')->default(0); //نسبه الخصم 15%
            $table->integer('discount_value')->default(0); //قيمه الخصم من الاجمالى الرقم الفعلى للخصم
            $table->decimal('tax_percent')->default(0);
            $table->integer('tax_value')->default(0);
            $table->integer('total_cost')->default(0);
            $table->integer('money_for_account')->default(0); //الفلوس الى للمورد او فلوس الشراء بتاع الفاتوره لكل حساب مورد
            $table->boolean('pill_type'); //نوع الفاتوره كاش او ااجل
            $table->integer('what_paid')->default(0); //اى الفيمه الى اتدفعت وقت الفاتوره
            $table->integer('what_remain')->default(0); //لو دفعت جزء ومتبقى جزء يبقى كم المتبقى
            $table->integer('treasuries_transaction_id')->nullable();
            $table->integer('supplier_balance_before_pill')->nullable();
            $table->integer('supplier_balance_after_pill')->nullable();
            $table->string('notes')->nullable();
            $table->integer('added_by');
            $table->integer('store_id');
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
        Schema::dropIfExists('suppliers_orders');
    }
};
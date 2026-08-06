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
        Schema::create('invoices_pdf', function (Blueprint $table) {
            $table->id();

            $table->integer('company_code');
            $table->integer('account_number');
            $table->integer('invoice_auto_serial');
            $table->integer('sub_total');
            $table->integer('tax_rate');
            $table->integer('discount_rate');
            $table->integer('final_total');
            $table->integer('paid');
            $table->integer('remaining');
            $table->string('notes');

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
        Schema::dropIfExists('invoices_pdf');
    }
};
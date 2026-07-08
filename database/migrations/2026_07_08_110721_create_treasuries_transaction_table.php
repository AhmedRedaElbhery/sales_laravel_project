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
        Schema::create('treasuries_transaction', function (Blueprint $table) {
            $table->id();
            $table->integer('treasuries_id');
            $table->integer('move_type');
            $table->bigInteger('bill_code')->nullable();
            $table->bigInteger('account_number')->nullable();
            $table->boolean('from_account')->nullable();
            $table->boolean('is_approved')->default(1);
            $table->bigInteger('shift_id')->nullable();
            $table->integer('money_for_account'); //قيمه المبلغ المستحق للحساب او عليه
            $table->integer('money'); //قيمه المبلغ المصروف او المحصل بالخزنه
            $table->string('byan');
            $table->integer('added_by');
            $table->integer('updated_by');
            $table->date('date');
            $table->integer('com_code');
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
        Schema::dropIfExists('treasuries_transaction');
    }
};
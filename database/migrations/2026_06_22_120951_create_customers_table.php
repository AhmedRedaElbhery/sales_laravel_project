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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->integer('account_number')->default(0);
            $table->integer('start_balance');
            $table->tinyInteger('start_balance_status');
            $table->integer('current_balance');
            $table->integer('city_id')->nullable();
            $table->integer('customer_code');
            $table->integer('added_by');
            $table->integer('updated_by')->nullable();
            $table->date('date');
            $table->boolean('active')->default(0);
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
        Schema::dropIfExists('customers');
    }
};
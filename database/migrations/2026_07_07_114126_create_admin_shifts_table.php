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
        Schema::create('admin_shifts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('admin_id');
            $table->bigInteger('treasuries_id');
            $table->integer('treasuries_start_balance')->default(0);
            $table->integer('treasuries_end_balance')->default(0);
            $table->dateTime('start_shift')->nullable();
            $table->dateTime('end_shift')->nullable();
            $table->boolean('is_finished')->default(0); // تم الانتهاء من الشفت
            $table->boolean('is_delivered')->default(0); // تم التسليم والمراجعه
            $table->integer('delivered_to_shift_id')->nullable(); //الشفت المستلم
            $table->integer('delivered_to_treasuries_id')->nullable(); // الخزنه المستلمه للشفت
            $table->integer('money_should_delivered')->default(0);// كم الفلوس الى المفروض اسلمها بعد الشفت
            $table->integer('what_alredy_delivered')->default(0); // الفلوس الى انا سلمتها بعد الشفت
            $table->tinyInteger('money_status')->default(0); //حاله الفلوس 0- متزن 1- عجز 2- زياده
            $table->integer('money_status_value')->default(0); //قيمه العجز او الزياده او 0لو متزن
            $table->boolean('receive_on_the_same_treasuries')->default(0);//التسليم لنفس الخزنه او التسليم لخزنه رئيسيه
            $table->date('review_receive_date')->nullable();
            $table->bigInteger('treasuries_transaction_id')->nullable();
            $table->integer('added_by');
            $table->date('date')->nullable();
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
        Schema::dropIfExists('admin_shifts');
    }
};
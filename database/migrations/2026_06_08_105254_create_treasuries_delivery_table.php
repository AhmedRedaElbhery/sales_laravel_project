<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('treasuries_delivery', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('treasuries_id'); //رقم الخزنه الرئيسيه

            $table->integer('treasuries_can_delivery_id');// رقم الخزنه الفرعيه الى هتبعت للرئيسيه
            $table->integer('com_code');
            $table->integer('added_by');
            $table->integer('updated_by')->nullable();

            $table->timestamps();

            $table->foreign('treasuries_id')
                  ->references('id')
                  ->on('treasuries')
                  ->onDelete('cascade');

            $table->engine = 'InnoDB';
        });
    }

    public function down()
    {
        Schema::dropIfExists('treasuries_delivery');
    }
};
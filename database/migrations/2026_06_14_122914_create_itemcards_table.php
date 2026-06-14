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
        Schema::create('itemcards', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name');
            $table->tinyInteger('item_type'); //عهده او استهلاكى او مخزني
            $table->unsignedBigInteger('categories_id'); //forign key on table categories
            $table->bigInteger('parent_id'); //رقم الصنف الاب التابع له
            $table->boolean('has_retail_unit'); //هل يوجد وحده تجزئه للصنف
            $table->integer('retail_unit_id'); // كود وحده قياس التجزئه
            $table->integer('parent_unit_id'); // كود وحده قياس الاب
            $table->decimal('retail_unit_to_parent' , 10,2); // عدد وحدات التجزئه بالنسبه للوحده الاب
            $table->integer('added_by');
            $table->integer('updated_by')->nullable();
            $table->boolean('active')->default(1);
            $table->date('date');
            $table->integer('com_code');
            $table->bigInteger('item_code');
            $table->string('barcode');
            $table->timestamps();

            $table->foreign('categories_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');

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
        Schema::dropIfExists('itemcards');
    }
};
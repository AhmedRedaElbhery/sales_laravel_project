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
            $table->bigInteger('item_code');
            $table->string('name');
            $table->tinyInteger('item_type'); //عهده او استهلاكى او مخزني
            $table->unsignedBigInteger('categories_id'); //forign key on table categories
            $table->bigInteger('parent_id'); //رقم الصنف الاب التابع له
            $table->boolean('has_retail_unit'); //هل يوجد وحده تجزئه للصنف
            $table->integer('retail_unit_id')->nullable(); // كود وحده قياس التجزئه
            $table->integer('parent_unit_id'); // كود وحده قياس الاب
            $table->decimal('retail_unit_to_parent' , 10,2)->nullable(); // عدد وحدات التجزئه بالنسبه للوحده الاب

            $table->decimal('price' , 10,2); //السعر القطاعى لوحده القياس الاساسيه
            $table->decimal('Wholesale_price' , 10,2); // السعرالجمله لوحده القياس الاساسيه
            $table->decimal('half_Wholesale_price' , 10,2); //السعر النص جمله لوحده القياس الاساسيه

            $table->decimal('retail_price' , 10,2)->nullable(); // السعر القطاعى لوحده القياس التجزئه
            $table->decimal('retail_Wholesale_price' , 10,2)->nullable(); // السعرالجمله لوحده القياس التجزئه
            $table->decimal('retail_half_Wholesale_price' , 10,2)->nullable(); //السعر النص جمله لوحده القياس التجزئه

            $table->decimal('cost_price' , 10,2); // متوسط التكلفه للشراء بالوحده الاساسيه
            $table->decimal('retail_cost_price' , 10,2)->nullable(); //متوسط التكلفه للشراء بالتجزئه

            $table->decimal('quantity' , 10,2)->nullable(); //متوسط التكلفه للشراء بالتجزئه
            $table->decimal('retail_quantity' , 10,2)->nullable(); //متوسط التكلفه للشراء بالتجزئه
            $table->decimal('all_retail_quantity' , 10,2)->nullable(); //متوسط التكلفه للشراء بالتجزئه

            $table->integer('added_by');
            $table->boolean('has_fixed_price');
            $table->integer('updated_by')->nullable();
            $table->boolean('active')->default(1);
            $table->date('date');
            $table->integer('com_code');
            $table->string('barcode')->nullable();
            $table->string('photo')->nullable();
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
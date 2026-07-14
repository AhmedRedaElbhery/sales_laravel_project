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
        Schema::create('item_movement', function (Blueprint $table) {
            $table->id();
            $table->integer('item_code');
            $table->integer('movement_type');
            $table->integer('table_code');
            $table->integer('table_details_code');
            $table->decimal('quantity_before_movement')->default(0);
            $table->decimal('quantity_after_movement')->default(0);
            $table->integer('added_by');
            $table->integer('com_code');
            $table->date('date');
            $table->string('byan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_movement');
    }
};
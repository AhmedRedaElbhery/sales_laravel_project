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
        Schema::create('admin_panal_settings', function (Blueprint $table) {
            $table->id();
            $table->string('system_name', 250);
            $table->string('photo', 225);
            $table->boolean('active')->default(1);
            $table->string('general_alert', 150)->nullable();
            $table->string('address', 250);
            $table->string('phone', 100);
            $table->integer('added_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('com_code');
            $table->bigInteger('customer_parent_account_number');
            $table->bigInteger('supplier_parent_account_number');
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
        Schema::dropIfExists('admin_panal_settings');
    }
};
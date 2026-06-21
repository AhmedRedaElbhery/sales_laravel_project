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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('account_type');
            $table->integer('parent_account_number')->nullable();
            $table->integer('account_number')->default(0);
            $table->integer('start_balance');
            $table->tinyInteger('start_balance_status');
            $table->integer('current_balance');
            $table->integer('added_by');
            $table->integer('updated_by')->nullable();
            $table->date('date');
            $table->boolean('is_archived')->default(0);
            $table->boolean('is_parent')->default(0);
            $table->integer('com_code');
            $table->string('notes')->nullable();
            $table->bigInteger('other_table_fk')->nullable(); // التغيرات ف كل الحسابات هتبعت رقم هنا عشان نعرف التغيير
            $table->timestamps();

            $table->foreign('account_type')
                  ->references('id')
                  ->on('account_types')
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
        Schema::dropIfExists('accounts');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code')->unique();
            $table->integer('weight');
            $table->integer('price');
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->string('status', 1);
            $table->unsignedBigInteger('laundromat_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('laundromat_id')->references('id')->on('laundromats');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('transactions');
    }
}

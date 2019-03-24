<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 45);
            $table->float('price', 8, 2);
            $table->string('description', 255);
            $table->integer('quantity');
            $table->date('post_date');
            // $table->integer('status');
            $table->integer('trade_transaction_id');
            $table->integer('trade_category_id');
            $table->integer('trade_condition_type_id');
            $table->integer('trade_status_id');
            $table->integer('is_deleted');
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
        Schema::dropIfExists('trades');
    }
}

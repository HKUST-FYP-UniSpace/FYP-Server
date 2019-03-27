<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 45);
            $table->string('subtitle', 120);
            $table->string('type', 45);
            $table->float('size', 8, 2);
            $table->string('address', 255);
            $table->integer('district_id');
            $table->string('description', 255);
            $table->integer('max_ppl');
            $table->float('price', 8, 2);
            $table->integer('status');
            $table->integer('owner_id');
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
        Schema::dropIfExists('houses');
    }
}

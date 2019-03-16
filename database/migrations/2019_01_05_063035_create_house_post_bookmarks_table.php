<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHousePostBookmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('house_post_bookmarks', function (Blueprint $table) {
            $table->increments('id');
            // $table->integer('status');
            // $table->integer('house_post_id');
            // $table->integer('bookmark_status_id');
            $table->integer('house_id');
            $table->integer('tenant_id');
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
        Schema::dropIfExists('house_post_bookmarks');
    }
}

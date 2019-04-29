<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameAndAddColumnsToChatroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chatrooms', function (Blueprint $table) {
            $table->renameColumn('identifiers', 'title');
            $table->integer('house_id')->length(11)->nullable()->after('chatroom_type_id');
            $table->dropColumn('group_id');
            $table->integer('team_id')->nullable()->after('house_id');
            $table->integer('trade_id')->length(11)->nullable()->after('team_id');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chatrooms', function (Blueprint $table) {
            //
        });
    }
}

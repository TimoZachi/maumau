<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsedToRoundsCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rounds_cards', function (Blueprint $table)
        {
	        $table->boolean('used')->default(false)->after('player_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rounds_cards', function (Blueprint $table)
        {
            $table->dropColumn('used');
        });
    }
}

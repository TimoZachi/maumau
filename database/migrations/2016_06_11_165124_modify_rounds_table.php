<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rounds', function (Blueprint $table)
        {
            $table->dropForeign('rounds_card_id_foreign');
            $table->dropIndex('rounds_card_id_foreign');
            $table->dropColumn('card_id');

            $table->integer('round_card_id', false, true)->nullable()->after('player_id');

            $table->foreign('round_card_id')
                ->references('id')->on('rounds_cards')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rounds', function (Blueprint $table)
        {
            $table->dropColumn('round_card_id');

            $table->integer('card_id', false, true)->nullable()->after('player_id');

            $table->foreign('card_id')
                ->references('id')->on('cards')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }
}

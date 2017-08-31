<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToRoundsTable extends Migration
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
            $table->integer('card_id', false, true)->nullable()->after('player_id');
            $table->smallInteger('suit_id', false, true)->nullable()->after('card_id');

            $table->foreign('card_id')
                ->references('id')->on('cards')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('suit_id')
                ->references('id')->on('suits')
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
            $table->dropColumn('suit_id');
            $table->dropColumn('card_id');
        });
    }
}

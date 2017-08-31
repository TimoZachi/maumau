<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoundsCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rounds_cards', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->integer('round_id', false, true);
            $table->integer('card_id', false, true);
            $table->integer('player_id', false, true)->nullable();

            $table->unique(['round_id', 'card_id']);

            $table->foreign('round_id')
                ->references('id')->on('rounds')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('card_id')
                ->references('id')->on('cards')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('player_id')
                ->references('id')->on('players')
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
        Schema::drop('round_cards');
    }
}

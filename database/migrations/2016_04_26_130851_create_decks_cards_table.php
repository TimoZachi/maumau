<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDecksCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('decks_cards', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

	        $table->smallInteger('deck_id', false, true);
	        $table->integer('card_id', false, true);
	        $table->smallInteger('order', false, true)->default(0);

	        $table->primary(['deck_id', 'card_id']);

	        $table->foreign('deck_id')
		        ->references('id')->on('decks')
		        ->onDelete('cascade')
		        ->onUpdate('cascade');

	        $table->foreign('card_id')
		        ->references('id')->on('cards')
		        ->onDelete('cascade')
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
        Schema::drop('deck_cards');
    }
}

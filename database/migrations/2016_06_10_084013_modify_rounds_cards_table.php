<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyRoundsCardsTable extends Migration
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
	        $table->dropForeign('rounds_cards_round_id_foreign');
	        $table->dropIndex('rounds_cards_round_id_card_id_unique');

	        $table->timestamps();

	        $table->index(['round_id', 'card_id']);
	        $table->foreign('round_id')
		        ->references('id')->on('rounds')
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
        Schema::table('rounds_cards', function (Blueprint $table)
        {
	        $table->dropForeign('rounds_cards_round_id_foreign');
	        $table->dropIndex('rounds_cards_round_id_card_id_index');

	        $table->dropColumn(['updated_at', 'created_at']);

	        $table->unique(['round_id', 'card_id']);
	        $table->foreign('round_id')
		        ->references('id')->on('rounds')
		        ->onDelete('cascade')
		        ->onUpdate('cascade');
        });
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeckCountToModalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::table('modalities', function (Blueprint $table)
		{
			$table->tinyInteger('decks_count')->default(1)->after('deck_id');
			$table->dropColumn('suits_count');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('modalities', function (Blueprint $table)
		{
			$table->tinyInteger('suits_count')->default(1)->after('name');
			$table->dropColumn('decks_count');
		});
	}
}

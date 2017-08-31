<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSuitsCountToModalitiesTable extends Migration
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
            $table->tinyInteger('suits_count')->default(1)->after('name');
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
            $table->dropColumn('suits_count');
        });
    }
}

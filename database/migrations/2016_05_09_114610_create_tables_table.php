<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tables', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->tinyInteger('capacity', false, false)->default(0);
            $table->tinyInteger('occupants', false, false)->default(0);
            $table->boolean('in_game')->default(false);

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
        Schema::drop('tables');
    }
}

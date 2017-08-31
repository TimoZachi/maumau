<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOccupantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_occupants', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->integer('table_id', false, true);
            $table->integer('user_id', false, true);

            $table->primary(['table_id', 'user_id']);

            $table->foreign('table_id')
                ->references('id')->on('tables')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
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
        Schema::drop('table_occupants');
    }
}

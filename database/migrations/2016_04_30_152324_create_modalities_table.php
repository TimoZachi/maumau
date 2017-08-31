<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modalities', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->smallInteger('id', true, true);

            $table->smallInteger('deck_id', false, true);
            $table->string('name', 255)->default('');
            $table->string('description', 2047)->default('');
            $table->boolean('main')->default(true);

            $table->timestamps();

            $table->foreign('deck_id')
                ->references('id')->on('decks')
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
        Schema::drop('modalities');
    }
}

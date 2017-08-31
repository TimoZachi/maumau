<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table)
        {
	        $table->engine = 'InnoDB';

            $table->increments('id');

	        $table->smallInteger('suit_id', false, true)->nullable();
	        $table->smallInteger('action_id', false, true)->nullable();
	        $table->tinyInteger('match', false, true)->default(1)
                ->comment('1 = Nome ou Naipe, 2 = Apenas Nome, 3 = Apenas Naipe, 4 = Qualquer Carta');
            $table->smallInteger('points', false, true)->default(1);

	        $table->string('name', 6)->default('')
		        ->comment('nome da carta (rei, valete, dama, etc)');
	        $table->string('image', 63)->default('')
		        ->comment('imagem da carta para mostrar no jogo?');

            $table->timestamps();

	        $table->foreign('suit_id')
		        ->references('id')->on('suits')
		        ->onDelete('restrict')
		        ->onUpdate('cascade');

	        $table->foreign('action_id')
		        ->references('id')->on('actions')
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
        Schema::drop('cards');
    }
}

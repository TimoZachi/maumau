<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

	        $table->smallInteger('id', true, true);

	        $table->string('key', 63)->default('')->unique()
		        ->comment('identificador único para aquela regra, letras minúsculas, dígitos e underlines permitidos apenas');
	        $table->string('name', 127)->default('')
		        ->comment('nome curto da ação');
	        $table->string('description', 1023)->default('')
		        ->comment('rdescrição detalhada da ação');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('actions');
    }
}

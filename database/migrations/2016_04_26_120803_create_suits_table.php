<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suits', function (Blueprint $table)
        {
	        $table->engine = 'InnoDB';

            $table->smallInteger('id', true, true);

	        $table->string('name', 127)->default('')
		        ->comment('nome do naipe');
	        $table->string('icon', 63)->default('')
	            ->comment('nome do ícone (imagem)');
	        $table->char('color', 7)->nullable()
		        ->comment('rgb = 000000');

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
        Schema::drop('suits');
    }
}

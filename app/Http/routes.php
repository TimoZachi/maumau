<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [
	'as' => 'home',
    'uses' => function () {  return view('welcome'); }
]);

Route::get('login', [
	'as' => 'login',
	'uses' => '\MauMau\Http\Controllers\Auth\AuthController@getLogin'
]);
Route::post('login', '\MauMau\Http\Controllers\Auth\AuthController@postLogin');
Route::get('logout', [
	'as' => 'logout',
	'uses' => '\MauMau\Http\Controllers\Auth\AuthController@getLogout'
]);

Route::get('cadastrar', [
	'as' => 'register',
	'uses' => '\MauMau\Http\Controllers\Auth\AuthController@getRegister'
]);
Route::post('cadastrar', '\MauMau\Http\Controllers\Auth\AuthController@postRegister');

Route::group([
		//Descomente abaixo para adicionar segurança do login
		'middleware' => 'auth.admin',
		'prefix' => 'admin'
	], function ()
	{
		Route::get('/', function () { return redirect()->route('admin.dashboard'); });

		Route::get('dashboard', [
			'as' => 'admin.dashboard',
			'uses' => '\MauMau\Http\Controllers\Admin\IndexController@dashboard'
		]);

		Route::get('modalidades', [
			'as' => 'admin.modalidades',
			'uses' => '\MauMau\Http\Controllers\Admin\IndexController@modalidades'
		]);
		Route::get('cartas', [
			'as' => 'admin.cartas',
			'uses' => '\MauMau\Http\Controllers\Admin\IndexController@cartas'
		]);
		Route::get('baralhos-e-naipes', [
			'as' => 'admin.baralhos-e-naipes',
			'uses' => '\MauMau\Http\Controllers\Admin\IndexController@baralhosENaipes'
		]);
		Route::get('baralhos/{id}/associar-cartas', [
			'as' => 'admin.baralhos-associar-cartas',
			'uses' => '\MauMau\Http\Controllers\Admin\IndexController@baralhosAssociarCartas'
		]);

		/** CRUD dos naipes */
		Route::resource('suits', '\MauMau\Http\Controllers\Admin\SuitController', [
			//Incluí todos os recursos rest aqui por questão de exemplo
			'only' => ['index', 'create', 'store', /*'show',*/ 'edit', 'update', 'destroy']
		]);

		/** CRUD dos baralhos */
		Route::resource('decks', '\MauMau\Http\Controllers\Admin\DeckController', [
			//Incluí todos os recursos rest aqui por questão de exemplo
				'only' => ['index', 'create', 'store', /*'show',*/ 'edit', 'update', 'destroy']
		]);
        Route::post('{id}/associate-cards', [
            'as' => 'admin.decks.associate-cards',
            'uses' => '\MauMau\Http\Controllers\Admin\DeckController@postAssociateCards'
        ]);

		/** CRUD das cartas */
		Route::resource('cards', '\MauMau\Http\Controllers\Admin\CardController', [
			//Incluí todos os recursos rest aqui por questão de exemplo
			'only' => ['index', 'create', 'store', /*'show',*/ 'edit', 'update', 'destroy']
		]);

		/** CRUD das cartas */
		Route::resource('modalities', '\MauMau\Http\Controllers\Admin\ModalityController', [
			//Incluí todos os recursos rest aqui por questão de exemplo
			'only' => ['index', 'create', 'store', /*'show',*/ 'edit', 'update', 'destroy']
		]);
	}
);

Route::group([
    //Descomente abaixo para adicionar segurança do login
    'middleware' => 'auth',
    ], function ()
    {
        Route::get('jogar', [
            'as' => 'jogar',
            'uses' => '\MauMau\Http\Controllers\GameController@jogar'
        ]);
        Route::get('game/{id}', [
            'as' => 'game',
            'uses' => '\MauMau\Http\Controllers\GameController@game'
        ]);
        Route::get('users/me', [
            'as' => 'users.edit',
            'uses' => '\MauMau\Http\Controllers\UserController@edit'
        ]);
        Route::put('users/me', [
            'as' => 'users.update',
            'uses' => '\MauMau\Http\Controllers\UserController@update'
        ]);
    }
);
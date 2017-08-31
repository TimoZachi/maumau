<?php
namespace MauMau\Http\Controllers\Admin;

use Auth;
use Config;
use Image;
use MauMau\Http\Controllers\Controller;
use MauMau\Models\Card;
use MauMau\Models\Deck;

class IndexController extends Controller
{
	public function navbar()
	{
		$user = Auth::user();

		return view('admin.navbar', compact(['user']));
	}

	public function dashboard()
	{
		return view('admin.dashboard');
	}

	public function cartas()
	{
		return view('admin.cartas');
	}

	public function baralhosENaipes()
	{
		return view('admin.baralhos-e-naipes');
	}

	public function modalidades()
	{
		return view('admin.modalidades');
	}

	public function baralhosAssociarCartas($id)
	{
		/** @var Deck $deck */
		$deck = Deck::find($id);
		if(!$deck) abort(404, 'Baralho não encontrado');

		$upload_path = Config::get('app.image_upload_path') . 'cards' . DIRECTORY_SEPARATOR;

		$cards_associated_ids = $deck->Cards()->getRelatedIds();
		$cards_associated = $deck->Cards;

		$cards_not_associated = Card::whereNotIn('id', $cards_associated_ids)->get();

		return view('admin.baralhos-associar-cartas', compact(['deck', 'cards_associated', 'cards_not_associated']));
	}
}
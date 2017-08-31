<?php
namespace MauMau\Http\Controllers;

use Auth;
use Config;
use Image;

class IndexController extends Controller
{
	public function navbar()
	{
		$user = null;
		if(Auth::check()) $user = Auth::user();

		return view('navbar', compact(['user']));
	}
	
}
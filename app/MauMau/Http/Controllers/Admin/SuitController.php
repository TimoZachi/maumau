<?php
namespace MauMau\Http\Controllers\Admin;

use MauMau\Http\Controllers\Controller;
use MauMau\Models\Suit;
use Illuminate\Http\Request;

use Image;
use Config;
use App\Http\Requests;

class SuitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $suits = Suit::all()->toArray();

        return view('admin.suits.index', compact(['suits']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    return view('admin.suits.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $this->validate($request, [
		    'name' => 'required',
		    'icon' => 'required|image',
		    'color' => 'required|regex:/^#[0-9a-fA-F]{6}$/',
	    ]);

		$input = $request->all();

		$icon = $input['icon'];
		$upload_path = Config::get('app.image_upload_path') . 'suits' . DIRECTORY_SEPARATOR;
		do {
			$icon_name = str_random(8) . '.' . $icon->getClientOriginalExtension();
		} while(file_exists($upload_path . $icon_name));
		$input['icon'] = $icon_name;
		$icon->move($upload_path, $icon_name);

		/** @var Suit $suit */
		$suit = Suit::create($input);

		return response()->json([
			'status' => 'success',
			'message' => 'Naipe criado com sucesso',
			'suit' => $suit->toArray()
		]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		/** @var Suit $suit */
	    $suit = Suit::find($id);
	    if(!$suit) abort(404, 'Naipe não encontrado');

	    $suit = $suit->toArray();

		if(!empty($suit['icon']))
		{
			$upload_path = Config::get('app.image_upload_path') . 'suits' . DIRECTORY_SEPARATOR;

			$suit['icon'] = Image::make($upload_path . $suit['icon']);
		}

	    return view('admin.suits.edit', compact(['id', 'suit']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		/** @var Suit $suit */
		$suit = Suit::find($id);
		if(!$suit) abort(404, 'Naipe não encontrado');

		$this->validate($request, [
			'name' => 'required',
			'icon' => 'image',
			'color' => 'required|regex:/^#[0-9a-fA-F]{6}$/',
		]);

		$input = $request->all();

		if(!empty($input['icon']))
		{
			$icon = $input['icon'];
			$upload_path = Config::get('app.image_upload_path') . 'suits' . DIRECTORY_SEPARATOR;
			do {
				$icon_name = str_random(8) . '.' . $icon->getClientOriginalExtension();
			} while(file_exists($upload_path . $icon_name));
			$input['icon'] = $icon_name;
			$icon->move($upload_path, $icon_name);

			if(!empty($card['image']) && file_exists($upload_path . $suit['icon'])) unlink($upload_path . $suit['icon']);
		}
		else unset($input['icon']);

		$success = $suit->update($input);

		return response()->json([
			'status' => 'success',
			'message' => 'Naipe atualizado com sucesso',
		    'suit' => $suit->toArray()
		]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		/** @var Suit $suit */
		$suit = Suit::find($id);
		if(!$suit) abort(404, 'Naipe não encontrado');

		$success = Suit::destroy($id);

		return response()->json([
			'status' => 'success',
			'message' => 'Naipe excluído com sucesso',
		    'id' => $id
		]);
    }
}

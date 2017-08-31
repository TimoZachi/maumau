<?php
namespace MauMau\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Config;
use Image;
use MauMau\Http\Controllers\Controller;
use MauMau\Models\Action;
use MauMau\Models\Card;
use MauMau\Models\Suit;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $cards = Card::all();

	    return view('admin.cards.index', compact(['cards']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    $suits = Suit::all()->toArray();
	    $actions = Action::all()->toArray();

	    return view('admin.cards.create', compact(['suits', 'actions']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $suit_table = Suit::getModelTable();
	    $action_table = Action::getModelTable();

	    $this->validate($request, [
		    'suit_id' => "exists:{$suit_table},id",
		    'action_id' => "exists:{$action_table},id",
		    'points' => "required|integer|min:1|max:30",
		    'match' => "required|integer|in:1,2,3,4",
		    'name' => 'required|regex:/^[0-9A-Z]{1,6}$/',
		    'image' => 'image'
	    ]);

	    $input = $request->all();
	    if(empty($input['suit_id'])) $input['suit_id'] = null;
	    if(empty($input['action_id'])) $input['action_id'] = null;
        $input['name'] = strtoupper($input['name']);

	    if(!empty($input['image']))
	    {
		    $image = $input['image'];
		    $upload_path = Config::get('app.image_upload_path') . 'cards' . DIRECTORY_SEPARATOR;
		    do {
			    $image_name = str_random(8) . '.' . $image->getClientOriginalExtension();
		    } while(file_exists($upload_path . $image_name));
		    $input['image'] = $image_name;
		    $image->move($upload_path, $image_name);
	    }
	    else unset($input['image']);

	    /** @var Card $card */
	    $card = Card::create($input);

	    return response()->json([
		    'status' => 'success',
		    'message' => 'Carta criada com sucesso',
		    'card' => $card->toArray()
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
	    /** @var Card $card */
	    $card = Card::find($id);
	    if(!$card) abort(404, 'Carta não encontrada');

	    $suits = Suit::all()->toArray();
	    $actions = Action::all()->toArray();
	    $card = $card->toArray();

		if(!empty($card['image']))
		{
			$upload_path = Config::get('app.image_upload_path') . 'cards' . DIRECTORY_SEPARATOR;

			$card['image'] = Image::make($upload_path . $card['image']);
		}

	    return view('admin.cards.edit', compact(['id', 'card', 'suits', 'actions']));
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
	    /** @var Card $card */
	    $card = Card::find($id);
	    if(!$card) abort(404, 'Carta não encontrada');

	    $suit_table = Suit::getModelTable();
	    $action_table = Action::getModelTable();

	    $this->validate($request, [
            'suit_id' => "exists:{$suit_table},id",
            'action_id' => "exists:{$action_table},id",
            'points' => "required|integer|min:1|max:30",
            'match' => "required|integer|in:1,2,3,4",
            'name' => 'required|regex:/^[0-9A-Z]{1,6}$/',
		    'image' => 'image'
	    ]);

	    $input = $request->all();
		if(empty($input['suit_id'])) $input['suit_id'] = null;
		if(empty($input['action_id'])) $input['action_id'] = null;
        $input['name'] = strtoupper($input['name']);

	    if(!empty($input['image']))
	    {
		    $image = $input['image'];
		    $upload_path = Config::get('app.image_upload_path') . 'cards' . DIRECTORY_SEPARATOR;
		    do {
			    $image_name = str_random(8) . '.' . $image->getClientOriginalExtension();
		    } while(file_exists($upload_path . $image_name));
		    $input['image'] = $image_name;
		    $image->move($upload_path, $image_name);

		    if(!empty($card['image']) && file_exists($upload_path . $card['image'])) unlink($upload_path . $card['image']);
	    }
	    else unset($input['image']);

	    $success = $card->update($input);

	    return response()->json([
		    'status' => 'success',
		    'message' => 'Carta editada com sucesso',
		    'card' => $card->toArray()
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
	    /** @var Card $card */
	    $card = Card::find($id);
	    if(!$card) abort(404, 'Carta não encontrada');

	    $success = Card::destroy($id);

	    return response()->json([
		    'status' => 'success',
		    'message' => 'Carta excluída com sucesso',
		    'id' => $id
	    ]);
    }
}

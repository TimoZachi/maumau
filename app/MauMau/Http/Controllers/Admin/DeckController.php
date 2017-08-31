<?php
namespace MauMau\Http\Controllers\Admin;

use DB;
use Illuminate\Database\Query\Builder;
use MauMau\Http\Controllers\Controller;
use MauMau\Models\Deck;
use Illuminate\Http\Request;

use App\Http\Requests;
use MauMau\Models\DeckCard;

class DeckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $decks_models = Deck::all();
        $decks = [];
        /** @var Deck $deck_model */
        foreach ($decks_models as $deck_model) {
            $deck = $deck_model->toArray();
            $deck['suits_count'] = $deck_model->SuitsCount();
            $deck['cards_count'] = $deck_model->Cards()->count();
            $decks[] = $deck;
        }

        return view('admin.decks.index', compact(['decks']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.decks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $input = $request->all();

        /** @var Deck $deck */
        $deck = Deck::create($input);

        return response()->json([
            'status' => 'success',
            'message' => 'Baralho criado com sucesso',
            'deck' => $deck->toArray()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /** @var Deck $deck */
        $deck = Deck::find($id);
        if (!$deck) abort(404, 'Baralho não encontrado');

        $deck = $deck->toArray();

        return view('admin.decks.edit', compact(['id', 'deck']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /** @var Deck $deck */
        $deck = Deck::find($id);
        if (!$deck) abort(404, 'Baralho não encontrado');

        $this->validate($request, [
            'name' => 'required'
        ]);

        $input = $request->all();

        $success = $deck->update($input);

        return response()->json([
            'status' => 'success',
            'message' => 'Baralho atualizado com sucesso',
            'deck' => $deck->toArray()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /** @var Deck $deck */
        $deck = Deck::find($id);
        if (!$deck) abort(404, 'Baralho não encontrado');

        $success = Deck::destroy($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Baralho excluído com sucesso',
            'id' => $id
        ]);
    }

    public function postAssociateCards(Request $request, $id)
    {
        /** @var Deck $deck */
        $deck = Deck::find($id);
        if (!$deck) abort(404, 'Baralho não encontrado');

        $card_ids = $request->input('card_ids');
        $deck->Cards()->sync($request->input('card_ids'));

        /** @var Builder $qb */
        $i = 1; $deck_card_table = DeckCard::getModelTable();
        foreach($card_ids as $card_id)
        {
            DB::table($deck_card_table)
                ->where('deck_id', '=', $deck['id'])
                ->where('card_id', '=', (int)$card_id)
                ->update(['order' => $i]);

            $i++;
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cartas associadas com sucesso',
            'deck' => $deck
        ]);
    }
}

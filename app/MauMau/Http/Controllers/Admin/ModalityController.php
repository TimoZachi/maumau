<?php

namespace MauMau\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use MauMau\Http\Controllers\Controller;
use MauMau\Models\Deck;
use MauMau\Models\Modality;

class ModalityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modalities_models = Modality::all();

        $modalities = [];
        /** @var Modality $modality_model */
        foreach($modalities_models as $modality_model)
        {
            $modality = $modality_model->toArray();
            $modality['Deck'] = $modality_model->Deck->toArray();
            $modalities[] = $modality;
        }

        return view('admin.modalities.index', compact(['modalities']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $decks = Deck::all()->toArray();

        return view('admin.modalities.create', compact(['decks']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $deck_table = Deck::getModelTable();

        $this->validate($request, [
            'deck_id' => "required|exists:{$deck_table},id",
            'name' => 'required',
            'decks_count' => 'required|integer|min:1'
        ]);

        $input = $request->all();
        $input['main'] = $request->has('main') ? true : false;

        /** @var Modality $modality */
        $modality = Modality::create($input);

        return response()->json([
            'status' => 'success',
            'message' => 'Modalidade criada com sucesso',
            'modality' => $modality->toArray()
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /** @var Modality $modality */
        $modality = Modality::find($id);
        if(!$modality) abort(404, 'Modalidade não encontrada');

        $decks = Deck::all()->toArray();
        $modality = $modality->toArray();

        return view('admin.modalities.edit', compact(['id', 'modality', 'decks']));
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
        /** @var Modality $modality */
        $modality = Modality::find($id);
        if(!$modality) abort(404, 'Modalidade não encontrada');

        $deck_table = Deck::getModelTable();

        $this->validate($request, [
            'deck_id' => "required|exists:{$deck_table},id",
            'name' => 'required',
            'decks_count' => 'required|integer|min:1'
        ]);

        $input = $request->all();
        $input['main'] = $request->has('main') ? true : false;

        $success = $modality->update($input);

        return response()->json([
            'status' => 'success',
            'message' => 'Modalidade editada com sucesso',
            'modality' => $modality->toArray()
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
        /** @var Modality $modality */
        $modality = Modality::find($id);
        if(!$modality) abort(404, 'Modalidade não encontrada');

        $success = Modality::destroy($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Modalidade excluída com sucesso',
            'id' => $id
        ]);
    }
}

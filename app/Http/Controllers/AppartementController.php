<?php

namespace App\Http\Controllers;

use App\Models\Appartement;
use App\Models\Client;
use Illuminate\Http\Request;

class AppartementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('amrani.pages.appartement.index')->with([
            'appartements'   =>  Appartement::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lastID = 'APP' . str_pad( (Appartement::max('id') + 1) , 5, 0, STR_PAD_LEFT );
        return view('amrani.pages.appartement.create')->with([
            'etats'                 =>  ['Nouveau', 'Habite'],
            'types'                 =>  ['Appartement', 'Duplexe'],
            'situations'            =>  ['Titre', 'Milikia', 'Contrat', 'Miftah', 'Contrat Adlia'],
            'code_appartement'      =>  $lastID
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'appartement_code'           => 'required|max:10'
        ]);

        if(!$request->client_id){
            $clientTemp = new ClientController;
            $client = Client::create([
                'client_code'           =>  $clientTemp->newCodeClient(),
                'client_category_id'    =>  $clientTemp->getDefaultClientCategory(),
                'client_status_id'    =>  $clientTemp->getDefaultClientStatus()
            ]);
        }

        $request->merge([
            'appartements_en_etage' => $request->appartements_en_etage? $request->appartements_en_etage:0,
            'client_id' =>  $client->id
        ]);
        Appartement::create($request->all());
        return redirect()->route('appartement.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appartement  $appartement
     * @return \Illuminate\Http\Response
     */
    public function show(Appartement $appartement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appartement  $appartement
     * @return \Illuminate\Http\Response
     */
    public function edit(Appartement $appartement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appartement  $appartement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appartement $appartement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appartement  $appartement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appartement $appartement)
    {
        //
    }
}

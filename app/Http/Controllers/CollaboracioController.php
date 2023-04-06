<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use App\Models\Empresa;
use App\Models\Contacte;
use App\Models\Collaboracio;
use App\Models\Curs;
use App\Models\Cicle;
use App\Models\User;

class CollaboracioController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collaboracions = Collaboracio::all();
        return view('collaboracio.index', ['collaboracions' => $collaboracions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empreses = Empresa::all();
        $cicles = Cicle::all();
        $user = Auth::user();
        $year = date("Y") + 1;

        return view('collaboracio.create', [
            'empreses' => $empreses, 'cicles' => $cicles, 'user' => $user, 'year' => $year
        ]);
    }

    /**
     * Get contacts for create blade.
     */
    public function getContactes(Request $request)
    {
        error_log($request);

        try {
            if($request->id){    
            $empresa_id = $request->id;
            $contactes = Contacte::where('contactes.empresa_id', '=', $empresa_id)
            ->select('contactes.*')
            ->get();
            return response()->json($contactes);}
        } catch (\Exception $exception) {
            return response()->json([ 'message' => 'There was an error retrieving the records' ], 500);
        }

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $user)
    {
        $collaboracio = new Collaboracio;
        $collaboracio->empresa_id = $request->empresa_id;
        $collaboracio->contacte_id = $request->contacte_id;
        $collaboracio->cicle_id = $request->cicle_id;
        $collaboracio->curs_id = $request->curs_id;
        $collaboracio->comentari = $request->comentari;
        $collaboracio->user_id = $user;


        $collaboracio->save();

        return view('collaboracio.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $contacte = Contacte::find($id);
        $empreses = Empresa::all();
        return view('contacte.edit', ['contacte' => $contacte, 'empreses' => $empreses]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $contacte = Contacte::find($id);
        $contacte->nom = $request->nom;
        $contacte->cognoms = $request->cognoms;
        $contacte->movil = $request->movil;
        $contacte->email = $request->email;
        $contacte->empresa_id = $request->empresa;

        $contacte->save();

        $empresa = Empresa::find($contacte->empresa_id);
        $contactes = Empresa::find(1)->contactes;

        return view('empresa.show', ['empresa' => $empresa, 'contactes' => $contactes]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $contacte = Contacte::find($id);
        $contacte->delete();

        $idEmpresa = $contacte->empresa_id;

        return redirect()->route('empresa_show', ['id' => $idEmpresa])->with('status', 'Contacte ' . $contacte->nom . ' eliminat!');
    }
}

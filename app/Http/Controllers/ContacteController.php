<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Empresa;
use App\Models\Contacte;
use Inertia\Inertia;


class ContacteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactes = Contacte::with('empresa')->paginate(5);

        $columns = [
            ["label" => "Nom", "field" => "nom"],
            ["label" => "Cognoms", "field" => "cognoms"],
            ["label" => "Móvil", "field" => "movil"],
            ["label" => "E-mail", "field" => "email"],
            ["label" => "Empresa", "field" => "empresa.nom"]
        ];

        return Inertia::render('Contacte/Index', [
            'contactes' => $contactes,
            'columns' => $columns
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $id)
    {
        $empresa = Empresa::where('id',$id)->with('poblacio', 'categoria', 'sector')->firstOrFail();

        return Inertia::render('Contacte/Create', [
            'empresa' => $empresa
        ]);

    }

    public function createWithoutId()
    {
        $empreses = Empresa::all();

        return Inertia::render('Contacte/CreateContacte', [
            'empreses' => $empreses
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $contacte = new Contacte;
        $contacte->nom = $request->nom;
        $contacte->cognoms = $request->cognoms;
        $contacte->movil = $request->movil;
        $contacte->email = $request->email;
        $contacte->empresa_id = $request->empresa_id;

        $contacte->save();

        $empresa = Empresa::where('id',$contacte->empresa_id)->with('poblacio', 'categoria', 'sector')->firstOrFail();
        
        return redirect()->route('empresa.show', ['id' => $empresa->id])->with('status', 'Nou contacte ' . $contacte->nom . ' creat!');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $contacte = Contacte::where('id',$id)->with('empresa')->firstOrFail();

        return Inertia::render('Contacte/Edit', [
            'contacte' => $contacte
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $contacte = Contacte::where('id',$id)->with('empresa')->firstOrFail();
        $contacte->nom = $request->nom;
        $contacte->cognoms = $request->cognoms;
        $contacte->movil = $request->movil;
        $contacte->email = $request->email;
        $contacte->empresa_id = $request->empresa_id;

        $contacte->save();

        $empresa = Empresa::where('id',$contacte->empresa_id)->with('poblacio', 'categoria', 'sector')->firstOrFail();

        return redirect()->route('empresa.show', ['id' => $empresa->id])->with('status', 'Contacte ' . $contacte->nom . ' modificat!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(int $id)
    {
        $contacte = Contacte::find($id);
        $contacte->delete();

        $idEmpresa = $contacte->empresa_id;

        return redirect()->route('empresa.show', ['id' => $idEmpresa])->with('status', 'Contacte ' . $contacte->nom . ' eliminat!');
    }
}

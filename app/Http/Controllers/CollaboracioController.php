<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Empresa;
use App\Models\Contacte;
use App\Models\Collaboracio;
use App\Models\Cicle;

class CollaboracioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collaboracions = Collaboracio::with('empresa', 'contacte', 'cicle', 'user')->paginate(5);
        $columns = [
            ["label" => "Cicle", "field" => "cicle.nom"],
            ["label" => "Any", "field" => "any"],
            ["label" => "Empresa", "field" => "empresa.nom"],
            ["label" => "Contacte", "field" => "contacte.nom"],
            ["label" => "Usuari", "field" => "user.name"],
        ];

        return Inertia::render('Collaboracio/Index', [
            'collaboracions' => $collaboracions,
            'columns' => $columns
        ]);
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
        try {
            if ($request->id) {
                $empresa_id = $request->id;
                $contactes = Contacte::where('contactes.empresa_id', '=', $empresa_id)
                    ->select('contactes.*')
                    ->get();
                return response()->json($contactes);
            }
        } catch (\Exception $exception) {
            return response()->json(['message' => 'There was an error retrieving the records'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $collaboracio = new Collaboracio;
        $collaboracio->empresa_id = $request->empresa;
        $collaboracio->contacte_id = $request->contacte;
        $collaboracio->cicle_id = $request->cicle;
        $collaboracio->any = $request->year;
        $collaboracio->comentaris = $request->comentaris;
        $collaboracio->user_id = $request->user()->id;

        $collaboracio->save();

        return redirect()->route('collaboracio_index')->with('status', 'Col·laboració ' . $collaboracio->id . ' editada!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $collaboracio = Collaboracio::find($id);
        $contactes = Contacte::all();
        $empreses = Empresa::all();
        $cicles = Cicle::all();
        $user = Auth::user();
        $year = date("Y") + 1;

        return view('collaboracio.edit', ['collaboracio' => $collaboracio, 'empreses' => $empreses, 'contactes' => $contactes, 'cicles' => $cicles, 'user' => $user, 'year' => $year]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $collaboracio = Collaboracio::find($id);
        $collaboracio->any = $request->year;
        $collaboracio->empresa_id = $request->empresa;
        $collaboracio->contacte_id = $request->contacte;
        $collaboracio->cicle_id = $request->cicle;
        $collaboracio->comentaris = $request->comentaris;

        $collaboracio->save();

        return redirect()->route('collaboracio_index')->with('status', 'Col·laboració ' . $collaboracio->id . ' modificada!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(int $id)
    {
        $collaboracio = Collaboracio::find($id);
        $collaboracio->delete();

        return redirect()->route('collaboracio_index')->with('status', 'Col·laboració ' . $collaboracio->id . ' eliminada!');
    }
}

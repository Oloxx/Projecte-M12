<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;


use App\Models\Empresa;
use App\Models\Contacte;
use App\Models\Collaboracio;
use App\Models\Cicle;

class CollaboracioController extends Controller
{

    private $columns = [
        ["label" => "Cicle", "field" => "cicle.nom"],
        ["label" => "Any", "field" => "any"],
        ["label" => "Empresa", "field" => "empresa.nom"],
        ["label" => "Contacte", "field" => "contacte.nom"],
        ["label" => "Usuari", "field" => "user.name"],
    ];


    /**
     * Display a listing of the resource.
     */

    public function index(String $cicle = '', String $empresa = '', String $any = '', String $contacte = '', String $usuari = '')
    {
        $year = date("Y") + 1;

        if ($cicle == '%') $cicle = '';
        if ($empresa == '%') $empresa = '';
        if ($any == '%') $any = '';
        if ($contacte == '%') $contacte = '';
        if ($usuari == '%')  $usuari = '';

        if ($cicle || $empresa || $any || $contacte || $usuari) {

            $search = true;
            $estadesFiltre = Collaboracio::filter($cicle, $any, $empresa, $contacte, $usuari);

            return Inertia::render('Collaboracio/Index', [
                'collaboracions' => $estadesFiltre,
                'columns' => $this->columns,
                'search' => $search,
                'year' => $year,
                'cicleColab' => $cicle,
                'empresaColab' => $empresa,
                'anyColab' => $any,
                'contacteColab' => $contacte,
                'usuariColab' => $usuari,
            ]);
        } else {


            $estades = Collaboracio::with('empresa', 'contacte', 'cicle', 'user')->orderBy('id', 'desc')->paginate(5);
            $search = false;

            return Inertia::render('Collaboracio/Index', [
                'collaboracions' => $estades,
                'columns' => $this->columns,
                'search' => $search,
                'year' => $year
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $id = null)
    {
        $contactes = Contacte::all();
        $cicles = Cicle::all();
        $user = Auth::user();
        $year = date("Y") + 1;

        if ($id) {
            $empresa = Empresa::where('id', $id)->with('poblacio', 'categoria', 'sector')->firstOrFail();
            return Inertia::render('Collaboracio/Create', [
                'empresa' => $empresa, 'contactes' => $contactes, 'cicles' => $cicles, 'user' => $user, 'year' => $year
            ]);
        } else {
            $empreses = Empresa::all();
            return Inertia::render('Collaboracio/Create', [
                'empreses' => $empreses, 'contactes' => $contactes, 'cicles' => $cicles, 'user' => $user, 'year' => $year
            ]);
        }
    }

    /**
     * Get contacts for create blade.
     */
    public function getContactes(Request $request)
    {
        try {
            if ($request->id) {
                $contactes = Contacte::where('empresa_id', $request->id)->with('empresa')->firstOrFail();
                return response()->json([
                    'contactes' => $contactes
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json(['message' => 'There was an error retrieving the records'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $year = date("Y") + 1;

        $rules = [
            'empresa_id' => ['required'],
            'contacte_id' => ['required'],
            'cicle_id' => ['required'],
            'any' => ['required', 'before_or_equal:' . $year],
        ];

        Validator::make($request->all(), $rules, $messages = [
            'empresa_id.required' => 'Selecciona una empresa.',
            'contacte_id.required' => 'Selecciona un contacte.',
            'cicle_id.required' => 'Selecciona un cicle.',
            'any.required' => 'Selecciona l\'any de l\'estada.',
            'any.before_or_equal' => 'L\'any ha de ser anterior a l\'any actual.',
        ])->validate();

        $collaboracio = new Collaboracio;
        $collaboracio->empresa_id = $request->empresa_id;
        $collaboracio->contacte_id = $request->contacte_id;
        $collaboracio->cicle_id = $request->cicle_id;
        $collaboracio->any = $request->any;
        $collaboracio->comentaris = $request->comentaris;
        if ($request->stars) {
            $collaboracio->stars = $request->stars;
        }
        $collaboracio->user_id = $request->user()->id;

        $collaboracio->save();

        return redirect()->route('empresa.show', ['id' => $collaboracio->empresa_id])->with('status', 'Estada a ' . $collaboracio->empresa->nom . ' desada!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $collaboracio = Collaboracio::where('id', $id)->with('empresa', 'contacte', 'cicle', 'user')->firstOrFail();
        $contactes = Contacte::all();
        $empreses = Empresa::all();
        $cicles = Cicle::all();
        $user = Auth::user();
        $year = date("Y") + 1;

        return Inertia::render('Collaboracio/Edit', [
            'collaboracio' => $collaboracio, 'empreses' => $empreses, 'contactes' => $contactes, 'cicles' => $cicles, 'user' => $user, 'year' => $year
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {

        $year = date("Y") + 1;
        $rules = [
            'empresa_id' => ['required'],
            'contacte_id' => ['required'],
            'cicle_id' => ['required'],
            'any' => ['required', 'before_or_equal:' . $year],
        ];

        Validator::make($request->all(), $rules, $messages = [
            'empresa_id.required' => 'Selecciona una empresa.',
            'contacte_id.required' => 'Selecciona un contacte.',
            'cicle_id.required' => 'Selecciona un cicle.',
            'any.required' => 'Selecciona l\'any de l\'estada.',
            'any.before_or_equal' => 'L\'any ha de ser anterior a l\'any actual.',
        ])->validate();

        $collaboracio = Collaboracio::find($id);
        $collaboracio->any = $request->any;
        $collaboracio->empresa_id = $request->empresa_id;
        $collaboracio->contacte_id = $request->contacte_id;
        $collaboracio->cicle_id = $request->cicle_id;
        if ($request->stars) {
            $collaboracio->stars = $request->stars;
        }
        $collaboracio->comentaris = $request->comentaris;

        $collaboracio->save();

        return redirect()->route('empresa.show', ['id' => $collaboracio->empresa_id])->with('status', 'Estada a ' . $collaboracio->empresa->nom . ' modificada!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(int $id)
    {
        $collaboracio = Collaboracio::find($id);
        $collaboracio->delete();

        return redirect()->route('collaboracio.index')->with('status', 'Estada a ' . $collaboracio->empresa->nom . ' eliminada!');
    }
}

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

    public function index(Request $request)
    {
        $year = date("Y") + 1;
        $nomCicleEstada = $request->cicle;
        $anyEstada = $request->any;
        $nomEmpresaEstada = $request->nom;
        $nomContacteEstada = $request->contacte;
        $nomUsuariEstada = $request->usuari;

        if ($request->isMethod('post')) {

            if ($nomCicleEstada || $anyEstada || $nomEmpresaEstada || $nomContacteEstada || $nomUsuariEstada) {

                if ($request->session()->exists('nomCicleEstada')) {
                    $request->session()->forget('nomCicleEstada');
                    session(['nomCicleEstada' => $nomCicleEstada]);
                } else {
                    session(['nomCicleEstada' => $nomCicleEstada]);
                }

                if ($request->session()->exists('anyEstada')) {
                    $request->session()->forget('anyEstada');
                    session(['anyEstada' => $anyEstada]);
                } else {
                    session(['anyEstada' => $anyEstada]);
                }

                if ($request->session()->exists('nomEmpresaEstada')) {
                    $request->session()->forget('nomEmpresaEstada');
                    session(['nomEmpresaEstada' => $nomEmpresaEstada]);
                } else {
                    session(['nomEmpresaEstada' => $nomEmpresaEstada]);
                }

                if ($request->session()->exists('nomContacteEstada')) {
                    $request->session()->forget('nomContacteEstada');
                    session(['nomContacteEstada' => $nomContacteEstada]);
                } else {
                    session(['nomContacteEstada' => $nomContacteEstada]);
                }

                if ($request->session()->exists('nomUsuariEstada')) {
                    $request->session()->forget('nomUsuariEstada');
                    session(['nomUsuariEstada' => $nomUsuariEstada]);
                } else {
                    session(['nomUsuariEstada' => $nomUsuariEstada]);
                }

                $search = true;
                $estadesFiltre = Collaboracio::filter($nomCicleEstada, $anyEstada, $nomEmpresaEstada, $nomContacteEstada, $nomUsuariEstada);
            
            } else {
                // Entra en el moment de paginar
                $search = true;

                $nomCicleEstada = $request->session()->get('nomCicleEstada');
                $anyEstada = $request->session()->get('anyEstada');
                $nomEmpresaEstada = $request->session()->get('nomEmpresaEstada');
                $nomContacteEstada = $request->session()->get('nomContacteEstada');
                $nomUsuariEstada = $request->session()->get('nomUsuariEstada');

                $estadesFiltre = Collaboracio::filter($nomCicleEstada, $anyEstada, $nomEmpresaEstada, $nomContacteEstada, $nomUsuariEstada);
            }

            return Inertia::render('Collaboracio/Index', [
                'collaboracions' => $estadesFiltre,
                'columns' => $this->columns,
                'search' => $search,
                'year' => $year
            ]);
        } else {

            if ($request->session()->exists('nomCicleEstada')) {
                $request->session()->forget('nomCicleEstada');
                session(['nomCicleEstada' => $nomCicleEstada]);
            }

            if ($request->session()->exists('anyEstada')) {
                $request->session()->forget('anyEstada');
                session(['anyEstada' => $anyEstada]);
            }

            if ($request->session()->exists('nomEmpresaEstada')) {
                $request->session()->forget('nomEmpresaEstada');
                session(['nomEmpresaEstada' => $nomEmpresaEstada]);
            }

            if ($request->session()->exists('nomContacteEstada')) {
                $request->session()->forget('nomContacteEstada');
                session(['nomContacteEstada' => $nomContacteEstada]);
            }

            if ($request->session()->exists('nomUsuariEstada')) {
                $request->session()->forget('nomUsuariEstada');
                session(['nomUsuariEstada' => $nomUsuariEstada]);
            }

            $estades = Collaboracio::with('empresa', 'contacte', 'cicle', 'user')->paginate(5);
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
    public function create(int $id)
    {
        $contactes = Contacte::all();
        $cicles = Cicle::all();
        $user = Auth::user();
        $year = date("Y") + 1;

        if($id){
            $empresa = Empresa::where('id', $id)->with('poblacio', 'categoria', 'sector')->firstOrFail();
            return Inertia::render('Collaboracio/Create', [
                'empresa' => $empresa, 'contactes' => $contactes, 'cicles' => $cicles, 'user' => $user, 'year' => $year
            ]);
        }else{
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
            'any' => ['required', 'before_or_equal:'.$year],
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
        $collaboracio->user_id = $request->user()->id;

        $collaboracio->save();

        return redirect()->route('collaboracio.index')->with('status', 'Estada a ' . $collaboracio->empresa->nom . ' desada!');
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
    public function update(Request $request, int $id) : RedirectResponse
    {

        $year = date("Y") + 1;
        $rules = [
            'empresa_id' => ['required'],
            'contacte_id' => ['required'],
            'cicle_id' => ['required'],
            'any' => ['required', 'before_or_equal:'.$year],
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
        $collaboracio->comentaris = $request->comentaris;

        $collaboracio->save();

        return redirect()->route('collaboracio.index')->with('status', 'Estada a ' . $collaboracio->empresa->nom . ' modificada!');
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

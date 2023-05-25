<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Empresa;
use App\Models\Contacte;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;


class ContacteController extends Controller
{

    private $columns = [
        ["label" => "Nom", "field" => "nom"],
        ["label" => "Cognoms", "field" => "cognoms"],
        ["label" => "Mòbil", "field" => "movil"],
        ["label" => "E-mail", "field" => "email"],
        ["label" => "Empresa", "field" => "empresa.nom"]
    ];

    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {

        if ($request->isMethod('post')) {

            $nomContacte = $request->nomContacte;
            $cognomsContacte = $request->cognoms;
            $nomEmpresaContacte = $request->empresaContacte;

            if ($nomContacte || $cognomsContacte || $nomEmpresaContacte) {

                if ($request->session()->exists('nomContacte')) {
                    $request->session()->forget('nomContacte');
                    session(['nomContacte' => $nomContacte]);
                } else {
                    session(['nomContacte' => $nomContacte]);
                }

                if ($request->session()->exists('cognomsContacte')) {
                    $request->session()->forget('cognomsContacte');
                    session(['cognomsContacte' => $cognomsContacte]);
                } else {
                    session(['cognomsContacte' => $cognomsContacte]);
                }

                if ($request->session()->exists('nomEmpresaContacte')) {
                    $request->session()->forget('nomEmpresaContacte');
                    session(['nomEmpresaContacte' => $nomEmpresaContacte]);
                } else {
                    session(['nomEmpresaContacte' => $nomEmpresaContacte]);
                }

                $search = true;
                $contactesFiltre = Contacte::filter($nomContacte, $cognomsContacte, $nomEmpresaContacte);
            } else {
                $search = true;
                $nomContacte = $request->session()->get('nomContacte');
                $cognomsContacte = $request->session()->get('cognomsContacte');
                $nomEmpresaContacte = $request->session()->get('nomEmpresaContacte');

                $contactesFiltre = Contacte::filter($nomContacte, $cognomsContacte, $nomEmpresaContacte);
            }

            return Inertia::render('Contacte/Index', [
                'contactes' => $contactesFiltre,
                'columns' => $this->columns,
                'search' => $search
            ]);
        } else {

            if ($request->session()->exists('nomContacte')) {
                $request->session()->forget('nomContacte');
            }

            if ($request->session()->exists('cognomsContacte')) {
                $request->session()->forget('cognomsContacte');
            }

            if ($request->session()->exists('nomEmpresaContacte')) {
                $request->session()->forget('nomEmpresaContacte');
            }

            $contactes = Contacte::with('empresa')->orderBy('nom')->paginate(5);
            $search = false;

            return Inertia::render('Contacte/Index', [
                'contactes' => $contactes,
                'columns' => $this->columns,
                'search' => $search
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $id)
    {
        $empresa = Empresa::where('id', $id)->with('poblacio', 'categoria', 'sector')->firstOrFail();

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
    public function store(Request $request) : RedirectResponse
    {

        $rules = [
            'nom' => ['required', 'max:30'],
            'cognoms' => ['required', 'max:60'],
            'movil' => ['required', 'numeric', 'digits_between:9,9'],
            'email' => ['required', 'email'],
            'empresa_id' => ['required'],
        ];

        Validator::make($request->all(), $rules, $messages = [
            'nom.required' => 'El nom del contacte és obligatori.',
            'cognoms.required' => 'Els cognoms del contacte són obligatoris.',
            'nom.max' => 'El nom del contacte ha de tenir com a màxim 30 caràcters.',
            'cognoms.max' => 'El nom del contacte ha de tenir com a màxim 60 caràcters.',
            'movil.required' => 'El camp telèfon és obligatori.',
            'movil.numeric' => 'El camp telèfon ha de ser de caràcter numèric.',
            'movil.digits_between' => 'El camp telèfon ha de contenir 9 dígits.',
            'email' => 'Aquest correu és incorrecte.',
            'empresa_id.required' => 'L\'assignació d\'empresa és obligatòria.',
        ])->validate();

        $contacte = new Contacte;
        $contacte->nom = $request->nom;
        $contacte->cognoms = $request->cognoms;
        $contacte->movil = $request->movil;
        $contacte->email = $request->email;
        $contacte->empresa_id = $request->empresa_id;

        $contacte->save();

        $empresa = Empresa::where('id', $contacte->empresa_id)->with('poblacio', 'categoria', 'sector')->firstOrFail();

        return redirect()->route('empresa.show', ['id' => $empresa->id])->with('status', 'Nou contacte ' . $contacte->nom . ' creat!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $contacte = Contacte::where('id', $id)->with('empresa')->firstOrFail();

        return Inertia::render('Contacte/Edit', [
            'contacte' => $contacte
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $rules = [
            'nom' => ['required', 'max:30'],
            'cognoms' => ['required', 'max:60'],
            'movil' => ['required', 'numeric', 'digits_between:9,9'],
            'email' => ['required', 'email'],
            'empresa_id' => ['required', 'numeric'],
        ];

        Validator::make($request->all(), $rules, $messages = [
            'nom.required' => 'El nom del contacte és obligatori.',
            'cognoms.required' => 'Els cognoms del contacte són obligatoris.',
            'nom.max' => 'El nom del contacte ha de tenir com a màxim 30 caràcters.',
            'cognoms.max' => 'El nom del contacte ha de tenir com a màxim 60 caràcters.',
            'movil.required' => 'El camp telèfon és obligatori.',
            'movil.numeric' => 'El camp telèfon ha de ser de caràcter numèric.',
            'movil.digits_between' => 'El camp telèfon ha de contenir 9 dígits.',
            'email' => 'Aquest correu és incorrecte.',
            'empresa_id.required' => 'L\'assignació d\'empresa és obligatòria.',
        ])->validate();

        $contacte = Contacte::where('id', $id)->with('empresa')->firstOrFail();
        $contacte->nom = $request->nom;
        $contacte->cognoms = $request->cognoms;
        $contacte->movil = $request->movil;
        $contacte->email = $request->email;
        $contacte->empresa_id = $request->empresa_id;

        $contacte->save();

        $empresa = Empresa::where('id', $contacte->empresa_id)->with('poblacio', 'categoria', 'sector')->firstOrFail();

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

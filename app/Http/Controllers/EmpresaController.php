<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Categoria;
use App\Models\Collaboracio;
use App\Models\Empresa;
use App\Models\Poblacio;
use App\Models\Sector;
use App\Models\Contacte;

class EmpresaController extends Controller
{
    private $columns = [
        ["label" => "Logo", "field" => "logo"],
        ["label" => "Nom", "field" => "nom"],
        ["label" => "Telèfon", "field" => "telefon"],
        ["label" => "Web", "field" => "web"],
        ["label" => "E-mail", "field" => "email"],
        ["label" => "Població", "field" => "poblacio.nom"],
        ["label" => "Categoria", "field" => "categoria.nom"],
        ["label" => "Sector", "field" => "sector.nom"]
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->isMethod('post')) {

            $nomEmpresa = $request->nom;
            $nomPoblacio = $request->poblacio;
            $nomSector = $request->sector;

            if ($nomEmpresa || $nomPoblacio || $nomSector) {

                if ($request->session()->exists('nomEmpresa')) {
                    $request->session()->forget('nomEmpresa');
                    session(['nomEmpresa' => $nomEmpresa]);
                } else {
                    session(['nomEmpresa' => $nomEmpresa]);
                }

                if ($request->session()->exists('nomPoblacio')) {
                    $request->session()->forget('nomPoblacio');
                    session(['nomPoblacio' => $nomPoblacio]);
                } else {
                    session(['nomPoblacio' => $nomPoblacio]);
                }

                if ($request->session()->exists('nomSector')) {
                    $request->session()->forget('nomSector');
                    session(['nomSector' => $nomSector]);
                } else {
                    session(['nomSector' => $nomSector]);
                }

                $search = true;
                $empresesFiltre = Empresa::filter($nomEmpresa, $nomPoblacio, $nomSector);

            } else {
                $search = true;
                $nomEmpresa = $request->session()->get('nomEmpresa');
                $nomPoblacio = $request->session()->get('nomPoblacio');
                $nomSector = $request->session()->get('nomSector');

                $empresesFiltre = Empresa::filter($nomEmpresa, $nomPoblacio, $nomSector);
            }

            return Inertia::render('Empresa/Index', [
                'empreses' => $empresesFiltre,
                'columns' => $this->columns,
                'search' => $search
            ]);

        } else {

            if ($request->session()->exists('nomEmpresa')) {
                $request->session()->forget('nomEmpresa');
            }

            if ($request->session()->exists('nomPoblacio')) {
                $request->session()->forget('nomPoblacio');
            }

            if ($request->session()->exists('nomSector')) {
                $request->session()->forget('nomSector');
            } 
            
            $empreses = Empresa::with('poblacio', 'categoria', 'sector')->orderBy('nom')->paginate(5);
            $search = false;

            return Inertia::render('Empresa/Index', [
                'empreses' => $empreses,
                'columns' => $this->columns,
                'search' => $search
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $poblacions = Poblacio::all();
        $categories = Categoria::all();
        $sectors = Sector::all();

        return Inertia::render('Empresa/Create', [
            'poblacions' => $poblacions,
            'categories' => $categories,
            'sectors' => $sectors
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $empresa = new Empresa;
        $empresa->nom = $request->nom;
        $empresa->telefon = $request->telefon;
        $empresa->web = $request->web;
        $empresa->email = $request->email;
        $empresa->poblacio_id = $request->poblacio_id;
        $empresa->categoria_id = $request->categoria_id;
        $empresa->sector_id = $request->sector_id;
        // TODO: FORM VALIDATIONS
        $empresa->save();

        return redirect()->route('empresa.show', ['id' => $empresa->id])->with('status', 'Nova empresa ' . $empresa->nom . ' creada!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $empresa = Empresa::where('nom', 'like', '')->with('poblacio', 'categoria', 'sector')->firstOrFail();

        $contactes = Contacte::where('empresa_id', $id)->paginate(5);

        $collaboracions = Collaboracio::where('empresa_id', $id)->with('empresa', 'contacte', 'cicle', 'user')->paginate(5);

        $columnsContacte = [
            ["label" => "Nom", "field" => "nom"],
            ["label" => "Cognoms", "field" => "cognoms"],
            ["label" => "Mòvil", "field" => "movil"],
            ["label" => "E-mail", "field" => "email"],
        ];

        $columnsCollaboracio = [
            ["label" => "Cicle", "field" => "cicle.nom"],
            ["label" => "Any", "field" => "any"],
            ["label" => "Empresa", "field" => "empresa.nom"],
            ["label" => "Contacte", "field" => "contacte.nom"],
            ["label" => "Usuari", "field" => "user.name"],
        ];

        return Inertia::render('Empresa/Show', [
            'empresa' => $empresa->load('poblacio', 'categoria', 'sector'),
            'contactes' => $contactes,
            'columnsContacte' => $columnsContacte,
            'collaboracions' => $collaboracions,
            'columnsCollaboracio' => $columnsCollaboracio
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $empresa = Empresa::where('id', $id)->with('poblacio', 'categoria', 'sector')->firstOrFail();
        $poblacions = Poblacio::all();
        $categories = Categoria::all();
        $sectors = Sector::all();

        return Inertia::render('Empresa/Edit', [
            'empresa' => $empresa->load('poblacio', 'categoria', 'sector'),
            'poblacions' => $poblacions,
            'categories' => $categories,
            'sectors' => $sectors
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $empresa = Empresa::find($id);
        $empresa->nom = $request->nom;
        $empresa->telefon = $request->telefon;
        $empresa->web = $request->web;
        $empresa->email = $request->email;
        $empresa->poblacio_id = $request->poblacio_id;
        $empresa->categoria_id = $request->categoria_id;
        $empresa->sector_id = $request->sector_id;

        $empresa->save();

        return redirect()->route('empresa.index')->with('status', 'Empresa ' . $empresa->nom . ' modificada!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(int $id)
    {
        $empresa = Empresa::find($id);
        $empresa->delete();

        return redirect()->route('empresa.index')->with('status', 'Empresa ' . $empresa->nom . ' eliminada!');
    }

    /**
     * Filters
     */

    /* public function search(Request $request)
    {
        if ($request->isMethod('post')){
            $nomEmpresa = $request->nom;
            $nomPoblacio = $request->poblacio;
            $nomSector = $request->sector;

            if ($nomEmpresa || $nomPoblacio || $nomSector) {

                $empreses = Empresa::filter($nomEmpresa, $nomPoblacio, $nomSector);
                if ($request->session()->exists('empreses')) {
                    $request->session()->forget('empreses');
                    session(['empreses' => $empreses]);
                } else {
                    session(['empreses' => $empreses]);
                }
            } else {

                if ($request->session()->exists('empreses')) {
                    $request->session()->forget('empreses');
                }
            }

            return redirect()->route('empresa.index');
        } else {
            dd('hola');
            if ($request->session()->exists('empreses')) {
                $request->session()->forget('empreses');
            }

            return redirect()->route('empresa.index');
        }
    } */
}

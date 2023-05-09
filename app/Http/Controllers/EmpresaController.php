<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;


use App\Models\Categoria;
use App\Models\Collaboracio;
use App\Models\Empresa;
use App\Models\Poblacio;
use App\Models\Sector;
use App\Models\Contacte;


class EmpresaController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $columns = [
            ["label" => "Logo", "field" => "logo"],
            ["label" => "Nom", "field" => "nom"],
            ["label" => "Telèfon", "field" => "telefon"],
            ["label" => "Web", "field" => "web"],
            ["label" => "E-mail", "field" => "email"],
            ["label" => "Població", "field" => "poblacio.nom"],
            ["label" => "Categoria", "field" => "categoria.nom"],
            ["label" => "Sector", "field" => "sector.nom"]
        ];

        if ($request->session()->exists('empreses')) {
            $data = session('empreses');

            if ($request->session()->exists('empreses')) {
                session()->forget('empreses');
            }
            return Inertia::render('Empresa/Index', [
                'empreses' => $data,
                'columns' => $columns,
                'search' => true
            ]);

        } else {

            $empreses = Empresa::with('poblacio', 'categoria', 'sector')->orderBy('nom')->paginate(5);
            return Inertia::render('Empresa/Index', [
                'empreses' => $empreses,
                'columns' => $columns,
                'search' => false
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
        $empresa->poblacio_id = $request->poblacio_id['id'];
        $empresa->categoria_id = $request->categoria_id;
        $empresa->sector_id = $request->sector_id;
        // TODO: FORM VALIDATIONS
        $empresa->save();

        return redirect()->route('empresa.show', ['id' => $empresa->id])->with('status', 'Nova empresa ' . $empresa->nom . ' creada!');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {

        $empresa = Empresa::where('id', $id)->with('poblacio', 'categoria', 'sector')->firstOrFail();

        $contactes = Contacte::where('empresa_id', $id)->paginate(5);

        $collaboracions = Collaboracio::where('empresa_id', $id)->with('empresa', 'contacte', 'cicle', 'user')->paginate(5);

        $columnsContacte = [
            ["label" => "Nom", "field" => "nom"],
            ["label" => "Cognoms", "field" => "cognoms"],
            ["label" => "Mòbil", "field" => "movil"],
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
        $empresa->poblacio_id = $request->poblacio_id['id'];
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

    public function search(Request $request)
    {
        if ($request->session()->exists('empreses')) {
            session()->forget('empreses');
        }

        if ($request->isMethod('post')) {

            $empreses = null;
            
            $request->session()->put('empreses', $empreses);

            $nomEmpresa = $request->nom;
            $nomPoblacio = $request->poblacio;
            $nomSector = $request->sector;

            if ($nomEmpresa && !$nomPoblacio && !$nomSector) {
                $empreses = Empresa::where('nom', 'LIKE', '%' . $nomEmpresa . '%')->with('poblacio', 'categoria', 'sector')->orderBy('nom')->paginate(5);
            } else if ($nomPoblacio && !$nomEmpresa && !$nomSector) {

                $empreses = Empresa::join('poblacions', 'empreses.poblacio_id', '=', 'poblacions.id')
                    ->where('poblacions.nom', 'LIKE', '%' . $nomPoblacio . '%')->with('poblacio', 'categoria', 'sector')
                    ->select('empreses.*')
                    ->orderBy('empreses.nom')->paginate(5);
            } else if ($nomSector && !$nomEmpresa && !$nomPoblacio) {

                $empreses = Empresa::join('sectors', 'empreses.sector_id', '=', 'sectors.id')
                    ->where('sectors.nom', 'LIKE', '%' . $nomSector . '%')->with('poblacio', 'categoria', 'sector')
                    ->select('empreses.*')
                    ->orderBy('empreses.nom')->paginate(5);

            } else if ($nomEmpresa && $nomPoblacio && !$nomSector) {
                $empreses = Empresa::join('poblacions', 'empreses.poblacio_id', '=', 'poblacions.id')
                    ->where('poblacions.nom', 'LIKE', '%' . $nomPoblacio . '%')
                    ->where('empreses.nom', 'LIKE', '%' . $nomEmpresa . '%')
                    ->with('poblacio', 'categoria', 'sector')
                    ->select('empreses.*')
                    ->orderBy('empreses.nom')->paginate(5);

            } else if ($nomEmpresa && $nomSector && !$nomPoblacio) {

                $empreses = Empresa::join('sectors', 'empreses.sector_id', '=', 'sectors.id')
                    ->select('empreses.*')
                    ->where('empreses.nom', 'LIKE', '%' . $nomEmpresa . '%')
                    ->where('sectors.nom', 'LIKE', '%' . $nomSector . '%')
                    ->with('poblacio', 'categoria', 'sector')
                    ->orderBy('empreses.nom')->paginate(5);
            } else if ($nomPoblacio && $nomSector && !$nomEmpresa) {

                $empreses = Empresa::join('sectors', 'empreses.sector_id', '=', 'sectors.id')
                    ->join('poblacions', 'empreses.poblacio_id', '=', 'poblacions.id')
                    ->select('empreses.*')
                    ->where('poblacions.nom', 'LIKE', '%' . $nomPoblacio . '%')
                    ->where('sectors.nom', 'LIKE', '%' . $nomSector . '%')
                    ->with('poblacio', 'categoria', 'sector')
                    ->orderBy('empreses.nom')->paginate(5);
            } else if ($nomPoblacio && $nomSector && $nomEmpresa) {

                $empreses = Empresa::join('sectors', 'empreses.sector_id', '=', 'sectors.id')
                    ->join('poblacions', 'empreses.poblacio_id', '=', 'poblacions.id')
                    ->select('empreses.*')
                    ->where('empreses.nom', 'LIKE', '%' . $nomEmpresa . '%')
                    ->where('poblacions.nom', 'LIKE', '%' . $nomPoblacio . '%')
                    ->where('sectors.nom', 'LIKE', '%' . $nomSector . '%')
                    ->with('poblacio', 'categoria', 'sector')
                    ->orderBy('empreses.nom')->paginate(5);
            }

            session(['empreses' => $empreses]);

            Redirect::to('posts')->with('variable','this is a new value');

        } else {
            return redirect()->route('empresa.index');
        }
    }
}

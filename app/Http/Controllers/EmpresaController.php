<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

use App\Models\Categoria;
use App\Models\Collaboracio;
use App\Models\Empresa;
use App\Models\Poblacio;
use App\Models\Sector;
use App\Models\Contacte;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
            'sectors' => $sectors,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'nom' => 'required|min:1|max:255',
            'telefon' => 'required|numeric|digits_between:9,9',
            'email' => 'nullable|email',
            'web' => 'nullable|regex:/^[a-zA-Z]+\.[a-zA-Z]/',
            'poblacio_id' => 'required',
            'categoria_id' => 'required',
            'sector_id' => 'required',
        ];

        Validator::make($request->all(), $rules, $messages = [
            'required' => 'El camp :attribute és obligatori.',
            'nom.required' => 'El nom de l\'empresa és obligatori.',
            'telefon.required' => 'El camp telèfon és obligatori.',
            'telefon.numeric' => 'El camp telèfon ha de ser de caràcter numèric.',
            'telefon.digits_between' => 'El camp telèfon ha de contenir 9 dígits.',
            'min' => 'El nom de l\'empresa ha de tenir com a mínim :min caràcters.',
            'max' => 'El nom de l\'empresa ha de tenir com a màxim :man caràcters.',
            'email' => 'Aquest correu és incorrecte.',
            'web' => 'Aquesta URL és incorrecta.',
        ])->validate();

        $empresa = new Empresa;
        $empresa->nom = $request->nom;
        $empresa->telefon = $request->telefon;
        $empresa->web = $request->web;
        $empresa->email = $request->email;
        $empresa->poblacio_id = $request->poblacio_id['id'];
        $empresa->categoria_id = $request->categoria_id;
        $empresa->sector_id = $request->sector_id;
        if ($request->hasFile('logo')) {
            $empresa->logo = $this->uploadLogo($request->logo);;
        }

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
    public function update(Request $request, int $id): RedirectResponse
    {

        $rules = [
            'nom' => 'required|min:1|max:255',
            'telefon' => 'required|numeric|digits_between:9,9',
            'email' => 'nullable|email',
            'web' => 'nullable|regex:/^[a-zA-Z]+\.[a-zA-Z]/',
            'poblacio_id' => 'required',
            'categoria_id' => 'required',
            'sector_id' => 'required',
        ];

        Validator::make($request->all(), $rules, $messages = [
            'required' => 'El camp :attribute és obligatori.',
            'nom.required' => 'El nom de l\'empresa és obligatori.',
            'telefon.required' => 'El camp telèfon és obligatori.',
            'telefon.numeric' => 'El camp telèfon ha de ser de caràcter numèric.',
            'telefon.digits_between' => 'El camp telèfon ha de contenir 9 dígits.',
            'min' => 'El nom de l\'empresa ha de tenir com a mínim :min caràcters.',
            'max' => 'El nom de l\'empresa ha de tenir com a màxim :man caràcters.',
            'email' => 'Aquest correu és incorrecte.',
            'web' => 'Aquesta URL és incorrecta.',
        ])->validate();   

        $empresa = Empresa::find($id);
        $empresa->nom = $request->nom;
        $empresa->telefon = $request->telefon;
        $empresa->web = $request->web;
        $empresa->email = $request->email;
        $empresa->poblacio_id = $request->poblacio_id['id'];
        $empresa->categoria_id = $request->categoria_id;
        $empresa->sector_id = $request->sector_id;
        if ($request->hasFile('logo')) {
            $empresa->logo = $this->uploadLogo($request->logo);;
        }
        

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

    private function uploadLogo($logo)
    {
        $uploadedFileUrl = Cloudinary::upload($logo->getRealPath())->getSecurePath();

        return $uploadedFileUrl;
    }

    public function removeLogo(int $id)
    {
        $empresa = Empresa::find($id);
        if ($empresa->logo) {
            $path = str_replace('/storage', 'public', $empresa->logo);
            if (Storage::exists($path)) {
                Storage::delete($path);
            }
            $empresa->logo = null;
            $empresa->save();
        }
    }

    public function importCSV(Request $request)
    {
        $request->validate([
            'csv' => 'required|mimes:csv,txt',
        ]);
        if ($request->hasFile('csv')) {
            try {
                DB::beginTransaction();

                $csv = $request->file('csv')->getRealPath();
                $data = array_map('str_getcsv', file($csv));

                foreach ($data as $row) {
                    $empresa = new Empresa();
                    $empresa->nom = $row[0];
                    $empresa->telefon = $row[1];
                    $empresa->web = $row[2] === '' ? null : $row[2];
                    $empresa->email = $row[3];
                    $empresa->logo = $row[4] === '' ? null : $row[4];
                    $empresa->poblacio_id = $row[5];
                    $empresa->categoria_id = $row[6];
                    $empresa->sector_id = $row[7];

                    $empresa->save();
                }

                DB::commit();

                return redirect()->route('empresa.index')->with('status', 'Les dades s\'han importat correctament');
            } catch (\Exception $e) {
                DB::rollBack();

                // Error occurred, no empresas were saved
                return redirect()->route('profile.edit')->with('error', 'Error en importar empreses: '.$e->getMessage());
            }
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Empresa extends Model
{
    use HasFactory;
    // property that refers to the class name
    protected $table = 'empreses';

    /**
     * Get the comments for the blog post.
     */
    public function contactes(): HasMany
    {
        return $this->hasMany(Contacte::class);
    }

    public function poblacio(): BelongsTo
    {
        return $this->belongsTo(Poblacio::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }

    // Querys

    public static function searchByName($nomEmpresa)
    {
        return Empresa::where('nom', 'LIKE', '%' . $nomEmpresa . '%')->with('poblacio', 'categoria', 'sector')->orderBy('nom')->paginate(5);
    }

    public static function searchByPoblacio($nomPoblacio)
    {
        return Empresa::join('poblacions', 'empreses.poblacio_id', '=', 'poblacions.id')
            ->where('poblacions.nom', 'LIKE', '%' . $nomPoblacio . '%')->with('poblacio', 'categoria', 'sector')
            ->select('empreses.*')
            ->orderBy('empreses.nom')->paginate(5);
    }

    public static function searchBySector($nomSector)
    {
        return Empresa::join('sectors', 'empreses.sector_id', '=', 'sectors.id')
            ->where('sectors.nom', 'LIKE', '%' . $nomSector . '%')->with('poblacio', 'categoria', 'sector')
            ->select('empreses.*')
            ->orderBy('empreses.nom')->paginate(5);
    }

    public static function searchByNameAndPoblacio($nomEmpresa, $nomPoblacio)
    {
        return Empresa::join('poblacions', 'empreses.poblacio_id', '=', 'poblacions.id')
            ->where('poblacions.nom', 'LIKE', '%' . $nomPoblacio . '%')
            ->where('empreses.nom', 'LIKE', '%' . $nomEmpresa . '%')
            ->with('poblacio', 'categoria', 'sector')
            ->select('empreses.*')
            ->orderBy('empreses.nom')->paginate(5);
    }

    public static function searchByNameAndSector($nomEmpresa, $nomSector)
    {
        return Empresa::join('sectors', 'empreses.sector_id', '=', 'sectors.id')
            ->select('empreses.*')
            ->where('empreses.nom', 'LIKE', '%' . $nomEmpresa . '%')
            ->where('sectors.nom', 'LIKE', '%' . $nomSector . '%')
            ->with('poblacio', 'categoria', 'sector')
            ->orderBy('empreses.nom')->paginate(5);
    }

    public static function searchByPoblacioAndSector($nomPoblacio, $nomSector)
    {
        return Empresa::join('sectors', 'empreses.sector_id', '=', 'sectors.id')
            ->join('poblacions', 'empreses.poblacio_id', '=', 'poblacions.id')
            ->select('empreses.*')
            ->where('poblacions.nom', 'LIKE', '%' . $nomPoblacio . '%')
            ->where('sectors.nom', 'LIKE', '%' . $nomSector . '%')
            ->with('poblacio', 'categoria', 'sector')
            ->orderBy('empreses.nom')->paginate(5);
    }

    public static function searchByAll($nomPoblacio, $nomSector, $nomEmpresa)
    {
        return Empresa::join('sectors', 'empreses.sector_id', '=', 'sectors.id')
            ->join('poblacions', 'empreses.poblacio_id', '=', 'poblacions.id')
            ->select('empreses.*')
            ->where('empreses.nom', 'LIKE', '%' . $nomEmpresa . '%')
            ->where('poblacions.nom', 'LIKE', '%' . $nomPoblacio . '%')
            ->where('sectors.nom', 'LIKE', '%' . $nomSector . '%')
            ->with('poblacio', 'categoria', 'sector')
            ->orderBy('empreses.nom')->paginate(5);
    }

    public static function filter($nomEmpresa, $nomPoblacio, $nomSector)
    {
        if ($nomEmpresa && !$nomPoblacio && !$nomSector) {
            return Empresa::searchByName($nomEmpresa);
        } else if ($nomPoblacio && !$nomEmpresa && !$nomSector) {
            return Empresa::searchByPoblacio($nomPoblacio);
        } else if ($nomSector && !$nomEmpresa && !$nomPoblacio) {
            return Empresa::searchBySector($nomSector);
        } else if ($nomEmpresa && $nomPoblacio && !$nomSector) {
            return Empresa::searchByNameAndPoblacio($nomEmpresa, $nomPoblacio);
        } else if ($nomEmpresa && $nomSector && !$nomPoblacio) {
            return Empresa::searchByNameAndSector($nomEmpresa, $nomSector);
        } else if ($nomPoblacio && $nomSector && !$nomEmpresa) {
            return Empresa::searchByPoblacioAndSector($nomPoblacio, $nomSector);
        } else if ($nomPoblacio && $nomSector && $nomEmpresa) {
            return Empresa::searchByAll($nomPoblacio, $nomSector, $nomEmpresa);
        }
    }
}

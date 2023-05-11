<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contacte extends Model
{
    use HasFactory;

    /**
     * Get the post that owns the comment.
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    // Querys

    public static function searchByNomContacte($nomContacte)
    {
        return Contacte::where('nom', 'LIKE', '%' . $nomContacte . '%')->with('empresa')->orderBy('nom')->paginate(5);
    }

    public static function searchByCognomsContacte($cognomsContacte)
    {
        return Contacte::where('cognoms', 'LIKE', '%' . $cognomsContacte . '%')->with('empresa')->orderBy('nom')->paginate(5);
    }

    public static function searchByEmpresaContacte($nomEmpresa)
    {
        return Contacte::join('empreses', 'empreses.id', '=', 'contactes.empresa_id')
            ->where('empreses.nom', 'LIKE', '%' . $nomEmpresa . '%')
            ->select('contactes.*')
            ->with('empresa')
            ->orderBy('contactes.nom')->paginate(5);
    }

    public static function searchByNomCognomsContacte($nomContacte, $cognomsContacte)
    {
        return Contacte::where('nom', 'LIKE', '%' . $nomContacte . '%')
            ->where('cognoms', 'LIKE', '%' . $cognomsContacte . '%')
            ->with('empresa')
            ->orderBy('nom')
            ->paginate(5);
    }

    public static function searchByNomContacteAndEmpresa($nomContacte, $nomEmpresa)
    {
        return Contacte::join('empreses', 'empreses.id', '=', 'contactes.empresa_id')
            ->where('contactes.nom', 'LIKE', '%' . $nomContacte . '%')
            ->where('empreses.nom', 'LIKE', '%' . $nomEmpresa . '%')
            ->select('contactes.*')
            ->with('empresa')
            ->orderBy('contactes.nom')->paginate(5);
    }

    public static function searchByCognomsContacteAndEmpresa($cognomsContacte, $nomEmpresa)
    {
        return Contacte::join('empreses', 'empreses.id', '=', 'contactes.empresa_id')
            ->where('contactes.cognoms', 'LIKE', '%' . $cognomsContacte . '%')
            ->where('empreses.nom', 'LIKE', '%' . $nomEmpresa . '%')
            ->select('contactes.*')
            ->with('empresa')
            ->orderBy('contactes.nom')->paginate(5);
    }

    public static function searchByNomCognomsContacteAndEmpresa($nomContacte, $cognomsContacte, $nomEmpresa)
    {
        return Contacte::join('empreses', 'empreses.id', '=', 'contactes.empresa_id')
            ->where('contactes.nom', 'LIKE', '%' . $nomContacte . '%')
            ->where('contactes.cognoms', 'LIKE', '%' . $cognomsContacte . '%')
            ->where('empreses.nom', 'LIKE', '%' . $nomEmpresa . '%')
            ->select('contactes.*')
            ->with('empresa')
            ->orderBy('contactes.nom')->paginate(5);
    }

    public static function filter($nomContacte, $cognomsContacte, $nomEmpresa)
    {
        if ($nomContacte && !$cognomsContacte && !$nomEmpresa) {
            return Contacte::searchByNomContacte($nomContacte);
        } else if ($cognomsContacte && !$nomContacte && !$nomEmpresa) {
            return Contacte::searchByCognomsContacte($cognomsContacte);
        } else if ($nomEmpresa && !$nomContacte && !$cognomsContacte) {
            return Contacte::searchByEmpresaContacte($nomEmpresa);
        } else if ($nomContacte && $cognomsContacte && !$nomEmpresa) {
            return Contacte::searchByNomCognomsContacte($nomContacte, $cognomsContacte);
        } else if ($nomContacte && $nomEmpresa && !$cognomsContacte) {
            return Contacte::searchByNomContacteAndEmpresa($nomContacte, $nomEmpresa);
        } else if ($cognomsContacte && $nomEmpresa && !$nomContacte) {
            return Contacte::searchByCognomsContacteAndEmpresa($cognomsContacte, $nomEmpresa);
        } else if ($cognomsContacte && $nomEmpresa && $nomContacte) {
            return Contacte::searchByNomCognomsContacteAndEmpresa($cognomsContacte, $nomEmpresa, $nomContacte);
        }
    }
}

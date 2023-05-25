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

    public static function filter($nomContacte, $cognomsContacte, $nomEmpresa)
    {
        return Contacte::join('empreses', 'empreses.id', '=', 'contactes.empresa_id')
            ->where('contactes.nom', 'LIKE', '%' . $nomContacte . '%')
            ->where('contactes.cognoms', 'LIKE', '%' . $cognomsContacte . '%')
            ->where('empreses.nom', 'LIKE', '%' . $nomEmpresa . '%')
            ->select('contactes.*')
            ->with('empresa')
            ->orderBy('contactes.nom')->paginate(5);

    }
}

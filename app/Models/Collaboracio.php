<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaboracio extends Model
{
    use HasFactory;

    protected $table = 'collaboracions';

    /**
     * Get the empresa that owns the collaboracio.
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function contacte()
    {
        return $this->belongsTo(Contacte::class);
    }

    public function cicle()
    {
        return $this->belongsTo(Cicle::class);
    }

    public function curs()
    {
        return $this->belongsTo(Curs::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Querys

    public static function filter($nomCicleEstada, $anyEstada, $nomEmpresaEstada, $nomContacteEstada, $nomUsuariEstada)
    {
        $query =  Collaboracio::join('contactes', 'collaboracions.contacte_id', '=', 'contactes.id')
            ->join('empreses', 'collaboracions.empresa_id', '=', 'empreses.id')
            ->join('cicles', 'collaboracions.cicle_id', '=', 'cicles.id')
            ->join('users', 'collaboracions.user_id', '=', 'users.id')
            ->select('collaboracions.*')
            ->where(function ($query) use ($nomCicleEstada) {
                $query->where('cicles.nom', 'LIKE', '%' . $nomCicleEstada . '%')
                        ->orWhere('cicles.codi', 'LIKE', '%' . $nomCicleEstada . '%');
            })            
            ->where('empreses.nom', 'LIKE', '%' . $nomEmpresaEstada . '%')
            ->where('contactes.nom', 'LIKE', '%' . $nomContacteEstada . '%')
            ->where('users.name', 'LIKE', '%' . $nomUsuariEstada . '%')
            ->with('empresa', 'contacte', 'cicle', 'user')
            ->orderBy('collaboracions.id', 'desc');

        if ($anyEstada) {
            $query = $query->where('collaboracions.any', '=', $anyEstada)->paginate(5);
        } else {
            $query = $query->paginate(5);
        }

        return $query;
    }
}

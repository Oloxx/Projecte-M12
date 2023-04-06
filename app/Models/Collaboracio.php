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

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Poblacio extends Model
{
    use HasFactory;

    // property that refers to the class name
    protected $table = 'poblacions';

    /**
    * Get the post that owns the Comarca.
    */
    public function comarca(): BelongsTo
    {
        return $this->belongsTo(Comarca::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Comarca extends Model
{
    use HasFactory;

    /**
    * Get the post that owns the Comarca.
    */
    public function provincia(): BelongsTo
    {
        return $this->belongsTo(Provincia::class);
    }

}

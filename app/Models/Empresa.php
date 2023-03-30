<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

}

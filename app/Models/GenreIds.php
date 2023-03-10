<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenreIds extends Model
{
    use HasFactory;
    protected $table = 'genre_ids';

    function contents()
    {
        return $this->hasMany(Content::class, 'id', 'content_id');
    }
}

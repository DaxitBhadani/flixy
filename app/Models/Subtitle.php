<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtitle extends Model
{
    use HasFactory;
    protected $table = 'subtitles';

    function languages()
    {
        return $this->hasOne(Language::class, 'id' , 'title');
    }
}

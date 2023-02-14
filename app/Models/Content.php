<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
     use HasFactory;
     protected $table = 'contents';

     function language()
     {
          return $this->hasOne(Language::class, 'id', 'language');
     }

     function genres()
     {
          return $this->hasOne(Genre::class, 'id', 'genres');
     }

     function genres_ids()
     {
          return $this->hasOne(Genre::class, 'id', 'genres',);
     }
}

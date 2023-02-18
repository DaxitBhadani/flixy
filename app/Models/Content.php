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

     function sources()
     {
          return $this->hasMany(Source::class, 'movie_id', 'id');
     }

     function casts()
     {
          return $this->hasMany(Cast::class, 'movie_id', 'id');
     }

     function subtitles()
     {
          return $this->hasMany(Subtitle::class, 'movie_id', 'id');
     }

     function seasons()
     {
          return $this->hasMany(Season::class, 'series_id', 'id');
     }

}

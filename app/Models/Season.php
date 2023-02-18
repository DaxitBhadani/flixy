<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;
    protected $table = 'seasons';

    function episodes()
    {
         return $this->hasMany(Episode::class, 'season_id', 'id');
    }

   
    function episodeSubtitles()
    {
         return $this->hasMany(EpisodeSubtitle::class, 'episode_id', 'id');
    }
}

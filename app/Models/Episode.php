<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    function episodeSources()
    {
         return $this->hasMany(EpisodeSource::class, 'episode_id', 'id');
    }

    function episodeSubtitles()
    {
         return $this->hasMany(EpisodeSubtitle::class, 'episode_id', 'id');
    }
}

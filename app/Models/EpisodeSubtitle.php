<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EpisodeSubtitle extends Model
{
    use HasFactory;
    protected $table = 'episode_subtitles';
    
    function languages()
    {
        return $this->hasOne(Language::class, 'id' , 'title');
    }
}

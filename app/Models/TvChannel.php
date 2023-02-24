<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TvChannel extends Model
{
    use HasFactory;
    protected $table = 'tv_channels';

    // function tvCategories()
    // {
    //     return $this->hasMany(TvCategory::class, 'id', 'category_ids');
    // }

    function tvCategories()
    {
        return $this->hasOne(TvCategoryIds::class, 'tv_channel_id', 'id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TvCategoryIds extends Model
{
    use HasFactory;
    protected $table = 'tv_category_ids';

    function tvChannels()
    {
        return $this->hasOne(TvChannel::class, 'id' , 'tv_channel_id');
    }

    function category()
    {
        return $this->hasOne(TvCategory::class, 'id', 'tv_category_id');
    }

}

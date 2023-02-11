<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'cat_img',
        'cat_title',
    ];

    function musics()
    {
        return $this->hasMany(Music::class, 'category_id' , 'id');
    }
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    function postCount(){
        return $this->hasMany('App\Models\Post', 'category_id', 'id')->count();
    }
}

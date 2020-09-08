<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    function getUser(){
        return $this->hasOne('App\Models\User', 'id', 'writer_id');
    }

    function getCategory(){
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }
}

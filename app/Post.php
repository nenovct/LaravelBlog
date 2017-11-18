<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //relação entre tabelas 
    public function category()
    {
        return $this->belongsTo('App\category');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}

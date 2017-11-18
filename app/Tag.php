<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function posts()
    {
        //BelongsToMany('App\Post','Name_of_Table','tag_id','post_id')
        return $this->BelongsToMany('App\Post');
    }
}

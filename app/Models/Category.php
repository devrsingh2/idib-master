<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

//    protected $with = ['trans'];

    public function trans()
    {
        return $this->hasMany('App\Models\SubCategory', 'category_id')->select("*");
    }

}

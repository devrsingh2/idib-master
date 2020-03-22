<?php

namespace Idib\Suits\Models;

use Illuminate\Database\Eloquent\Model;

class SuitCategory extends Model
{
    protected $table = 'suit_categories';

//    protected $with = ['trans'];

    /*public function trans()
    {
        return $this->hasMany('Idib\Suits\Models\SubCategory', 'category_id')->select("*");
    }*/

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

}

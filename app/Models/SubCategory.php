<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'sub_categories';

//    protected $with = ['parent'];

    public function parent()
    {
        return $this->belongsTo('App\Models\Category');
    }
}

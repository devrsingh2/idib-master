<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'sub_categories';

    protected $with = ['parent'];

    public function parent()
    {
        /*return $this->belongsTo('App\Models\Category', 'category_id', 'id')
            ->select('name');*/
        return $this->belongsTo('App\Models\Category', 'category_id')->select(['id', 'name']);
    }

    public function scopeFilterCategory($query, $id)
    {
        return $query->whereHas('category_id', $id)->get();
    }

}

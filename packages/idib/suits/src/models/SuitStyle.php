<?php

namespace Idib\Suits\Models;

use Illuminate\Database\Eloquent\Model;

class SuitStyle extends Model
{
    protected $table = 'suit_styles';
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return $this
     */
    public function trans()
    {
        return $this->hasMany('\Idib\Suits\Models\SuitStyleAttribute', 'style_id')
            ->select("*")
            ->orderBy('order_id', 'asc');
    }

}

<?php

namespace Idib\Suits\Models;

use Illuminate\Database\Eloquent\Model;

class SuitAccent extends Model
{
    protected $table = 'suit_accents';
    
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
        return $this->hasMany('\Idib\Suits\Models\SuitAccentAttribute', 'accent_id')
            ->select("*")
            ->orderBy('order_id', 'asc');
    }

}

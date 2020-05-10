<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Phased\State\Traits\Vuexable;
use Sushi\Sushi;

class Version extends Model
{
    use Vuexable, Sushi;

    public $rows = [
        [ 'id' => 1, 'branch' => 'master' ]
    ];

    // public function getRows() {
    //     return $this->data;
    // }

    public function scopeByTag($query, $tag)
    {
        return $query->where('branch', $tag);
    }

    public function sections()
    {
        return $this->hasMany('App\Section');
    }
}

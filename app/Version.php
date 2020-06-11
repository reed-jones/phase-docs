<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Phased\State\Traits\Vuexable;
use Sushi\Sushi;

class Version extends Model
{
    use Vuexable, Sushi;

    protected $rows = [
        [ 'id' => 1, 'branch' => 'master' ],
    ];

    public function scopeByTag($query, $tag)
    {
        return $query->where('branch', $tag);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}

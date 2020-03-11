<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Phased\State\Traits\Vuexable;
use Sushi\Sushi;

class Section extends Model
{
    use Vuexable, Sushi;

    protected $rows = [
        [
            'version_id' => 1,
            'slug' => 'getting-started',
            'title' => 'Getting Started'
        ],
        [
            'version_id' => 1,
            'slug' => 'what-is-phase',
            'title' => 'What Is Phase'
        ],
        [
            'version_id' => 1,
            'slug' => 'routing',
            'title' => 'Routing'
        ],
        [
            'version_id' => 1,
            'slug' => 'state-management',
            'title' => 'State Management'
        ],
        [
            'version_id' => 1,
            'slug' => 'module-loaders',
            'title' => 'Module Loaders'
        ],
        [
            'version_id' => 1,
            'slug' => 'server-side-rendering',
            'title' => 'Server Side Rendering'
        ]
    ];

    public function version()
    {
        return $this->belongsTo('App\Version');
    }

    public function getContentAttribute()
    {
        return $this->attributes['content'] = Storage::get("docs/{$this->version->branch}/{$this->slug}.md");
    }

    public function hasContent()
    {
        return Storage::exists("docs/{$this->version->branch}/{$this->slug}.md");
    }
}

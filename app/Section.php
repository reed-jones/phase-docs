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
            'title' => 'Getting Started',
        ],
        [
            'version_id' => 1,
            'slug' => 'what-is-phase',
            'title' => 'What Is Phase',
        ],
        [
            'version_id' => 1,
            'slug' => 'routing',
            'title' => 'Routing',
        ],
        [
            'version_id' => 1,
            'slug' => 'state-management',
            'title' => 'State Management',
        ],
        [
            'version_id' => 1,
            'slug' => 'server-side-rendering',
            'title' => 'Server Side Rendering',
        ],
        [
            'version_id' => 1,
            'slug' => 'api',
            'title' => 'API',
        ],
    ];

    public function version()
    {
        return $this->belongsTo(Version::class);
    }

    public function getContentAttribute()
    {
        $path = "docs/{$this->version->branch}/{$this->slug}.md";
        return $this->attributes['content'] = Storage::get($path);
    }

    public function hasContent()
    {
        $path = "docs/{$this->version->branch}/{$this->slug}.md";
        return Storage::exists($path);
    }

    protected function getSectionWithContent($version_id, $section_slug)
    {
        $section = Section::query()
            ->where([
                'version_id' => $version_id,
                'slug' => $section_slug,
            ])
            ->firstOrFail();

        if (! $section->hasContent()) {
            abort(404);
        }

        return $section->append('content');
    }
}

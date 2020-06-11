<?php

namespace App\VuexLoaders;

use App\Section;
use App\Version;
use Phased\State\Support\VuexLoader;

class PhaseDocsModuleLoader extends VuexLoader
{
    protected $namespace = 'phase/docs';

    public function active($section)
    {
        return $section;
    }

    public function sections()
    {
        return Section::with('version')
            ->get()
            ->groupBy('version.branch');
    }

    public function versions()
    {
        return Version::all();
    }
}

<?php

namespace App\Http\Controllers;

use App\Apis\Github;
use App\Section;
use App\Version;
use Phased\Routing\Facades\Phase;
use Phased\State\Facades\Vuex;

class DocsController extends Controller
{
    public function LandingPage()
    {
        Github::release('reed-jones/phase', 'latest')
            ->first()
            ->toVuex('phase/releases', 'latest');

        return Phase::view();
    }

    public function DocumentationHandler($versionTag, $sectionSlug = null)
    {
        if (!$sectionSlug) {
            return redirect("/docs/master/$versionTag");
        }

        $version = Version::byTag($versionTag)->first();

        if (!$version) {
            return abort(404);
        }

        $section = Section::query()
            ->where([
                'version_id' => $version->id,
                'slug' => $sectionSlug
            ])
            ->first();

        if (!$section || !$section->hasContent()) {
            return abort(404);
        }

        Vuex::module('phase/docs', [
            'active' => $section->append('content'),
            'sections' => Section::with('version')->get()->groupBy('version.branch'),
            // 'sections' => Section::with('version')->get(),
            'versions' => Version::all()
        ]);

        return Phase::view();
    }
}

<?php

namespace App\Http\Controllers;

use App\Apis\Github;
use App\Section;
use App\User;
use App\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // redirects from /getting-started to /master/getting-started
        if (! $sectionSlug) {
            return redirect("/docs/master/{$versionTag}");
        }

        $version = Version::byTag($versionTag)->firstOrFail();

        $section = Section::getSectionWithContent($version->id, $sectionSlug);
        Vuex::load('phase/docs', [
            'active' => $section,
            'sections',
            'versions',
        ]);

        return Phase::view();
    }

    public function SearchHandler(Request $request)
    {
        return Section::search($request->search)->get()->each->append('content');
    }
}

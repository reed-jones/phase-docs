<?php

namespace App\Http\Controllers;

use App\Apis\Github;
use Illuminate\Http\Request;
use Phased\Routing\Facades\Phase;
use Phased\State\Facades\Vuex;
use ReedJones\ApiBuilder\Examples\Github as ApiBuilderGithub;

class DocsController extends Controller
{
    public function LandingPage()
    {
        Github::release('reed-jones/phase', 'latest')
            ->first()
            ->toVuex('phase/releases', 'latest');

        return Phase::view();
    }
}

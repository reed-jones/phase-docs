<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Phased\Routing\Facades\Phase;
use Phased\State\Facades\Vuex;

class DocsController extends Controller
{
    public function LandingPage()
    {
        Vuex::state(['author' => 'Blah']);

        return Phase::view();
    }
}

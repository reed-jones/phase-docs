<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Phased\Routing\Facades\Phase;

class DocsController extends Controller
{
    public function LandingPage()
    {
        return Phase::view();
    }
}

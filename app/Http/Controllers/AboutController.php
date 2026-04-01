<?php

namespace App\Http\Controllers;

use App\Models\BandInfo;
use App\Models\Member;

class AboutController extends Controller
{
    public function index()
    {
        $bandInfo = BandInfo::getInstance();
        $members  = Member::active()->get();
        return view('pages.public.about', compact('bandInfo', 'members'));
    }
}

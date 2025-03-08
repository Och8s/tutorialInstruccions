<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\Ifixit;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    public function index()
    {
        $guides = Guide::all();
        return view('guides.index', compact('guides'));
    }

    public function show(Guide $guide)
    {

        return view('guides.show', compact('guide'));
    }
}

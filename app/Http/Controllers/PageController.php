<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function getList() {
        return Content::simplePaginate(10);
    }

    public function getDetails($slug)
    {
        return Content::whereSlug($slug)->first();
    }
}

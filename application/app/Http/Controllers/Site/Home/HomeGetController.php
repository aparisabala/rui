<?php

namespace App\Http\Controllers\Site\Home;

use App\Http\Controllers\Controller;
use App\Traits\BaseTrait;
use Illuminate\Http\Request;
use DB;
use Webpatser\Uuid\Uuid;

class HomeGetController extends Controller
{
    use BaseTrait;
    public function __construct()
    {
    }
    public function viewHomePage(Request $request)
    {   
        return view('site.pages.home.viewHomePage');
    }
}

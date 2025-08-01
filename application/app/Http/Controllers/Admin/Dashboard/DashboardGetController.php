<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Traits\BaseTrait;
use Illuminate\Http\Request;
use Auth;
class DashboardGetController extends Controller
{
    use BaseTrait;
    public function __construct()
    {
        $this->LoadMiddleware('auth:globuser',['HasSetPassword']);
    }

    public function viewDashboard(Request $request)
    {
        return view('admin.pages.dashboard.viewDashboard');
    }

    public function viewProfileUpdate(Request $request)
    {
        $data['item'] = Auth::user();
        return  view('admin.pages.dashboard.viewProfileUpdate')->with("data",$data);
    }

    public function viewUpdatePasword(Request $request)
    {
        $data['item'] = Auth::user();
        return  view('admin.pages.dashboard.viewUpdatePasword')->with("data",$data);
    }
}

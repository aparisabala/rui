<?php

namespace App\Http\Middleware\Admin;

use Closure;
use App;
use App\Models\Globuser;
use App\Models\Tx_ward;
use Auth;
class IsSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if(!in_array("SA",config('r'))) {
            return redirect()->route('admin.dashboard');
        }
        return $next($request);
    }
}

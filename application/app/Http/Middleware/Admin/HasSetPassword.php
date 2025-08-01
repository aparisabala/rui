<?php

namespace App\Http\Middleware\Admin;

use Closure;
use App;
use App\Models\Globuser;
use App\Models\Tx_ward;
use Auth;
class HasSetPassword
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
        if(Auth::user()->setup_done == "no") {
             return redirect()->route('admin.setup_profile');
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware\Admin;

use Closure;
use App;
use App\Models\Globuser;
use App\Models\Tx_ward;
use Auth;
class SetUserRoles
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
        if(Auth::user() && Auth::user()->user_access != null) {
            config(['r' => json_decode(Auth::user()->user_access)]);
        }
        return $next($request);
    }
}

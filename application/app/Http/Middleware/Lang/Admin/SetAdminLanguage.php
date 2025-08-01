<?php

namespace App\Http\Middleware\Lang\Admin;

use Closure;
use App;
class SetAdminLanguage
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
        
        App::setLocale(config('a.local'));
        return $next($request);
    }
}

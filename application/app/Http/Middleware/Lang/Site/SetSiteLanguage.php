<?php

namespace App\Http\Middleware\Lang\Site;

use Closure;
use App;
use Session;
use Config;
class SetSiteLanguage
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
        
        $localelang = Session::get('local_lang', 'bn');
        App::setLocale($localelang);
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware\Https;

use Closure;

class ForceHttps
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
        if (env('SERVER_MODE') == "SERVER") {
            if (!$request->secure()) {
                return redirect()->secure($request->getRequestUri());
            }
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (in_array($request->segment(1), config('app.available_locales'))) {
            app()->setLocale($request->segment(1));
        }

        return $next($request);
    }
}

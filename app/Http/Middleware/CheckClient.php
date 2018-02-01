<?php

namespace App\Http\Middleware;

use Closure;

class CheckClient
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
        if (empty($_SESSION['client_email']) && empty($_SESSION['client_name'])) {
            return view('welcome');
        }
        return $next($request);
    }
}

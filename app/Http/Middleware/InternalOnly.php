<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InternalOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->user()->customer_id && $request->user()->customer_id > 0) {
            return redirect('/');
        }
        return $next($request);
    }
}

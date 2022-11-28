<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOrOwner
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
        if (\Auth::user() && \Auth::user()->is_admin) {
            return $next($request);
        }

        if (\Auth::user() && $request->get('user_id') === \Auth::user()->id) {
            return $next($request);
        }

        return redirect('dashboard')->with('error', 'Unauthorized');
    }
}

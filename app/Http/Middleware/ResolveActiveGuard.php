<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResolveActiveGuard
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
        $guards = ['admin', 'apex', 'committee', 'chapter'];
        $activeGuard = null;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $activeGuard = $guard;
                break;
            }
        }

        if (!$activeGuard) {
            abort(403, 'Unauthorized');
        }

        Auth::shouldUse($activeGuard);
        $request->merge(['active_guard' => $activeGuard]);

        return $next($request);
    }
}

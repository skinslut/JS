<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class TestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (
                Route::currentRouteName() === 'test.answer'
                or (($request->has('ANSWER') or Route::currentRouteName() === 'test.init') and !$user->hasStartedOrNewTests)
                or $user->hasStartedOrNewTests and Route::currentRouteName() === 'test.start'
            )
                return $next($request);
            elseif ($user->hasStartedOrNewTests) {
                return redirect()->route('test.start');
            }
        }
        return $next($request);
    }
}

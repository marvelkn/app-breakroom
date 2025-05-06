<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
{
    Log::info('AdminMiddleware hit');
    Log::info('User Auth Status:', [
        'is_authenticated' => Auth::check(),
        'user_id' => Auth::id(),
        'role_id' => Auth::user()?->role_id
    ]);
    
    if (Auth::check() && Auth::user()->role_id === 1) {
        return $next($request);
    }
    return redirect('/dashboard')->with('error', 'Unauthorized access');
}
}
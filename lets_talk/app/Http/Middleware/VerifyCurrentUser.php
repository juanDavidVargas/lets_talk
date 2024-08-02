<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use App\User;
use Illuminate\Support\Facades\Auth;

class VerifyCurrentUser
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
        Log::info('Current user:', ['user' => auth()->user()]);

        // if (session()->has('usuario_id')) {
        //     $user = User::find(session('usuario_id'));
        //     if ($user) {
        //         Auth::login($user);
        //     }
        // }

        return $next($request);
    }
}

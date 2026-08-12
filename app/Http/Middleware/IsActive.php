<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use SweetAlert2\Laravel\Swal;
use Symfony\Component\HttpFoundation\Response;

class IsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            if (auth()->user()->is_root || auth()->user()->is_active) {
                return $next($request);
            }
        }

        Swal::fire([
            'toast' => true,
            'position' => 'top',
            'showConfirmButton' => false,
            'icon' => 'error',
            'title' => 'Usuario Inactivo',
            'showCloseButton' => true,
        ]);
        auth()->logout();

        return redirect()->route('home');

    }
}

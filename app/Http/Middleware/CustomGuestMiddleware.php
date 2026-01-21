<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomGuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated

        if (auth()->check()) {
            if(auth()->user()->role === 'admin'){
                return redirect('admin/dashboard');
            }elseif(auth()->user()->role === 'service-provider'){
                return redirect('service-provider/dashboard');
            }else{
                return redirect('/');
            }
        }

        return $next($request);
    }
}

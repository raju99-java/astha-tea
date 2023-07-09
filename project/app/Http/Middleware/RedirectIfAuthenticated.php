<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        switch ($guard) {
            case 'admin':
              if (Auth::guard($guard)->check()) {
                return redirect()->route('admin.dashboard');
              }
              break;
            case 'delivery':
             
              if (Auth::guard($guard)->check()) {
                return redirect()->route('delivery.dashboard');
              }
              break;
            case 'sales':
            
              if (Auth::guard($guard)->check()) {
                return redirect()->route('sales.dashboard');
              }
              break;
            default:
              if (Auth::guard($guard)->check()) {
                  return redirect()->route('user-dashboard');
              }
              break;
          }
    
            return $next($request);
    }
}

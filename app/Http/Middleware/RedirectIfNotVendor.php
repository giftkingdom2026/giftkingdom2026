<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
class RedirectIfNotVendor
{
/**
 * Handle an incoming request.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \Closure  $next
 * @param  string|null  $guard
 * @return mixed
 */
public function handle($request, Closure $next, $guard = 'vendor')
{
    if (Auth::check() && Auth::user()->role_id == 4 ) {

      return $next($request);
    
    }
    
    return redirect('/dashboard/'.Auth()->user()->user_name);
    
    }
}

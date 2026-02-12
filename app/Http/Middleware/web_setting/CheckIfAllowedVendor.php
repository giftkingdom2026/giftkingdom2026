<?php

namespace App\Http\Middleware\web_setting;

use Closure;
use Auth;
use DB;
use App\Models\Web\Usermeta;
use App\Models\Core\Setting;

class CheckIfAllowedVendor
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
    $check = DB::table('users')
        ->where('id', Auth()->user()->id)
        ->whereIn('role_id', [1, 2, 4])
        ->first();

    if (!$check) {
        return redirect('/');
    }

    if ($check->role_id == 1) {
        return $next($request);
    }

$arr = Usermeta::where('user_id', $check->id)->where('meta_key','access')->pluck('meta_value')->first();
    $sidebar = unserialize($arr);

    $permissionsMap = [
        'product' => 'products',
        'orders'  => 'orders',
    ];

    $route = $request->route()->getPrefix();
    $prefix = last(explode('/', $route));

    if (isset($permissionsMap[$prefix])) {
        $permKey = $permissionsMap[$prefix];

        if (isset($sidebar[$permKey]) && $sidebar[$permKey] === 'off') {
            abort(403, 'Access denied');
        }
    }

    if ($check->role_id == 4) {
        $approved = Usermeta::where([
            ['user_id', $check->id],
            ['meta_key','approved']
        ])->first();

        return $approved ? $next($request) : redirect('/dashboard/'.$check->user_name);
    }

    return $next($request);
}


}

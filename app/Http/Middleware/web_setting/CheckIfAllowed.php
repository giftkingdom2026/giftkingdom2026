<?php

namespace App\Http\Middleware\web_setting;

use Closure;
use Auth;
use DB;
use App\Models\Core\Setting;
use App\Models\Web\Usermeta;

class CheckIfAllowed
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
    $user = DB::table('users')
        ->where('id', Auth()->user()->id)
        ->first();

    if ($user && $user->role_id == 1) {
        return $next($request);
    }

    if (!$user || !in_array($user->role_id, [2, 4])) {
        return redirect('/');
    }

$arr = Usermeta::where('user_id', $user->id)->where('meta_key','access')->pluck('meta_value')->first();
    $sidebar = unserialize($arr);
    $segment2 = $request->segment(2);
    $segment3 = $request->segment(3);

$permissionMap = [
    'attribute'   => 'attributes',
    'brand'       => 'brands',
    'category'    => 'categories',
    'products'    => 'products',
    'media'       => 'media',
    'customers'   => 'customers',
    'coupons'     => 'coupons',
    'page'        => 'pages',
    'reviews'     => 'reviews',
    'currencies'  => 'currency',
    'vendors'     => 'vendors',
];

if (isset($permissionMap[$segment2])) {
    $key = $permissionMap[$segment2];

    // Block if the sidebar key is missing OR explicitly off
    if (!isset($sidebar[$key]) || $sidebar[$key] === 'off') {
        abort(403, 'Access denied.');
    }
}


if ($segment2 === 'list' || $segment2 === 'edit') {
    $postType = $segment3; // {post_type} is always segment3

    if (isset($sidebar[$postType]) && $sidebar[$postType] === 'off') {
        abort(403, 'Access denied.');
    }
}
    
    $singleRouteMap = [
        'admin/home-content' => 'home-page',
        'admin/setting'      => 'settings',
        'admin/abandonedcart' => 'abandoned-cart',
        'admin/reports/low-stock' => 'low-stock-products',
        'admin/reports/out-stock' => 'out-of-stock-products',
        'admin/reports/customers' => 'customers-order-total',
        'admin/reports/sales-report' => 'sales-report',
        'admin/addappkey' => 'app-labels',
        'admin/listingAppLabels' => 'app-labels',
        'admin/editAppLabel' => 'app-labels',
        'admin/event-inquiries' => 'event-inquiry-form',
        'admin/contact-form' => 'contact-form',
        'admin/menus' => 'menu',
        'admin/addmenus' => 'menu',
        'admin/editmenu' => 'menu',
        'admin/admins' => 'admins',
        'admin/addadmins' => 'addadmins',
        'admin/editadmin' => 'editadmin',
        'admin/editaccess' => 'editaccess',
        'admin/customer-wallet-history' => 'customer-wallet',
    ];

foreach ($singleRouteMap as $route => $sidebarKey) {
    // Match current request against the route, including dynamic parameters
    if (request()->is($route) || request()->is($route . '/*')) {

        // If the sidebar key is missing or explicitly off, block access
        if (!isset($sidebar[$sidebarKey]) || $sidebar[$sidebarKey] === 'off') {
            abort(403, 'Access denied.');
        }

        // Found a matching route, no need to check further
        break;
    }
}


    if (isset($sidebar[$segment2]) && $sidebar[$segment2] === 'off') {
        abort(403, 'Access denied.');
    }

    return $next($request);
}




}

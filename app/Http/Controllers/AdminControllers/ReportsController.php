<?php
namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Core\Products;
use App\Models\Web\Order;
use App\Models\Web\Users;
use App\Models\Web\Index;
use Auth;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller{
    public function getSalesReport(Request $request)
    {
        $perPage = $request->input('length');
        $start = $request->input('start');
        $draw = $request->input('draw');

        $query = Order::where('order_status', 'Delivered');

        $total = $query->count();

        $orders = $query->skip($start)->take($perPage)->get();
        $data = [];
        foreach ($orders as $order) {
            $user = Users::getUserData($order->customer);

            $data[] = [
                'ID' => $order->ID,
                'customer_email' => $order->email,
                'origin' => $order->ordered_source == 1 ? 'Website' : 'App',
                'total' => $order->currency . ' ' . number_format($order->order_total, 2),
                'date' => date('M d, Y', strtotime($order->updated_at)),
            ];
        }
        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data
        ]);
    }
    public function lowStock(Request $request){

        if( Auth::user()->role_id == 1 ) :

            $result = Products::where([['prod_quantity', '<', 10],['prod_quantity', '!=', 0],['prod_type','!=','variation']])->paginate(25);

        else :

            $result = Products::where([['prod_quantity', '<', 10],['prod_quantity', '!=', 0],['author_id',Auth::user()->id],['prod_type','!=','variation']])->paginate(25);

        endif; 

        $result ? $result = $result->toArray() : '';

        foreach( $result['data'] as &$prod ) :

            $prod['prod_image'] = Index::get_image_path($prod['prod_image']);

        endforeach;

        return view("admin.reports.low-stock", ['pageTitle' => 'Low Stock'])->with('result', $result);

    }


    public function outStock(Request $request){

        if( Auth::user()->role_id == 1 ) :

            $result = Products::where([['prod_quantity', 0]])->paginate(25);

        else :

            $result = Products::where([['prod_quantity',0],['author_id',Auth::user()->id]])->paginate(25);
            
        endif;

        $result ? $result = $result->toArray() : '';

        foreach( $result['data'] as &$prod ) :

            $prod['prod_image'] = Index::get_image_path($prod['prod_image']);

        endforeach;

        return view("admin.reports.out-stock", ['pageTitle' => 'Out Stock'])->with('result', $result);

    }
public function getCustomersTotal(Request $request)
{
    $perPage = $request->input('length', 10);
    $start = $request->input('start', 0);
    $draw = $request->input('draw');
    $search = $request->input('search.value');

    // Get all currency conversion rates (AED = 1.0, USD = 0.27, etc.)
    $currencies = DB::table('currencies')->pluck('value', 'code');

    // Get all delivered orders
    $orders = Order::where('order_status', 'Delivered')->get();

    $grouped = [];

    foreach ($orders as $order) {
        $user = Users::getUserData($order->customer);
        if (!$user) continue;

        $userId = $user['id'];

        if (!isset($grouped[$userId])) {
            $grouped[$userId] = [
                'name' => $user['first_name'] . ' ' . $user['last_name'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'order_count' => 0,
                'total' => 0
            ];
        }

        $orderTotal = $order->order_total;
        $orderCurrency = strtoupper($order->currency);

        // Normalize the order total to AED
        if (isset($currencies[$orderCurrency]) && $currencies[$orderCurrency] > 0) {
            $normalizedTotal = $orderTotal / $currencies[$orderCurrency];
        } else {
            $normalizedTotal = $orderTotal; // fallback if currency not found
        }

        $grouped[$userId]['order_count']++;
        $grouped[$userId]['total'] += $normalizedTotal;
    }

    // Apply search filter
    if (!empty($search)) {
        $grouped = array_filter($grouped, function ($customer) use ($search) {
            return stripos($customer['name'], $search) !== false
                || stripos($customer['email'], $search) !== false
                || stripos($customer['phone'], $search) !== false;
        });
    }

    // Convert to indexed array
    $groupedArray = array_values($grouped);
    $total = count($groupedArray);
    $paged = array_slice($groupedArray, $start, $perPage);

    // Format total with currency
    foreach ($paged as &$c) {
        $c['total'] = 'AED ' . number_format($c['total'], 2);
    }

    return response()->json([
        'draw' => intval($draw),
        'recordsTotal' => $total,
        'recordsFiltered' => $total,
        'data' => $paged,
    ]);
}

    public function getLowStockProducts(Request $request)
    {
        $perPage = $request->input('length', 10);
        $start = $request->input('start', 0);
        $draw = $request->input('draw');
        $search = $request->input('search.value');

        $query = Products::where([
            ['prod_quantity', '<', 10],
            ['prod_quantity', '!=', 0],
        ]);

        if (Auth::user()->role_id == 4) {
            $query->where('author_id', Auth::user()->id);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('prod_title', 'like', '%' . $search . '%');
            });
        }

        $totalRecords = $query->count();

        $data = $query->offset($start)
            ->limit($perPage)
            ->get()
            ->toArray();

foreach ($data as &$prod) {
    $prod['prod_image'] = Index::get_image_path($prod['prod_image']);

    $prodTitle = $prod['prod_title'];

    if ($prod['prod_type'] === 'variation') {
        $attribute_links = \App\Models\Core\VariationsToAttributeValues::where('variation_ID', $prod['ID'])->get();
        $attribute_titles = [];

        foreach ($attribute_links as $link) {
            $attribute = \App\Models\Core\Values::where('value_ID', $link->value_ID)->first();
            if ($attribute) {
                $attribute_titles[] = $attribute->value_title;
            }
        }

        $attribute_string = implode(' | ', $attribute_titles);
        $prodTitle = '#' . $prod['prod_sku'] . ' ' . $prod['prod_title'];

        if (!empty($attribute_string)) {
            $prodTitle .= ' | ' . $attribute_string;
        }
    }

    $prod['prod_title'] = $prodTitle;

    // Use your updated action URL logic here:
    if ($prod['prod_type'] === 'variation') {
        $actionUrl = asset('admin/product/edit/' . $prod['prod_parent']) . '?var=' . $prod['ID'];
    } else {
        $actionUrl = asset('admin/product/edit/' . $prod['ID']);
    }

    $prod['action'] = '<a href="' . $actionUrl . '" title="View" class="badge bg-light-blue"><i class="fa fa-eye" aria-hidden="true"></i></a>';
}



        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
        ]);
    }
    public function customersTotal(Request $request){

        $orders = Order::where('order_status','Completed')->paginate(25);

        $orders ? $orders = $orders->toArray() : '';

        $arr = [];

        foreach( $orders['data'] as $key => $order ):

            $check = Users::getUserData($order['customer']);

            if( $check != null ):

                $arr[$order['customer']]['customer'] = $check;

                $arr[$order['customer']]['orders'][] = $order;

            endif;

        endforeach;

        return view("admin.reports.customers", ['pageTitle' => 'Out Stock'])->with('result', $arr);

    }

public function salesReport(Request $request)
{
    // Fetch conversion rates: 'USD' => 0.27, etc.
    $currencies = DB::table('currencies')->pluck('value', 'code');

    // Paginated orders for display
    $orders = Order::where('order_status', 'Delivered')->paginate(25);
    $orders = $orders ? $orders->toArray() : [];

    // All delivered orders for total calculation
    $allorders = Order::where('order_status', 'Delivered')->get();
    $allorders = $allorders ? $allorders->toArray() : [];

    $ordertotal = 0;

    // Normalize and sum all order totals
    foreach ($allorders as $item) {
        $orderTotal = $item['order_total'];
        $currencyCode = strtoupper($item['currency']);

        if (isset($currencies[$currencyCode]) && $currencies[$currencyCode] > 0) {
            $normalizedTotal = $orderTotal / $currencies[$currencyCode];
        } else {
            $normalizedTotal = $orderTotal;
        }

        $ordertotal += $normalizedTotal;
    }

    // Attach customer data for display
    foreach ($orders['data'] as $key => &$order) {
        $customer = Users::getUserData($order['customer']);
        $order['customer'] = $customer;

        if ($customer === null) {
            unset($orders['data'][$key]);
        }
    }

    $arr['total'] = $ordertotal;
    $arr['orders'] = $orders;

    return view("admin.reports.sales", ['pageTitle' => 'Out Stock'])->with('result', $arr);
}

        public function getOutStockProducts(Request $request)
    {
        $perPage = $request->input('length', 10); // DataTables uses 'length' for page size
        $start = $request->input('start', 0);
        $draw = $request->input('draw');
        $search = $request->input('search.value');

        $query = Products::where('prod_quantity', 0);

        if (Auth::user()->role_id == 4) {
            $query->where('author_id', Auth::user()->id);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('prod_title', 'like', '%' . $search . '%');
            });
        }

        $totalRecords = $query->count();

        $data = $query->offset($start)
            ->limit($perPage)
            ->get()
            ->toArray();

        foreach ($data as &$prod) {
            // Default title
            $prodTitle = $prod['prod_title'];

            if ($prod['prod_type'] == 'variation') {
                $attribute_links = \App\Models\Core\VariationsToAttributeValues::where('variation_ID', $prod['ID'])->get();
                $attribute_titles = [];

                foreach ($attribute_links as $link) {
                    $attribute = \App\Models\Core\Values::where('value_ID', $link->value_ID)->first();
                    if ($attribute) {
                        $attribute_titles[] = $attribute->value_title;
                    }
                }

                $attribute_string = implode(' | ', $attribute_titles);
                $prodTitle = '#' . $prod['prod_sku'] . ' ' . $prod['prod_title'];

                if (!empty($attribute_string)) {
                    $prodTitle .= ' | ' . $attribute_string;
                }
            }

            $prod['prod_title'] = $prodTitle;
            $prod['prod_image'] = Index::get_image_path($prod['prod_image']);
if ($prod['prod_type'] === 'variation') {
    $actionUrl = asset('admin/product/edit/' . $prod['prod_parent']) . '?var=' . $prod['ID'];
} else {
    $actionUrl = asset('admin/product/edit/' . $prod['ID']);
}

$prod['action'] = '<a href="' . $actionUrl . '" title="View" class="badge bg-light-blue"><i class="fa fa-eye" aria-hidden="true"></i></a>';

        }


        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
        ]);
    }
}

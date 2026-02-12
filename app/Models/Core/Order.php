<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Core\Orderitems;
use App\Models\Web\Users;
use Auth;
class Order extends Model{   

    protected $table= 'orders';
    protected $guarded = [];

    public static function paginator(){


        if( !in_array(Auth::user()->role_id, [1,2]) ) :

            $orders = Orderitems::where('author_id',Auth()->user()->id)->pluck('order_ID');

            $orders ? $orders = $orders->toArray() : '';

            $orders = self::whereIn('ID',$orders)->orderBy('created_at', 'DESC')->paginate(15);

            $orders ? $orders = $orders->toArray() : '';

            foreach($orders['data'] as $key => &$order) :

                $items = Orderitems::where([['author_id',Auth()->user()->id],['order_ID',$order['ID']]])->get();

                $items ? $items = $items->toArray() : '';

                $total = 0;

                foreach($items as $item) :

                    $total+= $item['item_price'];

                endforeach;

                $order['order_total'] = $total;

            endforeach;
            
        else :

            $orders = self::orderBy('created_at', 'DESC')->paginate(15)->toArray();

        endif;

        // foreach($orders as &$order) :

        //     $order['items'] =  Orderitems::where([['order_ID',$request->id],['author_id',Auth()->user()->id]])->get()->toArray();

        //     $total = 0;

        //     foreach($order['items'] as $item) :



        //     endforeach;

        // endforeach;

        return $orders;
    }


    public static function getDashboardOrders(){

$orders = self::orderBy('created_at', 'DESC')->take(6)->get()->toArray();

        foreach($orders as $key => &$order) :

            $where = [['order_ID',$order['ID']]];

            $items = Orderitems::where($where)->take(1)->get();

            $items ? $items = $items->toArray() : '';

            $total = 0;

            foreach($items as &$item) :

                $total+= $item['item_price'];

                $item['product'] = Products::getProduct($item['product_ID']);
                
            endforeach;

            $order['items'] = $items;

            $order['order_total'] = $total;

            $order['customer'] = Users::getUserData( $order['customer'] );

            if( $order['customer'] == null ) :

                unset($orders['data'][$key]);

            endif;

        endforeach;
        return $orders;
    }

public static function getSales()
{
    $currencies = DB::table('currencies')->pluck('value', 'code');

    $orders = self::where('order_status', 'Delivered')->get();
    $user = Auth::user();

    $total = 0;

    foreach ($orders as $order) {
        if (in_array($user->role_id, [1, 2])) {
            $orderCurrency = strtoupper($order->currency);
            $orderTotal = $order->order_total;

            if (isset($currencies[$orderCurrency]) && $currencies[$orderCurrency] > 0) {
                $total += $orderTotal / $currencies[$orderCurrency];
            } else {
                $total += $orderTotal;
            }
        } else {
            $items = Orderitems::where([
                ['order_ID', $order->ID],
                ['author_id', $user->id]
            ])->get();

            foreach ($items as $item) {
                $total += $item->item_price; 
            }
        }
    }

    return $total; 
}


    public static function getOrdersByYear(){

        if( in_array(Auth::user()->role_id, [1,2]) ) :

            $orders = self::whereYear('created_at', date('Y'))->get();

        else :

            $items = Orderitems::where([['author_id',Auth()->user()->id]])->pluck('order_ID');

            $items ? $items = $items->toArray() : '';

            $items = array_unique($items);

            $orders = self::whereIn('ID',$items)->whereYear('created_at', date('Y'))->get();

        endif;

        $arr = [];

        foreach($orders as $order) :

            isset($arr[date('M', strtotime($order->created_at))]) ? 

            $arr[date('M', strtotime($order->created_at))]+=1 : 

            $arr[date('M', strtotime($order->created_at))] = 1;

        endforeach;

        $data['keys'] = array_keys($arr);
        $data['values'] = array_values($arr);

        return $data;
    }

    public static function getOrdersByYears(){

        if( in_array(Auth::user()->role_id, [1,2]) ) :

            $orders = self::whereYear('created_at', date('Y'))->get();

        else :

            $items = Orderitems::where([['author_id',Auth()->user()->id]])->pluck('order_ID');

            $items ? $items = $items->toArray() : '';

            $items = array_unique($items);

            $orders = self::whereIn('ID',$items)->whereYear('created_at', date('Y'))->get();

        endif;

        $arr = [];

        foreach($orders as $order) :

            isset($arr[date('Y', strtotime($order->created_at))]) ? 

            $arr[date('Y', strtotime($order->created_at))]+=1 : 

            $arr[date('Y', strtotime($order->created_at))] = 1;

        endforeach;

        $data['keys'] = array_keys($arr);
        $data['values'] = array_values($arr);

        return $data;
    }

    public static function getOrdersByMonth(){

        if( in_array(Auth::user()->role_id, [1,2]) ) :

            $orders = self::whereMonth('created_at', date('m'))->get();

        else :

            $items = Orderitems::where([['author_id',Auth()->user()->id]])->pluck('order_ID');

            $items ? $items = $items->toArray() : '';

            $items = array_unique($items);

            $orders = self::whereIn('ID',$items)->whereMonth('created_at', date('m'))->get();

        endif;

        $arr = [];

        foreach($orders as $order) :

            isset($arr[date('d M, Y', strtotime($order->created_at))]) ? 

            $arr[date('d M, Y', strtotime($order->created_at))]+=1 : 

            $arr[date('d M, Y', strtotime($order->created_at))] = 1;

        endforeach;

        $data['keys'] = array_keys($arr);
        $data['values'] = array_values($arr);

        return $data;
    }
    public static function getOrdersByDaily()
    {
        if (in_array(Auth::user()->role_id, [1, 2])) {
            $orders = self::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->get();
        } else {
            $items = Orderitems::where('author_id', Auth()->user()->id)->pluck('order_ID')->unique()->toArray();
            $orders = self::whereIn('ID', $items)
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->get();
        }

        $orderCounts = [];
        foreach ($orders as $order) {
            $key = date('d M, Y', strtotime($order->created_at));
            $orderCounts[$key] = ($orderCounts[$key] ?? 0) + 1;
        }

        $daysInMonth = date('t');
        $year = date('Y');
        $month = date('m');

        $data = [
            'keys' => [],
            'values' => [],
        ];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = sprintf('%02d-%s-%s', $day, $month, $year);
            $formatted = date('d M, Y', strtotime($date));

            $data['keys'][] = $formatted;
            $data['values'][] = $orderCounts[$formatted] ?? 0;
        }

        return $data;
    }
    public static function getCount(){

        if( in_array(Auth::user()->role_id, [1,2]) ) :

            $return = self::all()->count();

        else :

            $items = Orderitems::where([['author_id',Auth()->user()->id]])->pluck('order_ID');

            $items ? $items = $items->toArray() : '';

            $items = array_unique($items);

            $return = count($items);

        endif;

        return $return;
    }
}

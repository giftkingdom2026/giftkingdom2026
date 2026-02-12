<?php
namespace App\Http\Controllers\AdminControllers;

use App\Models\Core\Customers;
use App\Models\Core\Images;
use App\Models\Web\Users;
use App\Models\Web\Cart;
use App\Models\Web\Cartitems;
use App\Models\Web\Usermeta;
use App\Models\Web\Referrals;
use App\Models\Web\Wallet;
use App\Models\Core\Setting;
use App\Models\Core\Order;
use App\Models\Core\Languages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;
use Kyslik\ColumnSortable\Sortable;

class CustomersController extends Controller
{
    //
    public function __construct(Customers $customers, Setting $setting)
    {
        $this->Customers = $customers;
        $this->myVarsetting = new SiteSettingController($setting);
        $this->Setting = $setting;
    }

    public function display(){

        $data = Users::where([['role_id',3]])->orderBy('created_at','DESC')->paginate(15);

        $data ? $data = $data->toArray() : '';

        foreach( $data['data'] as &$item ) :

            $item['meta'] = Usermeta::getMeta($item['id']);

        endforeach;


        return view("admin.customers.index", ['pageTitle' => 'Customers'])->with('data', $data);
    }

    public function wallet(){

        $data = Wallet::paginate(25);

        $data ? $data = $data->toArray() : '';

        foreach( $data['data'] as $key => &$item ) :

            $check = Users::getUserData($item['user_id']);
            
            $item['user'] = $check;

            if( $check == null ) : 

                unset($data['data'][$key]);
                
            endif; 

        endforeach;

        return view("admin.customers.wallet", ['pageTitle' => 'Wallet History'])->with('data', $data);
    }

    public function update(Request $request){

        $data = $request->all();

        if( isset( $data['meta'] ) ) :

            foreach($data['meta'] as $key => $value ) :

                Usermeta::updateOrCreate(['meta_key' => $key,'user_id' => $data['id']],[

                    'user_id' => $data['id'],
                    'meta_key' => $key,
                    'meta_value' => $value
                ]);

            endforeach;

            unset($data['meta']);

        endif;

        unset($data['_token']);

        $data = array_filter($data);

        if( isset( $data['password'] ) ) :

            if( isset( $data['confirmpassword'] ) && $data['confirmpassword'] == $data['password'] ) :

                $data['password'] = Hash::make( $data['password'] ); unset( $data['confirmpassword']);

            else :

                return redirect()->back()->with('success','Confirm Password empty or mismatch!');

            endif;

        endif;

        Users::where('id',$data['id'])->update($data);

        return redirect()->back()->with('message','Record Updated Successfully!');
    }

    public function add(Request $request){

        return view("admin.customers.add", ['pageTitle' => 'Add Customer']);
    }

    public function edit(Request $request){

        $data = Users::getUserData($request->id);

        return view("admin.customers.edit",['pageTitle' => 'Edit Customer'])->with('data', $data);
    }

    //add addcustomers data and redirect to address
    public function insert(Request $request){

        $data = $request->all();

        $check = Users::where('email',$data['email'])->first();

        if( $check ) :

        return redirect()->back()->with('success','A customer is already registered with this email!');

        endif;

        $num = rand(0,100);

        $username = $data['first_name'].'_'.$data['last_name'].$num;

        $check = Users::where('user_name',$username)->first();

        if( $check ):

            $num = rand(0,100);

            $username = $data['first_name'].'_'.$data['last_name'].$num;

        endif;


        $arr = [

            'user_name' => strtolower($username),

            'role_id' => 3,

            'first_name' => $data['first_name'],

            'last_name' => $data['last_name'],

            'email' => $data['email'],

            'phone' => $data['phone'],

            'dob' => $data['dob'],
            
            'gender' => $data['gender'],
            'emirate_of_residence' => $data['emirate_of_residence'],
            'nationality' => $data['nationality'],

        ];
        if( isset( $data['password'] ) ) :

            if( isset( $data['confirmpassword'] ) && $data['confirmpassword'] == $data['password'] ) :

                $arr['password'] = Hash::make( $data['password'] ); unset( $data['confirmpassword']);

            else :

                return redirect()->back()->with('success','Confirm Password empty or mismatch!');

            endif;

        endif;

        $user = Users::create( $arr );

        return redirect('/admin/customers/display')->with('success','Customer Added Successfully!');
    }

    public function delete(Request $request){

        Users::where('id',$request->id)->delete();

        Order::where('customer',$request->id)->delete();

        $cart = Cart::where('customer_id',$request->id)->pluck('customer_id')->first();

        Cart::where('customer_id',$request->id)->delete();

        Cartitems::where('cart_ID',$cart)->delete();

        return redirect()->back()->with('success','Customer has been moved to trash');
    }

    public function referrals(Request $request){

        $data = Referrals::paginate(25);

        $data ? $data = $data->toArray() : '';

        $arr = [];

        foreach($data['data'] as $item ) : 

            $arr[$item['user_id']]['referrer'] = Users::getUserData( $item['user_id'] );

            $arr[$item['user_id']]['referrals'][] = Users::getUserData( $item['referral_id'] ); 

        endforeach;


        return view("admin.customers.referrals", ['pageTitle' => 'Referrals'])->with('data', ['parsed' => $arr, 'data' => $data]);

    }
    public function updateCustomerStatus(Request $request, $id)
    {
        $customer = Users::find($id);
        if ($customer) {
            DB::table('users')->where('id', $id)->update(['status'=>$request->status]);
        } else {
            return redirect()->back()->with('error', 'User Not Found');
        }
        
        return redirect()->back()->with('success', 'User Status Updated');
    }
    public function getCustomersAjax(Request $request)
{
    $perPage = (int) $request->input('length', 25);
    $start = (int) $request->input('start', 0);
    $draw = (int) $request->input('draw');
    $search = $request->input('search.value');

    $query = Users::where('role_id', 3);

    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    $total = $query->count();

    $customers = $query->offset($start)
        ->limit($perPage)
        ->orderBy('id', 'DESC')
        ->get();

    $formatted = $customers->map(function ($user) {
        $statusText = $user->status == '1' ? 'Active' : 'Inactive';
        $fullName = $user->first_name . ' ' . $user->last_name;
        $meta = Usermeta::getMeta($user->id);

$actionHtml = '
    <div class="careerFilter">
        <div class="child_option position-relative">
            <button class="dots open-menu2 bg-transparent border-0 p-0" type="button">
                <svg height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512">
                    <path d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"></path>
                </svg>
            </button>
            <div class="dropdown-menu2 dropdown-menu-right" style="display: none;">
                <ul class="careerFilterInr">
                    <li>
                        <a href="' . asset('admin/customers/edit/' . $user->id) . '" class="w-100 border-0 d-flex justify-content-between">Edit</a>
                    </li>
                    <li>
                        <a href="javascript:delete_popup(\'' . asset('admin/customers/delete') . '\',' . $user->id . ');" class="w-100 border-0 d-flex justify-content-between">Delete</a>
                    </li>
                    <li>
                        <form method="POST" action="' . route('update-customer-status', $user->id) . '" class="w-100">
                            ' . csrf_field() . '
                            <input type="hidden" name="status" value="' . ($user->status === '1' ? '0' : '1') . '">
                            <button type="submit" class="w-100 border-0 bg-transparent d-flex justify-content-between align-items-center" style="padding: 0.75rem 0.938rem;">
                                ' . ($user->status === '1' ? 'Deactivate' : 'Activate') . '
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 512 512">
                                    <path d="M256 48C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48zm93.3 241.1c4.7 4.7 4.7 12.3 0 17L313 342.4c-4.7 4.7-12.3 4.7-17 0L256 302.6l-40 39.8c-4.7 4.7-12.3 4.7-17 0l-36.3-36.3c-4.7-4.7-4.7-12.3 0-17L202.6 256l-40-39.8c-4.7-4.7-4.7-12.3 0-17l36.3-36.3c4.7-4.7 12.3-4.7 17 0l40 39.8 40-39.8c4.7-4.7 12.3-4.7 17 0l36.3 36.3c4.7 4.7 4.7 12.3 0 17L309.4 256l39.9 33.1z"/>
                                </svg>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
';


        return [
            'select' => '<input type="checkbox" class="row-select" data-id="'. $user->id .'">',
            'id' => $user->id,
            'full_name' => $fullName,
            'email' => $user->email,
            'phone' => $user->phone,
            'action' => $actionHtml
        ];
    })->all();

    return response()->json([
        'draw' => $draw,
        'recordsTotal' => $total,
        'recordsFiltered' => $total,
        'data' => $formatted
    ]);
}

public function walletAjax(Request $request)
{
    $perPage = $request->input('length', 10);
    $start = $request->input('start', 0);
    $draw = $request->input('draw');
    $search = $request->input('search.value');

    // Get all valid user IDs to filter wallets
    $validUserIds = Users::pluck('id')->toArray();

    // Base query only wallets with valid user IDs
    $query = Wallet::whereIn('user_id', $validUserIds);

    // Apply search on wallet fields
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('transaction_type', 'like', "%{$search}%")
              ->orWhere('transaction_status', 'like', "%{$search}%")
              ->orWhere('transaction_comment', 'like', "%{$search}%");
        });
    }

    $totalRecords = $query->count();

    // Fetch wallets with pagination
    $wallets = $query->orderBy('id', 'desc')
                     ->offset($start)
                     ->limit($perPage)
                     ->get();

    $data = [];
    foreach ($wallets as $wallet) {
        // Since we filtered by valid users, this should never be null
        $user = Users::getUserData($wallet->user_id);

        $order = $wallet->transaction_order ? Order::find($wallet->transaction_order) : null;

        $type = ucfirst($wallet->transaction_type);

        $status = 'Unknown';
        if ($wallet->transaction_status === 'pending_payment') {
            $status = 'Pending';
        } elseif ($wallet->transaction_status === 'completed') {
            $status = 'Completed';
        }

        $points = (strtolower($wallet->transaction_type) === 'debit' ? '-' : '+') . $wallet->transaction_points;

        $date = date('d M, Y', strtotime($wallet->created_at));

        $action = '<a title="Edit Customer" href="' . asset('admin/customers/edit/' . $wallet->user_id) . '" class="badge bg-light-blue"><i class="fas fa-edit"></i></a>';

        $data[] = [
            'id' => $wallet->ID,
            'user_email' => $user['email'] ?? 'N/A',
            'type' => $type,
            'status' => $status,
            'points' => $points,
            'comment' => $wallet->transaction_comment,
            'date' => $date,
            'action' => $action,
        ];
    }

    return response()->json([
        'draw' => intval($draw),
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $totalRecords,
        'data' => $data,
    ]);
}


}

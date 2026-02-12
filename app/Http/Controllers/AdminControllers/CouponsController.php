<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\Controller;
use App\Models\Core\Coupon;
use App\Models\Core\Products;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class CouponsController extends Controller
{
    //
    public function __construct(Coupon $coupon, Setting $setting)
    {
        $this->Coupon = $coupon;
        $this->myVarSetting = new SiteSettingController($setting);
        $this->Setting = $setting;

    }

    public function display(Request $request)
    {
        $coupons = Coupon::paginate(15)->toArray();

        return view("admin.coupons.index", ['pageTitle' => 'Coupons'])->with('coupons', $coupons);

    }

    public function add(Request $request)
    {   
        $result = [];

        $result['products'] = Products::where([['prod_status', 'active'], ['prod_quantity', '>', '0']])->get();

        return view("admin.coupons.add", ['pageTitle' => 'Add Coupons'])->with('result' , $result);
    }

    public function filter(Request $request)
    {

        $result = array();
        $message = array();
        $title = array('pageTitle' => Lang::get("labels.EditSubCategories"));
        $name = $request->FilterBy;
        $param = $request->parameter;
        switch ($name) {
            case 'Code':$coupons = Coupon::sortable()->where('code', 'LIKE', '%' . $param . '%')
            ->orderBy('created_at', 'DESC')
            ->paginate(7);

            break;
            case 'CouponType':$coupons = Coupon::sortable()->where('discount_type', 'LIKE', '%' . $param . '%')
            ->orderBy('created_at', 'DESC')
            ->paginate(7);

            break;
            case 'CouponAmount':
            $coupons = Coupon::sortable()->where('amount', 'LIKE', '%' . $param . '%')
            ->orderBy('created_at', 'DESC')
            ->paginate(7);

            break;
            case 'Description':
            $coupons = Coupon::sortable()->where('description', 'LIKE', '%' . $param . '%')
            ->orderBy('created_at', 'DESC')
            ->paginate(7);

            break;
            default:

            break;
        }

        $result['coupons'] = $coupons;
        //get function from other controller
        $result['currency'] = $this->myVarSetting->getSetting();
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.coupons.index", $title)->with('result', $result)->with('coupons', $coupons)->with('name', $name)->with('param', $param);
    }

    

    public function insert(Request $request)
    {

                $check = \App\Models\Core\Coupon::where('coupon_code', $request->coupon_code)->first();

        if ($check) :

            return redirect()->back()->with('success', 'Coupon Code Already Exists!');

        else :

            \App\Models\Core\Coupon::create([

                'coupon_code'                =>   $request->coupon_code,
                'status'                =>   $request->status,

                'coupon_description'         =>   $request->coupon_description,

                'discount_type'              =>   $request->discount_type,

                'discount_amount'            =>   $request->discount_amount,

                'individual_use'             =>   0,

                'usage_limit'                =>   $request->usage_limit,

                'usage_limit_per_user'       =>   100,

                'usage_count'                =>   0,

                'limit_usage_to_x_items'     =>   0,

                'product_categories'         =>   0,

                'excluded_product_categories' =>   0,

                'exclude_sale_items'         =>   0,

                'email_restrictions'         =>   0,

                'minimum_amount'             =>   $request->minimum_amount,

                'maximum_amount'             =>   0,

                'expiry_date'                =>   $request->expiry_date,

                'free_shipping'              =>   0,

                'is_redeem'                  =>   0,

                'overall_usage'              =>   0,

                'product_ids' => json_encode($request->input('product_ids', [])),

            ]);
        return redirect('admin/coupons/display')->with('success','Coupon added successfully!');  

        endif;

    }

    public function edit(Request $request, $id){

        $result = Coupon::where('coupon_ID',$id)->first();

        $result['products'] = Products::where([['prod_status', 'active'], ['prod_quantity', '>', '0']])->get();

        return view("admin.coupons.edit", ['pageTitle' => 'Add Coupons'])->with('result', $result);
    }

    public function update(Request $request){

        Coupon::updateCoupon($request);

        return redirect()->back()->with('success','Coupon updated successfully!'); 

    }

    public function delete(Request $request)
    {
        $deletecoupon = DB::table('coupons')->where('coupon_ID',$request->id)->delete();

        return redirect()->back()->with('success','Coupon deleted successfully');
    }
public function getCouponsAjax(Request $request)
{
    $perPage = $request->input('length', 25); // DataTables uses 'length' instead of 'per_page'
    $start = $request->input('start', 0);     // Start offset
    $draw = $request->input('draw');          // Draw count for DataTables
    $search = $request->input('search.value'); // Search value from DataTables

    $query = Coupon::query();

    // Apply search filter if present
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('coupon_code', 'like', '%' . $search . '%')
              ->orWhere('discount_type', 'like', '%' . $search . '%')
              ->orWhere('discount_amount', 'like', '%' . $search . '%');
        });
    }

    $totalRecords = $query->count();

    // Get paginated result set
    $coupons = $query->orderBy('coupon_ID', 'DESC')
                     ->offset($start)
                     ->limit($perPage)
                     ->get();

    // Format data for DataTables
    $formatted = [];

    foreach ($coupons as $coupon) {
        $formatted[] = [
            'select' => '<input type="checkbox" class="row-select" data-id="' . $coupon->coupon_ID . '">',
            'coupon_ID' => $coupon->coupon_ID,
            'coupon_code' => $coupon->coupon_code,
            'discount_type' => ucfirst($coupon->discount_type),
            'discount_amount' => $coupon->discount_amount,
            'expiry_date' => \Carbon\Carbon::parse($coupon->expiry_date)->format('d M, Y'),
            'action' => '
                <a href="' . asset('admin/coupons/edit/' . $coupon->coupon_ID) . '" class="badge bg-light-blue"><i class="fas fa-edit"></i></a>
                <a href="javascript:delete_popup(\'' . asset('admin/coupons/delete') . '\',' . $coupon->coupon_ID . ');" class="badge delete-popup bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>'
        ];
    }

    return response()->json([
        'draw' => intval($draw),
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $totalRecords,
        'data' => $formatted
    ]);
}
}

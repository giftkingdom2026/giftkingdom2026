<?php

namespace App\Http\Controllers\AdminControllers;



use App\Http\Controllers\Controller;



use App\Models\Web\Users;

use App\Models\Web\Usermeta;

use App\Models\Core\Images;

use App\Models\Core\Products;

use App\Models\Web\Index;

use App\Models\Core\Setting;

use Illuminate\Http\Request;

use DB;

use Hash;


class VendorsController extends Controller

{



    public function display()

    {

        $data = Users::where('role_id',4)->paginate(15);

        $data ? $data = $data->toArray() : '';

        foreach( $data['data'] as &$item ) :

            $item['meta'] = Usermeta::getMeta($item['id']);

        endforeach;

        return view("admin.vendors.index", ['pageTitle' => 'Vendors'])->with('data', $data);

    }

    public function add(){


        return view("admin.vendors.add", ['pageTitle' => 'Vendors']);

    }

public function insert(Request $request)
{
    $data = $request->all();

    $checkEmail = Users::where('email', $data['email'])->first();
    if ($checkEmail) {
        return redirect()->back()->with('success', 'This email has already been registered!');
    }

    $num = rand(0, 100);

    $username = $data['first_name'].'_'.$data['last_name'].$num;

    $check = Users::where('user_name', $username)->first();

    if ($check) {
        $num = rand(0, 100);
        $username = $data['first_name'].'_'.$data['last_name'].$num;
    }

    $arr = [
        'user_name' => strtolower($username),
        'role_id' => 4,
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'email' => $data['email'],
        'phone' => $data['phone'],
    ];

    if (isset($data['password'])) {
        if (isset($data['confirmpassword']) && $data['confirmpassword'] == $data['password']) {
            $arr['password'] = Hash::make($data['password']);
            unset($data['confirmpassword']);
        } else {
            return redirect()->back()->with('success', 'Confirm Password empty or mismatch!');
        }
    }

    $user = Users::create($arr);

    foreach ($data['meta'] as $key => $val) {
        Usermeta::updateOrCreate(
            ['meta_key' => $key, 'user_id' => $user->id],
            ['user_id' => $user->id, 'meta_key' => $key, 'meta_value' => $val]
        );
    }

    return redirect('admin/vendors/display');
}


    public function edit($id){

        $data = Users::where('id', $id )->first()->toArray();

        $meta = Usermeta::where('user_id',$id)->get();

        $meta ? $meta = $meta->toArray() : '';

        $arr = [];

        foreach($meta as $item) :

            $item['meta_value'] = str_contains($item['meta_key'],'image') ? ['path' => Index::get_image_path( $item['meta_value'] ), 'id' => $item['meta_value'] ] : $item['meta_value'];
            
            str_contains($item['meta_key'],'registration') ? 

            $item['meta_value'] = ['path' => Index::get_image_path( $item['meta_value'] ), 'id' => $item['meta_value'] ] : '';

            if( $item['meta_key'] == 'residence_id' ) :

                $val = explode(',', $item['meta_value']);

                foreach( $val as &$file):

                    $file =  ['path' => Index::get_image_path( $file ) , 'id' =>explode(',',$item['meta_value']) ];
                endforeach;

                $item['meta_value'] = $val;

            endif;

            $item['meta_key'] == 'bank_confirmation' ? 

            $item['meta_value'] = ['path' => Index::get_image_path( $item['meta_value'] ), 'id' => $item['meta_value'] ] : '';

            $item['meta_key'] == 'residence_visa' ? 

            $item['meta_value'] = ['path' => Index::get_image_path( $item['meta_value'] ), 'id' => $item['meta_value'] ] : '';


            // isset($item['meta_value']['path']) && str_contains($item['meta_value']['path'], '.pdf') ? $item['meta_value']['path'] = 'images/document.png' : '';

            $arr[$item['meta_key']] = $item['meta_value'];


        endforeach; 

        $data['metadata'] = $arr;

        // dd($arr);
        return view("admin.vendors.edit", ['pageTitle' => 'Vendors'])->with('data', $data);

    }

public function update(Request $request)
{
    $check = $request->all();

    unset($check['_token'], $check['id']);

    $arr = [
        'first_name' => $check['first_name'] ?? '',
        'last_name'  => $check['last_name'] ?? '',
        'email'      => $check['email'] ?? '',
        'phone'      => $check['phone'] ?? '',
    ];

    if (!empty($check['password'])) {
        if (!empty($check['confirmpassword']) && $check['confirmpassword'] == $check['password']) {
            $arr['password'] = Hash::make($check['password']);
        } else {
            return redirect()->back()->with('error', 'Confirm Password empty or mismatch!');
        }
    }

    unset(
        $check['first_name'],
        $check['last_name'],
        $check['email'],
        $check['phone'],
        $check['password'],
        $check['confirmpassword']
    );

    Users::where('id', $request->id)->update($arr);

    if (isset($check['meta'])) {
        foreach ($check['meta'] as $key => $value) {
            Usermeta::updateOrCreate(
                [
                    'user_id'  => $request->id,
                    'meta_key' => $key,
                ],
                [
                    'meta_value' => $value,
                ]
            );
        }
        unset($check['meta']);
    }

    foreach ($check as $key => $value) {
        Usermeta::updateOrCreate(
            [
                'user_id'  => $request->id,
                'meta_key' => $key,
            ],
            [
                'meta_value' => $value,
            ]
        );
    }

    return redirect()->back()->with('success', 'Vendor has been updated successfully');
}


    public function delete(Request $request){

        Users::where('id',$request->id)->delete();

        Usermeta::where('user_id',$request->id)->delete();

        Products::where('author_id',$request->id)->delete();

        return redirect()->back()->with('success','Vendors Deleted Successfully!');
    }


    public function storesListing(Request $request)
    {
        $title = array('pageTitle' => '');
        $result = array();
        $message = array();
        $store = DB::table('stores')
        ->leftJoin('users', 'users.id', '=', 'stores.vendor_id')
        ->select('stores.*', 'users.user_name')
        ->paginate(20);

        $result['message'] = $message;
        $result['store'] = $store;
        // $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.store.index", $title)->with('result', $result);
    }

    public function updateStatus(Request $request)
    {
     $check=DB::table('stores')->where('id','=',$request->id)->first();
     if($check->status == '1'){
      $status=0;
  }else{
      $status=1;
  }
  DB::table('stores')->where('id','=',$request->id)->update([
      'status'=>$status,
  ]);
  $message='Store Has Been Active';
  return redirect()->back()->withErrors([$message]);

}


    public function getVendorsAjax(Request $request)
    {
        $perPage = (int) $request->input('length', 25);
        $start = (int) $request->input('start', 0);
        $draw = (int) $request->input('draw');
        $search = $request->input('search.value');

        $query = Users::where('role_id', 4);
        if (!empty($search)) {
    $query->where(function ($q) use ($search) {
        $q->where('users.first_name', 'like', "%{$search}%")
            ->orWhere('users.last_name', 'like', "%{$search}%")
            ->orWhere('users.email', 'like', "%{$search}%")
            ->orWhere('users.phone', 'like', "%{$search}%")
            // Search by vendor_name and vendor_email from usermeta
            ->orWhereIn('users.id', function ($sub) use ($search) {
                $sub->select('user_id')
                    ->from('usermeta')
                    ->where('meta_key', 'store_name')
                    ->where('meta_value', 'like', "%{$search}%");
            });
    });
}
        $total = $query->count();

        $vendors = $query->offset($start)
            ->limit($perPage)
            ->orderBy('users.id', 'DESC')
            ->get();
        $formatted = $vendors->map(function ($vendor) {
            
            $meta = Usermeta::getMeta($vendor->id);
            // dd($meta);
            $statusText = $vendor->status == '1' ? 'Active' : 'Inactive';
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
                        <a href="' . asset('admin/vendors/edit/' . $vendor->id) . '" class="w-100 border-0 d-flex justify-content-between">Edit</a>
                    </li>
                    <li>
                        <a href="javascript:delete_popup(\'' . asset('admin/vendors/delete') . '\',' . $vendor->id . ');" class="w-100 border-0 d-flex justify-content-between">Delete</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
';


            return [
                'select' => '<input type="checkbox" class="row-select" data-id="' . $vendor->id . '">',
                'id' => $vendor->id,
                'email' => $meta['vendor_email'],
                'phone' => $meta['vendor_phone'],
                'status' => !empty($meta['approved']) ? "Approved" : "Not Approved",


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

}


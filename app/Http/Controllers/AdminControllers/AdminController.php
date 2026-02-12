<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\Core\Languages;
use App\Models\Core\Setting;
use App\Models\Admin\Admin;
use App\Models\Core\Order;
use App\Models\Core\Customers;
use App\Models\Core\Products;
use App\Models\Web\Analytics;
use App\Models\Core\Posts;
use App\Models\Web\Users;
use App\Models\Web\Usermeta;
use App\Models\Core\Megamenu;
use Illuminate\Http\Request;
use App\Models\Core\Templates;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminControllers\PostsController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Exception;
use App\Models\Core\Images;
use Illuminate\Support\Facades\Validator;
use Hash;
use Auth;
use ZipArchive;
use File;

class AdminController extends Controller
{
	private $domain;
	public function __construct(Admin $admin, Setting $setting, Order $order, Customers $customers, Images $images)
	{

		$this->Setting = $setting;
		$this->Admin = $admin;
		$this->Order = $order;
		$this->Customers = $customers;
		$this->images = $images;
	}

	public function getAdmins(Request $request)
	{
		$length = $request->input('length', 10);
		$start = $request->input('start', 0);
		$search = $request->input('search.value');
		$draw = $request->input('draw');

		$query = Users::where('role_id', 2); // assuming 3 = customers

		if ($search) {
			$query->where(function ($q) use ($search) {
				$q->where('first_name', 'like', "%$search%")
					->orWhere('last_name', 'like', "%$search%")
					->orWhere('email', 'like', "%$search%")
					->orWhere('phone', 'like', "%$search%");
			});
		}

		$total = $query->count();

		$admins = $query->offset($start)->limit($length)->orderBy('created_at', 'DESC')->get();

		$data = [];

		foreach ($admins as $admin) {
			$fullName = $admin->first_name . ' ' . $admin->last_name;
			$status = $admin->status == 1 ? 'Deactivate' : 'Activate';

			$action = '
			<div class="careerFilter">
				<div class="child_option position-relative">
					<button class="dots open-menu2 bg-transparent border-0 p-0" type="button">
						<!-- Dots Icon -->
						<svg height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512">
															<path d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"></path>
														</svg>
					</button>
					<div class="dropdown-menu2 dropdown-menu-right" style="display: none;">
						<ul class="careerFilterInr">
						<li><a href="' . asset('admin/editaccess/' . $admin->id) . '">Edit Access
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="15" height="15">
																			<path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z" />
																		</svg></a></li>
							<li><a href="' . asset('admin/editadmin/' . $admin->id) . '">Edit
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="15" height="15">
																			<path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z" />
																		</svg></a></li>
							<li><a href="javascript:delete_popup(\'' . asset('admin/admin/delete') . '\',' . $admin->id . ');">Delete

							<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 448 512">
																			<path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z" />
																		</svg></a></li>
							<li>
								<form method="POST" action="' . route('update-customer-status', $admin->id) . '">'
				. csrf_field() . '
									<input type="hidden" name="status" value="' . ($admin->status == 1 ? '0' : '1') . '">
									<button type="submit" style="padding: 0.75rem 0.938rem;" class="w-100 border-0 bg-transparent d-flex justify-content-between align-items-center">' . $status . '
									<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 512 512">
																				<path d="M256 48C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48zm93.3 241.1c4.7 4.7 4.7 12.3 0 17L313 342.4c-4.7 4.7-12.3 4.7-17 0L256 302.6l-40 39.8c-4.7 4.7-12.3 4.7-17 0l-36.3-36.3c-4.7-4.7-4.7-12.3 0-17L202.6 256l-40-39.8c-4.7-4.7-4.7-12.3 0-17l36.3-36.3c4.7-4.7 12.3-4.7 17 0l40 39.8 40-39.8c4.7-4.7 12.3-4.7 17 0l36.3 36.3c4.7 4.7 4.7 12.3 0 17L309.4 256l39.9 33.1z" />
																			</svg>
									</button>

								</form>
							</li>
						</ul>
					</div>
				</div>
			</div>';
			$adminStatus = '';
			if ($admin->status == 0) {
				$adminStatus = 'Deactive';
			} else if ($admin->status == 1) {
				$adminStatus = 'Active';
			}
			$data[] = [
				'select' => '<input type="checkbox" name="select" class="row-select" data-id="' . $admin->id . '">',
				'id' => $admin->id,
				'name' => $fullName,
				'email' => $admin->email,
				'phone' => $admin->phone,
				'status' => $adminStatus,
				'action' => $action,
			];
		}

		return response()->json([
			'draw' => intval($draw),
			'recordsTotal' => $total,
			'recordsFiltered' => $total,
			'data' => $data,
		]);
	}
	public function template(Request $request)
	{

		$check = Templates::where('id', $request->direction)->first()->toArray();

		if ($check) {

			return view("admin.templates.fields")->with('fields', $check['data']);
		}

		if (view()->exists("admin.templates." . $_POST['direction'])) {

			return view("admin.templates." . $_POST['direction']);
		} else {

			return view("admin.templates.default");
		}
	}


	public function dashboard(Request $request)
	{


		$title = ['pageTitle' => 'Dashboard'];

		$result['products'] = Products::getDashboardProducts();

		$result['orders'] = Order::getDashboardOrders();

		$result['customers'] = Users::getDashboardCustomers();

		$result['blogs'] = Posts::where('post_type', 'blogs')->limit(4)->get()->toArray();

		$result['blogs'] = PostsController::parsePostContent($result['blogs']);

		$result['analytics']['month'] = Order::getOrdersByMonth();

		$result['analytics']['monthly'] = Order::getOrdersByYear();

		$result['analytics']['yearly'] = Order::getOrdersByYears();
		$result['analytics']['daily'] = Order::getOrdersByDaily();

		$result['analytics']['user'] = Analytics::getData();

		$where = [['prod_parent', 0], ['prod_status', 'active']];

		!in_array(Auth::user()->role_id, [1, 2])  ? $where[] = ['author_id', Auth::user()->id] : '';

		$result['products_count'] = Products::where($where)->count();

		$result['orders_count'] = Order::getCount();

		$result['customer_count'] = Users::where([['role_id', 3], ['status', 1]])->count();

		$result['gross_sales'] = Order::getSales();

		return view("admin.dashboard", $title)->with('result', $result);
	}


	public function login()
	{
		$result = array();
		$result['commonContent'] = $this->Setting->commonContent();
		if (Auth::check()) {
			return redirect('/admin/dashboard/');
		} else {
			$title = array('pageTitle' => Lang::get("labels.login_page_name"));
			return view("admin.login", $title)->with('result', $result);
		}
	}

	public function admininfo()
	{
		$administor = administrators::all();
		return view("admin.login", $title);
	}

	//login function
public function checkLogin(Request $request)
{
    $validator = Validator::make(
        [
            'email'    => $request->email,
            'password' => $request->password,
        ],
        [
            'email'    => 'required|email',
            'password' => 'required',
        ]
    );

    if ($validator->fails()) {
        return redirect('admin/login')->withErrors($validator)->withInput();
    }

    $user = DB::table('users')->where('email', $request->email)->first();

    if (!$user) {
        return redirect('admin/login')->with('loginError', Lang::get("labels.EmailPasswordIncorrectText"));
    }

    if ($user->status == 0) {
        return redirect('admin/login')->with('loginError', Lang::get("Your Account Is Deactivated"));
    }

    $adminInfo = ["email" => $request->email, "password" => $request->password];

    if (auth()->attempt($adminInfo)) {
        $admin = auth()->user();
        $administrators = DB::table('users')->where('id', $admin->myid)->get();

        if ($user->id == 223) {
            return redirect()->intended('admin/orders/display/')->with('administrators', $administrators);
        }

        return redirect()->intended('admin/dashboard/')->with('administrators', $administrators);
    }

    // fallback for wrong password
    return redirect('admin/login')->with('loginError', Lang::get("labels.EmailPasswordIncorrectText"));
}


	//logout
	public function logout()
	{
		Auth::guard('admin')->logout();
		return redirect()->intended('admin/login');
	}



	//updateProfile
	public function updateProfile(Request $request)
	{
		$updated_at	= date('y-m-d h:i:s');
		$myVar = new SiteSettingController();
		$languages = $myVar->getLanguages();
		$extensions = $myVar->imageType();

		$uploadImage = $request->oldImage;
		$orders_status = DB::table('users')->where('id', '=', Auth()->user()->id)->update([
			'user_name'		=>	$request->user_name,
			'first_name'	=>	$request->first_name,
			'last_name'		=>	$request->last_name,
			'country'		=>	$request->country,
			'phone'			=>	$request->phone,
			'avatar'		=>	$uploadImage,
			'updated_at'	=>	$updated_at
		]);

		$message = Lang::get("labels.ProfileUpdateMessage");
		return redirect()->back()->withErrors([$message]);
	}

	//updateProfile
	public function updateAdminPassword(Request $request)
	{

		$orders_status = DB::table('users')->where('id', '=', auth()->user()->myid)->update([
			'password'		=>	Hash::make($request->password)
		]);

		$message = Lang::get("labels.PasswordUpdateMessage");
		return redirect()->back()->withErrors([$message]);
	}

	public function sorting(Request $request)
	{

		$check = $request->all();

		if ($request->type == 'terms') :

			Terms::updateOrder($check);

		elseif ($request->type == 'posts') :

			Posts::updateOrder($check);

		elseif ($request->type == 'category') :

			Categories::updateOrder($check);

		elseif ($request->type == 'megamenu') :

			Megamenu::updateOrder($check);

		endif;
	}

	//Admins

	public function admins(Request $request)
	{

		$data = Users::where('role_id', 2)->paginate(9);

		$data ? $data = $data->toArray() : '';

		foreach ($data['data'] as &$item) :

			$item['meta'] = Usermeta::getMeta($item['id']);

		endforeach;

		return view("admin.admins.index", ['pageTitle' => 'Admins'])->with('data', $data);
	}

	public function addadmins(Request $request)
	{

		return view("admin.admins.add", ['pageTitle' => 'Add Admin']);
	}

	public function addnewadmin(Request $request)
	{
		if ($request->password !== $request->confirmpassword) {
			return redirect()->back()->with('success', 'Passwords do not match!');
		}

		$messages = [
			'email.unique'   => 'The email address is already registered.',
			'password.min'   => 'Password must be at least 6 characters.',
			'email.email'    => 'Please enter a valid email address.',
			'email.required' => 'Email is required.',
			'phone.required' => 'Phone number is required.',
			'password.required' => 'Password is required.',
		];

		$validator = Validator::make($request->all(), [
			'first_name' => 'required|string|max:100',
			'last_name'  => 'required|string|max:100',
			'email'      => 'required|email|unique:users,email',
			'password'   => 'required|min:6',
		], $messages);

		if ($validator->fails()) {
			return redirect()->back()->with('success', $validator->errors()->first())->withInput();
		}

		do {
			$username = strtolower($request->first_name . '_' . $request->last_name . rand(0, 100));
		} while (Users::where('user_name', $username)->exists());

		Users::create([
			'user_name'  => $username,
			'role_id'    => 2,
			'first_name' => $request->first_name,
			'last_name'  => $request->last_name,
			'email'      => $request->email,
			'phone'      => $request->phone,
			'password'   => Hash::make($request->password),
		]);

		return redirect('admin/admins')->with('success', 'Admin Added Successfully!');
	}



	public function editadmin(Request $request)
	{

		$data = Users::getUserData($request->id);

		return view("admin.admins.edit", ['pageTitle' => 'Edit Admin'])->with('data', $data);
	}


	public function updateadmin(Request $request)
	{

		$data = $request->all();

		if (isset($data['password'])) :

			if ($data['password'] == $data['confirmpassword']) :

				$data['password'] = Hash::make($data['password']);

			endif;

			unset($data['confirmpassword']);

		endif;

		if (isset($data['meta'])) :

			foreach ($data['meta'] as $key => $value) :

				Usermeta::updateOrCreate(['meta_key' => $key, 'user_id' => $data['id']], [

					'user_id' => $data['id'],
					'meta_key' => $key,
					'meta_value' => $value
				]);

			endforeach;

			unset($data['meta']);

		endif;

		unset($data['_token']);

		unset($data['confirmpassword']);

		Users::where('id', $data['id'])->update($data);

		return redirect()->back()->with('success', 'Record Updated Successfully!');
	}

	public function updatepassword(Request $request)
	{
		$update = $this->Admin->updatepassword($request);
		$message = Lang::get("labels.PasswordUpdateMessage");
		return redirect()->back()->withErrors([$message]);
	}

	//deleteProduct
	public function delete(Request $request)
	{

		Users::where('id', $request->id)->delete();

		return redirect()->back()->with('success', 'Admin Deleted Successfully!');
	}


	public function editAccess(Request $request, $id)
	{

		$user = Users::where('id', $id)->first();
		$result['user'] = $user;
		$arr = Usermeta::where('user_id', $id)->where('meta_key', 'access')->pluck('meta_value')->first();

		$result['arr'] = unserialize($arr);

		// $result['default'] = [
		// 	"dashboard","mobile-application","mega-menu","menu","pages","blogs","jobs","faqs","questions","offers","coupons","abandoned-cart","categories","deals","brands","attributes","products","inventory","reviews","prodquestions","orders","low-stock-products","out-of-stock-products","customers-order-total","sales-report","vendors","customers","wallet","media","settings","home-page",
		// ];

		// $result['default'] = [
		// "dashboard","menu","pages","home-page",'blogs',"faqs","banners",'events',"coupons","categories",'attributes',"products","inventory",'reviews',"orders","low-stock-products","out-of-stock-products","customers-order-total","sales-report","customers","media","settings",'contact-form'
		// ];

		$result['default'] = [
			"dashboard",
			"menu",
			"pages",
			"home-page",
			"blogs",
			"faqs",
			"banners",
			"events",
			"reasons",
			"coupons",
			"abandoned-cart",
			"categories",
			"brands",
			"attributes",
			"products",
			"inventory",
			"reviews",
			"orders",
			"low-stock-products",
			"out-of-stock-products",
			"customers-order-total",
			"sales-report",
			"vendors",
			"customers",
			"customer-wallet",
			"currency",
			"media",
			"app-labels",
			"settings",
			"contact-form",
			"event-inquiry-form"
		];

		return view("admin.admins.access", ['pageTitle' => 'Admins'])->with('data', $result);
	}

	public function updateAccess(Request $request, $id)
	{

		$data = $request->all();
		unset($data['_token']);

		$arr = serialize($data);
$meta = Usermeta::where('user_id', $id)
                ->where('meta_key', 'access')
                ->first();

if ($meta) {
    $meta->update(['meta_value' => $arr]);
} else {
    Usermeta::create([
        'user_id' => $id,
        'meta_key' => 'access',
        'meta_value' => $arr,
    ]);
}

		return redirect()->back()->with('success', 'Access Updated Successfully!');
	}

	public function ContactForm()
	{

		$title 	= 	'Contact';

		$data['list'] = DB::table('inquiry')->get();

		return view("admin.forms.contact-form")->with('result', $data)->with('title', $title);
	}
	public function EventInquiryForm()
	{

		$title 	= 	'Event Inquiries';

		$data['list'] = DB::table('event_inquiries')->get();

		return view("admin.forms.event-inquiry-form")->with('result', $data)->with('title', $title);
	}
	public function ContactDelete(Request $request)
	{

		DB::table('inquiry')->where('id', $request->id)->delete();

		return redirect()->back();
	}
	public function EventInquiryDelete(Request $request)
	{
		DB::table('event_inquiries')->where('id', $request->id)->delete();

		return redirect()->back();
	}
	public function ContactFormAjax(Request $request)
	{
		$perPage = (int) $request->input('length', 10);
		$start = (int) $request->input('start', 0);
		$draw = (int) $request->input('draw');
		$search = $request->input('search.value');
		if (Auth::user()->role_id == 4) {
			$query = DB::table('inquiry')->where('vendor_id', Auth::user()->id)->orderBy('created_at', 'desc');
		} else {
			$query = DB::table('inquiry')->where('vendor_id', null)->orderBy('created_at', 'desc');
		}

		if (!empty($search)) {
			$query->where(function ($q) use ($search) {
				$q->where('name', 'like', "%{$search}%")
					->orWhere('email', 'like', "%{$search}%")
					->orWhere('subject', 'like', "%{$search}%")
					->orWhere('message', 'like', "%{$search}%");
			});
		}

		$total = $query->count();

		$inquiries = $query->offset($start)
			->limit($perPage)
			->get();

		$formatted = $inquiries->map(function ($item, $index) use ($start) {
			$deleteUrl = asset('admin/contact-delete');
			return [
				'select' => '<input type="checkbox" class="row-select" data-id="' . $item->id . '">',
				'serial' => $start + $index + 1,
				'name' => $item->name,
				'email' => $item->email,
				'subject' => $item->subject,
				'message' => $item->message,
				'support_category' => $item->support_category,
				'received_date' => date('d-m-Y', strtotime($item->created_at)),
				'action' => '<a href="javascript:delete_popup(\'' . $deleteUrl . '\', ' . $item->id . ');" class="badge delete-popup bg-red">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>',
			];
		})->all();

		if ($request->ajax()) {
			return response()->json([
				'draw' => $draw,
				'recordsTotal' => $total,
				'recordsFiltered' => $total,
				'data' => $formatted
			]);
		}

		// Fallback for non-AJAX (initial page load)
		$title = 'Contact';
		$data['list'] = DB::table('inquiry')->orderBy('created_at', 'desc')->paginate($perPage);

		return view("admin.forms.contact-form")
			->with('result', $data)
			->with('title', $title)
			->with('perPage', $perPage);
	}

	public function EventInquiryAjax(Request $request)
	{
		$perPage = (int) $request->input('length', 10);
		$start = (int) $request->input('start', 0);
		$draw = (int) $request->input('draw');
		$search = $request->input('search.value');

		$query = DB::table('event_inquiries')->orderBy('created_at', 'DESC');

		if (!empty($search)) {
			$query->where(function ($q) use ($search) {
				$q->where('name', 'like', "%{$search}%")
					->orWhere('email', 'like', "%{$search}%")
					->orWhere('event', 'like', "%{$search}%")
					->orWhere('message', 'like', "%{$search}%")
					->orWhere('phone', 'like', "%{$search}%");
			});
		}

		$total = $query->count();

		$inquiries = $query->offset($start)
			->limit($perPage)
			->get();

		$formatted = $inquiries->map(function ($item, $index) use ($start) {
			$deleteUrl = asset('admin/event-inquiry-delete');

			$viewButton = '<button type="button" class="btn btn-sm viewEventDetails"
		data-name="' . e($item->name) . '"
		data-email="' . e($item->email) . '"
		data-event="' . e($item->event) . '"
		data-event-date="' . ($item->event_date ? date('d-m-Y', strtotime($item->event_date)) : '-') . '"
		data-guests="' . ($item->guest_count ?? '-') . '"
		data-phone="' . ($item->phone ?? '-') . '"
		data-message="' . e($item->message ?? '-') . '"
		data-created="' . date('d-m-Y', strtotime($item->created_at)) . '">
		<i class="fa fa-eye" aria-hidden="true"></i>
	</button>';

			$deleteButton = '<a href="javascript:delete_popup(\'' . $deleteUrl . '\', ' . $item->id . ');" class="badge delete-popup bg-red">
		<i class="fa fa-trash" aria-hidden="true"></i>
	</a>';

			return [
				'select' => '<input type="checkbox" class="row-select" data-id="' . $item->id . '">',

				'serial' => $start + $index + 1,
				'name' => $item->name,
				'email' => $item->email,
				'event' => $item->event,
				'received_date' => date('d-m-Y', strtotime($item->created_at)),
				'event_date' => date('d-m-Y', strtotime($item->event_date)),
				'action' => $viewButton . ' ' . $deleteButton,

				// 👇 Add these hidden fields for exporting
				'phone' => $item->phone ?? '-',
				'guest_count' => $item->guest_count ?? '-',
				'message' => $item->message ?? '-',
			];
		})->all();



		if ($request->ajax()) {
			return response()->json([
				'draw' => $draw,
				'recordsTotal' => $total,
				'recordsFiltered' => $total,
				'data' => $formatted
			]);
		}

		// fallback view render (non-AJAX)
		$title = 'Event Inquiries';
		$data['list'] = DB::table('event_inquiries')->orderBy('created_at', 'desc')->paginate($perPage);

		return view("admin.forms.event-inquiry-form")
			->with('result', $data)
			->with('title', $title)
			->with('perPage', $perPage);
	}
}

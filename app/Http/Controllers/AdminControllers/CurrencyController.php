<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\Core\Languages;
use App\Models\Core\Currency;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Exception;
use App\Models\Core\Images;


class CurrencyController extends Controller
{
  public function __construct(Currency $currencies, Setting $setting)
  {
    $this->currencies = $currencies;
    $this->Setting = $setting;
  }
public function getCurrencies(Request $request)
{
    $perPage = $request->input('length', 10);
    $start = $request->input('start', 0);
    $draw = $request->input('draw');
    $search = $request->input('search.value');

    $query = Currency::query();

    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('code', 'like', "%{$search}%")
              ->orWhere('symbol_left', 'like', "%{$search}%")
              ->orWhere('symbol_right', 'like', "%{$search}%");
        });
    }

    $totalRecords = $query->count();
    $currencies = $query->offset($start)
        ->limit($perPage)
        ->get();

    $data = [];

    foreach ($currencies as $index => $currency) {
        $data[] = [
            'id' => ($start + $index + 1) . ($currency->id == 1 ? ' <span class="label label-success">Default</span>' : ''),
            'title' => $currency->title,
            'code' => $currency->code,
            'symbol' => $currency->symbol_left . ' ' . $currency->symbol_right,
            'placement' => !empty($currency->symbol_left) ? 'Left' : 'Right',
            'decimal_places' => $currency->decimal_places,
            'value' => $currency->value,
            'action' => '<a href="' . url('admin/currencies/edit/' . $currency->id) . '" class="badge bg-red"><i class="fa fa-edit"></i></a>'
                . ($currency->id != 1 ? ' <a href="#" class="badge bg-red currency-delete-btn" data-id="' . $currency->id . '"><i class="fa fa-trash"></i></a>' : '')
        ];
    }

    return response()->json([
        'draw' => intval($draw),
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $totalRecords,
        'data' => $data
    ]);
}
  public function display(){
    $title = array('pageTitle' => Lang::get("labels.Currency"));
    $currencies = $this->currencies->paginator();
    $result['commonContent'] = $this->Setting->commonContent();
    return view("admin.currencies.index",$title)->with('result', $result)->with('currencies', $currencies);
  }


  public function filter(Request $request){
    $title = array('pageTitle' => Lang::get("labels.SubCategories"));
    $categories = $this->Categories->filter($request);
    return view("admin.categories.index", $title)->with(['categories'=> $categories, 'name'=> $request->FilterBy, 'param'=> $request->parameter]);
  }

  public function add(Request $request){
    $title = array('pageTitle' => Lang::get("labels.Add Currency"));
    $currencies = DB::table('currency_record')->get();
    $result['commonContent'] = $this->Setting->commonContent();
    return view("admin.currencies.add",['title' => $title, 'currencies' => $currencies, 'result' => $result]);
  }

  public function insert(Request $request){
    //check already has
    $exist = $this->currencies->checkexist($request);
    if($exist){
      $message = Lang::get("labels.Currency already exist");
      return redirect()->back()->withErrors([$message]);
    }else{
      $this->currencies->insert($request);
      $message = Lang::get("labels.Currency Addded Successfully");
      return redirect()->back()->with('success',$message);
    }
  }

  public function edit($currency_id){
    $title = array('pageTitle' => Lang::get("labels.Edit Currency"));
    $result = array();
    $currencies = DB::table('currency_record')->get();
    $currency = $this->currencies->recordToUpdate($currency_id);
    $result['currency'] = $currency;
    $result['warning'] = 0;
    $result['commonContent'] = $this->Setting->commonContent();
    return view("admin.currencies.edit",['title' => $title,'currencies' => $currencies])->with('result', $result);
   }

   public function warningedit($currency_id){
     $title = array('pageTitle' => Lang::get("labels.Edit Currency"));
     $result = array();
     $currencies = DB::table('currency_record')->get();
     $currency = $this->currencies->recordToUpdate($currency_id);
     $result['currency'] = $currency;
     $result['warning'] = 1;
     $result['commonContent'] = $this->Setting->commonContent();
     return view("admin.currencies.edit",['title' => $title,'currencies' => $currencies])->with('result', $result);
    }

   public function update(Request $request){

    $exist = $this->currencies->checkexistupdate($request);
    if($exist){
      $message = Lang::get("labels.Currency already exist");
      return redirect()->back()->withErrors([$message]);
    }else{
      $id = $this->currencies->updaterecord($request);
      if($id == 0){
        $message = Lang::get("labels.You have orders in your databse with current currency. Are you sure you want to change this currency. If yes then submit form again. This act is tatally your own responsabilty.");
        return redirect('/admin/currencies/edit/warning/'.$request->id)->with('error', $message);
      }
      $message = Lang::get("labels.Currency Edit Successfully");
      return redirect('/admin/currencies/edit/'.$id)->with('success', $message);
    }


    }

    public function delete(Request $request){
      $deletecategory = $this->currencies->deleterecord($request);
      $message = Lang::get("labels.Currency Deleted Successfully");
      return redirect()->back()->withErrors([$message]);
    }
}

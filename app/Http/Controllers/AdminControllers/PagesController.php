<?php

namespace App\Http\Controllers\AdminControllers;

use App;
use App\Http\Controllers\Controller;
use App\Models\Web\Index;
use App\Models\Core\Pages;
use App\Models\Core\Templates;
use App\Models\Core\Content;
use Illuminate\Http\Request;
use Lang;
use App\Models\Core\Setting;
use DB;
class PagesController extends Controller
{
    public function __construct(Setting $setting)
    {
        $this->Setting = $setting;
    }
public function getPagesAjax(Request $request)
{
    $perPage = $request->input('length', 10);
    $start = $request->input('start', 0);
    $draw = $request->input('draw');
    $search = $request->input('search.value');

    $columns = ['page_id','slug', 'template'];

    $query = Pages::query();
 if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('slug', 'like', "%{$search}%");
        });
    }

    if ($order = $request->input('order.0')) {
        $columnIndex = $order['column'];
        $dir = $order['dir'];

        $sortColumn = $columns[$columnIndex] ?? 'page_id';
        $query->orderBy($sortColumn, $dir);
    } else {
        $query->orderBy('page_id', 'asc');
    }

    $totalRecords = $query->count();

    $pages = $query->offset($start)
        ->limit($perPage)
        ->get();

    $data = [];

    foreach ($pages as $page) {
        $pageTitle = Content::where([
            ['page_id', '=', $page->page_id],
            ['content_key', '=', 'pagetitle']
        ])->value('content_value') ?? '';

        $template = Templates::where('id', $page->template)->value('name') ?? 'Default';

        $editUrl = asset('admin/page/edit/' . $page->page_id);
        $deleteUrl = $page->page_id > 102 ? asset('admin/page/delete/' . $page->page_id) : null;

        $data[] = [
            'checkbox' => '<input type="checkbox" name="select" class="row-select" data-id="' . $page->page_id . '">',
            'page_title' => $pageTitle,
            'slug' => $page->slug,
            'template' => $template,
            'actions' => '',
            'edit_url' => $editUrl,
            'delete_url' => $deleteUrl,
            'page_id' => $page->page_id
        ];
    }

    return response()->json([
        'draw' => intval($draw),
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $totalRecords,
        'data' => $data
    ]);
}

    public function pages(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.Pages"));

        $result = Pages::all()->toArray(); 

        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.pages.index", $title)->with('result', $result);

    }


    public function addpage(Request $request)
    {
        if(auth()->user()->is_edit== 0){
            abort('404');
        }
        $title = array('pageTitle' => Lang::get("labels.AddPage"));
        $result = Pages::addpage(); 
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.pages.add", $title)->with('result', $result);

    }

    

    public function webpages(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.Pages"));
        
        $result = Pages::all()->toArray(); 

        foreach($result as $key => $page) :

            $result[$key]['page_title'] = current(Content::where([

                ['page_id', '=', $page['page_id']],
                ['content_key', '=','pagetitle']

            ])->pluck('content_value')->toArray());

            $result[$key]['template'] = current(

                Templates::where('id',$page['template'])
                ->pluck('name')->toArray()

            );

            $result[$key]['template'] == '' ? $result[$key]['template'] = 'Default' : '';

        endforeach;

        return view("admin.pages.index", $title)->with('result', $result);

    }
    

    public function addwebpage(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.AddPage"));
        
        $result['commonContent'] = $this->Setting->commonContent();
        
        $result['templates'] = Templates::where('type','page')->get();

        return view("admin.pages.add", $title)->with('result', $result);

    }



    public function addnewwebpage(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddPage"));

        Pages::addnewwebpage($request);
        
        return redirect(asset('admin/page/list'))->with('success','Page Added Successfully!');
    }


    public function editwebpage(Request $request)
    {   

        // if(auth()->user()->is_edit== 0){ return redirect('/'); }

        $title = array('pageTitle' => Lang::get("labels.EditPage"));

        $result = Pages::editwebpage($request); 

        $result['content'] = Index::parseContent( $result['content'] );

        ($result['content']['template'] != 'default' ) ? 
        
        $result['template'] = Templates::get_template( $result['content']['template'] ) :

        '';

        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.pages.edit", $title)->with('result', $result);
    }

    function changeLang(Request $request){

        $result = Pages::langData($request->id,$request->lang); 

        $result['content'] = Index::parseContent( $result['content'] );

        !isset($result['content']['template']) ? $result['content']['template'] = Content::where([[ 'page_id',$request->id ],['content_key','template']])->pluck('content_value')->first() : '';

        ($result['content']['template'] != 'default' ) ? 
        
        $result['template'] = Templates::get_template( $result['content']['template'] ) : '';

        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.pages.fields")->with('result', $result)->render();

    }

    /*------------------------------------------------ Update Web Pages -----------------------------------------*/
    public function updatewebpage(Request $request)
    {
        Pages::updatewebpage($request);

        return redirect()->back()->with('success','Page Updated Successfully!');
    }


    /*------------------------------------------------ Delete Pages -----------------------------------------*/


    public function deletepage(Request $request)
    {
        Pages::deletepage($request);

        return redirect()->back()->with('success','Page has been deleted successfully!');
    }


    /*------------------------------------------------ Status Web Pages -----------------------------------------*/
    public function pageWebStatus(Request $request)
    {
        Pages::pageWebStatus($request);
        return redirect()->back()->withErrors([Lang::get("labels.PageStatusMessage")]);
    }

}

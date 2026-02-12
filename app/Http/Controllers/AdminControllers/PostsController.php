<?php
namespace App\Http\Controllers\AdminControllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Web\Index;
use App\Models\Core\Images;
use App\Models\Core\Posts;
use App\Models\Core\Posttypes;
use App\Models\Core\Postmeta;
use App\Models\Core\Templates;
use App\Models\Core\Products;
use App\Models\Core\Taxonomy;
use App\Models\Core\Terms;
use App\Models\Core\TermRelations;
use DB;

class PostsController extends Controller{


	public function view(Request $request){
		
		$data['taxonomy'] = Taxonomy::exists($request->post_type);

		$title = Posttypes::where('post_type' , $request->post_type )->first();

		$data['post_type'] = ['type' => $request->post_type , 'title' => $title->post_type_title ];

		$data['post_type_data'] = Posts::where('post_type' , $request->post_type )->orderBy('created_at','DESC')->paginate(10)->toArray();

		$data['post_type_data']['data'] = self::parsePostContent($data['post_type_data']['data']);

		foreach($data['taxonomy'] as $tax => $taxonomy) :

			foreach( $data['post_type_data']['data'] as $key => $post ) :

				$data['post_type_data']['data'][$key]['termdata'][$taxonomy['taxonomy_slug']] = TermRelations::getTerms($post['ID'],$taxonomy['id']);

			endforeach;

		endforeach;

		$title = array('pageTitle' => $title->post_type_title );

		return view("admin.posts.index",$title)->with('data', $data);
	}

	public function add(Request $request){
		
		$title = Posttypes::where('post_type' , $request->post_type )->first();

		$data['post_type'] = ['type' => $request->post_type , 'title' => $title->post_type_title ];
		
		$data['template'] = Templates::where('type',$request->post_type)->first();

		$checktax = Taxonomy::exists($request->post_type);

		$data['taxonomy'] = Terms::get_terms($checktax);

		$request->post_type == 'offers' ? $data['products'] = Products::all()->toArray() : '';

		$title = array('pageTitle' => 'Add '.$title->post_type_title );

		return view("admin.posts.add",$title)->with('data', $data);

	}

	public function create(Request $request){
		$check = $request->all();
		unset( $check[ '_token' ] );
		// $j = 0;

		// $titles = ['Birthday Event','Wedding Event','Cooperate Event','Graduation Party Event'];

		// $imgs = [11493,11494,11495,11496];

		// for($i=0; $i < 8; $i++){

		// 	$j++;

		// 	$check['pagetitle'] = $titles[($j - 1)];

		// 	$check['featured_image'] = $imgs[($j - 1)];

		// 	$j == 4 ? $j = 0 : '';

		$check['slug'] = Posts::checkSlug( $check['slug'],'',$check['post_type'] );
		$title = Posttypes::where('post_type' , $check['post_type'] )->first();
		$post = Posts::insert($check);
		if( isset($check['fields']) && $check['fields'] != '' )  :
			Postmeta::insert($check , $post->id );
		endif;
		if( isset($check['terms']) && $check['terms'] != '' )  :
			TermRelations::insertorupdate($check , $post->id );
		endif;
		// }

		return redirect( asset( 'admin/list/'.$check['post_type'] ) )
		->with('success', $title->post_type_title.' Added Successfully!');
	}


	public function edit(Request $request){

		$post['post_data'] = Posts::where('ID', $request->post_id)->first()->toArray();

		$post = Postmeta::getMetaData( $post );

		$post = self::parsePostContent($post);

		$checktax = Taxonomy::exists($post['post_data']['post_type']);

		$post['template'] = Templates::where('type',$post['post_data']['post_type'])->first();

		$post['post_data']['post_type'] == 'offers' ? $post['products'] = Products::all()->toArray() : '';

		$post['taxonomy'] = Terms::get_terms($checktax);

		if( !empty($checktax) ) :

			$post['post_data']['termdata'] = TermRelations::getTermData($request->post_id,$checktax);

		endif;

		return view("admin.posts.edit",['pageTitle',$post['post_data']['post_title']])->with('data', $post);


	}

	function changeLang(Request $request){

		$post['post_data'] = Posts::where('ID', $request->id)->first()->toArray();

		if( $request->lang != 1 ) :

			$data = Postmeta::where([['posts_id',$request->id],['lang',$request->lang]])->whereIn('meta_key',['pagetitle','post_content','featured_image','post_excerpt'])->get();

			$meta = [];


			foreach($data as $item) :

				$meta[$item->meta_key] = $item->meta_value;

			endforeach;

			$post['post_data']['post_title'] = isset($meta['pagetitle']) ? $meta['pagetitle'] : ''; 
			$post['post_data']['post_content'] = isset($meta['post_content']) ? $meta['post_content'] : ''; 
			$post['post_data']['featured_image'] = isset($meta['featured_image']) ? $meta['featured_image'] : ''; 
			$post['post_data']['post_excerpt'] = isset($meta['post_excerpt']) ? $meta['post_excerpt'] : ''; 

		endif;

		$post = Postmeta::getMetaData( $post,$request->lang );

		$post = self::parsePostContent($post);

		$checktax = Taxonomy::exists($post['post_data']['post_type']);

		$post['template'] = Templates::where('type',$post['post_data']['post_type'])->first();

		// $post['post_data']['post_type'] == 'offers' ? $post['products'] = Products::all()->toArray() : '';

		$post['taxonomy'] = Terms::get_terms($checktax);

		if( !empty($checktax) ) :

			$post['post_data']['termdata'] = TermRelations::getTermData($request->post_id,$checktax);

		endif;

		return view("admin.posts.fields")->with('data',$post)->render();

	}

	public function update(Request $request){

		$check = $request->all();

		$check['slug'] = Posts::checkSlug( $check['slug'],$check['ID'],$check['post_type'] );

		if( $check['lang'] != 1 ) :

			$check['fields'].=',pagetitle,post_content,featured_image,post_excerpt';

		endif;

		$post = Posts::updatepost($check);

		Postmeta::where([['posts_id',$check['ID']],['lang',$check['lang']]])->delete();

		if( isset($check['fields']) && $check['fields'] != '' )  :
			Postmeta::insertorupdate($check , $check['ID'],$check['lang']);
		endif;

		if( isset($check['terms']) && $check['terms'] != '' )  :

			TermRelations::insertorupdate($check , $check['ID'] );

		endif;

		return back()->with('success', ucfirst($check['post_type']).' Updated Successfully!');
	}


	public function delete(Request $request){

		Posts::where('ID',$request->id)->delete();

		Postmeta::where('posts_id',$request->id)->delete();

		return back()->with('success','Item Deleted!');


	}


	public static function parsePostContent($result){

		foreach( $result as $key => $data ) :

			foreach($data as $subkey => $subdata ) :

				if( str_contains( $subkey , 'image') ) :

					$result[$key][$subkey] = ['path' => Index::get_image_path( $subdata ) , 'id' => $subdata , 'alt' => Index::get_image_alt($subdata) ];

				endif;

				if( $subkey == 'metadata' ) :

					foreach($subdata as $metakey => $metadata) :

						if( str_contains($metakey, 'image') ) :

							$result[$key][$subkey][$metakey] = [

								'path'=> Index::get_image_path($metadata) ,

								'id' => $metadata,

								'alt' => Index::get_image_alt($metadata)
							];

						endif;

					endforeach;

				endif;

			endforeach;

		endforeach;

		return $result;
	}
public function getPostTypes(Request $request)
{
    $length = (int) $request->input('length', 10);
    $start = (int) $request->input('start', 0);
    $search = $request->input('search.value');
    $draw = (int) $request->input('draw');
    $postType = $request->input('post_type');

    // Determine ordering column and direction
    $columnIndex = $request->input('order.0.column');
    $columnDir   = $request->input('order.0.dir', 'desc'); // default desc

    // Map DataTables columns to database columns
    $columns = [
        0 => 'ID',            // if you have S/No as first data column, adjust accordingly
        'id' => 'ID',
        'title' => 'post_title',
        'status' => 'post_status',
        // you can add more if you have extra sortable columns
    ];

    // Base query
    $query = Posts::where('post_type', $postType);

    // Total records count
    $recordsTotal = $query->count();

    // Apply search filter
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('post_title', 'like', "%{$search}%")
              ->orWhere('post_status', 'like', "%{$search}%");
        });
    }

    // Count filtered
    $recordsFiltered = $query->count();

    // Apply order if valid
    $orderColumnData = $request->input("columns.{$columnIndex}.data");
    if (isset($columns[$orderColumnData])) {
        $orderColumn = $columns[$orderColumnData];
        $query->orderBy($orderColumn, $columnDir);
    } else {
        $query->orderBy('sort_order', 'Asc');
    }

    // Fetch data
    $posts = $query->offset($start)
                   ->limit($length)
                   ->get();

    // Prepare data
    $data = [];
    $serial = $start + 1;
    foreach ($posts as $post) {

        // Determine image URL
        $image = null;
		$imageID = (int)$post->featured_image;

        $featured_image = DB::table('image_categories')
            ->where('image_type', 'ACTUAL')
            ->where('image_id', $post->featured_image)
            ->value('path');

        if (!empty($featured_image)) {
            $image = asset($featured_image);
        }
        $action = '
            <div class="careerFilter">
                <div class="child_option position-relative">
                    <button class="dots open-menu2 bg-transparent border-0 p-0" type="button">
                        <svg height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512">
                            <path d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"></path>
                        </svg>
                    </button>
                    <div class="dropdown-menu2 dropdown-menu-right" style="display: none;">
                        <ul class="careerFilterInr">
                            <li><a href="' . asset('admin/edit/'. $post->post_type . '/' . $post->ID) . '">Edit</a></li>
                            <li><a href="javascript:delete_popup(\'' . asset('admin/deletepost') . '\',' . $post->ID . ');">Delete</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        ';

        $data[] = [
            'select'         => '<input type="checkbox" name="select" class="row-select" data-id="' . $post->ID . '">',
            'serial_number'  => $serial++,
            'id'             => $post->ID,
            'title'          => $post->post_title,
            'status'         => $post->post_status,
            'image'          => $image,
            'action'         => $action,
        ];
    }

    return response()->json([
        'draw'            => $draw,
        'recordsTotal'    => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data'            => $data,
    ]);
}
}

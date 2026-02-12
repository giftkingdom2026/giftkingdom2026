<?php
namespace App\Http\Controllers\AdminControllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Web\Index;
use App\Models\Core\Images;
use App\Models\Core\Posts;
use App\Models\Core\Taxonomy;
use App\Models\Core\Terms;
use App\Models\Core\Termmeta;


class TaxonomyController extends Controller
{


public function view(Request $request)
{
    $perPage = $request->input('length', 10);
    $search = $request->input('search');

    $taxonomy = Taxonomy::where('taxonomy_slug', $request->slug)
        ->orderBy('id', 'DESC')
        ->first();

    if (!$taxonomy) {
        abort(404, 'Taxonomy not found');
    }

    $query = Terms::where('taxonomy_id', $taxonomy->id)
        ->orderBy('sort_order', 'ASC');

    if (!empty($search)) {
        $query->where(function($q) use ($search) {
            $q->where('term_title', 'like', "%$search%")
              ->orWhere('term_slug', 'like', "%$search%");
        });
    }

    $terms = $query->paginate($perPage)->appends([
        'length' => $perPage,
        'search' => $search
    ]);

    // Convert to array so you can edit links URLs
    $termsArray = $terms->toArray();

    // Fix links URLs
    if (isset($termsArray['links']) && is_array($termsArray['links'])) {
        foreach ($termsArray['links'] as &$link) {
            if (isset($link['url']) && strpos($link['url'], 'create') !== false) {
                $link['url'] = str_replace('create', 'list', $link['url']);
            }
        }
    }

    $data = [
        'taxonomy_data' => $taxonomy->toArray(),
        'terms' => $termsArray  // Pass the modified array, not the paginator!
    ];

    $title = ['pageTitle' => $taxonomy->taxonomy_title];

    return view("admin.taxonomies.index", $title)->with('data', $data);
}




	public function create(Request $request){
		
		$check = $request->all();

		$check['slug'] = Terms::checkSlug( $check['slug'] );

		$taxonomy = Terms::insert($check);

		$terms = Terms::where('taxonomy_id' , $check['taxonomy_id'] )->orderBy('sort_order','ASC')->get();
		
		$terms ? $terms = $terms->toArray() : '';

		$data['terms'] = $terms;

		return view('admin.taxonomies.table')->with('data', $data);

	}


	public function edit(Request $request){

		$data = Terms::getTermData($request->id);

		$data['meta'] = self::parsePostContent([$data['meta']]);

		$data['meta'] = array_shift($data['meta']);
		
		return view("admin.taxonomies.edit",['pageTitle',$data['term_title']])->with('data', $data);


	}

	public function changeLang(Request $request){

        $lang = $request->lang;

        $data = Terms::getTermData($request->id);

        $meta = Termmeta::where([['terms_id',$request->id],['lang',$lang]])->get();
        
        $meta ? $meta = $meta->toArray() : '';

        $arr = [];

        foreach($meta as $m) :

            $arr[$m['meta_key']] = $m['meta_value'];

        endforeach;

        $data['meta'] = $arr;

        return view('admin.taxonomies.fields')->with('data',$data)->render();

    }


	public function update(Request $request){

		$check = $request->all();

		$response = Terms::updateterm($check);

		return back()->with('success','Term Updated Successfully!');


	}


	public function delete(Request $request){


		Terms::where('terms_id',$request->id)->delete();

		Termmeta::where('terms_id',$request->id)->delete();

		return back()->with('success','Item Deleted!');


	}


	public static function parsePostContent($result){

		foreach( $result as $key => $data ) :

			foreach($data as $subkey => $subdata ) :

				if( str_contains( $subkey , 'image') ) :

					$result[$key][$subkey] = ['path' => Index::get_image_path( $subdata ) , 'id' => $subdata ];

				endif;

			endforeach;

		endforeach;

		return $result;
	}

}

<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use App\Models\Core\Termmeta;
use App\Models\Core\Taxonomy;


class Terms extends Model

{

	protected $table= 'taxonomy_terms';
	protected $guarded = [];

	public function metadata() {
		
		return $this->hasMany('App\Models\Core\Termmeta');
		
	}

	public function terms() {

		return $this->belongsTo('App\Models\Core\Terms');
		
	}

	public static function insert($data){

		$response =	self::Create([

			'taxonomy_id' => $data['taxonomy_id'],

			'term_title' => $data['term_title'],

			'term_slug' => $data['slug'],
			'status' => $data['status']

		]);

		$data['term_id'] = $response->id;
		
		if(isset( $data['fields']) && !empty($data['fields']) ) :

			$fields = explode(',', $data['fields']);

		foreach($fields as $field) : 

			Termmeta::insertorupdate($data,$field);

		endforeach;

	endif;


	return $response;

}

public static function get_terms($data){

	$taxonomies = [];

	if( !empty($data) ){

		foreach($data as $item) :

$terms = self::where('taxonomy_id', $item['id'])
    ->where(function($query) {
        $query->where('status', 'active')
              ->orWhereNull('status');
    })
    ->orderBy('sort_order', 'ASC')
    ->get()
    ->toArray();

			$taxonomies[$item['taxonomy_slug']] = $terms;

		endforeach;

	}
	
	return $taxonomies;

}


public static function getTermData($data){

	$term = self::where('terms_id',$data)->first()->toArray();

	$term['taxonomy'] = Taxonomy::getTaxonomy($term['taxonomy_id']); 

	$term['meta'] = Termmeta::getTermmeta($data);

	return $term;

}

public static function getTermBySlug($slug){

	$term = self::where('term_slug',$slug)->first()->toArray();

	$term['taxonomy'] = Taxonomy::getTaxonomy($term['taxonomy_id']); 

	$term['meta'] = Termmeta::getTermmeta($term['terms_id']);

	return $term;

}

public static function updateterm($data){

	unset($data['_token']); 
	if( isset( $data['fields'] ) ) :
		
		$fields = explode(',', $data['fields']); unset($data['fields']);

		foreach($fields as $field):

			Termmeta::insertorupdate($data,$field);

			unset($data[$field]);

		endforeach;

	endif;

	$data['terms_id'] = $data['term_id']; unset($data['term_id']);

	if( $data['lang'] != 1 ) :

            Termmeta::where([['taxonomy_id',$data['taxonomy_id']],['terms_id',$data['terms_id']],['lang',$data['lang']]])->delete();

            Termmeta::create([

                'taxonomy_id' => $data['taxonomy_id'],

                'terms_id' => $data['terms_id'],

                'meta_key' => 'term_title',
                
                'meta_value' => $data['term_title'],

                'lang' => $data['lang'],
            ]);

            unset($data['term_title']);
            
            unset($data['lang']);

        endif;
unset($data['lang']);	

	self::where('terms_id',$data['terms_id'])->update($data);
}

public static function updateOrder($data){

	foreach($data['terms'] as $term):

		self::where('terms_id',$term['id'])->update(['sort_order' => $term['order']]);

	endforeach;

}

public static function checkSlug($slug){

	$slug = str_replace([',','.'],'',$slug );

	$check = self::all();

	$slugarr = [];

	foreach( $check as $checking ) :

		if( str_contains($checking->post_name, $slug) ) :

			$ending = substr( $checking->post_name, -7 );

			$int = filter_var( $ending, FILTER_SANITIZE_NUMBER_INT);

			if( $int == '' ) :

				$append = '2';

			else :

				$append = ($int+1);

			endif;

		else :

			$append = '';

		endif;

		array_push($slugarr, $checking->post_name);

	endforeach;

	if( in_array( $slug, $slugarr )  ) :

		$parsedslug = $slug.$append;

	else :

		$parsedslug = $slug;

	endif;

	return $parsedslug;
}


}	
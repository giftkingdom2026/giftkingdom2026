<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use App\Models\Core\Terms;
use App\Models\Core\Taxonomy;


class TermRelations extends Model

{

	protected $table= 'taxonomy_term_relations';
	protected $guarded = [];

	public static function insertorupdate($data,$post_id){

		$taxonomies = explode(',',$data['terms']);

		$taxonomies = array_filter($taxonomies);

		foreach($taxonomies as $taxslug) :

			if( isset($data[$taxslug]) ) :

				$data[$taxslug] = array_filter($data[$taxslug]);

				if( !empty( $data[$taxslug] ) ) :

					$taxonomy = Taxonomy::where('taxonomy_slug',$taxslug)->pluck('id')->first();

					self::where([

						['post_id',$post_id],

						['taxonomy_id' , $taxonomy]

					])->delete();

					foreach( $data[$taxslug]  as $term ) :

						$term_data = Terms::where('terms_id',$term)->first();

						$term_data ? $term_data = $term_data->toArray() : '';

						self::Create([

							'taxonomy_id' => $taxonomy,

							'term_id' => $term,

							'post_id' => $post_id 

						]);

					endforeach;

				endif;

			endif;

		endforeach;

	}


	public static function getTermData($id,$taxonomy){

		$arr = [];
		
		foreach( $taxonomy as $tax ) :

			$terms = self::select('term_id')->where([

				['post_id','=',$id],
				['taxonomy_id','=',$tax['id']]

			])->get();

			!empty($terms) ? $terms = $terms->toArray() : '' ;

		endforeach;

		foreach( $terms as $term ):

			$arr[] = $term['term_id'];

		endforeach;

		return $arr;
	}

	public static function getTerms($id,$tax){

		$terms = self::where([

			['post_id','=',$id],
			['taxonomy_id','=',$tax]

		])->get();

		$terms ? $terms = $terms->toArray() : '';

		$arr = [];

		if( !empty($terms) ) : 

			foreach( $terms as $item ) :

				$term = Terms::select('term_title')->where([ 

					['terms_id',$item['term_id']],

					['taxonomy_id',$item['taxonomy_id']]

				])->first();

				if( $term ) :

					$arr[] = $term->term_title;

				endif;

			endforeach;

		endif;

		return $arr;
	}
}	
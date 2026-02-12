<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;


class Taxonomy extends Model

{

	protected $table= 'taxonomies';
	protected $guarded = [];

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

	public static function exists($postype){

		$return = self::where('post_type',$postype)->get()->toArray();

		return $return;

	}

	public static function getTaxonomy($id){

		return self::where('id',$id)->first()->toArray();

	}

	


}	
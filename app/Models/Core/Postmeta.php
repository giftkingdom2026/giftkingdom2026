<?php

namespace App\Models\Core;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;



class Postmeta extends Model

{

	protected $table= 'postmeta';

	protected $guarded = [];

	protected $primaryKey = 'meta_id';

	public function posts() {

		return $this->belongsTo('App\Models\Core\Posts');

	}

	public static function insertorupdate($check,$id,$lang=1){

		$fields = explode(',', $check['fields']);

		if( in_array( 'sizes', $fields ) ):

			$new = array_filter(explode(',',$check['sizes']));

			foreach($new as $item) :

				$fields[] = $item;

			endforeach;

		endif;

		foreach( $fields as $field ) :

			$response = Postmeta::where([ 
				
				['posts_id',$id],

				['meta_key',$field],

				['lang',$lang]
			])

			->first();

			$response ? $response = $response->toArray() : $response = [];

			if( empty( $response ) ) :

				self::insert($check,$id,$lang);

			else :

				self::updatemeta($check,$id,$lang);

			endif;

			
		endforeach;

	}

	public static function insert($check,$id,$lang=1){

		$fields = explode(',', $check['fields']);

		if( in_array( 'sizes', $fields ) ):

			$new = array_filter(explode(',',$check['sizes']));

			foreach($new as $item) :

				$fields[] = $item;

			endforeach;

		endif;


		foreach( $fields as $field ) :
			
			$result =	self::Create([

				'posts_id' => $id,

				'meta_key' => $field,

				'meta_value' => $check[$field],

				'lang' => $lang
				
			]);

		endforeach;


	}


	public static function updatemeta($check,$id,$lang=1){

		$fields = explode(',', $check['fields']);

		foreach( $fields as $field ) :

			$result =	self::where([
				['posts_id',$id],

				['meta_key',$field],

				['lang',$lang],

			])->update([

				'meta_value' => $check[$field],

			]);

		endforeach;

	}


	public static function getMetaData($posts,$lang = 1){
		
		if( is_array($posts) ) :

			foreach($posts as $key => $post):

				$metadatadb = Postmeta::where('posts_id',$post['ID'])->where('lang',$lang)->get();

				$metadatadb ? $metadatadb = $metadatadb->toArray() : '';

				$metadata = [];

				foreach($metadatadb as $metakey => $data) :

					$metadata[$data['meta_key']] = $data['meta_value'];

				endforeach;

				$posts[$key]['metadata'] = $metadata;

			endforeach;

		else :

			$metadatadb = Postmeta::where('posts_id',$posts)->where('lang',$lang)->get();

			$metadatadb ? $metadatadb = $metadatadb->toArray() : '';

			$metadata = [];

			foreach($metadatadb as $metakey => $data) :

				$metadata[$data['meta_key']] = $data['meta_value'];

			endforeach;

			$posts = $metadata;

		endif;

		return $posts;

	}


}
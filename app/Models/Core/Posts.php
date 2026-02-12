<?php

namespace App\Models\Core;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

use App\Models\Core\TermRelations;
use App\Models\Core\Postmeta;
use App\Models\Core\Taxonomy;
use App\Models\Core\Terms;
use App\Http\Controllers\AdminControllers\PostsController;



class Posts extends Model

{

	protected $table= 'posts';
	protected $guarded = [];


	public function metadata() {

		return $this->hasMany('App\Models\Core\Postmeta');
		
	}

	public static function checkSlug($slug,$id='',$post_type){

		$slug = str_replace([',','.'],'',$slug );

		$parsedslug = $slug;
		
		$append = '';

		$strcheck = substr($slug,-1);

		if( $strcheck == '-' ) :

			$slug = rtrim($slug,'-');

		endif;

		$check = self::where([
			['post_type',$post_type],

			['post_name','like', '%'.$slug.'%']

		])->get();

		$slugarr = [];
		
		$checkslug = [];

		foreach( $check as $checking ) :

			$ending = substr( $checking->post_name, -7 );

			$int = (int)filter_var( $ending, FILTER_SANITIZE_NUMBER_INT);

			array_push($checkslug, $int);

		endforeach;

		foreach( $check as $checking ) :

			if( $id == '' ) :

				if( $checking->post_name === $slug )  :

					$ending = substr( $checking->post_name, -7 );

					$int = (int)filter_var( $ending, FILTER_SANITIZE_NUMBER_INT);

					$parsedslug = str_replace( abs($int) , '' , $slug ).( abs( max($checkslug) + 1 ) ) ;

				endif;

			else :

				if( $checking->post_name === $slug && $checking->ID != $id )  :

					$ending = substr( $checking->post_name, -7 );
					
					$int = (int)filter_var( $ending, FILTER_SANITIZE_NUMBER_INT);

					$parsedslug = str_replace( abs($int) , '' , $slug ).( abs( max($checkslug) + 1 ) ) ;

				endif;

			endif;

		endforeach;


		return $parsedslug;
	}

	public static function getPostBySlug($slug,$type){

		$curr = self::where([['post_name', $slug],['post_type',$type]])->first();
		
		if( $curr ) :

			$curr = $curr->toArray();

		else:

			return false;
			
		endif;

		$post['post_data'] = $curr;

		$lang = session()->has('lang_id') ? session('lang_id') : 1;

		$post = Postmeta::getMetaData( $post, $lang );

		$post = PostsController::parsePostContent( $post );

		$checktax = Taxonomy::exists($post['post_data']['post_type']);
		
		$post['taxonomy'] = Terms::get_terms($checktax);

		if( !empty($checktax) ) :

			$post['post_data']['termdata'] = TermRelations::getTermData($post['post_data']['ID'],$checktax);

		endif;

		return $post;
	}

	public static function getPostByID($id){

		$post['post_data'] = self::where('ID', $id)->first()->toArray();

		$post = Postmeta::getMetaData( $post );

		$post = PostsController::parsePostContent( $post );

		$checktax = Taxonomy::exists($post['post_data']['post_type']);
		
		$post['taxonomy'] = Terms::get_terms($checktax);

		if( !empty($checktax) ) :

			$post['post_data']['termdata'] = TermRelations::getTermData($post['post_data']['ID'],$checktax);

		endif;

		return $post;
	}

	public static function searchJob($request){

		$data = $request->all();
		
		$ids = Postmeta::where([['meta_key','location'],['meta_value','like', '%'.$request->location.'%']])->pluck('posts_id');

		$posts = self::whereIn('ID',$ids)->where('post_title','like','%'.$request->keywords.'%')->get();

		$posts ? $posts = $posts->toArray() : '';

		$posts = Postmeta::getMetaData( $posts );

		$posts = PostsController::parsePostContent( $posts );

		return $posts;
	}

	public static function searchQuestion($request){

		$data = $request->all();

		$posts = self::where([['post_title','like','%'.$request->keywords.'%'],['post_type','questions']])->get();

		$posts ? $posts = $posts->toArray() : '';

		$posts = Postmeta::getMetaData( $posts );

		$posts = PostsController::parsePostContent( $posts );

		return $posts;
	}

	public static function insert($check){
		$id = Posts::create([
			'post_content' => $check['post_content'],
			'post_title' => $check['pagetitle'],
			'post_name' =>  $check['slug'],
			'featured_image' =>  $check['featured_image'] ?? null,
			'post_status' =>  $check['post_status'],
			'post_type' =>  $check['post_type'],
			'post_excerpt' =>  $check['post_excerpt'],
			'reason_type' =>  $check['reason_type'] ?? null,
		]);
		return $id;
	}


	public static function updatepost($check){

		$arr = [

			'post_name' =>  $check['slug'],

			'post_status' =>  $check['post_status'],

			'post_type' =>  $check['post_type'],

		];

		if( $check['lang'] == 1 ) :

			$arr['post_content'] = $check['post_content'];

			$arr['post_title'] = $check['pagetitle'];

			$arr['featured_image'] =  $check['featured_image'] ?? null;

			$arr['post_excerpt'] =  $check['post_excerpt'];
			$arr['reason_type'] =  $check['reason_type'] ?? null;

		endif;

		$post = Posts::where('ID', $check['ID'])->update($arr);

	}

	public static function getDevices(){

		$posts = Posts::where('post_type','devices')->get()->toArray();

		foreach($posts as &$post) :

			$data['post_data'] = $post;

			$data = Postmeta::getMetaData($data);

			$post = $data;
			
		endforeach;

		return $posts;
	}

	public static function getPostsByTerm($term,$taxonomy){

		$ids = TermRelations::where([
			['term_id',$term],
			['taxonomy_id',$taxonomy]
		])->pluck('post_id')->groupBy('post_id')->first();		
		
		$posts = self::whereIn('ID',$ids)->get();

		$posts ? $posts = $posts->toArray() : ''; 

		foreach($posts as &$post):

			$meta = Postmeta::where('posts_id',$post['ID'])->get();

			$meta ? $meta = $meta->toArray() : '';

			$arr = [];

			foreach( $meta as $item ) :

				$arr[$item['meta_key']] = $item['meta_value'];

			endforeach;

			$post['metadata'] = $arr;

		endforeach;

		return $posts;
	}

	public static function updateOrder($data){

		foreach($data['posts'] as $post):

			self::where('ID',$post['id'])->update(['sort_order' => $post['order']]);

		endforeach;

	}

}	



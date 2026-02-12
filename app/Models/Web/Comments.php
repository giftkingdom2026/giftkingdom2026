<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

use App\Models\Web\Usermeta;

use App\Models\Web\Index;
use App\Models\Web\Users;

use Auth;

use Session;
class Comments extends Model

{

	protected $table= 'comments';

	protected $guarded = [];



	public static function getComments($id){

		$data = self::where([['product_ID', $id],['parent_ID',0]])->get();

		$data ? $data = $data->toArray() : '';

		foreach($data as &$item) :

			$answer = self::where([['product_ID', $id],['parent_ID',$item['comment_ID']]])->first();

			$answer ? $answer = $answer->toArray() : '';

			$item['answer'] = $answer;

			$item['user_ID'] = Users::getUserData($item['user_ID']);

		endforeach; 

		return $data;
		
	}



}
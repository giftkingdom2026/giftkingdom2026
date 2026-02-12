<?php



namespace App\Models\Core;



use Illuminate\Database\Eloquent\Model;





class Termmeta extends Model



{



	protected $table= 'termmeta';

	protected $guarded = [];



	public function terms() {



		return $this->belongsTo('App\Models\Core\Terms');

	

	}



	public static function getTermmeta($id,$cat = false){

		$termmeta = [];

		if( $cat ) :
			
			$data = self::where([['taxonomy_id',2147483647],['terms_id',$id]])->get();

		else :

			$data = self::where('terms_id',$id)->get();

		endif;

		!empty($data) ? $data = $data->toArray() : '';

		foreach($data as $key => $value) :

			$termmeta[$value['meta_key']] = $value['meta_value'];

		endforeach;
		
		return $termmeta;

	}



	public static function insertorupdate($data,$field){







		$check = self::where([

			['taxonomy_id' , $data['taxonomy_id']],

			['terms_id' , $data['term_id']],

			['meta_key' , $field],

		])->first();





		if( !empty( $check ) ) {



			self::where([

				['taxonomy_id' , $data['taxonomy_id']],

				['terms_id' , $data['term_id']],

				['meta_key' , $field],

			])



			->update(['meta_value' => $data[$field]]);



		}

		else{



			self::Create([ 



				'taxonomy_id' => $data['taxonomy_id'],



				'terms_id' => $data['term_id'],



				'meta_key' => $field,



				'meta_value' => $data[$field]



			]);

		}



	}



}	
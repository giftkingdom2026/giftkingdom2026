<?php



namespace App\Models\Core;



use Illuminate\Database\Eloquent\Model;



class Templates extends Model



{



  protected $table= 'templates';

  protected $guarded = [];

  public static function insertorupdate($data){

    $check = Templates::where('name' , $data['template'])->get()->toArray();

    if( isset($data['id']) ) :

            $d = Templates::where('id' , $data['id'])->update([

              'name' => $data['template'],
              
              'data' => serialize($data['section_data']),

              'type' => $data['type'],

            ]);

    else : 

          if( !empty( $check ) ) :

            $d = Templates::where('name' , $data['template'])->update([

              'data' => serialize($data['section_data'])

            ]);

          else :

           $d = Templates::create([

              'name' => $data['template'],

              'data' => serialize($data['section_data']),

              'type' => $data['type'],

            ]);

          endif;
  
    endif;

    return $d;

  }





  public static function get_template($id){



    $data = self::where( 'id' , $id )->first()->toArray();



    return $data['data'];



  }



} 
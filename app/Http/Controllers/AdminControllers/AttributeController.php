<?php



namespace App\Http\Controllers\AdminControllers;



use App\Models\Core\Languages;

use App\Models\Core\Attributes;

use App\Models\Core\Values;
use App\Models\Core\Termmeta;

use App\Models\Web\Index;

use App\Models\Core\Setting;

use App\Models\Core\CategoriesToAttributes;

use App\Models\Core\Categories;

use Illuminate\Http\Request;

use App\Models\Core\Manufacturers;



use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Lang;

use Exception;

use App\Models\Core\Images;



class AttributeController extends Controller {

    public function list(Request $request){

        $id = isset( $request->cat ) ? $request->cat : null;
    $perPage = $request->input('length', 10);
    $search = $request->input('s', null);
        $data['attributes'] = Attributes::list( $id, $perPage, $search);

        $data['cat'] = $id;

        return view('admin.attributes.index')->with('data',$data);

    }

    public function values(Request $request){

        $data['values'] = Values::list( $request->ID );

        $data['attr'] = $request->ID;

        return view('admin.attributes.values.index')->with('data',$data);

    }

    public function edit(Request $request){

        $data = Attributes::where( 'attribute_ID', $request->ID )->first();

        $data ? $data = $data->toArray() : '';

        $cat = CategoriesToAttributes::where('attribute_ID',$request->ID)->pluck('category_ID')->first();

        $cat = Categories::where('category_ID',$cat)->first();
        
        $cat ? $cat = $cat->toArray() : '';
        
        $data['cat'] = $cat;

        return view('admin.attributes.edit')->with('data',$data);

    }

    public function changeLang(Request $request){

        $lang = $request->lang;

        $data = Attributes::where( 'attribute_ID', $request->id )->first();

        $data ? $data = $data->toArray() : '';

        $meta = Termmeta::where([['taxonomy_id',447218073],['terms_id',$request->id],['lang',$lang]])->get();
        
        $meta ? $meta = $meta->toArray() : '';

        $arr = [];

        foreach($meta as $m) :

            $arr[$m['meta_key']] = $m['meta_value'];

        endforeach;

        $data['meta'] = $arr;

        return view('admin.attributes.fields')->with('data',$data)->render();

    }

public function changeValueLang(Request $request){

        $lang = $request->lang;

        $data = Values::where('value_ID',$request->id)->first();
        
        $data ? $data = $data->toArray() : '';
        
        $meta = Termmeta::where([['taxonomy_id',741035],['terms_id',$request->id],['lang',$lang]])->get();
        
        $meta ? $meta = $meta->toArray() : '';

        $arr = [];

        foreach($meta as $m) :

            $arr[$m['meta_key']] = $m['meta_value'];

        endforeach;

        $data['meta'] = $arr;

        return view('admin.attributes.values.fields')->with('data',$data)->render();

    }
    public function ValueEdit(Request $request){

        $data = Values::where('value_ID',$request->ID)->first();
        
        $data ? $data = $data->toArray() : '';
        
        $data['value_image'] = ['id' => $data['value_image'], 'path' => Index::get_image_path( $data['value_image'] )];

        return view('admin.attributes.values.edit')->with('data',$data);

    }

    
    public function updateValue(Request $request){

        $data = $request->all();

        unset($data['_token']);

        if( $data['lang'] != 1 ) :

            Termmeta::where([['taxonomy_id',741035],['terms_id',$data['value_ID']],['lang',$data['lang']]])->delete();

            Termmeta::create([

                'taxonomy_id' => 741035 ,

                'terms_id' => $data['value_ID'],

                'meta_key' => 'value_title',
                
                'meta_value' => $data['value_title'],

                'lang' => $data['lang'],
            ]);

            unset($data['value_title']);
            
            unset($data['lang']);

        endif;

        Values::where( 'value_ID', $data['value_ID'] )->update($data);
        
        return redirect()->back()->with('success','Attribute updated successfully');

    }

    public function deleteValue(Request $request){

        Values::where( 'value_ID', $request->id )->delete();
        
        return redirect()->back()->with('success','Value deleted successfully');

    }


    public function update(Request $request){

        $data = $request->all();

        CategoriesToAttributes::where('attribute_ID',$data['attribute_ID'])->delete();

        if( is_array( $data['category_ID'] ) ) :

            if( array_shift($data['category_ID']) == 'all' ) :

                $cats = Categories::all();

                foreach( $cats as $id ) :

                    CategoriesToAttributes::create([

                        'category_ID' => $id->category_ID,
                        'attribute_ID' => $data['attribute_ID'],

                    ]);

                endforeach;

            else :

                foreach( $data['category_ID'] as $id ) :

                    CategoriesToAttributes::create([

                        'category_ID' => $id,
                        'attribute_ID' => $data['attribute_ID'],

                    ]);

                endforeach;

            endif;

        else :

            CategoriesToAttributes::create([

                'category_ID' => $data['category_ID'],
                'attribute_ID' => $data['attribute_ID'],

            ]);

        endif;

        unset($data['_token']); unset($data['category_ID']);

        if( $data['lang'] != 1 ) :

            Termmeta::where([['taxonomy_id',447218073],['terms_id',$data['attribute_ID']],[ 'lang',$data['lang'] ] ])->delete();

            Termmeta::create([

                'taxonomy_id' => 447218073 ,

                'terms_id' => $data['attribute_ID'],

                'meta_key' => 'attribute_title',
                
                'meta_value' => $data['attribute_title'],

                'lang' => $data['lang'],

            ]);

            unset($data['attribute_title']);
            unset($data['lang']);

        endif;

        Attributes::where( 'attribute_ID', $data['attribute_ID'] )->update($data);

        return redirect()->back()->with('success','Attribute updated successfully');

    }



    public function insertValue(Request $request){

        Values::addValue($request->all());

        $data['values'] = Values::list($request->attribute_ID);

        return view('admin.attributes.values.table')->with('data',$data);

    }


    public function insert(Request $request){

        Attributes::addAttr($request->all());

        $data['attributes'] = Attributes::list($request->category_ID);

        return view('admin.attributes.table')->with('data',$data);

    }


    public function delete(Request $request){

        Attributes::where( 'attribute_ID', $request->id )->delete();

        return redirect()->back()->with('success','Attribute deleted successfully');

    }

}


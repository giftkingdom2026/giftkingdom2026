<?php

namespace App\Http\Controllers\AdminControllers;



use App\Models\Core\Setting;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Core\Templates;



class DeveloperController extends Controller

{

	

	public function view(Request $request){

		$title = ['pageTitle' => 'Developer'] ;

		$templates = Templates::all()->toArray();

		return view("admin.developer.index", ['title' => $title])->with('templates' , $templates );



	}


	public function get_field(Request $request){

		$data = $request->all();

		return view("admin.developer.fields")->with('data' , $data);
	}



	public function save(Request $request){

		$data = $request->all();

		$response = Templates::insertorupdate($data['data']);

	}



	public function create(Request $request){

		$title = ['pageTitle' => 'Create Template'] ;

		return view("admin.developer.create", ['title' => $title]);

	}



	public function edit(Request $request){

		$title = ['pageTitle' => 'Edit Template'] ;

		$template = Templates::where('id' , $request->id )->first()->toArray();

		return view("admin.developer.edit", ['title' => $title])->with('template',$template);
	}





	public function update(Request $request){

		$data = $request->all();

		$response = Templates::insertorupdate($data['data']);

	}

}


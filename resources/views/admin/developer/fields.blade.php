<?php





$svg = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" version="1.1" id="Capa_1" width="800px" height="800px" viewBox="0 0 94.926 94.926" xml:space="preserve"><g>

	<path d="M55.931,47.463L94.306,9.09c0.826-0.827,0.826-2.167,0-2.994L88.833,0.62C88.436,0.224,87.896,0,87.335,0   c-0.562,0-1.101,0.224-1.498,0.62L47.463,38.994L9.089,0.62c-0.795-0.795-2.202-0.794-2.995,0L0.622,6.096   c-0.827,0.827-0.827,2.167,0,2.994l38.374,38.373L0.622,85.836c-0.827,0.827-0.827,2.167,0,2.994l5.473,5.476   c0.397,0.396,0.936,0.62,1.498,0.62s1.1-0.224,1.497-0.62l38.374-38.374l38.374,38.374c0.397,0.396,0.937,0.62,1.498,0.62   s1.101-0.224,1.498-0.62l5.473-5.476c0.826-0.827,0.826-2.167,0-2.994L55.931,47.463z"/></g></svg>';



$data = $data['data'];



($data[1] === 0 ) ? $count = 1 : $count = $data[1];



switch ($data[0]) {



	case 'section':



		echo json_encode(



			[



				'view' =>   '<div draggable="true" class="section-field-view deletable">

				<div class="container">

				<div class="section-box">

				<div class="section-title">Section<a href="javascript:;" class="delete">'. $svg .'</a></div>

				<form data-id="#'.$count.'">

				<div class="row">

				<div class="col-md-6">

				<div class="form-group">

				<input type="text" name="title" class="title form-control" placeholder="Title">

				</div>

				</div>

				<div class="col-md-6">

				<div class="form-group">

				<input type="text" name="key" class="key form-control" placeholder="Key">

				</div>

				</div>

				</div>

				</form>

				</div>

				</div>

				</div>',

				

				'data' => '<ul id="'.$count.'"></ul>',



				'count' => ($count + 1)



			]

		);



	break;





	case 'text':



		echo json_encode(



			[



				'view' =>   '<div draggable="true" class="text-field-view deletable">

				<div class="container">

				<div class="section-box sub">

				<div class="section-title">Text<a href="javascript:;" class="delete">'. $svg .'</a></div>

				<form data-id="#'.$count.'">

				<div class="row">

				<div class="col-md-4">

				<div class="form-group">

				<input type="text" name="title" class="title form-control" placeholder="Title">

				</div>

				</div>

				<div class="col-md-4">

				<div class="form-group">

				<input type="text" name="key" class="key form-control" placeholder="Key">

				</div>

				</div>

				<div class="col-md-4">

				<div class="form-group">

				<input type="text" name="column_class" class="column_class form-control" placeholder="Column">

				</div>

				</div>

				</div>

				</form>

				</div>

				</div>

				</div>',

				

				'data' => '<li id="'.$count.'" field-type="text"></li>',



				'count' => ($count + 1)



			]

		);



	break;



	case 'image':



		echo json_encode(



			[



				'view' =>   '<div draggable="true" class="text-field-view deletable">

				<div class="container">

				<div class="section-box sub">

				<div class="section-title">Image<a href="javascript:;" class="delete">'. $svg .'</a></div>

				<form data-id="#'.$count.'">

				<div class="row">

				<div class="col-md-6">

				<div class="form-group">

				<input type="text" name="title" class="title form-control" placeholder="Title">

				</div>

				</div>

				<div class="col-md-6">

				<div class="form-group">

				<input type="text" name="key" class="key form-control" placeholder="Key">

				</div>

				</div>

				<div class="col-md-4 mt-3">

				<div class="form-group">

				<input type="text" name="column_class" class="column_class form-control" placeholder="Column">

				</div>

				</div>

				<div class="col-md-4 mt-3">

				<div class="form-group">

				<input type="text" name="height" class="height form-control" placeholder=Height>

				</div>

				</div>

				<div class="col-md-4 mt-3">

				<div class="form-group">

				<input type="text" name="uploadtyp" class="uploadtyp form-control" placeholder=Type>

				</div>

				</div>

				</div>

				</form>

				</div>

				</div>

				</div>',

				

				'data' => '<li id="'.$count.'" field-type="image"></li>',



				'count' => ($count + 1)



			]

		);



	break;



	case 'video':



		echo json_encode(



			[



				'view' =>   '<div draggable="true" class="text-field-view deletable">

				<div class="container">

				<div class="section-box sub">

				<div class="section-title">Video<a href="javascript:;" class="delete">'. $svg .'</a></div>

				<form data-id="#'.$count.'">

				<div class="row">

				<div class="col-md-4">

				<div class="form-group">

				<input type="text" name="title" class="title form-control" placeholder="Title">

				</div>

				</div>

				<div class="col-md-4">

				<div class="form-group">

				<input type="text" name="key" class="key form-control" placeholder="Key">

				</div>

				</div>

				<div class="col-md-4">

				<div class="form-group">

				<input type="text" name="column_class" class="column_class form-control" placeholder="Column">

				</div>

				</div>

				</div>

				</form>

				</div>

				</div>

				</div>',

				

				'data' => '<li id="'.$count.'" field-type="video"></li>',



				'count' => ($count + 1)



			]

		);



	break;





	case 'file':



		echo json_encode(



			[



				'view' =>   '<div draggable="true" class="text-field-view deletable">

				<div class="container">

				<div class="section-box sub">

				<div class="section-title">File<a href="javascript:;" class="delete">'. $svg .'</a></div>

				<form data-id="#'.$count.'">

				<div class="row">

				<div class="col-md-4">

				<div class="form-group">

				<input type="text" name="title" class="title form-control" placeholder="Title">

				</div>

				</div>

				<div class="col-md-4">

				<div class="form-group">

				<input type="text" name="key" class="key form-control" placeholder="Key">

				</div>

				</div>

				<div class="col-md-4">

				<div class="form-group">

				<input type="text" name="column_class" class="column_class form-control" placeholder="Column">

				</div>

				</div>

				</div>

				</form>

				</div>

				</div>

				</div>',

				

				'data' => '<li id="'.$count.'" field-type="file"></li>',



				'count' => ($count + 1)



			]

		);



	break;


	case 'editor':



		echo json_encode(



			[



				'view' =>   '<div draggable="true" class="text-field-view deletable">

				<div class="container">

				<div class="section-box sub">

				<div class="section-title">Text Editor<a href="javascript:;" class="delete">'. $svg .'</a></div>

				<form data-id="#'.$count.'">

				<div class="row">

				<div class="col-md-4">

				<div class="form-group">

				<input type="text" name="title" class="title form-control" placeholder="Title">

				</div>

				</div>

				<div class="col-md-4">

				<div class="form-group">

				<input type="text" name="key" class="key form-control" placeholder="Key">

				</div>

				</div>

				<div class="col-md-4">

				<div class="form-group">

				<input type="text" name="column_class" class="column_class form-control" placeholder="Column">

				</div>

				</div>

				<div class="col-md-6 mt-3">

				<div class="form-group">

				<input type="text" name="height" class="height form-control" placeholder="Height">

				</div>

				</div>

				<div class="col-md-6 mt-3">

				<div class="form-group">

				<input type="text" name="menubar" class="menubar form-control" placeholder="Menubar">

				</div>

				</div>

				</div>

				</form>

				</div>

				</div>

				</div>',

				

				'data' => '<li id="'.$count.'" field-type="editor"></li>',



				'count' => ($count + 1)



			]

		);



	break;


	case 'repetitive':

		echo json_encode(

			[

				'view' =>   '<div draggable="true" class="text-field-view deletable">

				<div class="container">

				<div class="section-box sub">

				<div class="section-title">Repetative Content<a href="javascript:;" class="delete">'. $svg .'</a></div>

				<form data-id="#'.$count.'">

				<div class="row">

				<div class="col-md-4">

				<div class="form-group">

				<input type="text" name="title" class="title form-control" placeholder="Title">

				</div>

				</div>

				<div class="col-md-4">

				<div class="form-group">

				<input type="text" name="key" class="key form-control" placeholder="Key">

				</div>

				</div>

				<div class="col-md-4">

				<div class="form-group">

				<input type="text" name="column_class" class="column_class form-control" placeholder="Column">

				</div>

				</div>

				</div>

				</form>

				</div>

				</div>

				</div>',

				
				'data' => '<li id="'.$count.'" field-type="repetitive" class="repetitive"></li>',


				'count' => ($count + 1)

			]

		);



	break;

}



?>






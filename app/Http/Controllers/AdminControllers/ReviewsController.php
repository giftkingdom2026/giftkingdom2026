<?php

namespace App\Http\Controllers\AdminControllers;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Core\Products;

use App\Models\Web\Users;

use App\Models\Web\Index;

use App\Models\Web\Reviews;

use App\Models\Web\Comments;

use Auth;



class ReviewsController extends Controller{


public function getReviewsAjax(Request $request)
{
    $perPage = $request->input('length', 10);
    $start = $request->input('start', 0);
    $draw = $request->input('draw');
    $search = $request->input('search.value');

    $query = Reviews::query();

    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('review', 'like', '%' . $search . '%');
        });
    }

    $totalRecords = $query->count();

    $data = $query->offset($start)->limit($perPage)->orderBy('review_ID', 'DESC')->get();

    $formatted = [];

    foreach ($data as $review) {
        $product = Products::getProduct($review->object_ID);
        $customer = Users::getUserData($review->customer_ID);

        if (!$customer) continue;

        $formatted[] = [
            'select' => '<input type="checkbox" class="row-select" data-id="' . $review->review_ID . '">',
            'review_ID' => $review->review_ID,
            'product_title' => $product['prod_title'] ?? '-',
            'customer_email' => $customer['email'] ?? '-',
            'review' => $review->review,
            'status' => $review->approved ? 'Approved' : 'Not Approved',
            'action' => '<a href="' . asset('admin/reviews/edit/' . $review->review_ID) . '" class="badge bg-light-blue"><i class="fas fa-edit"></i></a>
                        <a href="javascript:delete_popup(\'' . asset('admin/reviews/delete') . '\',' . $review->review_ID . ');" class="badge delete-popup bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>'
        ];
    }

    return response()->json([
        'draw' => intval($draw),
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $totalRecords,
        'data' => $formatted
    ]);
}
	public function delete(Request $request){

		Reviews::where('review_ID',$request->id)->delete();

		return redirect()->back()->with('success', 'Review deleted successfully!');

	}

	public function deleteQuestion(Request $request){

		Comments::where('comment_ID',$request->id)->delete();

		return redirect()->back()->with('success', 'Question deleted successfully!');

	}

	public function view(Request $request){

		$data = Reviews::paginate(25)->toArray();

		foreach( $data['data'] as $key => &$item ) :

			$item['product'] = Products::getProduct($item['object_ID']);

			$item['customer'] = Users::getUserData($item['customer_ID']);

			if( $item['customer'] == null ) :

				unset($data['data'][$key]);

			endif;

		endforeach;

		return view("admin.reviews.index", ['pageTitle' => 'Reviews'])->with('result', $data);

	}



	public function edit(Request $request){

		$data = $request->all();

		$reviews = Reviews::where('review_ID',$request->ID)->first()->toArray();

		$reviews['product'] = Products::getProduct($reviews['object_ID']);

		$reviews['customer'] = Users::getUserData($reviews['customer_ID']);

		$reviews['media'] = $reviews['media'] != '' ? unserialize($reviews['media']) : [];

		if( !empty($reviews['media']) ) :

			foreach( $reviews['media'] as &$img ) :

				$img = Index::get_image_path($img); 

			endforeach;

		endif;

		return view("admin.reviews.edit", ['pageTitle' => 'Edit Question'])->with('result',$reviews);

	}



	public function update(Request $request){

		$data = $request->all();

		unset($data['_token']);

		$reviews = Reviews::where('review_ID',$data['review_ID'])->update($data);

		return redirect()->back()->with('success','Review updated!');

	}



	public function viewQuestion(Request $request){



		$data = Comments::where('comment_type','question')->paginate(25)->toArray();



		foreach( $data['data'] as $key => &$item ) :



			$item['product'] = Products::getProduct($item['product_ID']);



			$item['customer'] = Users::getUserData($item['user_ID']);

			

			if( $item['product'] == null ) :



				unset($data['data'][$key]);



			endif;



		endforeach;



		return view("admin.reviews.questions.index", ['pageTitle' => 'Questions'])->with('result', $data);



	}



	public function editQuestion(Request $request){



		$data = Comments::where('comment_ID',$request->ID)->first()->toArray();



		$data['product'] = Products::getProduct($data['product_ID']);



		$answers = Comments::where('parent_ID',$request->ID)->get();



		$answers ? $answers = $answers->toArray() : '';



		$data['answers'] = $answers;



		$data['customer'] = Users::getUserData($data['user_ID']);



		return view("admin.reviews.questions.edit", ['pageTitle' => 'Edit Question'])->with('result',$data);



	}



	public function updateQuestion(Request $request){



		$data = $request->all();



		if( isset( $data['answer'] ) ) :



			Comments::create([



				'user_ID' => Auth()->user()->id,

				'product_ID' => $data['product_ID'],

				'parent_ID' => $data['comment_ID'],

				'comment' => $data['answer'],

				'comment_type' => 'answer',

				'attended' => 1,

			]);



			Comments::where('comment_ID',$data['comment_ID'])->update(['attended' => 1]);



		endif;



		return redirect()->back()->with('success','Question Answered!');



	}

}


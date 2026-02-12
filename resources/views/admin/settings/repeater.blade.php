<div class="form-group repetitive_parent gap-3 flex-column d-flex mt-3">

	<label for="home_faqs" class="repetitive_label justify-content-between">

		Faq
		<a href="javascript:;" class="btn btn-primary repeat" data-direction="#home_faqs">+</a>

	</label>

	<?php

	if( isset($data['home_faqs']) ) :

		$arr = unserialize($data['home_faqs']); 

		$count = count($arr['question']); 

	else :

		$arr = ['question' => [],'answer' => []];

		$count = 1;

	endif;

	for($i=0; $i < $count; $i++) : ?>

		<div class="repetitive_content">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<?php $ques = isset($arr['question'][$i]) ? $arr['question'][$i] : '';?> 
						<input type="text" name="home_faqs[question][]" value="<?=$ques?>" id="tagline" placeholder="Question" class="form-control">
					</div>	
				</div>

				<div class="col-md-12">
					<div class="form-group">
						<?php $ans = isset($arr['answer'][$i]) ? $arr['answer'][$i] : '';?> 
						<input type="text" name="home_faqs[answer][]" value="<?=$ans?>" id="tagline" placeholder="Answer" class="form-control">
					</div>	
				</div>
			</div>
		</div>

	<?php endfor;?>

</div>
@extends('web.layout')

@section('content')

<div class="breadcrumb cc">
	<div class="container">
		<ul class="d-inline-flex align-items-center">
			<li><a href="<?=asset('')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>
			<li>></li>
			<li><a href="javascript:;"><?=$data['content']['pagetitle']?></a></li>
		</ul>
	</div>
</div>

<section class="main-section how-to-sell pt-0">
	<div class="container">
		<div class="sellTop">
			<h2><?=$data['content']['pagetitle']?></h2>
			<?=$data['content']['content']?>
		</div>
		
		<?php

		if( isset( $data['content']['s1_head'] ) && $data['content']['s1_head'] != '' ) : ?>

			<article>
				<div class="main-heading">
					<h4><?=$data['content']['s1_head']?></h4>
				</div>
				<div class="js-add-class"><?=$data['content']['s1_text']?></div>
			</article>

		<?php endif;?>
		<?php

		if( isset( $data['content']['s2_head'] ) && $data['content']['s2_head'] != '' ) : ?>

			<article>
				<div class="main-heading">
					<h4><?=$data['content']['s2_head']?></h4>
				</div>
				<div class="js-add-class"><?=$data['content']['sec2_text']?></div>
			</article>

		<?php endif;?>
		<?php

		if( isset( $data['content']['s3_head'] ) && $data['content']['s3_head'] != '' ) : ?>

			<article>
				<div class="main-heading">
					<h4><?=$data['content']['s3_head']?></h4>
				</div>
				<div class="js-add-class"><?=$data['content']['s3_text']?></div>
			</article>

		<?php endif;?>
		<?php

		if( isset( $data['content']['s4_head'] ) && $data['content']['s4_head'] != '' ) : ?>

			<article>
				<div class="main-heading">
					<h4><?=$data['content']['s4_head']?></h4>
				</div>
				<div class="js-add-class"><?=$data['content']['s4_text']?></div>
			</article>

		<?php endif;?>
		<?php

		if( isset( $data['content']['s5_head'] ) && $data['content']['s5_head'] != '' ) : ?>

			<article>
				<div class="main-heading">
					<h4><?=$data['content']['s5_head']?></h4>
				</div>
				<div class="js-add-class"><?=$data['content']['s5_text']?></div>
			</article>

		<?php endif;?>
		<?php

		if( isset( $data['content']['s6_head'] ) && $data['content']['s6_head'] != '' ) : ?>

			<article>
				<div class="main-heading">
					<h4><?=$data['content']['s6_head']?></h4>
				</div>
				<div class="js-add-class"><?=$data['content']['s6_text']?></div>
			</article>

		<?php endif;?>
		<?php

		if( isset( $data['content']['s7_head'] ) && $data['content']['s7_head'] != '' ) : ?>

			<article>
				<div class="main-heading">
					<h4><?=$data['content']['s7_head']?></h4>
				</div>
				<div class="js-add-class"><?=$data['content']['s7_text']?></div>
			</article>

		<?php endif;?>

		<?php

		if( isset( $data['content']['s8_head'] ) && $data['content']['s8_head'] != '' ) : ?>
			
			<article>
				<div class="main-heading">
					<h4><?=$data['content']['s8_head']?></h4>
				</div>
				<div class="js-add-class"><?=$data['content']['s8_text']?></div>
			</article>

		<?php endif;?>

		<?php

		if( isset( $data['content']['s9_head'] ) && $data['content']['s9_head'] != '' ) : ?>
			
			<article>
				<div class="main-heading">
					<h4><?=$data['content']['s9_head']?></h4>
				</div>
				<div class="js-add-class"><?=$data['content']['s9_text']?></div>
			</article>

		<?php endif;?>

		<?php

		if( isset( $data['content']['s10_head'] ) && $data['content']['s10_head'] != '' ) : ?>
			
			<article>
				<div class="main-heading">
					<h4><?=$data['content']['s10_head']?></h4>
				</div>
				<div class="js-add-class"><?=$data['content']['s10_text']?></div>
			</article>

		<?php endif;?>

		<?php

		if( isset( $data['content']['s11_head'] ) && $data['content']['s11_head'] != '' ) : ?>
			
			<article>
				<div class="main-heading">
					<h4><?=$data['content']['s11_head']?></h4>
				</div>
				<div class="js-add-class"><?=$data['content']['s11_text']?></div>
			</article>

		<?php endif;?>

		<?php

		if( isset( $data['content']['s12_head'] ) && $data['content']['s12_head'] != '' ) : ?>
			
			<article>
				<div class="main-heading">
					<h4><?=$data['content']['s12_head']?></h4>
				</div>
				<div class="js-add-class"><?=$data['content']['s12_text']?></div>
			</article>

		<?php endif;?>

		<?php

		if( isset( $data['content']['s13_head'] ) && $data['content']['s13_head'] != '' ) : ?>
			
			<article>
				<div class="main-heading">
					<h4><?=$data['content']['s13_head']?></h4>
				</div>
				<div class="js-add-class"><?=$data['content']['s13_text']?></div>
			</article>

		<?php endif;?>

		<?php

		if( isset( $data['content']['s14_head'] ) && $data['content']['s14_head'] != '' ) : ?>
			
			<article>
				<div class="main-heading">
					<h4><?=$data['content']['s14_head']?></h4>
				</div>
				<div class="js-add-class"><?=$data['content']['s14_text']?></div>
			</article>

		<?php endif;?>

		<?php

		if( isset( $data['content']['s15_head'] ) && $data['content']['s15_head'] != '' ) : ?>
			
			<article>
				<div class="main-heading">
					<h4><?=$data['content']['s15_head']?></h4>
				</div>
				<div class="js-add-class"><?=$data['content']['s15_text']?></div>
			</article>

		<?php endif;?>

		<?php

		if( isset( $data['content']['s16_head'] ) && $data['content']['s16_head'] != '' ) : ?>
			
			<article>
				<div class="main-heading">
					<h4><?=$data['content']['s16_head']?></h4>
				</div>
				<div class="js-add-class"><?=$data['content']['s16_text']?></div>
			</article>

		<?php endif;?>

		<?php

		if( isset( $data['content']['s17_head'] ) && $data['content']['s17_head'] != '' ) : ?>
			
			<article>
				<div class="main-heading">
					<h4><?=$data['content']['s17_head']?></h4>
				</div>
				<div class="js-add-class"><?=$data['content']['s17_text']?></div>
			</article>

		<?php endif;?>

		<?php

		if( isset( $data['content']['s18_head'] ) && $data['content']['s18_head'] != '' ) : ?>
			
			<article>
				<div class="main-heading">
					<h4><?=$data['content']['s18_head']?></h4>
				</div>
				<div class="js-add-class"><?=$data['content']['s18_text']?></div>
			</article>

		<?php endif;?>

		<?php

		if( isset( $data['content']['s19_head'] ) && $data['content']['s19_head'] != '' ) : ?>
			
			<article>
				<div class="main-heading">
					<h4><?=$data['content']['s19_head']?></h4>
				</div>
				<div class="js-add-class"><?=$data['content']['s19_text']?></div>
			</article>

		<?php endif;?>

	</div>
</section>

@endsection

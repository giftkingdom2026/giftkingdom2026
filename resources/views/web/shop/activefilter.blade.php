<?php 

// dd($activefilter);
foreach( $activefilter as $key => $item ) :   ?>

	<li>

		<?php

		$id = '';

		if( $key == 'deal' || $key == 'category' ) :

			$title = $item['category_title'];

			$id = $item['category_ID']; 

		elseif($key == 'brand') :

			$title = $item['brand_title'];

			$id = $item['brand_ID']; 

		else :

			$title = $item;

		endif;?>

		<a href="javascript:;" data-remove="<?=$key?>" data-id="<?=$id?>" class="active remove-filter" >

			<?=$title?>

			<svg xmlns="http://www.w3.org/2000/svg" width="15" viewBox="0 0 512 512"><path fill="#fff" d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"></path></svg>

		</a>


	</li>



	<?php endforeach;?>
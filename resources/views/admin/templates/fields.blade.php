

<div class="content-tabs">

	<?php $sections = unserialize($fields); ?>

	<div class="tabs-nav">

		<ul>

			<?php 

			$i = 0 ;

			foreach($sections as $section ) :

				$i== 0 ? $c = 'active' : $c = ''; ?>

				<li class="tab-nav <?=$c?>">

					<a href="javascript:;" class="tab-link" 

					data-tab="#{{$section['key']}}">

					{{$section['title']}}


				</a>

			</li>

			<?php

			$i++;

		endforeach; ?>

	</ul>

</div>

<div class="tabs-content">

	<?php 

	$i = 0 ;

	// Looping Through Sections
	foreach($sections as $section ) :

		$i== 0 ? $c = 'active' : $c = ''; ?>

		<div class="tab {{$c}}" id="{{$section['key']}}">

			<div class="row">

				<?php

				$j = 0;

					// Looping Through Field Data of section


				foreach($section['data'] as $key => $field) :

					// Condition for row columns

					if( !isset($field['column_class']) ) :


					endif;

					if(  
						!str_contains($field['column_class'], 'same') &&
						!str_contains($field['column_class'], 'start') 
					) :

						$col = '<div class="col-md-'.$field['column_class'].'">';

						$colbreak = '</div>';

					endif;

					if( str_contains($field['column_class'], 'start') ) :

						$col = '<div class="col-md-'.$field['column_class'].'">';

						$colbreak = '';

					endif;

					if( str_contains($field['column_class'], 'same') ) :

						$col = '';

						$colbreak = '';

					endif;

					if( str_contains($field['column_class'], 'same end') ) :

						$col = '';

						$colbreak = '</div>';

					endif;

					echo $col;

					switch ($field['field-type']) {
						
						case 'text': ?>

						<div class="form-group  mt-3">

							<label for="<?=$field['key']?>" class="control-label mb-1">

								<?=$field['title']?>

							</label>

							<input type="text" name="<?=$field['key']?>" class="form-control <?= !empty($field['is_required']) && $field['is_required'] == 1 ? 'required' : '' ?>" 

							value="<?php 

							if(isset($result['content'][$field['key']])){

								echo $result['content'][$field['key']];

							}

						?>" id="tagline">

					</div>							



					<?php		 break;

					case 'editor': ?>

					<div class="form-group  mt-3">

						<label for="<?=$field['key']?>" class="control-label mb-1">

							<?=$field['title']?>

						</label>

						<textarea class="quilleditor <?= !empty($field['is_required']) && $field['is_required'] == 1 ? 'required' : '' ?>" name="<?=$field['key']?>" height="<?=$field['height']?>">

							<?php 

							if( isset( $result['content'][ $field['key']] ) )

							{ 
								echo $result['content'][$field['key']];
							}

							?>

						</textarea>

					</div>					

					<?php		 break;

					case 'image': ?>

					<div class="form-group  mt-3">

						<label for="<?=$field['key']?>" class="control-label mb-1">

							<?=$field['title']?>

						</label>

						<?php ( isset( $result['content'][ $field['key'] ] ) ) ?

						$height = $field['height'] : $height ='' ;

						( isset( $result['content'][$field['key']]['path'] ) && $result['content'][$field['key']]['path'] != '' ) ? 

						$c1 = 'featured' : $c1 = ''; ?>

						<div class="featuredWrap <?=$c1?>">

							<button class="btn  uploader featured_image btn-primary" 

							data-type="<?=$field['uploadtyp']?>">+

						</button>

						<input type="hidden" id="<?=$field['key']?>"  class="<?= !empty($field['is_required']) && $field['is_required'] == 1 ? 'required' : '' ?>"

						name="<?=$field['key']?>" value="

						<?php if( isset( $result['content'][ $field['key'] ] ) ){ 

							echo $result['content'][ $field['key'] ]['id'];

						}?>">

						<?php 

						if( 
							$field['uploadtyp'] == 'single' ||
							$field['uploadtyp'] == ''
						) :

							( isset( $result['content'][$field['key']]['path'] ) && $result['content'][$field['key']]['path'] != '' ) ? 

							$img = asset($result['content'][$field['key']]['path']) : 

							$img = ''; 

							( $img != '' ) ? 

							$c = '' : $c = 'd-none';?>

							<img src="<?=$img?>" alt="<?=$field['key']?>" 

							class="w-100 <?=$c?> <?=$height?>">

							<?php

						else :

							if( isset( $result['content'][$field['key']] ) ) : ?>

								<div class="row" id="images">

									<?php								foreach( $result['content'][$field['key']]['path'] as $path ) : ?>

										<div class="col-md-4">

											<img src="{{asset($path)}}" class="w-100">

										</div>

									<?php								endforeach; ?>

								</div>

							<?php 						endif;

						endif;	?>

					</div>

				</div>				

				<?php			break;

				case 'video': ?>

				<div class="form-group  mt-3">

					<label for="video" class="control-label"><?=$field['title']?></label>

					<?php				( isset( $result['content'][ $field['key'] ] ) ) ?

					$height = '' : $height = $field['height']; ?>

					<div class="featuredWrap featured <?=$height?>">

						<button class="btn uploader  btn-primary" data-type="single">+</button>

						<input type="hidden" id="<?=$field['key']?>" class="<?= !empty($field['is_required']) && $field['is_required'] == 1 ? 'required' : '' ?>"

						name="<?=$field['key']?>" value="

						<?php if( isset( $result['content'][$field['key']] ) ){ 

							echo $result['content'][$field['key']]['id'];

						}?>">

						<?php 

						if( isset( $result['content'][$field['key'] ] ) ) :  ?>

							<div class="w-100 mt-3">

								<video controls class="w-100">

									<source src="{{asset($result['content'][$field['key']]['path'])}}">

									</video>

								</div>

							<?php					endif;?>

						</div>

					</div>

					<?php break;

					case 'repetitive':

					$str = '';

					
					foreach($field['subfields'] as $subfield) :  $str.= $subfield['key'].','; endforeach;?>

					<div class="form-group repetitive_parent gap-3 flex-column d-flex mt-3">

						<label for="<?=$field['key']?>" class="repetitive_label justify-content-between">

							<?=$field['title']?>

							<a href="javascript:;" class="btn btn-primary repeat" 
							data-initial="<?=$str?>" data-direction="#<?=$field['key']?>">+</a>

						</label>


						<?php if( isset( $result['content'][$field['key']] ) ) : ?>

							<input type="hidden" name="<?=$field['key']?>" id="<?=$field['key']?>" 
							value="<?=$result['content'][$field['key']]?>">

							<?php

							$repetetive = array_filter(explode( ',' , $field['key'] ));

							$keys = explode(',', $result['content'][$field['key']] );

							foreach($keys as $index => $ke) : 
								$keys[$index] = preg_replace("/[^0-9]/", '', $ke );  
							endforeach;

							$count = max($keys);

							$keys = explode(',', $result['content'][$field['key']] );

							for($i = 0 ; $i <= $count; $i++ ) : ?>

								<div class="repetitive_content">

									<div class="row">

										<?php 

										foreach($field['subfields'] as $subfield) : ?>

											<div class="col-md-<?=$subfield['column_class']?>">

												<?php								

												switch ($subfield['field-type']) {

													case 'image': ?>

													<div class="form-group">

														<?php ( isset( $result['content'][ $subfield['key'].$i ] ) ) ?

														$height = '' : $height = $subfield['height'] ; 

														( isset( $result['content'][$subfield['key'].$i] ) ) ? 

														$c1 = 'featured' : $c1 = ''; 

														( isset( $result['content'][$subfield['key'].$i] ) ) ? 

														$img = asset($result['content'][$subfield['key'].$i]['path']) : 

														$img = ''; 

														( isset( $result['content'][$subfield['key'].$i] ) ) ? 

														$c = '' : $c = 'd-none';?>

														<div class="featuredWrap <?=$c1?>">

															<button title="<?=$subfield['title']?>" class="btn  uploader featured_image btn-primary" 

																data-type="<?=$subfield['uploadtyp']?>">+

															</button>

															<input type="hidden" id="<?=$subfield['key'].$i?>"  class="<?= !empty($field['is_required']) && $field['is_required'] == 1 ? 'required' : '' ?>"

															name="<?=$subfield['key'].$i?>" value="

															<?php if( isset( $result['content'][ $subfield['key'].$i ] ) ){ 

																echo $result['content'][ $subfield['key'].$i ]['id'];

															}?>">

															<img src="<?=$img?>" alt="<?=$subfield['key'].$i?>" 

															class="w-100 <?=$c?> <?=$height?>">

														</div>

													</div>	

													<?php 

													break;

													case 'text': ?>

													<div class="form-group">

														<input type="text" name="<?=$subfield['key'].$i?>" 

														value="<?php 

														if(isset($result['content'][$subfield['key'].$i])){

															echo $result['content'][$subfield['key'].$i];

														}

													?>" id="tagline" placeholder="<?=$subfield['title']?>" 
													class="form-control <?= !empty($field['is_required']) && $field['is_required'] == 1 ? 'required' : '' ?>">

												</div>	

												<?php break; 

												case 'editor': ?>

												<div class="form-group  mt-3">

													<label for="<?=$subfield['key'].$i?>" class="control-label mb-1">

														<?=$subfield['title']?>

													</label>

													<textarea class="quilleditor <?= !empty($field['is_required']) && $field['is_required'] == 1 ? 'required' : '' ?>" name="<?=$subfield['key'].$i?>" height="<?=$subfield['height']?>"

														menubar="<?=$subfield['menubar']?>">

														<?php 

														if( isset( $result['content'][ $subfield['key'].$i] ) )

														{ 
															echo $result['content'][$subfield['key'].$i];
														}

														?>

													</textarea>

												</div>					

												<?php break;}?>

											</div>

										<?php endforeach;?>

									</div>

								</div>

							<?php			endfor; ?>

						<?php else : ?>

							<div class="repetitive_content">

								<div class="row">

									<?php 

									foreach($field['subfields'] as $subfield) : ?>

										<div class="col-md-<?=$subfield['column_class']?>">

											<?php								

											switch ($subfield['field-type']) {

												case 'image': ?>

												<div class="form-group">

													<?php ( isset( $result['content'][ $subfield['key'] ] ) ) ?

													$height = '' : $height = $subfield['height'] ; 

													( isset( $result['content'][$subfield['key']] ) ) ? 

													$img = asset($result['content'][$subfield['key']]['path']) : 

													$img = ''; 

													( isset( $result['content'][$subfield['key']] ) ) ? 

													$c1 = 'featured' : $c1 = '';

													( isset( $result['content'][$subfield['key']] ) ) ? 

													$c = '' : $c = 'd-none';?>

													<div class="featuredWrap featured">

														<button title="<?=$subfield['title']?>" class="btn  uploader featured_image btn-primary" 

															data-type="<?=$subfield['uploadtyp']?>">+

														</button>

														<input type="hidden" id="<?=$subfield['key']?>" class="<?= !empty($field['is_required']) && $field['is_required'] == 1 ? 'required' : '' ?>"

														name="<?=$subfield['key']?>" value="

														<?php if( isset( $result['content'][ $subfield['key'] ] ) ){ 

															echo $result['content'][ $subfield['key'] ]['id'];

														}?>">

														<img src="<?=$img?>" alt="<?=$subfield['key']?>" 

														class="w-100 <?=$c?> <?=$height?>">

													</div>

												</div>	

												<?php 

												break;

												case 'text': ?>

												<div class="form-group">

													<input type="text" name="<?=$subfield['key']?>" 

													value="<?php 

													if(isset($result['content'][$subfield['key']])){

														echo $result['content'][$subfield['key']];

													}

												?>" id="tagline" placeholder="<?=$subfield['title']?>" 
												class="form-control <?= !empty($field['is_required']) && $field['is_required'] == 1 ? 'required' : '' ?>">

											</div>	

											<?php break; 

											case 'editor': ?>

											<div class="form-group  mt-3">

												<label for="<?=$subfield['key']?>" class="control-label mb-1">

													<?=$subfield['title']?>

												</label>


												<textarea class="quilleditor <?= !empty($field['is_required']) && $field['is_required'] == 1 ? 'required' : '' ?>" name="<?=$subfield['key']?>" height="<?=$subfield['height']?>"

													menubar="<?=$subfield['menubar']?>">

													<?php 

													if( isset( $result['content'][ $subfield['key']] ) )

													{ 
														echo $result['content'][$subfield['key']];
													}

													?>

												</textarea>

											</div>					

											<?php break;}?>

										</div>

									<?php endforeach;?>

								</div>

							</div>

							<input type="hidden" name="<?=$field['key']?>" id="<?=$field['key']?>" value="<?=$str?>">

						<?php endif;?>


					</div>

					<?php break; }

					echo $colbreak;

					$j++;

				endforeach;?>

			</div>

		</div>

		<?php

		$i++;

	endforeach; ?>

</div>	

</div>
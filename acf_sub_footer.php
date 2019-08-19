<?php

// Create quotes Slider
function acf_sub_footer_template($page_id) {
	$bg_sub_footer = get_field('bg_sub_footer', $page_id);
	$show_sub_footer = get_field('show_sub_footer', $page_id);
	$title = get_field('title_sub_footer', $page_id);
	$content = get_field('content_sub_footer', $page_id);
	$photo = get_field('photo_sub_footer', $page_id);
	?>
	<?php if($show_sub_footer == true) : ?>
		
			<div class="sub-footer-section" <?php echo ($bg_sub_footer ? 'style="background-image: url('.$bg_sub_footer.');"' : ''); ?>>
		  <?php echo ($bg_sub_footer ? '<div class="sec-over"></div>' : ''); ?>
				<div class="container">
					<div class="row">
						<?php if( have_rows('contacts_rep') ): $row_count = count(get_field('contacts_rep')); ?>
							<?php if( $title || $content ) : ?>
								<div class="col-sm-12 col-md-6">
									<h2 class="blocks-title"><?php echo $title; ?></h2>
									<?php if( $content ) : ?>
											<div class="sub-content <?php echo ($photo ? 'sub-photo-show' : ''); ?>">
											  <?php if($photo) : ?>
																			<div class="thumb-wrap">
													<?php echo wp_get_attachment_image( $photo, 'testimonial-thumb', '', array(
														'class'=>'contacts-thumb',
														'alt'=>$content,
														'title'=>$content) ); ?>
																			</div>
											  <?php endif; ?>
												<div class="blocks-desc"><?php echo $content; ?></div>
											</div>
									<?php endif; ?>
								</div>
							<?php endif; ?>
							
								
							<div class="col-sm-12 col-md-6 <?php echo ($row_count > 1 ? 'two-el' : ''); ?>">
								<?php while( have_rows('contacts_rep') ): the_row();
								  $is_address = get_sub_field('this_is_address');
								  $photo_c = get_sub_field('contacts_photo');
								  $contacts_title = get_sub_field('contacts_title');
								  $contacts_sub_title = get_sub_field('contacts_sub_title');  ?>
									<div class="row sub-footer-block <?php echo ($photo_c ? '' : 'empty_photo'); ?>">
										<?php if($photo_c) : ?>
											<div class="thumb-wrap">
										  <?php echo wp_get_attachment_image( $photo_c, 'testimonial-thumb', '', array(
											  'class'=>'contacts-thumb',
											  'alt'=>$contacts_title,
											  'title'=>$contacts_title) ); ?>
											</div>
										<?php endif; ?>
										<div class="contact-content">
										  <?php if($contacts_title) : ?>
											  <h4 class="contact-title <?php echo ($is_address === true ? 'is-address' : ''); ?>"><?php
													  echo $contacts_title; ?></h4>
										  <?php endif; ?>
											<?php if($contacts_sub_title) : ?>
											 <span class="contact-sub-title"> <?php echo $contacts_sub_title; ?></span>
										  <?php endif; ?>
											
											<?php if( have_rows('list_with_contacts') ): ?>
												<ul class="list-wrap">
													<?php while( have_rows('list_with_contacts') ): the_row();
														$or = get_sub_field('phone_or_mail');
														$li = get_sub_field('field_for_phone_or_mail'); ?>
														<li class="list-item <?php echo ($or == 'tel' ? 'tel' : 'mail'); ?>">
															<a href="<?php echo ($or == 'tel' ? 'tel:' : 'mailto:'); ?><?php echo $li; ?>">
																	<?php echo $li; ?>
															</a>
														</li>
													<?php endwhile; ?>
												</ul>
											<?php endif; ?>
										</div>
									</div>
							  <?php endwhile; ?>
							</div>
						<?php else : ?>
							<?php if( $title || $content ) : ?>
									<div class="col-sm-12 col-md-12">
										<h2 class="blocks-title"><?php echo $title; ?></h2>
										<?php if( $content ) : ?>
												<div class="sub-content <?php echo ($photo ? 'sub-photo-show' : ''); ?>">
												  <?php if($photo) : ?>
																				<div class="thumb-wrap">
														<?php echo wp_get_attachment_image( $photo, 'testimonial-thumb', '', array(
															'class'=>'contacts-thumb',
															'alt'=>$content,
															'title'=>$content) ); ?>
																				</div>
												  <?php endif; ?>
													<div class="blocks-desc"><?php echo $content; ?></div>
												</div>
										<?php endif; ?>
									</div>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
	
	<?php endif; ?>

<?php }

// recentre Taxonomy Tabs Shortcode
function acf_sub_footer_shortcode() {
	$queried_object = get_queried_object();
	$page_id = $queried_object->ID;
	ob_start();
	acf_sub_footer_template($page_id);
	$acf_sub_footer = ob_get_clean();
	return $acf_sub_footer;
}
add_shortcode( 'acf_sub_footer', 'acf_sub_footer_shortcode' );


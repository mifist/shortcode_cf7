<?php

// Create quotes Slider
function acf_repeater_cash_cta_template($page_id) {
	$show_cash = get_field('show_cash', $page_id);
	$title_cash = get_field('title_cash', $page_id);
	$top_result_cash = get_field('title_top_result_cash', $page_id);
	$bottom_result_cash = get_field('title_bottom_result_cash', $page_id);
	?>
<?php if($show_cash == true) : ?>
	<?php if( have_rows('big_cta') ): ?>
		<div class="repeater-big-cta-section">
			<div class="container">
				<div class="row">
					<?php if($title_cash) : ?>
						<div class="col-sm-12">
							<h2 class="section-title"><?php echo $title_cash; ?></h2>
						</div>
					<?php endif; ?>
					<div class="col-sm-12 big-cta-container <?php echo (empty($top_result_cash) && empty($bottom_result_cash) ? 'no-cash' : '');
					?>">
						<div class="big-cta-wrap row">
					<?php $row_count = count(get_field('big_cta')); $index = 1;
					while( have_rows('big_cta') ): the_row();
						$icon = get_sub_field('icon');
						$title = get_sub_field('title');
						$description = get_sub_field('description');
						$btn_show = get_sub_field('show_button');
						$btn_name = get_sub_field('button_name');
						$btn_link = get_sub_field('button_link'); ?>
								<div class="big-cta-block <?php echo (empty($top_result_cash) && empty($bottom_result_cash) ? 'no-cash' : '');	?>"><span class="cta-before-icon"></span><span class="counter"><?php echo '0'.$index; ?></span>
										<?php if($icon) : ?>
											<div class="cta-icon">
												<img class="item-icon" src="<?php echo $icon; ?>" alt="<?php echo $title; ?>">
											</div>
												
										<?php endif; ?>
										<?php if($title) : ?>
												<h3 class="item-title"><?php echo $title; ?></h3>
										<?php endif; ?>
										<?php if($description) : ?>
												<div class="item-desc"><?php echo $description; ?></div>
										<?php endif; ?>
					
										<?php if( have_rows('list_ul') ): ?>
												<ul class="list-wrap">
												  <?php while( have_rows('list_ul') ): the_row();
													  $li = get_sub_field('text_li'); ?>
														<li class="list-item"><?php echo $li; ?></li>
												  <?php endwhile; ?>
												</ul>
										<?php endif; ?>
									
									 <?php if($btn_show === true && $btn_name) : ?>
										 <a href="<?php echo $btn_link; ?>"  class="btn-default green green-default"><?php echo
												 $btn_name; ?></a>
									 <?php endif; ?>
								</div>
					<?php $index++; endwhile; ?>
						</div>
				  <?php if( $top_result_cash || $bottom_result_cash ) : ?>
								<div class="cash-result">
									<?php if($top_result_cash) : ?>
										<div class="top-result">
					              <?php echo $top_result_cash; ?>
										</div>
									<?php endif; ?>
							<?php if($bottom_result_cash) : ?>
										<div class="bottom-result">
					             <?php echo $bottom_result_cash; ?>
										</div>
									<?php endif; ?>
								</div>
				  <?php endif; ?>
					</div>
					
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>
		
<?php }

// recentre Taxonomy Tabs Shortcode
function acf_repeater_cash_cta_shortcode() {
	$queried_object = get_queried_object();
	$page_id = $queried_object->ID;
	ob_start();
	acf_repeater_cash_cta_template($page_id);
	$acf_repeater_cash_cta = ob_get_clean();
	return $acf_repeater_cash_cta;
}
add_shortcode( 'acf_repeater_cash_cta', 'acf_repeater_cash_cta_shortcode' );


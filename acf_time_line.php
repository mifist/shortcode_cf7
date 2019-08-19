<?php

// Create quotes Slider
function acf_time_line_template($page_id) {
	$tml_title = get_field('tml_title');
	$tml_description = get_field('tml_description');
	$btn_name_tl = get_field('tml_btn_name', $page_id);
	$btn_link_tl = get_field('tml_btn_link', $page_id); ?>
	<?  ?>
		<div class="time_line-section">
			<div class="container">
				<div class="row ">
					<div class="col-sm-12">
				  <? if( $tml_title ) : ?>
								<h2 class="section-title"><? echo $tml_title; ?></h2>
				  <? endif; ?>
				  <? if( $tml_description ) : ?>
								<div class="section-description"><? echo $tml_description; ?></div>
				  <? endif; ?>
					</div>
					<div class="cell small-12">
				  <? if( have_rows('tml__items') ): ?>
								<ul id="time_line">
						<? $i =1; while( have_rows('tml__items') ): the_row();
							$content = get_sub_field('content');
							$time = get_sub_field('time'); ?>
											<li class="tml-item ">
												<span class="tml-icon"><i class="icon-border"></i></span>
												<? if( $time ) : ?>
													<span class="tml-time"><? echo $time; ?></span>
												<? endif; ?>
												<? if( $content ) : ?>
													<span class="tml-content"><? echo $content; ?></span>
												<? endif; ?>
											</li><!--end of .columns -->
							<? $i++; endwhile; ?>
								</ul> <!-- end #time_line  -->
				  <? endif; ?>
					</div>
					<div class="col-sm-12 cta-section-btn">
					  <?php if($btn_name_tl) : ?>
							<a href="<?php echo $btn_link_tl; ?>" class="btn-default green green-default"><?php echo $btn_name_tl; ?></a>
					  <?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	<? ?>
<?php }

// recentre Taxonomy Tabs Shortcode
function acf_time_line_shortcode() {
	$queried_object = get_queried_object();
	$page_id = $queried_object->ID;
	ob_start();
	acf_time_line_template($page_id);
	$time_line = ob_get_clean();
	return $time_line;
}
add_shortcode( 'acf_time_line', 'acf_time_line_shortcode' );


<?php


// Create quotes Slider
function acf_repeater_timeline_template($page_id) {
	$show_tl = get_field('show_timeline', $page_id);

	$tl_title = get_field('block_title_tl', $page_id);
	$show_btn_tl = get_field('show_button_tl', $page_id);
	$btn_name_tl = get_field('btn_name_tl', $page_id);
	$btn_link_tl = get_field('btn_link_tl', $page_id);
	?>
<?php if($show_tl == true) : ?>
	<?php if( have_rows('tl_columns') ): ?>
		<div class="repeater-timeline-section">
			<div class="container">
				<div class="row">
					<?php if($tl_title) : ?>
						<div class="col-sm-12">
							<h2 class="blocks-title"><?php echo $tl_title; ?></h2>
						</div>
					<?php endif; ?>
					<div class="col-sm-12 tl-block">
						<?php $row_count = count(get_field('tl_columns')); $index = 1;
						while( have_rows('tl_columns') ): the_row();
							$title = get_sub_field('title');
							$description = get_sub_field('description'); ?>
								<div class="tl-item <?php echo ($row_count <= 1 ? '' : ''); ?>">
								 <span class="item-counter"><?php echo $index; ?></span>
									<div class="item-content">
									  <?php if($title) : ?>
											<div class="item-title"><?php echo $title; ?></div>
									  <?php endif; ?>
									  <?php if($description) : ?>
											<div class="item-desc"><?php echo $description; ?></div>
									  <?php endif; ?>
									</div>
								</div>
						<?php $index++; endwhile; ?>
					</div>
					<div class="col-sm-12">
					  <?php if($show_btn_tl === true && $btn_name_tl) : ?>
							<a href="<?php echo $btn_link_tl; ?>" class="btn-default green green-default"><?php echo $btn_name_tl; ?></a>
					  <?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>
		
<?php }

// recentre Taxonomy Tabs Shortcode
function acf_repeater_timeline_shortcode() {
	$queried_object = get_queried_object();
	$page_id = $queried_object->ID;
	ob_start();
	acf_repeater_timeline_template($page_id);
	$acf_repeater_timeline = ob_get_clean();
	return $acf_repeater_timeline;
}
add_shortcode( 'acf_repeater_timeline', 'acf_repeater_timeline_shortcode' );


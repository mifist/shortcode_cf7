<?php


// Create quotes Slider
function acf_testimonials_template() {
	$queried_object = get_queried_object();
	$page_id = $queried_object->ID;
	$bg_nial = get_field('bg_of_nial', $page_id);
	$show_nial = get_field('show_nial', $page_id);
	$title_nial = get_field('title_nial', $page_id);
	$btn_name_nial = get_field('button_name_nail', $page_id);
	$btn_link_nial = get_field('button_link_nail', $page_id);
	$photo_nial = get_field('photo_nial', $page_id);
	$name_nial = get_field('name_nial', $page_id);
	$position_nial = get_field('position_nial', $page_id);
	$content_nial = get_field('content_nial', $page_id);
	?>
<?php if($show_nial == true) : ?>
	<?php if( have_rows('lists_blocks') ): ?>
		<div class="testimonials-section" <?php echo ($bg_nial ? 'style="background-image: url('.$bg_nial.');"' : ''); ?>>
		<?php echo ($bg_nial ? '<div class="sec-over"></div>' : ''); ?>
			<div class="container">
				<div class="row">
					 <?php if($title_nial) : ?>
						 <div class="col-sm-12">
							 <h2 class="blocks-title"><?php echo $title_nial; ?></h2>
						 </div>
					 <?php endif; ?>
					<div class="col-sm-12">
						<div class="nial-block">
							<?php if($photo_nial) : ?>
								<?php echo wp_get_attachment_image( $photo_nial, 'testimonial-thumb', '', array(
										'class'=>'nial-thumb',
										'title'=>$name_nial) ); ?>
							<?php endif; ?>
							<?php if($name_nial) : ?>
								<h3 class="nial-title"><?php echo $name_nial; ?></h3>
							<?php endif; ?>
							<?php if($position_nial) : ?>
								<h3 class="position-nial"><?php echo $position_nial; ?></h3>
							<?php endif; ?>
							<?php if($content_nial) : ?>
								<h3 class="nial-content"><?php echo $content_nial; ?></h3>
							<?php endif; ?>
						</div>
					  <?php if($btn_name_nial) : ?>
							<a href="<?php echo $btn_link_nial; ?>" class="btn-default green green-default"><?php echo $btn_name_nial; ?></a>
					  <?php endif; ?>
					</div>
					
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>
		
<?php }

// recentre Taxonomy Tabs Shortcode
function acf_testimonials_shortcode() {
	ob_start();
	acf_testimonials_template();
	$acf_testimonials = ob_get_clean();
	return $acf_testimonials;
}
add_shortcode( 'acf_testimonials', 'acf_testimonials_shortcode' );


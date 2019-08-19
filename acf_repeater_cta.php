<?php


// Create quotes Slider
function acf_repeater_cta_template($page_id) {
	$show_cta = get_field('show_cta_blocks', $page_id);
	$cta_title = get_field('cta_title', $page_id);
	$cta_desc = get_field('cta_desc', $page_id);
	$btn_for_s_link = get_field('button_for_section_link', $page_id);
	$btn_for_s_name = get_field('cta_btn_for_section_name', $page_id);
	?>
<?php if($show_cta == true) : ?>
	<?php if( have_rows('cta_columns') ): ?>
		<div class="repeater-cta-section">
			<div class="container">
				<div class="row">
					<?php if($cta_title || $cta_desc) : ?>
						<div class="col-sm-12">
							<? if( $cta_title ) : ?>
								<h2 class="section-title"><?php echo $cta_title; ?></h2>
							<? endif; ?>
							<? if( $cta_desc ) : ?>
								<div class="section-description">	<? echo $cta_desc; ?></div>
							<? endif; ?>
						</div>
					<?php endif; ?>
					<?php $row_count = count(get_field('cta_columns'));
					while( have_rows('cta_columns') ): the_row();
						$btn_show = get_sub_field('show_column_button');
						$btn_name = get_sub_field('column_btn_name');
						$btn_link = get_sub_field('column_btn_link');
						$show_upload_pdf = get_sub_field('show_column_upload_pdf');
						$column_link_pdf = get_sub_field('column_link_pdf');
			      $send_to_mail = get_sub_field('column_send_mail');
			        $file_name = get_sub_field('column_file_name');
						  if ( $show_upload_pdf == true ) {
							  if(!empty($column_link_pdf)) { $column_link_pdf = '?get_pdf='. $column_link_pdf; }
							  if(!empty($send_to_mail) && !empty($column_link_pdf)) { $send_to_mail = '&send_to='. $send_to_mail; } else
							  {$send_to_mail = '?send_to='. $send_to_mail; }
						  }
						  if( !empty($file_name) && !empty($send_to_mail) && !empty($show_upload_pdf) ) {
							  $file_name = '&file_name='. $file_name;
						  } elseif( !empty($file_name) && empty($send_to_mail) && empty($show_upload_pdf) ) {
							  $file_name = '?file_name='. $file_name;
						  }
						?>
								<div class="cta-block col-sm-12 <?php
								if  ( $row_count <= 1 ) { echo 'col-md-12'; }
								elseif( $row_count == 2 ) { echo 'col-md-6'; }
								elseif( $row_count == 3 ) { echo 'col-md-4'; }; ?>">
								  <?php if( have_rows('column_item') ): ?>
										  <div class="cta-wrap <?php echo ($row_count > 1 ? 'half' : 'no-half'); ?>">
												<?php while( have_rows('column_item') ): the_row();
													$title = get_sub_field('title');
													$icon = get_sub_field('icon');
													$description = get_sub_field('description');
													$link_title = get_sub_field('link_title');
													$link = get_sub_field('link');
													?>
													<div class="cta-item <?php echo ($row_count > 1 ? 'half' : 'no-half'); ?>">
													  <?php if($icon) : ?>
														  <img class="item-icon" src="<?php echo $icon; ?>" alt="<?php echo $title; ?>">
													  <?php endif; ?>
													  <?php if($title) : ?>
																<h3 class="item-title"><?php echo $title; ?></h3>
													  <?php endif; ?>
													  <?php if($description) : ?>
														  <div class="item-desc"><?php echo $description; ?></div>
													  <?php endif; ?>
													  <?php if($link_title) : ?>
															<a href="<?php echo $link; ?>" class="item-link"><?php echo $link_title; ?></a>
													  <?php endif; ?>
													</div>
												<?php endwhile; ?>
										  </div>
								  <?php endif; ?>
									 <?php if($btn_show === true && $btn_name) : ?>
										 <a href="<?php echo $btn_link.$column_link_pdf.$send_to_mail.$file_name; ?>" target="_blank" class="btn-default green green-default">
												 <?php echo $btn_name; ?></a>
									 <?php endif; ?>
								</div>
					<?php endwhile; ?>
					<?php if( $btn_for_s_name ) : ?>
						<div class="col-sm-12 cta-section-btn">
							<a href="<?php echo $btn_for_s_link; ?>" class="btn-default green green-default">
					  <?php echo $btn_for_s_name; ?></a>
						</div>
					<?php endif; ?>
					
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>
		
<?php }

// recentre Taxonomy Tabs Shortcode
function acf_repeater_cta_shortcode() {
	$queried_object = get_queried_object();
	$page_id = $queried_object->ID;
	ob_start();
	acf_repeater_cta_template($page_id);
	$acf_repeater_cta = ob_get_clean();
	return $acf_repeater_cta;
}
add_shortcode( 'acf_repeater_cta', 'acf_repeater_cta_shortcode' );


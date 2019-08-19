<?php


// Create quotes Slider
function acf_repeater_lists_template($page_id) {
	$bg_list = get_field('background_list', $page_id);
	$bg_color_list = get_field('background_list_color', $page_id);
	$show_lists = get_field('show_lists_block', $page_id);
	$list_title = get_field('title_lists_block', $page_id);
	$s_btn_name = get_field('list_btn_for_section_name', $page_id);
	$s_btn_list = get_field('list_btn_for_section_link', $page_id);
	?>
<?php if($show_lists == true) : ?>
	<?php if( have_rows('lists_blocks') ): ?>
		<div class="repeater-lists-section" <?php echo ($bg_list ? 'style="background-image: url('.$bg_list.');"' : ''); ?>>
		<?php echo ($bg_list ? '<div class="sec-over" style="background-color: '. ($bg_color_list ? $bg_color_list : '#00aad4') .';"></div>' : ''); ?>
			<div class="container">
			  <?php if($list_title ) : ?>
					<div class="row">
						<div class="col-sm-12">
						<? if( $list_title ) : ?>
								<h2 class="section-title"><?php echo $list_title; ?></h2>
						<? endif; ?>
						</div>
					</div>
			  <?php endif; ?>
				<div class="row">
					<?php $row_count = count(get_field('lists_blocks'));
					while( have_rows('lists_blocks') ): the_row();
						$title = get_sub_field('list_title');
						$title_color = get_sub_field('title_color');
						$btn_show = get_sub_field('show_button');
						$btn_name = get_sub_field('button_name');
						$btn_link = get_sub_field('button_link');
					  $show_upload_pdf = get_sub_field('show_list_upload_pdf');
					  $column_link_pdf = get_sub_field('list_link_pdf');
					  $send_to_mail = get_sub_field('list_send_mail');
			       $file_name = get_sub_field('list_file_name');
					  if ( $show_upload_pdf == true ) {
						  if(!empty($column_link_pdf)) { $column_link_pdf = '?get_pdf='. $column_link_pdf; }
						  if(!empty($send_to_mail) && !empty($column_link_pdf)) { $send_to_mail = '&send_to='. $send_to_mail; } else
						  {$send_to_mail = '?send_to='. $send_to_mail; }
					    if( !empty($file_name) && !empty($send_to_mail) && !empty($column_link_pdf) ) {
						    $file_name = '&file_name='. $file_name;
					    } elseif( !empty($file_name) && empty($send_to_mail) && empty($column_link_pdf) ) {
						    $file_name = '?file_name='. $file_name;
					    }
					  } ?>
								<div class="lists-block <?php echo ($row_count <= 1 ? 'one-list' : ''); ?>">
									 <?php if($title) : ?>
										 <h3 class="list-title <?php echo ($row_count <= 1 ? 'one-item' : ''); ?>"
												 <? echo ($title_color ? 'style="color: '.$title_color.';"' : ''); ?>>
												 <?php echo $title; ?>
										 </h3>
									 <?php endif; ?>
								  <?php if( have_rows('list_items') ): ?>
										  <ul class="list-wrap">
												<?php while( have_rows('list_items') ): the_row();
													$li = get_sub_field('list_item'); ?>
													<li class="list-item"><?php echo $li; ?></li>
												<?php endwhile; ?>
										  </ul>
								  <?php endif; ?>
									 <?php if($btn_show === true && $btn_name) : ?>
										 <a href="<?php echo $btn_link.$column_link_pdf.$send_to_mail.$file_name; ?>" target="_blank" class="btn-default green green-default">
						            <?php echo $btn_name; ?></a>
									 <?php endif; ?>
								</div>
					<?php endwhile; ?>
				</div>
			  <?php if($s_btn_name ) : ?>
					<div class="row">
						<div class="col-sm-12 cta-section-btn">
							<a href="<?php echo $s_btn_list; ?>" class="btn-default green green-default">
				  <?php echo $s_btn_name; ?></a>
						</div>
					</div>
			  <?php endif; ?>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>
		
<?php }

// recentre Taxonomy Tabs Shortcode
function acf_repeater_lists_shortcode() {
	$queried_object = get_queried_object();
	$page_id = $queried_object->ID;
	ob_start();
	acf_repeater_lists_template($page_id);
	$acf_repeater_lists = ob_get_clean();
	return $acf_repeater_lists;
}
add_shortcode( 'acf_repeater_lists', 'acf_repeater_lists_shortcode' );


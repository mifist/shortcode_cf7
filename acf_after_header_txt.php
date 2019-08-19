<?php


// Create quotes Slider
function acf_after_header_txt_template($page_id) {
	$after_h_icon = get_field('after_h_icon', $page_id);
	$fullscreen_icon = get_field('fullscreen_icon', $page_id);
	$after_h_fs_c = get_field('font_style_of_content', $page_id);
	$after_h_fz_c = get_field('font_size_of_content', $page_id);
	$after_h_content = get_field('after_h_content', $page_id);
	$after_h_show_btn = get_field('after_h_show_btn', $page_id);
	$after_h_btn_name = get_field('after_h_btn_name', $page_id);
	$after_h_btn_link = get_field('after_h_btn_link', $page_id);
	$show_upload_pdf = get_field('show_after_upload_pdf', $page_id);
	$send_to_mail = get_field('after_send_mail', $page_id);
	$after_h_btn_file = get_field('after_h_link_file', $page_id);
	$file_name = get_field('after_file_name', $page_id);
	$show_sidebar = get_field('after_h_show_sidebar', $page_id);
	$title_for_side_bar = get_field('title_for_side_bar', $page_id);
	if ( $show_upload_pdf == true ) {
	  if(!empty($after_h_btn_file)) { $after_h_btn_file = '?get_pdf='. $after_h_btn_file; }
	  if(!empty($send_to_mail) && !empty($after_h_btn_file)) { $send_to_mail = '&send_to='. $send_to_mail; }
	  else { $send_to_mail = '?send_to='. $send_to_mail; }
	  if( !empty($file_name) && !empty($send_to_mail) && !empty($after_h_btn_file) ) {
		  $file_name = '&file_name='. $file_name;
	  } elseif( !empty($file_name) && empty($send_to_mail) && empty($after_h_btn_file) ) {
		  $file_name = '?file_name='. $file_name;
	  }
	}

	?>
			<div class="after-header-section <?php echo ($show_sidebar === true ? 'show-sidebar' : ''); ?>">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 <?php echo ($show_sidebar === true ? 'col-md-8 part-sidebar' : 'col-md-12'); ?>">
								
							 <?php if($after_h_icon && $show_sidebar === false) : ?>
									 <div class="after-icon ">
										 <img src="<?php echo $after_h_icon; ?>" alt="">
									 </div>
							 <?php endif; ?>
							 <?php if($after_h_content) : ?>
								 <div class="content"
								      style="font-family: <?php echo ($after_h_fs_c == 'lora' ? 'Lora, serif; font-style: italic;' : 'Avenir, sans-serif;font-style: normal;'); ?>; font-size: <?php echo (!empty($after_h_fz_c) ? $after_h_fz_c.'px;' : '18px;'); ?>">
					          <?php echo $after_h_content; ?>
								 </div>
							 <?php endif; ?>
							 <?php if($after_h_show_btn === true && $after_h_btn_name && $show_sidebar === false) : ?>
								 <a href="<?php echo $after_h_btn_link.$after_h_btn_file.$send_to_mail.$file_name; ?>"
								    class="btn-default green" target="_blank"
								    data-get_pdf="<?php echo $after_h_btn_file; ?>"><?php echo $after_h_btn_name; ?></a>
							 <?php endif; ?>
						</div>
					
					 <?php if($show_sidebar === true) : ?>
						 <div class="col-sm-12 col-md-4 sidebar-container <? echo (empty($after_h_icon) ? 'after_hide_icon': '');
						 ?>">
							 <div class="show-sidebar-container <? echo ( $fullscreen_icon===true ? 'fullscreen_icon' : ''); ?>">
							  <?php if($title_for_side_bar) : ?>
							  	<h5 class="title-sidebar <? echo ( $fullscreen_icon===true ? 'fullscreen_icon' : ''); ?>"><?php echo $title_for_side_bar; ?></h5>
							  <?php endif; ?>
							 <?php if($after_h_icon) : ?>
								 <div class="after-icon h-sidebar <? echo ( $fullscreen_icon===true ? 'fullscreen_icon' : ''); ?>">
									 <img src="<?php echo $after_h_icon; ?>" alt="">
								 </div>
							 <?php endif; ?>
							 <?php if($after_h_show_btn === true && $after_h_btn_name) : ?>
								 <a href="<?php echo $after_h_btn_link.$after_h_btn_file.$send_to_mail.$file_name; ?>"
								    class="btn-default green h-green"
								    data-get_pdf="<?php echo $after_h_btn_file; ?>"><?php echo $after_h_btn_name; ?></a>
							 <?php endif; ?>
							 </div>
						 </div>
					 <?php endif; ?>
						
					</div>
				</div>
			
			
			</div>

<?php }

// recentre Taxonomy Tabs Shortcode
function acf_after_header_txt_shortcode() {
	$queried_object = get_queried_object();
	$page_id = $queried_object->ID;
	ob_start();
	acf_after_header_txt_template($page_id);
	$after_header_txt = ob_get_clean();
	return $after_header_txt;
}
add_shortcode( 'acf_after_header_txt', 'acf_after_header_txt_shortcode' );


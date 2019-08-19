<?php



function get_cat_tabs_data($array_id) {
	$tabs = array();
	foreach ($array_id as $arr_id) :
		$tabs[] = get_term_by( 'id', $arr_id, 'tabs_categories' );
	endforeach;
	return $tabs;
}


function get_cat_first_tab_data($array_ids) {
	$tab_first = array();
	  foreach ($array_ids as $array_id) :
	    $tab_data = get_term_by( 'id', $array_id, 'tabs_categories' );
		  if($tab_data->count > 0) {
		    $tab_first[] = $tab_data->term_id;
		  }
		endforeach;
	return $tab_first[0];
}

function render_cat_tabs($tabs) { ?>
	<ul class="category_tabs">
	<?php $index = 0; foreach ($tabs as $tab) : ?>
		<?php if($tab->count > 0) : ?>
		<?php if($index == 0) : ?>
			<li class="tab-item active_tab">
		<?php else : ?>
			<li class="tab-item">
		<?php endif; ?>
				<a target="_blank" href="#tab_<?php echo $tab->term_id; ?>" data-tab-id="<?php echo $tab->term_id; ?>" title="<?php echo
				$tab->slug; ?>">
		      <?php /*echo do_shortcode(sprintf('[wp_custom_image_category term_id="%s"]', $tab->term_id)); */?>
						<span class="name"><?php echo $tab->name; ?></span>
				</a>
			</li>
			<?php endif;?>
	<?php $index++; endforeach;?>
	</ul>
	<?php
}


// Create quotes Slider
function category_tabs_template($choice_category) {
	// get term content
	$tabs = get_cat_tabs_data($choice_category);

	// get first term id
	$tab_first_id = get_cat_first_tab_data($choice_category);

	$arg = array(
	  'post_type'	      => 'post', /*<-- Enter name of Custom Post Type here*/
	  'order'		        => 'DESC',
	  'orderby'	        => 'date',
		'posts_per_page'  => 3,
  //  'post_status'     => 'publish', //'publish'
    'tax_query' => array(
	    array(
		    'taxonomy' => 'tabs_categories',
		    'field'    => 'id',
		    'terms'    => $tab_first_id
	    )
    )
	);
	$the_query = new WP_Query( $arg );
	$cat_title = get_field('title_for_categories_button', icl_object_id(72, 'settings', true));

	
		if( $the_query->have_posts() ):
		$add_link = get_field('add_custom_link_tabs', 'tabs_categories_' .$tab_first_id);
		$custom_cat_link = get_field('custom_tabs_link', 'tabs_categories_' .$tab_first_id);
		$cat_link = get_term_link( $tab_first_id, 'tabs_categories' ); ?>
	<div class="categories-tabs-section">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<?php render_cat_tabs($tabs); // term render html ?>
					<div id="categories-posts" class="row active_tab" data-tab-id="<?php echo $tab_first_id; ?>">
						<?php $index = 1; while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
				
							<?php get_template_part('template-parts/post', 'default'); ?>
								
						<?php $index++; endwhile; wp_reset_postdata(); ?>
					  <?php if( $cat_title ) : ?>
								<div class="cat-btn-wrap col-sm-12 end">
									<a target="_blank" id="<?php echo $add_link; ?>" href="<?php echo ($add_link === true ? ($custom_cat_link ? $custom_cat_link : $cat_link) : $cat_link); ?>" class="btn btn-blog-cat">
											<?php echo $cat_title; ?>
									</a>
								</div>
					  <?php endif; ?>
					</div><!-- END of  #home-slider-->
				</div>
				 
			</div>
		</div>
	</div>
	<?php endif; ?>

<?php }

// recentre Taxonomy Tabs Shortcode
function category_tabs_shortcode() {
	$queried_object = get_queried_object();
	$page_id = $queried_object->ID;
	$term_id = $queried_object->term_id;
	ob_start();
	
	$posts_footer = get_field('blog_posts_section_for_footer', icl_object_id(72, 'settings', true));
	if( !empty($posts_footer) ) {
	  category_tabs_template($posts_footer);
	}
	$category_tabs = ob_get_clean();
	return $category_tabs;
}
add_shortcode( 'categories_tabs', 'category_tabs_shortcode' );



// ajax load more posts for tabs
add_action( 'wp_ajax_category_tabs_ajax', 'category_tabs_ajax' );
add_action( 'wp_ajax_nopriv_category_tabs_ajax', 'category_tabs_ajax' );
function category_tabs_ajax() {
	
	$current_term_id = $_POST['current_term_id'];
	$arg = array(
		'post_type'	      => 'post', /*<-- Enter name of Custom Post Type here*/
		'order'		        => 'DESC',
		'orderby'	        => 'date',
		'posts_per_page'  => 3,
	//	'post_status'     => 'publish', //'publish'
		'tax_query' => array(
			array(
				'taxonomy' => 'tabs_categories',
				'field'    => 'id',
				'terms'    => $current_term_id
			)
		)
	);
	$cat_title = get_field('title_for_categories_button', icl_object_id(72, 'settings', true));
	
	$the_query = new WP_Query( $arg );

	
	if( $the_query->have_posts() ):
	  $add_link = get_field('add_custom_link_tabs', 'tabs_categories_' .$current_term_id);
	  $custom_cat_link = get_field('custom_tabs_link', 'tabs_categories_' .$current_term_id);
	  $cat_link = get_term_link( (int) $current_term_id, 'tabs_categories' ); ?>
	  <?php $index = 1; while ( $the_query->have_posts() ) : $the_query->the_post();  ?>
		  
		  <?php get_template_part('template-parts/post', 'default'); ?>
		
	  <?php $index++; endwhile; wp_reset_postdata(); ?>
	  
	  <?php if( $cat_title ) :?>
			<div class="cat-btn-wrap col-sm-12 end">
				<a target="_blank" href="<?php echo ($add_link === true ? ($custom_cat_link ? $custom_cat_link : $cat_link) : $cat_link); ?>" class="btn btn-blog-cat">
						<?php echo $cat_title; ?>
				</a>
			</div>
	  <?php endif; ?>
			
	<?php endif;
	die();
}
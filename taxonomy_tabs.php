<?php

function get_tabs_data($array_id) {
	$tabs = array();
	foreach ($array_id as $arr_id) :
		$tabs[] = get_term_by( 'id', $arr_id, 'tabs_categories' );
	endforeach;
	return $tabs;
}



function get_first_tab_data($array_ids) {
	$tab_first = array();
	foreach ($array_ids as $array_id) :
		$tab_data = get_term_by( 'id', $array_id, 'tabs_categories' );
		if($tab_data->count > 0) {
			$tab_first[] = $tab_data->term_id;
		}
	endforeach;
	return $tab_first[0];
}

function render_tabs($tabs) { ?>
	<ul class="taxonomy_tabs">
	<?php $index = 0; foreach ($tabs as $tab) : ?>
		<?php if($tab->count > 0) : ?>
		<?php if($index == 0) : ?>
			<li class="tab-item active_tab">
		<?php else : ?>
			<li class="tab-item">
		<?php endif; ?>
				<a href="#tab_<?php echo $tab->term_id; ?>" data-tab-id="<?php echo $tab->term_id; ?>" title="<?php echo $tab->slug; ?>">
		      <?php echo do_shortcode(sprintf('[wp_custom_image_category term_id="%s"]', $tab->term_id)); ?>
						<span class="name"><?php echo $tab->name; ?></span>
				</a>
			</li>
		<?php endif; ?>
	<?php $index++; endforeach;?>
	</ul>
	<?php
}


// Create quotes Slider
function taxonomy_tabs_template($choice_category) {
	// get term content
	$tabs = get_tabs_data($choice_category);

	// get first term id
	$tab_first = get_first_tab_data($choice_category);

	$arg = array(
	  'post_type'	      => 'post', /*<-- Enter name of Custom Post Type here*/
	  'order'		        => 'DESC',
	  'orderby'	        => 'date',
		'posts_per_page'  => 5,
   // 'post_status'     => 'draft', //'publish'
    'tax_query' => array(
	    array(
		    'taxonomy' => 'tabs_categories',
		    'field'    => 'id',
		    'terms'    => $tab_first
	    )
    )
	);
	
	$the_query = new WP_Query( $arg );

		if( $the_query->have_posts() ): ?>
	<div class="taxonomy-tabs-section">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<?php render_tabs($tabs); // term render html ?>
					<div id="taxonomy-posts" class="row active_tab" data-tab-id="<?php echo $tab_first; ?>">
						<?php $index = 1; while ( $the_query->have_posts() ) : $the_query->the_post();  ?>
								
							 <?php if($index == 4) : ?>
									<?php get_template_part('template-parts/post', 'big'); ?>
								<?php elseif($index == 5) : ?>
									<?php get_template_part('template-parts/post', 'vertical'); ?>
								<?php else : ?>
									<?php get_template_part('template-parts/post', 'default'); ?>
							 <?php endif; ?>
								
						<?php $index++; endwhile; wp_reset_postdata(); ?>
					</div><!-- END of  #home-slider-->
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

<?php }

// recentre Taxonomy Tabs Shortcode
function taxonomy_tabs_shortcode() {
	ob_start();
	
	$choice_category = get_field('choice_category');
	if( !empty($choice_category) ) {
	  taxonomy_tabs_template($choice_category);
	}
	$taxonomy_tabs = ob_get_clean();
	return $taxonomy_tabs;
}
add_shortcode( 'taxonomy_tabs_choice', 'taxonomy_tabs_shortcode' );



// ajax load more posts for tabs
add_action( 'wp_ajax_taxonomy_tabs_ajax', 'taxonomy_tabs_ajax' );
add_action( 'wp_ajax_nopriv_taxonomy_tabs_ajax', 'taxonomy_tabs_ajax' );
function taxonomy_tabs_ajax() {
	
	$current_term_id = $_POST['current_term_id'];
	$arg = array(
		'post_type'	      => 'post', /*<-- Enter name of Custom Post Type here*/
		'order'		        => 'DESC',
		'orderby'	        => 'date',
		'posts_per_page'  => 5,
		//'post_status'     => 'draft', //'publish'
		'tax_query' => array(
			array(
				'taxonomy' => 'tabs_categories',
				'field'    => 'id',
				'terms'    => $current_term_id
			)
		)
	);
	
	$the_query = new WP_Query( $arg );
	
	if( $the_query->have_posts() ): ?>
	  <?php $index = 1; while ( $the_query->have_posts() ) : $the_query->the_post();  ?>
		  
		  <?php if($index == 4) : ?>
			  <?php get_template_part('template-parts/post', 'big'); ?>
		  <?php elseif($index == 5) : ?>
			  <?php get_template_part('template-parts/post', 'vertical'); ?>
		  <?php else : ?>
			  <?php get_template_part('template-parts/post', 'default'); ?>
		  <?php endif; ?>
	  
	  <?php $index++; endwhile; wp_reset_postdata(); ?>
	<?php endif;
	die();
}
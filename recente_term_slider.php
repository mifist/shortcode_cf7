<?php


/*function get_tabs_data($array_id) {
	$tabs = array();
	foreach ($array_id as $arr_id) :
		$tabs[] = get_term_by( 'id', $arr_id, 'tabs_categories' );
	endforeach;
	return $tabs;
}*/

// Create quotes Slider
function recente_term_slider_template($page_id, $recent_term) { ?>
	
	<script async type="text/javascript">
	  jQuery(document).on('ready', function() {
		  jQuery('#recente_term_slider').slick({
			  //cssEase: 'ease', // 'linear'
			  easing: 'linear',
			  fade: false,
			  arrows: false,
		    appendDots: jQuery('.recentre-section').find('.section-header'),
			  dots: true,
			  infinite: true,
			  speed: 500,
			  draggable: true,
			  swipe: true,
			  autoplay: false,
			  autoplaySpeed: 3000,
			  slidesToShow: 4,
			  slidesToScroll: 4,
			  prevArrow: '<div class="slick-prev"></div>',
			  nextArrow: '<div class="slick-next"></div>',
			  responsive: [
				  {
					  breakpoint: 1024,
					  settings: {
						  slidesToShow: 3,
						  slidesToScroll: 3
					  }
				  },
				  {
					  breakpoint: 641,
					  settings: {
						  slidesToShow: 1,
						  slidesToScroll: 1
					  }
				  }
			  ]
			  
		  });
		  
	  });
	</script>
		
	<?php
	$arg = array(
		'post_type'	      => 'post', /*<-- Enter name of Custom Post Type here*/
		'order'		        => 'DESC',
		'orderby'	        => 'date',
	  'post_status'     => 'publish', //'publish' draft
		'posts_per_page'  => 16,
		'tax_query' => array(
			array(
				'taxonomy' => 'tabs_categories',
				'field'    => 'id',
				'terms'    => $recent_term
			)
		)
	);
	$title_for_recent = get_field('title_for_recent', $page_id);
	
	$recent_query = new WP_Query( $arg );
		
		if( $recent_query->have_posts() ): ?>
	<div class="recentre-section">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="section-header">
					  <?php if($title_for_recent) : ?>
								<h2 class="section-title"><?php echo $title_for_recent; ?></h2>
					  <?php endif; ?>
					</div>
					<div id="recente_term_slider" class="slick-slider slider" >
						<?php while ( $recent_query->have_posts() ) : $recent_query->the_post(); ?>
									
							<div id="post-<?php the_ID(); ?>" class="recent-post">
								<div class="post-header">
									<?php if ( has_post_thumbnail()) : ?>
										<div class="image"><?php the_post_thumbnail('recent-thumb'); ?></div>
									<?php else : ?>
										<div class="image"><img src="<?php echo get_template_directory_uri() . '/img/icon/mask.png'; ?>"
										                        alt="Placeholder"></div>
									<?php endif; ?>
									<?php echo posts_meta_title(); ?>
								</div>
							 
							  <?php echo posts_entry_meta_link(); ?>
							</div>
						
						<?php endwhile; wp_reset_postdata(); ?>
					</div><!-- END of  #home-slider-->
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

<?php }

// recentre Slider Shortcode

function recente_term_slider_shortcode() {
	$queried_object = get_queried_object();
	$page_id = $queried_object->ID;
	ob_start();
	$show_recent = get_field('show_recent', $page_id);
	$recent_term = get_field('show_recente_term', $page_id);
	if($show_recent === true) {
	  recente_term_slider_template($page_id, $recent_term);
	}

	$slider_recentre = ob_get_clean();
	return $slider_recentre;
}
add_shortcode( 'recente_term_slider', 'recente_term_slider_shortcode' );
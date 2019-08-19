<?php


// Create quotes Slider
function recentre_slider_template() {
	$queried_object = get_queried_object();
	$page_id = $queried_object->ID; ?>
	
	<script async type="text/javascript">
	  jQuery(document).on('ready', function() {
		  jQuery('#recentre_slider').slick({
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
		'posts_per_page'  => 16
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
					<div id="recentre_slider" class="slick-slider slider" >
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

function recentre_slider_shortcode() {
	ob_start();
	$queried_object = get_queried_object();
	$page_id = $queried_object->ID;
	$show_recent = get_field('show_recent', $page_id);
	if($show_recent === true) {
	  recentre_slider_template();
	}

	$slider_recentre = ob_get_clean();
	return $slider_recentre;
}
add_shortcode( 'recentre_slider', 'recentre_slider_shortcode' );
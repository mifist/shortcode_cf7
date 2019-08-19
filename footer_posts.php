<?php



// Create quotes Slider
function footer_posts_template() {
	$page = ( isset($_POST['current_page']) ) ? $_POST['current_page'] : 1;
	$arg = array(
	  'post_type'	      => 'post', /*<-- Enter name of Custom Post Type here*/
	  'order'		        => 'DESC',
	  'post_status'		  => 'publish',
	  'orderby'	        => 'date',
		'posts_per_page'  => 4,
    'paged' => $page
	);
	$the_query = new WP_Query( $arg );
	$btn_more = get_field('title_btn_more', icl_object_id(72, 'settings', true));
	
	
		if( $the_query->have_posts() ): ?>
	<div class="footer-posts-section">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					
					<div id="footer-posts" class="row active_tab">
						<?php $index = 1; while ( $the_query->have_posts() ) : $the_query->the_post();  ?>
								
								<?php if($index == 1) : ?>
									<div class="col-xs-12 col-sm-4 col-md-4 end footer-form-row">
										<?php get_template_part('template-parts/subscribe-footer'); ?>
									</div>
									<?php get_template_part('template-parts/post', 'big'); ?>
								<?php else : ?>
									<?php get_template_part('template-parts/post', 'default'); ?>
								<?php endif; ?>
								
						<?php $index++; endwhile; wp_reset_postdata(); ?>
						
					</div><!-- END of  #home-slider-->
					<div class="row">
						<div class="col-xs-12 col-sm-12">
							<a href="#!" class="btn btn-posts-more">
				        <?php echo $btn_more; ?>
							</a>
						</div>
					</div>
					
				</div>
				 
			</div>
		</div>
	</div>
	<?php endif; ?>

<?php }

// recentre Taxonomy Tabs Shortcode
function footer_posts_shortcode() {
	ob_start();
	$queried_object = get_queried_object();
	$page_id = $queried_object->ID;
	$term_id = $queried_object->term_id;
	footer_posts_template();
	$category_tabs = ob_get_clean();
	return $category_tabs;
}
add_shortcode( 'footer_posts', 'footer_posts_shortcode' );



// ajax load more posts for tabs
add_action( 'wp_ajax_footer_posts_ajax', 'footer_posts_ajax' );
add_action( 'wp_ajax_nopriv_footer_posts_ajax', 'footer_posts_ajax' );
function footer_posts_ajax() {
	$page = ( isset($_POST['current_page']) ) ? $_POST['current_page'] : 2;
	$arg = array(
	  'post_type'	      => 'post', /*<-- Enter name of Custom Post Type here*/
	  'order'		        => 'DESC',
    'post_status'		  => 'publish',
	  'orderby'	        => 'date',
	  'posts_per_page'  => 3,
    'paged' => $page
	);
	$the_query = new WP_Query( $arg );
		
	if( $the_query->have_posts() ): ?>
	  <?php $index = 1; while ( $the_query->have_posts() ) : $the_query->the_post();  ?>
		  
		  <?php get_template_part('template-parts/post', 'default'); ?>
		
	  <?php $index++; endwhile; wp_reset_postdata(); ?>
		<script type="text/javascript">
			/* <![CDATA[ */
	  custom_ajax.current_page = <?php echo $page+1; ?>;
			/* ]]> */
		</script>
	<?php endif;
	die();
}
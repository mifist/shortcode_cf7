<?php

// Create quotes Slider
function quotes_slider_template() { ?>
	
	<script async type="text/javascript">
	  jQuery(document).on('ready',function() {
	    jQuery('#quotes_slider').slick({
				cssEase: 'ease', // 'linear'
		    //easing: 'linear',
				fade: true,
				arrows: true,
				dots: false,
				infinite: true,
				speed: 500,
		    draggable: true,
		    swipe: true,
				autoplay: true,
				autoplaySpeed: 5000,
				slidesToShow: 1,
				slidesToScroll: 1,
				prevArrow: '<div class="slick-prev"></div>',
				nextArrow: '<div class="slick-next"></div>'
			
			});
		
		});
	</script>
	
	<?php if( have_rows('quotes_slider') ): ?>
		
		<div id="quotes_slider" class="slick-slider slider" >
			<?php while( have_rows('quotes_slider') ): the_row();
				$content = get_sub_field('quote_content'); ?>
				 <?php if($content) : ?>
						<div class="slick-slide"  >
							<div class="quotes-wrap">
								<blockquote><?php echo $content; ?></blockquote>
							</div><!--end of .columns -->
						</div>
				 <?php endif; ?>
			<?php endwhile; ?>
		</div><!-- END of  #home-slider-->
	
	<?php endif; ?>

<?php }

// quotes Slider Shortcode

function quotes_slider_shortcode() {
	ob_start();
	quotes_slider_template();
	$slider_quotes = ob_get_clean();
	return $slider_quotes;
}
add_shortcode( 'quotes_slider', 'quotes_slider_shortcode' );
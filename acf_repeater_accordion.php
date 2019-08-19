<?php


// Create quotes Slider
function acf_repeater_accordion_template($page_id) {
	$show_tl = get_field('show_accord', $page_id);
	$title_accord = get_field('title_accord', $page_id);
	$desc_accord = get_field('description_accord', $page_id);
	$bg_accord = get_field('bg_accord', $page_id);
	?>
<?php if($show_tl == true) : ?>
	<?php if( have_rows('accordions') ): ?>
		<div class="repeater-accordion-section" <?php echo ($bg_accord ? 'style="background-image: url('.$bg_accord.');"' : ''); ?>>
		<?php echo ($bg_accord ? '<div class="sec-over"></div>' : ''); ?>
			<div class="container">
				<div class="row">
					<?php if($title_accord || $desc_accord) : ?>
						<div class="col-sm-12">
							<?php if( $title_accord ) : ?>
								<h2 class="blocks-title"><?php echo $title_accord; ?></h2>
							<?php endif; ?>
							 <?php if( $desc_accord ) : ?>
								 <h3 class="blocks-desc"><?php echo $desc_accord; ?></h3>
							 <?php endif; ?>
						</div>
					<?php endif; ?>
					<div class="col-sm-12 accordion-block">
						<?php $index = 1; while( have_rows('accordions') ): the_row();
									$question = get_sub_field('question');
									$answer = get_sub_field('answer'); ?>
								<div class="accordion-item">
									<?php if($question) : ?>
										<a href="#answer_<?php echo $index; ?>" class="item-question btn-accordion"><?php echo $question; ?></a>
									<?php endif; ?>
									<?php if(	$answer) : ?>
										<div id="answer_<?php echo $index; ?>" class="item-answer"><?php echo $answer; ?></div>
									<?php endif; ?>
									
								</div>
						<?php $index++; endwhile; ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>
		
<?php }

// recentre Taxonomy Tabs Shortcode
function acf_repeater_accordion_shortcode() {
	$queried_object = get_queried_object();
	$page_id = $queried_object->ID;
	ob_start();
	acf_repeater_accordion_template($page_id);
	$acf_repeater_accordion = ob_get_clean();
	return $acf_repeater_accordion;
}
add_shortcode( 'acf_repeater_accordion', 'acf_repeater_accordion_shortcode' );


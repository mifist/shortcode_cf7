<?php


function all_categories_template() {
	$title_for_cat = get_field('title_cat_section', icl_object_id(72, 'settings', true));
	?>
	
	<div class="categories-section">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="section-header">
						<?php if($title_for_cat) : ?>
							<h2 class="section-title"><?php echo $title_for_cat; ?></h2>
						<?php endif; ?>
					</div>
					<ul id="all-cat">
					  <?php
					  $categories = get_categories(array(
						  'orderby' => 'name',
						  'order' => 'ASC',
						  'hide_empty' => 1,
			        'hierarchical' => true
					  )); ?>
					 <?php foreach( $categories as $category ) :
							  $add_link = get_field('add_custom_link_tabs', $category->term_id);
							  $custom_cat_link = get_field('custom_tabs_link', $category->term_id);
							  $cat_link = get_category_link( $category->term_id );
							 ?>
						 <li class="cat-item">
							 <a target="_blank" href="<?php echo $cat_link; ?>" target="_blank" title="<?php echo sprintf(	__(	"View all posts in %s" ), $category->name ); ?>">
						      <?php echo $category->name; ?>
							 </a>
						 </li>
					 <?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	
<?php }


// recentre Taxonomy Tabs Shortcode
function all_categories_shortcode() {
	ob_start();
	$queried_object = get_queried_object();
	$page_id = $queried_object->ID;
	$show_all_cat = get_field('show_all_cat', icl_object_id(72, 'settings', true));
	if($show_all_cat === true) {
		all_categories_template();
	}
	$all_categories = ob_get_clean();
	return $all_categories;
}
add_shortcode( 'all_categories', 'all_categories_shortcode' );
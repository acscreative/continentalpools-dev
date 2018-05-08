<?php
/* Template Name: Blog */

// Blog Style
$style = get_post_meta( get_the_ID(), 'minti_blogstyle', true );

if($style == 'fullwidth'){
	$templatepart = 'framework/inc/post-format/entry';
} 
elseif($style == 'medium'){
	$templatepart = 'framework/inc/post-format/medium/entry';
} 
elseif($style == 'center'){
	$templatepart = 'framework/inc/post-format/entry';
} 
elseif($style == 'masonry'){
	$templatepart = 'framework/inc/post-format/masonry/entry';
} 
else{
	$templatepart = 'framework/inc/post-format/entry';
}

// Blog Layout
$sidebar = get_post_meta( get_the_ID(), 'minti_layout', true );

if(($style == 'fullwidth' || $style == 'medium') && $sidebar == 'sidebar-right'){
	$sidebarlayout = 'sidebar-right twelve alt columns';
} 
elseif(($style == 'fullwidth' || $style == 'medium') && $sidebar == 'sidebar-left'){
	$sidebarlayout = 'sidebar-left twelve alt columns';
}
elseif($style == 'center'){
	$sidebarlayout = '';
} 
else{
	$sidebarlayout = 'sixteen columns';
}

get_header(); ?>

<div id="page-wrap" class="blog-page blog-<?php echo esc_attr($style); ?> container">

	<div id="content" class="blog-wrap <?php echo esc_attr($sidebarlayout); ?>">
	
		<?php
		global $wp_query;
		// Pagination fix to work when set as Front Page
		// $paged = get_query_var('paged') ? get_query_var('paged') : 1;
		if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } elseif ( get_query_var('page') ) { $paged = get_query_var('page'); } else { $paged = 1; }	

		// Get Categories
		$categories = rwmb_meta( 'minti_blogcategories', 'type=checkbox_list' );
		$categories = implode( ', ', $categories );	

		$args = array(
			'post_status' => 'publish',
			'orderby' => 'date',
			'order' => 'DESC',
			'category_name'	=> $categories,
			'paged' => $paged
		);
		$wp_query = new WP_Query($args);
		
		while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
			
			<?php get_template_part( $templatepart, get_post_format() ); ?>
	
		<?php endwhile; ?>

		<?php if($style != 'masonry') { get_template_part( 'framework/inc/nav' ); wp_reset_postdata(); } ?>
	
	</div>	

	<?php if($style == 'masonry') { get_template_part( 'framework/inc/nav' ); wp_reset_postdata(); } ?>

	<?php if( ($style == 'fullwidth' || $style == 'medium') && ($sidebar != 'fullwidth' && $sidebar != 'default')){ ?>
	<div id="sidebar" class="<?php echo esc_attr($sidebar); ?> alt">
		<?php get_sidebar(); ?>
	</div>
	<?php } ?>

</div>

<?php get_footer(); ?>
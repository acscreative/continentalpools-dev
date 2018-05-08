<?php 
$sidebar = $minti_data['select_bloglayout'];

if($sidebar == 'sidebar-right'){
	$sidebarlayout = 'sidebar-right twelve alt';
	$sidebarorientation = 'sidebar-right';
}
elseif($sidebar == 'sidebar-left'){
	$sidebarlayout = 'sidebar-left twelve alt';
	$sidebarorientation = 'sidebar-left';
}
else{
	$sidebarlayout = 'sixteen';
}

get_header(); ?>

<div id="page-wrap" class="blog-page blog-fullwidth container">
	
	<div id="content" class="blog-wrap <?php echo esc_attr($sidebarlayout); ?> columns">
	
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<?php get_template_part( 'framework/inc/post-format/entry', get_post_format() ); ?>
	
		<?php endwhile; endif; ?>

		<?php get_template_part( 'framework/inc/nav' ); ?>
	
	</div>

	<?php if($sidebar != 'no-sidebar'){ ?>
	<div id="sidebar" class="<?php echo esc_attr($sidebarorientation); ?> alt">
		<?php get_sidebar(); ?>
	</div>
	<?php } ?>

</div>

<?php get_footer(); ?>
<?php get_header(); ?>

<?php 
// Get bbPress Layout from Theme Options
if($minti_data['select_bbpresssidebar'] == 'sidebar-left')  {
	$bbpressclass = 'sidebar-left twelve alt columns';
}
elseif($minti_data['select_bbpresssidebar'] == 'sidebar-right')  {
	$bbpressclass = 'sidebar-right twelve alt columns';
}
else{
	$bbpressclass = 'no-sidebar sixteen columns';
}
?>

<div id="page-wrap" class="container">

	<div id="content" class="<?php echo esc_attr($bbpressclass); ?>">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
			<div class="entry">

				<?php the_content(); ?>

				<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>

			</div>

		</article>
		
		<?php if($minti_data['switch_comments'] == 1) { ?>
			<?php comments_template(); ?>
		<?php } ?>

		<?php endwhile; endif; ?>
	</div> <!-- end content -->
	
	<?php if($minti_data['select_bbpresssidebar'] != 'no-sidebar')  { ?>
	<div id="sidebar" class="<?php echo esc_attr($minti_data['select_bbpresssidebar']); ?> alt">
		<div id="sidebar-widgets" class="four columns">
		<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Forum Widgets') ); ?>
		</div>
	</div>
	<?php } ?>
	
</div> <!-- end page-wrap -->
	
<?php get_footer(); ?>
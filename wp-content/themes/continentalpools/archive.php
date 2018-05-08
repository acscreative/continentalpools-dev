<?php get_header(); ?>

<div id="page-wrap" class="blog-page blog-medium container">
	
	<div id="content" class="sidebar-right twelve alt columns">

		<?php if (is_author()) { ?>
			<div class="author-archive">

				<div id="author-info" class="clearfix">
					    <div class="author-image">
					    	<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta( 'ID' ))); ?>"><?php echo get_avatar( esc_attr(get_the_author_meta('user_email')), '80', '' ); ?></a>
					    </div>   
					    <div class="author-bio">
					       <h4><?php _e('About', 'minti'); ?> <?php the_author(); ?></h4>
					        <?php the_author_meta('description'); ?>
					    </div>
				</div>

			</div>
		<?php } ?>
	
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<?php get_template_part( 'framework/inc/post-format/medium/entry', get_post_format() ); ?>
	
		<?php endwhile; endif; ?>

		<?php get_template_part( 'framework/inc/nav' ); ?>
	
	</div>

	<div id="sidebar" class="sidebar-right alt">
		<?php get_sidebar(); ?>
	</div>

</div>

<?php get_footer(); ?>

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

<div id="page-wrap" class="blog-page blog-single container">
	
	<div id="content" class="<?php echo esc_attr($sidebarlayout); ?> columns">
	
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<?php get_template_part( 'framework/inc/post-format/entry', get_post_format() ); ?>
			
			<?php if($minti_data['switch_sharebox'] == 1) { ?>
				<?php get_template_part( 'framework/inc/sharebox' ); ?>
			<?php } ?>
			
			<?php if($minti_data['switch_authorinfo'] == 1) { ?>

				<div id="author-info" class="clearfix">
				    <div class="author-image">
				    	<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta( 'ID' ))); ?>"><?php echo get_avatar( esc_attr(get_the_author_meta('user_email')), '160', '' ); ?></a>
				    </div>   
				    <div class="author-bio">
				       <h4><?php _e('About The Author', 'minti'); ?></h4>
				        <?php the_author_meta('description'); ?>
				    </div>
				</div>

			<?php } ?>
				
			<?php if($minti_data['switch_relatedposts'] == 1) { ?>	
			
					<?php //for use in the loop, list 5 post titles related to first tag on current post
					$tags = wp_get_post_tags($post->ID);
					if($tags) {
					?>
					
					<div id="related-posts">
						<h3><?php _e('Related Posts', 'minti'); ?></h3>
						<ul>
							<?php  $first_tag = $tags[0]->term_id;
							  $args=array(
							    'tag__in' => array($first_tag),
							    'post__not_in' => array($post->ID),
							    'showposts'=>4
							   );
							  $my_query = new WP_Query($args);
							  if( $my_query->have_posts() ) {
							    while ($my_query->have_posts()) : $my_query->the_post(); ?>
							      <li><a href="<?php the_permalink() ?>" rel="bookmark" title="Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a><span><?php the_time(get_option('date_format')); ?></span></li>
							      <?php
							    endwhile;
							    wp_reset_postdata();
							  } ?>
						</ul>
					</div>
					
					<?php } // end if $tags ?>

			<?php } ?>
		
			<?php comments_template(); ?>
			
			<?php if($minti_data['switch_blogpagination'] == 1) { ?>	
				<div id="post-navigation">
					<?php previous_post_link('%link', '<div class="prev"></div>', FALSE); ?>
					<?php next_post_link('%link', '<div class="next"></div>', FALSE); ?>
				</div>
			<?php } ?>
	
		<?php endwhile; endif; ?>
	
	</div>

	<?php if($sidebar != 'no-sidebar'){ ?>
	<div id="sidebar" class="<?php echo esc_attr($sidebarorientation); ?> alt">
		<?php get_sidebar(); ?>
	</div>
	<?php } ?>

</div>

<?php dynamic_sidebar(‘footerwave’); ?>

<?php get_footer(); ?>
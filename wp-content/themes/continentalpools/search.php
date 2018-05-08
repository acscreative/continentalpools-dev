<?php get_header(); ?>

<div id="page-wrap" class="blog-page search-page container">
	
	<div id="content" class="sidebar-right twelve alt columns">

		<h3><?php _e('New Search', 'minti') ?></h3>

		<?php _e('If you are not happy with the results below please do another search', 'minti') ?>

		<?php get_search_form(); ?>

		<div class="clear"></div>
	
		<div class="divider1"></div>

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<article id="post-<?php the_ID(); ?>" <?php post_class('post entry-search clearfix'); ?>>

				<div class="entry-icon"><i class="fa fa-align-left"></i></div>
			        
			    <div class="entry-wrap">

			        <div class="entry-title">
			            <h3><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'minti'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
			        </div>

			        <div class="entry-type">
			        <?php if( get_post_type($post->ID) == 'post' ){ ?>
			        	<?php echo __('Blog Post', 'minti'); ?>
			        <?php } elseif( get_post_type($post->ID) == 'page' ){ ?>
			        	<?php echo __('Page', 'minti'); ?>
			        <?php } elseif( get_post_type($post->ID) == 'portfolio' ){ ?>
			        	<?php echo __('Portfolio Item', 'minti'); ?>
			        <?php } elseif( get_post_type($post->ID) == 'product' ){ ?>
			        	<?php echo __('Product', 'minti'); ?>
			        <?php } ?>
			        </div>

		        	<?php if (minti_custom_excerpt(100) != '') { ?>
					<div class="entry-content"><?php echo wp_kses_post(minti_custom_excerpt(100)); ?></div>
		        	<?php } ?>

			    </div>

			</article><!-- #post -->
			
		<?php endwhile; ?>
		
		<?php get_template_part( 'framework/inc/nav' ); ?>
	
		<?php else : ?>
	
			<div class="alert-message"><?php _e('No results found', 'minti') ?></div>
	
		<?php endif; ?>
	
	</div>

	<div id="sidebar" class="sidebar-right alt">
		<?php get_sidebar(); ?>
	</div>

</div>

<?php get_footer(); ?>

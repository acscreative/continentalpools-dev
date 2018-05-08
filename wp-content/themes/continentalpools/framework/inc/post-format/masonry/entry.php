<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
    
    <?php if ( has_post_thumbnail() ) { ?>
    <div class="entry-image">
        <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'minti'), the_title_attribute('echo=0') ); ?>" rel="bookmark">
            <?php the_post_thumbnail(); ?>
        </a>
    </div>
    <?php } ?>
    
    <div class="entry-wrap">

        <div class="entry-title">
        	<h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'minti'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
        </div>

        <div class="entry-content">
        	<?php echo wp_kses_post(minti_custom_excerpt(20)); ?>
        </div>

        <div class="entry-meta">
            <?php get_template_part( 'framework/inc/meta' ); ?>
        </div>

    </div>

</article><!-- #post -->
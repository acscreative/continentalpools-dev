<div class="post-time">
	<span class="month"><?php the_time('M'); ?></span>
	<span class="day"><?php the_time('d'); ?></span>
</div>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
    
    <div class="entry-link">
        <a href="<?php echo esc_url(get_post_meta( get_the_ID(), 'minti_blog-link', true )) ?>" title="<?php printf( esc_attr__('Link to %s', 'minti'), the_title_attribute('echo=0') ); ?>" target="_blank"><?php the_title(); ?><span><?php echo esc_html(get_post_meta( get_the_ID(), 'minti_blog-link', true )) ?></span></a>
    </div>

    <?php if(is_single()){ ?>
    <div class="entry-meta">
        <?php get_template_part( 'framework/inc/meta' ); ?>
    </div>

    <div class="entry-content">
		<?php the_content(); ?>
    </div>
    <?php } ?>

</article><!-- #post -->
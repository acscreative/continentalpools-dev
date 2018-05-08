<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

    <div class="entry-link">
        <a href="<?php echo esc_url(get_post_meta( get_the_ID(), 'minti_blog-link', true )) ?>" title="<?php printf( esc_attr__('Link to %s', 'minti'), the_title_attribute('echo=0') ); ?>" target="_blank"><?php the_title(); ?><span><?php echo esc_html(get_post_meta( get_the_ID(), 'minti_blog-link', true )) ?></span></a>
    </div>

</article><!-- #post -->
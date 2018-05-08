<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
	
	<div class="entry-quote">
	<?php if (get_post_meta( get_the_ID(), 'minti_blog-quote', true ) != '') {   ?>
		<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'minti'), the_title_attribute('echo=0') ); ?>" class="quote-text"><?php echo esc_html(get_post_meta( get_the_ID(), 'minti_blog-quote', true )); ?>
		<span class="quote-source"><?php echo esc_html(get_post_meta( get_the_ID(), 'minti_blog-quotesource', true )); ?></span></a>
    <?php } else { echo 'Please insert a Quote'; } ?>
    </div>

</article><!-- #post -->
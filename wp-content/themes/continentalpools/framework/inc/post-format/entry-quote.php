<div class="post-time">
	<span class="month"><?php the_time('M'); ?></span>
	<span class="day"><?php the_time('d'); ?></span>
</div>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
	
	<div class="entry-quote">
	<?php if (get_post_meta( get_the_ID(), 'minti_blog-quote', true ) != '') {   ?>
		<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'minti'), the_title_attribute('echo=0') ); ?>" class="quote-text"><?php echo esc_html(get_post_meta( get_the_ID(), 'minti_blog-quote', true )); ?>
		<span class="quote-source"><?php echo esc_html(get_post_meta( get_the_ID(), 'minti_blog-quotesource', true )); ?></span></a>
    <?php } else { echo 'Please insert a Quote'; } ?>
    </div>
	
	<?php if(is_single()){ ?>
    <div class="entry-title">
        <h1><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'minti'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
    </div>
    
    <div class="entry-meta">
        <?php get_template_part( 'framework/inc/meta' ); ?>
    </div>

    <div class="entry-content">
		<?php the_content(); ?>
    </div>
    <?php } ?>

</article><!-- #post -->
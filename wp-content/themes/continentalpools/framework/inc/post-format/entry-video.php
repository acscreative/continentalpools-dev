<div class="post-time">
	<span class="month"><?php the_time('M'); ?></span>
	<span class="day"><?php the_time('d'); ?></span>
</div>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

	<?php if (get_post_meta( get_the_ID(), 'minti_blog-video', true ) != '') {  ?>
    <div class="entry-video">
	   <?php   
            if (get_post_meta( get_the_ID(), 'minti_blog-videosource', true ) == 'videourl') {  
                $embed_code = wp_oembed_get(esc_url(get_post_meta( get_the_ID(), 'minti_blog-video', true )));
                echo $embed_code; // No need to escape here
            }  
            else {  
                echo wp_kses(get_post_meta( get_the_ID(), 'minti_blog-video', true ), minti_expand_allowed_tags()); 
            }  
        ?>
    </div>
    <?php } ?>
    
    <div class="entry-title">
        <?php if(!is_single()){ ?>
            <h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'minti'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
        <?php } else { ?>
            <h1><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'minti'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
        <?php } ?>
    </div>

    <?php if(is_single()){ ?>
    <div class="entry-meta">
        <?php get_template_part( 'framework/inc/meta' ); ?>
    </div>
    <?php } ?>

    <div class="entry-content">
    	<?php if(!is_single()){ ?>
    		<?php echo wp_kses_post(minti_custom_excerpt(50)); ?>
    	<?php } else { ?>
			<?php the_content(); ?>
    	<?php } ?>
    </div>

    <?php if(!is_single()){ ?>
    <div class="entry-meta">
        <?php get_template_part( 'framework/inc/meta' ); ?>
    </div>
    <?php } ?>

</article><!-- #post -->
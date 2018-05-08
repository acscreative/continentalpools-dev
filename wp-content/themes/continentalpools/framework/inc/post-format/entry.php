<div class="post-time">
    <span class="month"><?php the_time('M'); ?></span>
    <span class="day"><?php the_time('d'); ?></span>
</div>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
    
    <?php if (!is_single() || (is_single() && get_post_meta( get_the_ID(), 'minti_hideimage', true ) == false)) { ?>
        <?php if ( has_post_thumbnail() ) { ?>
        <div class="entry-image">
            <?php if(is_single()){ ?>
                <?php $thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id(),'full', true); ?>
                <a href="<?php echo esc_url($thumb_url[0]); ?>" title="<?php the_title(); ?>" class="prettyPhoto" rel="bookmark">
                    <?php the_post_thumbnail('blog'); ?>
                </a>
            <?php } else { ?>
                <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'minti'), the_title_attribute('echo=0') ); ?>" rel="bookmark">
                    <?php the_post_thumbnail('blog'); ?>
                </a>
            <?php } ?>
        </div>
        <?php } ?>
    <?php } ?>
    
    <div class="entry-wrap">

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

    </div>

</article><!-- #post -->
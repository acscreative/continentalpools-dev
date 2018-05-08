<?php get_header(); ?>

<?php // If Layout Type = Custom Page
if ( get_post_meta( get_the_ID(), 'minti_portfolio-detaillayout', true ) == "custom" ) {
	
	get_template_part( 'framework/inc/portfolio/custom' );

} else { ?> 
	
<div id="page-wrap" class="container portfolio-detail">
	
	<div id="content">
	
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<?php 
		if ( get_post_meta( get_the_ID(), 'minti_portfolio-detaillayout', true ) == "wide" ) {
			get_template_part( 'framework/inc/portfolio/wide' );
		} 
		elseif ( get_post_meta( get_the_ID(), 'minti_portfolio-detaillayout', true ) == "wide-ns" ) {
			get_template_part( 'framework/inc/portfolio/wide-noslider' );
		}
		elseif ( get_post_meta( get_the_ID(), 'minti_portfolio-detaillayout', true ) == "sidebyside" ) {
			get_template_part( 'framework/inc/portfolio/sidebyside' );
		} 
		elseif ( get_post_meta( get_the_ID(), 'minti_portfolio-detaillayout', true ) == "sidebyside-ns" ) {
			get_template_part( 'framework/inc/portfolio/sidebyside-noslider' );
		}
		else {
			get_template_part( 'framework/inc/portfolio/wide' );
		}
		?>

		<div class="clear"></div>
		
		<?php if( get_post_meta( get_the_ID(), 'minti_portfolio-relatedposts', true ) == 1 ) { // Show related Posts Projects specific ?>

			<div id="portfolio-related-post" class="portfolio-default portfolio-overlay-icon clearfix">

				<div class="sixteen columns">
					<h3><?php _e('Related Projects', 'minti'); ?></h3>
				</div>
				
				<?php
				$terms = get_the_terms( $post->ID , 'portfolio_filter', 'string');
				$term_ids = array_values( wp_list_pluck( $terms,'term_id' ) );
				$second_query = new WP_Query( array(
					'post_type' => 'portfolio',
					'tax_query' => array(
						array(
							'taxonomy' => 'portfolio_filter',
							'field' => 'id',
							'terms' => $term_ids,
							'operator'=> 'IN' //Or 'AND' or 'NOT IN'
						)),
					'posts_per_page' => 3,
					'ignore_sticky_posts' => 1,
					'orderby' => 'date',  // 'rand' for random order
					'post__not_in'=>array($post->ID)
			   ) );
				
				//Loop through posts and display...
				if($second_query->have_posts()) {
					while ($second_query->have_posts() ) : $second_query->the_post(); ?>
					
						<?php // LIGHTBOX
						if(get_post_meta( get_the_ID(), "minti_portfolio-lightbox", true ) == '1') {
							$portfoliolink = '<a href="'. esc_url(wp_get_attachment_url( get_post_thumbnail_id() )) .'" class="prettyPhoto" rel="prettyPhoto[portfolio]" title="'.esc_attr(get_the_title()).'">';
							$lightboxicon = 'icon-minti-search';
						} else {
							$portfoliolink = '<a href="'.esc_url(get_permalink()).'" title="'.esc_attr(get_the_title()).'">';
							$lightboxicon = 'icon-minti-plus';
						} ?>

						<?php // OVERLAY
							$overlay_output = '<div class="portfolio-overlay overlay-icon"></div><i class="'.esc_attr($lightboxicon).'"></i>';
						?>

						<?php // GET FEATURED IMAGE 
						if ( has_post_thumbnail()) { $portfolio_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'portfolio' ); } ?>

						<div class="portfolio-item one-third column">
							<div class="portfolio-image"><?php echo $portfoliolink; ?><div class="portfolio-image-img"><img src="<?php echo esc_url($portfolio_thumbnail[0]); ?>" /></div><?php echo $overlay_output; ?></a></div>
							<h4><a href="<?php the_permalink(); ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h4>
							<span class="portfolio-subtitle"><?php echo esc_html(get_post_meta( get_the_ID(), "minti_subtitle", true )); ?></span>
						</div>

					   <?php endwhile; wp_reset_postdata(); ?>
				<?php } //end if have_posts() ?>
				
			</div> <!-- end of portfolio-related-posts -->
		
		<?php } //end related specific ?>
		
		<?php if($minti_data['switch_comments'] == 1) { ?>
			<?php if(comments_open()) { ?>
			<div class="sixteen columns portfolio-comments"><?php comments_template(); ?></div>
			<?php } ?>
		<?php } ?>
		
		<?php if($minti_data['switch_portfoliopagination'] == 1) { ?>	
			<div id="post-navigation">
				<?php previous_post_link('%link', '<div class="prev"></div>', FALSE); ?>
				<?php next_post_link('%link', '<div class="next"></div>', FALSE); ?>
			</div>
		<?php } ?>
	
		<?php endwhile; endif; ?>
	
	</div> <!-- end of content -->
	
</div> <!-- end of page-wrap -->

<?php } ?>

<?php get_footer(); ?>
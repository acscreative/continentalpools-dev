<?php global $minti_data; ?>

<?php if( is_object($post) && !is_archive() &&!is_search() && !is_404() && ! is_author() && !is_home()  ) { ?>

<?php if(rwmb_meta('minti_titlebar') != 'default' && rwmb_meta('minti_titlebar') != ''){ ?>

		<?php if (rwmb_meta('minti_titlebar') == 'title') { ?>

			<div id="fulltitle" class="titlebar">
				<div class="container">
					<div id="title" class="ten columns">
						<?php if(!is_single()){?><h1><?php the_title(); ?></h1><?php } else { ?> <div class="title-h1"><?php the_title(); ?></div> <?php } ?>
					</div>
					<div id="breadcrumbs" class="six columns">
						<?php if($minti_data['titlebar_breadcrumbs'] == 1) { minti_breadcrumbs(); } ?>
					</div>
				</div>
			</div>

		<?php /* ---------------------------------------------------------------------------------------*/ ?>
			
		<?php } elseif (rwmb_meta('minti_titlebar') == 'featuredimagecenter') { ?>

			<div id="fullimagecenter" class="titlebar" style="background-image: url( <?php $images = rwmb_meta( 'minti_headerimage', 'type=image_advanced&size=standard' ); foreach ( $images as $image ) { echo esc_url($image['url']); } ?> );">
				<div class="container">
					<div class="sixteen columns">
						<?php if(!is_single()){?><h1><?php the_title(); ?></h1><?php } else { ?> <div class="title-h1"><?php the_title(); ?></div> <?php } ?>
					</div>
				</div>
			</div>

		<?php /* ---------------------------------------------------------------------------------------*/ ?>
			
		<?php } elseif (rwmb_meta('minti_titlebar') == 'transparentimage') { ?>
			
			<div id="transparentimage" class="titlebar" style="background-image: url( <?php $images = rwmb_meta( 'minti_headerimage', 'type=image_advanced&size=standard' ); foreach ( $images as $image ) { echo esc_url($image['url']); } ?> );">
				<div class="container">
					<div class="sixteen columns">
						<?php if(!is_single()){?><h1><?php the_title(); ?></h1><?php } else { ?> <div class="title-h1"><?php the_title(); ?></div> <?php } ?>
					</div>
				</div>
			</div>
			
		<?php /* ---------------------------------------------------------------------------------------*/ ?>
			
		<?php } elseif (rwmb_meta('minti_titlebar') == 'notitle') { ?>

			<div id="notitlebar"></div>

		<?php } ?>

<?php } else { ?>
		
		<?php
			// Define the Title for different Pages
			if ( is_home() ) { $title = 'Blog'; }
			elseif( is_search() ) { 	
				$allsearch = new WP_Query("s=$s&showposts=-1"); 
				$count = $allsearch->post_count; 
				wp_reset_postdata();
				$title = $count . ' '; 
				$title .= __('Search results for:', 'minti');
				$title .= ' ' . get_search_query();
			}
			elseif( class_exists('Woocommerce') && is_woocommerce() ) { $title = $minti_data['text_titlebar_woocommerce']; }
			elseif( is_archive() ) { 
				if (is_category()) { 	$title = single_cat_title('',false); }
				elseif( is_tag() ) { 	$title = __('Posts Tagged:', 'minti') . ' ' . single_tag_title('',false); }
				elseif (is_day()) { 	$title = __('Archive for', 'minti') . ' ' . get_the_time('F jS, Y'); }
				elseif (is_month()) { 	$title = __('Archive for', 'minti') . ' ' . get_the_time('F Y'); }
				elseif (is_year()) { 	$title = __('Archive for', 'minti') . ' ' . get_the_time('Y'); }
				elseif (is_author()) { 	$title = __('Author Archive for', 'minti') . ' ' . get_the_author(); }
				elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { $title = __('Blog Archives', 'minti'); }
				else{
					$title = single_term_title( "", false );
					if ( $title == '' ) { // Fix for templates that are archives
						$post_id = $post->ID;
						$title = get_the_title($post_id);
					} 
				}
			}
			elseif( is_404() ) { $title = __('Oops, this Page could not be found.', 'minti'); }
			elseif( get_post_type() == 'post' ) { $title = $minti_data['text_titlebar_blog']; }
			else { $title = get_the_title(); }
		?>
	
		<?php if($minti_data['titlebar_layout'] == 'title') { ?>
			<div id="fulltitle" class="titlebar">
				<div class="container">
					<div  id="title" class="ten columns">
						<?php if(!is_single()){?><h1><?php echo esc_html($title); ?></h1><?php } else { ?> <div class="title-h1"><?php echo esc_html($title); ?></div> <?php } ?>
					</div>
					<div id="breadcrumbs" class="six columns">
						<?php if($minti_data['titlebar_breadcrumbs'] == 1) { minti_breadcrumbs(); } ?>
					</div>
				</div>
			</div>
		<?php } elseif($minti_data['titlebar_layout'] == 'featuredimagecenter') { ?>
			<div id="fullimagecenter" class="titlebar" style="background-image: url( <?php echo esc_url($minti_data['titlebar_image']['url']); ?> );">
				<div id="fullimagecentertitle">
					<div class="container">
						<div class="sixteen columns">
							<?php if(!is_single()){?><h1><?php echo esc_html($title); ?></h1><?php } else { ?> <div class="title-h1"><?php echo esc_html($title); ?></div> <?php } ?>
						</div>
					</div>
				</div>
			</div>
		<?php } elseif($minti_data['titlebar_layout'] == 'transparentimage') { ?>
			<div id="transparentimage" class="titlebar" style="background-image: url( <?php echo esc_url($minti_data['titlebar_image']['url']); ?> );">
				<div class="titlebar-overlay"></div>
				<div class="container">
					<div class="sixteen columns">
						<?php if(!is_single()){?><h1><?php echo esc_html($title); ?></h1><?php } else { ?> <div class="title-h1"><?php echo esc_html($title); ?></div> <?php } ?>
					</div>
				</div>
			</div>
		<?php } elseif($minti_data['titlebar_layout'] == 'notitle') { ?>
			<div id="notitlebar"></div>
		<?php } ?>

<?php } // End Else ?>

<?php } else { // If no post page ?>

<?php
			// Define the Title for different Pages
			if ( is_home() ) { $title = 'Blog'; }
			elseif( is_search() ) { 	
				$allsearch = new WP_Query("s=$s&showposts=-1"); 
				$count = $allsearch->post_count; 
				wp_reset_postdata();
				$title = $count . ' '; 
				$title .= __('Search results for:', 'minti');
				$title .= ' ' . get_search_query();
			}
			elseif( class_exists('Woocommerce') && is_woocommerce() ) { $title = $minti_data['text_titlebar_woocommerce']; }
			elseif( is_archive() ) { 
				if (is_category()) { 	$title = single_cat_title('',false); }
				elseif( is_tag() ) { 	$title = __('Posts Tagged:', 'minti') . ' ' . single_tag_title('',false); }
				elseif (is_day()) { 	$title = __('Archive for', 'minti') . ' ' . get_the_time('F jS, Y'); }
				elseif (is_month()) { 	$title = __('Archive for', 'minti') . ' ' . get_the_time('F Y'); }
				elseif (is_year()) { 	$title = __('Archive for', 'minti') . ' ' . get_the_time('Y'); }
				elseif (is_author()) { 	$title = __('Author Archive for', 'minti') . ' ' . get_the_author(); }
				elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { $title = __('Blog Archives', 'minti'); }
				else{
					$title = single_term_title( "", false );
					if ( $title == '' ) { // Fix for templates that are archives
						$post_id = $post->ID;
						$title = get_the_title($post_id);
					} 
				}
			}
			elseif( is_404() ) { $title = __('Oops, this Page could not be found.', 'minti'); }
			elseif( get_post_type() == 'post' ) { $title = $minti_data['text_titlebar_blog']; }
			else { $title = get_the_title(); }
		?>
	
		<?php if($minti_data['titlebar_layout'] == 'title') { ?>
			<div id="fulltitle" class="titlebar">
				<div class="container">
					<div  id="title" class="ten columns">
						<?php if(!is_single()){?><h1><?php echo esc_html($title); ?></h1><?php } else { ?> <div class="title-h1"><?php echo esc_html($title); ?></div> <?php } ?>
					</div>
					<div id="breadcrumbs" class="six columns">
						<?php if($minti_data['titlebar_breadcrumbs'] == 1) { minti_breadcrumbs(); } ?>
					</div>
				</div>
			</div>
		<?php } elseif($minti_data['titlebar_layout'] == 'featuredimagecenter') { ?>
			<div id="fullimagecenter" class="titlebar" style="background-image: url( <?php echo esc_url($minti_data['titlebar_image']['url']); ?> );">
				<div id="fullimagecentertitle">
					<div class="container">
						<div class="sixteen columns">
							<?php if(!is_single()){?><h1><?php echo esc_html($title); ?></h1><?php } else { ?> <div class="title-h1"><?php echo esc_html($title); ?></div> <?php } ?>
						</div>
					</div>
				</div>
			</div>
		<?php } elseif($minti_data['titlebar_layout'] == 'transparentimage') { ?>
			<div id="transparentimage" class="titlebar" style="background-image: url( <?php echo esc_url($minti_data['titlebar_image']['url']); ?> );">
				<div class="titlebar-overlay"></div>
				<div class="container">
					<div class="sixteen columns">
						<?php if(!is_single()){?><h1><?php echo esc_html($title); ?></h1><?php } else { ?> <div class="title-h1"><?php echo esc_html($title); ?></div> <?php } ?>
					</div>
				</div>
			</div>
		<?php } elseif($minti_data['titlebar_layout'] == 'notitle') { ?>
			<div id="notitlebar"></div>
		<?php } ?>

<?php } // End Else ?>
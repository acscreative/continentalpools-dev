<?php global $minti_data; ?>
<div id="topbar" class="header-v2 clearfix">
	<div class="container">

		<div class="sixteen columns">

			<div class="topbar-col1">
				<?php if($minti_data['select_topbarleft'] == 'Text Field') { ?>
					<?php echo wp_kses_post($minti_data['textarea_topbar']); ?>
				<?php } elseif($minti_data['select_topbarleft'] == 'Navigation') { ?>
					<?php if(has_nav_menu('topbar_navigation')) {
					    wp_nav_menu( array( 'theme_location' => 'topbar_navigation' ) ); 
					} ?>
				<?php } elseif($minti_data['select_topbarleft'] == 'Social Media') { ?>
					<?php get_template_part( 'framework/inc/socialmedia' ); ?>
				<?php } elseif($minti_data['select_topbarleft'] == 'Leave Empty') { } ?>
			</div>

			<div class="topbar-col2">
				<?php if($minti_data['select_topbarright'] == 'Text Field') { ?>
					<?php echo wp_kses_post($minti_data['textarea_topbar']); ?>
				<?php } elseif($minti_data['select_topbarright'] == 'Navigation') { ?>
					<?php if(has_nav_menu('topbar_navigation')) {
					    wp_nav_menu( array( 'theme_location' => 'topbar_navigation' ) ); 
					} ?>
				<?php } elseif($minti_data['select_topbarright'] == 'Social Media') { ?>
					<?php get_template_part( 'framework/inc/socialmedia' ); ?>
				<?php } elseif($minti_data['select_topbarright'] == 'Leave Empty') { } ?>
			</div>
			
		</div>
		
	</div>
</div>

<header id="header" class="header header-v1 clearfix">
		
	<div class="container">
	
		<div id="logo-navigation" class="sixteen columns">
			
			<div id="logo" class="logo">
				<?php if($minti_data['media_logo']['url'] != "") { ?>
					<a href="<?php echo esc_url(home_url()); ?>/"><img src="<?php echo esc_url($minti_data['media_logo']['url']); ?>" alt="<?php esc_html(bloginfo('name')); ?>" class="logo_standard" /></a>
					<?php if($minti_data['media_logo_transparent']['url'] != '') { ?><a href="<?php echo esc_url(home_url()); ?>/"><img src="<?php echo esc_url($minti_data['media_logo_transparent']['url']); ?>" alt="<?php esc_html(bloginfo('name')); ?>" class="logo_transparent" /></a><?php } ?>
					<?php if($minti_data['media_logo_retina']['url'] != '') { ?><a href="<?php echo esc_url(home_url()); ?>/"><img src="<?php echo esc_url($minti_data['media_logo_retina']['url']); ?>" width="<?php echo esc_attr($minti_data['media_logo']['width']); ?>" height="<?php echo esc_attr($minti_data['media_logo']['height']); ?>" alt="<?php esc_html(bloginfo('name')); ?>" class="logo_retina" /></a><?php } ?>
					<?php if($minti_data['media_logo_retina_transparent']['url'] != '') { ?><a href="<?php echo esc_url(home_url()); ?>/"><img src="<?php echo esc_url($minti_data['media_logo_retina_transparent']['url']); ?>" width="<?php echo esc_attr($minti_data['media_logo_transparent']['width']); ?>" height="<?php echo esc_attr($minti_data['media_logo_transparent']['height']); ?>" alt="<?php esc_html(bloginfo('name')); ?>" class="logo_retina_transparent" /></a><?php } ?>
				<?php } else { ?>
					<a href="<?php echo esc_url(home_url()); ?>/"><?php esc_html(bloginfo('name')); ?></a>
				<?php } ?>
			</div>

			<div id="navigation" class="clearfix">			
				<div class="header-icons">
				<?php if($minti_data['switch_searchform'] != 0 || $minti_data['switch_shoppingicon'] != 0) { ?>
					<div class="header-icons-divider"></div>
				<?php } ?>
				<?php if($minti_data['switch_searchform'] == 1) { ?>
					<a href="#" id="search-btn"><i class="icon-minti-search"></i></a>
				<?php } ?>
				
				<?php if (class_exists('Woocommerce')) { ?>
					<?php if($minti_data['switch_shoppingicon'] == 1) { ?>
					<?php global $woocommerce; ?>
					<span class="cart-popup">
					<a href="<?php echo esc_url($woocommerce->cart->get_cart_url()); ?>" id="shopping-btn" class="cart-contents"><i class="icon-minti-cart"></i><?php if ( sizeof( $woocommerce->cart->cart_contents ) != 0 ) { ?><span><?php echo esc_html($woocommerce->cart->cart_contents_count); ?></span><?php } ?></a>
					</span>
					<?php } ?>
				<?php } ?>
				</div>	

				<?php 
					if(has_nav_menu('main_navigation')) {
						wp_nav_menu( array(
							 'theme_location' => 'main_navigation',
							 'container' =>false,
							 'menu_id' => 'nav',
							 'echo' => true,
							 'menu_class' => 'menu',
							 'before' => '',
							 'after' => '',
							 'link_before' => '',
							 'link_after' => '',
							 'depth' => 0
							)
						); 
					}
					else {
						echo '<ul><li><a href=""><strong>NO MENU ASSIGNED</strong> <span>Go To Appearance > Menus and create a Menu</span></a></li></ul>';
					}
				?>
			</div>
			
		</div>
		
		<?php if($minti_data['switch_searchform'] == 1) { ?>
		<div id="search-top" class="sixteen columns clearfix">
			<form action="<?php echo esc_url(home_url()) ?>" method="GET">
	      		<input type="text" name="s" value="" placeholder="<?php echo __('To Search start typing...', 'minti') ?>" autocomplete="off" />
			</form>
			<a href="#" id="close-search-btn"><i class="icon-minti-close"></i></a>
		</div>
		<?php } ?>

		<?php if (class_exists('Woocommerce')) { ?>
		<?php global $woocommerce; ?>
		<?php if ( sizeof( $woocommerce->cart->cart_contents ) != 0 ) { ?>
			<?php if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) { the_widget( 'WC_Widget_Cart', 'title= ' ); } ?>
		<?php } ?>	
	<?php } ?>	

	</div>	
	
</header>

<div id="mobile-header" class="mobile-header-v1">
	<div class="container">
		<div class="sixteen columns">
			<div id="mobile-logo" class="logo">
				<?php if($minti_data['media_logo']['url'] != "") { ?>
					<a href="<?php echo esc_url(home_url()); ?>/"><img src="<?php echo esc_url($minti_data['media_logo']['url']); ?>" alt="<?php esc_html(bloginfo('name')); ?>" class="logo_standard" /></a>
					<?php if($minti_data['media_logo_retina']['url'] != '') { ?><a href="<?php echo esc_url(home_url()); ?>/"><img src="<?php echo esc_url($minti_data['media_logo_retina']['url']); ?>" width="<?php echo esc_attr($minti_data['media_logo']['width']); ?>" height="<?php echo esc_attr($minti_data['media_logo']['height']); ?>" alt="<?php esc_html(bloginfo('name')); ?>" class="logo_retina" /></a><?php } ?>
				<?php } else { ?>
					<a href="<?php echo esc_url(home_url()); ?>/"><?php esc_html(bloginfo('name')); ?></a>
				<?php } ?>
			</div>
			<a href="#" id="mobile-navigation-btn"><i class="fa fa-bars"></i></a>
			<?php if (class_exists('Woocommerce')) { ?>
				<?php if($minti_data['switch_shoppingicon'] == 1) { ?>
					<?php global $woocommerce; ?>
					<a href="<?php echo esc_url($woocommerce->cart->get_cart_url()); ?>" id="mobile-shopping-btn" ><i class="icon-minti-cart"></i></a>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</div>

<div id="mobile-navigation">
	<div class="container">
		<div class="sixteen columns">
			<?php wp_nav_menu(array('theme_location' => 'main_navigation', 'menu_id' => 'mobile-nav')); ?>
			
			<?php if($minti_data['switch_searchformmobile'] == 1) { ?>
			<form action="<?php echo esc_url(home_url()) ?>" method="GET">
	      		<input type="text" name="s" value="" placeholder="<?php echo __('Search..', 'minti') ?>"  autocomplete="off" />
			</form> 
			<?php } ?>	
		</div>
	</div>
</div>
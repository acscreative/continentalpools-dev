<?php global $minti_data; ?>
<header id="header" class="header header-v3 clearfix">
		
	<div class="container">
		<div class="sixteen columns">

			<div id="logo" class="logo">
				<?php if($minti_data['media_logo']['url'] != "") { ?>
					<a href="<?php echo esc_url(home_url()); ?>/"><img src="<?php echo esc_url($minti_data['media_logo']['url']); ?>" alt="<?php esc_attr(bloginfo('name')); ?>" class="logo_standard" /></a>
					<?php if($minti_data['media_logo_retina']['url'] != '') { ?><a href="<?php echo esc_url(home_url()); ?>/"><img src="<?php echo esc_url($minti_data['media_logo_retina']['url']); ?>" width="<?php echo esc_attr($minti_data['media_logo']['width']); ?>" height="<?php echo esc_attr($minti_data['media_logo']['height']); ?>" alt="<?php esc_attr(bloginfo('name')); ?>" class="logo_retina" /></a><?php } ?>
				<?php } else { ?>
					<a href="<?php echo esc_url(home_url()); ?>/"><?php esc_html(bloginfo('name')); ?></a>
				<?php } ?>
			</div>

			<div id="slogan" class="clearfix">
				<?php echo wp_kses_post($minti_data['textarea_slogan']); ?>
			</div>

		</div>
	</div>
	
	<div class="navigation-wrap">
		<div class="container">
			<div class="sixteen columns">
				
				<div id="navigation" class="clearfix">
					<?php if(has_nav_menu('main_navigation')) {
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
					} ?>
				</div>

				<?php if (class_exists('Woocommerce')) { ?>
					<?php if($minti_data['switch_shoppingicon'] == 1) { ?>
					<?php global $woocommerce; ?>
					<a href="<?php echo esc_url($woocommerce->cart->get_cart_url()); ?>" id="shopping-btn" class="cart-contents"><i class="icon-minti-cart"></i><?php if ( sizeof( $woocommerce->cart->cart_contents ) != 0 ) { ?><span><?php echo esc_html($woocommerce->cart->cart_contents_count); ?></span><?php } ?></a>
					<?php } ?>
				<?php } ?>

			</div>
		</div>
	</div>	
	
</header>

<div id="mobile-header">
	<div class="container">
		<div class="sixteen columns">
			<div id="mobile-logo" class="logo">
				<?php if($minti_data['media_logo']['url'] != "") { ?>
					<a href="<?php echo esc_url(home_url()); ?>/"><img src="<?php echo esc_url($minti_data['media_logo']['url']); ?>" alt="<?php esc_attr(bloginfo('name')); ?>" class="logo_standard" /></a>
					<?php if($minti_data['media_logo_retina']['url'] != '') { ?><a href="<?php echo esc_url(home_url()); ?>/"><img src="<?php echo esc_url($minti_data['media_logo_retina']['url']); ?>" width="<?php echo esc_attr($minti_data['media_logo']['width']); ?>" height="<?php echo esc_attr($minti_data['media_logo']['height']); ?>" alt="<?php esc_attr(bloginfo('name')); ?>" class="logo_retina" /></a><?php } ?>
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
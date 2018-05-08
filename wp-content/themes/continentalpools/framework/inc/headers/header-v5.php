<?php global $minti_data; ?>

<?php
// Add transparent header class
$transparentClass = NULL;
if (!is_search() && !is_404() && !is_archive() && !is_author() && !is_home()) {
	if ( (get_post_meta( get_the_ID(), 'minti_titlebar', true ) == 'transparent' || get_post_meta( get_the_ID(), 'minti_titlebar', true ) == 'transparentimage') || (get_post_meta( get_the_ID(), 'minti_titlebar', true ) == 'default' && $minti_data['titlebar_layout'] == 'transparentimage')  ){
		$transparentClass = 'header-transparent';
	}
}
if (is_search() || is_404() || is_archive() || is_home()) {
	if ($minti_data['titlebar_layout'] == 'transparentimage'){
		$transparentClass = 'header-transparent';
	}
}
if(function_exists('is_woocommerce') && is_woocommerce()){
	if ($minti_data['titlebar_layout'] == 'transparentimage'){
		$transparentClass = 'header-transparent';
	}
}
if(function_exists('is_bbpress') && is_bbpress()){
	if ($minti_data['titlebar_layout'] == 'transparentimage'){
		$transparentClass = 'header-transparent';
	}
}

// Add dark header class if selected
if((rwmb_meta('minti_titlebar') != 'default' && rwmb_meta('minti_titlebar') != '') && !is_search() && !is_404() && !is_archive() && ! is_author() && !is_home() ){
	if( rwmb_meta('minti_headercolor') == 'dark' ){
		$headerClass = 'darkheader';
	} else {
		$headerClass = '';
	}
} else {
	if ($minti_data['titlebar_color'] == 'dark'){
		$headerClass =  'darkheader';
	} else {
		$headerClass =  '';
	}
}
?>
<header id="header" class="header header-v1 header-v1-only clearfix <?php echo esc_attr($transparentClass); ?> <?php echo esc_attr($headerClass); ?>">
		
	<div class="header-wide-container">
	
		<div id="logo-navigation" class="sixteen columns">
			
			<div id="logo" class="logo">
				<?php if(isset($minti_data['media_logo']['url']) && ($minti_data['media_logo']['url'] != "")) { ?>
					<a href="<?php echo esc_url(home_url()); ?>/"><img src="<?php echo esc_url($minti_data['media_logo']['url']); ?>" alt="<?php esc_attr(bloginfo('name')); ?>" class="logo_standard" /></a>
					<?php if($minti_data['media_logo_transparent']['url'] != '') { ?><a href="<?php echo esc_url(home_url()); ?>/"><img src="<?php echo esc_url($minti_data['media_logo_transparent']['url']); ?>" alt="<?php esc_attr(esc_attr(bloginfo('name'))); ?>" class="logo_transparent" /></a><?php } ?>
					<?php if($minti_data['media_logo_retina']['url'] != '') { ?><a href="<?php echo esc_url(home_url()); ?>/"><img src="<?php echo esc_url($minti_data['media_logo_retina']['url']); ?>" width="<?php echo esc_attr($minti_data['media_logo']['width']); ?>" height="<?php echo esc_attr($minti_data['media_logo']['height']); ?>" alt="<?php esc_attr(bloginfo('name')); ?>" class="logo_retina" /></a><?php } ?>
					<?php if($minti_data['media_logo_retina_transparent']['url'] != '') { ?><a href="<?php echo esc_url(home_url()); ?>/"><img src="<?php echo esc_url($minti_data['media_logo_retina_transparent']['url']); ?>" width="<?php echo esc_attr($minti_data['media_logo_transparent']['width']); ?>" height="<?php echo esc_attr($minti_data['media_logo_transparent']['height']); ?>" alt="<?php esc_attr(bloginfo('name')); ?>" class="logo_retina_transparent" /></a><?php } ?>
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
					<a href="<?php echo esc_url($woocommerce->cart->get_cart_url()); ?>" id="shopping-btn" class="cart-contents"><i class="icon-minti-cart"></i><?php if ( sizeof( $woocommerce->cart->cart_contents ) != 0 ) { ?><span><?php echo esc_html($woocommerce->cart->cart_contents_count); ?></span><?php } ?></a>
					<?php } ?>
				<?php } ?>
				</div>	
				
				<?php dynamic_sidebar(‘topnav’); ?>

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
				<?php if(isset($minti_data['media_logo']['url']) && ($minti_data['media_logo']['url'] != "")) { ?>
					<a href="<?php echo esc_url(home_url()); ?>/"><img src="<?php echo esc_url($minti_data['media_logo']['url']); ?>" alt="<?php esc_attr(bloginfo('name')); ?>" class="logo_standard" /></a>
					<?php if($minti_data['media_logo_retina']['url'] != '') { ?><a href="<?php echo esc_url(home_url()); ?>/"><img src="<?php echo esc_url($minti_data['media_logo_retina']['url']); ?>" width="<?php echo esc_attr($minti_data['media_logo']['width']); ?>" height="<?php echo esc_attr($minti_data['media_logo']['height']); ?>" alt="<?php esc_html(bloginfo('name')); ?>" class="logo_retina" /></a><?php } ?>
				<?php } else { ?>
					<a href="<?php echo esc_url(home_url()); ?>/"><?php esc_html(bloginfo('name')); ?></a>
				<?php } ?>
			</div>
			<a href="#" id="mobile-navigation-btn"><i class="fa fa-bars"></i></a>
			<?php if (class_exists('Woocommerce')) { ?>
				<?php if($minti_data['switch_shoppingicon'] == 1) { ?>
					<?php global $woocommerce; ?>
					<span class="cart-popup">
					<a href="<?php echo esc_url($woocommerce->cart->get_cart_url()); ?>" id="mobile-shopping-btn" ><i class="icon-minti-cart"></i></a>
					</span>
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
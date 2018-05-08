<?php
/* ------------------------------------------------------------------------ */
/* Scripts */
/* ------------------------------------------------------------------------ */
function minti_scripts() {  
	
	global $minti_data;

	// Register Styles
	wp_register_script('minti-easing', get_template_directory_uri() . '/framework/js/jquery.easing.min.js', array( 'jquery' ), NULL, true);
	wp_register_script('waypoints', get_template_directory_uri() . '/framework/js/waypoints.min.js', array( 'jquery' ), NULL, true);
	wp_register_script('minti-waypoints-sticky', get_template_directory_uri() . '/framework/js/waypoints-sticky.min.js', array( 'jquery', 'waypoints' ), NULL, true);
	wp_register_script('minti-prettyphoto', get_template_directory_uri() . '/framework/js/prettyPhoto.js', array( 'jquery' ), NULL, true);
	wp_register_script('minti-isotope', get_template_directory_uri() . '/framework/js/isotope.pkgd.min.js', array( 'jquery' ), NULL, true);
	wp_register_script('minti-functions', get_template_directory_uri() . '/framework/js/functions.js', array( 'jquery' ), NULL, true);
	wp_register_script('minti-flexslider', get_template_directory_uri() . '/framework/js/flexslider.min.js', array( 'jquery' ), NULL, true);
	wp_register_script('minti-smoothscroll', get_template_directory_uri() . '/framework/js/smoothscroll.js', array( 'jquery' ), NULL, true);
	wp_register_script('minti-carousel', get_template_directory_uri() . '/framework/js/owl.carousel.min.js', array( 'jquery' ), NULL, true); // gets called individually in the shortcodes
	
	// Enqueue
	wp_enqueue_script('jquery');
	wp_enqueue_script('minti-easing');
	wp_enqueue_script('waypoints');
	wp_enqueue_script('minti-waypoints-sticky');
  	wp_enqueue_script('minti-prettyphoto');
	wp_enqueue_script('minti-isotope');
	wp_enqueue_script('minti-functions');
  	wp_enqueue_script('minti-flexslider');

  	// Enable / Disable Smooth Scrolling
  	if($minti_data['switch_smoothscroll'] == 1) { 
  		wp_enqueue_script('minti-smoothscroll');
  	}

  	// Load WP Comment Reply JS
  	if(is_singular()){
  		wp_enqueue_script( 'comment-reply' );
  	}

  	// Remove other PrettyPhoto scripts
    wp_dequeue_script( 'prettyPhoto' );
    wp_deregister_script( 'prettyPhoto' );
  	
}
add_action( 'wp_enqueue_scripts', 'minti_scripts' );  

/* ------------------------------------------------------------------------ */
/* Stylesheets */
/* ------------------------------------------------------------------------ */
function minti_styles() {  
	
	// Register Styles
	wp_register_style( 'shortcodes', get_template_directory_uri() . '/framework/css/shortcodes.css' );
	wp_register_style( 'woocommerce', get_template_directory_uri() . '/framework/css/woocommerce.css' );
	wp_register_style( 'responsive', get_template_directory_uri() . '/framework/css/responsive.css' );

	// Load Primary Stylesheet
	wp_enqueue_style( 'stylesheet', get_stylesheet_uri(), array(), '1', 'all' ); 
	
	// Deregister Composer Custom CSS
	wp_deregister_style( 'js_composer_custom_css' );
	
	// Load Visual Composer at Top of the Site
	if ( function_exists( 'vc_map' ) && !is_admin() ) {
		wp_enqueue_style( 'js_composer_front' );
	}

	wp_enqueue_style( 'shortcodes' );

	// Disable default WooCommerce CSS & load own styles
	if (class_exists('Woocommerce')){
		wp_enqueue_style( 'woocommerce' );
	}

	wp_enqueue_style( 'responsive' );

}  
add_action( 'wp_enqueue_scripts', 'minti_styles' ); 

?>
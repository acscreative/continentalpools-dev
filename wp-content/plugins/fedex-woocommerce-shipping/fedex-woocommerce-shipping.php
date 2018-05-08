<?php
/*
	Plugin Name: FedEx WooCommerce Shipping with Print Label
	Plugin URI: https://www.xadapter.com/product/woocommerce-fedex-shipping-plugin-with-print-label/
	Description: Obtain real time shipping rates and Print shipping labels via FedEx Shipping API.
	Version: 4.0.0
	Author: Xadapter
	Author URI: https://www.xadapter.com/vendor/wooforce/
	WC requires at least: 2.6.0
	WC tested up to: 3.2.5
*/

if (!defined('WF_Fedex_ID')){
	define("WF_Fedex_ID", "wf_fedex_woocommerce_shipping");
}

if( !defined('WF_FEDEX_ADV_DEBUG_MODE') ){
	define("WF_FEDEX_ADV_DEBUG_MODE", "off"); // Turn 'on' to allow advanced debug mode.
}

/**
 * Plugin activation check
 */
function wf_fedex_pre_activation_check(){
	//check if basic version is there
	if ( is_plugin_active('fedex-woocommerce-shipping-method/fedex-woocommerce-shipping.php') ){
        deactivate_plugins( basename( __FILE__ ) );
		wp_die( __("Oops! You tried installing the premium version without deactivating and deleting the basic version. Kindly deactivate and delete FedEx(Basic) Woocommerce Extension and then try again", "wf-shipping-fedex" ), "", array('back_link' => 1 ));
	}
	set_transient('wf_fedex_welcome_screen_activation_redirect', true, 30);
}

register_activation_hook( __FILE__, 'wf_fedex_pre_activation_check' );

/**
 * Check if WooCommerce is active
 */
if (in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )) {	
	
	if (!function_exists('wf_get_settings_url')){
		function wf_get_settings_url(){
			return version_compare(WC()->version, '2.1', '>=') ? "wc-settings" : "woocommerce_settings";
		}
	}
	
	if (!function_exists('wf_plugin_override')){
		add_action( 'plugins_loaded', 'wf_plugin_override' );
		function wf_plugin_override() {
			if (!function_exists('WC')){
				function WC(){
					return $GLOBALS['woocommerce'];
				}
			}
		}
	}
	if (!function_exists('wf_get_shipping_countries')){
		function wf_get_shipping_countries(){
			$woocommerce = WC();
			$shipping_countries = method_exists($woocommerce->countries, 'get_shipping_countries')
					? $woocommerce->countries->get_shipping_countries()
					: $woocommerce->countries->countries;
			return $shipping_countries;
		}
	}

	include('includes/wf-automatic-label-generation.php');
	if(!class_exists('wf_fedEx_wooCommerce_shipping_setup')){
		class wf_fedEx_wooCommerce_shipping_setup {
			
			public function __construct() {
                
				add_action( 'init', array( $this, 'init' ) );
                add_action('admin_init', array($this,'wf_fedex_welcome'));
                add_action('admin_menu', array($this,'wf_fedex_welcome_screen'));
                add_action('admin_head', array($this,'wf_fedex_welcome_screen_remove_menus'));
				
                $this->wf_init();
				add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_action_links' ) );
				add_action( 'woocommerce_shipping_init', array( $this, 'wf_fedEx_wooCommerce_shipping_init' ) );
				add_filter( 'woocommerce_shipping_methods', array( $this, 'wf_fedEx_wooCommerce_shipping_methods' ) );		
				add_filter( 'admin_enqueue_scripts', array( $this, 'wf_fedex_scripts' ) );		
				
				$fedex_settings = get_option( 'woocommerce_'.WF_Fedex_ID.'_settings', array() );

				if ( isset( $fedex_settings['freight_enabled'] ) && 'yes' === $fedex_settings['freight_enabled'] ) {
					// Make the city field show in the calculator (for freight)
					add_filter( 'woocommerce_shipping_calculator_enable_city', '__return_true' );

					// Add freight class option for shipping classes (for freight)
					if ( is_admin() ) {
						include( 'includes/class-wf-fedex-freight-mapping.php' );
					}
				}			
			}
			public function init() {
				if ( ! class_exists( 'wf_order' ) ) {
			  		include_once 'includes/class-wf-legacy.php';
			  	}
			}
			public function wf_fedex_welcome()
            {
	          	if (!get_transient('wf_fedex_welcome_screen_activation_redirect')) {
	           		 return;
	        	}
	       	 	delete_transient('wf_fedex_welcome_screen_activation_redirect');
	        	wp_safe_redirect(add_query_arg(array('page' => 'Fedex-Welcome'), admin_url('index.php')));
            }
            public function wf_fedex_welcome_screen()
            {
            	add_dashboard_page('Welcome To Fedex', 'Welcome To Fedex', 'read', 'Fedex-Welcome', array($this,'wf_fedex_screen_content'));
            }
            public function wf_fedex_screen_content()
            {
            	include 'includes/wf_fedex_welcome.php';
            }
            public function wf_fedex_welcome_screen_remove_menus()
            {
            	 remove_submenu_page('index.php', 'Fedex-Welcome');
            }
			public function wf_init() {
				include_once ( 'includes/class-wf-admin-notice.php' );
				include_once ( 'includes/class-wf-fedex-woocommerce-shipping-admin.php' );
				include_once ( 'includes/class-wf-admin-options.php' );
				include_once ( 'includes/class-wf-tracking-admin.php' );
				include_once ( 'includes/wf-multi-address-shipping.php' );
				include_once ( 'includes/class-wf-request.php' );
				include_once ( 'includes/class-xa-my-account-order-return.php' );
				if ( is_admin() ) {
					include_once ( 'includes/class-wf-fedex-pickup-admin.php' );				
					//include api manager
					include_once ( 'includes/wf_api_manager/wf-api-manager-config.php' );
					include_once ( 'includes/class-xa-fedex-image-upload.php' );

				}
				// Localisation
				load_plugin_textdomain( 'wf-shipping-fedex', false, dirname( plugin_basename( __FILE__ ) ) . '/i18n/' );
			}
			
			public function wf_fedex_scripts() {
				wp_enqueue_script( 'jquery-ui-sortable' );
				wp_enqueue_script( 'wf-common-script', plugins_url( '/resources/js/wf_common.js', __FILE__ ), array( 'jquery' ) );
				wp_enqueue_script( 'wf-fedex-script', plugins_url( '/resources/js/wf_fedex.js', __FILE__ ), array( 'jquery' ) );
				wp_enqueue_style( 'wf-common-style', plugins_url( '/resources/css/wf_common_style.css', __FILE__ ));
				wp_enqueue_style( 'wf-fedex-style', plugins_url( '/resources/css/wf_fedex_style.css', __FILE__ ));
			}
			
			public function plugin_action_links( $links ) {
				$plugin_links = array(
					'<a href="' . admin_url( 'admin.php?page=' . wf_get_settings_url() . '&tab=shipping&section=wf_fedex_woocommerce_shipping' ) . '">' . __( 'Settings', 'wf_fedEx_wooCommerce_shipping' ) . '</a>',
					'<a href="https://www.xadapter.com/category/product/woocommerce-fedex-shipping-plugin-with-print-label/" target="_blank">' . __('Documentation', 'wf_fedEx_wooCommerce_shipping') . '</a>',
                '<a href="https://www.xadapter.com/online-support/" target="_blank">' . __('Support', 'wf_fedEx_wooCommerce_shipping') . '</a>',
                '<a href="'.admin_url('index.php?page=Fedex-Welcome').'" style="color:green;" target="_blank">' . __('Get Started', 'wf_fedEx_wooCommerce_shipping') . '</a>'
				);
				return array_merge( $plugin_links, $links );
			}			
			
			public function wf_fedEx_wooCommerce_shipping_init() {
				include_once( 'includes/class-wf-fedex-woocommerce-shipping.php' );
				$shipping_obj = new wf_fedex_woocommerce_shipping_method();
				//This filer kept outside of 'wf_fedex_woocommerce_shipping_method'. Because, the scope of filter should be avail outside of calculate_shipping() method.
            	add_filter( 'woocommerce_cart_shipping_method_full_label', array($shipping_obj, 'wf_add_delivery_time'), 10, 2 );
			}

			
			public function wf_fedEx_wooCommerce_shipping_methods( $methods ) {
				$methods[] = 'wf_fedex_woocommerce_shipping_method';
				return $methods;
			}		
		}
		new wf_fedEx_wooCommerce_shipping_setup();
	}
}

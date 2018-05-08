<?php

class minti_shortcode_generator {

	function __construct() 
    {			
        add_action('init', array(&$this, 'init'));
        add_action('admin_init', array(&$this, 'admin_init'));
	}

	function init()
	{		
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;
	
		if ( get_user_option('rich_editing') == 'true' )
		{
			add_filter( 'mce_external_plugins', array(&$this, 'add_rich_plugins') );
			add_filter( 'mce_buttons', array(&$this, 'register_rich_buttons') );
		}
	}

	/* ------------------------------------------------------------------------ */
	/* Defins TinyMCE rich editor js plugin
	/* ------------------------------------------------------------------------ */
	function add_rich_plugins( $plugin_array )
	{
		$plugin_array['mintiShortcodes'] = get_template_directory_uri() . '/framework/inc/tinymce/plugin.js';
		return $plugin_array;
	}

	/* ------------------------------------------------------------------------ */
	/* Adds TinyMCE rich editor buttons
	/* ------------------------------------------------------------------------ */
	function register_rich_buttons( $buttons )
	{
		array_push( $buttons, "|", 'minti_button' );
		return $buttons;
	}
	
	/* ------------------------------------------------------------------------ */
	/* Enqueue Scripts and Styles
	/* ------------------------------------------------------------------------ */
	function admin_init()
	{
		// css
		wp_enqueue_style( 'minti-popup', get_template_directory_uri() . '/framework/inc/tinymce/css/popup.css', false, '1.0', 'all' );
		
		// js
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-livequery', get_template_directory_uri() . '/framework/inc/tinymce/js/jquery.livequery.js', false, '1.1.1', false );
		wp_enqueue_script( 'jquery-appendo', get_template_directory_uri() . '/framework/inc/tinymce/js/jquery.appendo.js', false, '1.0', false );
		wp_enqueue_script( 'base64', get_template_directory_uri() . '/framework/inc/tinymce/js/base64.js', false, '1.0', false );
		wp_enqueue_script( 'minti-popup', get_template_directory_uri() . '/framework/inc/tinymce/js/popup.js', false, '1.0', false );
		
	}

}

$minti_shortcode_generator = new minti_shortcode_generator();
    
?>
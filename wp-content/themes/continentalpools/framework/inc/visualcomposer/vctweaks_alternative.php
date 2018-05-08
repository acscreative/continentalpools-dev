<?php
/* ------------------------------------------------------------------------ */
/* General
/* ------------------------------------------------------------------------ */

// Disable automatic updates notifications
function minti_vcSetAsTheme() {
    vc_set_as_theme(true);
}
add_action( 'vc_before_init', 'minti_vcSetAsTheme' );

// Disable Frontend Editor
function vc_remove_frontend_links() {
    vc_disable_frontend(); // this will disable frontend editor
}
add_action( 'vc_after_init', 'vc_remove_frontend_links' );

// Override VC Templates Directory Path
if ( function_exists( 'vc_map' ) && !is_admin() ) {
	$dir = get_template_directory() . '/framework/inc/visualcomposer/vc_templates/';
	vc_set_shortcodes_templates_dir($dir);
}

// Add Visual Composer Admin CSS
function minti_vctweaks() {
	wp_enqueue_style( 'vcminti-admin-css', get_template_directory_uri() . '/framework/inc/visualcomposer/vctweaks.css' );
}
add_action( 'admin_enqueue_scripts', 'minti_vctweaks' );

// Remove VC Teaser Metabox
if ( ! function_exists('minti_vc_remove_teaserbox') ) {
	function minti_vc_remove_teaserbox(){
		$post_types = get_post_types( '', 'names' ); 
		foreach ( $post_types as $post_type ) {
			remove_meta_box('vc_teaser',  $post_type, 'side');
		}
	}
}
add_action('do_meta_boxes', 'minti_vc_remove_teaserbox');

// Remove Default Templates
add_filter( 'vc_load_default_templates', 'minti_template_modify_array' );
function minti_template_modify_array($data) {
    return array(); // This will remove all default templates
}

// Remove Tabs & Accordion from Depricated Tab
vc_map_update( 'vc_accordion', array('deprecated' => false) );
vc_map_update( 'vc_tabs', array('deprecated' => false) ); 
vc_map_update( 'vc_tour', array('deprecated' => false) ); 

/* ------------------------------------------------------------------------ */
/* Remove Visual Composer Elements
/* ------------------------------------------------------------------------ */
vc_remove_element("vc_separator");
vc_remove_element("vc_text_separator");
vc_remove_element("vc_message");
vc_remove_element("vc_empty_space");
//vc_remove_element("vc_facebook");
//vc_remove_element("vc_tweetmeme");
//vc_remove_element("vc_googleplus");
//vc_remove_element("vc_pinterest");
vc_remove_element("vc_single_image");
vc_remove_element("vc_gallery");
vc_remove_element("vc_images_carousel");
vc_remove_element("vc_posts_grid");
vc_remove_element("vc_carousel");
vc_remove_element("vc_posts_slider");
vc_remove_element("vc_btn");
vc_remove_element("vc_button");
vc_remove_element("vc_button2");
vc_remove_element("vc_cta");
vc_remove_element("vc_cta_button");
vc_remove_element("vc_cta_button2");
vc_remove_element("vc_video");
vc_remove_element("vc_gmaps");
vc_remove_element("vc_flickr");
vc_remove_element("vc_progress_bar");
vc_remove_element("vc_toggle");
vc_remove_element("vc_teaser_grid");
vc_remove_element("vc_custom_heading");
vc_remove_element("vc_media_grid");
vc_remove_element("vc_masonry_grid");
vc_remove_element("vc_masonry_media_grid");
vc_remove_element("vc_icon");
vc_remove_element("vc_basic_grid");

vc_remove_element("vc_wp_archives");
vc_remove_element("vc_wp_calendar");
vc_remove_element("vc_wp_categories");
vc_remove_element("vc_wp_custommenu");
vc_remove_element("vc_wp_links");
vc_remove_element("vc_wp_meta");
vc_remove_element("vc_wp_pages");
vc_remove_element("vc_wp_posts");
vc_remove_element("vc_wp_recentcomments");
vc_remove_element("vc_wp_rss");
vc_remove_element("vc_wp_search");
vc_remove_element("vc_wp_tagcloud");
vc_remove_element("vc_wp_text");

// Remove from VC 4.7
vc_remove_element("vc_tta_accordion");
vc_remove_element("vc_tta_tabs");
vc_remove_element("vc_tta_tour");
vc_remove_element("vc_tta_pageable");
//vc_remove_element("vc_tta_section");

/* ------------------------------------------------------------------------ */
/* Edit VC Row
/* ------------------------------------------------------------------------ */
vc_remove_param("vc_row", "full_width");
vc_remove_param("vc_row", "bg_color");
vc_remove_param("vc_row", "font_color");
vc_remove_param("vc_row", "margin_bottom");
vc_remove_param("vc_row", "bg_image");
vc_remove_param("vc_row", "bg_image_repeat");
vc_remove_param("vc_row", "padding");
vc_remove_param("vc_row", "el_class");
vc_remove_param("vc_row", "css" );

vc_remove_param("vc_row", "parallax");
vc_remove_param("vc_row", "parallax_image");
vc_remove_param("vc_row", "el_id");

// Visual Composer 4.6+
vc_remove_param("vc_row", "video_bg");

// Visual Composer 4.9+
vc_remove_param("vc_row", "gap");
vc_remove_param("vc_row", "equal_height");
vc_remove_param("vc_row", "columns_placement");
vc_remove_param("vc_row", "content_placement");
vc_remove_param("vc_row", "parallax_speed_bg");

vc_remove_param("vc_row", "video_bg_url");
vc_remove_param("vc_row", "video_bg_parallax");
vc_remove_param("vc_row", "parallax_speed_video");


vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Content Position",
	"param_name" => "content_placement",
	"value" => array(
		"Middle" => "middle",
		"Top" => "top",
	),
	'dependency' => array('element' => 'full_height','not_empty' => true),
));

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Section Type",
	"param_name" => "type",
	"value" => array(
		"Standard Section" => "standard_section",
		"Full Width Section" => "full_width_section"		
	),
));

vc_add_param("vc_row", array(
	"type" => "attach_image",
	"class" => "",
	"heading" => "Background Image",
	"param_name" => "bg_image",
	"value" => "",
	"description" => "",
	"group"	=> __( 'Background', 'minti-framework' ),
));

// vc_add_param("vc_row", array(
// 	"type" => "dropdown",
// 	"class" => "",
// 	"heading" => "Background Position",
// 	"param_name" => "bg_position",
// 	"value" => array(
// 		 "Left Top" => "left top",
//   		 "Left Center" => "left center",
//   		 "Left Bottom" => "left bottom",
//   		 "Center Top" => "center top",
//   		 "Center Center" => "center center",
//   		 "Center Bottom" => "center bottom",
//   		 "Right Top" => "right top",
//   		 "Right Center" => "right center",
//   		 "Right Bottom" => "right bottom"
// 	),
// 	"dependency" => Array('element' => "bg_image", 'not_empty' => true),
// 	"group"	=> __( 'Background', 'minti-framework' ),
// ));

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Background Repeat",
	"param_name" => "bg_repeat",
	"value" => array(
		"Stretch" => "stretch",
		"No Repeat" => "no-repeat",
		"Repeat" => "repeat"
	),
	"dependency" => Array('element' => "bg_image", 'not_empty' => true),
	"group"	=> __( 'Background', 'minti-framework' ),
));

vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => "Parallax Background",
	"value" => array("Enable Parallax Background?" => "true" ),
	"param_name" => "parallax_bg",
	"description" => "",
	"dependency" => Array('element' => "bg_image", 'not_empty' => true),
	"group"	=> __( 'Background', 'minti-framework' ),
));

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Parallax Speed",
	"value" => array(
		"Default Parallax" => "default",
		"Fixed Parallax" => "fixed",
	),
	"param_name" => "stellar_class",
	"description" => "",
	"dependency" => Array('element' => "parallax_bg", 'value' => array('true')),
	"group"	=> __( 'Background', 'minti-framework' ),
));

vc_add_param("vc_row", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => "Background Color",
	"param_name" => "bg_color",
	"value" => "",
	"description" => "",
	"group"	=> __( 'Background', 'minti-framework' ),
));

vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => "Section Arrow",
	"value" => array("Enable Section Arrow at the bottom? (Background Color must be defined)" => "false" ),
	"param_name" => "section_arrow",
	"description" => "",
	"group"	=> __( 'Background', 'minti-framework' ),
));

vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => "Video Background",
	"value" => array("Want to use a Video Background?" => "use_video" ),
	"param_name" => "video_bg",
	"description" => "",
	"group"	=> __( 'Background', 'minti-framework' ),
));

vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => "Overlay Color",
	"value" => array("Add video overlay color?" => "true" ),
	"param_name" => "enable_video_color_overlay",
	"description" => "",
	"dependency" => Array('element' => "video_bg", 'value' => array('use_video')),
	"group"	=> __( 'Background', 'minti-framework' ),
));

vc_add_param("vc_row", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => "Overlay Color",
	"param_name" => "video_overlay_color",
	"value" => "",
	"description" => "",
	"dependency" => Array('element' => "enable_video_color_overlay", 'value' => array('true')),
	"group"	=> __( 'Background', 'minti-framework' ),
));

vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "WebM Video URL",
	"value" => "",
	"param_name" => "video_webm",
	"description" => "Insert absolute path to your webm video.",
	"dependency" => Array('element' => "video_bg", 'value' => array('use_video')),
	"group"	=> __( 'Background', 'minti-framework' ),
));

vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "MP4 Video URL",
	"value" => "",
	"param_name" => "video_mp4",
	"description" => "Insert absolute path to your mp4 video.",
	"dependency" => Array('element' => "video_bg", 'value' => array('use_video')),
	"group"	=> __( 'Background', 'minti-framework' ),
));

vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "OGV Video URL",
	"value" => "",
	"param_name" => "video_ogv",
	"description" => "Insert absolute path to your ogv video.",
	"dependency" => Array('element' => "video_bg", 'value' => array('use_video')),
	"group"	=> __( 'Background', 'minti-framework' ),
));

vc_add_param("vc_row", array(
	"type" => "attach_image",
	"class" => "",
	"heading" => "Video Fallback Image",
	"value" => "",
	"param_name" => "video_image",
	"description" => "",
	"dependency" => Array('element' => "video_bg", 'value' => array('use_video')),
	"group"	=> __( 'Background', 'minti-framework' ),
));

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Text Color",
	"param_name" => "text_color",
	"value" => array(
		"Dark" => "dark",
		"Light" => "light",
		"Custom" => "custom"
	),
	"group"	=> __( 'Text', 'minti-framework' ),
));

vc_add_param("vc_row", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => "Custom Text Color",
	"param_name" => "custom_text_color",
	"value" => "",
	"description" => "",
	"dependency" => Array('element' => "text_color", 'value' => array('custom')),
	"group"	=> __( 'Text', 'minti-framework' ),
));

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Text Alignment",
	"param_name" => "text_align",
	"value" => array(
		"Left" => "left",
		"Center" => "center",
		"Right" => "right"
	),
	"group"	=> __( 'Text', 'minti-framework' ),
));

vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Padding Top",
	"value" => "",
	"param_name" => "top_padding",
	"description" => "Do not include \"px\" in your string. For example: 40",
));

vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Padding Bottom",
	"value" => "",
	"param_name" => "bottom_padding",
	"description" => "Do not include \"px\" in your string. For example: 40",
));

vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Extra Class Name",
	"param_name" => "class",
	"value" => "",
));

vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Row ID",
	"value" => "",
	"param_name" => "row_id",
	"description" => "Optional: Insert a unique name for that row. You can then link to that row with #rowid (useful for One Page Layouts).",
));

/*vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "EXPERIMENTAL: Angled Section?",
	"param_name" => "angled_section",
	"value" => array(
		"Default / None" => "",
		"Bottom: Left to Right" => "angled_b_ltr",
		"Bottom: Right to Left" => "angled_b_rtl",
		"Top: Left to Right" => "angled_t_ltr",
		"Top: Right to Left" => "angled_t_rtl"
	),
	"description" => "EXPERIMENTAL! This is an experimental feature and we can NOT guarantee compatibility in ALL browsers. This only works in modern browsers and only looks good in between of white sections.",
	"group"	=> __( 'Background', 'minti-framework' ),
));*/

/* ------------------------------------------------------------------------ */
/* Edit VC Inner Row
/* ------------------------------------------------------------------------ */
vc_remove_param("vc_row_inner", "css");
vc_remove_param("vc_row_inner", "font_color");
vc_remove_param("vc_row_inner", "equal_height");
vc_remove_param("vc_row_inner", "content_placement");
vc_remove_param("vc_row_inner", "gap");

/* ------------------------------------------------------------------------ */
/* Edit VC Columns
/* ------------------------------------------------------------------------ */
vc_remove_param("vc_column", "css" );
vc_remove_param("vc_column", "font_color" );
vc_remove_param("vc_column", "width" );
vc_remove_param("vc_column", "offset" );

vc_add_param("vc_column", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Animation",
	"param_name" => "animation",
	"value" => array(
		 "None" => "none",
	     "Fade In" => "fade-in",
  		 "Fade In From Left" => "fade-in-from-left",
  		 "Fade In From Right" => "fade-in-from-right",
  		 "Fade In From Bottom" => "fade-in-from-bottom",
  		 "Fade In From Top" => "fade-in-from-top"
	),
	"group"	=> __( 'Animation', 'minti-framework' ),
));

vc_add_param("vc_column", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Animation Delay",
	"param_name" => "delay",
	"admin_label" => false,
	"description" => "",
	"group"	=> __( 'Animation', 'minti-framework' ),
));

vc_add_param("vc_column", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => "Background Color",
	"param_name" => "bg_color",
	"value" => "",
	"description" => "",
	"group"	=> __( 'Background', 'minti-framework' ),
));

vc_add_param("vc_column", array(
	"type" => "attach_image",
	"class" => "",
	"heading" => "Background Image",
	"param_name" => "bg_image",
	"value" => "",
	"description" => "",
	"group"	=> __( 'Background', 'minti-framework' )
));

vc_add_param("vc_column", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Column Padding",
	"param_name" => "column_padding",
	"value" => array(
		"Default (Standard)" => "no-padding",
		"1%" => "padding-1",
		"2%" => "padding-2",
		"3%" => "padding-3",
		"4%" => "padding-4",
		"5%" => "padding-5",
		"6%" => "padding-6",
		"7%" => "padding-7",
		"8%" => "padding-8",
		"9%" => "padding-9",
		"10%" => "padding-10",
		"Custom" => "custom-padding",
	),
	"description" => "Set the padding of your column. Note: Only works when the parent row is set to Full-Width.",
	"group"	=> __( 'Background', 'minti-framework' ),
));

vc_add_param("vc_column", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Custom Padding",
	"param_name" => "column_custompadding",
	"admin_label" => false,
	"value" => "0px 0px 0px 0px",
	"description" => "Set Padding - toppadding rightpadding bottompadding leftpadding",
	"group"	=> __( 'Background', 'minti-framework' ),
	"dependency" => Array('element' => "column_padding", 'value' => array('custom-padding')),
));

vc_add_param("vc_column", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => "Vertically Center Column?",
	"value" => array("Yes, please!" => "true" ),
	"param_name" => "column_center",
	"description" => "Useful if you have columns with different heights.",
	"group"	=> __( 'Background', 'minti-framework' )
));

vc_add_param("vc_column", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Text Color",
	"param_name" => "text_color",
	"value" => array(
		"Dark" => "dark",
		"Light" => "light",
		"Custom" => "custom"
	),
	"group"	=> __( 'Text', 'minti-framework' )
));

vc_add_param("vc_column", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => "Custom Text Color",
	"param_name" => "custom_text_color",
	"value" => "",
	"description" => "",
	"dependency" => Array('element' => "text_color", 'value' => array('custom')),
	"group"	=> __( 'Text', 'minti-framework' )
));

vc_add_param("vc_column", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Text Alignment",
	"param_name" => "text_align",
	"value" => array(
		"Left" => "left",
		"Center" => "center",
		"Right" => "right"
	),
	"group"	=> __( 'Text', 'minti-framework' )
));

/* ------------------------------------------------------------------------ */
/* Edit VC Inner Column
/* ------------------------------------------------------------------------ */


/*vc_add_param("vc_column_inner", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Animation",
	"param_name" => "animation",
	"value" => array(
		 "None" => "none",
	     "Fade In" => "fade-in",
  		 "Fade In From Left" => "fade-in-from-left",
  		 "Fade In From Right" => "fade-in-from-right",
  		 "Fade In From Bottom" => "fade-in-from-bottom",
  		 "Fade In From Top" => "fade-in-from-top"
	),
));

vc_add_param("vc_column_inner", array(
	"type" => "textfield",
	"class" => "",
	"heading" => "Animation Delay",
	"param_name" => "delay",
	"admin_label" => false,
	"description" => "",
));*/

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Alert Shortcode
/*-----------------------------------------------------------------------------------*/
function minti_alert_vc() {
	vc_map( array(
		"name"					=> __( "Alert", 'minti-framework' ),
		"description"			=> __( "Add Alert Message Boxes", 'minti-framework' ),
		"base"					=> "minti_alert",
		'category'				=> "Content",
		"icon"					=> "icon-wpb-minti-alert",
		"params"				=> array(
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Type", 'minti-framework' ),
				"param_name"	=> "type",
				"value"			=> array(
					'Warning Message' 	=> 'warning',
					'Success Message' 	=> 'success',
					'Error Message' 	=> 'error',
					'Info Message' 		=> 'info',
					'Notice Message' 		=> 'notice',
				),
			),
			array(
				"type"			=> "textarea",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Text", 'minti-framework' ),
				"param_name"	=> "content",
				"value"			=> "",
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Closable", 'minti-framework' ),
				"param_name"	=> "close",
				"value"			=> array(
					'Alert can be closed' 		=> 'true',
					'Alert can not be closed' 	=> 'false',
				),
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_alert_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Button Shortcode
/*-----------------------------------------------------------------------------------*/
function minti_button_vc() {
	vc_map( array(
		"name"					=> __( "Button", 'minti-framework' ),
		"description"			=> __( "Add Button", 'minti-framework' ),
		"base"					=> "minti_button",
		'category'				=> "Content",
		"icon"					=> "icon-wpb-ui-button",
		"params"				=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Button Text", 'minti-framework' ),
				"param_name"	=> "content",
				"value"			=> "",
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Button URL", 'minti-framework' ),
				"param_name"	=> "link",
				"value"			=> "http://",
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Link Target", 'minti-framework' ),
				"param_name"	=> "target",
				"value"			=> array(
					'Same Window' => '_self',
					'New Window' => '_blank',
				),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Button Icon", 'minti-framework' ),
				"param_name"	=> "icon",
				"value"			=> "",
				"description"	=> __( "Can be any Fontawesome Icon (fa-chevron-right) or Simple Line Icon (sl-users)", 'minti-framework' ),
				"group"	=> __( 'Styling', 'minti-framework' )
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Icon Appear Animation?", 'minti-framework' ),
				"param_name"	=> "appear",
				"value"			=> array(
					'Disable' => 'false',
					'Enable' => 'true',
				),
				"description"	=> __( "An Icon has to be defined", 'minti-framework' ),
				"group"	=> __( 'Styling', 'minti-framework' )
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Button Color", 'minti-framework' ),
				"param_name"	=> "color",
				"value"			=> array(
					'Grey Outline' => 'color-1',
					'Accent Outline' => 'color-2',
					'Accent Color' => 'color-3',
					'Light Grey Color' => 'color-4',
					'Grey Color' => 'color-5',
					'Dark Grey Color' => 'color-6',
					'White Color' => 'color-7',
					'Transparent Outline' => 'color-8',
					// 'Small Color' => 'color-9',
					'Yellow' => 'yellow',
					'Orange' => 'orange',
					'Red' => 'red',
					'Blue' => 'blue',
					'Green' => 'green',
					'Custom Color' => 'custom',
				),
				"group"	=> __( 'Styling', 'minti-framework' )
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => "Button Color Override",
				"param_name" => "custom_color",
				"value" => "",
				"description" => "",
				'dependency' => Array( 'element' => 'color', 'value' => Array('custom') ),
				"group"	=> __( 'Styling', 'minti-framework' )
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Button Size", 'minti-framework' ),
				"param_name"	=> "size",
				"value"			=> array(
					'Small' => 'small',
					'Medium' => 'medium',
					'Large' => 'large',
					'Full' => 'full',
				),
				"group"	=> __( 'Styling', 'minti-framework' )
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Border Radius", 'minti-framework' ),
				"param_name"	=> "border_radius",
				"value"			=> "2px",
				"description"	=> __( "", 'minti-framework' ),
				"group"	=> __( 'Styling', 'minti-framework' )
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Button Class", 'minti-framework' ),
				"param_name"	=> "class",
				"value"			=> "",
				"description"	=> __( "Use this field to give your button a custom class. For example: pagescroll - for smooth scrolling", 'minti-framework' ),
				"group"	=> __( 'Styling', 'minti-framework' )
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_button_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Callout Shortcode
/*-----------------------------------------------------------------------------------*/
function minti_callout_vc() {
	vc_map( array(
		"name"					=> __( "Callout", 'minti-framework' ),
		"description"			=> __( "Add Callout Section", 'minti-framework' ),
		"base"					=> "minti_callout",
		'category'				=> "Content",
		"icon"					=> "icon-wpb-minti-callout",
		"params"				=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Callout Text", 'minti-framework' ),
				"param_name"	=> "content",
				"value"			=> "",
				"description"	=> __( "Insert Callout Text", 'minti-framework' )
			),
			array(
				"type"			=> "colorpicker",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Background Color", 'minti-framework' ),
				"param_name"	=> "bgcolor",
				"value"			=> "#efefef",
			),
			array(
				"type"			=> "colorpicker",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Text Color", 'minti-framework' ),
				"param_name"	=> "textcolor",
				"value"			=> "#777777",
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Button Text", 'minti-framework' ),
				"param_name"	=> "buttontext",
				"value"			=> "",
				"description"	=> __( "Insert Button Text", 'minti-framework' )
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Button URL", 'minti-framework' ),
				"param_name"	=> "url",
				"value"			=> "",
				"description"	=> __( "Insert Button URL", 'minti-framework' )
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Button Color", 'minti-framework' ),
				"param_name"	=> "buttoncolor",
				"value"			=> array(
					'color-1' => 'color-1',
					'color-2' => 'color-2',
					'color-3' => 'color-3',
					'color-4' => 'color-4',
					'color-5' => 'color-5',
					'color-6' => 'color-6',
					'color-7' => 'color-7',
					'color-8' => 'color-8',
					'color-9' => 'color-9',
					'yellow' => 'yellow',
					'orange' => 'orange',
					'red' => 'red',
					'blue' => 'blue',
					'green' => 'green',
				),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Link Target", 'minti-framework' ),
				"param_name"	=> "target",
				"value"			=> array(
					'Same Window' => '_self',
					'New Window' => '_blank',
				),
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_callout_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Category Image
/*-----------------------------------------------------------------------------------*/
function minti_category_image_vc() {
	vc_map( array(
		"name"					=> __( "Category Image", 'minti-framework' ),
		"description"			=> __( "Image with link and a short headline", 'minti-framework' ),
		"base"					=> "minti_category_image",
		'category'				=> "Content",
		"icon"					=> "icon-wpb-minti-category_image",
		"params"				=> array(
			array(
				"type"			=> "attach_image",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Image", 'minti-framework' ),
				"param_name"	=> "image",
				"value"			=> "",
				"description"	=> __( "Select an image", 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Text", 'minti-framework' ),
				"param_name"	=> "content",
				"value"			=> "",
				"description"	=> __( "Insert Text", 'minti-framework' )
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Height", 'minti-framework' ),
				"param_name"	=> "height",
				"value"			=> "300px",
				"description"	=> __( "Height of the Category Image (Don't forget the px)", 'minti-framework' )
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Link", 'minti-framework' ),
				"param_name"	=> "url",
				"value"			=> "http://",
				"description"	=> __( "Link of the Category Image", 'minti-framework' )
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Link Target", 'minti-framework' ),
				"param_name"	=> "target",
				"value"			=> array(
					'Same Window' => '_self',
					'New Window' => '_blank',
				),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Color", 'minti-framework' ),
				"param_name"	=> "color",
				"value"			=> array(
					'Light Text' => 'light',
					'Dark Text' => 'dark'
				),
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_category_image_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Box - Box
/*-----------------------------------------------------------------------------------*/
function minti_box_vc() {
	vc_map( array(
		"name"					=> __( "Box", 'minti-framework' ),
		"description"			=> __( "Simple Box with different Styles", 'minti-framework' ),
		"base"					=> "minti_box",
		'category'				=> "Content",
		"icon"					=> "icon-wpb-minti-box",
		"params"				=> array(
			array(
				"type"			=> "textarea_html",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Content", 'minti-framework' ),
				"param_name"	=> "content",
				"value"			=> "Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.",
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Style", 'minti-framework' ),
				"param_name"	=> "style",
				"value"			=> array(
					'Thin Border' => '1',
					'Without Border' => '3',
					'Colored Top Border' => '2',
					'Colored Border' => '4',
					'Dark Background' => '5',
					'Colored Background' => '6',
					'Own Background Image' => '7'
				),
				"group"	=> __( 'Layout', 'minti-framework' ),
			),
			array(
				"type"			=> "attach_image",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Image", 'minti-framework' ),
				"param_name"	=> "bgimage",
				"value"			=> "",
				"description"	=> __( "Select an image", 'minti-framework' ),
				'dependency' => Array( 'element' => 'style', 'value' => Array('7') ),
				"group"	=> __( 'Layout', 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Padding", 'minti-framework' ),
				"param_name"	=> "padding",
				"value"			=> "40px 40px 40px 40px",
				"description"	=> __( "Set Box Padding - toppadding rightpadding bottompadding leftpadding", 'minti-framework', 'minti-framework' ),
				"group"	=> __( 'Layout', 'minti-framework' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Text Align", 'minti-framework' ),
				"param_name"	=> "align",
				"value"			=> array(
					'Center' => 'align-center',
					'Left' => 'align-left',
					'Right' => 'align-right',
				),
				"group"	=> __( 'Layout', 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Minimum Height", 'minti-framework' ),
				"param_name"	=> "height",
				"value"			=> "",
				"description"	=> __( "If you want to give the box a minimum fixed height insert your value here (ie: 400px)", 'minti-framework', 'minti-framework' ),
				"group"	=> __( 'Layout', 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "CSS Class", 'minti-framework' ),
				"param_name"	=> "class",
				"value"			=> "",
				"description"	=> __( "Add your own class and refer to it in your CSS file.", 'minti-framework' ),
				"group"	=> __( 'Layout', 'minti-framework' ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_box_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Iconbox
/*-----------------------------------------------------------------------------------*/
function minti_iconbox_vc() {
	vc_map( array(
		"name"					=> __( "Iconbox", 'minti-framework' ),
		"description"			=> __( "Box with Icon and Content.", 'minti-framework' ),
		"base"					=> "minti_iconbox",
		'category'				=> "Content",
		"icon"					=> "icon-wpb-minti-iconbox",
		"params"				=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Icon", 'minti-framework' ),
				"param_name"	=> "icon",
				"value"			=> "fa-phone",
				"description"	=> __( "Can be any Fontawesome Icon (fa-phone) or Simple Line Icon (sl-users)", 'minti-framework' ),
			),
			array(
				"type"			=> "attach_image",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Image Alternative", 'minti-framework' ),
				"param_name"	=> "iconimg",
				"value"			=> "",
				"description"	=> __( "Select an image instead of using a Font Icon", 'minti-framework' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Style", 'minti-framework' ),
				"param_name"	=> "style",
				"value"			=> array(
					'Icon next to Title' => '1',
					'Icon next to Box' => '2',
					'Icon above Box' => '3',
					'Circle Icon above to Box' => '4',
					'Circle Icon next to Box' => '5',
					'Square Icon above Box' => '6',
					'Icon above shaded Box' => '7',
					'Icon inside shaded Box' => '8',
					'Flipping Box' => '9',
					'Description Box' => '10',
				),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Icon Animation", 'minti-framework' ),
				"param_name"	=> "icon_animation",
				"value"			=> array(
					'None / Default' => 'none',
					'Icon Appear' => 'iconappear',
				),
				'dependency' => Array( 'element' => 'style', 'value' => Array('1') ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Icon Color", 'minti-framework' ),
				"param_name"	=> "iconcolor",
				"value"			=> array(
					'Accent Color' => 'accent',
					'Greyscale' => 'greyscale',
					'Custom Color' => 'custom',
				),
			),
			array(
				"type"			=> "colorpicker",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Color", 'minti-framework' ),
				"param_name"	=> "customcolor",
				"value"			=> "",
				'dependency' => Array( 'element' => 'iconcolor', 'value' => Array('custom') ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Custom Class", 'minti-framework' ),
				"param_name"	=> "class",
				"value"			=> "",
				"description"	=> __( "Use this field to add a custom class.", 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Title", 'minti-framework' ),
				"param_name"	=> "title",
				"value"			=> "",
				"group"	=> __( 'Content', 'minti-framework' ),
			),
			array(
				"type"			=> "textarea_html",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Content", 'minti-framework' ),
				"param_name"	=> "content",
				"value"			=> "Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.",
				"group"	=> __( 'Content', 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Iconbox URL (links the complete iconbox to this url)", 'minti-framework' ),
				"param_name"	=> "url",
				"value"			=> "",
				"description"	=> "Enter URL or leave empty. Please note: This link works only if JavaScript is enabled.",
				"group"	=> __( 'Content', 'minti-framework' ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_iconbox_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Box - Imagebox Shortcode
/*-----------------------------------------------------------------------------------*/
function minti_imagebox_vc() {
	vc_map( array(
		"name"					=> __( "Imagebox", 'minti-framework' ),
		"description"			=> __( "Box with Content and Button", 'minti-framework' ),
		"base"					=> "minti_imagebox",
		'category'				=> "Content",
		"icon"					=> "icon-wpb-minti-imagebox",
		"params"				=> array(
			array(
				"type"			=> "attach_image",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Image", 'minti-framework' ),
				"param_name"	=> "img",
				"value"			=> "",
				"description"	=> __( "If you want to use an Image you can upload it here.", 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Link Image to this URL", 'minti-framework' ),
				"param_name"	=> "url",
				"value"			=> "",
				"description"	=> __( "Enter URL or leave empty", 'minti-framework' )
			),
			array(
				"type"			=> "textarea_html",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Content", 'minti-framework' ),
				"param_name"	=> "content",
				"value"			=> "Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.",
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Style", 'minti-framework' ),
				"param_name"	=> "style",
				"value"			=> array(
					'Boxed' => '1',
					'Simple' => '2',
				),
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_imagebox_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Counter
/*-----------------------------------------------------------------------------------*/
function minti_counter_vc() {
	vc_map( array(
		"name"					=> __( "Counter", 'minti-framework' ),
		"description"			=> __( "Counter", 'minti-framework' ),
		"base"					=> "minti_counter",
		'category'				=> "Content",
		"icon"					=> "icon-wpb-minti-counter",
		"params"				=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Number", 'minti-framework' ),
				"param_name"	=> "number",
				"value"			=> "197",
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Title", 'minti-framework' ),
				"param_name"	=> "title",
				"value"			=> "",
			),
			array(
				"type"			=> "colorpicker",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Color", 'minti-framework' ),
				"param_name"	=> "color",
				"value"			=> "#666666",
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_counter_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Divider
/*-----------------------------------------------------------------------------------*/
function minti_divider_vc() {
	vc_map( array(
		"name"					=> __( "Divider", 'minti-framework' ),
		"description"			=> __( "Divider & Separator", 'minti-framework' ),
		"base"					=> "minti_divider",
		'category'				=> "Structure",
		"icon"					=> "icon-wpb-minti-divider",
		"params"				=> array(
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Divider Style", 'minti-framework' ),
				"param_name"	=> "style",
				"value"			=> array(
					'Thin Light Grey' => '1',
					'Dotted' => '2',
					'Line with Shadow' => '3',
					'Diagonal Lines' => '4',
					'Short Accent Color' => '5',
					'Short Dark Grey' => '6',
					'Dashed Line' => '7',
					'Centered Line with Icon' => '8',
					'Thin Light for dark Backgrounds' => '9',
				),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Margin", 'minti-framework' ),
				"param_name"	=> "margin",
				"value"			=> "60px 0 60px 0",
				"description"	=> __( "Set Divider Margin - topmargin rightmargin bottommargin leftmargin", 'minti-framework', 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Icon", 'minti-framework' ),
				"param_name"	=> "icon",
				"value"			=> "",
				"description"	=> __( "Can be any Fontawesome Icon (ie. fa-phone)", 'minti-framework' ),
				'dependency' => Array( 'element' => 'style', 'value' => Array('8') ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_divider_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - New Divider
/*-----------------------------------------------------------------------------------*/
function minti_newdivider_vc() {
	vc_map( array(
		"name" => __( "New Divider", 'minti-framework' ),
		"description" => __( "Divider & Separator", 'minti-framework' ),
		"base" => "minti_newdivider",
		"category" => 'Structure',
		"icon" => "icon-wpb-minti-divider",
		"params" => array(
			array(
				"type" => "dropdown",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Line Style",
				"param_name" => "style",
				"value" => array(
					"Solid" => "solid",
					"Dashed" => "dashed",
					"Dotted" => "dotted",
					"Transparent" => "transparent",
				),
				"description" => "",
			),
			array(
	            "type" => "colorpicker",
	            "admin_label" => false,
	            "class" => "",
	            "heading" => "Line Color",
	            "value" => "#999999",
	            "param_name" => "line_color",
	        ),
			array(
				"type" => "textfield",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Width",
				"param_name" => "width",
				"value" => "100%",
				"save_value" => true,
				"description" => "Width of the separator. Can be px or %. Default: 100%",
			),
			array(
				"type" => "textfield",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Thickness",
				"param_name" => "thickness",
				"value" => "1px",
				"save_value" => true,
				"description" => "Tickness of the separator. Default: 1px",
			),
			array(
				"type" => "textfield",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Top Margin",
				"param_name" => "topmargin",
				"value" => "",
				"save_value" => true,
				"description" => "Top Margin. For example: 20px",
			),
			array(
				"type" => "textfield",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Bottom Margin",
				"param_name" => "bottommargin",
				"value" => "",
				"save_value" => true,
				"description" => "Top Margin. For example: 20px",
			),
			array(
				"type" => "dropdown",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Align",
				"param_name" => "align",
				"value" => array(
					"Center" => "center",
					"Left" => "left",
					"Right" => "right",
				),
				"description" => "",
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_newdivider_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Spacer
/*-----------------------------------------------------------------------------------*/
function minti_spacer_vc() {
	vc_map( array(
		"name"					=> __( "Spacer", 'minti-framework' ),
		"description"			=> __( "Add Spacing to your Blocks", 'minti-framework' ),
		"base"					=> "minti_spacer",
		'category'				=> "Structure",
		"icon"					=> "icon-wpb-minti-spacer",
		"params"				=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Spacer Height", 'minti-framework' ),
				"param_name"	=> "height",
				"value"			=> "40",
				"description"	=> __( "Height in px (leave the 'px' out)", 'minti-framework' )
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_spacer_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Icon
/*-----------------------------------------------------------------------------------*/
function minti_member_vc() {
	vc_map( array(
		"name"					=> __( "Team Member", 'minti-framework' ),
		"description"			=> __( "Show a Member with a picture", 'minti-framework' ),
		"base"					=> "minti_member",
		'category'				=> "Content",
		"icon"					=> "icon-wpb-minti-member",
		"params"				=> array(
			array(
				"type"			=> "attach_image",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Image", 'minti-framework' ),
				"param_name"	=> "img",
				"value"			=> "",
				"description"	=> __( "URL of member image", 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Name", 'minti-framework' ),
				"param_name"	=> "name",
				"value"			=> "",
				"description"	=> __( "Name of the member", 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Role", 'minti-framework' ),
				"param_name"	=> "role",
				"value"			=> "",
				"description"	=> __( "Role of the member", 'minti-framework' ),
			),
			array(
				"type"			=> "textarea_html",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Description", 'minti-framework' ),
				"param_name"	=> "content",
				"value"			=> "",
				"description"	=> __( "Description of the Member", 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "URL", 'minti-framework' ),
				"param_name"	=> "url",
				"value"			=> "",
				"description"	=> __( "Link member image, or leave it blank", 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Facebook", 'minti-framework' ),
				"param_name"	=> "facebook",
				"value"			=> "",
				"description"	=> __( "Facebook URL, or leave it blank", 'minti-framework' ),
				"group"	=> __( 'Social Media', 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Twitter", 'minti-framework' ),
				"param_name"	=> "twitter",
				"value"			=> "",
				"description"	=> __( "Twitter URL, or leave it blank", 'minti-framework' ),
				"group"	=> __( 'Social Media', 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Skype", 'minti-framework' ),
				"param_name"	=> "skype",
				"value"			=> "",
				"description"	=> __( "Skype URL, or leave it blank", 'minti-framework' ),
				"group"	=> __( 'Social Media', 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Google", 'minti-framework' ),
				"param_name"	=> "google",
				"value"			=> "",
				"description"	=> __( "Google URL, or leave it blank", 'minti-framework' ),
				"group"	=> __( 'Social Media', 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "LinkedIn", 'minti-framework' ),
				"param_name"	=> "linkedin",
				"value"			=> "",
				"description"	=> __( "LinkedIn URL, or leave it blank", 'minti-framework' ),
				"group"	=> __( 'Social Media', 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Mail", 'minti-framework' ),
				"param_name"	=> "mail",
				"value"			=> "",
				"description"	=> __( "E-Mail Adress, or leave it blank", 'minti-framework' ),
				"group"	=> __( 'Social Media', 'minti-framework' ),
			),

			
		)
	) );
}
add_action( 'vc_before_init', 'minti_member_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Recent Posts Shortcode
/*-----------------------------------------------------------------------------------*/
function minti_recentposts_vc() {
	vc_map( array(
		"name"					=> __( "Recent Posts Carousel", 'minti-framework' ),
		"description"			=> __( "Add Recent Posts", 'minti-framework' ),
		"base"					=> "minti_recentposts",
		'category'				=> "Post Type",
		"icon"					=> "icon-wpb-minti-blog",
		"params"				=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Number of Posts", 'minti-framework' ),
				"param_name"	=> "posts",
				"value"			=> "6",
				"description"	=> __( "Number of Posts.", 'minti-framework' )
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Categories", 'minti-framework' ),
				"param_name"	=> "categories",
				"value"			=> "all",
				"description"	=> __( "Category Slugs - For example: sports, business, all", 'minti-framework' )
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Style", 'minti-framework' ),
				"param_name"	=> "style",
				"value"			=> array(
					'White' 	=> 'white',
					'Lightgrey' => 'grey',
				)
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_recentposts_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Bloglist Shortcode
/*-----------------------------------------------------------------------------------*/
function minti_bloglist_vc() {
	vc_map( array(
		"name"					=> __( "Bloglist", 'minti-framework' ),
		"description"			=> __( "Add a Bloglist", 'minti-framework' ),
		"base"					=> "minti_bloglist",
		'category'				=> "Post Type",
		"icon"					=> "icon-wpb-minti-bloglist",
		"params"				=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Number of Posts", 'minti-framework' ),
				"param_name"	=> "posts",
				"value"			=> "3",
				"description"	=> __( "Number of Posts. Get always displayed in 3 Columns", 'minti-framework' )
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Categories", 'minti-framework' ),
				"param_name"	=> "categories",
				"value"			=> "all",
				"description"	=> __( "Category Slugs - For example: sports, business, all", 'minti-framework' )
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Layout", 'minti-framework' ),
				"param_name"	=> "layout",
				"value"			=> array(
					'Vertical' => 'vertical',
					'Horizontal' => 'horizontal',
				),
				"description"	=> __( "Info: Horizontal needs to go in an own row.", 'minti-framework' )
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Style", 'minti-framework' ),
				"param_name"	=> "style",
				"value"			=> array(
					'Thumbnail' => 'thumbnail',
					'Date' => 'date',
				),
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_bloglist_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Bloglist Modern Shortcode
/*-----------------------------------------------------------------------------------*/
function minti_bloglistmodern_vc() {
	vc_map( array(
		"name"					=> __( "Bloglist Modern", 'minti-framework' ),
		"description"			=> __( "Add a modern Bloglist", 'minti-framework' ),
		"base"					=> "minti_bloglistmodern",
		'category'				=> "Post Type",
		"icon"					=> "icon-wpb-minti-bloglist",
		"params"				=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Number of Posts", 'minti-framework' ),
				"param_name"	=> "posts",
				"value"			=> "4",
				"description"	=> __( "Number of Posts. Get always displayed in 4 Columns", 'minti-framework' )
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Categories", 'minti-framework' ),
				"param_name"	=> "categories",
				"value"			=> "all",
				"description"	=> __( "Category Slugs - For example: sports, business, all", 'minti-framework' )
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_bloglistmodern_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Portfolio
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists('is_plugin_active')){ include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); } // load is_plugin_active() function if no available
if(is_plugin_active('unicon_portfolio_cpt/unicon_portfolio_cpt.php')){ 

	function minti_portfolio_vc() {

		$portfolio_options = NULL;

		$portfolio_filters = get_terms('portfolio_filter');

		foreach ($portfolio_filters as $filter) {
			$portfolio_options[$filter->name] = $filter->slug;
		}

		vc_map( array(
			"name"					=> __( "Portfolio", 'minti-framework' ),
			"description"			=> __( "Show your Portfolio Items", 'minti-framework' ),
			"base"					=> "minti_portfolio",
			'category'				=> "Post Type",
			"icon"					=> "icon-wpb-minti-portfolio",
			"params"				=> array(
				array(
					"type"			=> "dropdown",
					"admin_label"	=> true,
					"class"			=> "",
					"heading"		=> __( "Style", 'minti-framework' ),
					"param_name"	=> "style",
					"value"			=> array(
						'Default' 	=> 'default',
						'Grid' 		=> 'grid',
						'No Margin' => 'nomargin',
						'Masonry' 	=> 'masonry',
					)
				),
				array(
					"type"			=> "dropdown",
					"admin_label"	=> false,
					"class"			=> "",
					"heading"		=> __( "Column Layout", 'minti-framework' ),
					"param_name"	=> "columns",
					"value"			=> array(
						'2 Columns' => '2',
						'3 Columns' => '3',
						'4 Columns' => '4',
					),
					"description"	=> __( "Only relevant for Portfolio Style 'default' and 'grid'.", 'minti-framework' ),
				),
				array(
					"type"			=> "textfield",
					"admin_label"	=> true,
					"class"			=> "",
					"heading"		=> __( "Projects", 'minti-framework' ),
					"param_name"	=> "projects",
					"value"			=> "8",
					"description"	=> __( "Number of Projects you want to show. Enter -1 to show all Projects.", 'minti-framework' ),
				),
				array(
					"type"			=> "dropdown",
					"admin_label"	=> false,
					"class"			=> "",
					"heading"		=> __( "Pagination?", 'minti-framework' ),
					"param_name"	=> "pagination",
					"value"			=> array(
						'Disable Pagination' => 'no',
						'Enable Pagination' => 'yes',
					),
					"description"	=> __( "", 'minti-framework' ),
				),
				array(
					"type"			=> "checkbox",
					"admin_label"	=> false,
					"class"			=> "",
					"heading"		=> __( "Only Specific Filters?", 'minti-framework' ),
					"param_name"	=> "filters",
					"value"			=> $portfolio_options,
					"description"	=> __( "If nothing is selected, it will show Items from <strong>ALL</strong> filters.", 'minti-framework' ),
				),
				array(
					"type"			=> "dropdown",
					"admin_label"	=> false,
					"class"			=> "",
					"heading"		=> __( "Overlay Style", 'minti-framework' ),
					"param_name"	=> "overlay",
					"value"			=> array(
						'Icon Overlay' => 'icon',
						'Title Overlay' => 'name',
						'Title Effect' => 'effect',
					),
				),
				array(
					"type"			=> "dropdown",
					"admin_label"	=> false,
					"class"			=> "",
					"heading"		=> __( "Show Filters?", 'minti-framework' ),
					"param_name"	=> "showfilter",
					"value"			=> array(
						'Hide Filters' => 'no',
						'Show Filter' => 'yes',
					),
					"description"	=> __( "<strong>IMPORTANT:</strong> Please make sure to set the Row to 'Full Width Section.'", 'minti-framework' ),
				),
			)
		) );
	}
	add_action( 'vc_before_init', 'minti_portfolio_vc' );

}

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Pricing Plan
/*-----------------------------------------------------------------------------------*/
function minti_pricingplan_vc() {
	vc_map( array(
		"name"					=> __( "Pricing Plan", 'minti-framework' ),
		"description"			=> __( "Add a Pricing Plan", 'minti-framework' ),
		"base"					=> "minti_pricingplan",
		'category'				=> "Content",
		"icon"					=> "icon-wpb-minti-pricingplan",
		"params"				=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Plan Name", 'minti-framework' ),
				"param_name"	=> "name",
				"value"			=> "",
				"description"	=> __( "Name of the Plan", 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Link", 'minti-framework' ),
				"param_name"	=> "link",
				"value"			=> "",
				"description"	=> __( "Link of the Sign Up Button - leave empty if you don not want a Sign Up Button", 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Link Name", 'minti-framework' ),
				"param_name"	=> "linkname",
				"value"			=> "",
				"description"	=> __( "Name of the Link", 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Price", 'minti-framework' ),
				"param_name"	=> "price",
				"value"			=> "$59.00",
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Per", 'minti-framework' ),
				"param_name"	=> "per",
				"value"			=> "",
				"description"	=> __( "month, year, ... or leave empty", 'minti-framework' ),
			),
			array(
				"type"			=> "colorpicker",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Color", 'minti-framework' ),
				"param_name"	=> "color",
				"value"			=> "",
				"description"	=> __( "Can be any Color. Leave empty for white", 'minti-framework' ),
			),
			array(
				"type"			=> "textarea_html",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Content", 'minti-framework' ),
				"param_name"	=> "content",
				"value"			=> "<ul><li>Lorem Ipsum</li><li>Lorem Ipsum</li><li>Lorem Ipsum</li></ul>",
				"description"	=> __( "Use the 'Unordered List' button on the editor to add the Pricing Plan values.", 'minti-framework' ),
			),
		)
	) );

}
add_action( 'vc_before_init', 'minti_pricingplan_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Progress Bar
/*-----------------------------------------------------------------------------------*/
function minti_progressbar_vc() {
	vc_map( array(
		"name"					=> __( "Progress Bar", 'minti-framework' ),
		"description"			=> __( "Add a Progress Bar", 'minti-framework' ),
		"base"					=> "minti_progressbar",
		'category'				=> "Content",
		"icon"					=> "icon-wpb-minti-progressbar",
		"params"				=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Title", 'minti-framework' ),
				"param_name"	=> "title",
				"value"			=> "",
				"description"	=> __( "Title of the Skillbar (e.g. Photoshop)", 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Percentage", 'minti-framework' ),
				"param_name"	=> "percentage",
				"value"			=> "",
				"description"	=> __( "Percentage 0-100 (without %)", 'minti-framework' ),
			),
			array(
				"type"			=> "colorpicker",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Color", 'minti-framework' ),
				"param_name"	=> "color",
				"value"			=> "#999999",
				"description"	=> __( "Color of the Skillbar", 'minti-framework' ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_progressbar_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Testimonial
/*-----------------------------------------------------------------------------------*/
function minti_testimonial_vc() {
	vc_map( array(
		"name"					=> __( "Testimonial", 'minti-framework' ),
		"description"			=> __( "What your Clients say", 'minti-framework' ),
		"base"					=> "minti_testimonial",
		'category'				=> "Content",
		"icon"					=> "icon-wpb-minti-testimonial",
		"params"				=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Author", 'minti-framework' ),
				"param_name"	=> "author",
				"value"			=> "",
				"description"	=> __( "Author of the Testimonial", 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Company", 'minti-framework' ),
				"param_name"	=> "company",
				"value"			=> "",
				"description"	=> __( "Company of the Author", 'minti-framework' ),
			),
			array(
				"type"			=> "textarea_html",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Content", 'minti-framework' ),
				"param_name"	=> "content",
				"value"			=> "",
			),
			array(
				"type"			=> "attach_image",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Image", 'minti-framework' ),
				"param_name"	=> "img",
				"value"			=> "",
				"description"	=> __( "Upload your Image here.", 'minti-framework' ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_testimonial_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Testimonial Slider
/*-----------------------------------------------------------------------------------*/
function minti_testimonialslider_vc() {
	vc_map( array(
		"name"					=> __( "Testimonial Slider", 'minti-framework' ),
		"description"			=> __( "What your Clients say", 'minti-framework' ),
		"base"					=> "minti_testimonialslider",
		'category'				=> "Content",
		"icon"					=> "icon-wpb-minti-testimonial",
		"params"				=> array(
			array(
				"type"			=> "textarea",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Testimonial #1", 'minti-framework' ),
				"param_name"	=> "testimonial_1",
				"value"			=> "",
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Author #1", 'minti-framework' ),
				"param_name"	=> "author_1",
				"value"			=> "",
			),
			array(
				"type"			=> "textarea",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Testimonial #2", 'minti-framework' ),
				"param_name"	=> "testimonial_2",
				"value"			=> "",
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Author #2", 'minti-framework' ),
				"param_name"	=> "author_2",
				"value"			=> "",
			),
			array(
				"type"			=> "textarea",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Testimonial #3", 'minti-framework' ),
				"param_name"	=> "testimonial_3",
				"value"			=> "",
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Author #3", 'minti-framework' ),
				"param_name"	=> "author_3",
				"value"			=> "",
			),
			array(
				"type"			=> "textarea",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Testimonial #4", 'minti-framework' ),
				"param_name"	=> "testimonial_4",
				"value"			=> "",
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Author #4", 'minti-framework' ),
				"param_name"	=> "author_4",
				"value"			=> "",
			),
			array(
				"type"			=> "textarea",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Testimonial #5", 'minti-framework' ),
				"param_name"	=> "testimonial_5",
				"value"			=> "",
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Author #5", 'minti-framework' ),
				"param_name"	=> "author_5",
				"value"			=> "",
			),
			array(
				"type"			=> "textarea",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Testimonial #6", 'minti-framework' ),
				"param_name"	=> "testimonial_6",
				"value"			=> "",
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Author #6", 'minti-framework' ),
				"param_name"	=> "author_6",
				"value"			=> "",
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_testimonialslider_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Headline
/*-----------------------------------------------------------------------------------*/
function minti_headline_vc() {
	vc_map( array(
		"name"					=> __( "Headline", 'minti-framework' ),
		"description"			=> __( "Insert a Custom Headline", 'minti-framework' ),
		"base"					=> "minti_headline",
		'category'				=> "Text",
		"icon"					=> "icon-wpb-minti-headline",
		"params"				=> array(
			array(
				"type"			=> "textarea",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Content", 'minti-framework' ),
				"param_name"	=> "content",
				"value"			=> "",
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Headline Type", 'minti-framework' ),
				"param_name"	=> "type",
				"value"			=> array(
					'h1' => 'h1',
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'h6' => 'h6',
					'Normal Text' => 'div',
				),
				"description"	=> __( "This is for SEO purposes and does not set the size (i.e. you can have an h1 that is small or an h6 that displays large)", 'minti-framework' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Custom Font", 'minti-framework' ),
				"param_name"	=> "font",
				"value"			=> array(
					'Standard Headline Font' => 'font-inherit',
					'Special Font' => 'font-special',
				),
				"description"	=> __( "Headline Font & Special Font can be defined in Theme Options", 'minti-framework' ),
				"group"	=> __( 'Custom Styling', 'minti-framework' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Custom Font Size", 'minti-framework' ),
				"param_name"	=> "size",
				"value"			=> array(
					'Default' 		=> 'fontsize-inherit',
					'Extra Small' 	=> 'fontsize-xs',
					'Small' 		=> 'fontsize-s',
					'Medium' 		=> 'fontsize-m',
					'Large' 		=> 'fontsize-l',
					'Extra Large' 	=> 'fontsize-xl',
					'XXL' 			=> 'fontsize-xxl',
					'XXXL' 			=> 'fontsize-xxxl',
					'XXXXL' 			=> 'fontsize-xxxxl',
					'XXXXXL' 			=> 'fontsize-xxxxxl',
				),
				"description"	=> __( "Customize the Font Size or leave it at default (defined in Theme Options)", 'minti-framework' ),
				"group"	=> __( 'Custom Styling', 'minti-framework' ),
			),
			array(
				"type"			=> "colorpicker",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Custom Font Color", 'minti-framework' ),
				"param_name"	=> "color",
				"value"			=> "",
				"description"	=> __( "Choose a custom Font Color or leave it at default (defined in Theme Options)", 'minti-framework' ),
				"group"	=> __( 'Custom Styling', 'minti-framework' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Custom Font Weight", 'minti-framework' ),
				"param_name"	=> "weight",
				"value"			=> array(
					'Default' => 'fontweight-inherit',
					'Font Weight 300' => 'fontweight-300',
					'Font Weight 400' => 'fontweight-400',
					'Font Weight 500' => 'fontweight-500',
					'Font Weight 600' => 'fontweight-600',
					'Font Weight 700' => 'fontweight-700',
					'Font Weight 800' => 'fontweight-800',
					'Font Weight 900' => 'fontweight-900',
				),
				"description"	=> __( "Choose a custom Font Weight or leave it at default (defined in Theme Options)", 'minti-framework' ),
				"group"	=> __( 'Custom Styling', 'minti-framework' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Custom Line Height", 'minti-framework' ),
				"param_name"	=> "lineheight",
				"value"			=> array(
					'Default' 		=> 'lh-inherit',
					'Line-Height 1.2' 	=> 'lh-12',
					'Line-Height 1.3' 	=> 'lh-13',
					'Line-Height 1.4' 	=> 'lh-14',
					'Line-Height 1.5' 	=> 'lh-15',
					'Line-Height 1.6' 	=> 'lh-16',
					'Line-Height 1.7' 	=> 'lh-17',
					'Line-Height 1.8'   => 'lh-18',
					'Line-Height 1.9' 	=> 'lh-19',
					'Line-Height 2.0' 	=> 'lh-20',
				),
				"description"	=> __( "For Large Fonts over more than 2 lines you might want to define that value", 'minti-framework' ),
				"group"	=> __( 'Custom Styling', 'minti-framework' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Custom Text Transform", 'minti-framework' ),
				"param_name"	=> "transform",
				"value"			=> array(
					'Default' => 'transform-inherit',
					'Uppercase' => 'transform-uppercase',
				),
				"group"	=> __( 'Custom Styling', 'minti-framework' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Text Align", 'minti-framework' ),
				"param_name"	=> "align",
				"value"			=> array(
					'Center' => 'align-center',
					'Left' => 'align-left',
					'Right' => 'align-right',
				),
				"group"	=> __( 'Layout', 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Margin", 'minti-framework' ),
				"param_name"	=> "margin",
				"value"			=> "0 0 20px 0",
				"description"	=> __( "Margin - topmargin rightmargin bottommargin leftmargin. Default: 0 0 20px 0", 'minti-framework' ),
				"group"	=> __( 'Layout', 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Extra Class", 'minti-framework' ),
				"param_name"	=> "class",
				"value"			=> "",
				"description"	=> __( "Add your own class and refer to it in your CSS file.", 'minti-framework' ),
				"group"	=> __( 'Layout', 'minti-framework' ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_headline_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Title
/*-----------------------------------------------------------------------------------*/
function minti_title_vc() {
	vc_map( array(
		"name"					=> __( "Text Separator", 'minti-framework' ),
		"description"			=> __( "A horizontal Separator Line with Text", 'minti-framework' ),
		"base"					=> "minti_title",
		'category'				=> "Text",
		"icon"					=> "icon-wpb-minti-title",
		"params"				=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Content", 'minti-framework' ),
				"param_name"	=> "content",
				"value"			=> "",
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Text Align", 'minti-framework' ),
				"param_name"	=> "align",
				"value"			=> array(
					'Center' => 'center',
					'Left' => 'left',
				),
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_title_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Google Maps
/*-----------------------------------------------------------------------------------*/
function minti_googlemaps_vc() {
	vc_map( array(
		"name"					=> __( "Google Maps", 'minti-framework' ),
		"description"			=> __( "Google Maps", 'minti-framework' ),
		"base"					=> "minti_googlemaps",
		'category'				=> "Content",
		"icon"					=> "icon-wpb-minti-googlemaps",
		"params"				=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Address", 'minti-framework' ),
				"param_name"	=> "address",
				"value"			=> "",
				"description"	=> __( "Insert valid address string", 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Latitude", 'minti-framework' ),
				"param_name"	=> "lat",
				"value"			=> "",
				"description"	=> __( "For exact positioning you can use Lat & Long INSTEAD OF the address field.<br />Note: Does not work with a custom Marker Image", 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Longitude", 'minti-framework' ),
				"param_name"	=> "lon",
				"value"			=> "",
				"description"	=> __( "For exact positioning you can use Lat & Long INSTEAD OF the address field.<br />Note: Does not work with a custom Marker Image", 'minti-framework' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Map Style", 'minti-framework' ),
				"param_name"	=> "style",
				"value"			=> array(
					'With Border' => 'full',
					'Without Border' => 'fullsection',
				),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Height", 'minti-framework' ),
				"param_name"	=> "h",
				"value"			=> "300",
				"description"	=> __( "Height of the Map in px (leave the 'px' out)", 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Map ID", 'minti-framework' ),
				"param_name"	=> "id",
				"value"			=> "",
				"description"	=> __( "Unique Map ID (map1, map2,.. if you use multiple maps on one page)", 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Zoom Level", 'minti-framework' ),
				"param_name"	=> "z",
				"value"			=> "14",
				"description"	=> __( "Value between 1-21. Higher number = more zoomed in.", 'minti-framework' ),
				"group"	=> __( 'Options', 'minti-framework' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Map Type", 'minti-framework' ),
				"param_name"	=> "maptype",
				"value"			=> array(
					'Roadmap' => 'ROADMAP',
					'Satellite' => 'SATELLITE',
					'Hybrid' => 'HYBRID',
					'Terrain' => 'TERRAIN',
				),
				"description"	=> __( "Desired map type", 'minti-framework' ),
				"group"	=> __( 'Options', 'minti-framework' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Marker", 'minti-framework' ),
				"param_name"	=> "marker",
				"value"			=> array(
					'Show Marker' => 'yes',
					'Hide Marker' => '',
				),
				"description"	=> __( "Select if you want to show a marker", 'minti-framework' ),
				"group"	=> __( 'Marker', 'minti-framework' ),
			),
			array(
				"type"			=> "attach_image",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Marker Image", 'minti-framework' ),
				"param_name"	=> "markerimage",
				"value"			=> "",
				"description"	=> __( "If you want to use a Marker Image you can upload it here.", 'minti-framework' ),
				"group"	=> __( 'Marker', 'minti-framework' ),
			),
			array(
				"type"			=> "textarea",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Infowindow", 'minti-framework' ),
				"param_name"	=> "infowindow",
				"value"			=> "",
				"description"	=> __( "Text to add to the Infowindow", 'minti-framework' ),
				"group"	=> __( 'Marker', 'minti-framework' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Show Infowindow", 'minti-framework' ),
				"param_name"	=> "infowindowdefault",
				"value"			=> array(
					'Show Info Window on load' => 'yes',
					'Hide Info Window on load' => 'no',
				),
				"description"	=> __( "Choose to have the infowindow show or not show automatically when the page loads", 'minti-framework' ),
				"group"	=> __( 'Marker', 'minti-framework' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Scrollwheel Zoom", 'minti-framework' ),
				"param_name"	=> "scrollwheel",
				"value"			=> array(
					'Enable Scrollwheel Zoom' => 'true',
					'Disable Scrollwheel Zoom' => 'false',
				),
				"description"	=> __( "Allow scroll wheel zooming", 'minti-framework' ),
				"group"	=> __( 'Options', 'minti-framework' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Controls", 'minti-framework' ),
				"param_name"	=> "hidecontrols",
				"value"			=> array(
					'Show Controls' => 'false',
					'Hide Controls' => 'true',
				),
				"description"	=> __( "Show / Hide Map Controls", 'minti-framework' ),
				"group"	=> __( 'Options', 'minti-framework' ),
			),
			array(
				"type"			=> "textarea_raw_html",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Color Scheme Code", 'minti-framework' ),
				"param_name"	=> "colorscheme",
				"value"			=> "",
				"description"	=> __( "<strong>For advanced users:</strong> Paste your snazzymaps.com styles here.", 'minti-framework' ),
				"group"	=> __( 'Options', 'minti-framework' ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_googlemaps_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Video
/*-----------------------------------------------------------------------------------*/
function minti_video_vc() {
	vc_map( array(
		"name"					=> __( "Embed Video", 'minti-framework' ),
		"description"			=> __( "Embed Youtube, Vimeo Player", 'minti-framework' ),
		"base"					=> "minti_video",
		'category'				=> "Content",
		"icon"					=> "icon-wpb-minti-video",
		"params"				=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Content", 'minti-framework' ),
				"param_name"	=> "content",
				"value"			=> "",
				"description"	=> __( "URL to the video. <a href='http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F' target='_blank'>Supported Video Sites</a>", 'minti-framework' ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_video_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Single Image
/*-----------------------------------------------------------------------------------*/
function minti_image_vc() {
	vc_map( array(
		"name"					=> __( "Single Image", 'minti-framework' ),
		"description"			=> __( "Insert a single Image", 'minti-framework' ),
		"base"					=> "minti_image",
		'category'				=> "Content",
		"icon"					=> "icon-wpb-minti-image",
		"params"				=> array(
			array(
				"type"			=> "attach_image",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Image", 'minti-framework' ),
				"param_name"	=> "img",
				"value"			=> "",
				"description"	=> __( "Upload your Image here.", 'minti-framework' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "On Click Action", 'minti-framework' ),
				"param_name"	=> "lightbox",
				"value"			=> array(
					'None' => 'none',
					'Open in Lightbox' => '1',
					'Open external URL' => '2',
				),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "URL", 'minti-framework' ),
				"param_name"	=> "url",
				"value"			=> "",
				"dependency" => Array('element' => "lightbox", 'value' => array('1', '2')),
				"description"	=> __( "If Click Action = Lightbox, you can leave this blank to open the image above or link to an external image.", 'minti-framework' )
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Target", 'minti-framework' ),
				"param_name"	=> "target",
				"value"			=> array(
					'Open same Window' => '_self',
					'Open new Window' => '_blank',
				),
				"dependency" => Array('element' => "lightbox", 'value' => array('2')),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Image Size", 'minti-framework' ),
				"param_name"	=> "img_size",
				"value"			=> "full",
				"description"	=> __( "Enter image size. For example: thumbnail, medium, large, full. Alternatively enter size in pixels - example: 200x100 (Width x Height). Default = full (image size as uploaded).", 'minti-framework' ),
				"group"	=> __( 'Options', 'minti-framework' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Align", 'minti-framework' ),
				"param_name"	=> "align",
				"value"			=> array(
					'Left' => 'left',
					'Center' => 'center',
					'Right' => 'right',
				),
				"group"	=> __( 'Options', 'minti-framework' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Style", 'minti-framework' ),
				"param_name"	=> "style",
				"value"			=> array(
					'Default / None' => '',
					'Rounded' => 'image_box_rounded',
					'Border' => 'image_box_border',
					'Shadow' => 'image_box_shadow',
					'Circle' => 'image_box_circle',
					'Circle Border' => 'image_box_circle image_box_border',
					'Circle Shadow' => 'image_box_circle image_box_shadow',
				),
				"group"	=> __( 'Options', 'minti-framework' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Image Hover Effect", 'minti-framework' ),
				"param_name"	=> "hover",
				"value"			=> array(
					'Default / None' => '',
					'Greyscale' => 'image_greyscale',
					'Opacity' => 'image_opacity',
					'Zoom' => 'image_zoom',
					'Zoom Out' => 'image_zoomout',
					'Tilt' => 'image_tilt',
				),
				"group"	=> __( 'Options', 'minti-framework' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Fade in Animation", 'minti-framework' ),
				"param_name"	=> "animation",
				"value"			=> array(
					"None" => "none",
				    "Fade In" => "fade-in",
			  		"Fade In From Left" => "fade-in-from-left",
			  		"Fade In From Right" => "fade-in-from-right",
			  		"Fade In From Bottom" => "fade-in-from-bottom",
			  		"Fade In From Top" => "fade-in-from-top"
				),
				"group"	=> __( 'Options', 'minti-framework' ),
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Animation Delay", 'minti-framework' ),
				"param_name"	=> "delay",
				"value"			=> "0",
				"dependency" => Array('element' => "animation", 'value' => array('fade-in', 'fade-in-from-left', 'fade-in-from-right', 'fade-in-from-bottom', 'fade-in-from-top')),
				"description"	=> __( "Delay before the image animates in miliseconds. For example: 300", 'minti-framework' ),
				"group"	=> __( 'Options', 'minti-framework' ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_image_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Gallery
/*-----------------------------------------------------------------------------------*/
function minti_gallery_vc() {
	vc_map( array(
		"name"					=> __( "Gallery", 'minti-framework' ),
		"description"			=> __( "Gallery", 'minti-framework' ),
		"base"					=> "minti_gallery",
		'category'				=> "Content",
		"icon"					=> "icon-wpb-minti-gallery",
		"params"				=> array(
			array(
				"type"			=> "attach_images",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Gallery Images", 'minti-framework' ),
				"param_name"	=> "ids",
				"value"			=> "",
				"description"	=> __( "Upload your Images here.", 'minti-framework' ),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Link To", 'minti-framework' ),
				"param_name"	=> "link",
				"value"			=> array(
					'Lightbox Image' => 'file',
					'None' => 'none',
				),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Columns", 'minti-framework' ),
				"param_name"	=> "columns",
				"value"			=> array(
					"1" => "1",
				    "2" => "2",
			  		"3" => "3",
			  		"4" => "4",
			  		"5" => "5",
			  		"6" => "6",
				    "7" => "7",
			  		"8" => "8",
			  		"9" => "9",
				),
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Gallery Style", 'minti-framework' ),
				"param_name"	=> "style",
				"value"			=> array(
					"No Margins" => "1",
				    "With Margins" => "2",
				),
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_gallery_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Image Slider
/*-----------------------------------------------------------------------------------*/
function minti_imageslider_vc() {
	vc_map( array(
		"name"					=> __( "Image Slider", 'minti-framework' ),
		"description"			=> __( "Image Slider", 'minti-framework' ),
		"base"					=> "minti_imageslider",
		'category'				=> "Content",
		"icon"					=> "icon-wpb-minti-gallery",
		"params"				=> array(
			array(
				"type"			=> "attach_images",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Slider Images", 'minti-framework' ),
				"param_name"	=> "ids",
				"value"			=> "",
				"description"	=> __( "Upload your Images here. For a smooth sliding experience they all should have the same size.", 'minti-framework' ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_imageslider_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Toggle
/*-----------------------------------------------------------------------------------*/
function minti_toggle_vc() {
	vc_map( array(
		"name"					=> __( "Toggle", 'minti-framework' ),
		"description"			=> __( "Toggle Content Element", 'minti-framework' ),
		"base"					=> "minti_toggle",
		'category'				=> "Content",
		"icon"					=> "icon-wpb-minti-toggle",
		"params"				=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> __( "Title", 'minti-framework' ),
				"param_name"	=> "title",
				"value"			=> "",
				"description"	=> __( "Title of the Toggle", 'minti-framework' )
			),
			array(
				"type"			=> "textarea_html",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Content", 'minti-framework' ),
				"param_name"	=> "content",
				"value"			=> "Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.",
			),
			array(
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Open / Closed", 'minti-framework' ),
				"param_name"	=> "open",
				"value"			=> array(
					'Closed on load' => 'false',
					'Open on load' => 'true',
				),
				"description"	=> __( "Select if the Toggle should be open or closed on load", 'minti-framework' )
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> __( "Icon", 'minti-framework' ),
				"param_name"	=> "icon",
				"value"			=> "",
				"description"	=> __( "Can be any Fontawesome Icon (ie. fa-phone)", 'minti-framework' ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'minti_toggle_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Unordered List
/*-----------------------------------------------------------------------------------*/
function minti_list_vc() {
	vc_map( array(
		"name" => __( "List", 'minti-framework' ),
		"description" => __( "Unordered List Element", 'minti-framework' ),
		"base" => "minti_unordered_list",
		"icon" => "icon-wpb-minti-list",
		"category" => 'Content',
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "dropdown",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Style",
				"param_name" => "style",
				"value" => array(
					"Circle" => "circle",
					"Point" => "point",
					"Arrow"	 => "arrow",
					"Circle Arrow"	 => "circlearrow",
					"Dot Circle"	 => "dotcircle",
					"Plus"	 => "plus",
					"Thumb"	 => "thumb",
					"Line"	 => "line",
					"Checkbox"	 => "checkbox"
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Icon Color",
				"param_name" => "color",
				"value" => array(
					"Greyscale" => "grey",
					"Accent Color" => "accent",
				),
				"description" => ""
			),
			array(
				"type" => "textfield",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Padding left",
				"param_name" => "padding_left",
				"value" => "",
				"description" => "For example: 40px",
			),
			array(
				"type" => "dropdown",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Show Separator",
				"param_name" => "show_separator",
				"value" => array(
					"No" => "no",
					"Yes" => "yes"
				),
				"save_always" => true
			),
			array(
				"type" => "textarea_html",
				"admin_label"	=> true,
				"class" => "",
				"heading" => "Content",
				"param_name" => "content",
				"value" => "<ul><li>Lorem Ipsum</li><li>Lorem Ipsum</li><li>Lorem Ipsum</li></ul>",
				"description" => ""
			)
		)
	) );
}
add_action( 'vc_before_init', 'minti_list_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Blog Slider
/*-----------------------------------------------------------------------------------*/
function minti_blog_slider_vc() {
	vc_map( array(
		"name" => __( "Blog Slider", 'minti-framework' ),
		"description" => __( "Blog Slider Element", 'minti-framework' ),
		"base" => "minti_blog_slider",
		"category" => 'Content',
		"icon" => "icon-wpb-minti-blog",
		"params" => array(
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => "Title Tag",
				"param_name" => "title_tag",
				"value" => array(
					"h1"   => "h1",
					"h2" => "h2",
					"h3" => "h3",
					"h4" => "h4",
					"h5" => "h5",
					"h6" => "h6",
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Show Date",
				"param_name" => "show_date",
				"value" => array(
					"Yes" => "yes",
					"No"  => "no"
				),
				"description" => ""
			),
	        array(
			    "type" => "dropdown",
			    "admin_label"	=> false,
			    "class" => "",
			    "heading" => "Automatically change slides",
			    "param_name" => "blog_slide",
			    "value" => array(
				    "Yes" => "yes",
				    "No"  => "no"
			    ),
			    "save_always" => true,
			    "description" => "'Yes' to enable automatic changing of slides, otherwise slides will change only by clicking."
		    ),
			array(
				"type" => "textfield",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Set slide animation time",
				"param_name" => "animation_time",
				"value" => "4000",
				"description" => "Set the time between slide changes in miliseconds. Default: 4000",
				"dependency" => Array('element' => "blog_slide", 'value' => array('yes'))
			),
			array(
				"type" => "dropdown",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Order By",
				"param_name" => "order_by",
				"value" => array(
					"Date" => "date",
					"Title" => "title",
				),
				"description" => "",
				"group"	=> __( 'Post Options', 'minti-framework' ),
			),
			array(
				"type" => "dropdown",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Order",
				"param_name" => "order",
				"value" => array(
					"DESC" => "DESC",
					"ASC" => "ASC",
				),
				"description" => "",
				"group"	=> __( 'Post Options', 'minti-framework' ),
			),
			array(
				"type" => "textfield",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Number",
				"param_name" => "number",
				"value" => "-1",
				"save_value" => true,
				"description" => "Number of blog posts (-1 for all)",
				"group"	=> __( 'Post Options', 'minti-framework' ),
			),
			array(
				"type" => "textfield",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Category",
				"param_name" => "category",
				"value" => "",
				"description" => "Category Slug (leave empty for all)",
				"group"	=> __( 'Post Options', 'minti-framework' ),
			),
			array(
				"type" => "textfield",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Selected Posts",
				"param_name" => "selected_posts",
				"value" => "",
				"description" => "Selected Posts (leave empty for all, delimit by comma)",
				"group"	=> __( 'Post Options', 'minti-framework' ),
			)
		)
	) );
}
add_action( 'vc_before_init', 'minti_blog_slider_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Zooming Slider
/*-----------------------------------------------------------------------------------*/
class WPBakeryShortCode_Minti_Zooming_Slider extends WPBakeryShortCodesContainer {}
vc_map( array(
	"name" => __( "Zooming Slider", 'minti-framework' ),
	"description" => __( "3D Zooming Slider", 'minti-framework' ),
	"base" => "minti_zooming_slider",
	"category" => 'Content',
	"icon" => "icon-wpb-minti-zooming_slider",
	"as_parent" => array('only' => 'minti_zooming_slider_item'),
	"content_element" => true,
	"js_view" => 'VcColumnView',
	"params" => array(
		array(
			"type" => "textfield",
			"admin_label"	=> false,
			"class" => "",
			"value" => "",
			"heading" => "Custom Class",
			"param_name" => "customclass",
			"description"	=> __( "Add your own class and refer to it in your CSS file.", 'minti-framework' ),
		),
	)
) );

class WPBakeryShortCode_Minti_Zooming_Slider_Item extends WPBakeryShortCode {}
vc_map( array(
	"name" => __( "Zooming Slider Item", 'minti-framework' ),
	"base" => "minti_zooming_slider_item",
	"icon" => "icon-wpb-minti-zooming_slider",
	"as_child" => array('only' => 'minti_zooming_slider'),
	"params" => array(
		array(
			"type" => "attach_image",
			"admin_label"	=> false,
			"class" => "",
			"value" => "",
			"heading" => "Image",
			"param_name" => "image",
		),
		array(
			"type" => "textfield",
			"admin_label"	=> true,
			"class" => "",
			"value" => "",
			"heading" => "Title",
			"param_name" => "title",
		),
		array(
			"type" => "textfield",
			"admin_label"	=> false,
			"class" => "",
			"value" => "",
			"heading" => "Image Link",
			"param_name" => "image_link",
			"description" => __( "URL you want to link the Image to.", 'minti-framework' ),
		),
		array(
			"type" => "dropdown",
			"admin_label"	=> false,
			"class" => "",
			"heading" => "Link Target",
			"param_name" => "image_link_target",
			"value" => array(
				"Same Window" => "_self",
				"New Window" => "_blank"
			),
			"save_always" => true,
		),
	)
) );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Carousel
/*-----------------------------------------------------------------------------------*/
class WPBakeryShortCode_Minti_Carousel extends WPBakeryShortCodesContainer {}
vc_map( array(
	"name" => __( "Carousel", 'minti-framework' ),
	"description" => __( "Universal Carousel Element", 'minti-framework' ),
	"base" => "minti_carousel",
	"category" => 'Content',
	"icon" => "icon-wpb-minti-carousel",
	"as_parent" => array('only' => 'vc_column_text, minti_category_image, minti_box, minti_iconbox, minti_imagebox, minti_counter, minti_member, minti_pricingplan, minti_testimonial, minti_video, minti_image, minti_unordered_list'),
	"content_element" => true,
	"js_view" => 'VcColumnView',
	"params" => array(
		array(
			"type" => "textfield",
			"admin_label"	=> false,
			"class" => "",
			"value" => "3",
			"heading" => "Columns",
			"description" => "Define columns per scrollable container. Default: 3",
			"param_name" => "columns",
		),
		array(
			"type" => "textfield",
			"admin_label"	=> false,
			"class" => "",
			"value" => "3",
			"heading" => "Tablet Columns",
			"description" => "Define columns per scrollable container in responsive Tablet Mode. Default: 3",
			"param_name" => "tabletcolumns",
		),
		array(
			"type" => "dropdown",
			"admin_label"	=> false,
			"class" => "",
			"heading" => "Show Navigation Arrows",
			"value" => array(
				"Yes" => "true",
				"No" => "false"
			),
			"description" => "",
			"param_name" => "nav",
		),
		array(
			"type" => "dropdown",
			"admin_label"	=> false,
			"class" => "",
			"heading" => "Show Pagination",
			"value" => array(
				"Yes" => "true",
				"No" => "false"
			),
			"description" => "",
			"param_name" => "pagination",
		),
		array(
			"type" => "dropdown",
			"admin_label"	=> false,
			"class" => "",
			"heading" => "Pagination Style",
			"value" => array(
				"Dot Pagination (centered)" => "pagination_dots",
				"Numbered Pagination (left)" => "pagination_numbers"
			),
			"description" => "",
			"param_name" => "pagination_style",
			"dependency" => Array('element' => "pagination", 'value' => array('true'))
		),
		array(
			"type" => "dropdown",
			"admin_label"	=> false,
			"class" => "",
			"heading" => "Autoplay?",
			"value" => array(
				"No" => "false",
				"Yes" => "true",
			),
			"description" => "'Yes' to enable automatic changing of slides, otherwise slides will only change by click.",
			"param_name" => "autoplay",
		),
		array(
			"type" => "textfield",
			"admin_label"	=> false,
			"class" => "",
			"heading" => "Set slide animation time",
			"param_name" => "animationtime",
			"value" => "4000",
			"description" => "Set the time between slide changes in miliseconds. Default: 4000",
			"dependency" => Array('element' => "autoplay", 'value' => array('true'))
		),
		array(
			"type" => "dropdown",
			"admin_label"	=> false,
			"class" => "",
			"heading" => "Force Grab Icon",
			"value" => array(
				"No" => "false",
				"Yes" => "true"
			),
			"description" => "Force Grab icon for the complete section.",
			"param_name" => "grabicon",
		),
		array(
			"type" => "textfield",
			"admin_label"	=> false,
			"class" => "",
			"value" => "",
			"heading" => "Custom Class",
			"param_name" => "customclass",
			"description"	=> __( "Add your own class and refer to it in your CSS file.", 'minti-framework' ),
		),
	)
) );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Boxed Holder
/*-----------------------------------------------------------------------------------*/
class WPBakeryShortCode_Minti_Boxedholder extends WPBakeryShortCodesContainer {}
vc_map( array(
	"name" => __( "Boxed Element Holder", 'minti-framework' ),
	"description" => __( "Boxed Element Holder", 'minti-framework' ),
	"base" => "minti_boxedholder",
	"category" => 'Content',
	"icon" => "icon-wpb-minti-boxedholder",
	"as_parent" => array('except' => 'vc_row'),
	"content_element" => true,
	"js_view" => 'VcColumnView',
	"params" => array(
		array(
			"type" => "textfield",
			"admin_label" => false,
			"class" => "",
			"value" => "0px 0px 0px 0px",
			"heading" => "Padding",
			"description" => "Set padding in format: 40px 40px 40px 40px",
			"param_name" => "padding",
		),
		array(
			"type" => "textfield",
			"admin_label" => false,
			"class" => "",
			"value" => "0px 0px 0px 0px",
			"heading" => "Margin",
			"description" => "Set margin in format: 40px 40px 40px 40px",
			"param_name" => "margin",
		),
		array(
            "type" => "colorpicker",
            "admin_label" => false,
            "class" => "",
            "heading" => "Background Color",
            "param_name" => "background_color",
        ),
        array(
			"type" => "textfield",
			"admin_label" => false,
			"class" => "",
			"value" => "",
			"heading" => "Border Radius",
			"description" => "",
			"param_name" => "border_radius",
			"description" => "Set border radius (rounded corners). For example: 4px",
		),
		array(
			"type" => "textfield",
			"admin_label" => false,
			"class" => "",
			"value" => "",
			"heading" => "Border Width",
			"description" => "",
			"param_name" => "border_width",
			"description" => "Set border width. For example: 4px",
		),
		array(
            "type" => "colorpicker",
            "admin_label" => false,
            "class" => "",
            "heading" => "Border Color",
            "param_name" => "border_color",
        ),
		array(
			"type" => "dropdown",
			"admin_label"	=> false,
			"class" => "",
			"heading" => "Text Color",
			"value" => array(
				"Dark (default)" => "",
				"Light" => "color-light"
			),
			"description" => "",
			"param_name" => "colorscheme",
		),
		array(
			"type" => "textfield",
			"admin_label"	=> false,
			"class" => "",
			"value" => "",
			"heading" => "Custom Class",
			"param_name" => "customclass",
			"description"	=> __( "Add your own class and refer to it in your CSS file.", 'minti-framework' ),
		),
	)
) );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Blog
/*-----------------------------------------------------------------------------------*/
function minti_blog_vc() {
	vc_map( array(
		"name" => __( "Blog", 'minti-framework' ),
		"description" => __( "Blog Element", 'minti-framework' ),
		"base" => "minti_blog",
		"category" => 'Content',
		"icon" => "icon-wpb-minti-blog",
		"params" => array(
			array(
				"type" => "dropdown",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Style",
				"param_name" => "style",
				"value" => array(
					"Medium" => "medium",
					"Large" => "large",
				),
				"description" => "",
			),
			array(
				"type" => "dropdown",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Order By",
				"param_name" => "order_by",
				"value" => array(
					"Date" => "date",
					"Title" => "title",
				),
				"description" => "",
			),
			array(
				"type" => "dropdown",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Order",
				"param_name" => "order",
				"value" => array(
					"DESC" => "DESC",
					"ASC" => "ASC",
				),
				"description" => "",
			),
			array(
				"type" => "textfield",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Number",
				"param_name" => "number",
				"value" => "-1",
				"save_value" => true,
				"description" => "Number of blog posts (-1 for all)",
			),
			array(
				"type" => "textfield",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Category",
				"param_name" => "category",
				"value" => "",
				"description" => "Category Slug (leave empty for all)",
			),
			array(
				"type" => "textfield",
				"admin_label"	=> false,
				"class" => "",
				"heading" => "Selected Posts",
				"param_name" => "selected_posts",
				"value" => "",
				"description" => "Selected Posts (leave empty for all, delimit by comma)",
			)
		)
	) );
}
add_action( 'vc_before_init', 'minti_blog_vc' );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Masonry Grid
/*-----------------------------------------------------------------------------------*/
class WPBakeryShortCode_Minti_MasonryGrid extends WPBakeryShortCodesContainer {}
vc_map( array(
	"name" => __( "Masonry Grid", 'minti-framework' ),
	"description" => __( "Masonry Grid", 'minti-framework' ),
	"base" => "minti_masonrygrid",
	"category" => 'Content',
	"icon" => "icon-wpb-minti-masonrygrid",
	"as_parent" => array('only' => 'minti_masonrygrid_item'),
	"content_element" => true,
	"js_view" => 'VcColumnView',
	"params" => array(
		array(
			"type" => "textfield",
			"admin_label"	=> false,
			"class" => "",
			"value" => "",
			"heading" => "Custom Class",
			"param_name" => "customclass",
			"description"	=> __( "Add your own class and refer to it in your CSS file.", 'minti-framework' ),
		),
	)
) );

class WPBakeryShortCode_Minti_MasonryGrid_Item extends WPBakeryShortCode {}
vc_map( array(
	"name" => __( "Masonry Grid Item", 'minti-framework' ),
	"base" => "minti_masonrygrid_item",
	"icon" => "icon-wpb-minti-masonrygrid",
	"as_child" => array('only' => 'minti_masonrygrid'),
	"params" => array(
		array(
			"type" => "dropdown",
			"admin_label"	=> true,
			"class" => "",
			"heading" => "Style",
			"param_name" => "style",
			"value" => array(
				"Image" => "masonry_image",
				"Text" => "masonry_text",
				"Icon" => "masonry_icon",
			),
			"save_always" => true,
		),
		array(
			"type" => "dropdown",
			"admin_label"	=> false,
			"class" => "",
			"heading" => "Size",
			"param_name" => "size",
			"value" => array(
				"Square Small" => "masonry_ss",
				"Square Big" => "masonry_sb",
				"Rectangle Portrait" => "masonry_rp",
				"Rectangle Landscape" => "masonry_rl",
			),
			"dependency" => Array('element' => "style", 'value' => array('masonry_image', 'masonry_icon'))
		),
		array(
			"type" => "attach_image",
			"admin_label"	=> false,
			"class" => "",
			"value" => "",
			"heading" => "Image",
			"param_name" => "image",
			"dependency" => Array('element' => "style", 'value' => array('masonry_image'))
		),
		array(
			"type" => "textfield",
			"admin_label"	=> false,
			"class" => "",
			"value" => "",
			"heading" => "Icon",
			"param_name" => "icon",
			"dependency" => Array('element' => "style", 'value' => array('masonry_icon'))
		),
		array(
			"type" => "textfield",
			"admin_label"	=> true,
			"class" => "",
			"value" => "",
			"heading" => "Title",
			"param_name" => "title",
		),
		array(
			"type" => "textfield",
			"admin_label"	=> false,
			"class" => "",
			"value" => "",
			"heading" => "Subtitle",
			"param_name" => "subtitle",
			"dependency" => Array('element' => "style", 'value' => array('masonry_icon'))
		),
		array(
			"type" => "textarea_html",
			"admin_label"	=> false,
			"class" => "",
			"value" => "",
			"heading" => "Text",
			"param_name" => "content",
			"description" => __( "It's recommended to use short texts, otherwise you may destroy the masonry layout.", 'minti-framework' ),
			"dependency" => Array('element' => "style", 'value' => array('masonry_text'))
		),
		array(
			"type" => "textfield",
			"admin_label"	=> false,
			"class" => "",
			"value" => "",
			"heading" => "Link",
			"param_name" => "link",
			"description" => __( "URL you want to link the Grid Element to.", 'minti-framework' ),
			"dependency" => Array('element' => "style", 'value' => array('masonry_image', 'masonry_icon'))
		),
		array(
			"type" => "dropdown",
			"admin_label"	=> false,
			"class" => "",
			"heading" => "Link Target",
			"param_name" => "target",
			"value" => array(
				"Same Window" => "_self",
				"New Window" => "_blank"
			),
			"save_always" => true,
			"dependency" => Array('element' => "style", 'value' => array('masonry_image', 'masonry_icon'))
		),
	)
) );

/* ------------------------------------------------------------------------ */
/* Remove Params from Default Shortcodes
/* ------------------------------------------------------------------------ */
//vc_remove_param("vc_column_text", "css_animation" );
vc_remove_param("vc_column_text", "css" );
vc_remove_param("vc_accordion", "title" );

/*-----------------------------------------------------------------------------------*/
/* Edit VC Pie
/*-----------------------------------------------------------------------------------*/
vc_remove_param("vc_pie", "color");

vc_add_param("vc_pie", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => "Color",
	"param_name" => "color",
	"value" => "",
	"description" => "",
));

/* ------------------------------------------------------------------------ */
/* EOF
/* ------------------------------------------------------------------------ */
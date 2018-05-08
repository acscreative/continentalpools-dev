<?php
add_filter( 'rwmb_meta_boxes', 'minti_register_meta_boxes' );
function minti_register_meta_boxes( $meta_boxes ) {

	$prefix = 'minti_';
	global $minti_data;
	
	/* ----------------------------------------------------- */
	// PORTFOLIO FILTER ARRAY
	if ( ! function_exists('is_plugin_active')){ include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); } // load is_plugin_active() function if no available
	if(is_plugin_active('unicon_portfolio_cpt/unicon_portfolio_cpt.php')){ 

		$types = get_terms('portfolio_filter', 'hide_empty=0');
		$types_array[0] = 'All categories';
		if($types) {
			foreach($types as $type) {
				$types_array[$type->term_id] = $type->name;
			}
		}

	}

	/* ----------------------------------------------------- */
	// BLOG CATEGORIES FILTER ARRAY
	$blog_options = array(); // fixes a PHP warning when no blog posts at all.
	$blog_categories = get_categories();
	if($blog_categories) {
		foreach ($blog_categories as $category) {
			$blog_options[$category->slug] = $category->name;
		}
	}

	/* ----------------------------------------------------- */
	// SIDEBAR ARRAY
	function get_sidebars_array() {
	    global $wp_registered_sidebars;
	    $list_sidebars = array();
	    foreach ( $wp_registered_sidebars as $sidebar ) {
	        $list_sidebars[$sidebar['id']] = $sidebar['name'];
	    }
	    unset($list_sidebars['footer-widgets']); // Remove Footer Widgets from List
	    return $list_sidebars;
	}

	/* ----------------------------------------------------- */
	// Page Settings
	/* ----------------------------------------------------- */
	$meta_boxes[] = array(
		'id' => 'pagesettings',
		'title' => 'Page Settings',
		'pages' => array( 'page' ),
		'context' => 'normal',
		'priority' => 'high',

		'tabs'      => array(
			'main' => array(
                'label' => __( 'Main', 'rwmb' ),
            ),
            'header' => array(
                'label' => __( 'Header', 'rwmb' ),
            ),
            'footer' => array(
                'label' => __( 'Footer', 'rwmb' ),
            ),
            'blog'  => array(
                'label' => __( 'Blog', 'rwmb' ),
            ),
        ),

        // Tab style: 'default', 'box' or 'left'. Optional
        'tab_style' => 'default',
	
		// List of meta fields
		'fields' => array(
			array(
					'name'		=> 'Layout',
					'id'		=> $prefix . "layout",
					'type'		=> 'select',
					'options'	=> array(
						'default'			=> 'Default',
						'fullwidth'			=> 'Fullwidth',
						'sidebar-right'		=> 'Sidebar Right',
						'sidebar-left'		=> 'Sidebar Left',
					),
					'multiple'	=> false,
					'std'		=> array( 'default' ),
					'desc' => '<strong>Default:</strong> For normal Text Pages<br /> <strong>Full Width:</strong> For pages using Visual Composer Elements (most used)<br /> <strong>Sidebar Left:</strong> Sidebar Left Template<br /> <strong>Sidebar Right:</strong> Sidebar Right Template',
					'tab'  => 'main',
			),
			array(
					'name'		=> 'Header',
					'id'		=> $prefix . "header",
					'type'		=> 'select',
					'options'	=> array(
						'show'		=> 'Enable',
						'hide'		=> 'Disable'
					),
					'multiple'	=> false,
					'std'		=> array( 'show' ),
					'desc' => 'Enable or disable the Header on this Page.',
					'tab'  => 'header',
			),
			array(
					'name'		=> 'Titlebar Style',
					'id'		=> $prefix . "titlebar",
					'type'		=> 'select',
					'options'	=> array(
						'default'				=> 'Default (set in Theme Options)',
						'title'					=> 'Header + Title',
						'featuredimagecenter'	=> 'Header + Image Title',
						'notitle'				=> 'Header only',
						'transparentimage'		=> 'Transparent Header + Image Title',
						'transparent'			=> 'Transparent Header only',
					),
					'multiple'	=> false,
					'std'		=> array( 'default' ),
					'desc' => 'Choose your Titlebar Style for this Page',
					'tab'  => 'header',
			),
			array(
					'name'		=> 'Transparent Header Color',
					'id'		=> $prefix . "headercolor",
					'type'		=> 'select',
					'options'	=> array(
						'light'	=> 'Light (for dark backgrounds)',
						'dark'	=> 'Dark (for light backgrounds)',
					),
					'multiple'	=> false,
					'std'		=> array( 'light' ),
					'desc' => 'This is only relevant if the Titlebar Style is set to a transparent Header.',
					'tab'  => 'header',
			),
			array(
					'name'		=> 'Titlebar Image',
					'id'		=> $prefix . "headerimage",
					'type'		=> 'image_advanced',
					'max_file_uploads' => 1,
					'desc' => 'Upload Titlebar Image for the Titlebar Style.',
					'tab'  => 'header',
			),
			array(
					'name'		=> 'Footer Widgets',
					'id'		=> $prefix . "footerwidgets",
					'type'		=> 'select',
					'options'	=> array(
						'show'		=> 'Enable',
						'hide'		=> 'Disable'
					),
					'multiple'	=> false,
					'std'		=> array( 'show' ),
					'desc' => 'Enable or disable the Footer Widgets on this Page.',
					'tab'  => 'footer',
			),
			array(
					'name'		=> 'Footer Copyright',
					'id'		=> $prefix . "footercopyright",
					'type'		=> 'select',
					'options'	=> array(
						'show'		=> 'Enable',
						'hide'		=> 'Disable'
					),
					'multiple'	=> false,
					'std'		=> array( 'show' ),
					'desc' => 'Enable or disable the Footer Copyright Section on this Page.',
					'tab'  => 'footer',
			),
			array(
				'name'		=> 'Sidebar',
				'id'		=> $prefix . "sidebar",
				'type'		=> 'select',
				'options'	=> get_sidebars_array(),
				'multiple'	=> false,
				'std'		=> array( 'show' ),
				'desc'		=> 'Select the sidebar you wish to display on this page.',
				'tab'  => 'main',
			),
			array(
				'name'		=> 'The following Blog settings are only relevant if you choose the Blog Template from the Page Attributes.',
				'id'		=> $prefix . "heading",
				'type'		=> 'heading',
				'multiple'	=> false,
				'tab'  => 'blog',
			),
			array(
				'name'		=> 'Blog Style',
				'id'		=> $prefix . "blogstyle",
				'type'		=> 'select',
				'options'	=> array(
					'fullwidth'	=> 'Large Images',
					'medium'	=> 'Medium Images',
					'center'	=> 'Centered Blog',
					'masonry'	=> 'Masonry'
				),
				'multiple'	=> false,
				'std'		=> array( 'large' ),
				'desc' => '',
				'tab'  => 'blog',
			),
			// array(
			// 	'name'		=> 'Blog Sidebar',
			// 	'id'		=> $prefix . "bloglayout",
			// 	'type'		=> 'select',
			// 	'options'	=> array(
			// 		'sidebar-right'		=> 'Sidebar Right',
			// 		'sidebar-left'		=> 'Sidebar Left',
			// 		'no-sidebar'		=> 'No Sidebar (Fullwidth)'
			// 	),
			// 	'multiple'	=> false,
			// 	'std'		=> array( 'no-sidebar' ),
			// 	'desc' => 'Choose Sidebar Layout for this Blog Page. <br /><strong>Only works with Large or Medium Blog Style.</strong>',
			// 	'tab'  => 'blog',
			// ),
			array(
				'name'		=> 'Blog Categories',
				'id'		=> $prefix . "blogcategories",
				'type'		=> 'checkbox_list',
				'options'	=> $blog_options,
				'multiple'	=> true,
				'desc' => 'If nothing is selected, it will show Items from <strong>ALL</strong> categories.',
				'tab'  => 'blog',
			),
		)
	);

	/* ----------------------------------------------------- */
	// Blog Metaboxes
	/* ----------------------------------------------------- */
	$meta_boxes[] = array(
		'id' => 'pagesettings',
		'title' => 'Blog Post Settings',
		'pages' => array( 'post' ),
		'context' => 'normal',
		'priority' => 'high',
	
		// List of meta fields
		'fields' => array(
			array(
					'name'		=> 'Titlebar Style',
					'id'		=> $prefix . "titlebar",
					'type'		=> 'select',
					'options'	=> array(
						'default'				=> 'Default (set in Theme Options)',
						'title'					=> 'Header + Title',
						'featuredimagecenter'	=> 'Header + Image Title',
						'notitle'				=> 'Header only',
						'transparentimage'		=> 'Transparent Header + Image Title',	
					),
					'multiple'	=> false,
					'std'		=> array( 'default' ),
					'desc' => 'Choose your Titlebar Style for this Page',
			),
			array(
					'name'		=> 'Transparent Header Color',
					'id'		=> $prefix . "headercolor",
					'type'		=> 'select',
					'options'	=> array(
						'light'	=> 'Light (for dark backgrounds)',
						'dark'	=> 'Dark (for light backgrounds)',
					),
					'multiple'	=> false,
					'std'		=> array( 'light' ),
					'desc' => 'This is only relevant if the Titlebar Style is set to a transparent Header.',
			),
			array(
					'name'		=> 'Titlebar Image',
					'id'		=> $prefix . "headerimage",
					'type'		=> 'image_advanced',
					'max_file_uploads' => 1,
					'desc' => 'Upload Titlebar Image for the Titlebar Style.',
			),
			array(
				'name'		=> 'Hide Featured Image?',
				'id'		=> $prefix . "hideimage",
				'type'		=> 'checkbox',
				'multiple'	=> false,
				'desc' => 'Check this if you want to hide the Featured Image / Gallery on the Blog Detail Page',
			),
		)
	);
	
	// Link Post Format
	$meta_boxes[] = array(
		'id' => 'blog-link',
		'title' => 'Link Settings',
		'pages' => array( 'post' ),
		'context' => 'normal',
		'priority' => 'high',
	
		// List of meta fields
		'fields' => array(
			array(
				'name'		=> 'URL',
				'id'		=> $prefix . 'blog-link',
				'desc'		=> 'Enter a URL for your link post format. (Don\'t forget the http://)',
				'clone'		=> false,
				'type'		=> 'text',
				'std'		=> ''
			)
		)
	);

	// Quote Post Format
	$meta_boxes[] = array(
		'id' => 'blog-quote',
		'title' => 'Quote Settings',
		'pages' => array( 'post' ),
		'context' => 'normal',
		'priority' => 'high',
	
		// List of meta fields
		'fields' => array(
			array(
				'name'		=> 'Quote',
				'id'		=> $prefix . 'blog-quote',
				'desc'		=> 'Please enter the text for your quote here.',
				'clone'		=> false,
				'type'		=> 'textarea',
				'std'		=> ''
			),
			array(
				'name'		=> 'Quote Source',
				'id'		=> $prefix . 'blog-quotesource',
				'desc'		=> 'Please enter the Source of the Quote here.',
				'clone'		=> false,
				'type'		=> 'text',
				'std'		=> ''
			)
		)
	);

	// Video Post Format
	$meta_boxes[] = array(
		'id' => 'blog-video',
		'title' => 'Video Settings',
		'pages' => array( 'post' ),
		'context' => 'normal',
		'priority' => 'high',
	
		// List of meta fields
		'fields' => array(
			array(
				'name'		=> 'Video Source',
				'id'		=> $prefix . 'blog-videosource',
				'type'		=> 'select',
				'options'	=> array(
					'videourl'		=> 'Video URL',
					'embedcode'		=> 'Embed Code'
				),
				'multiple'	=> false,
				'std'		=> array( 'videourl' ),
			),
			array(
				'name'		=> 'Video Embed Code',
				'id'		=> $prefix . 'blog-video',
				'desc'		=> 'If you choose Video URL you can just insert the URL of the <a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">Supported Video Site</a>. Otherwise insert the full embed code.',
				'clone'		=> false,
				'type'		=> 'textarea',
				'std'		=> '',
			),
		)
	);

	// Audio Post Format
	$meta_boxes[] = array(
		'id' => 'blog-audio',
		'title' => 'Audio Settings',
		'pages' => array( 'post' ),
		'context' => 'normal',
		'priority' => 'high',
	
		// List of meta fields
		'fields' => array(
			array(
				'name'		=> 'Audio Embed Code',
				'id'		=> $prefix . 'blog-audio',
				'desc'		=> 'Please enter the Audio Embed Code here.',
				'clone'		=> false,
				'type'		=> 'textarea',
				'std'		=> ''
			),
		)
	);

	// Gallery Post Format
	$meta_boxes[] = array(
		'id' => 'blog-gallery',
		'title' => 'Gallery Settings',
		'pages' => array( 'post' ),
		'context' => 'normal',
		'priority' => 'high',
	
		// List of meta fields
		'fields' => array(
			array(
				'name'	=> 'Gallery',
				'desc'	=> 'You can upload up to 50 gallery images for a slideshow',
				'id'	=> $prefix . 'blog-gallery',
				'type'	=> 'image_advanced',
				'max_file_uploads' => 50,
			)
		)
	);
	
	/* ----------------------------------------------------- */
	// Project Info Metabox
	/* ----------------------------------------------------- */
	if(is_plugin_active('unicon_portfolio_cpt/unicon_portfolio_cpt.php')){ 

		$meta_boxes[] = array(
			'id' => 'portfolio_info',
			'title' => 'Project Information',
			'pages' => array( 'portfolio' ),
			'context' => 'normal',

			'tabs'      => array(
				'portfolio'  => array(
	                'label' => __( 'Portfolio Configuration', 'rwmb' ),
	            ),
	            'header'  => array(
	                'label' => __( 'Header', 'rwmb' ),
	            ),
	            'slides'  => array(
	                'label' => __( 'Portfolio Slides', 'rwmb' ),
	            ),
	            'video'  => array(
	                'label' => __( 'Portfolio Video', 'rwmb' ),
	            ),
	        ),

	        // Tab style: 'default', 'box' or 'left'. Optional
	        'tab_style' => 'default',
			
			'fields' => array(
				array(
						'name'		=> 'Titlebar Style',
						'id'		=> $prefix . "titlebar",
						'type'		=> 'select',
						'options'	=> array(
							'default'				=> 'Default (set in Theme Options)',
							'title'					=> 'Header + Title',
							'featuredimagecenter'	=> 'Header + Image Title',
							'notitle'				=> 'Header only',
							'transparentimage'		=> 'Transparent Header + Image Title',
							'transparent'			=> 'Transparent Header only',
						),
						'multiple'	=> false,
						'std'		=> array( 'default' ),
						'desc' => 'Choose your Titlebar Style for this Page',
						'tab'  => 'header',
				),
				array(
						'name'		=> 'Transparent Header Color',
						'id'		=> $prefix . "headercolor",
						'type'		=> 'select',
						'options'	=> array(
							'light'	=> 'Light (for dark backgrounds)',
							'dark'	=> 'Dark (for light backgrounds)',
						),
						'multiple'	=> false,
						'std'		=> array( 'light' ),
						'desc' => 'This is only relevant if the Titlebar Style is set to a transparent Header.',
						'tab'  => 'header',
				),
				array(
						'name'		=> 'Titlebar Image',
						'id'		=> $prefix . "headerimage",
						'type'		=> 'image_advanced',
						'max_file_uploads' => 1,
						'desc' => 'Upload Titlebar Image for the Titlebar Style.',
						'tab'  => 'header',
				),
				array(
					'name'		=> 'Detail Layout',
					'id'		=> $prefix . 'portfolio-detaillayout',
					'desc'		=> 'Choose your Layout for the Portfolio Detail Page.<br />If you choose the "Custom Portfolio Page" Layout, the Project Slides & Video fields below will be ignored. You will start with a blank canvas & use shortcodes to style your Page like a normal Page.',
					'type'		=> 'select',
					'options'	=> array(
						'wide'			=> 'Full Width (Slider)',
						'wide-ns'		=> 'Full Width (No Slider)',
						'sidebyside'	=> 'Side By Side (Slider)',
						'sidebyside-ns'	=> 'Side By Side (No Slider)',
						'custom'		=> 'Custom Portfolio Page (100% Section)'
					),
					'multiple'	=> false,
					'std'		=> array( 'no' ),
					'tab'  => 'portfolio',
				),
				array(
					'name'		=> 'Subtitle',
					'id'		=> $prefix . 'subtitle',
					'desc'		=> 'The Subtitle is shown on the Portfolio Overview Pages, Shortcodes & Related Projects. You can leave this empty to hide it. ',
					'clone'		=> false,
					'type'		=> 'text',
					'std'		=> '',
					'tab'  => 'portfolio',
				),	
				array(
					'name'		=> 'Client',
					'id'		=> $prefix . 'portfolio-client',
					'desc'		=> 'The Client is shown on the Portfolio Detail Page. You can leave this empty to hide it.',
					'clone'		=> false,
					'type'		=> 'text',
					'std'		=> '',
					'tab'  => 'portfolio',
				),
				array(
					'name'		=> 'Project link',
					'id'		=> $prefix . 'portfolio-link',
					'desc'		=> 'URL Link to your Project (Do not forget the http://). This will be shown on the Portfolio Detail Page. You can leave this empty to hide it.',
					'clone'		=> false,
					'type'		=> 'text',
					'std'		=> '',
					'tab'  => 'portfolio',
				),
				array(
					'name'		=> 'Show Project Details?',
					'id'		=> $prefix . "portfolio-details",
					'type'		=> 'checkbox',
					'std'		=> true,
					'tab'  => 'portfolio',
				),
				array(
					'name'		=> 'Show Related Projects?',
					'id'		=> $prefix . "portfolio-relatedposts",
					'type'		=> 'checkbox',
					'desc'		=> '',
					'std'		=> false,
					'tab'  => 'portfolio',
				),
				array(
					'name'		=> 'Masonry Size',
					'id'		=> $prefix . 'portfolio-size',
					'desc'		=> 'Only relevant when the portfolio is displayed in masonry format.',
					'type'		=> 'select',
					'options'	=> array(
						'regular'	=> 'Regular',
						'wide'		=> 'Wide',
						'tall'		=> 'Tall',
						'widetall'	=> 'Wide & Tall',
					),
					'multiple'	=> false,
					'std'		=> array( 'regular' ),
					'tab'  => 'portfolio',
				),
				array(
					'name'		=> 'Link to Lightbox',
					'id'		=> $prefix . "portfolio-lightbox",
					'type'		=> 'checkbox',
					'desc'		=> 'Open the Preview Image in a Lightbox (on Portfolio Overview, Shortcodes & Related Posts)',
					'std'		=> false,
					'tab'  => 'portfolio',
				),
				array(
					'name'	=> 'Project Slider Images',
					'desc'	=> 'You can upload up to 50 project images for a slideshow, or only one image to display a single image. <br /><strong>Notice:</strong> The Preview Image (on Overview, Shortcodes & Related Projects) will be the Image set as Featured Image.',
					'id'	=> $prefix . 'screenshot',
					'type'	=> 'image_advanced',
					'max_file_uploads' => 50,
					'tab'  => 'slides',
				),
				array(
					'name'		=> 'Video Source',
					'id'		=> $prefix . 'source',
					'type'		=> 'select',
					'options'	=> array(
						'videourl'		=> 'Video URL',
						'embedcode'		=> 'Embed Code'
					),
					'multiple'	=> false,
					'std'		=> array( 'no' ),
					'tab'  => 'video',
				),
				array(
					'name'	=> 'Video URL or own Embed Code',
					'id'	=> $prefix . 'embed',
					'desc'	=> 'If you choose Video URL you can just insert the URL of the <a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">Supported Video Site</a>. You can also insert your own Embed Code. If you fill out this field, it will be shown <strong>instead</strong> of the Slider.<br /><br /><strong>Notice:</strong> The Preview Image will be the Image set as Featured Image.',
					'type' 	=> 'textarea',
					'std' 	=> "",
					'cols' 	=> "40",
					'rows' 	=> "8",
					'tab'  => 'video',
				)
			)
		);

	}

	/* ----------------------------------------------------- */
	// Boxed Background Meta Box
	/* ----------------------------------------------------- */
	if(isset($minti_data['select_layoutstyle']) && ($minti_data['select_layoutstyle'] == 'boxed' )) {

		$meta_boxes[] = array(
			'id' => 'styling',
			'title' => 'Background Styling Options',
			'pages' => array( 'post', 'page', 'portfolio' ),
			'context' => 'side',
		
			// List of meta fields
			'fields' => array(
				array(
					'name'		=> 'Background Image URL',
					'id'		=> $prefix . 'bgurl',
					'desc'		=> '',
					'clone'		=> false,
					'type'		=> 'text',
					'std'		=> ''
				),
				array(
					'name'		=> 'Style',
					'id'		=> $prefix . "bgstyle",
					'type'		=> 'select',
					'options'	=> array(
						'stretch'		=> 'Stretch Image',
						'repeat'		=> 'Repeat',
						'no-repeat'		=> 'No-Repeat',
						'repeat-x'		=> 'Repeat-X',
						'repeat-y'		=> 'Repeat-Y'
					),
					'multiple'	=> false,
					'std'		=> array( 'stretch' )
				),
				array(
					'name'		=> 'Background Color',
					'id'		=> $prefix . "bgcolor",
					'type'		=> 'color'
				)
			)
		);

	}
	
	return $meta_boxes;
}

/* ----------------------------------------------------- */
// Metabox Visibility for Blog Posts
/* ----------------------------------------------------- */
add_action( 'admin_print_scripts', 'displayMetaboxes', 1000 );

if ( ! function_exists( 'displayMetaboxes' ) ) {
	
	function displayMetaboxes() {

	    if ( get_post_type() == "post" || get_post_type() == "page" ) { ?>
	        
	        <script type="text/javascript">// <![CDATA[
			
			jQuery(document).ready(function($){

				function displayMetaBox() {
	                $('#blog-link, #blog-quote, #blog-video, #blog-audio, #blog-gallery').hide();
	                var selectedformat = $("input[name='post_format']:checked").val();
	                
	                if( selectedformat ) {
	                	if( selectedformat == 'link' ) {
							$("#blog-link").fadeIn();
						}
						if( selectedformat == 'quote' ) {
							$("#blog-quote").fadeIn();
						}
						if( selectedformat == 'video' ) {
							$("#blog-video").fadeIn();
						}
						if( selectedformat == 'audio' ) {
							$("#blog-audio").fadeIn();
						}
						if( selectedformat == 'gallery' ) {
							$("#blog-gallery").fadeIn();
						}
					}
	            }

	            $(function() {
	                displayMetaBox();
	                $("input[name='post_format']").change(function() {
	                    displayMetaBox();
	                });
	            });

			 });

			// ]]></script>
	    <?php 
		}
	
	}
}
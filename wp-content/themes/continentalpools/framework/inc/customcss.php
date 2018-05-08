<?php
/* ------------------------------------------------------------------------ */
/* Add Dynamic CSS Styles
/* ------------------------------------------------------------------------ */
add_action('wp_head', 'minti_dynamic_css');

if ( !function_exists( 'minti_dynamic_css' ) ) {
	
	function minti_dynamic_css() {

		global $minti_data;
	
		$custom_css ='';

		/* Set Variables --------------------------------------------------------------- */

		/* Accent + Links */
		$color_accent = esc_attr($minti_data['color_accent']);
		$color_link = esc_attr($minti_data['color_link']);
		$color_hover = esc_attr($minti_data['color_hover']);

		/* Body */
		$font_body_face = $minti_data['font_body']['font-family']; // no need to escape - fixed array from Redux Framework
		$font_body_size = esc_attr($minti_data['font_body']['font-size']);
		$font_body_weight = esc_attr($minti_data['font_body']['font-weight']);
		$font_body_color = esc_attr($minti_data['font_body']['color']);
		$style_bodylineheight = esc_attr($minti_data['style_bodylineheight']);
		$color_bodybg = esc_attr($minti_data['color_bodybg']);

		/* Fonts */
		$font_headline_face = $minti_data['font_headline']['font-family']; // no need to escape - fixed array from Redux Framework
		$font_headline_weight = esc_attr($minti_data['font_headline']['font-weight']);
		$font_headline_style = esc_attr($minti_data['font_headline']['font-style']);
		$font_headline_color = esc_attr($minti_data['font_headline']['color']);

		$size_h1 = esc_attr($minti_data['size_h1']);
		$size_h2 = esc_attr($minti_data['size_h2']);
		$size_h3 = esc_attr($minti_data['size_h3']);
		$size_h4 = esc_attr($minti_data['size_h4']);
		$size_h5 = esc_attr($minti_data['size_h5']);
		$size_h6 = esc_attr($minti_data['size_h6']);

		/* Sidebar */
		$font_sidebarheadline_face = $minti_data['font_sidebarheadline']['font-family']; // no need to escape - fixed array from Redux Framework
		$font_sidebarheadline_size = esc_attr($minti_data['font_sidebarheadline']['font-size']);
		$font_sidebarheadline_style = esc_attr($minti_data['font_sidebarheadline']['font-style']);
		$font_sidebarheadline_weight = esc_attr($minti_data['font_sidebarheadline']['font-weight']);
		$font_sidebarheadline_color = esc_attr($minti_data['font_sidebarheadline']['color']);
		$color_sidebarborder = esc_attr($minti_data['color_sidebarborder']);

		/* Topbar */
		$color_topbar_bg = esc_attr($minti_data['color_topbar_bg']);
		$color_topbar_text = esc_attr($minti_data['color_topbar_text']);
		$color_topbar_link = esc_attr($minti_data['color_topbar_link']);
		$color_topbar_linkhover = esc_attr($minti_data['color_topbar_linkhover']);

		/* Header + Logo */
		$style_logotopmargin = esc_attr($minti_data['style_logotopmargin']);
		$style_headerheight = esc_attr($minti_data['style_headerheight']);
		$style_navmargintop = esc_attr($minti_data['style_navmargintop']);

		$color_headerbg = esc_attr($minti_data['color_headerbg']);
		$color_headericon = esc_attr($minti_data['color_headericon']);
		$color_headericonhover = esc_attr($minti_data['color_headericonhover']);
		$color_searchinput = esc_attr($minti_data['color_searchinput']);

		$style_hv3_topmargin = esc_attr($minti_data['style_hv3_topmargin']);
		$style_hv3_bottommargin = esc_attr($minti_data['style_hv3_bottommargin']);
		$style_hv3slogan_topmargin = esc_attr($minti_data['style_hv3slogan_topmargin']);

		$font_slogan_size = esc_attr($minti_data['font_slogan']['font-size']);
		$font_slogan_face = $minti_data['font_slogan']['font-family']; // no need to escape - fixed array from Redux Framework
		$font_slogan_weight = esc_attr($minti_data['font_slogan']['font-weight']);
		$font_slogan_style = esc_attr($minti_data['font_slogan']['font-style']);
		$font_slogan_color = esc_attr($minti_data['font_slogan']['color']);

		/* Navigation */
		$font_nav_face = $minti_data['font_nav']['font-family']; // no need to escape - fixed array from Redux Framework
		$font_nav_size = esc_attr($minti_data['font_nav']['font-size']);
		$font_nav_style = esc_attr($minti_data['font_nav']['font-style']);
		$font_nav_weight = esc_attr($minti_data['font_nav']['font-weight']);
		$font_nav_color = esc_attr($minti_data['font_nav']['color']);

		$color_navlinkhover = esc_attr($minti_data['color_navlinkhover']);
		$color_navlinkactive = esc_attr($minti_data['color_navlinkactive']);
		$color_navdivider = esc_attr($minti_data['color_navdivider']);

		/* Subnavigation */
		$color_subnavbg = esc_attr($minti_data['color_subnavbg']);
		$font_subnav_face = $minti_data['font_subnav']['font-family']; // no need to escape - fixed array from Redux Framework
		$font_subnav_size = esc_attr($minti_data['font_subnav']['font-size']);
		$font_subnav_style = esc_attr($minti_data['font_subnav']['font-style']);
		$font_subnav_weight = esc_attr($minti_data['font_subnav']['font-weight']);
		$font_subnav_color = esc_attr($minti_data['font_subnav']['color']);
		$color_subnavlinkhover = esc_attr($minti_data['color_subnavlinkhover']);
		$color_subnavborder = esc_attr($minti_data['color_subnavborder']);

		$color_megamenuheading = esc_attr($minti_data['color_megamenuheading']);
		$color_megamenuhover = esc_attr($minti_data['color_megamenuhover']);

		$color_mobilesearchbg = esc_attr($minti_data['color_mobilesearchbg']);
		$color_mobilesearch = esc_attr($minti_data['color_mobilesearch']);

		/* Titlebar: Default */
		$color_titlebarbg = esc_attr($minti_data['color_titlebarbg']);
		$border_titlebar_width = esc_attr($minti_data['border_titlebar']['border-bottom']);
		$border_titlebar_style = esc_attr($minti_data['border_titlebar']['border-style']);
		$border_titlebar_color = esc_attr($minti_data['border_titlebar']['border-color']);
		$font_titlebar_face = $minti_data['font_titlebar']['font-family']; // no need to escape - fixed array from Redux Framework
		$font_titlebar_size = esc_attr($minti_data['font_titlebar']['font-size']);
		$font_titlebar_style = esc_attr($minti_data['font_titlebar']['font-style']);
		$font_titlebar_weight = esc_attr($minti_data['font_titlebar']['font-weight']);
		$font_titlebar_color = esc_attr($minti_data['font_titlebar']['color']);
		$font_breadcrumb_face = $minti_data['font_breadcrumb']['font-family']; // no need to escape - fixed array from Redux Framework
		$font_breadcrumb_size = esc_attr($minti_data['font_breadcrumb']['font-size']);
		$font_breadcrumb_style = esc_attr($minti_data['font_breadcrumb']['font-style']);
		$font_breadcrumb_weight = esc_attr($minti_data['font_breadcrumb']['font-weight']);
		$font_breadcrumb_color = esc_attr($minti_data['font_breadcrumb']['color']);
		$color_breadcrumbhover = esc_attr($minti_data['color_breadcrumbhover']);
		$style_breadcrumbmargin = esc_attr($minti_data['style_breadcrumbmargin']);

		/* Titlebar: Image Title */
		$font_titlebar_3_face = $minti_data['font_titlebar_3']['font-family']; // no need to escape - fixed array from Redux Framework
		$font_titlebar_3_size = esc_attr($minti_data['font_titlebar_3']['font-size']);
		$font_titlebar_3_style = esc_attr($minti_data['font_titlebar_3']['font-style']);
		$font_titlebar_3_weight = esc_attr($minti_data['font_titlebar_3']['font-weight']);
		$font_titlebar_3_color = esc_attr($minti_data['font_titlebar_3']['color']);
		$font_titlebar_3_letterspacing = esc_attr($minti_data['font_titlebar_3']['letter-spacing']);
		$font_titlebar_3_texttransform = esc_attr($minti_data['font_titlebar_3']['text-transform']);
		$align_titlebar_3 = esc_attr($minti_data['align_titlebar_3']);

		/* Footer */
		$font_footerheadline_face = $minti_data['font_footerheadline']['font-family']; // no need to escape - fixed array from Redux Framework
		$font_footerheadline_size = esc_attr($minti_data['font_footerheadline']['font-size']);
		$font_footerheadline_style = esc_attr($minti_data['font_footerheadline']['font-style']);
		$font_footerheadline_weight = esc_attr($minti_data['font_footerheadline']['font-weight']);
		$font_footerheadline_color = esc_attr($minti_data['font_footerheadline']['color']);
		$color_footerbg = esc_attr($minti_data['color_footerbg']);
		// $style_footerbg = esc_attr($minti_data['media_footerbg']);
		// $style_footerbgrepeat = esc_attr($minti_data['select_footerbg']);
		$color_footertext = esc_attr($minti_data['color_footertext']);
		$color_footerlink = esc_attr($minti_data['color_footerlink']);
		$color_footerlinkhover = esc_attr($minti_data['color_footerlinkhover']);
		$border_footertop_width = esc_attr($minti_data['border_footertop']['border-top']);
		$border_footertop_style = esc_attr($minti_data['border_footertop']['border-style']);
		$border_footertop_color = esc_attr($minti_data['border_footertop']['border-color']);
		$style_footerwidgetborder = esc_attr($minti_data['style_footerwidgetborder']);

		/* Copyright */
		$color_copyrightbg = esc_attr($minti_data['color_copyrightbg']);
		$color_copyrighttext = esc_attr($minti_data['color_copyrighttext']);
		$color_copyrightlink = esc_attr($minti_data['color_copyrightlink']);
		$color_copyrightlinkhover = esc_attr($minti_data['color_copyrightlinkhover']);

		/* Special Font */
		$font_specialfont_face = $minti_data['font_specialfont']['font-family']; // no need to escape - fixed array from Redux Framework
		$font_specialfont_spacing = esc_attr($minti_data['font_specialfont']['letter-spacing']);
		$font_specialfont_weight = esc_attr($minti_data['font_specialfont']['font-weight']);

		/* Custom CSS */
		$usercss = balancetags($minti_data['textarea_csscode']);

		// Responsive Screen Sizes CSS
		$usercss_xl = balancetags($minti_data['textarea_csscode_xl']);
		$usercss_l = balancetags($minti_data['textarea_csscode_l']);
		$usercss_m = balancetags($minti_data['textarea_csscode_m']);
		$usercss_s = balancetags($minti_data['textarea_csscode_s']);
		$usercss_xs = balancetags($minti_data['textarea_csscode_xs']);

		/* Change CSS --------------------------------------------------------------- */
		$custom_css .= "body{ font: {$font_body_weight} {$font_body_size} {$font_body_face}, Arial, Helvetica, sans-serif; color: {$font_body_color}; line-height: {$style_bodylineheight};}
		.wrapall, .boxed-layout{ background-color: {$color_bodybg}; }
		body.page-template-page-blank-php{ background: {$color_bodybg} !important; }

		h1, .title-h1{ font: {$font_headline_weight} {$size_h1} {$font_headline_face}, Arial, Helvetica, sans-serif; color: {$font_headline_color}; }
		h2{ font: {$font_headline_weight} {$size_h2} {$font_headline_face}, Arial, Helvetica, sans-serif; color: {$font_headline_color}; }
		h3{ font: {$font_headline_weight} {$size_h3} {$font_headline_face}, Arial, Helvetica, sans-serif; color: {$font_headline_color}; }
		h4{ font: {$font_headline_weight} {$size_h4} {$font_headline_face}, Arial, Helvetica, sans-serif; color: {$font_headline_color}; }
		h5{ font: {$font_headline_weight} {$size_h5} {$font_headline_face}, Arial, Helvetica, sans-serif; color: {$font_headline_color}; }
		h6{ font: {$font_headline_weight} {$size_h6} {$font_headline_face}, Arial, Helvetica, sans-serif; color: {$font_headline_color}; }

		.title{ font-family: '{$font_headline_face}', Arial, Helvetica, sans-serif; }

		h1 a, h2 a, h3 a, h4 a, h5 a, h6 a  { font-weight: inherit; color: inherit; }
		h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover, a:hover h1, a:hover h2, a:hover h3, a:hover h4, a:hover h5, a:hover h6 { color: {$color_hover}; }

		a{ color: {$color_link}; }
		a:hover{ color: {$color_hover}; }

		input[type='text'], input[type='password'], input[type='email'], input[type='tel'], textarea, select { font-family: {$font_body_face}, Arial, Helvetica, sans-serif; font-size: {$font_body_size}; }

		#sidebar .widget h3{ font: {$font_sidebarheadline_weight} {$font_sidebarheadline_size} {$font_sidebarheadline_face}, Arial, Helvetica, sans-serif; color: {$font_sidebarheadline_color}; }
		.container .twelve.alt.sidebar-right,
		.container .twelve.alt.sidebar-left,
		#sidebar.sidebar-right #sidebar-widgets,
		#sidebar.sidebar-left #sidebar-widgets{ border-color: {$color_sidebarborder};}

		#topbar{ background: {$color_topbar_bg}; color: {$color_topbar_text}; }
		#topbar a{ color: {$color_topbar_link}; }
		#topbar a:hover{ color: {$color_topbar_linkhover}; }

		@media only screen and (max-width: 767px) {
			#topbar .topbar-col1{
				background: {$color_topbar_bg};
			}
		}

		/* Navigation */
		#navigation > ul > li > a{ font: {$font_nav_weight} {$font_nav_size} {$font_nav_face}, Arial, Helvetica, sans-serif; color: {$font_nav_color}; }
		#navigation > ul > li:hover > a, #navigation > ul > li > a:hover { color: {$color_navlinkhover}; }
		#navigation li.current-menu-item > a:hover,
		#navigation li.current-page-ancestor > a:hover,
		#navigation li.current-menu-ancestor > a:hover,
		#navigation li.current-menu-parent > a:hover,
		#navigation li.current_page_ancestor > a:hover,
		#navigation > ul > li.sfHover > a { color: {$color_navlinkhover}; }
		#navigation li.current-menu-item > a,
		#navigation li.current-page-ancestor > a,
		#navigation li.current-menu-ancestor > a,
		#navigation li.current-menu-parent > a,
		#navigation li.current_page_ancestor > a { color: {$color_navlinkactive}; }
		#navigation ul li:hover{ border-color: {$color_navlinkhover}; }
		#navigation li.current-menu-item,
		#navigation li.current-page-ancestor,
		#navigation li.current-menu-ancestor,
		#navigation li.current-menu-parent,
		#navigation li.current_page_ancestor{ border-color: {$color_navlinkactive}; }

		#navigation .sub-menu{ background: {$color_subnavbg}; }
		#navigation .sub-menu li a{ font: {$font_subnav_weight} {$font_subnav_size} {$font_subnav_face}, Arial, Helvetica, sans-serif; color: {$font_subnav_color}; }
		#navigation .sub-menu li a:hover{ color: {$color_subnavlinkhover}; }
		
		#navigation .sub-menu li.current_page_item > a,
		#navigation .sub-menu li.current_page_item > a:hover,
		#navigation .sub-menu li.current-menu-item > a,
		#navigation .sub-menu li.current-menu-item > a:hover,
		#navigation .sub-menu li.current-page-ancestor > a,
		#navigation .sub-menu li.current-page-ancestor > a:hover,
		#navigation .sub-menu li.current-menu-ancestor > a,
		#navigation .sub-menu li.current-menu-ancestor > a:hover,
		#navigation .sub-menu li.current-menu-parent > a,
		#navigation .sub-menu li.current-menu-parent > a:hover,
		#navigation .sub-menu li.current_page_ancestor > a,
		#navigation .sub-menu li.current_page_ancestor > a:hover{ color: {$color_subnavlinkhover}; }
		#navigation .sub-menu li a, #navigation .sub-menu ul li a{ border-color: {$color_subnavborder}; }

		#navigation > ul > li.megamenu > ul.sub-menu{ background: {$color_subnavbg}; border-color: {$color_navlinkhover};  }
		#navigation > ul > li.megamenu > ul > li { border-right-color: {$color_subnavborder} !important; }

		#navigation > ul > li.megamenu ul li a{ color:{$font_subnav_color}; }

		#navigation > ul > li.megamenu > ul > li > a { color:{$color_megamenuheading}; }

		#navigation > ul > li.megamenu > ul ul li a:hover, #header #navigation > ul > li.megamenu > ul ul li.current-menu-item a { color: {$color_subnavlinkhover} !important; background-color: {$color_megamenuhover} !important; }

		/* Header General */
		#search-btn, #shopping-btn, #close-search-btn { color: {$color_headericon}; }
		#search-btn:hover, #shopping-btn:hover, #close-search-btn:hover { color: {$color_headericonhover}; }

		#slogan{ font: {$font_slogan_weight} {$font_slogan_size} {$font_slogan_face}, Arial, Helvetica, sans-serif; color: {$font_slogan_color}; margin-top: {$style_hv3slogan_topmargin}; }

		/* Mobile Header */
		#mobile-navigation{ background: {$color_subnavbg}; }
		#mobile-navigation ul li a{ font: {$font_subnav_weight} {$font_subnav_size} {$font_subnav_face}, Arial, Helvetica, sans-serif; color: {$font_subnav_color}; border-bottom-color: {$color_subnavborder} !important; }
		#mobile-navigation ul li a:hover, 
		#mobile-navigation ul li a:hover [class^='fa-'], 
		#mobile-navigation li.open > a, 
		#mobile-navigation ul li.current-menu-item > a, 
		#mobile-navigation ul li.current-menu-ancestor > a{ color: {$color_subnavlinkhover}; }
		body #mobile-navigation li.open > a [class^='fa-']{ color: {$color_subnavlinkhover};  }

		#mobile-navigation form, #mobile-navigation form input{ background: {$color_mobilesearchbg}; color: {$color_mobilesearch}; }
		#mobile-navigation form:before{ color: {$color_mobilesearch}; }

		#mobile-header{ background: {$color_headerbg}; height: {$style_headerheight}; }
		#mobile-navigation-btn, #mobile-cart-btn, #mobile-shopping-btn{ color: {$color_headericon}; line-height: {$style_headerheight}; }
		#mobile-navigation-btn:hover, #mobile-cart-btn:hover, #mobile-shopping-btn:hover { color: {$color_headericonhover}; }
		#mobile-header .logo{ margin-top: {$style_logotopmargin}; }

		/* Header V1 */
		#header.header-v1 { height: {$style_headerheight}; background: {$color_headerbg}; }
		.header-v1 .logo{ margin-top: {$style_logotopmargin}; }
		.header-v1 #navigation > ul > li{ height: {$style_headerheight}; padding-top: {$style_navmargintop}; }
		.header-v1 #navigation .sub-menu{ top: {$style_headerheight}; }

		.header-v1 .header-icons-divider{ line-height: {$style_headerheight}; background: {$color_navdivider}; }
		#header.header-v1 .widget_shopping_cart{ top: {$style_headerheight}; }

		.header-v1 #search-btn, .header-v1 #close-search-btn, .header-v1 #shopping-btn{ line-height: {$style_headerheight}; }
		.header-v1 #search-top, .header-v1 #search-top input{ height: {$style_headerheight}; }
		.header-v1 #search-top input{ color: {$color_searchinput}; font-family: {$font_body_face}, Arial, Helvetica, sans-serif; }

		/* Header V3 */
		#header.header-v3 { background: {$color_headerbg}; }
		.header-v3 .navigation-wrap{ background: {$color_headerbg}; border-top: 1px solid {$color_navdivider}; }
		.header-v3 .logo { margin-top: {$style_hv3_topmargin}; margin-bottom: {$style_hv3_bottommargin}; }

		/* Header V4 */
		#header.header-v4 { background: {$color_headerbg}; }
		.header-v4 .navigation-wrap{ background: {$color_headerbg}; border-top: 1px solid {$color_navdivider}; }
		.header-v4 .logo { margin-top: {$style_hv3_topmargin}; margin-bottom: {$style_hv3_bottommargin}; }

		/* Transparent Header */
		#transparentimage{ padding: {$style_headerheight} 0 0 0; }
		.header-is-transparent #mobile-navigation{ top: {$style_headerheight}; }

		/* Stuck */
		.stuck{ background: {$color_headerbg}; }

		/* Titlebars */
		.titlebar h1, .title-h1{ font: {$font_titlebar_weight} {$font_titlebar_size} {$font_titlebar_face}, Arial, Helvetica, sans-serif; color: {$font_titlebar_color}; }
		#fulltitle{ background: {$color_titlebarbg}; border-bottom: {$border_titlebar_width} {$border_titlebar_style} {$border_titlebar_color}; }

		#breadcrumbs{ margin-top: {$style_breadcrumbmargin}; }
		#breadcrumbs, #breadcrumbs a{ font: {$font_breadcrumb_weight} {$font_breadcrumb_size} {$font_breadcrumb_face}, Arial, Helvetica, sans-serif; color: {$font_breadcrumb_color}; }
		#breadcrumbs a:hover{ color: {$color_breadcrumbhover}; }

		#fullimagecenter h1, #transparentimage h1, #fullimagecenter .title-h1, #transparentimage .title-h1{ font: {$font_titlebar_3_weight} {$font_titlebar_3_size} {$font_titlebar_3_face}, Arial, Helvetica, sans-serif; color: {$font_titlebar_3_color}; text-transform: {$font_titlebar_3_texttransform}; letter-spacing: {$font_titlebar_3_letterspacing}; text-align: {$align_titlebar_3}; }

		/* Footer */
		#footer .widget h3{ font: {$font_footerheadline_weight} {$font_footerheadline_size} {$font_footerheadline_face}, Arial, Helvetica, sans-serif; color: {$font_footerheadline_color}; }
		#footer{ color: {$color_footertext}; border-top: {$border_footertop_width} {$border_footertop_style} {$border_footertop_color}; }
		#footer{ background-color: {$color_footerbg}; }
		#footer a, #footer .widget ul li:after { color: {$color_footerlink}; }
		#footer a:hover, #footer .widget ul li:hover:after { color: {$color_footerlinkhover}; }
		#footer .widget ul li{ border-bottom-color: {$style_footerwidgetborder}; }

		/* Copyright */
		#copyright{ background: {$color_copyrightbg}; color: {$color_copyrighttext}; }
		#copyright a { color: {$color_copyrightlink}; }
		#copyright a:hover { color: {$color_copyrightlinkhover}; }

		/* Color Accent */
		.highlight{color:{$color_accent} !important;}
		::selection{ background: {$color_accent}; }
		::-moz-selection { background: {$color_accent}; }
		#shopping-btn span{background:{$color_accent};}
		.blog-page .post h1 a:hover,.blog-page .post h2 a:hover{color:{$color_accent};}
		.entry-image .entry-overlay{background:{$color_accent};}
		.entry-quote a:hover{background:{$color_accent};}
		.entry-link a:hover{background:{$color_accent};}
		.blog-single .entry-tags a:hover{color:{$color_accent};}
		.sharebox ul li a:hover{color:{$color_accent};}
		#pagination .current a{background:{$color_accent};}
		#filters ul li a:hover{color:{$color_accent};}
		#filters ul li a.active{color:{$color_accent};}
		#back-to-top a:hover{background-color:{$color_accent};}
		#sidebar .widget ul li a:hover{color:{$color_accent};}
		#sidebar .widget ul li:hover:after{color:{$color_accent};}
		.widget_tag_cloud a:hover,.widget_product_tag_cloud a:hover{background:{$color_accent};border-color:{$color_accent};}
		.widget_portfolio .portfolio-widget-item .portfolio-overlay{background:{$color_accent};}
		#sidebar .widget_nav_menu ul li a:hover{color:{$color_accent};}
		#footer .widget_tag_cloud a:hover,#footer .widget_product_tag_cloud a:hover{background:{$color_accent};border-color:{$color_accent};}
		/* Shortcodes */
		.box.style-2{border-top-color:{$color_accent};}
		.box.style-4{border-color:{$color_accent};}
		.box.style-6{background:{$color_accent};}
		a.button,input[type=submit],button,.minti_button{background:{$color_accent};border-color:{$color_accent};}
		a.button.color-2{color:{$color_accent};border-color:{$color_accent};}
		a.button.color-3{background:{$color_accent};border-color:{$color_accent};}
		a.button.color-9{color:{$color_accent};}
		a.button.color-6:hover{background:{$color_accent};border-color:{$color_accent};}
		a.button.color-7:hover{background:{$color_accent};border-color:{$color_accent};}
		.counter-number{color:{$color_accent};}
		.divider-title.align-center:after, .divider-title.align-left:after { background-color:{$color_accent} }
		.divider5{border-bottom-color:{$color_accent};}
		.dropcap.dropcap-circle{background-color:{$color_accent};}
		.dropcap.dropcap-box{background-color:{$color_accent};}
		.dropcap.dropcap-color{color:{$color_accent};}
		.toggle .toggle-title.active, .color-light .toggle .toggle-title.active{ background:{$color_accent}; border-color: {$color_accent};}
		.iconbox-style-1.icon-color-accent i.boxicon,.iconbox-style-2.icon-color-accent i.boxicon,.iconbox-style-3.icon-color-accent i.boxicon,.iconbox-style-8.icon-color-accent i.boxicon,.iconbox-style-9.icon-color-accent i.boxicon{color:{$color_accent}!important;}
		.iconbox-style-4.icon-color-accent i.boxicon,.iconbox-style-5.icon-color-accent i.boxicon,.iconbox-style-6.icon-color-accent i.boxicon,.iconbox-style-7.icon-color-accent i.boxicon,.flip .icon-color-accent.card .back{background:{$color_accent};}
		.latest-blog .blog-item .blog-overlay{background:{$color_accent};}
		.latest-blog .blog-item .blog-pic i{color:{$color_accent};}
		.latest-blog .blog-item h4 a:hover{color:{$color_accent};}
		.progressbar .progress-percentage{background:{$color_accent};}
		.wpb_widgetised_column .widget ul li a:hover{color:{$color_accent};}
		.wpb_widgetised_column .widget ul li:hover:after{color:{$color_accent};}
		.wpb_accordion .wpb_accordion_wrapper .ui-state-active .ui-icon{background-color:{$color_accent};}
		.wpb_accordion .wpb_accordion_wrapper .ui-state-active.wpb_accordion_header a{color:{$color_accent};}
		.wpb_accordion .wpb_accordion_wrapper .wpb_accordion_header a:hover,.wpb_accordion .wpb_accordion_wrapper .wpb_accordion_header a:hover .ui-state-default .ui-icon{color:{$color_accent};}
		.wpb_accordion .wpb_accordion_wrapper .wpb_accordion_header:hover .ui-icon{background-color:{$color_accent}!important;}
		.wpb_content_element.wpb_tabs .wpb_tabs_nav li.ui-tabs-active{border-bottom-color:{$color_accent};}
		.portfolio-item h4 a:hover{ color: {$color_accent}; }
		.portfolio-filters ul li a:hover { color: {$color_accent}; }
		.portfolio-filters ul li a.active { color: {$color_accent}; }
		.portfolio-overlay-icon .portfolio-overlay{ background: {$color_accent}; }
		.portfolio-overlay-icon i{ color: {$color_accent}; }
		.portfolio-overlay-effect .portfolio-overlay{ background: {$color_accent}; }
		.portfolio-overlay-name .portfolio-overlay{ background: {$color_accent}; }
		.portfolio-detail-attributes ul li a:hover{ color: {$color_accent}; }
		a.catimage:hover .catimage-text{ background: {$color_accent}; }
		/* WooCommerce */
		.products li h3{font: {$font_body_weight} {$font_body_size} {$font_body_face}, Arial, Helvetica, sans-serif; color: {$font_body_color};}
		.woocommerce .button.checkout-button{background:{$color_accent};border-color:{$color_accent};}
		.woocommerce .products .onsale{background:{$color_accent};}
		.product .onsale{background:{$color_accent};}
		button.single_add_to_cart_button:hover{background:{$color_accent};}
		.woocommerce-tabs > ul > li.active a{color:{$color_accent};border-bottom-color:{$color_accent};}
		p.stars a:hover{background:{$color_accent};}
		p.stars a.active,p.stars a.active:after{background:{$color_accent};}
		.product_list_widget a{color:{$color_accent};}
		.woocommerce .widget_layered_nav li.chosen a{color:{$color_accent}!important;}
		.woocommerce .widget_product_categories > ul > li.current-cat > a{color:{$color_accent}!important;}
		.woocommerce .widget_product_categories > ul > li.current-cat:after{color:{$color_accent}!important;} 
		.woocommerce-message{ background: {$color_accent}; }
		.bbp-topics-front ul.super-sticky .bbp-topic-title:before,
		.bbp-topics ul.super-sticky .bbp-topic-title:before,
		.bbp-topics ul.sticky .bbp-topic-title:before,
		.bbp-forum-content ul.sticky .bbp-topic-title:before{color: {$color_accent}!important; }
		#subscription-toggle a:hover{ background: {$color_accent}; }
		.bbp-pagination-links span.current{ background: {$color_accent}; }
		div.wpcf7-mail-sent-ok,div.wpcf7-mail-sent-ng,div.wpcf7-spam-blocked,div.wpcf7-validation-errors{ background: {$color_accent}; }
		.wpcf7-not-valid{ border-color: {$color_accent} !important;}
		.products .button.add_to_cart_button{ color: {$color_accent}!important; }
		.minti_list.color-accent li:before{ color: {$color_accent}!important; }
		.blogslider_text .post-categories li a{ background-color: {$color_accent}; }
		.minti_zooming_slider .flex-control-nav li .minti_zooming_slider_ghost { background-color: {$color_accent}; }
		.minti_carousel.pagination_numbers .owl-dots .owl-dot.active{ background-color: {$color_accent}; }
		.wpb_content_element.wpb_tour .wpb_tabs_nav li.ui-tabs-active, .color-light .wpb_content_element.wpb_tour .wpb_tabs_nav li.ui-tabs-active{ background-color: {$color_accent}; }
		.masonry_icon i{ color: {$color_accent}; }
		.woocommerce-MyAccount-navigation-link.is-active a{ color: {$color_link};}

		/* Special Font */
		.font-special, .button, .counter-title, h6, .wpb_accordion .wpb_accordion_wrapper .wpb_accordion_header a, 
		.pricing-plan .pricing-plan-head h3, a.catimage, .divider-title,
		button, input[type='submit'], input[type='reset'], input[type='button'],
		.vc_pie_chart h4, .page-404 h3, .minti_masonrygrid_item h4{ font-family: '{$font_specialfont_face}', Arial, Helvetica, sans-serif; /*letter-spacing: {$font_specialfont_spacing}; font-weight: {$font_specialfont_weight};*/}

		.ui-helper-reset{ line-height: {$style_bodylineheight}; }

		/* User CSS from Theme Options */
		{$usercss}
		";
		
		// Remove Topbar on Mobiles if selected
		if($minti_data['switch_topbarresponsive'] == true) {
			$custom_css .= '@media only screen and (max-width: 767px) { #topbar{ display: none !important; } }';
		}

		// Set Header Background
		if(isset($minti_data['media_headerbg']['url']) && ($minti_data['media_headerbg']['url'] != '')){
			$custom_css .= '#header, #mobile-header{ background-image: url('.esc_url($minti_data['media_headerbg']['url']).') !important; background-repeat: no-repeat!important; background-position: top center !important; }';
		}

		// Set Page Background + Default Background
		if($minti_data['select_layoutstyle'] == 'boxed') {
			$custom_css .= 'body{';
			if( get_post_meta( get_the_ID(), 'minti_bgurl', true ) != '' || get_post_meta( get_the_ID(), 'minti_bgcolor', true ) != '' ) {
		
				if(get_post_meta( get_the_ID(), 'minti_bgcolor', true )) { $custom_css .= 'background-color: '.esc_attr(get_post_meta( get_the_ID(), 'minti_bgcolor', true )).';';}
				if(get_post_meta( get_the_ID(), 'minti_bgurl', true )) { $custom_css .= 'background-image: url('.esc_url(get_post_meta( get_the_ID(), 'minti_bgurl', true )).');';}
				if(get_post_meta( get_the_ID(), 'minti_bgstyle', true ) != 'stretch') { 
					$custom_css .= 'background-repeat: '.esc_attr(get_post_meta( get_the_ID(), 'minti_bgstyle', true )).';'; 
				} else { 
					$custom_css .= 'background-size: cover;'; 
				}
				
			} else {

				if($minti_data['style_bodybg']['background-color'] != "") { $custom_css .= 'background-color: '. esc_attr($minti_data['style_bodybg']['background-color']) .';'; }
				if($minti_data['style_bodybg']['background-image'] != "") { $custom_css .= 'background-image: url('.esc_url($minti_data['style_bodybg']['background-image']).');'; } 
				if($minti_data['style_bodybg']['background-size'] != 'cover') { 
					$custom_css .= 'background-repeat: '.esc_attr($minti_data['style_bodybg']['background-repeat']).';'; 
				} else { 
					$custom_css .= 'background-size: cover;'; 
				}
				
			}
			$custom_css .= "background-position: top center; background-attachment: fixed; }";
		}

		// Mobile Header Breakpoint
		if(isset($minti_data['style_mobileheaderbp']) && $minti_data['style_mobileheaderbp'] != '') {
			$custom_css .= '@media only screen and (max-width: '. esc_attr($minti_data['style_mobileheaderbp']) .') { #header, .sticky-wrapper{display:none;} #mobile-header{display:inherit} }';
		}

		// Back to Top on Mobiles
		if(isset($minti_data['select_backtotop']) && $minti_data['select_backtotop'] == 'desktop') {
			$custom_css .= '@media only screen and (max-width: 767px) { #back-to-top, #back-to-top a{ display: none; opacity: 0; } }';
		}
		if(isset($minti_data['select_backtotop']) && $minti_data['select_backtotop'] == 'mobile') {
			$custom_css .= '@media only screen and (min-width: 768px) { #back-to-top, #back-to-top a{ display: none; opacity: 0; } }';
		}

		// Responsive Custom CSS
		if(isset($minti_data['textarea_csscode_xl']) && $minti_data['textarea_csscode_xl'] != '') {
			$custom_css .= "@media only screen and (min-width: 1200px) {{$usercss_xl}}";
		}
		if(isset($minti_data['textarea_csscode_l']) && $minti_data['textarea_csscode_l'] != '') {
			$custom_css .= "@media only screen and (min-width: 960px) and (max-width: 1199px) {{$usercss_l}}";
		}
		if(isset($minti_data['textarea_csscode_m']) && $minti_data['textarea_csscode_m'] != '') {
			$custom_css .= "@media only screen and (min-width: 768px) and (max-width: 959px) {{$usercss_m}}";
		}
		if(isset($minti_data['textarea_csscode_s']) && $minti_data['textarea_csscode_s'] != '') {
			$custom_css .= "@media only screen and (min-width: 480px) and (max-width: 767px) {{$usercss_s}}";
		}
		if(isset($minti_data['textarea_csscode_xs']) && $minti_data['textarea_csscode_xs'] != '') {
			$custom_css .= "@media only screen and (max-width: 479px) {{$usercss_xs}}";
		}

		// Remove white space
		$custom_css =  preg_replace( '/\s+/', ' ', $custom_css );
		
		// output css on front end
		$css_output = "<style type=\"text/css\">\n" . $custom_css . "\n</style>";
		if( !empty($custom_css) ) {
			echo $css_output; // No need to escape
		}
		
	}
	
}
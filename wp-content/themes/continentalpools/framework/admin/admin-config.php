<?php

/* ------------------------------------------------------------------------ */
/* Redux Configuration
/* ------------------------------------------------------------------------ */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "minti_data";

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        'opt_name'          => 'minti_data',            // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
        'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
        'menu_type'         => 'submenu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'    => false,                    // Show the sections below the admin menu item or not
        'menu_title'        => __('Theme Options', 'minti-framework'),
        'page_title'        => __('Theme Options', 'minti-framework'),
        'save_defaults'     => true,
        'async_typography'  => true,                    // Use a asynchronous font on the front end or font string
        'admin_bar'         => false,                    // Show the panel pages on the admin bar
        'global_variable'   => 'minti_data',                      // Set a different name for your global variable other than the opt_name
        'dev_mode'          => false,                    // Show the time the page took to load, etc
        'customizer'        => false,                    // Enable basic customizer support
        'page_slug'         => 'minti_options',
        'system_info'       => false,
        'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
    );

    Redux::setArgs( $opt_name, $args );

    /* Set Extensions /-------------------------------------------------- */
    Redux::setExtensions( $opt_name, dirname( __FILE__ ) . '/extensions/' );

    /* General /--------------------------------------------------------- */
    Redux::setSection( $opt_name, array(
        'title'     => __('General', 'minti-framework'),
        'icon'      => 'el-icon-home',
        'fields'    => array(

            array(
                'id'        => 'general-global',
                'type'      => 'info',
                'desc'      => __('Global Settings', 'minti-framework')
            ),

            array(
                'id'       => 'switch_comments',
                'type'     => 'switch', 
                'title'    => __('Global Page Comments', 'minti-framework'),
                'subtitle' => __('You can globally disable the Page Comments (not Blog). Page specific Settings get overwritten.', 'minti-framework'),
                'default'  => false,
            ),

            array(
                'id'        => 'general-favicons',
                'type'      => 'info',
                'desc'      => __('Favicons', 'minti-framework')
            ),

            array(
                'id'       => 'media_favicon',
                'type'     => 'media', 
                'url'      => false,
                'title'    => __('Favicon Upload (16x16)', 'minti-framework'),
                'subtitle' => __('Upload your Favicon (16x16px ico/png - use <a href="http://www.favicon.cc/" target="_blank">favicon.cc</a> to make sure its fully compatible)', 'minti-framework'),
            ),

            array(
                'id'       => 'media_favicon_iphone',
                'type'     => 'media', 
                'url'      => false,
                'title'    => __('Apple iPhone Icon Upload (57x57)', 'minti-framework'),
                'subtitle' => __('Upload your Apple Touch Icon (57x57px png)', 'minti-framework'),
            ),

            array(
                'id'       => 'media_favicon_iphone_retina',
                'type'     => 'media', 
                'url'      => false,
                'title'    => __('Apple iPhone Retina Icon Upload (120x120)', 'minti-framework'),
                'subtitle' => __('Upload your Apple Touch Retina Icon (120x120 png)', 'minti-framework'),
            ),

            array(
                'id'       => 'media_favicon_ipad',
                'type'     => 'media', 
                'url'      => false,
                'title'    => __('Apple iPad Mini Icon Upload (76x76)', 'minti-framework'),
                'subtitle' => __('Upload your Apple iPad Mini Icon (76x76px png)', 'minti-framework'),
            ),

            array(
                'id'       => 'media_favicon_ipad_retina',
                'type'     => 'media', 
                'url'      => false,
                'title'    => __('Apple iPad Retina Icon Upload (152x152)', 'minti-framework'),
                'subtitle' => __('Upload your Apple Touch Retina Icon (152x152 png)', 'minti-framework'),
            ),

        ),
    ) );

    /* Layout /--------------------------------------------------------- */
    Redux::setSection( $opt_name, array(
        'title'     => __('Layout', 'minti-framework'),
        'icon'      => 'el-icon-th',
        'fields'    => array(

            array(
                'id'        => 'layout-responsive',
                'type'      => 'info',
                'desc'      => __('Mobile', 'minti-framework'),
            ),

            // array(
            //     'id'       => 'switch_responsive',
            //     'type'     => 'switch', 
            //     'title'    => __('Responsive Layout', 'minti-framework'),
            //     'subtitle'  => __('Enable / Disable Site Responsiveness.', 'minti-framework'),
            //     'description'  => __('<strong>Note:</strong> If you use Visual Composer you also need to disable the responsiveness in Settings > Visual Composer.', 'minti-framework'),
            //     'default'  => true,
            // ),

            array(
                'id'       => 'switch_zoom',
                'type'     => 'switch', 
                'title'    => __('Zoom on Mobile Devices', 'minti-framework'),
                'subtitle'  => __('Enable / Disable Pinch-to-Zoom on mobile devices.', 'minti-framework'),
                'default'  => false,
            ),

            array(
                'id'        => 'layout-general',
                'type'      => 'info',
                'desc'      => __('General Options & Layout', 'minti-framework')
            ),

            array(
                'id'       => 'select_backtotop',
                'type'     => 'select',
                'title'    => __('Back to Top Button', 'minti-framework'), 
                'subtitle' => __('Enable / Disable Back to Top Button', 'minti-framework'),
                'options'  => array(
                    'all' => 'Enable on all Devices',
                    'desktop' => 'Enable on Desktop only',
                    'mobile' => 'Enable on Mobile only',
                    'hide' => 'Disable',
                ),
                'default'  => 'all',
            ),

            array(
                'id'       => 'switch_smoothscroll',
                'type'     => 'switch', 
                'title'    => __('Smooth Scroll', 'minti-framework'),
                'subtitle' => __('Enable / Disable Smooth Scroll', 'minti-framework'),
                'default'  => true,
            ),

            array(
                'id'       => 'select_layoutstyle',
                'type'     => 'select',
                'title'    => __('Layout Style', 'minti-framework'), 
                'subtitle' => __('Choose your Layout Style', 'minti-framework'),
                'options'  => array(
                    'fullwidth' => 'Fullwidth',
                    'boxed' => 'Boxed Layout',
                ),
                'default'  => 'fullwidth',
            ),

            array(
                'id'        => 'style_bodybg',
                'type'      => 'background',
                //'output'    => array('body'),
                'transparent' => false,
                'background-attachment' => false,
                'background-position' => false,
                'preview' => false,
                'title'     => __('Default Background for Boxed Layout', 'minti-framework'),
                'subtitle'  => __('Define the default Background when your Layout Mode is set to Boxed Layout', 'minti-framework'),
                'required'  => array('select_layoutstyle', "=", 'boxed'),
            ),

            array(
                'id'       => 'switch_simpleselect',
                'type'     => 'switch', 
                'title'    => __('Custom Select/Dropdown Styling', 'minti-framework'),
                'subtitle' => __('Enable / Disable select field styling', 'minti-framework'),
                'default'  => true,
            ),

        ),
    ) );

    /* Styling /--------------------------------------------------------- */
    Redux::setSection( $opt_name, array(
        'title'     => __('Styling', 'minti-framework'),
        'icon'      => 'el-icon-brush',
        'fields'    => array(

            array(
                'id'        => 'styling-main',
                'type'      => 'info',
                'desc'      => __('General', 'minti-framework'),
            ),

            array(
                'id'=>'color_accent',
                'type' => 'color',
                'title' => __('Accent Color', 'minti-framework'),
                'subtitle' => __('Default: #1cbac8', 'minti-framework'),
                'default' => '#1cbac8',
                'transparent' => false,
                'validate' => 'color',
            ),

            array(
                'id'        => 'styling-links',
                'type'      => 'info',
                'desc'      => __('Links', 'minti-framework'),
            ),

            array(
                'id'=>'color_link',
                'type' => 'color',
                'title' => __('Link Color', 'minti-framework'),
                'subtitle' => __('Default: #1cbac8', 'minti-framework'),
                'default' => '#1cbac8',
                'transparent' => false,
                'validate' => 'color',
            ),

            array(
                'id'=>'color_hover',
                'type' => 'color',
                'title' => __('Link Hover Color', 'minti-framework'),
                'subtitle' => __('Default: #333333', 'minti-framework'),
                'default' => '#333333',
                'transparent' => false,
                'validate' => 'color',
            ),

            array(
                'id'        => 'styling-topbar',
                'type'      => 'info',
                'desc'      => __('Topbar', 'minti-framework'),
                'required' => array( 
                    array('header_layout', "=", 'v2') 
                )
            ),

            array(
                'id'=>'color_topbar_bg',
                'type' => 'color',
                'title' => __('Topbar Background Color', 'minti-framework'),
                'subtitle' => __('Default: #f5f5f5', 'minti-framework'),
                'default' => '#f5f5f5',
                'transparent' => false,
                'validate' => 'color',
                'required' => array( 
                    array('header_layout', "=", 'v2') 
                )
            ),

            array(
                'id'=>'color_topbar_text',
                'type' => 'color',
                'title' => __('Topbar Text Color', 'minti-framework'),
                'subtitle' => __('Default: #777777', 'minti-framework'),
                'default' => '#777777',
                'transparent' => false,
                'validate' => 'color',
                'required' => array( 
                    array('header_layout', "=", 'v2') 
                )
            ),

            array(
                'id'=>'color_topbar_link',
                'type' => 'color',
                'title' => __('Topbar Link Color', 'minti-framework'),
                'subtitle' => __('Default: #999999', 'minti-framework'),
                'default' => '#999999',
                'transparent' => false,
                'validate' => 'color',
                'required' => array( 
                    array('header_layout', "=", 'v2') 
                )
            ),

            array(
                'id'=>'color_topbar_linkhover',
                'type' => 'color',
                'title' => __('Topbar Link Hover Color', 'minti-framework'),
                'subtitle' => __('Default: #333333', 'minti-framework'),
                'default' => '#333333',
                'transparent' => false,
                'validate' => 'color',
                'required' => array( 
                    array('header_layout', "=", 'v2') 
                )
            ),

            array(
                'id'        => 'styling-links',
                'type'      => 'info',
                'desc'      => __('Header', 'minti-framework'),
            ),

            array(
                'id'=>'color_headerbg',
                'type' => 'color',
                'title' => __('Header Background Color', 'minti-framework'),
                'subtitle' => __('Default: #ffffff', 'minti-framework'),
                'default' => '#ffffff',
                'transparent' => false,
                'validate' => 'color',
            ),

            array(
                'id'       => 'media_headerbg',
                'type'     => 'media', 
                'url'      => false,
                'title'    => __('Header Background Image', 'minti-framework'),
                'description' => __('Optional: Upload a Background Image for the Header part. Width 1200px height as defined in the settings.', 'minti-framework'),
            ),

            array(
                'id'=>'color_headericon',
                'type' => 'color',
                'title' => __('Header Icon Color', 'minti-framework'),
                'subtitle' => __('Default: #bbbbbb', 'minti-framework'),
                'default' => '#bbbbbb',
                'transparent' => false,
                'validate' => 'color',
            ),

            array(
                'id'=>'color_headericonhover',
                'type' => 'color',
                'title' => __('Header Icon Hover Color', 'minti-framework'),
                'subtitle' => __('Default: #999999', 'minti-framework'),
                'default' => '#999999',
                'transparent' => false,
                'validate' => 'color',
            ),

            array(
                'id'=>'color_searchinput',
                'type' => 'color',
                'title' => __('Search Input Color', 'minti-framework'),
                'subtitle' => __('Default: #666666', 'minti-framework'),
                'default' => '#666666',
                'transparent' => false,
                'validate' => 'color',
            ),

            array(
                'id'=>'color_navdivider',
                'type' => 'color',
                'title' => __('Header Divider / Border Color', 'minti-framework'),
                'subtitle' => __('Default: #efefef', 'minti-framework'),
                'default' => '#efefef',
                'transparent' => false,
                'validate' => false,
            ),

            array(
                'id'=>'font_slogan',
                'type' => 'typography', 
                'title' => __('Slogan', 'minti-framework'),
                'compiler'=>false,
                'google'=>true,
                'font-backup'=>false,
                'subsets'=>true,
                'font-size'=>true,
                'line-height'=>false,
                'word-spacing'=>false,
                'letter-spacing'=>false,
                'text-align'=>false,
                'color'=>true,
                'preview'=>false,
                //'output' => array('body'),
                'units'=>'px',
                'subtitle'=> __('Select your Slogan Color. <br />Default: 20px, #777777', 'minti-framework'),
                'default'=> array(
                    'color'=>"#777777",
                    'font-family'=>'Open Sans', 
                    'font-size'=>'20px',
                    'font-style'=>'400',
                    'font-weight'=>'400',
                ),
                'required' => array( 
                    array('header_layout', "=", 'v3') 
                )
            ),

            array(
                'id'        => 'styling-navigation',
                'type'      => 'info',
                'desc'      => __('Navigation', 'minti-framework'),
            ),

            array(
                'id'=>'font_nav',
                'type' => 'typography', 
                'title' => __('Navigation Link', 'minti-framework'),
                'compiler'=>false,
                'google'=>true,
                'font-backup'=>false,
                'subsets'=>true,
                'font-size'=>true,
                'line-height'=>false,
                'word-spacing'=>false,
                'letter-spacing'=>false,
                'text-align'=>false,
                'color'=>true,
                'preview'=>false,
                //'output' => array('body'),
                'units'=>'px',
                'subtitle'=> __('Select your Navigation Font. <br />Default: 13px, 700, #777777', 'minti-framework'),
                'default'=> array(
                    'color'=>"#777777",
                    'font-family'=>'Montserrat', 
                    'font-size'=>'13px',
                    'font-style'=>'700',
                    'font-weight'=>'700',
                )
            ),

            array(
                'id'=>'color_navlinkhover',
                'type' => 'color',
                'title' => __('Navigation Link Hover Color', 'minti-framework'),
                'subtitle' => __('Default: #1cbac8', 'minti-framework'),
                'default' => '#1cbac8',
                'transparent' => false,
                'validate' => 'color',
            ),

            array(
                'id'=>'color_navlinkactive',
                'type' => 'color',
                'title' => __('Navigation Link Active Color', 'minti-framework'),
                'subtitle' => __('Default: #1cbac8', 'minti-framework'),
                'default' => '#1cbac8',
                'transparent' => false,
                'validate' => 'color',
            ),

            array(
                'id'        => 'styling-subnavigation',
                'type'      => 'info',
                'desc'      => __('Subnavigation & Mobile Menu', 'minti-framework'),
            ),

            array(
                'id'=>'color_subnavbg',
                'type' => 'color',
                'title' => __('Subnavigation Background Color', 'minti-framework'),
                'subtitle' => __('Default: #666666', 'minti-framework'),
                'default' => '#262626',
                'transparent' => false,
                'validate' => 'color',
            ),

            array(
                'id'=>'font_subnav',
                'type' => 'typography', 
                'title' => __('Subnavigation Link', 'minti-framework'),
                'compiler'=>false,
                'google'=>true,
                'font-backup'=>false,
                'subsets'=>true,
                'font-size'=>true,
                'line-height'=>false,
                'word-spacing'=>false,
                'letter-spacing'=>false,
                'text-align'=>false,
                'color'=>true,
                'preview'=>false,
                //'output' => array('body'),
                'units'=>'px',
                'subtitle'=> __('Select your Subnavigation Font. <br />Default: 13px, #bbbbbb', 'minti-framework'),
                'default'=> array(
                    'color'=>"#bbbbbb",
                    'font-family'=>'Open Sans', 
                    'font-size'=>'13px',
                    'font-style'=>'400',
                    'font-weight'=>'400',
                )
            ),

            array(
                'id'=>'color_subnavlinkhover',
                'type' => 'color',
                'title' => __('Subnavigation Link Hover Color / Active Color', 'minti-framework'),
                'subtitle' => __('Default: #ffffff', 'minti-framework'),
                'default' => '#ffffff',
                'transparent' => false,
                'validate' => 'color',
            ),

            array(
                'id'=>'color_subnavborder',
                'type' => 'color',
                'title' => __('Subnavigation Border Color', 'minti-framework'),
                'subtitle' => __('Default: #333333', 'minti-framework'),
                'default' => '#333333',
                'transparent' => false,
                'validate' => 'color',
            ),

            array(
                'id'=>'color_megamenuheading',
                'type' => 'color',
                'title' => __('Mega Menu Heading Color', 'minti-framework'),
                'subtitle' => __('Default: #ffffff', 'minti-framework'),
                'default' => '#ffffff',
                'transparent' => false,
                'validate' => 'color',
            ),

            array(
                'id'=>'color_megamenuhover',
                'type' => 'color',
                'title' => __('Mega Menu Hover Background', 'minti-framework'),
                'subtitle' => __('Default: #333333', 'minti-framework'),
                'default' => '#333333',
                'transparent' => false,
                'validate' => 'color',
            ),

            array(
                'id'=>'color_mobilesearchbg',
                'type' => 'color',
                'title' => __('Mobile Menu Search Background Color', 'minti-framework'),
                'subtitle' => __('Default: #444444', 'minti-framework'),
                'default' => '#444444',
                'transparent' => false,
                'validate' => 'color',
            ),

            array(
                'id'=>'color_mobilesearch',
                'type' => 'color',
                'title' => __('Mobile Menu Search Color', 'minti-framework'),
                'subtitle' => __('Default: #cccccc', 'minti-framework'),
                'default' => '#cccccc',
                'transparent' => false,
                'validate' => 'color',
            ),

            array(
                'id'        => 'styling-body',
                'type'      => 'info',
                'desc'      => __('Body', 'minti-framework'),
            ),

            array(
                'id'=>'font_body',
                'type' => 'typography', 
                'title' => __('Body Font', 'minti-framework'),
                'compiler'=>false,
                'google'=>true,
                'font-backup'=>false,
                'subsets'=>true,
                'font-size'=>true,
                'line-height'=>false,
                'word-spacing'=>false,
                'letter-spacing'=>false,
                'text-align'=>false,
                'color'=>true,
                'preview'=>false,
                'all_styles'=>true,
                //'output' => array('body'),
                'units'=>'px',
                'subtitle'=> __('Default: 14px, #777777', 'minti-framework'),
                'default'=> array(
                    'color'=>"#777777",
                    'font-family'=>'Open Sans', 
                    'font-size'=>'13px',
                    'font-weight'=>'400',
                )
            ),

            array(
                'id'       => 'style_bodylineheight',
                'type'     => 'text',
                'title'    => __('Body Font Line Height', 'minti-framework'),
                'subtitle' => __('Default: 1.9 (Could also be 23px, or 0.3em)', 'minti-framework'),
                'default' => '1.9',
            ),

            array(
                'id'=>'color_bodybg',
                'type' => 'color',
                'title' => __('Body Backround Color', 'minti-framework'),
                'subtitle' => __('Default: #ffffff', 'minti-framework'),
                'default' => '#ffffff',
                'transparent' => false,
                'validate' => 'color',
            ),

            array(
                'id'        => 'styling-footer',
                'type'      => 'info',
                'desc'      => __('Footer', 'minti-framework'),
                'required' => array('switch_footerwidgets', "=", '1'),
            ),

            array(
                'id'=>'color_footerbg',
                'type' => 'color',
                'title' => __('Footer Background Color', 'minti-framework'),
                'subtitle' => __('Default: #262626', 'minti-framework'),
                'default' => '#262626',
                'transparent' => false,
                'validate' => 'color',
                'required' => array('switch_footerwidgets', "=", '1'),
            ),

            array( 
                'id'       => 'border_footertop',
                'type'     => 'border',
                'all'       => true,
                'title'    => __('Footer Border Top Color', 'minti-framework'),
                'subtitle' => __('Default: 4px none #1cbac8', 'minti-framework'),
                'default'  => array(
                    'border-color'  => '#1cbac8', 
                    'border-style'  => 'none', 
                    'border-top'    => '4px',
                ),
                'required' => array('switch_footerwidgets', "=", '1'),
            ),

            array(
                'id'=>'font_footerheadline',
                'type' => 'typography', 
                'title' => __('Footer Headline Font', 'minti-framework'),
                'compiler'=>false,
                'google'=>true,
                'font-backup'=>false,
                'subsets'=>true,
                'font-size'=>true,
                'line-height'=>false,
                'word-spacing'=>false,
                'letter-spacing'=>false,
                'text-align'=>false,
                'color'=>true,
                'preview'=>false,
                //'output' => array('body'),
                'units'=>'px',
                'subtitle'=> __('Default: 13px, #ffffff', 'minti-framework'),
                'default'=> array(
                    'color'=>"#ffffff",
                    'font-family'=>'Montserrat', 
                    'font-size'=>'13px',
                    'font-style'=>'700',
                    'font-weight'=>'700',
                ),
                'required' => array('switch_footerwidgets', "=", '1'),
            ),

            array(
                'id'=>'color_footertext',
                'type' => 'color',
                'title' => __('Footer Text Color', 'minti-framework'),
                'subtitle' => __('Default: #888888', 'minti-framework'),
                'default' => '#888888',
                'transparent' => false,
                'validate' => 'color',
                'required' => array('switch_footerwidgets', "=", '1'),
            ),

            array(
                'id'=>'color_footerlink',
                'type' => 'color',
                'title' => __('Footer Link Color', 'minti-framework'),
                'subtitle' => __('Default: #888888', 'minti-framework'),
                'default' => '#888888',
                'transparent' => false,
                'validate' => 'color',
                'required' => array('switch_footerwidgets', "=", '1'),
            ),

            array(
                'id'=>'color_footerlinkhover',
                'type' => 'color',
                'title' => __('Footer Link Hover Color', 'minti-framework'),
                'subtitle' => __('Default: #ffffff', 'minti-framework'),
                'default' => '#ffffff',
                'transparent' => false,
                'validate' => 'color',
                'required' => array('switch_footerwidgets', "=", '1'),
            ),

            array(
                'id'=>'style_footerwidgetborder',
                'type' => 'color',
                'title' => __('Footer Widget Border Color', 'minti-framework'),
                'subtitle' => __('Default: #333333', 'minti-framework'),
                'default' => '#333333',
                'transparent' => false,
                'validate' => 'color',
                'required' => array('switch_footerwidgets', "=", '1'),
            ),

            array(
                'id'        => 'styling-copyright',
                'type'      => 'info',
                'desc'      => __('Copyright', 'minti-framework'),
                'required' => array('switch_copyright', "=", '1'),
            ),

            array(
                'id'=>'color_copyrightbg',
                'type' => 'color',
                'title' => __('Copyright Backround Color', 'minti-framework'),
                'subtitle' => __('Default: #1b1b1b', 'minti-framework'),
                'default' => '#1b1b1b',
                'transparent' => false,
                'validate' => 'color',
                'required' => array('switch_copyright', "=", '1'),
            ),

            array(
                'id'=>'color_copyrighttext',
                'type' => 'color',
                'title' => __('Copyright Text Color', 'minti-framework'),
                'subtitle' => __('Default: #777777', 'minti-framework'),
                'default' => '#777777',
                'transparent' => false,
                'validate' => 'color',
                'required' => array('switch_copyright', "=", '1'),
            ),

            array(
                'id'=>'color_copyrightlink',
                'type' => 'color',
                'title' => __('Copyright Link Color', 'minti-framework'),
                'subtitle' => __('Default: #999999', 'minti-framework'),
                'default' => '#999999',
                'transparent' => false,
                'validate' => 'color',
                'required' => array('switch_copyright', "=", '1'),
            ),

            array(
                'id'=>'color_copyrightlinkhover',
                'type' => 'color',
                'title' => __('Copyright Link Hover', 'minti-framework'),
                'subtitle' => __('Default: #cccccc', 'minti-framework'),
                'default' => '#cccccc',
                'transparent' => false,
                'validate' => 'color',
                'required' => array('switch_copyright', "=", '1'),
            ),

            array(
                'id'        => 'styling-typography',
                'type'      => 'info',
                'desc'      => __('Typography', 'minti-framework'),
            ),

            array(
                'id'=>'font_headline',
                'type' => 'typography', 
                'title' => __('Headline Font', 'minti-framework'),
                'compiler'=>false,
                'google'=>true,
                'font-backup'=>false,
                'subsets'=>true,
                'font-size'=>false,
                'line-height'=>false,
                'word-spacing'=>false,
                'letter-spacing'=>false,
                'text-align'=>false,
                'color'=>true,
                'preview'=>false,
                'all_styles'=>true,
                //'output' => array('body'),
                'units'=>'px',
                'subtitle'=> __('Specify the H1 Headline font properties. Default: #333333', 'minti-framework'),
                'default'=> array(
                    'color'=>"#333333",
                    'font-family'=>'Open Sans', 
                    'font-style'=>'600',
                    'font-weight'=>'600',
                ),
            ),

            array(
                'id'       => 'size_h1',
                'type'     => 'text',
                'title'    => __('Headline H1 Font Size', 'minti-framework'),
                'subtitle' => __('Default: 28px', 'minti-framework'),
                'default' => '28px',
            ),

            array(
                'id'       => 'size_h2',
                'type'     => 'text',
                'title'    => __('Headline H2 Font Size', 'minti-framework'),
                'subtitle' => __('Default: 24px', 'minti-framework'),
                'default' => '24px',
            ),

            array(
                'id'       => 'size_h3',
                'type'     => 'text',
                'title'    => __('Headline H3 Font Size', 'minti-framework'),
                'subtitle' => __('Default: 20px', 'minti-framework'),
                'default' => '20px',
            ),

            array(
                'id'       => 'size_h4',
                'type'     => 'text',
                'title'    => __('Headline H4 Font Size', 'minti-framework'),
                'subtitle' => __('Default: 18px', 'minti-framework'),
                'default' => '16px',
            ),

            array(
                'id'       => 'size_h5',
                'type'     => 'text',
                'title'    => __('Headline H5 Font Size', 'minti-framework'),
                'subtitle' => __('Default: 16px', 'minti-framework'),
                'default' => '16px',
            ),

            array(
                'id'       => 'size_h6',
                'type'     => 'text',
                'title'    => __('Headline H6 Font Size', 'minti-framework'),
                'subtitle' => __('Default: 14px', 'minti-framework'),
                'default' => '16px',
            ),

            array(
                'id'        => 'styling-sidebar',
                'type'      => 'info',
                'desc'      => __('Sidebar', 'minti-framework'),
            ),

            array(
                'id'=>'font_sidebarheadline',
                'type' => 'typography', 
                'title' => __('Sidebar Headline Font', 'minti-framework'),
                'compiler'=>false,
                'google'=>true,
                'font-backup'=>false,
                'subsets'=>true,
                'font-size'=>true,
                'line-height'=>false,
                'word-spacing'=>false,
                'letter-spacing'=>false,
                'text-align'=>false,
                'color'=>true,
                'preview'=>false,
                //'output' => array('body'),
                'units'=>'px',
                'subtitle'=> __('Default: 13px, #444444', 'minti-framework'),
                'default'=> array(
                    'color'=>"#444444",
                    'font-size'=>'14px',
                    'font-family'=>'Montserrat', 
                    'font-style'=>'700',
                    'font-weight'=>'700',
                ),
            ),

            array(
                'id'=>'color_sidebarborder',
                'type' => 'color',
                'title' => __('Sidebar Border Color', 'minti-framework'),
                'subtitle' => __('Default: #efefef', 'minti-framework'),
                'default' => '#efefef',
                'transparent' => true,
                'validate' => 'color',
            ),

            array(
                'id'        => 'styling-customfont',
                'type'      => 'info',
                'desc'      => __('Special Font', 'minti-framework'),
            ),

            array(
                'id'=>'font_specialfont',
                'type' => 'typography', 
                'title' => __('Special Font', 'minti-framework'),
                'compiler'=>false,
                'google'=>true,
                'font-backup'=>false,
                'subsets'=>true,
                'font-size'=>false,
                'line-height'=>false,
                'word-spacing'=>false,
                'letter-spacing'=>true,
                'text-align'=>false,
                'color'=>false,
                'preview'=>false,
                'all_styles'=>true,
                //'output' => array('body'),
                'units'=>'px',
                'subtitle'=> __('This font is used for Buttons, parts in Shortcodes and Visual Elements.', 'minti-framework'),
                'default'=> array(
                    'color'=>"#444444",
                    'letter-spacing'=>'0',
                    'font-family'=>'Montserrat', 
                    'font-weight'=>'700',
                    'font-style'=>'700',
                ),
            ),


        ),
    ) );

    /* Header /--------------------------------------------------------- */
    Redux::setSection( $opt_name, array(
        'title'     => __('Header', 'minti-framework'),
        'icon'      => 'el-icon-file-edit',
        'fields'    => array(

            array(
                'id'        => 'header-layout',
                'type'      => 'info',
                'desc'      => __('Header Layout', 'minti-framework')
            ),

            array(
                'id'       => 'header_layout',
                'type'     => 'image_select',
                'title'    => __('Header Layout', 'minti-framework'), 
                'subtitle' => __('Select the header Layout', 'minti-framework'),
                'description' => __('<strong>PLEASE NOTE:</strong> Only Header 1 & 5 can be transparent. Keep that in mind when choosing your Page specific Headers.', 'minti-framework'),
                'options'  => array(
                    'v1'      => array(
                        'alt'   => 'Header 1', 
                        'img'   => get_template_directory_uri().'/framework/images/admin/header1.jpg'
                    ),
                    'v2'      => array(
                        'alt'   => 'Header 2', 
                        'img'   => get_template_directory_uri().'/framework/images/admin/header2.jpg'
                    ),
                    'v3'      => array(
                        'alt'   => 'Header 3', 
                        'img'   => get_template_directory_uri().'/framework/images/admin/header3.jpg'
                    ),
                    'v4'      => array(
                        'alt'   => 'Header 3', 
                        'img'   => get_template_directory_uri().'/framework/images/admin/header4.jpg'
                    ),
                    'v5'      => array(
                        'alt'   => 'Header 5', 
                        'img'   => get_template_directory_uri().'/framework/images/admin/header5.jpg'
                    ),
                ),
                'default' => 'v1'
            ),

            array(
                'id'       => 'select_topbarleft',
                'type'     => 'select',
                'title'    => __('Top Bar Left Content', 'minti-framework'), 
                'options'  => array(
                    'Text Field' => 'Text Field',
                    'Social Media' => 'Social Media',
                    'Navigation' => 'Navigation',
                    'Leave Empty' => 'Leave Empty',
                ),
                'default'  => 'Leave Empty',
                'required' => array( 
                    array('header_layout', "=", 'v2') 
                )
            ),

            array(
                'id'       => 'select_topbarright',
                'type'     => 'select',
                'title'    => __('Top Bar Right Content', 'minti-framework'), 
                'options'  => array(
                    'Text Field' => 'Text Field',
                    'Social Media' => 'Social Media',
                    'Navigation' => 'Navigation',
                    'Leave Empty' => 'Leave Empty',
                ),
                'default'  => 'Leave Empty',
                'required' => array( 
                    array('header_layout', "=", 'v2') 
                )
            ),

            array(
                'id'=>'textarea_topbar',
                'type' => 'textarea',
                'title' => __('Topbar Textfield', 'minti-framework'), 
                'subtitle' => __('Enter your Text for the Topbar (HTML allowed).', 'minti-framework'),
                'default' => '',
                'required' => array( 
                    array('header_layout', "=", 'v2') 
                )
            ),

            array(
                'id'       => 'switch_topbarresponsive',
                'type'     => 'switch', 
                'title'    => __('Hide Topbar on Mobiles?', 'minti-framework'),
                'subtitle'  => __('Enable / Disable to hide Topbar on Mobile Devices.', 'minti-framework'),
                'default'  => false,
                'required' => array( 
                    array('header_layout', "=", 'v2') 
                )
            ),

            array(
                'id'=>'textarea_slogan',
                'type' => 'textarea',
                'title' => __('Slogan', 'minti-framework'), 
                'subtitle' => __('Enter your Text for the Slogan (HTML allowed).', 'minti-framework'),
                'default' => 'For the next generation of big businesses.',
                'required' => array( 
                    array('header_layout', "=", 'v3') 
                )
            ),

            array(
                'id'       => 'switch_stickyheader',
                'type'     => 'switch', 
                'title'    => __('Sticky Header', 'minti-framework'),
                'subtitle'  => __('Enable / Disable Sticky Header.', 'minti-framework'),
                'default'  => true,
            ),
            
            array(
                'id'       => 'switch_searchform',
                'type'     => 'switch', 
                'title'    => __('Search in Header', 'minti-framework'),
                'subtitle' => __('Enable / Disable Search in Header', 'minti-framework'),
                'default'  => true,
                'required' => array( 
                    array('header_layout', "!=", 'v3'),
                    array('header_layout', "!=", 'v4')
                )
            ),

            array(
                'id'       => 'switch_searchformmobile',
                'type'     => 'switch', 
                'title'    => __('Searchform in Mobile Navigation', 'minti-framework'),
                'subtitle' => __('Enable / Disable Searchform in Mobile Navigation', 'minti-framework'),
                'default'  => true,
            ),

            array(
                'id'       => 'switch_pagescroll',
                'type'     => 'switch', 
                'title'    => __('Enable OnePage Navigation?', 'minti-framework'),
                'subtitle'  => __('Enable / Disable One Page Navigation. Read the Documentation on how to set everything up correctly.', 'minti-framework'),
                'default'  => false,
            ),

            array(
                'id'        => 'layout-logo',
                'type'      => 'info',
                'desc'      => __('Logo', 'minti-framework')
            ),

            array(
                'id'       => 'media_logo',
                'type'     => 'media', 
                'url'      => false,
                'title'    => __('Logo Upload', 'minti-framework'),
            ),

            array(
                'id'       => 'media_logo_retina',
                'type'     => 'media', 
                'url'      => false,
                'title'    => __('Retina Logo Upload', 'minti-framework'),
                'subtitle' => __('Upload your Retina Logo. This should be your Logo in double size (If your logo is 100 x 20px, it should be 200 x 40px)', 'minti-framework'),
            ),

            array(
                'id'        => 'layout-logo',
                'type'      => 'info',
                'desc'      => __('Logo for Transparent Background', 'minti-framework')
            ),

            array(
                'id'       => 'media_logo_transparent',
                'type'     => 'media', 
                'url'      => false,
                'title'    => __('Transparent Logo Upload', 'minti-framework'),
                'subtitle' => __('Upload your logo here for the Transparent Header (usually a white version of your logo).', 'minti-framework'),
            ),

            array(
                'id'       => 'media_logo_retina_transparent',
                'type'     => 'media', 
                'url'      => false,
                'title'    => __('Transparent Retina Logo Upload', 'minti-framework'),
                'subtitle' => __('Upload your Retina Logo for the Transparent Header. This should be your Logo in double size (If your logo is 100 x 20px, it should be 200 x 40px)', 'minti-framework'),
            ),

            array(
                'id'        => 'layout-headersettings',
                'type'      => 'info',
                'desc'      => __('Header-V1, Header-V2, Header-V5 & Mobile Header Settings', 'minti-framework')
            ),

            array(
                'id'       => 'style_headerheight',
                'type'     => 'text',
                'title'    => __('Header Height', 'minti-framework'),
                'subtitle' => __('Enter Header Height. Default: 90px', 'minti-framework'),
                'default' => '90px',
            ),

            array(
                'id'       => 'style_logotopmargin',
                'type'     => 'text',
                'title'    => __('Logo Top Margin', 'minti-framework'),
                'subtitle' => __('Enter your Top margin value for the Logo in pixels (Default: 34px)', 'minti-framework'),
                'default' => '34px',
            ),

            array(
                'id'       => 'style_navmargintop',
                'type'     => 'text',
                'title'    => __('Navigation Top Margin', 'minti-framework'),
                'subtitle' => __('Default: 35px', 'minti-framework'),
                'default' => '35px',
            ),

            array(
                'id'        => 'layout-headerv3settings',
                'type'      => 'info',
                'desc'      => __('Header-V3 & Header-V4 Settings', 'minti-framework'),
                'required' => array( 
                    array('header_layout', "!=", 'v1'),
                    array('header_layout', "!=", 'v2'),
                    array('header_layout', "!=", 'v5')  
                )
            ),

            array(
                'id'       => 'style_hv3_topmargin',
                'type'     => 'text',
                'title'    => __('Logo Top Margin', 'minti-framework'),
                'subtitle' => __('Enter Logo Top Margin. Default: 30px', 'minti-framework'),
                'default' => '30px',
                'required' => array( 
                    array('header_layout', "!=", 'v1'),
                    array('header_layout', "!=", 'v2'),
                    array('header_layout', "!=", 'v5')  
                )
            ),

            array(
                'id'       => 'style_hv3_bottommargin',
                'type'     => 'text',
                'title'    => __('Logo Bottom Margin', 'minti-framework'),
                'subtitle' => __('Enter Logo Bottom Margin. Default: 30px', 'minti-framework'),
                'default' => '30px',
                'required' => array( 
                    array('header_layout', "!=", 'v1'),
                    array('header_layout', "!=", 'v2'),
                    array('header_layout', "!=", 'v5')  
                )
            ),

            array(
                'id'       => 'style_hv3slogan_topmargin',
                'type'     => 'text',
                'title'    => __('Slogan Top Margin', 'minti-framework'),
                'subtitle' => __('Enter Slogan Top Margin. Default: 30px', 'minti-framework'),
                'default' => '26px',
                'required' => array( 
                    array('header_layout', "=", 'v3') 
                )
            ),

            array(
                'id'        => 'layout-mobileheader',
                'type'      => 'info',
                'desc'      => __('Mobile Header Breakpoint', 'minti-framework')
            ),

            array(
                'id'       => 'style_mobileheaderbp',
                'type'     => 'text',
                'title'    => __('Mobile Header Breakpoint', 'minti-framework'),
                'subtitle' => __('Theme Breakpoints are: 1199px, 959px, 767px. Default: 959px', 'minti-framework'),
                'default' => '959px',
            ),

        ),
    ) );

    /* Social Media /--------------------------------------------------------- */
    Redux::setSection( $opt_name, array(
        'title'     => __('Social Media', 'minti-framework'),
        'icon'      => 'el-icon-twitter',
        'fields'    => array(

            array(
                'id'        => 'social-media',
                'type'      => 'info',
                'desc'      => __('Social Media Icons (Remember to include the "http://" in all URLs)', 'minti-framework')
            ),

            array(
                'id'       => 'social_dribbble',
                'type'     => 'text',
                'title'    => __('Dribbble', 'minti-framework'),
                'subtitle' => __('Enter URL to your Dribbble Account', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'       => 'social_facebook',
                'type'     => 'text',
                'title'    => __('Facebook', 'minti-framework'),
                'subtitle' => __('Enter URL to your Facebook Account', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'       => 'social_foursquare',
                'type'     => 'text',
                'title'    => __('Foursquare', 'minti-framework'),
                'subtitle' => __('Enter URL to your Foursquare Account', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'       => 'social_flickr',
                'type'     => 'text',
                'title'    => __('Flickr', 'minti-framework'),
                'subtitle' => __('Enter URL to your Flickr Account', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'       => 'social_github',
                'type'     => 'text',
                'title'    => __('Github', 'minti-framework'),
                'subtitle' => __('Enter URL to your Github Account', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'       => 'social_googleplus',
                'type'     => 'text',
                'title'    => __('Google+', 'minti-framework'),
                'subtitle' => __('Enter URL to your Google+ Account', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'       => 'social_instagram',
                'type'     => 'text',
                'title'    => __('Instagram', 'minti-framework'),
                'subtitle' => __('Enter URL to your Instagram Account', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'       => 'social_linkedin',
                'type'     => 'text',
                'title'    => __('LinkedIn', 'minti-framework'),
                'subtitle' => __('Enter URL to your LinkedIn Account', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'       => 'social_pinterest',
                'type'     => 'text',
                'title'    => __('Pinterest', 'minti-framework'),
                'subtitle' => __('Enter URL to your Pinterest Account', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'       => 'social_renren',
                'type'     => 'text',
                'title'    => __('Renren', 'minti-framework'),
                'subtitle' => __('Enter URL to your Renren Account', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'       => 'social_rss',
                'type'     => 'text',
                'title'    => __('RSS', 'minti-framework'),
                'subtitle' => __('Enter URL to your RSS Account', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'       => 'social_skype',
                'type'     => 'text',
                'title'    => __('Skype', 'minti-framework'),
                'subtitle' => __('Enter URL to your Skype Account', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'       => 'social_soundcloud',
                'type'     => 'text',
                'title'    => __('Soundcloud', 'minti-framework'),
                'subtitle' => __('Enter URL to your Soundcloud Account', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'       => 'social_stackoverflow',
                'type'     => 'text',
                'title'    => __('Stack Overflow', 'minti-framework'),
                'subtitle' => __('Enter URL to your Stack Overflow Account', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'       => 'social_twitter',
                'type'     => 'text',
                'title'    => __('Twitter', 'minti-framework'),
                'subtitle' => __('Enter URL to your Twitter Account', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'       => 'social_tumblr',
                'type'     => 'text',
                'title'    => __('Tumblr', 'minti-framework'),
                'subtitle' => __('Enter URL to your Tumblr Account', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'       => 'social_vimeo',
                'type'     => 'text',
                'title'    => __('Vimeo', 'minti-framework'),
                'subtitle' => __('Enter URL to your Vimeo Account', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'       => 'social_vk',
                'type'     => 'text',
                'title'    => __('VK', 'minti-framework'),
                'subtitle' => __('Enter URL to your VK Account', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'       => 'social_weibo',
                'type'     => 'text',
                'title'    => __('Weibo', 'minti-framework'),
                'subtitle' => __('Enter URL to your Weibo Account', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'       => 'social_xing',
                'type'     => 'text',
                'title'    => __('Xing', 'minti-framework'),
                'subtitle' => __('Enter URL to your Xing Account', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'       => 'social_youtube',
                'type'     => 'text',
                'title'    => __('YouTube', 'minti-framework'),
                'subtitle' => __('Enter URL to your YouTube Account', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'        => 'own-social-media-1',
                'type'      => 'info',
                'desc'      => __('Own Social Media Icon #1 (Remember to include the "http://" in all URLs)', 'minti-framework')
            ),

            array(
                'id'       => 'ownsocial1_name',
                'type'     => 'text',
                'title'    => __('Social Field #1 - Name', 'minti-framework'),
                'subtitle' => __('Social Field Name', 'minti-framework'),
                'default'  => '',
            ),
            array(
                'id'       => 'ownsocial1_icon',
                'type'     => 'text',
                'title'    => __('Social Field #1 - Icon', 'minti-framework'),
                'subtitle' => __('Use any <a href="http://fontawesome.io/icons/" target="_blank">FontAwesome</a> Icon here. For example: fa-apple', 'minti-framework'),
                'default'  => '',
            ),
            array(
                'id'       => 'ownsocial1_url',
                'type'     => 'text',
                'title'    => __('Social Field #1 - URL', 'minti-framework'),
                'subtitle' => __('Enter URL to your Social Media Account here', 'minti-framework'),
                'default'  => '',
            ),

            array(
                'id'        => 'own-social-media-2',
                'type'      => 'info',
                'desc'      => __('Own Social Media Icon #2 (Remember to include the "http://" in all URLs)', 'minti-framework')
            ),

            array(
                'id'       => 'ownsocial2_name',
                'type'     => 'text',
                'title'    => __('Social Field #2 - Name', 'minti-framework'),
                'subtitle' => __('Social Field Name', 'minti-framework'),
                'default'  => '',
            ),
            array(
                'id'       => 'ownsocial2_icon',
                'type'     => 'text',
                'title'    => __('Social Field #2 - Icon', 'minti-framework'),
                'subtitle' => __('Use any <a href="http://fontawesome.io/icons/" target="_blank">FontAwesome</a> Icon here. For example: fa-apple', 'minti-framework'),
                'default'  => '',
            ),
            array(
                'id'       => 'ownsocial2_url',
                'type'     => 'text',
                'title'    => __('Social Field #2 - URL', 'minti-framework'),
                'subtitle' => __('Enter URL to your Social Media Account here', 'minti-framework'),
                'default'  => '',
            ),

        ),
    ) );

    /* Footer /--------------------------------------------------------- */
    Redux::setSection( $opt_name, array(
        'title'     => __('Footer', 'minti-framework'),
        'icon'      => 'el-icon-file-edit',
        'fields'    => array(

            array(
                'id'        => 'footer-footer',
                'type'      => 'info',
                'desc'      => __('Footer Widgets', 'minti-framework')
            ),

            array(
                'id'       => 'switch_footerwidgets',
                'type'     => 'switch', 
                'title'    => __('Footer Widget Area', 'minti-framework'),
                'subtitle' => __('Enable / Disable widgetized Footer Area.', 'minti-framework'),
                'default'  => true,
            ),

            array(
                'id'       => 'select_footercolumns',
                'type'     => 'image_select',
                'title'    => __('Footer Widget Columns', 'minti-framework'), 
                'subtitle' => __('Select Footer Columns', 'minti-framework'),
                'options'  => array(
                    '1'      => array(
                        'alt'   => 'Header 1', 
                        'img'   => get_template_directory_uri().'/framework/images/admin/col-1.jpg'
                    ),
                    '2'      => array(
                        'alt'   => 'Header 2', 
                        'img'   => get_template_directory_uri().'/framework/images/admin/col-2.jpg'
                    ),
                    '3'      => array(
                        'alt'   => 'header 3', 
                        'img'  => get_template_directory_uri().'/framework/images/admin/col-3.jpg'
                    ),
                    '4'      => array(
                        'alt'   => 'Header 4', 
                        'img'   => get_template_directory_uri().'/framework/images/admin/col-4.jpg'
                    )
                ),
                'default' => '4',
                'required' => array('switch_footerwidgets', "=", '1'),
            ),

            array(
                'id'        => 'footer-copyright',
                'type'      => 'info',
                'desc'      => __('Copyright', 'minti-framework')
            ),

            array(
                'id'       => 'switch_copyright',
                'type'     => 'switch', 
                'title'    => __('Copyright Area', 'minti-framework'),
                'subtitle' => __('Enable / Disable Copyright Area.', 'minti-framework'),
                'default'  => true,
            ),

            array(
                'id'=>'textarea_copyright',
                'type' => 'textarea',
                'title' => __('Copyright Text', 'minti-framework'), 
                'subtitle' => __('Enter your Copyright Text (HTML allowed).', 'minti-framework'),
                'default' => '2015 Theme - WordPress Theme built by <a href="http://www.mintithemes.com">Mintithemes</a> using <a href="http://wordpress.org/" target="_blank">WordPress</a>.',
                'required' => array('switch_copyright', "=", '1'),
            ),

            array(
                'id'       => 'select_copyright',
                'type'     => 'select',
                'title'    => __('Copyright Right Content', 'minti-framework'), 
                'options'  => array(
                    'Social Media' => 'Social Media',
                    'Navigation' => 'Navigation',
                    'Leave Empty' => 'Leave Empty',
                ),
                'default'  => 'Social Media',
                'required' => array('switch_copyright', "=", '1'),
            ),

        ),
    ) );

    /* Titlebar /--------------------------------------------------------- */
    Redux::setSection( $opt_name, array(
        'title'     => __('Titlebar', 'minti-framework'),
        'icon'      => 'el-icon-text-width',
        'fields'    => array(

            array(
                'id'        => 'titlebar-default',
                'type'      => 'info',
                'desc'      => __('Default Titlebar Settings', 'minti-framework')
            ),

            array(
                'id'       => 'titlebar_layout',
                'type'     => 'select',
                'title'    => __('Default Global Titlebar Layout', 'minti-framework'), 
                'subtitle' => __('Define the default Titlebar for your Page. This will be shown on all pages and can be overwritten individually by each page.', 'minti-framework'),
                'options'  => array(
                    'title'                 => 'Header + Title',
                    'featuredimagecenter'   => 'Header + Image Title',
                    'transparentimage'      => 'Transparent Header + Image Title',
                    'notitle'               => 'Header only'
                ),
                'default'  => 'title',
            ),

            array(
                'id'       => 'titlebar_image',
                'type'     => 'media', 
                'url'      => false,
                'title'    => __('Titlebar Image', 'minti-framework'),
                'subtitle' => __('Upload your Titlebar Image', 'minti-framework'),
                'required' => array( 
                    array('titlebar_layout', "!=", 'title'), 
                    array('titlebar_layout','!=','notitle')  
                )
            ),

            array(
                'id'       => 'titlebar_color',
                'type'     => 'select', 
                'url'      => false,
                'title'    => __('Transparent Header Color', 'minti-framework'),
                'subtitle' => __('Select the default Header color for Transparent Headers', 'minti-framework'),
                'options'  => array(
                    'light' => 'Light (for dark backgrounds)',
                    'dark'  => 'Dark (for light backgrounds)',
                ),
                'required' => array( 
                    array('titlebar_layout', "=", 'transparentimage'), 
                ),
                'default'  => 'light',
            ),

            array(
                'id'       => 'titlebar_breadcrumbs',
                'type'     => 'switch', 
                'title'    => __('Breadcrumbs', 'minti-framework'),
                'subtitle' => __('Enable / Disable Breadcrumbs.', 'minti-framework'),
                'default'  => true,
            ),

            array(
                'id'        => 'titlebar-text',
                'type'      => 'info',
                'desc'      => __('Titlebar Text', 'minti-framework')
            ),

            array(
                'id'       => 'text_titlebar_blog',
                'type'     => 'text',
                'title'    => __('Blog Title', 'minti-framework'),
                'subtitle' => __('Text of the Titlebar for the Blog Detail Page.', 'minti-framework'),
                'default' => 'Blog',
            ),

            array(
                'id'       => 'text_titlebar_woocommerce',
                'type'     => 'text',
                'title'    => __('WooCommerce Title', 'minti-framework'),
                'subtitle' => __('Text of the Titlebar for the Shop Overview & Product Detail Page.', 'minti-framework'),
                'default' => 'Shop',
            ),

            array(
                'id'       => 'text_titlebar_forums',
                'type'     => 'text',
                'title'    => __('bbPress Title', 'minti-framework'),
                'subtitle' => __('Text of the bbPress Breadcrumbs.', 'minti-framework'),
                'default' => 'Forum',
            ),

            /* Titlebar Style: Title /----------------------------------------------------- */
            array(
                'id'        => 'titlebar-style',
                'type'      => 'info',
                'desc'      => __('Titlebar Style: Title', 'minti-framework')
            ),

            array(
                'id'=>'color_titlebarbg',
                'type' => 'color',
                'title' => __('Titlebar Backround Color', 'minti-framework'),
                'subtitle' => __('Default: #f9f9f9', 'minti-framework'),
                'default' => '#f9f9f9',
                'transparent' => false,
                'validate' => 'color',
            ),

            array( 
                'id'       => 'border_titlebar',
                'type'     => 'border',
                'all'       => true,
                'title'    => __('Titlebar Border Bottom Color', 'minti-framework'),
                'subtitle' => __('Default: 1px solid #efefef', 'minti-framework'),
                'default'  => array(
                    'border-color'  => '#efefef', 
                    'border-style'  => 'solid', 
                    'border-bottom'    => '1px',
                ),
            ),

            array(
                'id'=>'font_titlebar',
                'type' => 'typography', 
                'title' => __('Titlebar Title Text', 'minti-framework'),
                'compiler'=>false,
                'google'=>true,
                'font-backup'=>false,
                'subsets'=>true,
                'font-size'=>true,
                'line-height'=>false,
                'word-spacing'=>false,
                'letter-spacing'=>false,
                'text-align'=>false,
                'color'=>true,
                'preview'=>false,
                //'output' => array('body'),
                'units'=>'px',
                'subtitle'=> __('Default: 18px, #777777', 'minti-framework'),
                'default'=> array(
                    'color'=>"#777777",
                    'font-family'=>'Open Sans', 
                    'font-size'=>'22px',
                    'font-style'=>'400',
                    'font-weight'=>'400',
                )
            ),

            array(
                'id'=>'font_breadcrumb',
                'type' => 'typography', 
                'title' => __('Breadcrumb Text', 'minti-framework'),
                'compiler'=>false,
                'google'=>true,
                'font-backup'=>false,
                'subsets'=>true,
                'font-size'=>true,
                'line-height'=>false,
                'word-spacing'=>false,
                'letter-spacing'=>false,
                'text-align'=>false,
                'color'=>true,
                'preview'=>false,
                //'output' => array('body'),
                'units'=>'px',
                'subtitle'=> __('Default: 13px, #aaaaaa', 'minti-framework'),
                'default'=> array(
                    'color'=>"#aaaaaa",
                    'font-family'=>'Open Sans', 
                    'font-size'=>'13px',
                    'font-style'=>'400',
                    'font-weight'=>'400',
                )
            ),

            array(
                'id'=>'color_breadcrumbhover',
                'type' => 'color',
                'title' => __('Breadcrumb Hover Color', 'minti-framework'),
                'subtitle' => __('Default: #666666', 'minti-framework'),
                'default' => '#666666',
                'transparent' => false,
                'validate' => 'color',
            ),

            array(
                'id'       => 'style_breadcrumbmargin',
                'type'     => 'text',
                'title'    => __('Breadcrumb Margin Top', 'minti-framework'),
                'subtitle' => __('Default: 6px', 'minti-framework'),
                'default' => '6px',
            ),

            /* Titlebar Style: Image Title /----------------------------------------------------- */
            array(
                'id'        => 'titlebar-style',
                'type'      => 'info',
                'desc'      => __('Titlebar Style: Image Title', 'minti-framework')
            ),

            array(
                'id'=>'font_titlebar_3',
                'type' => 'typography', 
                'title' => __('Titlebar Title Text', 'minti-framework'),
                'compiler'=>false,
                'google'=>true,
                'font-backup'=>false,
                'subsets'=>true,
                'font-size'=>true,
                'line-height'=>false,
                'word-spacing'=>false,
                'letter-spacing'=>true,
                'text-align'=>false,
                'text-transform' => true,
                'color'=>true,
                'preview'=>false,
                //'output' => array('body'),
                'units'=>'px',
                'subtitle'=> __('Default: 42px, #ffffff', 'minti-framework'),
                'default'=> array(
                    'color'=>"#ffffff",
                    'font-family'=>'Montserrat', 
                    'font-size'=>'42px',
                    'font-style'=>'700',
                    'font-weight'=>'700',
                    'letter-spacing'=> '1',
                    'text-transform'=>'uppercase',
                )
            ),

            array(
                'id'       => 'align_titlebar_3',
                'type'     => 'select',
                'title'    => __('Text Align', 'minti-framework'), 
                'subtitle' => __('Choose the align of your Text', 'minti-framework'),
                'options'  => array(
                    'center' => 'Center',
                    'left'  => 'Left',
                    'right' => 'Right',
                ),
                'default'  => 'center',
            ),

        ),
    ) );

    /* Blog /--------------------------------------------------------- */
    Redux::setSection( $opt_name, array(
        'title'     => __('Blog', 'minti-framework'),
        'icon'      => 'el-icon-pencil',
        'fields'    => array(

            array(
                'id'        => 'blog-general',
                'type'      => 'info',
                'desc'      => __('Blog General', 'minti-framework')
            ),

            array(
                'id'       => 'switch_readmore',
                'type'     => 'switch', 
                'title'    => __('Read More Button in Blog Posts', 'minti-framework'),
                'subtitle' => __('Enable / Disable Read More Button on Blog Posts.', 'minti-framework'),
                'default'  => true,
            ),

            array(
                'id'       => 'switch_metadata',
                'type'     => 'switch', 
                'title'    => __('Metadata on Blog Posts', 'minti-framework'),
                'subtitle' => __('Enable / Disable Metadata on Blog Posts.', 'minti-framework'),
                'default'  => true,
            ),

            array(
                'id'        => 'check_metadata',
                'type'      => 'checkbox',
                'title'     => __('Metadata Options', 'minti-framework'),
                'subtitle'  => __('Check the Metadata you want to show on Blog Posts.', 'minti-framework'),
                'options'   => array(
                    'date' => 'Date', 
                    'author' => 'Author', 
                    'comments' => 'Comments', 
                    'categories' => 'Categories',
                    'tags' => 'Tags (only on Blog Post Details)',
                ),
                'default'   => array(
                    'date' => '1', 
                    'author' => '1', 
                    'comments' => '1',
                    'categories' => '1',
                    'tags' => '0',
                ),
                'required' => array('switch_metadata', "=", '1'),
            ),

            array(
                'id'        => 'blog-detail',
                'type'      => 'info',
                'desc'      => __('Blog Post Detail Page', 'minti-framework')
            ),

            array(
                'id'       => 'select_bloglayout',
                'type'     => 'image_select',
                'title'    => __('Blog Detail Layout', 'minti-framework'), 
                'subtitle' => __('Select the Sidebar Position for Blog Detail Pages.', 'minti-framework'),
                'options'  => array(
                    'sidebar-left'      => array(
                        'alt'   => 'Sidebar Left', 
                        'img'   => get_template_directory_uri().'/framework/images/admin/layout-1.jpg'
                    ),
                    'sidebar-right'      => array(
                        'alt'   => 'Sidebar Right', 
                        'img'   => get_template_directory_uri().'/framework/images/admin/layout-2.jpg'
                    ),
                    'no-sidebar'      => array(
                        'alt'   => 'No Sidebar', 
                        'img'  => get_template_directory_uri().'/framework/images/admin/layout-3.jpg'
                    ),
                ),
                'default' => 'sidebar-right',
            ),

            array(
                'id'       => 'switch_blogpagination',
                'type'     => 'switch', 
                'title'    => __('Previous / Next Pagination', 'minti-framework'),
                'subtitle' => __('Enable / Disable Pagination on Blog Posts.', 'minti-framework'),
                'default'  => true,
            ),

            array(
                'id'       => 'switch_sharebox',
                'type'     => 'switch', 
                'title'    => __('ShareBox in Blog Details', 'minti-framework'),
                'subtitle' => __('Enable / Disable Share-Box on Blog Posts.', 'minti-framework'),
                'default'  => true,
            ),

            array(
                'id'        => 'check_sharebox',
                'type'      => 'checkbox',
                'title'     => __('Sharebox Social Icons', 'minti-framework'),
                'subtitle'  => __('Check the Social Icons you want to show.', 'minti-framework'),
                'options'   => array(
                    'facebook' => 'Facebook', 
                    'twitter' => 'Twitter', 
                    'linkedin' => 'LinkedIn',
                    'tumblr' => 'Tumblr',
                    'pinterest' => 'Pinterest',
                    'googleplus' => 'Google Plus',
                    'email' => 'E-Mail',
                ),
                'default'   => array(
                    'facebook' => '1', 
                    'twitter' => '1', 
                    'linkedin' => '1',
                    'tumblr' => '1',
                    'pinterest' => '1',
                    'googleplus' => '1',
                    'email' => '1',
                ),
                'required' => array('switch_sharebox', "=", '1'),
            ),

            array(
                'id'       => 'switch_authorinfo',
                'type'     => 'switch', 
                'title'    => __('Author Info in Blog Details', 'minti-framework'),
                'subtitle' => __('Enable / Disable Author Info on Blog Posts. You can add an Author text in your User Settings.', 'minti-framework'),
                'default'  => true,
            ),

            array(
                'id'       => 'switch_relatedposts',
                'type'     => 'switch', 
                'title'    => __('Related Posts in Blog Details', 'minti-framework'),
                'subtitle' => __('Enable / Disable Related Posts on Blog Posts.', 'minti-framework'),
                'default'  => true,
            ),

        ),
    ) );

    /* Portfolio /--------------------------------------------------------- */
    Redux::setSection( $opt_name, array(
        'title'     => __('Portfolio', 'minti-framework'),
        'icon'      => 'el-icon-briefcase',
        'fields'    => array(

            array(
                'id'        => 'portfolio-general',
                'type'      => 'info',
                'desc'      => __('Portfolio', 'minti-framework')
            ),

            array(
                'id'       => 'text_portfolioslug',
                'type'     => 'text',
                'title'    => __('Portfolio Slug', 'minti-framework'),
                'description' => __('Enter the URL Slug for your Portfolio (Default: portfolio-item) <br /><strong>Go to Settings > Permalinks and save your permalinks after changing this.</strong>', 'minti-framework'),
                'default'  => 'portfolio-item'
            ),

            array(
                'id'        => 'portfolio-detail',
                'type'      => 'info',
                'desc'      => __('Portfolio Detail Page', 'minti-framework')
            ),

            array(
                'id'       => 'switch_portfoliopagination',
                'type'     => 'switch', 
                'title'    => __('Previous / Next Pagination', 'minti-framework'),
                'subtitle' => __('Enable / Disable Pagination on Portfolio Posts.', 'minti-framework'),
                'default'  => false,
            ),

        ),
    ) );
    
    // check if woocommerce plugin installed
    if ( class_exists('Woocommerce') ) {

    /* WooCommerce /--------------------------------------------------------- */
    Redux::setSection( $opt_name, array(
        'title'     => __('WooCommerce', 'minti-framework'),
        'icon'      => 'el-icon-shopping-cart',
        'fields'    => array(

            array(
                'id'        => 'woocommerce-general-2',
                'type'      => 'info',
                'desc'      => __('WooCommerce General', 'minti-framework')
            ),

            array(
                'id'       => 'switch_shoppingicon',
                'type'     => 'switch', 
                'title'    => __('Shopping Cart Icon in Header', 'minti-framework'),
                'subtitle' => __('Enable / Disable Shopping Cart Icon in Header', 'minti-framework'),
                'default'  => true,
            ),

            array(
                'id'       => 'select_woocommercesidebar',
                'type'     => 'image_select',
                'title'    => __('Main Shop Layout', 'minti-framework'), 
                'subtitle' => __('Select the Sidebar Position of the main shop layout.', 'minti-framework'),
                'options'  => array(
                    'no-sidebar'      => array(
                        'alt'   => 'No Sidebar', 
                        'img'  => get_template_directory_uri().'/framework/images/admin/layout-3.jpg'
                    ),
                    'sidebar-left'      => array(
                        'alt'   => 'Sidebar Left', 
                        'img'   => get_template_directory_uri().'/framework/images/admin/layout-1.jpg'
                    ),
                    'sidebar-right'      => array(
                        'alt'   => 'Sidebar Right', 
                        'img'   => get_template_directory_uri().'/framework/images/admin/layout-2.jpg'
                    ),
                ),
                'default'  => 'sidebar-left',
            ),

            array(
                'id'       => 'select_woocommercesidebar_single',
                'type'     => 'image_select',
                'title'    => __('Single Product Layout', 'minti-framework'), 
                'subtitle' => __('Select the Sidebar Position of the single product page.', 'minti-framework'),
                'options'  => array(
                    'no-sidebar'      => array(
                        'alt'   => 'No Sidebar', 
                        'img'  => get_template_directory_uri().'/framework/images/admin/layout-3.jpg'
                    ),
                    'sidebar-left'      => array(
                        'alt'   => 'Sidebar Left', 
                        'img'   => get_template_directory_uri().'/framework/images/admin/layout-1.jpg'
                    ),
                    'sidebar-right'      => array(
                        'alt'   => 'Sidebar Right', 
                        'img'   => get_template_directory_uri().'/framework/images/admin/layout-2.jpg'
                    ),
                ),
                'default'  => 'no-sidebar',
            ),

            array(
                'id'        => 'woocommerce-general',
                'type'      => 'info',
                'desc'      => __('WooCommerce Overview Pages', 'minti-framework')
            ),

            array(
                'id'       => 'select_woocommercecolumns',
                'type'     => 'select',
                'title'    => __('WooCommerce Columns', 'minti-framework'), 
                'subtitle' => __('WooCommerce Columns', 'minti-framework'),
                'options'  => array(
                    'columns-2'   => '2 Columns',
                    'columns-3'   => '3 Columns',
                    'columns-4'   => '4 Columns',
                ),
                'default'  => 'columns-3',
            ),

            array(
                'id'       => 'text_shopitems',
                'type'     => 'text',
                'title'    => __('Items per Shop Page', 'minti-framework'),
                'description' => __('Enter how many items you want to show on Shop pages & Categorie Pages before Pagination shows up (Default: 12)', 'minti-framework'),
                'default'  => '12'
            ),

            array(
                'id'       => 'switch_secondimageonhover',
                'type'     => 'switch', 
                'title'    => __('Secondary Image on Hover', 'minti-framework'),
                'subtitle' => __('Enable / Disable to add secondary Image on hover of Product Images.', 'minti-framework'),
                'default'  => true,
            ),

            array(
                'id'       => 'switch_shopsorting',
                'type'     => 'switch', 
                'title'    => __('Shop Sort', 'minti-framework'),
                'subtitle' => __('Enable / Disable sort-by function on Shop Pages', 'minti-framework'),
                'default'  => true,
            ),

            array(
                'id'       => 'switch_shopresultcount',
                'type'     => 'switch', 
                'title'    => __('Shop Result Count', 'minti-framework'),
                'subtitle' => __('Enable / Disable Result Count on Shop Pages', 'minti-framework'),
                'default'  => true,
            ),

            array(
                'id'       => 'switch_addtocart',
                'type'     => 'switch', 
                'title'    => __('Add to Cart Button', 'minti-framework'),
                'subtitle' => __('Enable / Disable "Add to Cart"-Button on Shop Pages', 'minti-framework'),
                'default'  => false,
            ),

            array(
                'id'        => 'woocommerce-general',
                'type'      => 'info',
                'desc'      => __('WooCommerce Product Item Detail', 'minti-framework')
            ),

            array(
                'id'       => 'switch_shopupsells',
                'type'     => 'switch', 
                'title'    => __('Upsells Products', 'minti-framework'),
                'subtitle' => __('Enable / Disable to show upsells Products on Product Item Details', 'minti-framework'),
                'default'  => false,
            ),

            array(
                'id'       => 'switch_shoprelatedproducts',
                'type'     => 'switch', 
                'title'    => __('Related Products', 'minti-framework'),
                'subtitle' => __('Enable / Disable to show related Products on Product Item Details', 'minti-framework'),
                'default'  => true,
            ),

            

        ),
    ) );
    
    } // end check woocommerce

    // check if woocommerce plugin installed
    if ( class_exists('bbPress') ) {

    /* bbPress /--------------------------------------------------------- */
    Redux::setSection( $opt_name, array(
        'title'     => __('bbPress', 'minti-framework'),
        'icon'      => 'el-icon-bullhorn',
        'fields'    => array(

            array(
                'id'        => 'bbpress-general',
                'type'      => 'info',
                'desc'      => __('bbPress General', 'minti-framework')
            ),

            array(
                'id'       => 'select_bbpresssidebar',
                'type'     => 'image_select',
                'title'    => __('bbPress Sidebar Position', 'minti-framework'), 
                'subtitle' => __('bbPress Listing Sidebar Position', 'minti-framework'),
                'options'  => array(
                    'no-sidebar'      => array(
                        'alt'   => 'No Sidebar', 
                        'img'  => get_template_directory_uri().'/framework/images/admin/layout-3.jpg'
                    ),
                    'sidebar-left'      => array(
                        'alt'   => 'Sidebar Left', 
                        'img'   => get_template_directory_uri().'/framework/images/admin/layout-1.jpg'
                    ),
                    'sidebar-right'      => array(
                        'alt'   => 'Sidebar Right', 
                        'img'   => get_template_directory_uri().'/framework/images/admin/layout-2.jpg'
                    ),
                ),
                'default'  => 'no-sidebar',
            ),

        ),
    ) );
    
    } // end check bbpress

    /* Lightbox /--------------------------------------------------------- */
    Redux::setSection( $opt_name, array(
        'title'     => __('Lightbox', 'minti-framework'),
        'icon'      => 'el-icon-picture',
        'fields'    => array(

            array(
                'id'        => 'lightbox-general',
                'type'      => 'info',
                'desc'      => __('General Lightbox Settings', 'minti-framework')
            ),

            array(
                'id'       => 'lightbox_automatic',
                'type'     => 'switch', 
                'title'    => __('Automatic Lightbox for Images', 'minti-framework'),
                'subtitle' => __('Enable / Disable automatic lightbox for all links that link to an image. The lightbox is still active for links with class=prettyPhoto', 'minti-framework'),
                'default'  => true,
            ),

            array(
                'id'       => 'lightbox_smartphones',
                'type'     => 'switch', 
                'title'    => __('Lightbox on Smartphones', 'minti-framework'),
                'subtitle' => __('Enable / Disable Lightbox Images on small devices (under 500px width)', 'minti-framework'),
                'default'  => true,
            ),

            array(
                'id'        => 'lightbox-options',
                'type'      => 'info',
                'desc'      => __('Lightbox Options', 'minti-framework')
            ),

            array(
                'id'       => 'lightbox_animation_speed',
                'type'     => 'select',
                'title'    => __('Animation Speed', 'minti-framework'), 
                'options'  => array(
                    'fast' => 'Fast',
                    'normal' => 'Normal',
                    'slow' => 'Slow'
                ),
                'default'  => 'fast',
            ),

            array(
                'id'       => 'lightbox_opacity',
                'type'     => 'text',
                'title'    => __('Background Opacity', 'minti-framework'),
                'default'  => '0.8'
            ),

            array(
                'id'       => 'lightbox_title',
                'type'     => 'switch', 
                'title'    => __('Show Title', 'minti-framework'),
                'subtitle' => __('Enable / Disable to show the Title', 'minti-framework'),
                'default'  => false,
            ),

            array(
                'id'       => 'lightbox_gallery',
                'type'     => 'switch', 
                'title'    => __('Show Gallery Thumbnails', 'minti-framework'),
                'subtitle' => __('Enable / Disable to show the Gallery Thumbnails', 'minti-framework'),
                'default'  => false,
            ),

            array(
                'id'       => 'lightbox_autoplay',
                'type'     => 'switch', 
                'title'    => __('Autoplay Gallery', 'minti-framework'),
                'subtitle' => __('Enable / Disable to autoplay the Lughtbox Gallery', 'minti-framework'),
                'default'  => false,
            ),

            array(
                'id'       => 'lightbox_slideshow_speed',
                'type'     => 'text',
                'title'    => __('Autoplay Gallery Speed', 'minti-framework'),
                'subtitle' => __('Select the slideshow speed in ms. (Default: 5000, 1000 ms = 1 second)', 'minti-framework'),
                'default'  => '5000',
                'required' => array('lightbox_autoplay', "=", '1'),
            ),

            array(
                'id'       => 'lightbox_social',
                'type'     => 'switch', 
                'title'    => __('Social Icons', 'minti-framework'),
                'subtitle' => __('Enable to show social sharing icons.', 'minti-framework'),
                'default'  => false,
            ),

        ),
    ) );

    /* Custom CSS /--------------------------------------------------------- */
    Redux::setSection( $opt_name, array(
        'title'     => __('Custom CSS', 'minti-framework'),
        'icon'      => 'el-icon-adjust-alt',
        'fields'    => array(

            array(
                'id'        => 'customcss',
                'type'      => 'info',
                'desc'      => __('Custom CSS', 'minti-framework')
            ),

             array(
                'id'     => 'opt-info-normal',
                'type'   => 'info',
                'notice' => false,
                'title'  => __( '', 'redux-framework-demo' ),
                'desc'   => __( '* The CSS written here will not be lost when you update the theme.<br/>
* Sometimes you need to add !important rule to overwrite the default value set by the theme, example: <strong>font-size: 18px !important;</strong>', 'redux-framework-demo' )
            ),

            array(
                'id'        => 'textarea_csscode',
                'type'      => 'ace_editor',
                'title'     => __('CSS Code', 'minti-framework'),
                'subtitle'  => __('Advanced CSS Options. You can paste your custom CSS Code here.', 'minti-framework'),
                'mode'      => 'css',
                'validate' => 'css',
                'theme'     => 'chrome',
                'default'   => ""
            ),

            array(
                'id'        => 'responsivecss',
                'type'      => 'info',
                'desc'      => __('Responsive CSS - Targeting custom screen sizes', 'minti-framework')
            ),

            array(
                'id'        => 'textarea_csscode_xl',
                'type'      => 'ace_editor',
                'title'     => __('Extra Large Screen (Desktop)', 'minti-framework'),
                'subtitle'  => __('Screen size larger than 1200px', 'minti-framework'),
                'mode'      => 'css',
                'validate' => 'css',
                'theme'     => 'chrome',
                'default'   => ""
            ),

            array(
                'id'        => 'textarea_csscode_l',
                'type'      => 'ace_editor',
                'title'     => __('Large Screen (iPad Landscape)', 'minti-framework'),
                'subtitle'  => __('Screen size between 960px and 1199px', 'minti-framework'),
                'mode'      => 'css',
                'validate' => 'css',
                'theme'     => 'chrome',
                'default'   => ""
            ),

            array(
                'id'        => 'textarea_csscode_m',
                'type'      => 'ace_editor',
                'title'     => __('Medium Screen (iPad Portrait)', 'minti-framework'),
                'subtitle'  => __('Screen size between 768px and 959px', 'minti-framework'),
                'mode'      => 'css',
                'validate' => 'css',
                'theme'     => 'chrome',
                'default'   => ""
            ),

            array(
                'id'        => 'textarea_csscode_s',
                'type'      => 'ace_editor',
                'title'     => __('Small Screen (iPhone Landscape)', 'minti-framework'),
                'subtitle'  => __('Screen size between 480px and 767px', 'minti-framework'),
                'mode'      => 'css',
                'validate' => 'css',
                'theme'     => 'chrome',
                'default'   => ""
            ),

            array(
                'id'        => 'textarea_csscode_xs',
                'type'      => 'ace_editor',
                'title'     => __('Extra Small Screen (iPhone Portrait)', 'minti-framework'),
                'subtitle'  => __('Screen size smaller than 479px', 'minti-framework'),
                'mode'      => 'css',
                'validate' => 'css',
                'theme'     => 'chrome',
                'default'   => ""
            ),

        ),
    ) );
    
    /* Import & Export /--------------------------------------------------------- */
    Redux::setSection( $opt_name, array(
        'title'     => __('Import / Export', 'minti-framework'),
        'icon'      => 'el-icon-refresh',
        'fields'    => array(

            array(
                'id'        => 'import-export',
                'type'      => 'info',
                'desc'      => __('Import & Export Theme Options Settings', 'minti-framework')
            ),

            array(
                'id'            => 'opt-import-export',
                'type'          => 'import_export',
                'title'         => 'Import Export',
                'subtitle'      => 'Save and restore your Redux options',
                'full_width'    => false,
            ),
        ),
    ) );

/* ------------------------------------------------------------------------ */
/* Custom function for Mintitheme's own CSS
/* ------------------------------------------------------------------------ */
function overridePanelCSS() {   
    wp_register_style( 'redux-custom-css', get_template_directory_uri() . '/framework/admin/admin-custom.css', array(), '1', 'all' );    
    wp_enqueue_style('redux-custom-css');
}
add_action( 'redux/page/minti_data/enqueue', 'overridePanelCSS' );
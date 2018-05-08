<?php
/**
 * Main admin class
 *
 * @author Your Inspiration Themes
 * @package YITH Topbar Countdown
 * @version 1.0.0
 */

// Exit if accessed directly

if ( !defined( 'YITH_TCOUNTDOWN' ) ) { exit; }

global $yith_tcountdown_options;

$yith_tcountdown_options = array(

    /*ADD GENERAL TABS*/

    'general' => array(
        'label' => __('General', 'yith-topbar-countdown'),
        'sections' => array(
            'general' => array(
                'title' =>  __('General Settings', 'yith-topbar-countdown'),
                'description' => '',
                'fields' => array(

                    'yith_tcountdown_enable' => array(
                        'title' => __('Enable Topbar Countdown', 'yith-topbar-countdown'),
                        'description' => __( 'Enable the topbar countdown banner. (Default: Off)', 'yith-topbar-countdown' ),
                        'type' => 'checkbox',
                        'std' => false
                    ),

                    'yith_tcountdown_icon' => array(
                        'title' => __('Logo', 'yith-topbar-countdown'),
                        'description' => __( "Upload or choose from your media library the logo image, if you don't need it anymore simply delete it.", 'yith-topbar-countdown' ),
                        'type' => 'upload',
                        'std' => YITH_TCOUNTDOWN_URL . 'assets/images/icon.png',
                    ),

                    'yith_tcountdown_slogan' => array(
                        'title' => __('Slogan Text', 'yith-topbar-countdown'),
                        'description' => __( "Enter the topbar slogan", 'yith-topbar-countdown' ),
                        'type' => 'text',
                        'std' => '[LOREM IPSUM] DOLOR SIT!',
                    ),

                    'yith_tcountdown_message' => array(
                        'title' => __('Message', 'yith-topbar-countdown'),
                        'description' => __( "Enter the message text", 'yith-topbar-countdown' ),
                        'type' => 'text',
                        'std' => __('to offering expiration', 'yith-topbar-countdown'),
                    ),

                    'yith_tcountdown_link' => array(
                        'title' => __('Link Url', 'yith-topbar-countdown'),
                        'description' => __( "Enter the link", 'yith-topbar-countdown' ),
                        'type' => 'text',
                        'std' => '#',
                    ),

                    'yith_tcountdown_button_text' => array(
                        'title' => __('Button Text', 'yith-topbar-countdown'),
                        'description' => __( "Enter the Button Text", 'yith-topbar-countdown' ),
                        'type' => 'text',
                        'std' => __("Book Now", 'yith-topbar-countdown'),
                    ),

                    'yith_tcountdown_date' => array(
                        'title' => __('Countdown to', 'yith-topbar-countdown'),
                        'description' => __( "The date when the countdown will stop.", 'yith-topbar-countdown' ),
                        'type' => 'datepicker',

                    ),
                ),

            ),
        )
    ),

    /*ADD BACKGROUND TAB*/

    'background' => array(
        'label' => __('Background', 'yith-topbar-countdown'),
        'sections' => array(
            'background' => array(
                'title' =>  __('Background Settings', 'yith-topbar-countdown'),
                'description' => __('Customize the background of topbar countdown', 'yith-topbar-countdown'),
                'fields' => array(

                    'yith_tcountdown_background_image' => array(
                        'title' =>  __('Background image', 'yith-topbar-countdown'),
                        'description' => __("Upload or choose from your media library the background image, if you don't need it anymore simply delete it.", 'yith-topbar-countdown'),
                        'type' => 'upload',
                        'std' => YITH_TCOUNTDOWN_URL . 'assets/images/pattern.png',
                    ),

                    'yith_tcountdown_background_color' => array(
                        'title' =>  __('Background Color', 'yith-topbar-countdown'),
                        'description' => __('Choose a background color', 'yith-topbar-countdown'),
                        'type' => 'colorpicker',
                        'std' => '#144a60',
                    ),

                    'yith_tcountdown_background_repeat' => array(
                        'title' =>  __('Background Repeat', 'yith-topbar-countdown'),
                        'description' => __( 'Select the repeat mode for the background image.', 'yith-topbar-countdown' ),
                        'type' => 'select',
                        'std' => apply_filters( 'yith_tcountdown_background_repeat_std', 'repeat' ),
                        'options' => array(
                            'repeat' => __( 'Repeat', 'yith-topbar-countdown' ),
                            'repeat-x' => __( 'Repeat Horizontally', 'yith-topbar-countdown' ),
                            'repeat-y' => __( 'Repeat Vertically', 'yith-topbar-countdown' ),
                            'no-repeat' => __( 'No Repeat', 'yith-topbar-countdown' ),
                        )
                    ),

                    'yith_tcountdown_background_position' => array(
                        'title' =>  __('Background Position', 'yith-topbar-countdown'),
                        'description' =>  __( 'Select the position for the background image.', 'yith-topbar-countdown' ),
                        'type' => 'select',
                        'std' => apply_filters( 'yith_tcountdown_background_position_std', 'top left' ),
                        'options' => array(
                            'center' => __( 'Center', 'yith-topbar-countdown' ),
                            'top left' => __( 'Top left', 'yith-topbar-countdown' ),
                            'top center' => __( 'Top center', 'yith-topbar-countdown' ),
                            'top right' => __( 'Top right', 'yith-topbar-countdown' ),
                            'bottom left' => __( 'Bottom left', 'yith-topbar-countdown' ),
                            'bottom center' => __( 'Bottom center', 'yith-topbar-countdown' ),
                            'bottom right' => __( 'Bottom right', 'yith-topbar-countdown' ),
                        ),
                    ),

                    'yith_tcountdown_background_attachment' => array(
                        'title' =>  __('Background Attachment', 'yith-topbar-countdown'),
                        'description' => __( 'Select the attachment for the background image.', 'yith-topbar-countdown' ),
                        'type' => 'select',
                        'std' => apply_filters( 'yith_tcountdown_background_attachment_std', 'scroll' ),
                        'options' => array(
                            'scroll' => __( 'Scroll', 'yith-topbar-countdown' ),
                            'fixed' => __( 'Fixed', 'yith-topbar-countdown' ),
                        ),
                    ),

                    'yith_tcountdown_button_color' => array(
                        'title' =>  __('Button Background Color', 'yith-topbar-countdown'),
                        'description' => __('Choose a button background color', 'yith-topbar-countdown'),
                        'type' => 'colorpicker',
                        'std' => '#aa2929',
                    ),

                    'yith_tcountdown_button_hover_color' => array(
                        'title' =>  __('Button Hover Background Color', 'yith-topbar-countdown'),
                        'description' => __('Choose a button hover background color', 'yith-topbar-countdown'),
                        'type' => 'colorpicker',
                        'std' => '#821919',
                    ),
                )
            )
        )
    ),

    /*ADD TYPOGRAPHY TAB*/

    'typography' => array(
        'label' => __('Typography', 'yith-topbar-countdown'),
        'sections' => array(
            'background' => array(
                'title' =>  __('Typography Settings', 'yith-topbar-countdown'),
                'description' => __('Customize the typography of topbar countdown', 'yith-topbar-countdown'),
                'fields' => array(

                    'yith_tcountdown_slogan_font' => array(
                        'title' =>  __('Slogan font of message', 'yith-topbar-countdown'),
                        'description' => __('Choose the font type, size and color for the slogan text.', 'yith-topbar-countdown'),
                        'type' => 'typography',
                        'std' => array(
                            'size' => 30,
                            'unit' => 'px',
                            'family' => 'Yanone Kaffeesatz',
                            'style' => 'regular',
                            'color' => '#FFFFFF',
                        ),
                    ),

                    'yith_tcountdown_bold_font' => array(
                        'title' =>  __('Bold Slogan font of message', 'yith-topbar-countdown'),
                        'description' => __('Choose the font type, size and color for the bold text.', 'yith-topbar-countdown'),
                        'type' => 'typography',
                        'std' => array(
                            'size' => 30,
                            'unit' => 'px',
                            'family' => 'Yanone Kaffeesatz',
                            'style' => 'bold',
                            'color' => '#b8cad1',
                        ),
                    ),

                    'yith_tcountdown_number_font' => array(
                        'title' =>  __('Numbers Font', 'yith-topbar-countdown'),
                        'description' => __('Choose the font type, size and color for days, hours, minutes and seconds.', 'yith-topbar-countdown'),
                        'type' => 'typography',
                        'std' => array(
                            'size' => 40,
                            'unit' => 'px',
                            'family' => 'Yanone Kaffeesatz',
                            'style' => 'bold',
                            'color' => '#b8cad1',
                        ),
                    ),

                    'yith_tcountdown_message_font' => array(
                    'title' =>  __('Message Font', 'yith-topbar-countdown'),
                    'description' => __('Choose the font type, size and color for the paragraphs inside the message text.', 'yith-topbar-countdown'),
                    'type' => 'typography',
                    'std' => array(
                        'size' => 25,
                        'unit' => 'px',
                        'family' => 'Yanone Kaffeesatz',
                        'style' => 'regular',
                        'color' => '#FFFFFF',
                        ),
                    ),

                    'yith_tcountdown_button_font' => array(
                    'title' =>  __('Button Font', 'yith-topbar-countdown'),
                    'description' => __('Choose the font type, size and color for the paragraphs inside the button.', 'yith-topbar-countdown'),
                    'type' => 'typography',
                    'std' => array(
                        'size' => 25,
                        'unit' => 'px',
                        'family' => 'Yanone Kaffeesatz',
                        'style' => 'bold',
                        'color' => '#FFFFFF',
                        ),
                    ),
                )
            )
        )
    ),
);
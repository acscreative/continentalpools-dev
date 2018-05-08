<?php
/**
 * Main class
 *
 * @author Your Inspiration Themes
 * @package YITH Topbar Countdown
 * @version 1.0.0
 */

// Exit if accessed directly

if ( !defined( 'YITH_TCOUNTDOWN' ) ) { exit; }

if( !class_exists( 'YITH_Topbar_Countdown_Frontend' ) ) {

    /**
     * YITH Custom Login Frontend
     *
     * @since 1.0.0
     */

    class YITH_Topbar_Countdown_Frontend {

        /**
         * Plugin version
         *
         * @var string
         * @since 1.0.0
         */

        public $version;

        /**
         * Plugin version
         *
         * @var string
         * @since 1.0.0
         */

        public $template_file = 'tcountdown.php';

        /**
         * Fonts used within the plugin
         *
         * @var array
         * @since 1.0.0
         */

         public $fonts = array();

        /**
         * Constructor
         *
         * @return YITH_Topbar_Countdown_Frontend
         * @since 1.0.0
         */

        public function __construct( $version ) {

            $this->version = $version;

            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts'), 99 );
            add_action('wp_head', array( $this, 'add_style_to_the_head'));
            add_action('init', array( $this, 'add_google_fonts'));
            add_action('wp_footer', array( $this, 'print_countdown'), 999);

            return $this;
        }

        public function add_google_fonts() { /*DA SISTEMARE*/

            $this->fonts = array(

                'slogan_font' => yit_typo_option_to_css( get_option('yith_tcountdown_slogan_font') ),
                'bold_font' => yit_typo_option_to_css( get_option('yith_tcountdown_bold_font') ),
                'number_font' => yit_typo_option_to_css( get_option('yith_tcountdown_number_font')),
                'message_font' => yit_typo_option_to_css( get_option('yith_tcountdown_message_font')),
                'button_font' => yit_typo_option_to_css( get_option('yith_tcountdown_button_font')),
            );
        }

        /**
         * Return URL of the template
         */

        public function print_countdown() {

            $plugin_path   = plugin_dir_path(__FILE__) . 'templates/' . $this->template_file;
            $template_path = get_template_directory() . '/' . $this->template_file;
            $child_path    = get_stylesheet_directory() . '/' . $this->template_file;

            foreach ( array( 'child_path', 'template_path', 'plugin_path' ) as $var ) {

                if ( file_exists( ${$var} ) ) {
                    include ${$var};
                    return;
                }

            }
        }

        /**
         * Return the url of stylesheet position
         *
         */

        public function stylesheet_url() {

            $filename = 'tcountdown.css';

            $plugin_path   = array( 'path' => plugin_dir_path(__FILE__) . 'assets/css/style.css', 'url' => YITH_TCOUNTDOWN_URL . 'assets/css/style.css' );
            $template_path = array( 'path' => get_template_directory() . '/' . $filename,         'url' => get_template_directory_uri() . '/' . $filename );
            $child_path    = array( 'path' => get_stylesheet_directory() . '/' . $filename,       'url' => get_stylesheet_directory_uri() . '/' . $filename );

            foreach ( array( 'child_path', 'template_path', 'plugin_path' ) as $var ) {

                if ( file_exists( ${$var}['path'] ) ) {
                    return ${$var}['url'];
                }

            }

            exit();
        }

        public function add_style_to_the_head(){

            ?>

            <style type="text/css" >



                #yith-topbar-countdown.topbar-countdown-container{

                    <?php if(is_admin_bar_showing()) : ?>
                        padding-top: 28px;
                    <?php endif; ?>

                    <?php if (get_option('yith_tcountdown_background_color')):?>
                        background-color: <?php echo get_option('yith_tcountdown_background_color');?>;
                    <?php endif; ?>

                    <?php if (get_option('yith_tcountdown_background_image')):?>
                        background-image:  url('<?php echo get_option('yith_tcountdown_background_image'); ?>');
                    <?php endif; ?>

                    background-repeat:<?php echo get_option('yith_tcountdown_background_repeat');?>;
                    background-position:<?php echo get_option('yith_tcountdown_background_position');?>;
                    background-attachment:<?php echo get_option('yith_tcountdown_background_attachment');?>;
                }

                #yith-topbar-countdown .countdown_slogan{
                    <?php if ($this->fonts): echo $this->fonts['slogan_font']; endif ?>
                }

                #yith-topbar-countdown .countdown_information .countdown .num {<?php if ($this->fonts): echo $this->fonts['number_font']; endif ?>}

                #yith-topbar-countdown .countdown_information .countdown_slogan strong{
                    <?php if ($this->fonts): echo $this->fonts['bold_font']; endif ?>
                }

                #yith-topbar-countdown .countdown_information .message,
                #yith-topbar-countdown .countdown_information .countdown-label{
                    <?php if ($this->fonts): echo $this->fonts['message_font']; endif ?>
                }

                #yith-topbar-countdown .countdown_button {

                    <?php if (get_option('yith_tcountdown_background_color')):?>
                        background-color: <?php echo get_option('yith_tcountdown_button_color');?>;
                    <?php endif; ?>

                    <?php if ($this->fonts): echo $this->fonts['button_font']; endif ?>
                }

                #yith-topbar-countdown .countdown_button a{<?php if ($this->fonts): echo $this->fonts['button_font']; endif ?>}

                #yith-topbar-countdown .countdown_button:hover {
                    <?php if (get_option('yith_tcountdown_background_color')):?>
                        background-color: <?php echo get_option('yith_tcountdown_button_hover_color');?>;
                    <?php endif; ?>
                }

            </style>

            <?php
        }

    /* Enqueue script & style */

    public function enqueue_scripts() {

        if(get_option('yith_tcountdown_enable')){

            wp_enqueue_style( 'yith-tcountdown', $this->stylesheet_url(), array(), $this->version );
            wp_enqueue_script( 'jquery-countdown', YITH_TCOUNTDOWN_URL . 'assets/js/jquery.countdown.js', array('jquery'), '', true );
            wp_enqueue_style( 'yith-tcountdown-google-fonts', yith_google_fonts_url(), false, $this->version );
        }
    }
  }
}
<?php
/**
 * Main admin class
 *
 * @author Your Inspiration Themes
 * @package YITH Topbar Countdown
 * @version 1.0.0
 */

// Exit if accessed directly
if (!defined('YITH_TCOUNTDOWN')) {
    exit;
}

if (!class_exists('YITH_Tcountdown_Admin')) {

    /**
     * YITH Custom Login Admin
     *
     * @since 1.0.0
     */

    class YITH_Tcountdown_Admin
    {
        /**
         * Plugin version
         *
         * @var string
         * @since 1.0.0
         */

        public $version;

        /**
         * Parameters for add_submenu_page
         *
         * @var array
         * @access public
         * @since 1.0.0
         */

        public $submenu = array();

        /**
         * Initial Options definition:
         *
         * @var array
         * @access public
         * @since 1.0.0
         */

        public $options = array();

        /**
         * Panel instance
         *
         * @var YITH_Panel
         * @since 1.0.0
         */

        public $panel;

        /**
         * Various links
         *
         * @var string
         * @access public
         * @since 1.0.0
         */

        public $banner_url = 'http://cdn.yithemes.com/plugins/yith_maintenance_mode.php?url';
        public $banner_img = 'http://cdn.yithemes.com/plugins/yith_maintenance_mode.php';
        public $doc_url = 'http://yithemes.com/docs-plugins/yith-topbar-countdown/';

        /**
         * Constructor
         *
         * @return YITH_Tcountdown_Admin
         * @since 1.0.0
         */

        public function __construct($version)
        {
            global $yith_tcountdown_options;

            $this->version = $version;

            $this->submenu = apply_filters('yith_tcountdown_submenu',
                array(
                        'themes.php',
                        __('YITH Topbar Countdown', 'yith-topbar-countdown'),
                        __('Topbar Countdown', 'yith-topbar-countdown'),
                        'administrator',
                        'yith-topbar-countdown'
                    ));

            $this->options = apply_filters('yith_tcountdown_options', $yith_tcountdown_options);

            add_action('init', array($this,'init_panel'));

            add_action('init', array($this,'default_options'));

            add_filter('plugin_action_links_' . plugin_basename(dirname(__FILE__) . '/init.php'), array($this,'action_links'));

            return $this;
        }

        /**
         * Default options
         *
         * Sets up the default options used on the settings page
         *
         * @access public
         * @return void
         * @since 1.0.0
         */

        public function default_options()
        {
            foreach ($this->options as $tab) {
                foreach ($tab['sections'] as $section) {
                    foreach ($section['fields'] as $id => $value) {
                        if (isset($value['std']) && isset($id)) {
                            add_option($id, $value['std']);
                        }
                    }
                }
            }
        }

        /**
         * Init the panel
         *
         * @return void
         * @since 1.0.0
         */

        public function init_panel()
        {
            $this->panel = new YITH_Panel($this->submenu, $this->options,
                array(
                    'url' => $this->banner_url,
                    'img' => $this->banner_img
                ), 'yith-topbar-countdown-group',
            'yith-topbar-countdown');
        }

        /**
         * action_links function.
         *
         * @access public
         * @param mixed $links
         * @return void
         */

        public function action_links($links)
        {
            $plugin_links = array(
                '<a href="' . admin_url($this->submenu[0] . '?page=' . $this->submenu[4]) . '">' . __('Settings', 'yith-topbar-countdown') . '</a>',
                '<a href="' . $this->doc_url . '">' . __('Docs', 'yith-topbar-countdown') . '</a>'
            );

            return array_merge($plugin_links, $links);
        }
    }
}
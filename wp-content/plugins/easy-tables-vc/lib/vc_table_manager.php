<?php
/**
 * Main object for controls
 *
 * @package vc_table_manager
 */

if (!class_exists('VcTableManager')) {
    Class VcTableManager
    {
        protected $dir;
        protected $init = false;
        static protected  $param_name = 'table_param';

        function __construct($dir)
        {
            $this->dir = empty($dir) ? dirname(dirname(__FILE__)) : $dir; // Set dir or find by current file path.
            $this->plugin_dir = basename($this->dir); // Plugin directory name required to append all required js/css files.
        }

        /**
         * @static
         * Singleton
         * @param string $dir
         * @return VcTableManager
         */
        public static function getInstance($dir = '')
        {
            static $instance = null;
            if ($instance === null)
                $instance = new VcTemplateManager($dir);
            return $instance;
        }

        /**
         * @static
         * Install plugin.
         * @return void
         */
        public static function install()
        {

        }

        /**
         * Initialize plugin data
         * @return VcTableManager
         */
        function init()
        {
            if ($this->init) return $this; // Disable double initialization.
            $this->init = true;
            add_action('admin_print_scripts-post.php', array(&$this, 'initPlugin'), 5);
            add_action('admin_print_scripts-post-new.php', array(&$this, 'initPlugin'), 5);
            add_action('vc_admin_inline_editor', array(&$this, 'initFePlugin'), 5);
            add_action('vc_frontend_editor_enqueue_js_css', array($this, 'assetsAdmin'));
            add_action('wp_loaded', array(&$this, 'createShortcode'));
            add_action('wp_enqueue_scripts', array(&$this, 'assets'));
        }
        function initPlugin() {
            load_plugin_textdomain( "vc_table_manager", false, basename($this->dir).'/locale' );
            add_action('vc_backend_editor_enqueue_js_css', array($this, 'assetsAdmin'));

        }
        function initFePlugin() {
            load_plugin_textdomain( "vc_table_manager", false, basename($this->dir).'/locale' );
        }
        /**
         * Maps vc_table shortcode
         */
        function createShortcode()
        {
            $param_name = $this->getParamName();
            require_once $this->dir.'/lib/vc_table_param.php';
            $script_url = $this->assetURL('js/table_param.js');
            vc_add_shortcode_param($param_name, 'vc_'.$param_name.'_form_field', $script_url);
            vc_add_shortcode_param('table_theme', 'vc_table_theme_form_field');
            require_once $this->dir.'/lib/vc_table_shortcode.php';
            vc_map(array(
                "name" => __("Table", "vc_table_manager"),
                "base" => "vc_table",
                "icon" => "icon-wpb-table",
                "category" => __('Content', "js_composer"),
                "description" => __('Simple table for your data', 'vc_table_manager'),
                "params" => array(
                    array(
                        "type" => "table_theme",
                        "heading" => __("Theme", "vc_table_manager"),
                        "param_name" => "vc_table_theme",
                        "value" => array(
                            __("Default", "vc_table_manager") => "default",

                            __("Classic", "vc_table_manager") => "classic",
                            __("Classic Orange", "vc_table_manager") => "classic_orange",
                            __("Classic Pink", "vc_table_manager") => "classic_pink",
                            __("Classic Purple", "vc_table_manager") => "classic_purple",
                            __("Classic Blue", "vc_table_manager") => "classic_blue",
                            __("Classic Green", "vc_table_manager") => "classic_green",

                            __("Simple", "vc_table_manager") => "simple",
                            __("Simple Orange", "vc_table_manager") => "simple_orange",
                            __("Simple Pink", "vc_table_manager") => "simple_pink",
                            __("Simple Purple", "vc_table_manager") => "simple_purple",
                            __("Simple Blue", "vc_table_manager") => "simple_blue",
                            __("Simple Green", "vc_table_manager") => "simple_green"
                        ),
                    ),
                    array(
                        "type" => $param_name,
                        "holder" => "div",
                        "heading" => __("Table", "vc_table_manager"),
                        "param_name" => "content",
                        "value" => __("", "vc_table_manager"),
                        "description" => __("Use right click to manage table.", "vc_table_manager")
                    ),
					array(
						"type" => 'checkbox',
						"heading" => __( "Allow HTML?", "vc_table_manager" ),
						'value' => array( __( 'Yes', 'vc_table_manager' ) => true ),
						"param_name" => "allow_html",
						"description" => __( "Check if you wish to use html in the table.", "vc_table_manager" ),
					),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra class name", "js_composer"),
                        "param_name" => "el_class",
                        "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
                    ),
                ),
            ));
        }


        /**
         * Url to js/css or image assets of plugin
         * @param $file
         * @return string
         */
        public function assetUrl($file)
        {
            return plugins_url($this->plugin_dir . '/assets/' . $file);
        }

        /**
         * Absolute path to assets files
         * @param $file
         * @return string
         */
        public function assetPath($file)
        {
            return $this->dir . '/assets/' . $file;
        }

        /**
         * Load admin required js and css files
         */
        public function assetsAdmin()
        {
            wp_register_script('vc_jquery_handsontable', $this->assetURL('lib/jquery-handsontable/dist/jquery.handsontable.full.js'), array('jquery'), WPB_VC_TABLE_MANAGER_VERSION, true);
            wp_register_script('vc_bootstrap_dropdown', $this->assetURL('lib/bootstrap-dropdown/bootstrap.js'), array('jquery', 'underscore', 'vc_jquery_handsontable'), WPB_VC_TABLE_MANAGER_VERSION, true);
            wp_register_script('vc_plugin_table', $this->assetURL('js/table.js'), array('vc_bootstrap_dropdown'), WPB_VC_TABLE_MANAGER_VERSION, true);
            wp_enqueue_script('vc_plugin_table');
            wp_localize_script( 'vc_plugin_table', 'i18nVcTable', array(
                'enter_rows_count' => __('Enter rows count to add', "vc_table_manager"),
                'enter_cols_count' => __('Enter columns count to add', "vc_table_manager"),
                'max_rows_count' => __('Max allowed rows count to add is 10', "vc_table_manager"),
                'max_cols_count' => __('Max allowed columns count to add is 10', "vc_table_manager"),
            ));
            wp_register_style('vc_jquery_handsontable_css', $this->assetURL('lib/jquery-handsontable/dist/jquery.handsontable.css'), WPB_VC_TABLE_MANAGER_VERSION);
            wp_register_style('vc_plugin_table_admin_css', $this->assetURL('css/admin.css'), array('vc_jquery_handsontable_css'), WPB_VC_TABLE_MANAGER_VERSION);
            wp_enqueue_style('vc_plugin_table_admin_css');
            wp_register_style('vc_plugin_themes_css', $this->assetURL('css/themes.css'), array(), WPB_VC_TABLE_MANAGER_VERSION);
            wp_enqueue_style('vc_plugin_themes_css');
        }
        public static function getParamName() {
            return self::$param_name;
        }
        public function assets() {
            wp_register_style('vc_plugin_table_style_css', $this->assetURL('css/style.css'), array(), '1.0.0');
            wp_enqueue_style('vc_plugin_table_style_css');
            wp_register_style('vc_plugin_themes_css', $this->assetURL('css/themes.css'));
            wp_enqueue_style('vc_plugin_themes_css');
        }
    }
}

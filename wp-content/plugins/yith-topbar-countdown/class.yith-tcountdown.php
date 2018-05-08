<?php
/**
 * Main class
 *
 * @author Your Inspiration Themes
 * @package YITH Topbar Countdown
 * @version 1.0.0
 */

// Exit if accessed directly

if (!defined('YITH_TCOUNTDOWN')) {
    exit;
}


if (!class_exists('YITH_Topbar_Countdown')) {

    /**
     * YITH Topbar Countdown
     *
     * @since 1.0.0
     */

    class YITH_Topbar_Countdown
    {
        /**
         * Plugin version
         *
         * @var string
         * @since 1.0.0
         */

        public $version = YITH_TCOUNTDOWN_VERSION;

        /**
         * Plugin object
         *
         * @var string
         * @since 1.0.0
         */

        public $obj = null;

        /**
         * Constructor
         *
         * @return mixed|YITH_Tcountdown_Admin|YITH_Topbar_Countdown_Frontend
         * @since 1.0.0
         */

        public function __construct()
        {
            if (is_admin()) {
                $this->obj = new YITH_Tcountdown_Admin($this->version);
            }
            else {
                $this->obj = new YITH_Topbar_Countdown_Frontend($this->version);
            }

            return $this->obj;
        }
    }
}
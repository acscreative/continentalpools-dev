<?php
/**
 * Functions
 *
 * @author Your Inspiration Themes
 * @package YITH Topbar Countdown
 * @version 1.0.0
 */

 // Exit if accessed directly

if ( !defined( 'YITH_TCOUNTDOWN' ) ) { exit; }

if( !function_exists( 'yith_tcountdown_is_enabled' ) ) {

    /**
     * Returns if the plugin is enabled
     *
     * @return bool
     * @since 1.0.0
     */

    function yith_tcountdown_is_enabled() {
        return get_option('yith_tcountdown_enable') == '1';
    }
}

if( !function_exists( 'yith_countdown_unixstamp' ) ) {
    /**
     * Return if the plugin is enabled
     *
     * @param array $date The date from the option
     * @return integer
     * @since 1.0.0
     */
    function yith_countdown_unixstamp( $date ) {
        list( $mm, $dd, $yy ) = !empty( $date['date'] ) ? explode( '/', $date['date'] ) : array( 0, 0, 0 );
        $h = $date['hh'];
        $m = $date['mm'];
        $s = $date['ss'];

        return mktime( (int) $h, (int) $m, (int) $s, (int) $mm, (int) $dd, (int) $yy );
    }
}

if( !function_exists( 'yith_countdown_days' ) ) {
    /**
     * How many days remains to $to
     *
     * @return bool
     * @since 1.0.0
     */
    function yith_countdown_days( $to ) {
        return floor( ( $to - time() ) / 60 / 60 / 24 );
    }
}

if( !function_exists( 'yith_countdown_hours' ) ) {
    /**
     * How many days remains to $to
     *
     * @return bool
     * @since 1.0.0
     */
    function yith_countdown_hours( $to ) {
        return floor( ( $to - time() ) / 60 / 60 );
    }
}

if( !function_exists( 'yith_countdown_minutes' ) ) {
    /**
     * How many days remains to $to
     *
     * @return bool
     * @since 1.0.0
     */
    function yith_countdown_minutes( $to ) {
        return floor( ( $to - time() ) / 60 );
    }
}

if( !function_exists( 'yith_countdown_seconds' ) ) {
    /**
     * How many days remains to $to
     *
     * @return bool
     * @since 1.0.0
     */
    function yith_countdown_seconds( $to ) {
        return $to - time();
    }
}

if( !function_exists( 'yith_get_countdown' ) ) {
    /**
     * @param $countdown_date
     * @return array
     */
    function yith_get_countdown($countdown_date){
        return  array(
                        'enabled' => get_option('yith_tcountdown_enable'),
                        'to' => $countdown_date - time(),
                        'days' => yith_countdown_days( $countdown_date ),
                        'hours' => yith_countdown_hours( $countdown_date ) - yith_countdown_days( $countdown_date ) * 24,
                        'minutes' => yith_countdown_minutes( $countdown_date ) - yith_countdown_hours( $countdown_date ) * 60,
                        'seconds' => yith_countdown_seconds( $countdown_date ) - yith_countdown_minutes( $countdown_date ) * 60,
                    );
    }
}
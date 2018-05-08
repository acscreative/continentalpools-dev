<?php
/**
 * WooCommerce Local Pickup Plus
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Local Pickup Plus to newer
 * versions in the future. If you wish to customize WooCommerce Local Pickup Plus for your
 * needs please refer to http://docs.woocommerce.com/document/local-pickup-plus/
 *
 * @package     WC-Shipping-Local-Pickup-Plus
 * @author      SkyVerge
 * @copyright   Copyright (c) 2012-2018, SkyVerge, Inc.
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

defined( 'ABSPATH' ) or exit;

/**
 * AJAX class.
 *
 * This class handles AJAX calls for Local Pickup Plus either from admin or frontend.
 *
 * @since 2.0.0
 */
class WC_Local_Pickup_Plus_Ajax {


	/**
	 * Add AJAX hooks.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {


		// ====================
		//   GENERAL ACTIONS
		// ====================

		// make sure Local Pickup Plus is loaded during cart/checkout operations
		add_action( 'wp_ajax_woocommerce_checkout',        array( $this, 'load_shipping_method' ), 5 );
		add_action( 'wp_ajax_nopriv_woocommerce_checkout', array( $this, 'load_shipping_method' ), 5 );


		// ====================
		//    ADMIN ACTIONS
		// ====================

		// Admin: add new time range picker HTML.
		add_action( 'wp_ajax_wc_local_pickup_plus_get_time_range_picker_html', array( $this, 'get_time_range_picker_html' ) );
		// Admin: get pickup location IDs from a JSON search.
		add_action( 'wp_ajax_wc_local_pickup_plus_json_search_pickup_location_ids', array( $this, 'json_search_pickup_location_ids' ) );
		// Admin: update order shipping item pickup data.
		add_action( 'wp_ajax_wc_local_pickup_plus_update_order_shipping_item_pickup_data', array( $this, 'update_order_shipping_item_pickup_data' ) );


		// ====================
		//   FRONTEND ACTIONS
		// ====================

		// get the shipping destination
		add_action( 'wp_ajax_wc_local_pickup_plus_get_shipping_destination',        array( $this, 'get_shipping_destination' ) );
		add_action( 'wp_ajax_nopriv_wc_local_pickup_plus_get_shipping_destination', array( $this, 'get_shipping_destination' ) );
		// set the default handling when automatic grouping and per-order mode is being used
		add_action( 'wp_ajax_wc_local_pickup_plus_set_default_handling',        array( $this, 'set_default_handling' ) );
		add_action( 'wp_ajax_nopriv_wc_local_pickup_plus_set_default_handling', array( $this, 'set_default_handling' ) );
		// set a cart item for shipping or pickup
		add_action( 'wp_ajax_wc_local_pickup_plus_set_cart_item_handling',        array( $this, 'set_cart_item_handling' ) );
		add_action( 'wp_ajax_nopriv_wc_local_pickup_plus_set_cart_item_handling', array( $this, 'set_cart_item_handling' ) );
		// set a package pickup data
		add_action( 'wp_ajax_wc_local_pickup_plus_set_package_handling',        array( $this, 'set_package_handling' ) );
		add_action( 'wp_ajax_nopriv_wc_local_pickup_plus_set_package_handling', array( $this, 'set_package_handling' ) );
		// pickup locations lookup
		add_action( 'wp_ajax_wc_local_pickup_plus_pickup_locations_lookup',        array( $this, 'pickup_locations_lookup' ) );
		add_action( 'wp_ajax_nopriv_wc_local_pickup_plus_pickup_locations_lookup', array( $this, 'pickup_locations_lookup' ) );
		// get location name
		add_action( 'wp_ajax_wc_local_pickup_plus_get_pickup_location_name',        array( $this, 'get_pickup_location_name' ) );
		add_action( 'wp_ajax_nopriv_wc_local_pickup_plus_get_pickup_location_name', array( $this, 'get_pickup_location_name' ) );
		// get location area
		add_action( 'wp_ajax_wc_local_pickup_plus_get_pickup_location_area',        array( $this, 'get_pickup_location_area' ) );
		add_action( 'wp_ajax_nopriv_wc_local_pickup_plus_get_pickup_location_area', array( $this, 'get_pickup_location_area' ) );
		// get location pickup appointment data
		add_action( 'wp_ajax_wc_local_pickup_plus_get_pickup_location_appointment_data',        array( $this, 'get_pickup_location_appointment_data' ) );
		add_action( 'wp_ajax_nopriv_wc_local_pickup_plus_get_pickup_location_appointment_data', array( $this, 'get_pickup_location_appointment_data' ) );
		// get opening hours for a given location
		add_action( 'wp_ajax_wc_local_pickup_plus_get_pickup_location_opening_hours_list',        array( $this, 'get_pickup_location_opening_hours_list' ) );
		add_action( 'wp_ajax_nopriv_wc_local_pickup_plus_get_pickup_location_opening_hours_list', array( $this, 'get_pickup_location_opening_hours_list' ) );
	}


	/**
	 * Loads the Local Pickup Plus shipping method class.
	 *
	 * Ensures the method is loaded from the 'woocommerce_update_shipping_method' AJAX action early.
	 * Otherwise it would not be loaded in time to update the shipping package.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function load_shipping_method() {

		wc_local_pickup_plus()->load_shipping_method();
	}


	/**
	 * Get time range picker HTML.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function get_time_range_picker_html() {

		check_ajax_referer( 'get-time-range-picker-html', 'security' );

		if ( isset( $_POST['name'] ) ) {

			$business_hours = new WC_Local_Pickup_Plus_Business_Hours();

			$input_field = $business_hours->get_time_range_picker_input_html( array(
				'name'           => sanitize_text_field( $_POST['name'] ),
				'selected_start' => ! empty( $_POST['selected_start'] ) ? max( 0, (int) $_POST['selected_start'] ) : 9 * HOUR_IN_SECONDS,
				'selected_end'   => ! empty( $_POST['selected_end'] )   ? max( 0, (int) $_POST['selected_end'] )   : 17 * HOUR_IN_SECONDS,
			) );

			wp_send_json_success( $input_field );
		}

		wp_send_json_error( 'Missing field name' );
	}


	/**
	 * Update order shipping item pickup data.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function update_order_shipping_item_pickup_data() {

		check_ajax_referer( 'update-order-pickup-data', 'security' );

		if ( isset( $_POST['item_id'] ) && is_numeric( $_POST['item_id'] ) ) {

			$orders_handler = wc_local_pickup_plus()->get_orders_instance();

			if ( $orders_handler && ( $order_item_handler = $orders_handler->get_order_items_instance() ) ) {

				$item_id            = (int) $_POST['item_id'];
				$pickup_location_id = ! empty( $_POST['pickup_location'] ) ? $_POST['pickup_location'] : null;
				$pickup_date        = ! empty( $_POST['pickup_date'] )     ? $_POST['pickup_date']     : '';
				$pickup_items       = ! empty( $_POST['pickup_items'] )    ? $_POST['pickup_items']    : array();
				// get the pickup location object
				$pickup_location    = is_numeric( $pickup_location_id ) ? wc_local_pickup_plus_get_pickup_location( (int) $pickup_location_id ) : null;

				// update corresponding order item meta if the pickup location exists
				if ( $pickup_location instanceof WC_Local_Pickup_Plus_Pickup_Location ) {
					$order_item_handler->set_order_item_pickup_location( $item_id, $pickup_location );
					$order_item_handler->set_order_item_pickup_date( $item_id, $pickup_date );
					$order_item_handler->set_order_item_pickup_minimum_hours( $item_id, 0 );
					$order_item_handler->set_order_item_pickup_items( $item_id, (array) $pickup_items );
				}

				// our JS script expects success to reload the page and display updated data
				wp_send_json_success();
			}
		}

		wp_send_json_error( sprintf( 'Could not set pickup data for order item %s', isset( $_POST['item_id'] ) && ( is_string( $_POST['item_id'] ) || is_numeric( $_POST['item_id'] ) ) ? $_POST['item_id'] : '' ) );
	}


	/**
	 * Get pickup location IDs for a JSON search output.
	 *
	 * Used in admin in enhanced dropdown inputs to link products to locations.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function json_search_pickup_location_ids() {

		check_ajax_referer( 'search-pickup-locations', 'security' );

		$search_term = (string) wc_clean( SV_WC_Helper::get_request( 'term' ) );

		if ( '' === trim( $search_term ) ) {
			die;
		}

		$plugin    = wc_local_pickup_plus();
		$locations = array();

		if ( $plugin->geocoding_enabled() && ( $geocoding_handler = $plugin->get_geocoding_api_instance() ) && ( $pickup_locations_handler = $plugin->get_pickup_locations_instance() ) ) {

			$coordinates = $geocoding_handler->get_coordinates( $search_term );

			if ( $coordinates ) {
				$locations = wc_local_pickup_plus_get_pickup_locations_nearby( $coordinates );
			}

		} else {

			// get search args
			if ( is_numeric( $search_term ) ) {
				$args = array(
					'post_status' => 'publish',
					'post__in'    => array( 0, $search_term ),
				);
			} else {
				$args = array(
					'post_status' => 'publish',
					's'           => $search_term,
				);
			}

			$locations = wc_local_pickup_plus_get_pickup_locations( $args );
		}

		// if there are still no locations, try a name search:
		if ( empty( $locations ) && strlen( $search_term ) >= 4 ) {

			$location_posts = get_posts( array(
				'post_type' => 'wc_pickup_location',
				's'         => $search_term,
				'fields'    => 'ids',
			) );

			foreach ( $location_posts as $location_post_id ) {
				$locations[] = wc_local_pickup_plus_get_pickup_location( $location_post_id );
			}
		}

		$found_locations = array();

		foreach ( $locations as $location ) {

			if ( $location instanceof WC_Local_Pickup_Plus_Pickup_Location ) {
				$found_locations[ $location->get_id() ] = $location->get_name();
			}
		}

		wp_send_json( $found_locations );
	}


	/**
	 * Get a pickup location name.
	 *
	 * Used in frontend to get a pickup location name by its ID.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function get_pickup_location_name() {

		check_ajax_referer( 'get-pickup-location-name', 'security' );

		if ( ! empty( $_POST['id'] ) && ( $pickup_location = wc_local_pickup_plus_get_pickup_location( (int) $_REQUEST['id'] ) ) ) {
			wp_send_json_success( $pickup_location->get_name() );
		}

		wp_send_json_error( sprintf( 'Could not determine Pickup Location from requested ID %s', isset( $_POST['id'] ) && ( is_string( $_POST['id'] ) || is_numeric( $_POST['id'] ) ) ? $_POST['id'] : '' ) );
	}


	/**
	 * Sends the shipping destination setting in use.
	 *
	 * @internal
	 *
	 * @since 2.3.10
	 */
	public function get_shipping_destination() {

		check_ajax_referer( 'get-shipping-destination', 'security' );

		if ( $shipping_method = wc_local_pickup_plus_shipping_method() ) {

			wp_send_json_success( $shipping_method->get_shipping_destination() );
		}

		wp_send_json_error();
	}


	/**
	 * Sets a default handling override in session.
	 *
	 * @internal
	 *
	 * @since 2.2.0
	 */
	public function set_default_handling() {

		check_ajax_referer( 'set-default-handling', 'security' );

		$handling      = ! empty( $_POST['handling'] ) && in_array( $_POST['handling'], array( 'pickup', 'ship' ), true ) ? $_POST['handling'] : wc_local_pickup_plus_shipping_method()->get_default_handling();
		$cart_contents = WC()->cart->cart_contents;
		$cart_items    = WC()->session->get( 'wc_local_pickup_plus_cart_items', array() );
		$new_items     = array();

		$set_for_shipping = array(
			'handling'           => 'ship',
			'lookup_area'        => '',
			'pickup_location_id' => 0,
		);

		$set_for_pickup   = array(
			'handling'    => 'pickup',
			'lookup_area' => '',
		);

		foreach ( $cart_items as $cart_item_id => $cart_item_data ) {

			if ( isset( $cart_contents[ $cart_item_id ], $cart_contents[ $cart_item_id ]['data'] ) && $cart_contents[ $cart_item_id ]['data'] instanceof WC_Product ) {

				if ( 'pickup' === $handling && wc_local_pickup_plus_product_can_be_picked_up( $cart_contents[ $cart_item_id ]['data'] ) ) {
					$new_items[ $cart_item_id ] = $set_for_pickup;
				} elseif ( 'ship' === $handling ) {
					if ( wc_local_pickup_plus_product_must_be_picked_up( $cart_contents[ $cart_item_id ]['data'] ) ) {
						$new_items[ $cart_item_id ] = $set_for_pickup;
					} else {
						$new_items[ $cart_item_id ] = $set_for_shipping;
					}
				}
			}
		}

		// merge new handling data with existing - this ensures that pickup locations are not overriden for
		// pickup-only items
		foreach ( $new_items as $cart_item_key => $data ) {
			wc_local_pickup_plus()->get_session_instance()->set_cart_item_pickup_data( $cart_item_key, $data );
		}

		WC()->session->set( 'wc_local_pickup_plus_packages', array() );
		WC()->session->set( 'wc_local_pickup_plus_default_handling', $handling );

		wp_send_json_success( $handling );
	}


	/**
	 * Set a cart item for shipping or local pickup, along with pickup data
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function set_cart_item_handling() {

		check_ajax_referer( 'set-cart-item-handling', 'security' );

		if (      isset( $_POST['cart_item_key'], $_POST['pickup_data'], $_POST['pickup_data']['handling'] )
		     &&   in_array( $_POST['pickup_data']['handling'], array( 'ship', 'pickup' ), true )
		     && ! WC()->cart->is_empty() ) {

			$cart_item_key = $_POST['cart_item_key'];
			$handling_type = $_POST['pickup_data']['handling'];
			$session_data  = wc_local_pickup_plus()->get_session_instance()->get_cart_item_pickup_data( $cart_item_key );

			if ( is_string( $cart_item_key ) && '' !== $cart_item_key ) {

				// designate item for pickup
				if ( 'pickup' === $handling_type ) {

					$session_data['handling'] = 'pickup';

					if ( isset( $_POST['pickup_data']['lookup_area'] ) ) {
						$session_data['lookup_area'] = sanitize_text_field( $_POST['pickup_data']['lookup_area'] );
					}

					if ( ! empty( $_POST['pickup_data']['pickup_location_id'] ) ) {

						$pickup_location = wc_local_pickup_plus_get_pickup_location( $_POST['pickup_data']['pickup_location_id'] );

						if ( $pickup_location instanceof WC_Local_Pickup_Plus_Pickup_Location ) {
							$session_data['pickup_location_id'] = $pickup_location->get_id();
						}
					}

					wc_local_pickup_plus()->get_session_instance()->set_cart_item_pickup_data( $cart_item_key, $session_data );

				// remove any pickup information previously set
				} elseif ( 'ship' === $handling_type ) {

					wc_local_pickup_plus()->get_session_instance()->set_cart_item_pickup_data( $cart_item_key, array(
						'handling'           => 'ship',
						'lookup_area'        => '',
						'pickup_location_id' => 0,
					) );
				}

				wp_send_json_success();
			}
		}

		wp_send_json_error();
	}


	/**
	 * Set a package pickup data, when meant for pickup.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function set_package_handling() {

		check_ajax_referer( 'set-package-handling', 'security' );

		$package_id         = SV_WC_Helper::get_post( 'package_id' );
		$pickup_date        = SV_WC_Helper::get_post( 'pickup_date' );
		$pickup_location_id = SV_WC_Helper::get_post( 'pickup_location_id' );
		$pickup_lookup_area = SV_WC_Helper::get_post( 'lookup_area' );

		if ( is_numeric( $package_id ) || ( is_string( $package_id ) && '' !== $package_id ) ) {

			wc_local_pickup_plus()->get_session_instance()->set_package_pickup_data( $package_id, array(
				'pickup_date'        => $pickup_date,
				'pickup_location_id' => (int) $pickup_location_id,
				'lookup_area'        => sanitize_text_field( $pickup_lookup_area ),
			) );

			// if per-item selection is disabled, set all items to this package's location ID
			if ( wc_local_pickup_plus_shipping_method()->is_per_order_selection_enabled() ) {

				$cart_item_data = wc_local_pickup_plus()->get_session_instance()->get_cart_item_pickup_data();

				foreach ( $cart_item_data as $cart_item_key => $data ) {

					$session_data = wc_local_pickup_plus()->get_session_instance()->get_cart_item_pickup_data( $cart_item_key );

					if ( 'pickup' !== $session_data['handling'] ) {
						continue;
					}

					if ( $pickup_lookup_area ) {
						$session_data['lookup_area'] = $pickup_lookup_area;
					}

					$pickup_location = wc_local_pickup_plus_get_pickup_location( $pickup_location_id );

					if ( $pickup_location instanceof WC_Local_Pickup_Plus_Pickup_Location ) {
						$session_data['pickup_location_id'] = $pickup_location->get_id();
					}

					$session_data['pickup_date'] = empty( $session_data['pickup_date'] ) ? $pickup_date : $session_data['pickup_date'];

					wc_local_pickup_plus()->get_session_instance()->set_cart_item_pickup_data( $cart_item_key, $session_data );
				}
			}

			wp_send_json_success();
		}

		wp_send_json_error();
	}


	/**
	 * Perform a pickup locations lookup and return results in JSON format.
	 *
	 * Used in frontend to search nearby locations.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function pickup_locations_lookup() {

		check_ajax_referer( 'pickup-locations-lookup', 'security' );

		$data = array();

		if ( ! empty( $_REQUEST['term'] ) ) {

			// gather request variables
			$search_term  = sanitize_text_field( $_REQUEST['term'] );
			$product_id   = isset( $_REQUEST['product_id'] )  ? (int) $_REQUEST['product_id']                       : null;
			$current_area = ! empty( $_REQUEST['area'] )      ? wc_format_country_state_string( $_REQUEST['area'] ) : null;
			$country      = isset( $current_area['country'] ) ? $current_area['country']                            : '';
			$state        = isset( $current_area['state'] )   ? $current_area['state']                              : '';

			// prepare query args for WP_Query
			$page        = isset( $_REQUEST['page'] ) && is_numeric( $_REQUEST['page'] ) ? (int) $_REQUEST['page'] : -1;
			$query_args  = array(
				'post_status'    => 'publish',
				'posts_per_page' => $page > 0 ? $page * 10 : -1,
				'offset'         => $page > 1 ? $page * 10 : 0,
			);

			// obtain coordinates if using geocoding
			if ( wc_local_pickup_plus()->geocoding_enabled() ) {

				// TODO: the following should really be moved to WC_Local_Pickup_Plus_Pickup_Location_Field::get_lookup_area()
				// where it would also bubble up to the UI as a visual reference. Additionally, we should also properly geolocate
				// the lookup area to the visitor's country. However, that requires more time investment, so this is a quick fix
				// for stores that sell only to a single country. {IT 2017-11-21}

				// if shipping to a single country, limit lookup area to that country
				if ( $country === 'anywhere' || empty( $country ) ) {

					$ship_to_countries = WC()->countries->get_shipping_countries();

					if ( 1 === count( $ship_to_countries ) ) {
						$country = key( $ship_to_countries );
					}

				}

				if ( $country === 'anywhere' || empty( $country ) ) {

					$geocode = $search_term;

				} else {

					$address = array(
						'address_1' => $search_term,
						'country'   => $country,
					);

					if ( ! empty( $state ) ) {
						$address['state'] = $state;
					}

					$address = new WC_Local_Pickup_Plus_Address( $address );
					$geocode = $address->get_array();
				}

				$coordinates = wc_local_pickup_plus()->get_geocoding_api_instance()->get_coordinates( $geocode );
			}

			// search by distance when there are found coordinates
			if ( ! empty( $coordinates ) ) {

				$origin = $coordinates;

			// search by address (either as fallback if no coordinates found or geocoding is disabled)
			} else {

				// without geocoding we have more limited search possibilities, utilizing only the geodata table with address columns:
				$origin = new WC_Local_Pickup_Plus_Address( array(
					'country'  => 'anywhere' === $country || empty( $country ) ? '' : $country,
					'state'    => $state,
					// we can't know in advance which entity the user is searching for:
					'name'     => $search_term, // -> they might be typing the place name directly (narrowest)...
					'postcode' => $search_term, // -> or they might be searching by postcode (narrower)...
					'city'     => $search_term, // -> or they might be searching by city/town (broader)...
				) );
			}

			$found_locations = wc_local_pickup_plus_get_pickup_locations_nearby( $origin, $query_args );

			if ( ! empty ( $found_locations ) ) {

				foreach ( $found_locations as $pickup_location ) {

					if ( $product_id > 0 && ! wc_local_pickup_plus_product_can_be_picked_up( $product_id, $pickup_location ) ) {
						continue;
					}

					// format results as expected by select2 script
					$data[] = array(
						'id'   => $pickup_location->get_id(),
						'text' => $pickup_location->get_name(),
					);
				}

				wp_send_json_success( $data );
			}
		}

		wp_send_json_error();
	}


	/**
	 * Get a location area (country, state or formatted label) from a location ID.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function get_pickup_location_area() {

		check_ajax_referer( 'get-pickup-location-area', 'security' );

		if (    isset( $_POST['location'] )
		     && ( $location_id = is_numeric( $_POST['location'] ) ? (int) $_POST['location'] : null ) ) {

			$location  = wc_local_pickup_plus_get_pickup_location( $location_id );
			$formatted = isset( $_POST['formatted'] ) && $_POST['formatted'];

			if ( $location && 'publish' === $location->get_post()->post_status ) {

				$country      = $location->get_address()->get_country();
				$state        = $location->get_address()->get_state();
				$states       = WC()->countries->get_states( $country );
				$state_name   = isset( $states[ $state ] ) ? $states[ $state ] : '';
				$countries    = WC()->countries->get_countries();
				$country_name = isset( $countries[ $country ] ) ? $countries[ $country ] : '';

				if ( $formatted ) {
					// send just a label which is the state or country name
					if ( ! empty( $country_name ) ) {
						wp_send_json_success( empty( $state_name ) ? $country_name : $state_name );
					}
				} else {
					// send complete area data
					wp_send_json_success( array(
						'country' => array(
							'code' => $country,
							'name' => $country_name,
						),
						'state'   => array(
							'code' => $state,
							'name' => $state_name,
						),
					) );
				}
			}
		}

		die;
	}


	/**
	 * Sends all the necessary pickup location data to schedule an appointment.
	 *
	 * The data is sent to jQuery DatePicker to build the front-end pickup appointment calendar.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function get_pickup_location_appointment_data() {

		check_ajax_referer( 'get-pickup-location-appointment-data', 'security' );

		if ( isset( $_POST['location'] ) && ( $location_id = is_numeric( $_POST['location'] ) ? (int) $_POST['location'] : null ) ) {

			$location = wc_local_pickup_plus_get_pickup_location( $location_id );

			if ( $location && 'publish' === $location->get_post()->post_status ) {

				// local time now is from when we start building our calendar with available dates
				$start_time = current_time( 'timestamp' );

				// the optional lead time is used to offset the first available date by some days
				if ( $location->has_pickup_lead_time() ) {
					$lead_time = $start_time + $location->get_pickup_lead_time()->in_seconds();
				} else {
					$lead_time = $start_time;
				}

				// the deadline defines the farthest selectable day in the calendar
				if ( $location->has_pickup_deadline() ) {
					$pickup_days = max( 1, $location->get_pickup_deadline()->in_days() );
				} else {
					// if no deadline is specified, we'll build a year-long calendar
					$pickup_days = 365;
				}

				// the end time will be relative to the start time (adjusted by lead time offset) as long as there's deadline left
				$end_time          = $lead_time;
				// the lead days will be used to offset the start date with more unavailable days
				$lead_days         = $location->get_pickup_lead_time()->in_days( current_time( 'timestamp', true ) );
				// the lead hours will be used to evaluate if in the first (current day) there's still time to schedule a pickup
				$lead_hours        = array( ( (int) date( 'G', $lead_time ) * HOUR_IN_SECONDS ) + ( (int) date( 'i', $lead_time ) * MINUTE_IN_SECONDS ) => DAY_IN_SECONDS );
				// variables used in the while loop below to compile available and unavailable days in calendar
				$available_days    = 0;
				$unavailable_days  = 0;
				$unavailable_dates = array();
				$calendar_limit    = max( 365, $pickup_days );

				// the end date is progressively bumped ahead until there is a sufficient amount of days available for pickup (or a reasonable limit is met at one year length);
				// simultaneously, the unavailable dates are collected: these will be passed to JS to black out specific dates (lead days, public holidays, days without opening hours)
				do {

					if ( ! $location->get_public_holidays()->is_public_holiday( $end_time ) && $location->get_business_hours()->has_schedule( date( 'w', $end_time ), $lead_hours ) ) {
						$available_days++;
					} else {
						$unavailable_dates[] = date( 'Y-m-d', $end_time );
						$unavailable_days++;
					}

					$total_days = $unavailable_days + $available_days;
					$lead_hours = array();
					$end_time  += DAY_IN_SECONDS;

				} while ( $available_days < $pickup_days && $total_days < $calendar_limit );

				// ensure that any entire lead days are marked as unavailable
				if ( $lead_days > 0 ) {

					$current_time = $start_time;

					for ( $i = 0; $i < $lead_days; $i++ ) {

						$unavailable_dates[] = date( 'Y-m-d', $current_time );
						$current_time       += DAY_IN_SECONDS;
					}
				}

				// we cut these additional dates because:
				// - yesterday before first day, to rule out a rare glitch that may make a date available in the past
				$unavailable_dates[] = date( 'Y-m-d', strtotime( 'yesterday', $start_time ) );
				// - the end date, because it's bumped one day ahead than it should at the end of the previous while loop
				$unavailable_dates[] = date( 'Y-m-d', $end_time );
				// - the day after the end date, like in the yesterday date case, to rule out any rare glitch that could make an unavailable date selectable
				$unavailable_dates[] = date( 'Y-m-d', strtotime( 'tomorrow', $end_time ) );

				usort( $unavailable_dates, array( $this, 'sort_calendar_dates' ) );

				// we send data to the jQuery datepicker without the timezone information i.e. with `date( 'c', $timestamp )` because this will produce inaccurate results;
				// instead, jQuery will use these dates universally with `date( 'Y-m-d', $timestamp )` according to the browser's (system) timezone
				wp_send_json_success( array(
					// the address is merely used to append some information to the calendar HTML
					'address'           => $location->has_description() ? wp_kses_post( $location->get_address()->get_formatted_html( true ) . "\n" . '<br />' . "\n" . $location->get_description() ) : $location->get_address()->get_formatted_html( true ),
					// when the calendar opens (generally today: does not necessarily match the first selectable day, as it may be unavailable)
					'calendar_start'    => date( 'Y-m-d', $start_time ),
					// when the calendar can't go any further
					'calendar_end'      => date( 'Y-m-d', $end_time ),
					// dates marked unavailable cannot be selected
					'unavailable_dates' => array_unique( $unavailable_dates ),
				) );
			}
		}

		die;
	}


	/**
	 * Sorts calendar dates (`usort` callback helper method).
	 *
	 * @see \WC_Local_Pickup_Plus_Ajax::get_pickup_location_appointment_data()
	 *
	 * @since 2.3.5
	 *
	 * @param string $date_a first date to compare
	 * @param string $date_b second date to compare
	 * @return int
	 */
	private function sort_calendar_dates( $date_a, $date_b ) {
		return (int) strtotime( $date_a ) - (int) strtotime( $date_b );
	}


	/**
	 * Get a list of opening hours for any given day of the week.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function get_pickup_location_opening_hours_list() {

		check_ajax_referer( 'get-pickup-location-opening-hours-list', 'security' );

		if (    isset( $_POST['location'], $_POST['date'], $_POST['day'] )
		     && ( $location_id = is_numeric( $_POST['location'] ) ? (int) $_POST['location'] : null ) ) {

			$list     = '';
			$date     = $_POST['date'];
			$day      = (int) $_POST['day'];
			$location = wc_local_pickup_plus_get_pickup_location( $location_id );

			if ( $location && ( $opening_hours = $location->get_business_hours()->get_schedule( $day ) ) ) {

				ob_start(); ?>

				<?php if ( ! empty( $opening_hours ) ) : ?>

					<small class="pickup-location-field-label"><?php
						/* translators: Placeholder: %s - day of the week name */
						printf( __( 'Opening hours for pickup on %s:', 'woocommerce-shipping-local-pickup-plus' ),
							'<strong>' . date_i18n( 'l', strtotime( $date ) ) . '</strong>'
						); ?></small>
					<ul>
						<?php foreach ( $opening_hours as $time_string ) : ?>
							<li><small><?php echo esc_html( $time_string ); ?></small></li>
						<?php endforeach; ?>
					</ul>

				<?php endif; ?>

				<?php $list .= ob_get_clean();
			}

			if ( ! empty( $list ) ) {
				wp_send_json_success( $list );
			} else {
				wp_send_json_error();
			}
		}

		die;
	}


}

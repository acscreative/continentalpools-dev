<?php
/**
* 
*/
class xa_my_account_order_return
{
	function __construct(){
		$this->init();
		if( $this->frontend_retun_label ){
			add_action( 'woocommerce_order_details_after_order_table', array($this,'xa_return_from_my_account_form'), 5 , 1 );
		}
		if (isset($_GET['generate_fedex_return_label'])) {
			// $this->generate_fedex_return_label();
			add_action('init', array($this, 'generate_fedex_return_label'));
		}
	}
	private function init(){
		$this->settings = get_option( 'woocommerce_'.WF_Fedex_ID.'_settings', null );
		$this->debug        = ( $bool = $this->settings[ 'debug' ] ) && $bool == 'yes' ? true : false;

		//This option is removed since 3.2.3 (Released 09-Nov-17 ), Kept here for backward compatibility
		$this->retun_label_dom_service 	= isset( $this->settings['retun_label_dom_service'] ) ? $this->settings['retun_label_dom_service'] : '';
		$this->retun_label_int_service 	= isset( $this->settings['retun_label_int_service'] ) ? $this->settings['retun_label_int_service'] : '';
				
		if(empty($this->retun_label_dom_service))
			$this->retun_label_dom_service 	= isset( $this->settings['default_dom_service'] ) ? $this->settings['default_dom_service'] : '';
		
		if( empty($this->retun_label_int_service))
			$this->retun_label_int_service 	= isset( $this->settings['default_int_service'] ) ? $this->settings['default_int_service'] : '';
		
		$this->frontend_retun_label 	= isset( $this->settings['frontend_retun_label'] ) && $this->settings['frontend_retun_label'] =='yes' ? true : false;

	}

	public function xa_return_from_my_account_form( $order ) {
		global $woocommerce;
		global $wp;

		$this->order_id = isset($wp->query_vars['view-order']) ? $wp->query_vars['view-order'] : 0;
		
		$shipmentIds = get_post_meta($this->order_id, 'wf_woo_fedex_shipmentId', false);
		if (!empty($shipmentIds)) {
			echo "<h2>Shipping details</h2>";
			foreach($shipmentIds as $shipmentId) {
				$shipping_return_label = get_post_meta($this->order_id, 'wf_woo_fedex_returnLabel_'.$shipmentId, true);
				$return_shipment_id = get_post_meta($this->order_id, 'wf_woo_fedex_returnShipmetId', true);
				if(!empty($shipping_return_label)){
					$download_url = admin_url('/post.php?wf_fedex_viewReturnlabel='.base64_encode($shipmentId.'|'.$this->order_id) );
					echo '<li style="padding:10px"><strong>Return Shipment #:</strong> '.$return_shipment_id;?>
					<a class="button tips" href="<?php echo $download_url; ?>" data-tip="<?php _e('Print Return Label', 'wf-shipping-fedex'); ?>"><?php _e('Print Return Label', 'wf-shipping-fedex'); ?></a>
					</li>
					<?php 
				}else{
					$selected_sevice = $this->wf_get_shipping_service($order);
					$generate_url = home_url("/my-account/view-order/$this->order_id/?generate_fedex_return_label=".base64_encode($shipmentId ."|".$this->order_id) );
					?>
					<li style="padding: 10px">
					<strong>Shipment id: </strong><a style="padding: 5px"><?php echo $shipmentId?></a>
					<input type="hidden" class="fedex_return_service" value="<?php echo $selected_sevice;?>" />
					<a class="button button-primary fedex_create_return_shipment tips" href="<?php echo $generate_url?>" data-tip="<?php _e( 'Generate return label', 'wf-shipping-fedex' ); ?>"><?php _e( 'Generate return label', 'wf-shipping-fedex' ); ?></a>
					</li><?php
				}
			}
		}
	}

	public function generate_fedex_return_label(){
		if( empty($_GET['generate_fedex_return_label']) ){
			return false;
		}
		$return_params = explode('|', base64_decode($_GET['generate_fedex_return_label']));
		
		if(empty($return_params) || !is_array($return_params) || count($return_params) != 2)
			return;

		$shipment_id = $return_params[0]; 
		$this->order_id 		=  $return_params[1];
		
		if ( ! class_exists( 'wf_fedex_woocommerce_shipping_admin_helper' ) )
			include_once 'class-wf-fedex-woocommerce-shipping-admin-helper.php';
		
		
		$woofedexwrapper = new wf_fedex_woocommerce_shipping_admin_helper();
		$this->order = $this->wf_load_order($this->order_id);

		$serviceCode = $this->wf_get_shipping_service( $this->order,false);
		
		$woofedexwrapper->print_return_label( $shipment_id, $this->order_id, $serviceCode  );		

		$location = home_url("/my-account/view-order/$this->order_id/");
		if(!$this->debug){
			echo"<script>
			    window.location.href = '".$location."';
			</script>";
			exit();
		}
	}

	private function wf_load_order($orderId){
		if (!class_exists('WC_Order')) {
			return false;
		}
		
		if(!class_exists('wf_order')){
			include_once('class-wf-legacy.php');
		}
		return ( WC()->version < '2.7.0' ) ? new WC_Order( $orderId ) : new wf_order( $orderId );    
	}

	private function wf_get_shipping_service($order,$retrive_from_order = false, $shipment_id=false){
		//Origin country cannot initialize from constructor, because global WC is not getting loaded there.
		$origin_country 	= isset( $this->settings['origin_country'] ) ? $this->settings['origin_country'] : WC()->countries->get_base_country() ;

		$order = $this->wf_load_order($this->order_id);
		$this->is_international = ($order->shipping_country != $origin_country ) ? true : false;


		if( !$this->is_international && !empty($this->retun_label_dom_service) ){
			return $this->retun_label_dom_service;	
		}

		if( $this->is_international && !empty($this->retun_label_int_service) ){
			return $this->retun_label_int_service;
		}

		if($retrive_from_order == true){
			$service_code = get_post_meta($order->id, 'wf_woo_fedex_service_code'.$shipment_id, true);
			if(!empty($service_code)) return $service_code;
		}
		
		if(!empty($_GET['service'])){			
		    $service_arr    =   json_decode(stripslashes(html_entity_decode($_GET["service"])));  
			return $service_arr[0];
		}
			
		//TODO: Take the first shipping method. It doesnt work if you have item wise shipping method
		$shipping_methods = $order->get_shipping_methods();
		
		if ( ! $shipping_methods ) {
			return '';
		}
		$shipping_method = array_shift($shipping_methods);
		if( strpos($shipping_method, WF_Fedex_ID)==false ){
			return false;
		}

		return str_replace(WF_Fedex_ID.':', '', $shipping_method['method_id']);
	}
}
new xa_my_account_order_return;
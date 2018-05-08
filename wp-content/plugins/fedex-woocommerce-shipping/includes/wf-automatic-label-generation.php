<?php



	$shipping_setting =get_option('woocommerce_wf_fedex_woocommerce_shipping_settings');

	if(isset($shipping_setting['automate_package_generation']) && $shipping_setting['automate_package_generation']=='yes' )
	{
		add_filter( 'woocommerce_payment_complete_order_status', 'wf_automatic_package_and_label_generation_fedex',100,2 );
	}
	function wf_automatic_package_and_label_generation_fedex($status,$order_id)
	{
		$order = new WC_Order($order_id);
		//  Automatically Generate Packages
		$current_minute=(integer)date('i');
		$package_url=admin_url( '/post.php?wf_fedex_generate_packages='.base64_encode($order_id).'&auto_generate='.md5($current_minute) );
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$package_url);
		$output=curl_exec($ch);
		curl_close($ch);
		return $status;
	}
	
	function wf_get_shipping_service($order,$retrive_from_order = false, $shipment_id=false){
		
		if($retrive_from_order == true){
			$service_code = get_post_meta($order->id, 'wf_woo_fedex_service_code'.$shipment_id, true);
			if(!empty($service_code)) return $service_code;
		}
		
		if(!empty($_GET['service'])){			
		    $service_arr    =   json_decode(stripslashes(html_entity_decode($_GET["service"])));  
			return $service_arr[0];
		}

		$settings = get_option( 'woocommerce_'.WF_Fedex_ID.'_settings', null );


		if( $settings['origin_country'] == $order->get_shipping_country() ){
			if( !empty($settings['default_dom_service']) ){
				return $settings['default_dom_service'];
			}
		}else{
			if( !empty($settings['default_int_service']) ){
				return $settings['default_int_service'];
			}
		}

		//TODO: Take the first shipping method. It doesnt work if you have item wise shipping method
		$shipping_methods = $order->get_shipping_methods();
		
		if ( ! $shipping_methods ) {
			return '';
		}
	
		$shipping_method = array_shift($shipping_methods);

		return str_replace(WF_Fedex_ID.':', '', $shipping_method['method_id']);
	}
	
	if(isset($shipping_setting['automate_label_generation']) && $shipping_setting['automate_label_generation']=='yes' ){	
		add_action('wf_after_package_generation','wf_auto_genarate_label_fedex',2,2);
	}

	function wf_auto_genarate_label_fedex($order_id,$package_data){
		/// Automatically Generate Labels
		$current_minute=(integer)date('i');
		$package_url=admin_url( '/post.php?wf_fedex_createshipment='.$order_id.'&auto_generate='.md5($current_minute) );

		$service_code=wf_get_shipping_service( new WC_Order($order_id) );
		$weight=array();
		$length=array();
		$width=array();
		$height=array();
		$services=array();
		foreach($package_data as $key=>$val)
		{	
			foreach($val as $key2=>$package)
			{	//error_log('weight='.$package['Weight']['Value']);
				if(isset($package['Weight'])) $weight[]=$package['Weight']['Value'];
				if(isset($package['Dimensions']))
				{
					$length[]=$package['Dimensions']['Length'];
					$width[]=$package['Dimensions']['Width'];
					$height[]=$package['Dimensions']['Height'];
				}
				$services[]=$service_code;
			}
		}
		$package_url.='&weight=["'.implode('","',$weight).'"]';
		$package_url.='&length=["'.implode('","',$length).'"]';
		$package_url.='&width=["'.implode('","',$width).'"]';
		$package_url.='&height=["'.implode('","',$height).'"]';
		$package_url.='&service=["'.implode('","',$services).'"]';
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$package_url);
		@$output=curl_exec($ch);
		curl_close($ch);

	}
	if(isset($shipping_setting['auto_email_label']) && $shipping_setting['auto_email_label']=='yes' )
	{		
		add_action('wf_label_generated_successfully','wf_after_label_generation_fedex',3,3);
	}


	function wf_after_label_generation_fedex($shipment_id,$encoded_label_image,$order_id)
	{
		$shipping_setting2 =get_option('woocommerce_wf_fedex_woocommerce_shipping_settings');
		if(isset($shipping_setting2['email_content']) && !empty($shipping_setting2['email_content']))
		{
			$emailcontent=$shipping_setting2['email_content'];
		}
		else
		{
			$emailcontent= ' ';
		}
		unset($shipping_setting2);
		if(!empty($shipment_id))
		{
			$order = new WC_Order( $order_id );
			$to = $order->get_billing_email();
			$subject = 'Shipment Label For Your Order';
			$img_url=admin_url('/post.php?wf_fedex_viewlabel='.base64_encode($shipment_id.'|'.$order_id));
			$body = "Please Download the label
			<html>
			<body>	<div>".$emailcontent."</div> </br>
					<a href='".$img_url."' ><input type='button' value='Download the label here' /> </a>
			</body>
			</html>
					";
			$headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail( $to, $subject, $body, $headers );		
		}
	
	}

	if(isset($shipping_setting['allow_label_btn_on_myaccount']) && $shipping_setting['allow_label_btn_on_myaccount']=='yes' )
	{	
		add_action('woocommerce_view_order','wf_add_view_shippinglabel_button_on_myaccount_order_page_fedex');
	}
	function wf_add_view_shippinglabel_button_on_myaccount_order_page_fedex($order_id)
	{
		$shipment_id= get_post_meta($order_id,'wf_woo_fedex_shipmentId',true);
		if(!empty($shipment_id))
		{
			$img_url=admin_url('/post.php?wf_fedex_viewlabel='.base64_encode($shipment_id.'|'.$order_id));
			echo ' </br><a href="'.$img_url.'" ><input type="button" value="Download Shipping Label here" class="button" /> </a> </br></br>';			
		}

	}
	unset($shipping_setting);
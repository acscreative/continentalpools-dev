<?php
add_filter('wf_filter_label_packages', 'wf_fx_shipping_packages_filter',21,3);
function wf_fx_shipping_packages_filter($packages,$address, $order_id){	
	$wms_packages           = get_post_meta($order_id, '_wcms_packages', true);		
	if(is_array($wms_packages)){
		return $wms_packages;
	}
	return $packages;
}
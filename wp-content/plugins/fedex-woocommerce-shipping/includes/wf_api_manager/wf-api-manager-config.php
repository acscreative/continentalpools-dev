<?php

$product_name = 'fedex'; // name should match with 'Software Title' configured in server, and it should not contains white space
$product_version = '4.0.0';
$product_slug = 'fedex-woocommerce-shipping/fedex-woocommerce-shipping.php'; //product base_path/file_name
$serve_url = 'https://www.xadapter.com/';
$plugin_settings_url = admin_url('admin.php?page=wc-settings&tab=shipping&section=wf_fedex_woocommerce_shipping');

//include api manager
include_once ( 'wf_api_manager.php' );
new WF_API_Manager($product_name, $product_version, $product_slug, $serve_url, $plugin_settings_url);
?>

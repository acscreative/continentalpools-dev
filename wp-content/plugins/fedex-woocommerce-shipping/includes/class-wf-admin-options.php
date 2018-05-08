<?php
if( !class_exists('WF_Admin_Options') ){
    class WF_Admin_Options{
        function __construct(){
			$this->freight_classes	=	include( 'data-wf-freight-classes.php' );
			$this->init();
        }

        function init(){
            $this->settings = get_option( 'woocommerce_'.WF_Fedex_ID.'_settings', null );

            if( is_admin() ){
                // Add a custome field in product page variation level
                add_action( 'woocommerce_product_after_variable_attributes', array($this,'wf_variation_settings_fields'), 10, 3 );
                // Save a custome field in product page variation level
                add_action( 'woocommerce_save_product_variation', array($this,'wf_save_variation_settings_fields'), 10, 2 );

                //add a custome field in product page
                add_action( 'woocommerce_product_options_shipping', array($this,'wf_custome_product_page')  );
                //Saving the values
                add_action( 'woocommerce_process_product_meta', array( $this, 'wf_save_custome_product_fields' ) );
			}

			add_action( 'woocommerce_product_options_shipping', array($this,	'admin_add_frieght_class'));
			add_action( 'woocommerce_process_product_meta', 	array( $this, 	'admin_save_frieght_class' ));
			add_action( 'woocommerce_product_after_variable_attributes', array($this,	'admin_add_frieght_class_variation'), 10, 3 );
			add_action( 'woocommerce_save_product_variation',array( $this, 	'admin_save_frieght_class_variation'), 10, 2 );
        }

        function wf_custome_product_page() {
            //HS code field
            woocommerce_wp_text_input( array(
                'id' => '_wf_hs_code',
                'label' => 'HS Tariff Number (FedEx)',
                'description' => __('HS is a standardized system of names and numbers to classify products.','wf-shipping-fedex'),
                'desc_tip' => 'true',
                'placeholder' => 'Harmonized System'
            ) );

            if( isset($this->settings['dry_ice_enabled']) && $this->settings['dry_ice_enabled']=='yes' ){
                //dry ice
                woocommerce_wp_checkbox( array(
                    'id' => '_wf_dry_ice',
                    'label' => 'Dry ice (FedEx)',
                    'description' => __('Check this the product is dry ice.','wf-shipping-fedex'),
                    'desc_tip' => 'true',
                ) );
            }            
            //Country of manufacture
            woocommerce_wp_text_input( array(
                'id' => '_wf_manufacture_country',
                'label' => 'Country of manufacture (FedEx)',
                'description' => __('Country of manufacture','wf-shipping-fedex'),
                'desc_tip' => 'true',
                'placeholder' => 'Country of manufacture'
            ) );
			
			//Dangerous Goods
			woocommerce_wp_checkbox( array(
				'id' => '_dangerous_goods',
				'label' => 'Dangerous Goods (FedEx)',
				'description' => __('Check this to mark the product as a dangerous goods.','wf-shipping-fedex'),
				'desc_tip' => 'true',
			));

            //Pre packed
            woocommerce_wp_checkbox( array(
            'id' => '_wf_fedex_pre_packed',
            'label' => __('Pre packed product (FedEx)','wf-shipping-fedex'),
            'description' => __('Check this if the item comes in boxes. It will consider as a separate package and ship in its own box.', 'wf-shipping-fedex'),
            'desc_tip' => 'true',
            ) );

            //Non-Standard Prducts
            woocommerce_wp_checkbox( array(
            'id' => '_wf_fedex_non_standard_product',
            'label' => __('Non-Standard product (FedEx)','wf-shipping-fedex'),
            'description' => __('Check this if the product belongs to Non Standard Container. Non-Stantard product will be charged heigher', 'wf-shipping-fedex'),
            'desc_tip' => 'true',
            ) );
        }


        public function wf_variation_settings_fields( $loop, $variation_data, $variation ){
            $is_pre_packed_var = get_post_meta( $variation->ID, '_wf_fedex_pre_packed_var', true );
            if( empty( $is_pre_packed_var ) ){
                $is_pre_packed_var = get_post_meta( wp_get_post_parent_id($variation->ID), '_wf_fedex_pre_packed', true );
            }
            woocommerce_wp_checkbox( array(
                'id' => '_wf_fedex_pre_packed_var[' . $variation->ID . ']',
                'label' => __(' Pre packed product(FedEx)', 'wf-shipping-fedex'),
                'description' => __('Check this if the item comes in boxes. It will override global product settings', 'wf-shipping-fedex'),
                'desc_tip' => 'true',
                'value'         => $is_pre_packed_var,
            ) );
        }

        public function wf_save_variation_settings_fields( $post_id ){
            $checkbox = isset( $_POST['_wf_fedex_pre_packed_var'][ $post_id ] ) ? 'yes' : 'no';
            update_post_meta( $post_id, '_wf_fedex_pre_packed_var', $checkbox );
        }

        function wf_save_custome_product_fields( $post_id ) {
            //HS code value
            if ( isset( $_POST['_wf_hs_code'] ) ) {
                update_post_meta( $post_id, '_wf_hs_code', esc_attr( $_POST['_wf_hs_code'] ) );
            }
            
            //dry ice
            $is_dry_ice =  ( isset( $_POST['_wf_dry_ice'] ) && esc_attr($_POST['_wf_dry_ice']=='yes')  ) ? esc_attr($_POST['_wf_dry_ice']) : false;
            update_post_meta( $post_id, '_wf_dry_ice', $is_dry_ice );

            // Country of manufacture
            if ( isset( $_POST['_wf_manufacture_country'] ) ) {
                update_post_meta( $post_id, '_wf_manufacture_country', esc_attr( $_POST['_wf_manufacture_country'] ) );
            }
            
            //Dangerous Goods
            $dangerous_goods =  ( isset( $_POST['_dangerous_goods'] ) && esc_attr($_POST['_dangerous_goods'])=='yes') ? esc_attr($_POST['_dangerous_goods'])  : false;
            update_post_meta( $post_id, '_dangerous_goods', $dangerous_goods );
            
            // Pre packed
            if ( isset( $_POST['_wf_fedex_pre_packed'] ) ) {
                update_post_meta( $post_id, '_wf_fedex_pre_packed', esc_attr( $_POST['_wf_fedex_pre_packed'] ) );
            } else {
                update_post_meta( $post_id, '_wf_fedex_pre_packed', '' );
            }
            
            //non-standard product
            $non_standard_product =  ( isset( $_POST['_wf_fedex_non_standard_product'] ) && esc_attr($_POST['_wf_fedex_non_standard_product'])=='yes') ? esc_attr($_POST['_wf_fedex_non_standard_product'])  : false;
            update_post_meta( $post_id, '_wf_fedex_non_standard_product', $non_standard_product );
            
        }
		
		function admin_add_frieght_class() {
            woocommerce_wp_select(array(
                'id' => 	'_wf_freight_class',
                'label' => 	 __('Freight Class','wf-shipping-fedex'),
                'options' => array(''=>__('None'))+$this->freight_classes,
				'description' => __('FedEx Freight class for shipping calculation.','wf-shipping-fedex'),
                'desc_tip' => 'true',
            ));
        }
		
		function admin_add_frieght_class_variation($loop, $variation_data, $variation){
			woocommerce_wp_select( 
			array( 
				'id'          => '_wf_freight_class[' . $variation->ID . ']', 
				'label'       => __( 'Freight Class', 'woocommerce' ), 
				'value'       => get_post_meta( $variation->ID, '_wf_freight_class', true ),
				'options' =>  array(''=>__('Default','wf-shipping-fedex'))+$this->freight_classes,
				'description' => __('Leaving default will inherit parent FedEx Freight class.','wf-shipping-fedex'),
                'desc_tip' => 'true',
				)
			);
		}

        function admin_save_frieght_class( $post_id ) {
            if ( isset( $_POST['_wf_freight_class'] ) ) {
                update_post_meta( $post_id, '_wf_freight_class', esc_attr( $_POST['_wf_freight_class'] ) );
            }
        }
		function admin_save_frieght_class_variation( $post_id ) {
			$select = $_POST['_wf_freight_class'][ $post_id ];
			if( ! empty( $select ) ) {
				update_post_meta( $post_id, '_wf_freight_class', esc_attr( $select ) );
			}
		}
    }
    new WF_Admin_Options();
}

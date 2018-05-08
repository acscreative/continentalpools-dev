<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class xa_settings_input_fields extends WC_Settings_API
{
	public function __construct(){
		$this->settings = get_option( 'woocommerce_'.WF_Fedex_ID.'_settings', null );
	}

	function xa_load_input_checkbox( $name, $checked, $label='', $description='', $class='', $disabled=false ){
		$disabled = ($disabled) ? 'disabled="true"' : "";
		echo '<input class="input-text regular-input '.$class.'" type="checkbox" name="'.$name.'" id="'.$name.'" style="" value="yes" '.$checked.' placeholder=""> '.$label;

		if($description){
			echo ' <span class="woocommerce-help-tip" data-tip="'.$description.'"></span>';
		}

	}
	function xa_load_input_field($type, $name, $value, $label='', $description='', $placeholder='', $class='', $disabled=false){
		$disabled = ($disabled) ? 'disabled="true"' : "";
		echo '<input class="input-text regular-input '.$class.'" type="'.$type.'" name="'.$name.'" id="'.$name.'" '.$disabled.' value="'.$value.'" placeholder="'.$placeholder.'">';
		echo ' <label for="'.$name.'" class="'.$class.'">'.$label.'</label>';
		if($description){
			echo ' <span class="woocommerce-help-tip" for="'.$name.'" data-tip="'.$description.'"></span>';
		}

	}

	function xa_load_input_select( $name, $selected_value, $options, $label='', $tool_tip='', $class='', $label_position=1 ){
		if( $label_position==1 && !empty($label) )
			echo '<label for="">'.$label.'</label><br>';

		echo '<select name="'.$name.'" id="'.$name.'" class="'.$class.'">';
		foreach ($options as $key => $value) {
			if($key == $selected_value){
				echo '<option value="'.$key.'" selected="true">'.$value.'</option>';
			}else{
				echo '<option value="'.$key.'">'.$value.'</option>';
			}
		}
		echo '</select>';

		if( $label_position==2 && !empty($label) )
			echo '<label for="">'.$label.'</label>';

		if($tool_tip){
			echo ' <span class="woocommerce-help-tip" data-tip="'.$tool_tip.'"></span>';
		}
	}

	function xa_load_input_radio( $name, $value, $options, $class='', $disabled=false ){
		$disabled = ($disabled) ? 'disabled="true"' : "";
		foreach ($options as $key => $label) {
			$checked = ( $value == $key ) ? 'checked="true"' : '';
			echo '<input class="input-text regular-input '.$class.'" type="radio" name="'.$name.'"  id="'.$name.'-'.$key.'" value="'.$key.'"  '.$disabled.' '.$checked.'/>'.$label.'&nbsp;'; 
		}
	}

	function xa_load_select_country($origin_country, $origin_state, $class='' ) {
		global $woocommerce;
	    echo'<select name="origin_country" id="origin_country" style="width: 250px;" data-placeholder="" title="Country" class="chosen_select '.$class.'">';
	        	echo $woocommerce->countries->country_dropdown_options( $origin_country, !empty($origin_state) ? $origin_state : '*' );
	    echo '</select>';
	}

	function get_origin_country_state($fededx_settings){
		$origin_country_state 		= isset( $fededx_settings['origin_country'] ) ? $fededx_settings['origin_country'] : '';
		if ( strstr( $origin_country_state, ':' ) ) :
			// WF: Following strict php standards.
			$origin_country_state_array 	= explode(':',$origin_country_state);
			$origin_country 			= current($origin_country_state_array);
			$origin_country_state_array 	= explode(':',$origin_country_state);
			$origin_state   				= end($origin_country_state_array);
		else :
			$origin_country = $origin_country_state;
			$origin_state   = '';
		endif;

		return array(
			'origin_country'  	=> apply_filters( 'woocommerce_fedex_origin_country_code', $origin_country ),
			'origin_state' 		=> !empty($origin_state) ? $origin_state : ( !empty($fededx_settings[ 'freight_shipper_state' ]) ? $fededx_settings[ 'freight_shipper_state' ] : ''),
		);
	}
}
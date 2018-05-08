<?php
if(!class_exists('weightPack')){
	class weightPack{
		var $packable_items=array();
		function __construct($strategy,$package,$options=array()){
			
			$to_ship  				= 	array();
			$group_id 				= 	1;		
			$group					= 	array();
			$package_total_weight	=	0;
			$insured_value			=	0;
			
			// Get weight of order
			foreach ( $package['contents'] as $item_id => $values ) {
				$values['data'] = new wf_product( $values['data'] );
				if ( ! $values['data']->needs_shipping() ) {
					$this->debug( sprintf( __( 'Product # is virtual. Skipping.', 'wf-shipping-fedex' ), $item_id ), 'error' );
					continue;
				}

				if ( ! $values['data']->get_weight() ) {
					$this->debug( sprintf( __( 'Product # is missing weight. Aborting.', 'wf-shipping-fedex' ), $item_id ), 'error' );
					return;
				}
				$package_total_weight	=	$package_total_weight+(wc_get_weight( $values['data']->get_weight(), $this->weight_unit )*$values['quantity']);
				$insured_value			=	$insured_value+$values['data']->get_price()*$values['quantity'];
				for($i=0;$i<$values['quantity'];$i++){
					$this->packable_items[]	=	$values['data'];
				}
			}
			echo '<hr>';
			pre($this->packable_items);
			
			switch($strategy){
				case 'descending':
					$pack=new weightPackDescend($this->packable_items);
				default:
					$pack=new weightPackDescend($this->packable_items);
			}
			$pack->packItems();
			//pre($package);
			echo '</br>';
		}		
	}

	interface weightBasedPackages {
		public function packItems();
	}

	class weightPackAscend implements weightBasedPackages{
		var $packable_items=array();
		public function __construct($packable_items){
			$this->packable_items=$packable_items;
		}
		public function packItems(){
			echo 'Ascend';
		}
	}

	class weightPackDescend implements weightBasedPackages{
		var $packable_items=array();
		public function __construct($packable_items){
			$this->packable_items=$packable_items;
		}
		public function packItems(){
			usort($this->packable_items,array($this,'sortDescend'));
			pre($this->packable_items);
		}
		function sortDescend($a,$b){
			$weight_a=floatval($a->weight);
			$weight_b=floatval($b->weight);
			if ($weight_a == $weight_b) {
				return 0;
			}
			return ($weight_a > $weight_b) ? +1 : -1;
		}
	}
}
<?php
/**
 * Box Sizes for fedex in array format
 * Box informatios available in this link http://www.fedex.com/us/service-guide/prepare-shipment/packing/express-ground/express-supplies.html
 */
return array(
	array(
		'name'       => 'FedEx&#174; Small Box',
		'id'         => 'FEDEX_SMALL_BOX',
		'max_weight' => 20,
		'box_weight' => 0,
		'length'     => 12.375,
		'width'      => 10.875,
		'height'     => 1.5,
		'inner_length'	=>	12.375,
		'inner_width'	=>	10.875,
		'inner_height'	=>	1.5
	),
	array(
		'name'       => 'FedEx&#174; Small Box',
		'id'         => 'FEDEX_SMALL_BOX:2',
		'max_weight' => 20,
		'box_weight' => 0,
		'length'     => 11.25,
		'width'      => 8.75,
		'height'     => 2.625,
		'inner_length'	=>	11.25,
		'inner_width'	=>	8.75,
		'inner_height'	=>	2.625
	),
	array(
		'name'       => 'FedEx&#174; Medium Box',
		'id'         => 'FEDEX_MEDIUM_BOX',
		'max_weight' => 20,
		'box_weight' => 0,
		'length'     => 13.25,
		'width'      => 11.5,
		'height'     => 2.375,
		'inner_length'	=>	13.25,
		'inner_width'	=>	11.5,
		'inner_height'	=>	2.375
	),
	array(
		'name'       => 'FedEx&#174; Medium Box',
		'id'         => 'FEDEX_MEDIUM_BOX:2',
		'max_weight' => 20,
		'box_weight' => 0,
		'length'     => 11.25,
		'width'      => 8.75,
		'height'     => 4.375,
		'inner_length'	=>	11.25,
		'inner_width'	=>	8.75,
		'inner_height'	=>	4.375
	),
	array(
		'name'       => 'FedEx&#174; Large Box',
		'id'         => 'FEDEX_LARGE_BOX',
		'max_weight' => 30,
		'box_weight' => 0,
		'length'     => 17.5,
		'width'      => 12.365,
		'height'     => 3,
		'inner_length'	=>	17.5,
		'inner_width'	=>	12.365,
		'inner_height'	=>	3
	),
	array(
		'name'       => 'FedEx&#174; Large Box',
		'id'         => 'FEDEX_LARGE_BOX:2',
		'max_weight' => 30,
		'box_weight' => 0,
		'length'     => 11.25,
		'width'      => 8.75,
		'height'     => 7.75,
		'inner_length'	=>	11.25,
		'inner_width'	=>	8.75,
		'inner_height'	=>	7.75
	),
	array(
		'name'       => 'FedEx&#174; Extra Large Box',
		'id'         => 'FEDEX_EXTRA_LARGE_BOX',
		'max_weight' => 30,
		'box_weight' => 0,
		'length'     => 11.875,
		'width'      => 11,
		'height'     => 10.75,
		'inner_length'	=>	11.875,
		'inner_width'	=>	11,
		'inner_height'	=>	10.75
	),
	array(
		'name'       => 'FedEx&#174; Extra Large Box',
		'id'         => 'FEDEX_EXTRA_LARGE_BOX:2',
		'max_weight' => 30,
		'box_weight' => 0,
		'length'     => 15.75,
		'width'      => 14.125,
		'height'     => 6,
		'inner_length'	=>	15.75,
		'inner_width'	=>	14.125,
		'inner_height'	=>	6
	),
	array(
		'name'       => 'FedEx&#174; Pak',
		'id'         => 'FEDEX_PAK',
		'max_weight' => 50,
		'box_weight' => 0,
		'length'     => 15.5,
		'width'      => 12,
		'height'     => 1.5,
		'inner_length'	=>	15.5,
		'inner_width'	=>	12,
		'inner_height'	=>	1.5,
		'type'       => 'packet'
	),
	array(
		'name'       => 'FedEx&#174; Envelope',
		'id'         => 'FEDEX_ENVELOPE',
		'max_weight' => 10,
		'box_weight' => 0,
		'length'     => 12.5,
		'width'      => 9.5,
		'height'     => .25,
		'inner_length'	=>	12.5,
		'inner_width'	=>	9.5,
		'inner_height'	=>	.25,
		'type'       => 'envelope'
	),
	array(
		'name'       => 'FedEx&#174; 10kg Box',
		'id'         => 'FEDEX_10KG_BOX',
		'max_weight' => 22,
		'box_weight' => 0.019375,
		'length'     => 15.81,
		'width'      => 12.94,
		'height'     => 10.19,
		'inner_length'	=>	15.81,
		'inner_width'	=>	12.94,
		'inner_height'	=>	10.19
	),
	array(
		'name'       => 'FedEx&#174; 25kg Box',
		'id'         => 'FEDEX_25KG_BOX',
		'max_weight' => 55,
		'box_weight' => 0.035625,
		'length'     => 21.56,
		'width'      => 16.56,
		'height'     => 13.19,
		'inner_length'	=>	21.56,
		'inner_width'	=>	16.56,
		'inner_height'	=>	13.19
	)
);
<?php

/*-----------------------------------------------------------------------------------*/
/* Global variables
/*-----------------------------------------------------------------------------------*/

$orderby = array("Title" => "title","Menu order" => "menu_order","Date" => "date","Random" => "rand","ID" => "id","None" => "");
$order = array("Ascending" => "asc","Descending" => "desc");

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Recent Products
/*-----------------------------------------------------------------------------------*/
vc_map( array(
	"name" => __("Order tracking", 'minti-framework'),
	"description" => __("Order Tracking Form", 'minti-framework'),
	"base" => "woocommerce_order_tracking",
	"show_settings_on_create" => false,
	"category" => __('WooCommerce', 'minti-framework'),
	"icon"          => "icon-wpb-minti-woocommerce",
) );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Recent Products
/*-----------------------------------------------------------------------------------*/
vc_map( array(
	"name" => __("Recent products", 'minti-framework'),
	"description" => __("Recent Products", 'minti-framework'),
	"base" => "recent_products",
	"show_settings_on_create" => true,
	"category" => __('WooCommerce', 'minti-framework'),
	"icon"          => "icon-wpb-minti-woocommerce",
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Products", 'minti-framework'),
			"param_name" => "per_page",
			"value" => "4",
			"description" => __("How many products you want to show on the page.", 'minti-framework')
		),
		array(
		"type" => "dropdown",
		"heading" => __("Columns", 'minti-framework'),
		"param_name" => "columns",
		"value" => array(
			'4' 	=> '4',
			'3' 	=> '3',
			'2' 	=> '2',
		),
		"description" => __("How many products in a row.", 'minti-framework')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order by", 'minti-framework'),
			"param_name" => "orderby",
			"value" => $orderby,
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order", 'minti-framework'),
			"param_name" => "order",
			"value" => $order,
		),
    )
) );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Featured Products
/*-----------------------------------------------------------------------------------*/
vc_map( array(
	"name" => __("Featured Products", 'minti-framework'),
	"description" => __("Featured Products", 'minti-framework'),
	"base" => "featured_products",
	"show_settings_on_create" => true,
	"category" => __('WooCommerce', 'minti-framework'),
	"icon"          => "icon-wpb-minti-woocommerce",
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Per page", 'minti-framework'),
			"param_name" => "per_page",
			"value" => "4",
			"description" => __("How many products you want to show on the page.", 'minti-framework')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Columns", 'minti-framework'),
			"param_name" => "columns",
			"value" => array(
				'4' 	=> '4',
				'3' 	=> '3',
				'2' 	=> '2',
			),
			"description" => __("How many products in a row.", 'minti-framework')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order by", 'minti-framework'),
			"param_name" => "orderby",
			"value" => $orderby,
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order", 'minti-framework'),
			"param_name" => "order",
			"value" => $order,
		),
	)
) );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Featured Products
/*-----------------------------------------------------------------------------------*/
vc_map( array(
	"name" => __("Products on Sale", 'minti-framework'),
	"description" => __("Sale Products", 'minti-framework'),
	"base" => "sale_products",
	"show_settings_on_create" => true,
	"category" => __('WooCommerce', 'minti-framework'),
	"icon"          => "icon-wpb-minti-woocommerce",
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Per page", 'minti-framework'),
			"param_name" => "per_page",
			"value" => "4",
			"description" => __("How many products you want to show on the page.", 'minti-framework')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Columns", 'minti-framework'),
			"param_name" => "columns",
			"value" => array(
				'4' 	=> '4',
				'3' 	=> '3',
				'2' 	=> '2',
			),
			"description" => __("How many products in a row.", 'minti-framework')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order by", 'minti-framework'),
			"param_name" => "orderby",
			"value" => $orderby,
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order", 'minti-framework'),
			"param_name" => "order",
			"value" => $order,
		),
	)
) );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Best Selling Products
/*-----------------------------------------------------------------------------------*/
vc_map( array(
	"name" => __("Best Selling Products", 'minti-framework'),
	"description" => __("Best Selling Products", 'minti-framework'),
	"base" => "best_selling_products",
	"show_settings_on_create" => true,
	"category" => __('WooCommerce', 'minti-framework'),
	"icon"          => "icon-wpb-minti-woocommerce",
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Per page", 'minti-framework'),
			"param_name" => "per_page",
			"value" => "4",
			"description" => __("How many products you want to show on the page.", 'minti-framework')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Columns", 'minti-framework'),
			"param_name" => "columns",
			"value" => array(
				'4' 	=> '4',
				'3' 	=> '3',
				'2' 	=> '2',
			),
			"description" => __("How many products in a row.", 'minti-framework')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order by", 'minti-framework'),
			"param_name" => "orderby",
			"value" => $orderby,
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order", 'minti-framework'),
			"param_name" => "order",
			"value" => $order,
		),
	)
) );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Top Rated Products
/*-----------------------------------------------------------------------------------*/
vc_map( array(
	"name" => __("Top Rated Products", 'minti-framework'),
	"description" => __("Top Rated Products", 'minti-framework'),
	"base" => "top_rated_products",
	"show_settings_on_create" => true,
	"category" => __('WooCommerce', 'minti-framework'),
	"icon"          => "icon-wpb-minti-woocommerce",
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Per page", 'minti-framework'),
			"param_name" => "per_page",
			"value" => "4",
			"description" => __("How many products you want to show on the page.", 'minti-framework')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Columns", 'minti-framework'),
			"param_name" => "columns",
			"value" => array(
				'4' 	=> '4',
				'3' 	=> '3',
				'2' 	=> '2',
			),
			"description" => __("How many products in a row.", 'minti-framework')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order by", 'minti-framework'),
			"param_name" => "orderby",
			"value" => $orderby,
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order", 'minti-framework'),
			"param_name" => "order",
			"value" => $order,
		),
	)
) );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Product Category
/*-----------------------------------------------------------------------------------*/
vc_map( array(
	"name" => __("Product Category", 'minti-framework'),
	"description" => __("Shows Products by Category", 'minti-framework'),
	"base" => "product_category",
	"show_settings_on_create" => true,
	"category" => __('WooCommerce', 'minti-framework'),
	"icon"          => "icon-wpb-minti-woocommerce",
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Category slug", 'minti-framework'),
			"param_name" => "category",
			"admin_label" => true,
			"description" => __("Enter Category Slug or Slugs (separated by comma).", 'minti-framework')
		), 
		array(
			"type" => "textfield",
			"heading" => __("Per page", 'minti-framework'),
			"param_name" => "per_page",
			"value" => "4",
			"description" => __("How many products you want to show on the page.", 'minti-framework')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Columns", 'minti-framework'),
			"param_name" => "columns",
			"value" => array(
				'4' 	=> '4',
				'3' 	=> '3',
				'2' 	=> '2',
			),
			"description" => __("How many products in a row.", 'minti-framework')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order by", 'minti-framework'),
			"param_name" => "orderby",
			"value" => $orderby,
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order", 'minti-framework'),
			"param_name" => "order",
			"value" => $order,
		),
	)
) );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Product
/*-----------------------------------------------------------------------------------*/
vc_map( array(
	"name" => __("Product", 'minti-framework'),
	"description" => __("Show a Single Product by ID", 'minti-framework'),
	"base" => "product",
	"show_settings_on_create" => true,
	"category" => __('WooCommerce', 'minti-framework'),
	"icon"          => "icon-wpb-minti-woocommerce",
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("ID", 'minti-framework'),
			"param_name" => "id",
			"admin_label" => true
		),
		array(
			"type" => "textfield",
			"heading" => __("SKU", 'minti-framework'),
			"param_name" => "sku",
			"admin_label" => true,
			"description" => __("Enter only one of these settings.", 'minti-framework')
		),
	)
) );
        
/*-----------------------------------------------------------------------------------*/
/* Map to VC - Products
/*-----------------------------------------------------------------------------------*/
vc_map( array(
	"name" => __("Products", 'minti-framework'),
	"description" => __("Show multiple Products by ID", 'minti-framework'),
	"base" => "products",
	"show_settings_on_create" => true,
	"category" => __('WooCommerce', 'minti-framework'),
	"icon"          => "icon-wpb-minti-woocommerce",
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("IDs", 'minti-framework'),
			"param_name" => "ids",
			"admin_label" => true
		),
		array(
			"type" => "textfield",
			"heading" => __("SKUs", 'minti-framework'),
			"param_name" => "skus",
			"description" => __("Enter only one of these settings. Separated by comma.", 'minti-framework'),
			"admin_label" => true
		),
		array(
			"type" => "dropdown",
			"heading" => __("Columns", 'minti-framework'),
			"param_name" => "columns",
			"value" => array(
				'4' 	=> '4',
				'3' 	=> '3',
				'2' 	=> '2',
			),
			"description" => __("How many products in a row.", 'minti-framework')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order by", 'minti-framework'),
			"param_name" => "orderby",
			"value" => $orderby,
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order", 'minti-framework'),
			"param_name" => "order",
			"value" => $order,
		),
	)
) );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Products
/*-----------------------------------------------------------------------------------*/
vc_map( array(
	"name" => __("Products by Attribute", 'minti-framework'),
	"description" => __("Products by Attribute", 'minti-framework'),
	"base" => "product_attribute",
	"show_settings_on_create" => true,
	"category" => __('WooCommerce', 'minti-framework'),
	"icon"          => "icon-wpb-minti-woocommerce",
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Attribute", 'minti-framework'),
			"param_name" => "attribute",
			"description" => __("e.g. color", 'minti-framework'),
			"admin_label" => true
		),
		array(
			"type" => "textfield",
			"heading" => __("Filter", 'minti-framework'),
			"param_name" => "filter",
			"description" => __("e.g. black", 'minti-framework'),
			"admin_label" => true
		),               
		array(
			"type" => "textfield",
			"heading" => __("Per page", 'minti-framework'),
			"param_name" => "per_page",
			"value" => "4",
			"description" => __("How many products you want to show on the page.", 'minti-framework')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Columns", 'minti-framework'),
			"param_name" => "columns",
			"value" => array(
				'4' 	=> '4',
				'3' 	=> '3',
				'2' 	=> '2',
			),
			"description" => __("How many products in a row.", 'minti-framework')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order by", 'minti-framework'),
			"param_name" => "orderby",
			"value" => $orderby
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order", 'minti-framework'),
			"param_name" => "order",
			"value" => $order,
		),
	)
) );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Add to Cart Button
/*-----------------------------------------------------------------------------------*/
vc_map( array(
	"name" => __("Add to Cart", 'minti-framework'),
	"description" => __("Add to cart Button of a Product", 'minti-framework'),
	"base" => "add_to_cart",
	"show_settings_on_create" => true,
	"category" => __('WooCommerce', 'minti-framework'),
	"icon"          => "icon-wpb-minti-woocommerce",
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("ID", 'minti-framework'),
			"param_name" => "id"
		),
		array(
			"type" => "textfield",
			"heading" => __("SKU", 'minti-framework'),
			"param_name" => "sku",
			"description" => __("Enter only one of these settings.", 'minti-framework')
		),
		array(
			"type" => "textfield",
			"heading" => __("Style", 'minti-framework'),
			"param_name" => "style",
			"description" => __("Use your own custom style if needed, e.g. border:4px solid #ccc; padding: 12px;", 'minti-framework'),
			"value"	=> ' '
		),
	)
) );

/*-----------------------------------------------------------------------------------*/
/* Map to VC - Product Page
/*-----------------------------------------------------------------------------------*/
vc_map( array(
	"name" => __("Product page", 'minti-framework'),
	"description" => __("Show a full Single Product", 'minti-framework'),
	"base" => "product_page",
	"show_settings_on_create" => true,
	"category" => __('WooCommerce', 'minti-framework'),
	"icon"          => "icon-wpb-minti-woocommerce",
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("ID", 'minti-framework'),
			"param_name" => "id"
		),
		array(
			"type" => "textfield",
			"heading" => __("SKU", 'minti-framework'),
			"param_name" => "sku",
			"description" => __("Enter only one of these settings.", 'minti-framework')
		),
	)
) );

?>
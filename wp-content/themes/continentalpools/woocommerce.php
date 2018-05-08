<?php get_header(); ?>

<div id="page-wrap" class="container">

	<?php
	// Single Products Page
	if(is_product()){
		// Get WooCommerce Single Product Layout from Theme Options
		if($minti_data['select_woocommercesidebar_single'] == 'sidebar-left')  {
			$wooclass_single = 'sidebar-left twelve alt columns';
		}
		elseif($minti_data['select_woocommercesidebar_single'] == 'sidebar-right')  {
			$wooclass_single = 'sidebar-right twelve alt columns';
		}
		else{
			$wooclass_single = 'no-sidebar sixteen columns';
		}
	?>
		
		<div id="content" class="<?php echo esc_attr($wooclass_single); ?> product-page">
			<?php woocommerce_content(); ?>
		</div> <!-- end content -->

		<?php if($minti_data['select_woocommercesidebar_single'] != 'no-sidebar')  { ?>
		<div id="sidebar" class="<?php echo esc_attr($minti_data['select_woocommercesidebar_single']); ?> alt">
			<div id="sidebar-widgets" class="four columns">
			<?php if(is_woocommerce()){
				/* WooCommerce Sidebar */
				if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Shop Widgets') );
			} ?>
			</div>
		</div>
		<?php } ?>


	<?php
	// Main Shop Layout
	} else{

		// Get WooCommerce Layout from Theme Options
		if($minti_data['select_woocommercesidebar'] == 'sidebar-left')  {
			$wooclass = 'sidebar-left twelve alt columns';
		}
		elseif($minti_data['select_woocommercesidebar'] == 'sidebar-right')  {
			$wooclass = 'sidebar-right twelve alt columns';
		}
		else{
			$wooclass = 'no-sidebar sixteen columns';
		}
	?>
		<div id="content" class="<?php echo esc_attr($wooclass); ?> <?php if(!is_product()){ echo esc_attr($minti_data['select_woocommercecolumns']); } ?>">
			<?php woocommerce_content(); ?>
		</div> <!-- end content -->

		<?php if($minti_data['select_woocommercesidebar'] != 'no-sidebar')  { ?>
		<div id="sidebar" class="<?php echo esc_attr($minti_data['select_woocommercesidebar']); ?> alt">
			<div id="sidebar-widgets" class="four columns">
			<?php if(is_woocommerce()){
				/* WooCommerce Sidebar */
				if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Shop Widgets') );
			} ?>
			</div>
		</div>
		<?php } ?>

	<?php } // end-if main shop layout ?>
	
</div> <!-- end page-wrap -->
	<?php dynamic_sidebar('footerwave'); ?>
<?php get_footer(); ?>
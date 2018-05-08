<?php
/* ------------------------------------------------------------------------ */
/* Add Admin CSS
/* ------------------------------------------------------------------------ */
function minti_demoimporter_css() {
	wp_enqueue_style( 'demoimporter-admin-css', get_template_directory_uri() . '/framework/inc/demoimporter/demoimporter.css' );
}
add_action( 'admin_enqueue_scripts', 'minti_demoimporter_css' );

/* ------------------------------------------------------------------------ */
/* Create new Admin Page
/* ------------------------------------------------------------------------ */
if (!function_exists('minti_add_demo_import_page')) {
	function minti_add_demo_import_page() {
		add_theme_page('Demo Import', 'Demo Import', 'manage_options', 'minti_demo_import','minti_demo_import');
	}
}
add_action('admin_menu', 'minti_add_demo_import_page');


if (!function_exists('minti_demo_import')) {
	function minti_demo_import() {
		?>
		<div class="wrap">
			<div class="demoimport-message content" style="display:none;">
				<img src="<?php echo get_template_directory_uri(); ?>/framework/inc/demoimporter/spinner.gif" alt="spinner">
				<h1 class="demoimport-message-title">Importing Demo Content...</h1>
				<p>Please be patient and <strong>do not navigate away</strong> from this page while the import is in progress. This may take up to several minutes (according to your server speed). You will get a notification on this page when the import is completed.</p>
			</div>

			<div class="demoimport-message success" style="display:none;">
				<h1 class="demoimport-message-title">Import completed successfully!</h1>
				<p>The Demo Import was successfully. View <a href="<?php echo site_url(); ?>" target="_blank">your page</a><br>or start to customize it with our <a href="<?php echo admin_url('themes.php?page=minti_options'); ?>">Theme Options Panel</a>.
			</div>

			<form class="demoimport-importer" action="?page=minti_demo_import" method="post">

				<div class="demoimport-importer-options">
					
					<h2>One-Click Installer</h2>
					<p>This is our famous One-Click Demo Importer. Select from the options below which type of data you want to import. The standard content gets always imported (including pages, images, navigation). <strong>If you want to import the demo content for plugins (WooCommerce, Contactform 7, bbPress, Revolution Slider), make sure to install them before running the Importer!</strong></p>

					<div class="demoimport-importer-option theme-options">
						<label class="demoimport-importer-option-check">
							<input id="theme_options" type="checkbox" value="ON" name="theme_options" checked="checked">
							<span class="demoimport-importer-option-title">Import Theme Options</span>
						</label>
					</div>
					<div class="demoimport-importer-option rev-slider">
						<label class="demoimport-importer-option-check">
							<input id="rev_slider" type="checkbox" value="ON" name="rev_slider"<?php if ( ! class_exists('RevSlider')) { echo ' disabled="disabled"'; }?>>
							<span class="demoimport-importer-option-title">Import Revolution Sliders</span>
						</label>
					</div>

					<?php if ( ! class_exists('RevSlider')) echo '<div class="demoimport-importer-note demoimport-importer-error"><p><strong>Revolution Slider</strong> plugin is not active. Please activate it if you want Sliders to be imported.</p></div>'; ?>

					<div class="demoimport-importer-note">
						<strong>Important Notes:</strong>
						<ol>
							<li>We recommend to run the Demo Import on a clean WordPress installation.</li>
							<li>To reset your installation (if the import fails) we recommend <a href="https://wordpress.org/plugins/wordpress-reset/" target="_blank">Wordpress Reset Plugin</a>.</li>
							<li>The Demo Import will not import the images we have used in our live demo, due to copyright / license reasons.</li>
							<li>Do not run the Demo Import multiple times, it will result in duplicated content.</li>
						</ol>
					</div>

					<input type="hidden" name="action" value="perform_import">
					<input class="button-primary size_big" type="submit" value="Import" id="import_demo_data">

				</div>

			</form>
		</div>
		<script>
			jQuery(document).ready(function() {
				var import_running = false;
				jQuery('#import_demo_data').click(function() {
					if ( !import_running) {
						import_running = true;
						jQuery("html, body").animate({ scrollTop: 0 }, { duration: 300 });
						jQuery('.demoimport-importer').slideUp(null, function(){
							jQuery('.demoimport-message.content').slideDown();
						});

						// Importing Content
						jQuery.ajax({
							type: 'POST',
							url: '<?php echo admin_url('admin-ajax.php'); ?>',
							data: {
								action: 'minti_demo_import_content'
							},
							success: function(data, textStatus, XMLHttpRequest){

								if (jQuery('#theme_options').is(':checked')) {
									// Importing Options after Content
									jQuery('.demoimport-message.options').slideDown();
									jQuery.ajax({
										type: 'POST',
										url: '<?php echo admin_url('admin-ajax.php'); ?>',
										data: {
											action: 'minti_demo_import_options'
										},
										success: function(data, textStatus, XMLHttpRequest){
											if (jQuery('#rev_slider').is(':checked')) {
												// Importing Slider after Options and Content
												jQuery('.demoimport-message.sliders').slideDown();
												jQuery.ajax({
													type: 'POST',
													url: '<?php echo admin_url('admin-ajax.php'); ?>',
													data: {
														action: 'minti_demo_import_sliders'
													},
													success: function(data, textStatus, XMLHttpRequest){
														jQuery('.demoimport-message.content').slideUp();
														jQuery('.demoimport-message.options').slideUp();
														jQuery('.demoimport-message.sliders').slideUp();
														jQuery('.demoimport-message.success').slideDown();
														import_running = false;
													},
													error: function(MLHttpRequest, textStatus, errorThrown){

													}
												});

											} else {
												jQuery('.demoimport-message.content').slideUp();
												jQuery('.demoimport-message.options').slideUp();
												jQuery('.demoimport-message.success').slideDown();
												import_running = false;
											}
										},
										error: function(MLHttpRequest, textStatus, errorThrown){

										}
									});

								} else {
									if (jQuery('#rev_slider').is(':checked')) {
										// Importing Slider after Content
										jQuery('.demoimport-message.sliders').slideDown();
										jQuery.ajax({
											type: 'POST',
											url: '<?php echo admin_url('admin-ajax.php'); ?>',
											data: {
												action: 'minti_demo_import_sliders'
											},
											success: function(data, textStatus, XMLHttpRequest){
												jQuery('.demoimport-message.content').slideUp();
												jQuery('.demoimport-message.sliders').slideUp();
												jQuery('.demoimport-message.success').slideDown();
												import_running = false;
											},
											error: function(MLHttpRequest, textStatus, errorThrown){

											}
										});

									} else {
										jQuery('.demoimport-message.content').slideUp();
										jQuery('.demoimport-message.success').slideDown();
										import_running = false;
									}
								}

							},
							error: function(MLHttpRequest, textStatus, errorThrown){

							}
						});
					}

					return false;
				});
			});
		</script>
		<?php
	}

/* ------------------------------------------------------------------------ */
/* Import content.xml File with WordPress Importer
/* ------------------------------------------------------------------------ */
	function minti_demo_import_content() {
		set_time_limit(0);

		if (!defined('WP_LOAD_IMPORTERS')) define('WP_LOAD_IMPORTERS', true);

		require_once(get_template_directory().'/framework/inc/demoimporter/wordpress-importer/wordpress-importer.php');

		$wp_import = new WP_Import();
		$wp_import->fetch_attachments = true;

		ob_start();
		$wp_import->import(get_template_directory().'/framework/inc/demoimporter/demo-files/content.xml');
		ob_end_clean();

		// Set Menu Locations
		$locations = get_theme_mod('nav_menu_locations');
		$menus  = wp_get_nav_menus();

		if(!empty($menus)) {
			foreach($menus as $menu) {
				if(is_object($menu) && $menu->name == 'Mega Menu') {
					$locations['main_navigation'] = $menu->term_id;
				}
			}
		}
		set_theme_mod('nav_menu_locations', $locations);

		// Set Front Page
		$front_page = get_page_by_title('Home: Classic');

		if(isset($front_page->ID)) {
			update_option('show_on_front', 'page');
			update_option('page_on_front',  $front_page->ID);
		}

		echo 'ok';
		die();

	}
	add_action('wp_ajax_minti_demo_import_content', 'minti_demo_import_content');

/* ------------------------------------------------------------------------ */
/* Import Theme Options
/* ------------------------------------------------------------------------ */
	function minti_demo_import_options() {

		$file = get_template_directory().'/framework/inc/demoimporter/demo-files/themeoptions.json';
		$file_contents = file_get_contents( $file ); // ignore theme check
		$options = json_decode($file_contents, true);
		$redux = ReduxFrameworkInstances::get_instance('minti_data');
		$redux->set_options($options);

		echo 'ok';
		die();

	}
	add_action('wp_ajax_minti_demo_import_options', 'minti_demo_import_options');

/* ------------------------------------------------------------------------ */
/* Import Revolution Slider
/* ------------------------------------------------------------------------ */
	function minti_demo_import_sliders() {

		if (!class_exists('RevSlider')) { return false; }

		ob_start();
		
		// Import Slider
		$_FILES["import_file"]["tmp_name"] = get_template_directory().'/framework/inc/demoimporter/demo-files/default.zip';
		$slider = new RevSlider();
		$response = $slider->importSliderFromPost();
		unset($slider);

		// Import Slider
		$_FILES["import_file"]["tmp_name"] = get_template_directory().'/framework/inc/demoimporter/demo-files/fullscreen.zip';
		$slider = new RevSlider();
		$response = $slider->importSliderFromPost();
		unset($slider);

		// Import Slider
		$_FILES["import_file"]["tmp_name"] = get_template_directory().'/framework/inc/demoimporter/demo-files/home.zip';
		$slider = new RevSlider();
		$response = $slider->importSliderFromPost();
		unset($slider);

		// Import Slider
		$_FILES["import_file"]["tmp_name"] = get_template_directory().'/framework/inc/demoimporter/demo-files/portfolio.zip';
		$slider = new RevSlider();
		$response = $slider->importSliderFromPost();
		unset($slider);

		// Import Slider
		$_FILES["import_file"]["tmp_name"] = get_template_directory().'/framework/inc/demoimporter/demo-files/shop.zip';
		$slider = new RevSlider();
		$response = $slider->importSliderFromPost();
		unset($slider);

		// Import Slider
		$_FILES["import_file"]["tmp_name"] = get_template_directory().'/framework/inc/demoimporter/demo-files/slideronly.zip';
		$slider = new RevSlider();
		$response = $slider->importSliderFromPost();
		unset($slider);

		// Import Slider
		$_FILES["import_file"]["tmp_name"] = get_template_directory().'/framework/inc/demoimporter/demo-files/small.zip';
		$slider = new RevSlider();
		$response = $slider->importSliderFromPost();
		unset($slider);

		// Import Slider
		$_FILES["import_file"]["tmp_name"] = get_template_directory().'/framework/inc/demoimporter/demo-files/somethingbig.zip';
		$slider = new RevSlider();
		$response = $slider->importSliderFromPost();
		unset($slider);

		// Import Slider
		$_FILES["import_file"]["tmp_name"] = get_template_directory().'/framework/inc/demoimporter/demo-files/modernshop.zip';
		$slider = new RevSlider();
		$response = $slider->importSliderFromPost();
		unset($slider);

		// Import Slider
		$_FILES["import_file"]["tmp_name"] = get_template_directory().'/framework/inc/demoimporter/demo-files/videoslide.zip';
		$slider = new RevSlider();
		$response = $slider->importSliderFromPost();
		unset($slider);
		
		ob_end_clean();

		echo 'ok';
		die();

	}
	add_action('wp_ajax_minti_demo_import_sliders', 'minti_demo_import_sliders');

}
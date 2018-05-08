<?php
/*
Plugin Name: Jumbo, by Bonfire 
Plugin URI: http://bonfirethemes.com/
Description: A 3-in-1 menu plugin for WordPress. Customize under Settings > Jumbo plugin. Customize colors and logo under Appearance > Customize.
Version: 2.0
Author: Bonfire Themes
Author URI: http://bonfirethemes.com/
License: GPL2
*/

	//
	// CREATE THE SETTINGS PAGE (for WordPress backend, Settings > Jumbo plugin)
	//
	
	/* create "Settings" link on plugins page */
	function bonfire_jumbo_settings_link($links) { 
		$settings_link = '<a href="options-general.php?page=jumbo-by-bonfire/jumbo.php">Settings</a>'; 
		array_unshift($links, $settings_link); 
		return $links; 
	}
	$plugin = plugin_basename(__FILE__); 
	add_filter("plugin_action_links_$plugin", 'bonfire_jumbo_settings_link' );

	/* create the "Settings > jumbo plugin" menu item */
	function bonfire_jumbo_admin_menu() {
		add_submenu_page('options-general.php', 'Jumbo Plugin Settings', 'Jumbo plugin', 'administrator', __FILE__, 'bonfire_jumbo_page');
	}
	
	/* create the actual settings page */
	function bonfire_jumbo_page() {
		if ( isset ($_POST['update_bonfire_jumbo']) == 'true' ) { bonfire_jumbo_update(); }
	?>

		<div class="wrap">
			<h2>Jumbo, by Bonfire</h2>
			<strong>Psst!</strong> Jumbo's color options can be changed under <strong>Appearance > Customize > Jumbo plugin colors</strong>.<br>
			Logo can be added under <strong>Appearance > Customize > Jumbo plugin logo</strong>

			<br>
			<br>
			<br>
			<strong>Jump to:</strong>
			<a href="#placement">Menu buttons placement options</a> | 
			<a href="#main-menu">Main menu options</a> | 
			<a href="#secondary-menu">Secondary menu options</a> | 
			<a href="#gravatar">Gravatar options</a>

			<form method="POST" action="">
				<input type="hidden" name="update_bonfire_jumbo" value="true" />

				<br><hr><br>

				<!-- BEGIN POSITIONING -->
				<div id="placement"></div>
				<br>
				<br>
				<h2>Menu buttons placement options</h2>
				<table class="form-table">
					<!-- BEGIN POSITION ABSOLUTE -->
					<tr valign="top">
					<th scope="row">Absolute positioning:</th>
					<td><label><input type="checkbox" name="jumbo_position_absolute" id="jumbo_position_absolute" <?php echo get_option('jumbo_absolute_positioning'); ?> /> Position absolute (if unchecked, menu buttons will stick to the top).</label></td>
					</tr>
					<!-- END POSITION ABSOLUTE -->
					
					<!-- BEGIN LEFT/RIGHT POSITION -->
					<tr valign="top">
					<th scope="row">Left/right positioning:</th>
					<td><label><input type="checkbox" name="jumbo_position_left_right" id="jumbo_position_left_right" <?php echo get_option('bonfire_jumbo_position_left_right'); ?> /> Position right (if unchecked, menu buttons will stick to the left).</label></td>
					</tr>
					<!-- END LEFT/RIGHT POSITION -->
					
					<!-- BEGIN MARGINS -->
					<tr valign="top">
					<th scope="row">Top/side positioning:</th>
					<td>
					Top: <input style="width:50px;" type="text" name="jumbo_position_top" id="jumbo_position_top" value="<?php echo get_option('jumbo_top_position'); ?>"/> pixels (if empty, will default to 0 pixels).<br>
					Side: <input style="width:50px;" type="text" name="jumbo_position_left" id="jumbo_position_left" value="<?php echo get_option('jumbo_left_position'); ?>"/> pixels (if empty, will default to 0 pixels).
					</td>
					</tr>
					<!-- END MARGINS -->
					
					<!-- BEGIN SHOW ONLY TO LOGGED IN USERS -->
					<tr valign="top">
					<th scope="row">Logged in only?:</th>
					<td><label><input type="checkbox" name="jumbo_logged_in" id="jumbo_logged_in" <?php echo get_option('bonfire_jumbo_logged_in'); ?> /> Show menu only if user is logged in (if unchecked, Jumbo will be visible to all visitors).</label></td>
					</tr>
					<!-- END SHOW ONLY TO LOGGED IN USERS -->
					
					<!-- BEGIN HIDE BETWEEN RESOLUTIONS -->
					<tr valign="top">
					<th scope="row">Hide at certain width/resolution:</th>
					<td>
					Hide Jumbo if browser width or screen resolution is between <input style="width:50px;" type="text" name="jumbo_smaller_than" id="jumbo_smaller_than" value="<?php echo get_option('bonfire_jumbo_smaller_than'); ?>"/> and <input style="width:50px;" type="text" name="jumbo_larger_than" id="jumbo_larger_than" value="<?php echo get_option('bonfire_jumbo_larger_than'); ?>"/> pixels (fill both fields). Example: if you'd like to hide Jumbo on smartphones, then enter the values as 0 and 500. If fields are empty, Jumbo will be visible at all browser widths and resolutions.
					</td>
					</tr>
					<!-- END HIDE BETWEEN RESOLUTIONS -->
				</table>
	 			<!-- END POSITIONING -->

				<br><hr><br>

				<!-- BEGIN MAIN MENU OPTIONS -->
				<div id="main-menu"></div>
				<br>
				<br>
				<h2>Main menu options</h2>
				<table class="form-table">
					<!-- BEGIN HIDE MAIN MENU BUTTON -->
					<tr valign="top">
					<th scope="row">Hide main menu button:</th>
					<td><label><input type="checkbox" name="jumbo_main_menu_button_hide" id="jumbo_main_menu_button_hide" <?php echo get_option('bonfire_jumbo_main_menu_button_hide'); ?> /> Hide main menu button (slightly advanced feature). Useful if you'd like to use your own element to activate the full-screen menu, in which case give said element the "jumbo-custom-activator" class.</label></td>
					</tr>
					<!-- END HIDE MAIN MENU BUTTON -->

					<!-- BEGIN ALTERNATE MENU BUTTON -->
					<tr valign="top">
					<th scope="row">Alternate menu button:</th>
					<td><label><input type="checkbox" name="jumbo_main_menu_button_alt" id="jumbo_main_menu_button_alt" <?php echo get_option('bonfire_jumbo_main_menu_button_alt'); ?> /> When menu is opened, animate menu button to minus symbol (if left unchecked, menu button will animate to X symbol).</label></td>
					</tr>
					<!-- END ALTERNATE MENU BUTTON -->
					
					<!-- BEGIN MAIN MENU OPEN ON FRONT PAGE -->
					<tr valign="top">
					<th scope="row">Open on front page?:</th>
					<td><label><input type="checkbox" name="jumbo_main_menu_open" id="jumbo_main_menu_open" <?php echo get_option('jumbo_main_menu_open_front'); ?> /> Make main menu open on front page.</label></td>
					</tr>
					<!-- END MAIN MENU OPEN ON FRONT PAGE -->
					
					<!-- BEGIN CLOSE ON CLICK -->
					<tr valign="top">
					<th scope="row">Close main menu after click?:</th>
					<td>
					<label><input type="checkbox" name="jumbo_close_on_click" id="jumbo_close_on_click" <?php echo get_option('bonfire_jumbo_close_on_click'); ?> /> Close main menu when menu item is clicked/tapped (useful on one-page websites where menu links lead to anchors, not new pages).</label>
					</td>
					</tr>
					<!-- END CLOSE ON CLICK -->
					
					<!-- BEGIN HIDE MAIN MENU BACKGROUND COLOR -->
					<tr valign="top">
					<th scope="row">Hide button background color?:</th>
					<td><label><input type="checkbox" name="jumbo_main_menu_transparent" id="jumbo_main_menu_transparent" <?php echo get_option('bonfire_jumbo_main_menu_transparent'); ?> /> Tick to make the main menu button background transparent.</label></td>
					</tr>
					<!-- END HIDE MAIN MENU BACKGROUND COLOR -->

					<!-- BEGIN SLIDE-IN DIRECTION -->
					<tr valign="top">
					<th scope="row">Main menu appearance:</th>
					<td>
					<?php $jumbo_slidein_direction = get_option('bonfire_jumbo_slidein_direction'); ?>
					<label><input value="jumboslideintop" type="radio" name="jumbo_slidein_direction" <?php if ($jumbo_slidein_direction=='jumboslideintop') { echo 'checked'; } ?>> Slide in/out from the top</label><br>
					<label><input value="jumboslideinleft" type="radio" name="jumbo_slidein_direction" <?php if ($jumbo_slidein_direction=='jumboslideinleft') { echo 'checked'; } ?>> Slide in/out from the left</label><br>
					<label><input value="jumboslideinright" type="radio" name="jumbo_slidein_direction" <?php if ($jumbo_slidein_direction=='jumboslideinright') { echo 'checked'; } ?>> Slide in/out from the right</label><br>
					<label><input value="jumboslideinbottom" type="radio" name="jumbo_slidein_direction" <?php if ($jumbo_slidein_direction=='jumboslideinbottom') { echo 'checked'; } ?>> Slide in/out from the bottom</label><br>
					<label><input value="jumboslideinfade" type="radio" name="jumbo_slidein_direction" <?php if ($jumbo_slidein_direction=='jumboslideinfade') { echo 'checked'; } ?>> Fade in/out</label><br>
					</td>
					</tr>
					<!-- END SLIDE-IN DIRECTION -->

					<!-- BEGIN MAIN MENU CAPS (SMALL TEXT) -->
					<tr valign="top">
					<th scope="row">Main menu small text (description):</th>
					<td><label><input type="checkbox" name="jumbo_main_menu_desc_uppercase" id="jumbo_main_menu_desc_uppercase" <?php echo get_option('jumbo_uppercase_main_menu_description'); ?> /> Make small main menu items (descriptions) all uppercase.</label></td>
					</tr>
					<!-- END MAIN MENU CAPS (SMALL TEXT) -->
					
					<!-- BEGIN MAIN MENU CAPS (BIG TEXT) -->
					<tr valign="top">
					<th scope="row">Main menu big text:</th>
					<td><label><input type="checkbox" name="jumbo_main_menu_uppercase" id="jumbo_main_menu_uppercase" <?php echo get_option('jumbo_uppercase_main_menu'); ?> /> Make big main menu items all uppercase.</label></td>
					</tr>
					<!-- END MAIN MENU CAPS (BIG TEXT) -->
				
					<!-- BEGIN MAIN MENU HORIZONTAL ALIGN -->
					<tr valign="top">
					<th scope="row">Main menu horizontal align</th>
					<td>
					<?php $jumbo_main_menu_horizontal_align = get_option('bonfire_jumbo_main_menu_horizontal_align'); ?>
					<label><input value="jumboalignleft" type="radio" name="jumbo_main_menu_horizontal_align" <?php if ($jumbo_main_menu_horizontal_align=='jumboalignleft') { echo 'checked'; } ?>> Left</label><br>
					<label><input value="jumboaligncenter" type="radio" name="jumbo_main_menu_horizontal_align" <?php if ($jumbo_main_menu_horizontal_align=='jumboaligncenter') { echo 'checked'; } ?>> Center</label><br>
					<label><input value="jumboalignright" type="radio" name="jumbo_main_menu_horizontal_align" <?php if ($jumbo_main_menu_horizontal_align=='jumboalignright') { echo 'checked'; } ?>> Right</label><br>
					</td>
					</tr>
					<!-- END MAIN MENU HORIZONTAL ALIGN -->
					
					<!-- BEGIN MAIN MENU VERTICAL ALIGN -->
					<tr valign="top">
					<th scope="row">Main menu vertical align</th>
					<td>
					<?php $jumbo_main_menu_vertical_align = get_option('bonfire_jumbo_main_menu_vertical_align'); ?>
					<label><input value="jumboaligntop" type="radio" name="jumbo_main_menu_vertical_align" <?php if ($jumbo_main_menu_vertical_align=='jumboaligntop') { echo 'checked'; } ?>> Top</label><br>
					<label><input value="jumboalignmiddle" type="radio" name="jumbo_main_menu_vertical_align" <?php if ($jumbo_main_menu_vertical_align=='jumboalignmiddle') { echo 'checked'; } ?>> Middle</label><br>
					<label><input value="jumboalignbottom" type="radio" name="jumbo_main_menu_vertical_align" <?php if ($jumbo_main_menu_vertical_align=='jumboalignbottom') { echo 'checked'; } ?>> Bottom</label><br>
					</td>
					</tr>
					<!-- END MAIN MENU VERTICAL ALIGN -->
					
					<!-- BEGIN MAIN MENU TOP MARGIN -->
					<tr valign="top">
					<th scope="row">Main menu top margin</th>
					<td>
					<input style="width:50px;" type="text" name="bonfire_jumbo_main_menu_margin" id="bonfire_jumbo_main_menu_margin" value="<?php echo get_option('bonfire_jumbo_main_menu_top_margin'); ?>"/> pixels
					<br> If your main menu has a lot of menu items, you may want to give it some top margin so it wouldn't stick too close to the top (potentially hiding partially behind the menu buttons). If you're not sure what to enter, try out 100 pixels to begin with and then adjust according to your needs.
					</td>
					</tr>
					<!-- END MAIN MENU TOP MARGIN -->
					
					<!-- BEGIN MAIN MENU ITEM OPACITY -->
					<tr valign="top">
					<th scope="row">Main menu item opacity</th>
					<td>
					<input style="width:50px;" type="text" name="bonfire_jumbo_main_menu_opacity" id="bonfire_jumbo_main_menu_opacity" value="<?php echo get_option('bonfire_jumbo_main_menu_text_opacity'); ?>"/>
					<br> From 0-1. Example: 0.25 or 0.5.
					<br> If left empty, defaults to 0.25.
					</td>
					</tr>
					<!-- END MAIN MENU ITEM OPACITY -->
					
					<!-- BEGIN MAIN MENU DESCRIPTION OPACITY -->
					<tr valign="top">
					<th scope="row">Main menu description opacity</th>
					<td>
					<input style="width:50px;" type="text" name="bonfire_jumbo_main_desc_opacity" id="bonfire_jumbo_main_desc_opacity" value="<?php echo get_option('bonfire_jumbo_main_menu_desc_opacity'); ?>"/>
					<br> From 0-1. Example: 0.25 or 0.5.
					<br> If left empty, defaults to 0.35.
					</td>
					</tr>
					<!-- END MAIN MENU DESCRIPTION OPACITY -->
					
					<!-- BEGIN BACKGROUND IMAGE -->
					<tr valign="top">
					<th scope="row">Main menu background image URL</th>
					<td>
					<input type="text" name="bonfire_jumbo_background" id="bonfire_jumbo_background" value="<?php echo get_option('bonfire_jumbo_background_image'); ?>"/>
					<br> To give the full-screen menu a background image, enter its URL in the field above.
					</td>
					</tr>
					<!-- END BACKGROUND IMAGE -->
					
					<!-- BEGIN BACKGROUND IMAGE OPACITY -->
					<tr valign="top">
					<th scope="row">Main menu background image opacity</th>
					<td>
					<input style="width:50px;" type="text" name="bonfire_jumbo_background_opacity" id="bonfire_jumbo_background_opacity" value="<?php echo get_option('bonfire_jumbo_background_image_opacity'); ?>"/>
					<br> From 0-1. Example: 0.25 or 0.5.
					<br> If left empty, defaults to 0.3.
					</td>
					</tr>
					<!-- END BACKGROUND IMAGE OPACITY -->
					
					<!-- BEGIN DOT OVERLAY OPACITY -->
					<tr valign="top">
					<th scope="row">Main menu dot overlay opacity</th>
					<td>
					<input style="width:50px;" type="text" name="bonfire_jumbo_dot_overlay" id="bonfire_jumbo_dot_overlay" value="<?php echo get_option('bonfire_jumbo_dot_overlay_opacity'); ?>"/>
					<br> From 0-1. Example: 0.4 or 0.75.
					<br> If left empty, defaults to 0.25.
					</td>
					</tr>
					<!-- END DOT OVERLAY OPACITY -->
					
					<!-- BEGIN BACKGROUND COLOR OPACITY -->
					<tr valign="top">
					<th scope="row">Main menu background color opacity</th>
					<td>
					<input style="width:50px;" type="text" name="bonfire_jumbo_bg_color_opacity" id="bonfire_jumbo_bg_color_opacity" value="<?php echo get_option('bonfire_jumbo_background_color_opacity'); ?>"/>
					<br> From 0-1. Example: 0.25 or 0.5.
					<br> If left empty, defaults to 0.3.
					</td>
					</tr>
					<!-- END BACKGROUND COLOR OPACITY -->
					
					<!-- BEGIN MAIN MENU APPEARACE SPEED -->
					<tr valign="top">
					<th scope="row">Main menu appearance speed</th>
					<td>
					<input style="width:50px;" type="text" name="bonfire_jumbo_main_menu_appearance" id="bonfire_jumbo_main_menu_appearance" value="<?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>"/> seconds
					<br> Example: 0.5 or 1.25.
					<br> If left empty, defaults to 0.3.
					</td>
					</tr>
					<!-- BEGIN MAIN MENU APPEARACE SPEED -->
					
					<!-- BEGIN MAIN MENU FONT -->
					<tr valign="top">
					<th scope="row">Main menu font:</th>
					<td>
					<strong>Advanced font feature:</strong><br>
					<input style="width:100%;height:35px;" type="text" name="jumbo_main_menu_theme_font" id="jumbo_main_menu_theme_font" value="<?php echo stripslashes(get_option('bonfire_jumbo_main_menu_theme_font')); ?>"/> If you know the name of and would like to use one of your theme's fonts, enter it in the textfield above as it appears in the theme's stylesheet (Jumbo's default font will be automatically overriden)
					</td>
					</tr>
					<!-- END MAIN MENU FONT -->
					
					<!-- BEGIN MAIN MENU DESCRIPTION FONT -->
					<tr valign="top">
					<th scope="row">Main menu description font:</th>
					<td>
					<strong>Advanced font feature:</strong><br>
					<input style="width:100%;height:35px;" type="text" name="jumbo_main_menu_description_theme_font" id="jumbo_main_menu_description_theme_font" value="<?php echo stripslashes(get_option('bonfire_jumbo_main_menu_description_theme_font')); ?>"/> If you know the name of and would like to use one of your theme's fonts, enter it in the textfield above as it appears in the theme's stylesheet (Jumbo's default font will be automatically overriden)
					</td>
					</tr>
					<!-- END MAIN MENU DESCRIPTION FONT -->
				</table>
				<!-- END MAIN MENU OPTIONS -->
				
				<br><hr><br>

				<!-- BEGIN SECONDARY MENU OPTIONS -->
				<div id="secondary-menu"></div>
				<br>
				<br>
				<h2>Secondary menu options</h2>
				<table class="form-table">
					<!-- BEGIN HIDE SECONDARY MENU BACKGROUND COLOR -->
					<tr valign="top">
					<th scope="row">Hide button background color?:</th>
					<td><label><input type="checkbox" name="jumbo_secondary_menu_transparent" id="jumbo_secondary_menu_transparent" <?php echo get_option('bonfire_jumbo_secondary_menu_transparent'); ?> /> Tick to make the secondary menu background transparent.</label></td>
					</tr>
					<!-- END HIDE SECONDARY MENU BACKGROUND COLOR -->

					<!-- BEGIN SECONDARY MENU CAPS -->
					<tr valign="top">
					<th scope="row">Secondary menu uppercase (top-level menus):</th>
					<td><label><input type="checkbox" name="jumbo_secondary_menu_uppercase" id="jumbo_secondary_menu_uppercase" <?php echo get_option('jumbo_uppercase_secondary_menu'); ?> /> Make secondary menu's top-level items all uppercase.</label></td>
					</tr>
					
					<tr valign="top">
					<th scope="row">Secondary menu uppercase (sub-menus):</th>
					<td><label><input type="checkbox" name="jumbo_secondary_sub_menu_uppercase" id="jumbo_secondary_sub_menu_uppercase" <?php echo get_option('jumbo_uppercase_secondary_sub_menu'); ?> /> Make secondary menu's sub-menu items all uppercase.</label></td>
					</tr>
					<!-- END SECONDARY MENU CAPS -->
				
					<!-- BEGIN SECONDARY MENU WIDTH -->
					<tr valign="top">
					<th scope="row">Secondary menu width:</th>
					<td>
					<input type="text" style="width:50px;" name="bonfire_jumbo_accordion_width" id="bonfire_jumbo_accordion_width" value="<?php echo get_option('bonfire_jumbo_accordion_menu_width'); ?>"/> pixels
					<p style="margin-left:5px;">If you want or need to make the sub-menu wider, enter the value into the field above (if left empty, will default to 180 pixels)</p>
					</td>
					</tr>
		 			<!-- END SECONDARY MENU WIDTH -->
				
					<!-- BEGIN HIDE SECONDARY MENU -->
					<tr valign="top">
					<th scope="row">Secondary menu (drop-down) hide:</th>
					<td><label><input type="checkbox" name="jumbo_secondary_menu_hide" id="jumbo_secondary_menu_hide" <?php echo get_option('jumbo_hide_secondary_menu'); ?> /> Hide secondary menu.</label></td>
					</tr>
					<!-- END HIDE SECONDARY MENU -->
					
					<!-- BEGIN SECONDARY MENU FONT -->
					<tr valign="top">
					<th scope="row">Secondary menu font:</th>
					<td>
					<strong>Advanced font feature:</strong><br>
					<input style="width:100%;height:35px;" type="text" name="jumbo_secondary_menu_theme_font" id="jumbo_secondary_menu_theme_font" value="<?php echo stripslashes(get_option('bonfire_jumbo_secondary_menu_theme_font')); ?>"/> If you know the name of and would like to use one of your theme's fonts, enter it in the textfield above as it appears in the theme's stylesheet (Jumbo's default font will be automatically overriden)
					</td>
					</tr>
					<!-- END SECONDARY MENU FONT -->
				</table>
				<!-- END SECONDARY MENU OPTIONS -->
				
				<br><hr><br>

				<!-- BEGIN AUTHOR DETAILS -->
				<div id="gravatar"></div>
				<br>
				<br>
				<h2>Gravatar options</h2>
				<table class="form-table">
					<!-- BEGIN USER GRAVATAR EMAIL -->
					<tr valign="top">
					<th scope="row">Enter your Gravatar email address:</th>
					<td>
					<input type="text" name="bonfire_jumbo_gravatar_email" id="bonfire_jumbo_gravatar_email" value="<?php echo get_option('bonfire_jumbo_gravatar_emailaddress'); ?>"/>
					<p style="margin-left:5px;">To show your gravatar next to the menu button, enter your gravatar email in the field above. If no email is entered, no icon will be shown.</p>
					</td>
					</tr>
					<!-- END USER GRAVATAR EMAIL -->
					
					<!-- BEGIN CUSTOM PROFILE IMAGE -->
					<tr valign="top">
					<th scope="row">Custom profile image:</th>
					<td>
					<input type="text" name="bonfire_jumbo_custom_profile" id="bonfire_jumbo_custom_profile" value="<?php echo get_option('bonfire_jumbo_custom_profile_image'); ?>"/>
					<br> To use a custom profile image, enter its URL in the field above (overrides Gravatar). To avoid distortion, use a square image.
					</td>
					</tr>
					<!-- END CUSTOM PROFILE IMAGE -->
					
					<!-- BEGIN LINK TO CUSTOM PROFILE PAGE -->
					<tr valign="top">
					<th scope="row">Link to custom profile page:</th>
					<td>
					<input type="text" name="bonfire_jumbo_authorpage" id="bonfire_jumbo_authorpage" value="<?php echo get_option('bonfire_jumbo_authorpage_link'); ?>"/>
					<p style="margin-left:5px;">Enter the URL the user will be directed to when the Gravatar is clicked/tapped.</p>
					</td>
					</tr>
					<!-- END LINK TO CUSTOM PROFILE PAGE -->
					
					<!-- BEGIN HIDE GRAVATAR TOOLTIP -->
					<tr valign="top">
					<th scope="row">Gravatar tooltip:</th>
					<td><label><input type="checkbox" name="jumbo_gravatar_tooltip" id="jumbo_gravatar_tooltip" <?php echo get_option('jumbo_hide_gravatar_tooltip'); ?> /> Hide Gravatar hover tooltip.</label></td>
					</tr>
					<!-- END HIDE GRAVATAR TOOLTIP -->
					
					<!-- BEGIN DISABLE GRAVATAR HOVER -->
					<tr valign="top">
					<th scope="row">Gravatar hover:</th>
					<td><label><input type="checkbox" name="jumbo_gravatar_hover" id="jumbo_gravatar_hover" <?php echo get_option('jumbo_disable_gravatar_hover'); ?> /> Disable Gravatar hover effect.</label></td>
					</tr>
					<!-- END DISABLE GRAVATAR HOVER -->
					
					<!-- BEGIN GRAVATAR TOOLTIP FONT -->
					<tr valign="top">
					<th scope="row">Gravatar tooltip font:</th>
					<td>
					<strong>Advanced font feature:</strong><br>
					<input style="width:100%;height:35px;" type="text" name="jumbo_gravatar_tooltip_theme_font" id="jumbo_gravatar_tooltip_theme_font" value="<?php echo stripslashes(get_option('bonfire_jumbo_gravatar_tooltip_theme_font')); ?>"/> If you know the name of and would like to use one of your theme's fonts, enter it in the textfield above as it appears in the theme's stylesheet (Jumbo's default font will be automatically overriden)
					</td>
					</tr>
					<!-- END GRAVATAR TOOLTIP FONT -->
				</table>
				<!-- END AUTHOR DETAILS -->
				
				<br><hr><br>

				<!-- BEGIN 'SAVE OPTIONS' BUTTON -->	
				<p><input type="submit" name="search" value="Save Options" class="button button-primary" /></p>
				<!-- BEGIN 'SAVE OPTIONS' BUTTON -->	

			</form>

		</div>
	<?php }
	function bonfire_jumbo_update() {

		/* position checkbox */
		if ( isset ($_POST['jumbo_position_absolute'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('jumbo_absolute_positioning', $display);
		
		/* position checkbox */
		if ( isset ($_POST['jumbo_position_left_right'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('bonfire_jumbo_position_left_right', $display);

		/* top/side positioning */
		update_option('jumbo_top_position',   $_POST['jumbo_position_top']);
		update_option('jumbo_left_position',   $_POST['jumbo_position_left']);

		/* logged in only */
		if ( isset ($_POST['jumbo_logged_in'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('bonfire_jumbo_logged_in', $display);

		/* larger than, lower than */
		update_option('bonfire_jumbo_larger_than',   $_POST['jumbo_larger_than']);
		update_option('bonfire_jumbo_smaller_than',   $_POST['jumbo_smaller_than']);

		/* main menu alignment */
		if ( isset ($_POST['jumbo_main_menu_horizontal_align']) == 'true' ) {
			update_option('bonfire_jumbo_main_menu_horizontal_align', $_POST['jumbo_main_menu_horizontal_align']);
		}		
		if ( isset ($_POST['jumbo_main_menu_vertical_align']) == 'true' ) {
			update_option('bonfire_jumbo_main_menu_vertical_align', $_POST['jumbo_main_menu_vertical_align']);
		}

		/* hide main menu button */
		if ( isset ($_POST['jumbo_main_menu_button_hide'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('bonfire_jumbo_main_menu_button_hide', $display);

		/* menu button style */
		if ( isset ($_POST['jumbo_main_menu_button_alt'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('bonfire_jumbo_main_menu_button_alt', $display);

		/* main menu */
		if ( isset ($_POST['jumbo_main_menu_open'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('jumbo_main_menu_open_front', $display);
		
		/* close on click */
		if ( isset ($_POST['jumbo_close_on_click'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('bonfire_jumbo_close_on_click', $display);
		
		/* main menu button transparent background */
		if ( isset ($_POST['jumbo_main_menu_transparent'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('bonfire_jumbo_main_menu_transparent', $display);
		
		/* main menu appearance */
		if ( isset ($_POST['jumbo_slidein_direction']) == 'true' ) {
			update_option('bonfire_jumbo_slidein_direction', $_POST['jumbo_slidein_direction']);
		}
		
		if ( isset ($_POST['jumbo_main_menu_desc_uppercase'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('jumbo_uppercase_main_menu_description', $display);
		
		if ( isset ($_POST['jumbo_main_menu_uppercase'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('jumbo_uppercase_main_menu', $display);
		
		update_option('bonfire_jumbo_main_menu_text_opacity',   $_POST['bonfire_jumbo_main_menu_opacity']);
		update_option('bonfire_jumbo_main_menu_desc_opacity',   $_POST['bonfire_jumbo_main_desc_opacity']);
		update_option('bonfire_jumbo_main_menu_top_margin',   $_POST['bonfire_jumbo_main_menu_margin']);
		update_option('bonfire_jumbo_background_image',   $_POST['bonfire_jumbo_background']);
		update_option('bonfire_jumbo_background_image_opacity',   $_POST['bonfire_jumbo_background_opacity']);
		update_option('bonfire_jumbo_dot_overlay_opacity',   $_POST['bonfire_jumbo_dot_overlay']);
		update_option('bonfire_jumbo_background_color_opacity',   $_POST['bonfire_jumbo_bg_color_opacity']);
		
		/* main menu appearance speed */
		update_option('bonfire_jumbo_main_menu_appearance_speed',   $_POST['bonfire_jumbo_main_menu_appearance']);
		
		/* main menu theme font */
		update_option('bonfire_jumbo_main_menu_theme_font', $_POST['jumbo_main_menu_theme_font']);
		/* main menu description theme font */
		update_option('bonfire_jumbo_main_menu_description_theme_font', $_POST['jumbo_main_menu_description_theme_font']);
		
		/* secondary menu button transparent background */
		if ( isset ($_POST['jumbo_secondary_menu_transparent'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('bonfire_jumbo_secondary_menu_transparent', $display);
		
		/* secondary menu uppercase checkbox (top-level) */
		if ( isset ($_POST['jumbo_secondary_menu_uppercase'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('jumbo_uppercase_secondary_menu', $display);
		
		/* secondary menu uppercase checkbox (sub-menus) */
		if ( isset ($_POST['jumbo_secondary_sub_menu_uppercase'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('jumbo_uppercase_secondary_sub_menu', $display);
		
		/* enter custom accordion menu width */
		update_option('bonfire_jumbo_accordion_menu_width',   $_POST['bonfire_jumbo_accordion_width']);
		
		/* hide secondary menu checkbox */
		if ( isset ($_POST['jumbo_secondary_menu_hide'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('jumbo_hide_secondary_menu', $display);
		
		/* secondary menu theme font */
		update_option('bonfire_jumbo_secondary_menu_theme_font', $_POST['jumbo_secondary_menu_theme_font']);

		/* enter user gravatar email address */
		update_option('bonfire_jumbo_gravatar_emailaddress',   $_POST['bonfire_jumbo_gravatar_email']);

		/* custom profile image */
		update_option('bonfire_jumbo_custom_profile_image',   $_POST['bonfire_jumbo_custom_profile']);

		/* link to custom profile page */
		update_option('bonfire_jumbo_authorpage_link',   $_POST['bonfire_jumbo_authorpage']);
		
		/* hide gravatar hover tooltip checkbox */
		if ( isset ($_POST['jumbo_gravatar_tooltip'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('jumbo_hide_gravatar_tooltip', $display);
		
		/* disable gravatar hover effect checkbox */
		if ( isset ($_POST['jumbo_gravatar_hover'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('jumbo_disable_gravatar_hover', $display);
		
		/* gravatar tooltip theme font */
		update_option('bonfire_jumbo_gravatar_tooltip_theme_font', $_POST['jumbo_gravatar_tooltip_theme_font']);

	}
	add_action('admin_menu', 'bonfire_jumbo_admin_menu');
	?>
<?php


	//
	// WordPress customizer: Custom logo upload
	//
	function jumbo_theme_customizer( $wp_customize ) {
	
	$wp_customize->add_section( 'jumbo_logo_section' , array(
		'title'       => __( 'Jumbo plugin logo', 'jumbo' ),
		'priority'    => 30,
		'description' => 'Upload a logo to replace the default site name and description in the header',
	) );
	
	$wp_customize->add_setting( 'jumbo_logo',
    array ( 'default' => '',
    'sanitize_callback' => 'esc_url_raw'
    ));
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'jumbo_logo', array(
		'label'    => __( 'Logo', 'jumbo' ),
		'section'  => 'jumbo_logo_section',
		'settings' => 'jumbo_logo',
	) ) );
	
	}
	add_action('customize_register', 'jumbo_theme_customizer');
	
	
	//
	// Add menu to theme
	//
	
	function bonfire_jumbo_footer() {
	?>

	<?php if( get_option('bonfire_jumbo_logged_in') ) { ?>
	
		<?php if ( is_user_logged_in()) { ?>
			<?php include( plugin_dir_path( __FILE__ ) . 'include.php'); ?>
		<?php } ?>
		
	<?php } else { ?>
	
			<?php include( plugin_dir_path( __FILE__ ) . 'include.php'); ?>
	
	<?php } ?>


	<?php
	}
	add_action('wp_footer','bonfire_jumbo_footer');
	

	//
	// ADD the walker class (for menu descriptions)
	//
	
	class Jumbo_Menu_Description extends Walker_Nav_Menu {
		function start_el(&$output, $item, $depth = 0, $args = Array(), $id = 0) {
			global $wp_query;
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
			
			$class_names = $value = '';
	
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
	
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
			$class_names = ' class="' . esc_attr( $class_names ) . '"';
	
			$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
	
			$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
			$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
			$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';
	
			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			$item_output .= '<span class="bonfire-jumbo-main-desc">' . $item->description . '</span><span class="bonfire-jumbo-main-item">';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= '</span></a>';
			$item_output .= $args->after;
	
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args, $id );
		}
	}


	//
	// ENQUEUE jumbo.css
	//

	function bonfire_jumbo_css() {
	// enqueue jumbo.css
		wp_register_style( 'bonfire-jumbo-css', plugins_url( '/jumbo.css', __FILE__ ) . '', array(), '1', 'all' );
		wp_enqueue_style( 'bonfire-jumbo-css' );
	}
	add_action( 'wp_enqueue_scripts', 'bonfire_jumbo_css' );


	//
	// ENQUEUE jumbo.js
	//
	
	function bonfire_jumbo_js() {
	// enqueue jumbo.js
		wp_register_script( 'bonfire-jumbo-js', plugins_url( '/jumbo.js', __FILE__ ) . '', array( 'jquery' ), '1', true );  
		wp_enqueue_script( 'bonfire-jumbo-js' );
	}
	add_action( 'wp_enqueue_scripts', 'bonfire_jumbo_js' );

	//
	// ENQUEUE jumbo-close-on-click.js
	//
	if(get_option('bonfire_jumbo_close_on_click')) {
		function bonfire_jumbo_close_on_click_js() {
			wp_register_script( 'bonfire-jumbo-close-on-click-js', plugins_url( '/jumbo-close-on-click.js', __FILE__ ) . '', array( 'jquery' ), '1', true );  
			wp_enqueue_script( 'bonfire-jumbo-close-on-click-js' );
		}
		add_action( 'wp_enqueue_scripts', 'bonfire_jumbo_close_on_click_js' );
	}


	//
	// ENQUEUE font-awesome.min.css (icons for menu)
	//
	
	function bonfire_jumbo_fontawesome() {
	// enqueue font-awesome.min.css
		wp_register_style( 'jumbo-fontawesome', plugins_url( '/fonts/font-awesome/css/font-awesome.min.css', __FILE__ ) . '', array(), '1', 'all' );  
		wp_enqueue_style( 'jumbo-fontawesome' );
	}
	add_action( 'wp_enqueue_scripts', 'bonfire_jumbo_fontawesome' );


	//
	// Enqueue Google WebFonts
	//
	function bonfire_jumbo_font() {
	$protocol = is_ssl() ? 'https' : 'http';
	// enqueue google webfonts
		wp_enqueue_style( 'bonfire-jumbo-font', "$protocol://fonts.googleapis.com/css?family=Open+Sans:400|Montserrat:400,700' rel='stylesheet' type='text/css" );
	}
	add_action( 'wp_enqueue_scripts', 'bonfire_jumbo_font' );
	

	//
	// Register Custom Menu Function
	//
	if (function_exists('register_nav_menus')) {
		register_nav_menus( array(
			'jumbo-by-bonfire' => ( 'Jumbo, by Bonfire (primary)' ),
			'jumbo-by-bonfire-secondary' => ( 'Jumbo, by Bonfire (secondary)' )
		) );
	}


	//
	// Add color options to Appearance > Customize > Jumbo plugin colors
	//
	add_action( 'customize_register', 'jumbo_plugin_customize_register' );
	function jumbo_plugin_customize_register($wp_customize)
	{
		$colors = array();
		/* menu button */
		$colors[] = array( 'slug'=>'jumbo_menu_button_color', 'default' => '', 'label' => __( 'Menu button', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_menu_button_color_hover', 'default' => '', 'label' => __( 'Menu button hover', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_menu_button_background_color', 'default' => '', 'label' => __( 'Menu button background', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_menu_button_background_color_hover', 'default' => '', 'label' => __( 'Menu button background hover', 'bonfire' ) );
		
		/* secondary menu button */
		$colors[] = array( 'slug'=>'jumbo_secondary_menu_button_color', 'default' => '', 'label' => __( 'Secondary menu button', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_secondary_menu_button_color_hover', 'default' => '', 'label' => __( 'Secondary menu button hover', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_secondary_menu_button_background_color', 'default' => '', 'label' => __( 'Secondary menu button background', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_secondary_menu_button_background_color_hover', 'default' => '', 'label' => __( 'Secondary menu button background hover', 'bonfire' ) );
		
		/* menu buttons separator */
		$colors[] = array( 'slug'=>'jumbo_menu_button_separator_color', 'default' => '', 'label' => __( 'Menu buttons separator', 'bonfire' ) );
		
		/* main menu */
		$colors[] = array( 'slug'=>'jumbo_main_background_color', 'default' => '', 'label' => __( 'Main menu background', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_main_item_color', 'default' => '', 'label' => __( 'Main menu item', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_main_item_color_hover', 'default' => '', 'label' => __( 'Main menu item hover', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_main_item_description_color', 'default' => '', 'label' => __( 'Main menu item description', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_main_item_description_color_hover', 'default' => '', 'label' => __( 'Main menu item description hover', 'bonfire' ) );
		
		/* accordion menu */
		$colors[] = array( 'slug'=>'jumbo_accordion_background_color', 'default' => '', 'label' => __( 'Accordion menu background', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_accordion_hover_color', 'default' => '', 'label' => __( 'Accordion menu background hover', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_accordion_separators_color', 'default' => '', 'label' => __( 'Accordion menu separators', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_accordion_text_color', 'default' => '', 'label' => __( 'Accordion menu text', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_accordion_text_hover_color', 'default' => '', 'label' => __( 'Accordion menu text hover', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_accordion_sub_color', 'default' => '', 'label' => __( 'Accordion sub-menu text', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_accordion_sub_hover_color', 'default' => '', 'label' => __( 'Accordion sub-menu text hover', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_accordion_sub_background', 'default' => '', 'label' => __( 'Accordion sub-menu background', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_accordion_sub_arrow_divider', 'default' => '', 'label' => __( 'Accordion sub-menu expand arrow divider', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_accordion_sub_arrow_divider_multi', 'default' => '', 'label' => __( 'Accordion sub-menu expand arrow divider (multi-level)', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_accordion_sub_expand', 'default' => '', 'label' => __( 'Accordion sub-menu expand arrow', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_accordion_sub_expand_hover', 'default' => '', 'label' => __( 'Accordion sub-menu expand arrow hover', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_accordion_sub_expand_multi', 'default' => '', 'label' => __( 'Accordion sub-menu expand arrow (multi-level)', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_accordion_sub_expand_multi_hover', 'default' => '', 'label' => __( 'Accordion sub-menu expand arrow hover (multi-level)', 'bonfire' ) );
		
		/* gravatar tooltip */
		$colors[] = array( 'slug'=>'jumbo_gravatar_tooltip_text_color', 'default' => '', 'label' => __( 'Gravatar tooltip text', 'bonfire' ) );
		$colors[] = array( 'slug'=>'jumbo_gravatar_tooltip_background_color', 'default' => '', 'label' => __( 'Gravatar tooltip background', 'bonfire' ) );

	foreach($colors as $color)
	{

	/* create custom color customization section */
	$wp_customize->add_section( 'jumbo_plugin_colors' , array( 'title' => __('Jumbo plugin colors', 'bonfire'), 'priority' => 30 ));
	$wp_customize->add_setting( $color['slug'], array( 'default' => $color['default'], 'type' => 'option', 'capability' => 'edit_theme_options' ));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color['slug'], array( 'label' => $color['label'], 'section' => 'jumbo_plugin_colors', 'settings' => $color['slug'] )));
	}
	}


	//
	// Insert plugin customizer options into the footer
	//
	
	function bonfire_jumbo_header_customize() {
	?>

		<!-- BEGIN CUSTOM COLORS (WP THEME CUSTOMIZER) -->
		<?php $jumbo_menu_button_color = get_option('jumbo_menu_button_color'); ?>
		<?php $jumbo_menu_button_color_hover = get_option('jumbo_menu_button_color_hover'); ?>
		<?php $jumbo_menu_button_background_color = get_option('jumbo_menu_button_background_color'); ?>
		<?php $jumbo_menu_button_background_color_hover = get_option('jumbo_menu_button_background_color_hover'); ?>
		
		<?php $jumbo_secondary_menu_button_color = get_option('jumbo_secondary_menu_button_color'); ?>
		<?php $jumbo_secondary_menu_button_color_hover = get_option('jumbo_secondary_menu_button_color_hover'); ?>
		<?php $jumbo_secondary_menu_button_background_color = get_option('jumbo_secondary_menu_button_background_color'); ?>
		<?php $jumbo_secondary_menu_button_background_color_hover = get_option('jumbo_secondary_menu_button_background_color_hover'); ?>
		
		<?php $jumbo_menu_button_separator_color = get_option('jumbo_menu_button_separator_color'); ?>
		
		<?php $jumbo_main_background_color = get_option('jumbo_main_background_color'); ?>
		<?php $jumbo_main_item_color = get_option('jumbo_main_item_color'); ?>
		<?php $jumbo_main_item_color_hover = get_option('jumbo_main_item_color_hover'); ?>
		<?php $jumbo_main_item_description_color = get_option('jumbo_main_item_description_color'); ?>
		<?php $jumbo_main_item_description_color_hover = get_option('jumbo_main_item_description_color_hover'); ?>
		
		<?php $jumbo_accordion_background_color = get_option('jumbo_accordion_background_color'); ?>
		<?php $jumbo_accordion_hover_color = get_option('jumbo_accordion_hover_color'); ?>
		<?php $jumbo_accordion_separators_color = get_option('jumbo_accordion_separators_color'); ?>
		<?php $jumbo_accordion_text_color = get_option('jumbo_accordion_text_color'); ?>
		<?php $jumbo_accordion_text_hover_color = get_option('jumbo_accordion_text_hover_color'); ?>
		<?php $jumbo_accordion_sub_color = get_option('jumbo_accordion_sub_color'); ?>
		<?php $jumbo_accordion_sub_hover_color = get_option('jumbo_accordion_sub_hover_color'); ?>
		<?php $jumbo_accordion_sub_background = get_option('jumbo_accordion_sub_background'); ?>
		<?php $jumbo_accordion_sub_arrow_divider = get_option('jumbo_accordion_sub_arrow_divider'); ?>
		<?php $jumbo_accordion_sub_arrow_divider_multi = get_option('jumbo_accordion_sub_arrow_divider_multi'); ?>
		<?php $jumbo_accordion_sub_expand = get_option('jumbo_accordion_sub_expand'); ?>
		<?php $jumbo_accordion_sub_expand_hover = get_option('jumbo_accordion_sub_expand_hover'); ?>
		<?php $jumbo_accordion_sub_expand_multi = get_option('jumbo_accordion_sub_expand_multi'); ?>
		<?php $jumbo_accordion_sub_expand_multi_hover = get_option('jumbo_accordion_sub_expand_multi_hover'); ?>
		
		<?php $jumbo_gravatar_tooltip_text_color = get_option('jumbo_gravatar_tooltip_text_color'); ?>
		<?php $jumbo_gravatar_tooltip_background_color = get_option('jumbo_gravatar_tooltip_background_color'); ?>

		<style>
		/* top distance */
		<?php if( get_option('jumbo_top_position') ) { ?>
		.jumbo-buttons-wrapper { top:<?php echo get_option('jumbo_top_position'); ?>px !important; }
		<?php } ?>
		
		
		<?php if( get_option('bonfire_jumbo_position_left_right') ) { ?>
			.jumbo-buttons-wrapper {
				left:auto;
				right:0;
			}
		<?php } ?>
		
		/* left/right distance*/
		<?php if( get_option('bonfire_jumbo_position_left_right') && get_option('jumbo_left_position') ) { ?>
			.jumbo-buttons-wrapper {
				left:auto !important;
				right:<?php echo get_option('jumbo_left_position'); ?>px !important;
			}
		<?php } else if( get_option('jumbo_left_position') ) { ?>
			.jumbo-buttons-wrapper {
				left:<?php echo get_option('jumbo_left_position'); ?>px !important;
			}
		<?php } ?>
		
		/* if main menu button hidden */
		<?php if( get_option('bonfire_jumbo_main_menu_button_hide') ) { ?>
		.jumbo-menu-active-secondary { left:-5px; }
		.jumbo-accordion-tooltip { margin-left:16px; }
		<?php } ?>
		
		/* if menu positioned right */
		<?php if( get_option('bonfire_jumbo_position_left_right') ) { ?>
			.jumbo-gravatar-tooltip-wrapper { margin-left:-45px; }
			.jumbo-gravatar-tooltip-wrapper i { margin-left:72px; }
			.jumbo-menu-active-secondary {
				left:auto;
				right:16px;
			}
			.jumbo-accordion-tooltip {
				margin-left:0;
				margin-right:55px;
			}
		<?php } ?>
		
		/* menu button styles */
		<?php if( get_option('bonfire_jumbo_main_menu_button_alt') ) { ?>
			.jumbo-menu-button-active:before {
				-webkit-transform:translateY(8px);
				-moz-transform:translateY(8px);
				transform:translateY(8px);
			}
			.jumbo-menu-button-active:after {
				-webkit-transform:translateY(-8px);
				-moz-transform:translateY(-8px);
				transform:translateY(-8px);
			}
		<?php } else { ?>
			.jumbo-menu-button-active:before {
				-webkit-transform:translateY(8px) rotate(45deg);
				-moz-transform:translateY(8px) rotate(45deg);
				transform:translateY(8px) rotate(45deg);
			}
			.jumbo-menu-button-active:after {
				-webkit-transform:translateY(-8px) rotate(-45deg);
				-moz-transform:translateY(-8px) rotate(-45deg);
				transform:translateY(-8px) rotate(-45deg);
			}
			.jumbo-menu-button-active div.jumbo-menu-button-middle { opacity:0; }
		<?php } ?>
		
		/* menu button */
		.jumbo-menu-button:after,
		.jumbo-menu-button:before,
		.jumbo-menu-button div.jumbo-menu-button-middle { background-color:<?php echo $jumbo_menu_button_color; ?>; }
		.jumbo-menu-button:hover:after,
		.jumbo-menu-button:hover:before,
		.jumbo-menu-button:hover div.jumbo-menu-button-middle { background-color:<?php echo $jumbo_menu_button_color_hover; ?>; }
		.jumbo-menu-button { background-color:<?php echo $jumbo_menu_button_background_color; ?>;<?php if( get_option('bonfire_jumbo_main_menu_transparent') ) { ?> background-color:transparent;<?php } ?> }
		.jumbo-menu-button:hover { background-color:<?php echo $jumbo_menu_button_background_color_hover; ?>;<?php if( get_option('bonfire_jumbo_main_menu_transparent') ) { ?> background-color:transparent;<?php } ?> }
		
		/* secondary menu button */
		.jumbo-secondary-menu-button i { color:<?php echo $jumbo_secondary_menu_button_color; ?>; }
		.jumbo-secondary-menu-button:hover i { color:<?php echo $jumbo_secondary_menu_button_color_hover; ?>; }
		.jumbo-secondary-menu-button { background-color:<?php echo $jumbo_secondary_menu_button_background_color; ?>;<?php if( get_option('bonfire_jumbo_secondary_menu_transparent') ) { ?> background-color:transparent;<?php } ?> }
		.jumbo-secondary-menu-button:hover { background-color:<?php echo $jumbo_secondary_menu_button_background_color_hover; ?>;<?php if( get_option('bonfire_jumbo_secondary_menu_transparent') ) { ?> background-color:transparent;<?php } ?> }
		
		/* menu buttons separator */
		.jumbo-secondary-menu-button { border-color:<?php echo $jumbo_menu_button_separator_color; ?>; }
		
		/* main menu */
		.jumbo-background-color {
			background-color:<?php echo $jumbo_main_background_color; ?>;
			opacity:<?php echo get_option('bonfire_jumbo_background_color_opacity'); ?>;
			
			-webkit-transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease, -webkit-transform 0s ease <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s;
			-moz-transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease, -moz-transform 0s ease <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s;
			transition: opacity .3s ease, transform 0s ease <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s;
		}
		.jumbo-background-color-active {
			-webkit-transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease, -webkit-transform 0s ease;
			-moz-transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease, -moz-transform 0s ease;
			transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease, transform 0s ease;
		}
		.jumbo-background-image {			
			-webkit-transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease, -webkit-transform 0s ease <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s;
			-moz-transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease, -moz-transform 0s ease <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s;
			transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease, transform 0s ease <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s;
		}
		.jumbo-background-image-active {
			-webkit-transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease, -webkit-transform 0s ease;
			-moz-transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease, -moz-transform 0s ease;
			transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease, transform 0s ease;
		}

		.bonfire-jumbo-main-item { color:<?php echo $jumbo_main_item_color; ?>; }
		.jumbo-main-menu-wrapper a:hover .bonfire-jumbo-main-item { color:<?php echo $jumbo_main_item_color_hover; ?>; }
		.bonfire-jumbo-main-desc { color:<?php echo $jumbo_main_item_description_color; ?>; <?php if( get_option('jumbo_uppercase_main_menu_description') ) { ?> text-transform:uppercase<?php } ?>; }
		.jumbo-main-menu-wrapper a:hover .bonfire-jumbo-main-desc { color:<?php echo $jumbo_main_item_description_color_hover; ?>; }
		.jumbo-main-menu-wrapper a .bonfire-jumbo-main-item { <?php if( get_option('jumbo_uppercase_main_menu') ) { ?>text-transform:uppercase<?php } ?>; }
		
		/* main menu font */
		<?php if(get_option('bonfire_jumbo_main_menu_theme_font')) { ?>
		.bonfire-jumbo-main-item {
			font-family:<?php echo stripslashes(get_option('bonfire_jumbo_main_menu_theme_font')); ?>;
		}
		<?php } ?>

		/* main menu description font */
		<?php if(get_option('bonfire_jumbo_main_menu_description_theme_font')) { ?>
		.bonfire-jumbo-main-desc {
			font-family:<?php echo stripslashes(get_option('bonfire_jumbo_main_menu_description_theme_font')); ?>;
		}
		<?php } ?>
		
		/* secondary menu font */
		<?php if(get_option('bonfire_jumbo_secondary_menu_theme_font')) { ?>
		.jumbo-by-bonfire-secondary .menu a {
			font-family:<?php echo stripslashes(get_option('bonfire_jumbo_secondary_menu_theme_font')); ?>;
		}
		<?php } ?>
		
		/* accordion menu */
		.jumbo-accordion-tooltip { color:<?php echo $jumbo_accordion_background_color; ?>; }
		.jumbo-by-bonfire-secondary { background-color:<?php echo $jumbo_accordion_background_color; ?>; }
		.jumbo-by-bonfire-secondary .menu li a:hover { background-color:<?php echo $jumbo_accordion_hover_color; ?>; }
		.jumbo-by-bonfire-secondary .menu li, .jumbo-by-bonfire-secondary .sub-menu li:first-child { border-color:<?php echo $jumbo_accordion_separators_color; ?>; }
		.jumbo-by-bonfire-secondary .menu a { color:<?php echo $jumbo_accordion_text_color; ?>; }
		
		.jumbo-by-bonfire-secondary .menu { <?php if( get_option('jumbo_uppercase_secondary_menu') ) { ?>text-transform:uppercase<?php } ?>; }

		.jumbo-by-bonfire-secondary .menu a:hover { color:<?php echo $jumbo_accordion_text_hover_color; ?>; }
		.jumbo-by-bonfire-secondary .sub-menu a { color:<?php echo $jumbo_accordion_sub_color; ?>; }
		.jumbo-by-bonfire-secondary .sub-menu a:hover {	color:<?php echo $jumbo_accordion_sub_hover_color; ?>; }
		.jumbo-by-bonfire-secondary .sub-menu { background:<?php echo $jumbo_accordion_sub_background; ?>; <?php if( get_option('jumbo_uppercase_secondary_sub_menu') ) { ?>text-transform:uppercase<?php } ?>; }
		.jumbo-by-bonfire-secondary .menu li span span { border-color:<?php echo $jumbo_accordion_sub_arrow_divider; ?>; }
		.jumbo-by-bonfire-secondary .menu li span span svg { fill:<?php echo $jumbo_accordion_sub_expand; ?>; }
		.jumbo-by-bonfire-secondary .menu li span:hover svg { fill:<?php echo $jumbo_accordion_sub_expand_hover; ?>; }
		/* expand arrow divider color (multi-level) */
		.jumbo-by-bonfire-secondary ul.menu > li li span span { border-color:<?php echo $jumbo_accordion_sub_arrow_divider_multi; ?>; }
		/* expand arrow colors in sub-menus (multi-level) */
		.jumbo-by-bonfire-secondary ul.menu > li li span svg { fill:<?php echo $jumbo_accordion_sub_expand_multi; ?>; }
		.jumbo-by-bonfire-secondary ul.menu > li li span:hover svg { fill:<?php echo $jumbo_accordion_sub_expand_multi_hover; ?>; }
		
		/* gravatar */
		.jumbo-gravatar-tooltip { color:<?php echo $jumbo_gravatar_tooltip_text_color; ?>; background-color:<?php echo $jumbo_gravatar_tooltip_background_color; ?>; }
		.jumbo-gravatar-tooltip-wrapper i { color:<?php echo $jumbo_gravatar_tooltip_background_color; ?>; }
		<?php if( get_option('jumbo_disable_gravatar_hover') ) { ?><?php } else { ?>
		.jumbo-gravatar-wrapper:hover img { opacity:.6; }
		<?php } ?>
		
		/* gravatar tooltip font */
		<?php if(get_option('bonfire_jumbo_gravatar_tooltip_theme_font')) { ?>
		.jumbo-gravatar-tooltip {
			font-family:<?php echo stripslashes(get_option('bonfire_jumbo_gravatar_tooltip_theme_font')); ?>;
		}
		<?php } ?>

		/* allows for smooth fade out */
		.jumbo-animation-out {
			-webkit-transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease, -webkit-transform 0s ease <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s !important;
			-moz-transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease, -moz-transform 0s ease <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s !important;
			transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease, transform 0s ease <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s !important;
		}
		.jumbo-menu-active {
			-webkit-transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease;
			-moz-transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease;
			transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease;
		}
		
		.jumbo-dot-overlay { opacity:<?php echo get_option('bonfire_jumbo_dot_overlay_opacity'); ?>; }
		
		.bonfire-jumbo-main-item { opacity:<?php echo get_option('bonfire_jumbo_main_menu_text_opacity'); ?>; }
		.bonfire-jumbo-main-desc { opacity:<?php echo get_option('bonfire_jumbo_main_menu_desc_opacity'); ?>; }
		.jumbo-main-menu-wrapper ul { margin-top:<?php echo get_option('bonfire_jumbo_main_menu_top_margin'); ?>px; }
		
		.jumbo-by-bonfire-secondary { width:<?php echo get_option('bonfire_jumbo_accordion_menu_width'); ?>px; }
		
		.jumbo-by-bonfire-wrapper-top,
		.jumbo-main-menu-wrapper-top,
		.jumbo-dot-overlay-top,
		.jumbo-background-image-top,
		.jumbo-background-color-top,
		.jumbo-by-bonfire-wrapper-bottom,
		.jumbo-main-menu-wrapper-bottom,
		.jumbo-dot-overlay-bottom,
		.jumbo-background-image-bottom,
		.jumbo-background-color-bottom,
		.jumbo-by-bonfire-wrapper-left,
		.jumbo-main-menu-wrapper-left,
		.jumbo-dot-overlay-left,
		.jumbo-background-image-left,
		.jumbo-background-color-left,
		.jumbo-by-bonfire-wrapper-right,
		.jumbo-main-menu-wrapper-right,
		.jumbo-dot-overlay-right,
		.jumbo-background-image-right,
		.jumbo-background-color-right {
			-webkit-transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease, -webkit-transform <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease 0s !important;
			-moz-transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease, -moz-transform <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease 0s !important;
			transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease, transform <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease 0s !important;
		}
		/* Hide Jumbo between resolutions */
		@media (min-width:<?php echo get_option('bonfire_jumbo_smaller_than'); ?>px) and (max-width:<?php echo get_option('bonfire_jumbo_larger_than'); ?>px) {
			.jumbo-buttons-wrapper { display:none; }
		}
		</style>
		<!-- END CUSTOM COLORS (WP THEME CUSTOMIZER) -->
	
	<?php
	}
	add_action('wp_footer','bonfire_jumbo_header_customize');

?>
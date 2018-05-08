		<!-- BEGIN PREVENT TOUCHSTART MISHAPS -->
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
		<!-- END PREVENT TOUCHSTART MISHAPS -->

		<!-- BEGIN JUMBO BUTTONS -->
		<div class="jumbo-buttons-wrapper<?php if ( is_admin_bar_showing() ) { ?> jumbo-wp-toolbar<?php } ?><?php if( get_option('jumbo_absolute_positioning') ) { ?> jumbo-buttons-wrapper-absolute<?php } ?>">
			
			<!-- BEGIN MAIN MENU BUTTON -->
			<?php if( get_option('bonfire_jumbo_main_menu_button_hide') ) { ?>
			<?php } else { ?>
			<div class="jumbo-menu-button<?php if( get_option('jumbo_main_menu_open_front') && is_front_page() ) { ?> jumbo-menu-button-active<?php } ?>">
				<div class="jumbo-menu-button-middle"></div>
			</div>
			<?php } ?>
			<!-- END MAIN MENU BUTTON -->
			
			<!-- BEGIN SECONDARY MENU BUTTON -->
			<?php if( get_option('jumbo_hide_secondary_menu') ) { ?>
			<?php } else { ?>
			<div class="jumbo-secondary-menu-button">
				<i class="fa fa-sort-down"></i>
			</div>
			<?php } ?>
			<!-- END SECONDARY MENU BUTTON -->
		
			<!-- BEGIN AUTHOR GRAVATAR -->
			<?php if( get_option('bonfire_jumbo_gravatar_emailaddress') ) { ?>
			<div class="jumbo-gravatar-wrapper">
				<a href="<?php echo get_option('bonfire_jumbo_authorpage_link'); ?>" rel="author">					
					<?php if( get_option('bonfire_jumbo_custom_profile_image') ) { ?>
						<img width="62px" height="62px" src="<?php echo get_option('bonfire_jumbo_custom_profile_image'); ?>">
					<?php } else { ?>
						<?php echo get_avatar( get_option('bonfire_jumbo_gravatar_emailaddress'), 62 ); ?>
					<?php } ?>
				</a>

				<!-- BEGIN AUTHOR GRAVATAR TOOLTIP -->
				<?php if( get_option('jumbo_hide_gravatar_tooltip') ) { ?><?php } else { ?>
					<?php if ( wp_is_mobile() ) { ?><?php } else { ?>
						<div class="jumbo-gravatar-tooltip-wrapper">
							<i class="fa fa-sort-up"></i>
							<div class="jumbo-gravatar-tooltip">
								<?php _e( 'VIEW PROFILE', 'bonfire' ); ?>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
				<!-- END AUTHOR GRAVATAR TOOLTIP -->

			</div>
			<?php } ?>
			<!-- END AUTHOR GRAVATAR -->
		
			<!-- BEGIN SECONDARY MENU -->
			<?php if( get_option('jumbo_hide_secondary_menu') ) { ?>
			<?php } else { ?>
				<div class="jumbo-accordion-tooltip">
					<i class="fa fa-sort-up"></i>
				</div>
				<?php wp_nav_menu( array( 'container_class' => 'jumbo-by-bonfire-secondary', 'theme_location' => 'jumbo-by-bonfire-secondary', 'fallback_cb' => '' ) ); ?>
			<?php } ?>
			<!-- END SECONDARY MENU -->
		
		</div>
		<!-- END BEGIN JUMBO BUTTONS -->
		
		<!-- BEGIN MAIN MENU BACKGROUND -->
		<div class="jumbo-by-bonfire-wrapper<?php if(get_option('bonfire_jumbo_slidein_direction') == "jumboslideinbottom") { ?> jumbo-by-bonfire-wrapper-two<?php } ?>

		<?php if( get_option('jumbo_main_menu_open_front') && is_front_page() ) { ?> jumbo-menu-active<?php } ?>"<?php if( get_option('bonfire_jumbo_main_menu_appearance_speed') ) { ?> style="-webkit-transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease;-moz-transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease;transition: opacity <?php echo get_option('bonfire_jumbo_main_menu_appearance_speed'); ?>s ease;"<?php } ?>>

			<!-- BEGIN DOT OVERLAY -->
			<div class="jumbo-dot-overlay <?php if(get_option('bonfire_jumbo_slidein_direction') == "jumboslideintop") { ?>jumbo-dot-overlay-top<?php } elseif(get_option('bonfire_jumbo_slidein_direction') == "jumboslideinleft") { ?>jumbo-dot-overlay-left<?php } elseif(get_option('bonfire_jumbo_slidein_direction') == "jumboslideinright") { ?>jumbo-dot-overlay-right<?php } elseif(get_option('bonfire_jumbo_slidein_direction') == "jumboslideinbottom") { ?>jumbo-dot-overlay-bottom<?php } ?><?php if( get_option('jumbo_main_menu_open_front') && is_front_page() ) { ?> jumbo-dot-overlay-active<?php } ?>">
			</div>
			<!-- END DOT OVERLAY -->

			<!-- BEGIN BACKGROUND IMAGE -->
			<?php if( get_option('bonfire_jumbo_background_image') ) { ?>
				<div class="jumbo-background-image <?php if(get_option('bonfire_jumbo_slidein_direction') == "jumboslideintop") { ?>jumbo-background-image-top<?php } elseif(get_option('bonfire_jumbo_slidein_direction') == "jumboslideinleft") { ?>jumbo-background-image-left<?php } elseif(get_option('bonfire_jumbo_slidein_direction') == "jumboslideinright") { ?>jumbo-background-image-right<?php } elseif(get_option('bonfire_jumbo_slidein_direction') == "jumboslideinbottom") { ?>jumbo-background-image-bottom<?php } ?><?php if( get_option('jumbo_main_menu_open_front') && is_front_page() ) { ?> jumbo-background-image-active<?php } ?>" style="background-image:url(<?php echo get_option('bonfire_jumbo_background_image'); ?>);opacity:<?php echo get_option('bonfire_jumbo_background_image_opacity'); ?>;">
				</div>
			<?php } ?>
			<!-- END BACKGROUND IMAGE -->
			
			<!-- BEGIN BACKGROUND COLOR -->
			<div class="jumbo-background-color <?php if(get_option('bonfire_jumbo_slidein_direction') == "jumboslideintop") { ?>jumbo-background-color-top<?php } elseif(get_option('bonfire_jumbo_slidein_direction') == "jumboslideinleft") { ?>jumbo-background-color-left<?php } elseif(get_option('bonfire_jumbo_slidein_direction') == "jumboslideinright") { ?>jumbo-background-color-right<?php } elseif(get_option('bonfire_jumbo_slidein_direction') == "jumboslideinbottom") { ?>jumbo-background-color-bottom<?php } ?><?php if( get_option('jumbo_main_menu_open_front') && is_front_page() ) { ?> jumbo-background-color-active<?php } ?>">
			</div>
			<!-- END BACKGROUND COLOR -->

		</div>
		<!-- END MAIN MENU BACKGROUND -->

		<!-- BEGIN LOGO + MAIN MENU -->
		<div class="jumbo-main-menu-wrapper <?php if(get_option('bonfire_jumbo_slidein_direction') == "jumboslideintop") { ?>jumbo-main-menu-wrapper-top<?php } elseif(get_option('bonfire_jumbo_slidein_direction') == "jumboslideinleft") { ?>jumbo-main-menu-wrapper-left<?php } elseif(get_option('bonfire_jumbo_slidein_direction') == "jumboslideinright") { ?>jumbo-main-menu-wrapper-right<?php } elseif(get_option('bonfire_jumbo_slidein_direction') == "jumboslideinbottom") { ?>jumbo-main-menu-wrapper-bottom<?php } ?><?php if( get_option('jumbo_main_menu_open_front') && is_front_page() ) { ?> jumbo-menu-active<?php } ?>"<?php if(get_option('bonfire_jumbo_main_menu_horizontal_align') == "jumboalignleft") { ?> style="text-align:left;"<?php } elseif(get_option('bonfire_jumbo_main_menu_horizontal_align') == "jumboalignright") { ?> style="text-align:right;"<?php } ?>>
			<div class="jumbo-main-menu-wrapper-inner">
				<div class="jumbo-main-menu-wrapper-inner-inner">
					<div class="jumbo-by-bonfire"<?php if(get_option('bonfire_jumbo_main_menu_vertical_align') == "jumboaligntop") { ?> style="vertical-align:top;"<?php } elseif(get_option('bonfire_jumbo_main_menu_vertical_align') == "jumboalignbottom") { ?> style="vertical-align:bottom;"<?php } ?>>
						
						<!-- BEGIN LOGO -->
						<div class="jumbo-logo-wrapper">
							<?php if ( get_theme_mod( 'jumbo_logo' ) ) { ?>
								<!-- BEGIN LOGO IMAGE -->
								<div class="jumbo-logo-image">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo get_theme_mod( 'jumbo_logo' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
								</div>
								<!-- END LOGO IMAGE -->
							<?php } ?>
						</div>
						<!-- END LOGO -->
						
						<!-- BEGIN MENU -->
						<?php $walker = new Jumbo_Menu_Description; ?>
						<?php wp_nav_menu( array( 'theme_location' => 'jumbo-by-bonfire', 'walker' => $walker, 'fallback_cb' => '' ) ); ?>
						<!-- END MENU -->
					</div>
				</div>
			</div>
		</div>
		<!-- END LOGO + MAIN MENU -->
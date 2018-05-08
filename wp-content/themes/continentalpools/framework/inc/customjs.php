<?php
function minti_js_custom() {
	
	global $minti_data; ?>

	<script type="text/javascript">
	jQuery(document).ready(function($){
		"use strict";
	    
		/* PrettyPhoto Options */
		var lightboxArgs = {			
			<?php if($minti_data["lightbox_animation_speed"]): ?>
			animation_speed: '<?php echo strtolower(esc_js($minti_data["lightbox_animation_speed"])); ?>',
			<?php endif; ?>
			overlay_gallery: <?php if($minti_data["lightbox_gallery"]) { echo 'true'; } else { echo 'false'; } ?>,
			autoplay_slideshow: <?php if($minti_data["lightbox_autoplay"]) { echo 'true'; } else { echo 'false'; } ?>,
			<?php if($minti_data["lightbox_slideshow_speed"]): ?>
			slideshow: <?php echo intval($minti_data['lightbox_slideshow_speed']); ?>,
			<?php endif; ?>
			<?php if($minti_data["lightbox_opacity"]): ?>
			opacity: <?php echo esc_js($minti_data['lightbox_opacity']); ?>,
			<?php endif; ?>
			show_title: <?php if($minti_data["lightbox_title"]) { echo 'true'; } else { echo 'false'; } ?>,
			<?php if(!$minti_data["lightbox_social"]) { echo 'social_tools: "",'; } ?>
			deeplinking: false,
			allow_resize: true,
			allow_expand: false,
			counter_separator_label: '/',
			default_width: 1160,
			default_height: 653
		};
		
		<?php if($minti_data["lightbox_automatic"] == 1){ ?>
		/* Automatic Lightbox */
		$('a[href$=jpg], a[href$=JPG], a[href$=jpeg], a[href$=JPEG], a[href$=png], a[href$=gif], a[href$=bmp]:has(img)').prettyPhoto(lightboxArgs);
		<?php } ?>
			
		/* General Lightbox */
		$('a[class^="prettyPhoto"], a[rel^="prettyPhoto"], .prettyPhoto').prettyPhoto(lightboxArgs);

		/* WooCommerce Lightbox */
		$("a[data-rel^='prettyPhoto']").prettyPhoto({
			hook: 'data-rel',
			social_tools: false,
			deeplinking: false,
			overlay_gallery: <?php if($minti_data["lightbox_gallery"]) { echo 'true'; } else { echo 'false'; } ?>,
			opacity: <?php echo esc_js($minti_data['lightbox_opacity']); ?>,
			allow_expand: false, /* Allow the user to expand a resized image. true/false */
			show_title: false
		});

		<?php if($minti_data["lightbox_smartphones"] == 0){ ?>
		/* Lightbox for Smartphones OFF */
		var windowWidth = window.screen.width < window.outerWidth ? window.screen.width : window.outerWidth;
	    var mobile = windowWidth < 500;
	    
	    if(mobile){
	        $('a[href$=jpg], a[href$=JPG], a[href$=jpeg], a[href$=JPEG], a[href$=png], a[href$=gif], a[href$=bmp]:has(img), a[class^="prettyPhoto"]').unbind('click.prettyphoto');
	    }
	    <?php } ?>

	    <?php if($minti_data['switch_stickyheader'] == 1) { ?>

		/* Transparent Header */
	    function transparentHeader() {
			if ($(document).scrollTop() >= 60) {
				$('#header.header-v1').removeClass('header-transparent');
			}
			else {
				$('#header.header-v1.stuck').addClass('header-transparent');
			}
		}
			
		/* Sticky Header */
		if (/Android|BlackBerry|iPhone|iPad|iPod|webOS/i.test(navigator.userAgent) === false) {

			var $stickyHeaders = $('#header.header-v1, #header.header-v3 .navigation-wrap, #header.header-v4 .navigation-wrap');
			$stickyHeaders.waypoint('sticky');
			
			$(window).resize(function() {
				$stickyHeaders.waypoint('unsticky');
				if ($(window).width() < 944) {
					$stickyHeaders.waypoint('unsticky');
				}
				else {
					$stickyHeaders.waypoint('sticky');
				}
			});
			
			if ($("body").hasClass("header-is-transparent")) {
				$(document).scroll(function() { transparentHeader(); });
				transparentHeader();
		    }

		}			
	    <?php } ?>

	    <?php if($minti_data['switch_simpleselect'] == 1) { ?>
	    $('.widget select, select.orderby, .variations_form select, .wpcf7-select, .woocommerce select').not('#rating, #calc_shipping_country, #billing_state').simpleselect();
	   	<?php } ?>

	    <?php if ( class_exists('Woocommerce') ) { ?>
		    <?php if($minti_data['switch_secondimageonhover'] == 1) { ?>
			/* WooCommerce: Second Image on Hover */
			$( 'ul.products li.pif-has-gallery a:first-child' ).hover( function() {
				$( this ).children( '.secondary-image' ).stop().animate({'opacity' : 1}, 'fast');
			}, function() {
				$( this ).children( '.secondary-image' ).stop().animate({'opacity' : 0}, 'fast');
			});		
		    <?php } ?>
	    <?php } ?>

	    <?php if($minti_data['select_layoutstyle'] != 'boxed') { ?>	
	    /* Fill rest of page */
	    		<?php if($minti_data['switch_copyright'] == 1 && get_post_meta( get_the_ID(), 'minti_footercopyright', true ) != 'hide'){ ?>
	    			$('body').css({'background-color' : '<?php echo esc_js($minti_data['color_copyrightbg']); ?>' });
	    		<?php } ?>
	    <?php } ?>

	});
	</script>
	
<?php 
}
add_action( 'wp_footer', 'minti_js_custom', 100 );
?>
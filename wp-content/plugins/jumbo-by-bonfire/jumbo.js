<!-- BEGIN SHOW/HIDE MAIN MENU -->
jQuery('.jumbo-menu-button, .jumbo-custom-activator').on('touchstart click', function(e) {
e.preventDefault();

	/* touchstart events */
	if(jQuery('.jumbo-by-bonfire-wrapper, .jumbo-main-menu-wrapper, .jumbo-dot-overlay').hasClass('jumbo-menu-active'))
	{
		/* turn menu button into default state */
		jQuery(".jumbo-menu-button").removeClass("jumbo-menu-button-active");
		/* hide main menu */
		jQuery(".jumbo-by-bonfire-wrapper, .jumbo-main-menu-wrapper").removeClass("jumbo-menu-active").addClass("jumbo-animation-out");
		jQuery(".jumbo-dot-overlay").removeClass("jumbo-dot-overlay-active").addClass("jumbo-animation-out");
		jQuery(".jumbo-background-image").removeClass("jumbo-background-image-active");
		jQuery(".jumbo-background-color").removeClass("jumbo-background-color-active");
	} else {
		/* turn menu button into X */
		jQuery(".jumbo-menu-button").addClass("jumbo-menu-button-active");
		/* show main menu */
		jQuery(".jumbo-by-bonfire-wrapper, .jumbo-main-menu-wrapper").addClass("jumbo-menu-active").removeClass("jumbo-animation-out");
		jQuery(".jumbo-dot-overlay").addClass("jumbo-dot-overlay-active").removeClass("jumbo-animation-out");
		jQuery(".jumbo-background-image").addClass("jumbo-background-image-active");
		jQuery(".jumbo-background-color").addClass("jumbo-background-color-active");
	}

});
<!-- END SHOW/HIDE MAIN MENU -->

<!-- BEGIN SHOW/HIDE SECONDARY MENU -->
jQuery('.jumbo-secondary-menu-button').on('touchstart click', function(e) {
e.preventDefault();

	/* touchstart events */
	if(jQuery('.jumbo-by-bonfire-secondary').hasClass('jumbo-menu-active-secondary'))
	{
		/* hide accordion menu */
		jQuery(".jumbo-by-bonfire-secondary, .jumbo-accordion-tooltip").removeClass("jumbo-menu-active-secondary");
	} else {
		/* show accordion menu */
		jQuery(".jumbo-by-bonfire-secondary, .jumbo-accordion-tooltip").addClass("jumbo-menu-active-secondary");
	}

});
<!-- END SHOW/HIDE SECONDARY MENU -->

<!-- BEGIN SHOW/HIDE GRAVATAR TOOLTIP -->
jQuery(".jumbo-gravatar-wrapper").on({
	mouseenter: function () {
		jQuery(".jumbo-gravatar-tooltip-wrapper").addClass("jumbo-gravatar-tooltip-wrapper-active");
	},
	mouseleave: function () {
		jQuery(".jumbo-gravatar-tooltip-wrapper").removeClass("jumbo-gravatar-tooltip-wrapper-active");
	}
});
<!-- END SHOW/HIDE GRAVATAR TOOLTIP -->

<!-- BEGIN HIDE WHEN CLICKED/TAPPED OUTSIDE MENU -->
var clickHandler = ('ontouchstart' in document.documentElement ? "touchstart" : "click");

jQuery("html").bind(clickHandler, function(e) {
	jQuery(".jumbo-by-bonfire-secondary, .jumbo-accordion-tooltip").removeClass("jumbo-menu-active-secondary");
	
	jQuery(".jumbo-by-bonfire-secondary .menu > li").find(".sub-menu").slideUp(300);
	jQuery(".menu > li > span, .sub-menu > li > span").removeClass("jumbo-submenu-active");
});

jQuery('.jumbo-secondary-menu-button, .jumbo-by-bonfire-secondary').on('click', function(event){
	event.stopPropagation();
});
jQuery('.jumbo-secondary-menu-button, .jumbo-by-bonfire-secondary').on('touchstart', function(event){
	event.stopPropagation();
});
<!-- END HIDE WHEN CLICKED/TAPPED OUTSIDE MENU -->

<!-- BEGIN HIDE MAIN MENU WHEN ESC BUTTON PRESSED -->
jQuery(document).keyup(function(e) {
	if (e.keyCode == 27) { 

		/* turn menu button into default state */
		jQuery(".jumbo-menu-button").removeClass("jumbo-menu-button-active");
		jQuery(".jumbo-by-bonfire-wrapper, .jumbo-main-menu-wrapper").removeClass("jumbo-menu-active").addClass("jumbo-animation-out");
		jQuery(".jumbo-dot-overlay").removeClass("jumbo-dot-overlay-active").addClass("jumbo-animation-out");
		jQuery(".jumbo-background-image").removeClass("jumbo-background-image-active");
		jQuery(".jumbo-background-color").removeClass("jumbo-background-color-active");

		return false;

	}
});
<!-- END HIDE MAIN MENU WHEN ESC BUTTON PRESSED -->

<!-- BEGIN CONVERTING DEFAULT WP MENU TO A SLIDE-DOWN ONE -->
jQuery(document).ready(function ($) {
'use strict';

	$(".jumbo-by-bonfire-secondary .menu > li").find(".sub-menu").slideUp(300);

	$('.jumbo-by-bonfire-secondary ul li ul').before($('<span><span><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><polygon id="arrow-24-icon" points="206.422,462 134.559,390.477 268.395,256 134.559,121.521 206.422,50 411.441,256 "/></svg></span></span>'));

	$(".menu > li > span, .sub-menu > li > span").on('touchstart click', function(e) {
	e.preventDefault();
		if (false == $(this).next().is(':visible')) {
			$(this).parent().siblings().find(".sub-menu").slideUp(300);
			$(this).siblings().find(".sub-menu").slideUp(300);
			$(this).parent().siblings().find("span").removeClass("jumbo-submenu-active");
		}
		$(this).next().slideToggle(300);
		$(this).toggleClass("jumbo-submenu-active");
	})
	
	
	$(".menu > li > span").on('touchstart click', function(e) {
	e.preventDefault();
		if($(".sub-menu > li > span").hasClass('jumbo-submenu-active'))
			{
				$(".sub-menu > li > span").removeClass("jumbo-submenu-active");
			}
	})
	
	$(".jumbo-secondary-menu-button").on('touchstart click', function(e) {
		if($(".menu > li > span, .sub-menu > li > span").hasClass('jumbo-submenu-active'))
			{
				$(".menu > li").find(".sub-menu").slideUp(300);
				$(".menu > li > span, .sub-menu > li > span").removeClass("jumbo-submenu-active");
			}
	})
	
});
<!-- END CONVERTING DEFAULT WP MENU TO A SLIDE-DOWN ONE -->

<!-- BEGIN HIDE MENU DESCRIPTION DIV IF NO DESCRIPTION ENTERED -->
jQuery(document).ready(function() { jQuery('.bonfire-jumbo-main-desc:empty').remove(); });
<!-- END HIDE MENU DESCRIPTION DIV IF NO DESCRIPTION ENTERED -->
<!-- BEGIN HIDE MENU WHEN MENU ITEM CLICKED -->
jQuery('.jumbo-by-bonfire ul li a').on('click', function(e) {
'use strict';
		if(jQuery('.jumbo-background-color').hasClass('jumbo-background-color-active'))
		{
			/* turn menu button into default state */
			jQuery(".jumbo-menu-button").removeClass("jumbo-menu-button-active");
			/* hide main menu */
			jQuery(".jumbo-by-bonfire-wrapper, .jumbo-main-menu-wrapper").removeClass("jumbo-menu-active").addClass("jumbo-animation-out");
			jQuery(".jumbo-dot-overlay").removeClass("jumbo-dot-overlay-active").addClass("jumbo-animation-out");
			jQuery(".jumbo-background-image").removeClass("jumbo-background-image-active");
			jQuery(".jumbo-background-color").removeClass("jumbo-background-color-active");
			}
});
<!-- END HIDE MENU WHEN MENU ITEM CLICKED -->
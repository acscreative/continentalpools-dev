<?php global $minti_data; ?>

<div class="social-icons clearfix">
	<ul>
		<?php if($minti_data['social_dribbble'] != "") { ?>
			<li><a href="<?php echo esc_url($minti_data['social_dribbble']); ?>" target="_blank" title="<?php _e( 'Dribbble', 'minti' ) ?>"><i class="fa fa-dribbble"></i></a></li>
		<?php } ?>
		<?php if($minti_data['social_facebook'] != "") { ?>
			<li><a href="<?php echo esc_url($minti_data['social_facebook']); ?>" target="_blank" title="<?php _e( 'Facebook', 'minti' ) ?>"><i class="fa fa-facebook"></i></a></li>
		<?php } ?>
		<?php if($minti_data['social_foursquare'] != "") { ?>
			<li><a href="<?php echo esc_url($minti_data['social_foursquare']); ?>" target="_blank" title="<?php _e( 'Foursquare', 'minti' ) ?>"><i class="fa fa-foursquare"></i></a></li>
		<?php } ?>
		<?php if($minti_data['social_flickr'] != "") { ?>
			<li><a href="<?php echo esc_url($minti_data['social_flickr']); ?>" target="_blank" title="<?php _e( 'Flickr', 'minti' ) ?>"><i class="fa fa-flickr"></i></a></li>
		<?php } ?>
		<?php if($minti_data['social_github'] != "") { ?>
			<li><a href="<?php echo esc_url($minti_data['social_github']); ?>" target="_blank" title="<?php _e( 'Github', 'minti' ) ?>"><i class="fa fa-github"></i></a></li>
		<?php } ?>
		<?php if($minti_data['social_googleplus'] != "") { ?>
			<li><a href="<?php echo esc_url($minti_data['social_googleplus']); ?>" target="_blank" title="<?php _e( 'Google+', 'minti' ) ?>"><i class="fa fa-google-plus"></i></a></li>
		<?php } ?>
		<?php if($minti_data['social_instagram'] != "") { ?>
			<li><a href="<?php echo esc_url($minti_data['social_instagram']); ?>" target="_blank" title="<?php _e( 'Instagram', 'minti' ) ?>"><i class="fa fa-instagram"></i></a></li>
		<?php } ?>
		<?php if($minti_data['social_linkedin'] != "") { ?>
			<li><a href="<?php echo esc_url($minti_data['social_linkedin']); ?>" target="_blank" title="<?php _e( 'LinkedIn', 'minti' ) ?>"><i class="fa fa-linkedin"></i></a></li>
		<?php } ?>
		<?php if($minti_data['social_pinterest'] != "") { ?>
			<li><a href="<?php echo esc_url($minti_data['social_pinterest']); ?>" target="_blank" title="<?php _e( 'Pinterest', 'minti' ) ?>"><i class="fa fa-pinterest"></i></a></li>
		<?php } ?>
		<?php if($minti_data['social_renren'] != "") { ?>
			<li><a href="<?php echo esc_url($minti_data['social_renren']); ?>" target="_blank" title="<?php _e( 'Renren', 'minti' ) ?>"><i class="fa fa-renren"></i></a></li>
		<?php } ?>
		<?php if($minti_data['social_rss'] != "") { ?>
			<li><a href="<?php echo esc_url($minti_data['social_rss']); ?>" target="_blank" title="<?php _e( 'RSS', 'minti' ) ?>"><i class="fa fa-rss"></i></a></li>
		<?php } ?>
		<?php if($minti_data['social_skype'] != "") { ?>
			<li><a href="<?php echo esc_attr($minti_data['social_skype']); ?>" target="_blank" title="<?php _e( 'Skype', 'minti' ) ?>"><i class="fa fa-skype"></i></a></li>
		<?php } ?>
		<?php if($minti_data['social_soundcloud'] != "") { ?>
			<li><a href="<?php echo esc_attr($minti_data['social_soundcloud']); ?>" target="_blank" title="<?php _e( 'Soundcloud', 'minti' ) ?>"><i class="fa fa-soundcloud"></i></a></li>
		<?php } ?>
		<?php if($minti_data['social_stackoverflow'] != "") { ?>
			<li><a href="<?php echo esc_url($minti_data['social_stackoverflow']); ?>" target="_blank" title="<?php _e( 'Stack Overflow', 'minti' ) ?>"><i class="fa fa-stack-overflow"></i></a></li>
		<?php } ?>
		<?php if($minti_data['social_twitter'] != "") { ?>
			<li><a href="<?php echo esc_url($minti_data['social_twitter']); ?>" target="_blank" title="<?php _e( 'Twitter', 'minti' ) ?>"><i class="fa fa-twitter"></i></a></li>
		<?php } ?>
		<?php if($minti_data['social_tumblr'] != "") { ?>
			<li><a href="<?php echo esc_url($minti_data['social_tumblr']); ?>" target="_blank" title="<?php _e( 'Tumblr', 'minti' ) ?>"><i class="fa fa-tumblr"></i></a></li>
		<?php } ?>
		<?php if($minti_data['social_vimeo'] != "") { ?>
			<li><a href="<?php echo esc_url($minti_data['social_vimeo']); ?>" target="_blank" title="<?php _e( 'Vimeo', 'minti' ) ?>"><i class="fa fa-vimeo-square"></i></a></li>
		<?php } ?>
		<?php if($minti_data['social_vk'] != "") { ?>
			<li><a href="<?php echo esc_url($minti_data['social_vk']); ?>" target="_blank" title="<?php _e( 'VK', 'minti' ) ?>"><i class="fa fa-vk"></i></a></li>
		<?php } ?>
		<?php if($minti_data['social_weibo'] != "") { ?>
			<li><a href="<?php echo esc_url($minti_data['social_weibo']); ?>" target="_blank" title="<?php _e( 'Weibo', 'minti' ) ?>"><i class="fa fa-weibo"></i></a></li>
		<?php } ?>
		<?php if($minti_data['social_xing'] != "") { ?>
			<li><a href="<?php echo esc_url($minti_data['social_xing']); ?>" target="_blank" title="<?php _e( 'Xing', 'minti' ) ?>"><i class="fa fa-xing"></i></a></li>
		<?php } ?>
		<?php if($minti_data['social_youtube'] != "") { ?>
			<li><a href="<?php echo esc_url($minti_data['social_youtube']); ?>" target="_blank" title="<?php _e( 'YouTube', 'minti' ) ?>"><i class="fa fa-youtube-play"></i></a></li>
		<?php } ?>
		<?php if($minti_data['ownsocial1_name'] != "") { ?>
			<li><a href="<?php echo esc_url($minti_data['ownsocial1_url']); ?>" target="_blank" title="<?php echo esc_attr($minti_data['ownsocial1_name']); ?>"><i class="fa <?php echo esc_attr($minti_data['ownsocial1_icon']); ?>"></i></a></li>
		<?php } ?>
		<?php if($minti_data['ownsocial2_name'] != "") { ?>
			<li><a href="<?php echo esc_url($minti_data['ownsocial2_url']); ?>" target="_blank" title="<?php echo esc_attr($minti_data['ownsocial2_name']); ?>"><i class="fa <?php echo esc_attr($minti_data['ownsocial2_icon']); ?>"></i></a></li>
		<?php } ?>
	</ul>
</div>
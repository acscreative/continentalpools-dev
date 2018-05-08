<form action="<?php echo esc_url( home_url( '/' ) ); ?>" id="searchform" method="get">
	<input type="text" id="s" name="s" value="<?php _e('To search type and hit enter', 'minti') ?>" onfocus="if(this.value=='<?php _e('To search type and hit enter', 'minti') ?>')this.value='';" onblur="if(this.value=='')this.value='<?php _e('To search type and hit enter', 'minti') ?>';" autocomplete="off" />
	<input type="submit" value="<?php _e('Search', 'minti') ?>" id="searchsubmit" />
</form>
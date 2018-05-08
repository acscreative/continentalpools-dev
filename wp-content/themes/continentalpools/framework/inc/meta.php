<?php global $minti_data; ?>
<?php if($minti_data['switch_metadata'] == '1') { ?>
<ul>
	<?php if($minti_data['check_metadata']['date'] == '1') { ?>	
		<li class="meta-date"><?php the_time(get_option('date_format')); ?></li>
	<?php } ?>
	<?php if($minti_data['check_metadata']['author'] == '1') { ?>
		<li class="meta-author"><a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta( 'ID' ))); ?>" title="<?php _e('View all posts by', 'minti'); ?> <?php the_author(); ?>"><?php the_author(); ?></a></li>
	<?php } ?>
	<?php if($minti_data['check_metadata']['comments'] == '1') { ?>
		<?php if ( comments_open() ) : ?><li class="meta-comment"><?php comments_popup_link(__('No Comments', 'minti'), __('1 Comment', 'minti'), __('% Comments', 'minti'), 'comments-link', ''); ?></li><?php endif; ?>
	<?php } ?>
	<?php if($minti_data['check_metadata']['categories'] == '1') { ?>
	<li class="meta-category"><?php the_category(', '); ?></li>
	<?php } ?>
	<?php if($minti_data['check_metadata']['tags'] == '1') { ?>
		<?php if(is_single()){ ?>
	    <?php if(has_tag()) { ?><li class="meta-tags"><?php the_tags( '', ', ', ''); ?></li><?php } ?>
	    <?php } ?>
	<?php } ?>
</ul>
<?php } ?>
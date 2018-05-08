<?php
/*
Template Name: Applied
*/

if (!empty($_REQUEST['_st']) && !empty($_REQUEST['_a'])) :
	global $wpdb;
	$region_id = $wpdb->get_var($wpdb->prepare("SELECT loc_rgnRecordId FROM OfficeLocation WHERE loc_State = %s AND loc_Area = %s", urldecode($_REQUEST['_st']), urldecode($_REQUEST['_a'])));
	$interview_url = $wpdb->get_var($wpdb->prepare("SELECT rgn_ScheduleInterviewURL FROM Region WHERE rgn_RecordId = %s", $region_id));
else :
	$interview_url = home_url('/lifeguards/how-to-apply/set-your-interview/');
endif;


get_header(); 

// Layout
$sidebar = get_post_meta( get_the_ID(), 'minti_layout', true );

if($sidebar == 'default'){
	$sidebarlayout = 'sixteen columns';
} 
elseif($sidebar == 'fullwidth'){
	$sidebarlayout = 'page-section nopadding';
}
elseif($sidebar == 'sidebar-left'){
	$sidebarlayout = 'sidebar-left twelve alt columns';
}
elseif($sidebar == 'sidebar-right'){
	$sidebarlayout = 'sidebar-right twelve alt columns';
} 
else{
	$sidebarlayout = 'sixteen columns';
} ?>

<div id="page-wrap" <?php if($sidebar != 'fullwidth'){ echo 'class="container"'; } ?> >

	<div id="content" class="<?php echo esc_attr($sidebarlayout); ?>">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<?php the_content(); ?>
		
		<h2>We've received your contact information</h2>
		<p>Please be on the lookout for an email with your login credentials.</p>
		<p>Know someone else who might be interested?</p>
		<p>Tell them about us and you could receive $50 for each referral.</p>
		<a class="button bg-red" style="text-decoration: none; font-size: 1.25em;" href="https:/www.continentalpools.com/lifeguards/how-to-apply/refer-a-friend/" rel="noopener" target="_blank">Refer a Friend</a>

		<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>

		<?php if($minti_data['switch_comments'] == 1) { ?>
			<?php comments_template(); ?>
		<?php } ?>

		<?php endwhile; endif; ?>
			<?php dynamic_sidebar(‘footerwave’); ?>
	</div> <!-- end content -->

	<?php if($sidebar == 'sidebar-left' || $sidebar == 'sidebar-right'){ ?>
	<div id="sidebar" class="<?php echo esc_attr($sidebar); ?> alt">
		<?php get_sidebar(); ?>
	</div>
	<?php } ?>

</div> <!-- end page-wrap -->
	
<?php get_footer(); ?>
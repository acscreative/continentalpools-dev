<?php /* Template Name: Blank Page */ ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php wp_title('| ', true, 'right'); ?></title>
<!-- Mobile Specific Metas & Favicons -->
<?php global $minti_data; ?>
<?php if($minti_data['switch_zoom'] == 0) { ?><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"><?php } else { ?><meta name="viewport" content="width=1200" /><?php } ?>
<?php if($minti_data['media_favicon']['url'] != "") { ?><link rel="shortcut icon" href="<?php echo esc_url($minti_data['media_favicon']['url']); ?>"><?php } ?>
<?php if($minti_data['media_favicon_iphone']['url'] != "") { ?><link rel="apple-touch-icon" href="<?php echo esc_url($minti_data['media_favicon_iphone']['url']); ?>"><?php } ?>
<?php if($minti_data['media_favicon_iphone_retina']['url'] != "") { ?><link rel="apple-touch-icon" sizes="120x120" href="<?php echo esc_url($minti_data['media_favicon_iphone_retina']['url']); ?>"><?php } ?>
<?php if($minti_data['media_favicon_ipad']['url'] != "") { ?><link rel="apple-touch-icon" sizes="76x76" href="<?php echo esc_url($minti_data['media_favicon_ipad']['url']); ?>"><?php } ?>
<?php if($minti_data['media_favicon_ipad_retina']['url'] != "") { ?><link rel="apple-touch-icon" sizes="152x152" href="<?php echo esc_url($minti_data['media_favicon_ipad_retina']['url']); ?>"><?php } ?>
<!-- WordPress Stuff -->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="page-wrap">

		<div id="content" class="nopadding page-section">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<div class="table-outer">
					
				<div class="table-inner">
						
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<div class="entry">

							<?php the_content(); ?>

						</div>

					</article>

				</div>

			</div>

			<?php endwhile; endif; ?>
		</div> <!-- end content -->

	</div> <!-- end page-wrap -->
	
	<?php wp_footer(); ?>
	
</body>
</html>
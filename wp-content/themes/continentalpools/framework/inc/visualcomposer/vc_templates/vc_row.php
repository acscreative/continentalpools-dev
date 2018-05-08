<?php

extract(shortcode_atts(array(
	'type' => 'standard_section',
	'bg_image'=> '', 
	'bg_position'=> '', 
	'bg_repeat' => 'stretch', 
	'parallax_bg' => '',
	'stellar_class' => 'default', 
	'bg_color'=> '',
	'section_arrow'=> '',
	'text_align'=> 'left', 
	'vertically_center_columns' => '',
	'video_bg'=> '', 
	'enable_video_color_overlay'=> '', 
	'video_overlay_color'=> '', 
	'video_webm'=> '', 
	'video_mp4'=> '', 
	'video_ogv'=> '', 
	'video_image'=> '', 
	'top_padding' => '', 
	'bottom_padding' => '',
	'text_color' => 'dark',  
	'custom_text_color' => '',
	'full_height' => '', 
	'content_placement' => 'middle', 
	'row_id' => '',
	'angled_section' => '',
	'class' => ''), 
$atts));

wp_enqueue_style( 'js_composer_front' );
wp_enqueue_script( 'wpb_composer_front_js' );
wp_enqueue_style('js_composer_custom_css');

$style = null;
$bg_stretch_class = null;
$main_class = null;
$set_row_id = null;
$height_class = null;
$heightcontent_class = null;

if($stellar_class == 'fixed') {
	$stellar_class = '0';
} else{
	$stellar_class = '1';
}

// Background Image
if(!empty($bg_image)) {
	if(!preg_match('/^\d+$/',$bg_image)){
		$style .= 'background-image: url('. $bg_image . '); ';
		//$style .= 'background-position: '. $bg_position .'; ';
	
	} else {
		$bg_image_src = wp_get_attachment_image_src($bg_image, 'full');
		$style .= 'background-image: url('. $bg_image_src[0]. '); ';
		//$style .= 'background-position: '. $bg_position .'; ';
	}

	//for pattern bgs
	if($bg_repeat == 'repeat'){
		$style .= 'background-repeat: '. $bg_repeat .'; ';
		$bg_stretch_class = null;
	} else if($bg_repeat == 'no-repeat'){
		$style .= 'background-repeat: '. $bg_repeat .'; ';
		$bg_stretch_class = null;
	} else if($bg_repeat == 'stretch'){
		$style .= null;
		$bg_stretch_class = 'bg-stretch';
	}
}

// Background Color
if(!empty($bg_color)) {
	$style .= 'background-color: '. $bg_color.'; ';
}

// Section ID
if(!empty($row_id)) {
	$set_row_id .= 'id="'. $row_id.'"';
}

// Parallax
if(strtolower($parallax_bg) == 'true' && $video_bg != 'true'){
	$parallax_class = 'section-parallax';
} else {
	$parallax_class = 'section-no-parallax';
}

// Padding
if($top_padding != ''){
	$style .= 'padding-top: '. $top_padding .'px; ';
}
if($bottom_padding != ''){
	$style .= 'padding-bottom: '. $bottom_padding .'px; ';
}

// Main Class
if($type == 'standard_section'){
	$main_class = "standard-section section ";
} else if($type == 'full_width_section'){
	$main_class = "full-width-section section ";
}

// Text-Align
if($text_align == 'center'){
	$text_align = "text-align-center";
} else if($text_align == 'right'){
	$text_align = "text-align-right";
}

// Text-Color
if($text_color == 'light'){
	$text_color = 'color-light';
} else if($text_color == 'dark'){
	$text_color = 'color-dark';
}

// Custom Text Color
if($text_color == 'custom' && !empty($custom_text_color)) {
	$style .= 'color: '. $custom_text_color .'; ';
	$text_color = 'color-custom';
}

// Full Height
if ( ! empty( $full_height ) ) {
	$height_class = ' vc_row-o-full-height';
	if ( ! empty( $content_placement ) ) {
		$heightcontent_class = ' vc_row-o-content-' . $content_placement;
	}
}

echo '<div '.$set_row_id.' class="wpb_row vc_row-fluid '. esc_attr($main_class) .' '. esc_attr($parallax_class) .' '. esc_attr($class) . ' '.esc_attr($bg_repeat).' '.esc_attr($bg_stretch_class).' '.esc_attr($height_class).' '.esc_attr($heightcontent_class).'" data-speed="'.esc_attr($stellar_class).'" style="'.$style.'">'; // Don't escape $set_row_id and $style

//video bg
if($video_bg) {

	wp_enqueue_script('wp-mediaelement');
	wp_enqueue_style('wp-mediaelement');

	$out = null;

	if($enable_video_color_overlay == 'true'){
		$out .=  '<div class="video-overlay" style="background-color: '. esc_attr($video_overlay_color) .';"></div>';
	}
	
	if($video_image){
		$video_image_src = wp_get_attachment_image_src($video_image, 'full');
		$out .=  '<div class="video-fallback" style="background-image: url('. esc_url($video_image_src[0]) .')"></div>';
	}
	
	$out .= '
	<div class="video-wrap">
		<video width="1920" height="800" preload="auto" autoplay loop muted="muted">';
		    if(!empty($video_webm)) { $out .= '<source src="'. esc_url($video_webm) .'" type="video/webm">'; }
		    if(!empty($video_mp4)) { $out .= '<source src="'. esc_url($video_mp4) .'" type="video/mp4">'; }
		    if(!empty($video_ogv)) { $out .= '<source src="'. esc_url($video_ogv) .'" type="video/ogg">'; }
	$out .='
		</video>
	</div>';
	
	echo $out;
}

echo '<div class="col span_12 '.esc_attr($text_color).' '.esc_attr($text_align).'">'.do_shortcode($content).'</div>';
echo '</div>';

if($section_arrow == true) {
	echo '<div class="section-triangle"><div class="section-triangle-color" style="border-color: ' . esc_attr($bg_color) . ' transparent transparent transparent;"></div></div>';
}
	
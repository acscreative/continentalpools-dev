<?php
$output = $el_class = $width = '';
extract(shortcode_atts(array(
    'el_class' => '',
    'width' => '1/1',
    'css' => '',
    'animation' => 'none', 
    'delay' => '',
	'column_padding' => 'no-padding',
	'column_custompadding' => '0px 0px 0px 0px',
	'bg_color' => '',
	'bg_image' => '',
	'column_center' => '',
	'text_color' => 'dark',
	'custom_text_color' => '',
	'text_align'=> 'left',
), $atts));

$el_class = $this->getExtraClass($el_class);
$width = wpb_translateColumnWidthToSpan($width);
$style = null;
$column_animation = null;

$el_class .= ' wpb_column column_container col';

// Vertically Center
if($column_center == 'true'){
	$el_class .= ' vertical-center';
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

// Text-Align
if($text_align == 'center'){
	$el_class .= " text-align-center";
} else if($text_align == 'right'){
	$el_class .= " text-align-right";
}

// Background Color
if(!empty($bg_color)) {
	$style .= 'background-color: '. $bg_color.'; ';
}

// Background Image
if(!empty($bg_image)) {
	$bg_image_src = wp_get_attachment_image_src($bg_image, 'full');
	$style .= 'background-image: url('. $bg_image_src[0]. '); ';
}

// Column Padding
if($column_padding == 'custom-padding'){
	$style .= 'padding: ' . $column_custompadding . '; ';
	$el_class .= ' custom-padding';
} else {
	$el_class .= ' '. $column_padding;
}


// Animation
if(!empty($animation) && $animation != 'none') {
	 $el_class .= ' animate';
	
	 $column_animation = str_replace(" ","-",$animation);
	 $delay = intval($delay);
}

$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width.$el_class, $this->settings['base']);
$output .= "\n\t".'<div class="'.esc_attr($css_class).' '.esc_attr($text_color).'" style="'.esc_attr($style).'" data-animation="'.esc_attr($column_animation).'" data-delay="'.esc_attr($delay).'">';
$output .= "\n\t\t".'<div class="wpb_wrapper">';
$output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
$output .= "\n\t".'</div> '.$this->endBlockComment($el_class) . "\n";

echo $output;
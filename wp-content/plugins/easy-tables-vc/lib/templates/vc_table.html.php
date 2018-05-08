<?php
if(!function_exists('convert_encode_chars')) {
    function convert_encode_chars($string) {
        return preg_replace('/\&amp\;(\#|cent|pound|yen|euro|sect|copy|reg|trade)/', '&$1', $string);
    }
}

$custom_css = $el_class = $vc_table_theme = '';
extract(shortcode_atts(array(
    'vc_table_theme' => '',
    'el_class' => '',
    'allow_html' => false
    ), $atts));
if(empty($content)) {
    echo '<table><tr><td>Empty table</td></tr></table>';
    return;
}
if(!empty($vc_table_theme)) {
    $custom_css = ' class="vc-table-plugin-theme-'.$vc_table_theme.'"';
}
if(!empty($el_class)) {
    $el_class .= ' '.$el_class;
}
$table_data = vc_table_parse_table_param($content);
$el_class = $this->getExtraClass($el_class);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_vc_table wpb_content_element'.$el_class, $this->settings['base']);

$output = '<div class="'.$css_class.'">';
$output .= '<table'.$custom_css.'>';
foreach($table_data as $index => $row) {
    $output .= '<tr'.($index===0 ? ' class="vc-th"' : '').'>';
    foreach($row as $cell) {
        $style = empty($cell['css_style']) ? '' : ' style="' . implode('', $cell['css_style']) . '"';
        $class = empty($cell['css_class']) ? '' : ' class="'. implode(' ', $cell['css_class']) . '"';
		$cell_content = $cell['content'];
		if ( empty( $allow_html ) ) {
			$cell_content = convert_encode_chars( htmlspecialchars( $cell_content ) );
		}
		$cell_content = apply_filters( 'wpb_vc_table_manager_table_content', $cell_content, $cell );
	    $output .= '<td' . $style . $class . '><span class="vc_table_content">' . $cell_content . '</span></td>';
    }
    $output .= '</tr>';
}
$output .= '</table>';
$output .= '</div>';
echo $output;
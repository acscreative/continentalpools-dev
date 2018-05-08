<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>

<?php 
	
	$startdate = get_field('start_date', false, false);
	$startdate = new DateTime($startdate);
	
	$enddate = get_field('end_date', false, false);
	$enddate = new DateTime($enddate);
	?>

<?php
    
    if (get_field('start_date')) :
        echo '<div id="notes-section"> ';
        echo $startdate->format('F j, Y');        
    else:
        echo '';
    endif; 

    if (get_field('end_date')) :
        echo ' - ';
        echo $enddate->format('F j, Y'); 
        echo '<br/>';
    else:
        echo '<br/>';
    endif; 

    if (get_field('facility')) :
        echo ' ';
        the_field('facility');
        echo '';
    else:
        echo '';
    endif; 

    if (get_field('address')) :
        echo '<br/>';
        the_field('address');
        echo '</p></div>';
    else:
        echo '</p></div>';
    endif; 
    
?>



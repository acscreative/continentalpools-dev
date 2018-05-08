<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

if ( ! $post->post_excerpt ) {
	return;
}

?>
<div class="woocommerce-product-details__short-description">
    <?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ); ?>
</div>
<?php 
	
	$startdate = get_field('start_date', false, false);
	$startdate = new DateTime($startdate);
	
	$enddate = get_field('end_date', false, false);
	$enddate = new DateTime($enddate);
	?>

<?php
    
    if (get_field('start_date')) :
        echo '<strong>Start Date:</strong> ';
        echo $startdate->format('F j, Y');        
        echo '<br/>';
    else:
        echo 'A start date has not been confirmed.';
    endif; 

    if (get_field('end_date')) :
        echo '<strong>End Date:</strong> ';
        echo $startdate->format('F j, Y'); 
        echo '<br/>';
    else:
        echo 'An end date has not been confirmed.';
    endif; 

    if (get_field('facility')) :
        echo '<strong>Facility:</strong> ';
        the_field('facility');
        echo '<br/>';
    else:
        echo '<p>An end date has not been confirmed.';
    endif; 

    if (get_field('address')) :
        echo '<strong>Address:</strong> ';
        the_field('address');
        echo '</p>';
    else:
        echo '</p>';
    endif; 
    
    if (get_field('notes')) :
        echo '<strong>Notes:</strong><br/> ';
        the_field('notes');
        echo '</p>';
    else:
        echo '</p>';
    endif; 
?>
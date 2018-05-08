<?php

// loads the shortcodes class, wordpress is loaded with it
require_once( 'shortcodes.class.php' );

// get popup type
$popup = trim( $_GET['popup'] );
$shortcode = new minti_shortcodes( $popup );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<div id="minti-popup">

	<div id="minti-shortcode-wrap">
		
		<div id="minti-sc-form-wrap">
		
			<div id="minti-sc-form-head">
			
				<?php echo $shortcode->popup_title; // No escape needed. No user content ?>
			
			</div>
			<!-- /#minti-sc-form-head -->
			
			<form method="post" id="minti-sc-form">
			
				<table id="minti-sc-form-table">
				
					<?php echo $shortcode->output; // No escape needed. No user content  ?>
					
					<tbody>
						<tr class="form-row">
							<?php if( ! $shortcode->has_child ) : ?><td class="label">&nbsp;</td><?php endif; ?>
							<td class="field"><a href="#" class="button-primary minti-insert">Insert Shortcode</a></td>							
						</tr>
					</tbody>
				
				</table>
				<!-- /#minti-sc-form-table -->
				
			</form>
			<!-- /#minti-sc-form -->
		
		</div>
		<!-- /#minti-sc-form-wrap -->
		
		<div class="clear"></div>
		
	</div>
	<!-- /#minti-shortcode-wrap -->

</div>
<!-- /#minti-popup -->

</body>
</html>
<?php
/*
Template Name: Quick Apply
*/
add_action( 'wp_head', 'szbl_recap' );
function szbl_recap()
{
?>
<script src='https://www.google.com/recaptcha/api.js'></script>
<?php
}

get_header();
the_post();

global $wpdb;
$wpdb->show_errors = true;
$wpdb->display_errors = true;
$work_states = $wpdb->get_col( "SELECT DISTINCT loc_State as State FROM OfficeLocation ORDER BY loc_State ASC" );

$states = $wpdb->get_results( "SELECT stpr_Name as Name, stpr_Abbrev as State FROM StateProvince ORDER BY Name ASC" );

$locations = $wpdb->get_results( "SELECT * FROM OfficeLocation ORDER BY loc_State ASC, loc_Area ASC" );

global $clean;

function gfl_output_value( $name )
{
	global $clean;
	$dob = $_POST['data']['DOB'];
	if ( !$clean )
		$clean = stripslashes_deep( $_POST['data'] );
	$clean['DOB'] = $dob;
	
	if ( isset( $clean[ $name ] ) )
		echo $clean[ $name ];

	return false;
}

$errors = array();

if ( isset( $_POST['szbl-nonce'] ) && wp_verify_nonce( $_POST['szbl-nonce'], 'submit-apply' ) )
{
	$clean = stripslashes_deep( $_POST['data'] );

	// $clean = array();
	if ( empty( $clean['FirstName'] ) ) 
	{
		$errors['FirstName'] = 'Enter your first name.';
	}
	if ( empty( $clean['LastName'] ) ) 
	{
		$errors['LastName'] = 'Enter your last name.';
	}

	if ( empty( $clean['HomePhone'] ) && empty( $clean['MobilePhone'] ) )
	{
		$errors['MobilePhone'] = 'At least one phone number is required.';
	}
	else 
	{
		$clean_phone = preg_replace( '/[^\\d]/', '', $clean['MobilePhone'] );
		if ( !empty( $clean['MobilePhone'] ) )
		{
			if ( strlen( $clean_phone ) != 10 ) 
			{
				$errors['MobilePhone'] = 'Enter your 10-digit mobile phone.';
			}
			elseif ( 10 == strlen( $clean_phone ) )
			{
				// $clean['MobilePhone'] = preg_replace( '/(\\d{3})(\\d{3})(\\d{4})/', '($1) $2-$3', $clean_phone );
				$clean['MobilePhone'] = $clean_phone;
			}
		}
		
		$clean_phone = preg_replace( '/[^\\d]/', '', $clean['HomePhone'] );
		if ( !empty( $clean['HomePhone'] ) && strlen( $clean_phone ) != 10 ) 
		{
			$errors['HomePhone'] = 'Enter your 10-digit home phone.';
		}
		elseif ( strlen( $clean_phone ) == 10 )
		{
			// $clean['HomePhone'] = preg_replace( '/(\\d{3})(\\d{3})(\\d{4})/', '($1) $2-$3', $clean_phone );
			$clean['HomePhone'] = $clean_phone;
		}
	}

	if ( empty( $clean['Address'] ) ) 
	{
		$errors['Address'] = 'Enter your address.';
	}
	if ( empty( $clean['City'] ) ) 
	{
		$errors['City'] = 'Enter your city.';
	}
	if ( empty( $clean['State'] ) ) 
	{
		$errors['State'] = 'Enter your state.';
	}
	if ( empty( $clean['Zip'] ) ) 
	{
		$errors['Zip'] = 'Enter your zip.';
	}
	if ( !is_email( $clean['Email'] ) ) 
	{
		$errors['Email'] = 'Enter a valid email address.';
	}
	if ( empty( $clean['PositionName'] ) ) 
	{
		$errors['PositionName'] = 'Please choose the position you would like.';
	}
	if ( empty( $clean['Certind'] ) ) 
	{
		$errors['Certind'] = 'Please select if you are certified or not.';
	}
	if ( empty( $clean['WorkState'] ) ) 
	{
		$errors['WorkState'] = 'Please select the state in which you would like to work.';
	}
	if ( empty( $clean['WorkArea'] ) ) 
	{
		$errors['WorkArea'] = 'Please select the area in which you would like to work.';
	}

	$clean['g-recaptcha-response'] = stripslashes( $_POST['g-recaptcha-response'] );

	if ( empty( $clean['g-recaptcha-response'] ) )
	{
		$errors['Captcha'] = 'Please use the CAPTCHA to confirm you are a human.';
	}
	else
	{
		$resp = wp_remote_post( 
			'https://www.google.com/recaptcha/api/siteverify',
			array(
				'body' => array(
					'secret' => '6LcGPEUUAAAAAIq0lknZKKH30MZxpD5I9QE3ClBC',
					'response' => $clean['g-recaptcha-response'],
					'remoteip' => $_SERVER['REMOTE_ADDR']
				)
			)
		);

		$ack = json_decode( $resp['body'] );
		if ( !$ack->success )
		{
			$errors['Captcha'] = 'Could not confirm CAPTCHA. Please re-enter/submit.';
		}
	}

	// get application year based on Work State/Area
	$apply_year = $wpdb->get_var( $wpdb->prepare("
		SELECT	apcc_GuardYear
		FROM	OfficeInfo
		WHERE	apcc_Secterr = (
			SELECT loc_Secterr
			FROM OfficeLocation
			WHERE loc_State = %s AND loc_Area = %s
		)
	", $clean['WorkState'], $clean['WorkArea'] ) );

	// check for duplicates
	if ( count( $errors ) <= 0 )
	{
		$clean['DOB'] = date("Y-m-d", strtotime(str_replace(' ', '', $clean['DOB'])));
		$existing = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM GuardApply WHERE grd_ApplyYear = %d AND LOWER( grd_Email ) = LOWER( %s )", $apply_year, $clean['Email'] ) );
		if ( $existing ) 
		{
			foreach ( $existing as $row )
			{
				$name_db = preg_replace( '/[^a-zA-Z]/', '', $row->grd_FirstName );
				$name_form = preg_replace( '/[^a-zA-Z]/', '', $clean['FirstName'] );

				if ( strtolower( $name_db ) != strtolower( $name_form ) )
					continue;

				$name_db = preg_replace( '/[^a-zA-Z]/', '', $row->grd_LastName );
				$name_form = preg_replace( '/[^a-zA-Z]/', '', $clean['LastName'] );
				
				if ( strtolower( $row->grd_LastName ) != strtolower( $clean['LastName'] ) )
					continue;

				$redirect = home_url('/lifeguards/how-to-apply/applied/');
				$redirect .= '?_st=' . rawurlencode( $clean['WorkState'] ) . '&_a=' . rawurlencode( $clean['WorkArea'] );

				//wp_dump( $redirect );
				wp_redirect( $redirect, 303 );
				die;
			}
		}
	}

	if ( count( $errors ) <= 0 )
	{
		$data = array();
		foreach ( $clean as $k => $v )
		{
			if ( $k == 'Zip' )
				$k = 'ZipCode';

			if ( in_array( $k, array( 'g-recaptcha-response' ) ) )
			{
				continue;
			}
			$data[ 'grd_' . $k ] = $v;
		}
		
		$data['grd_SubmitDate'] = date_i18n( 'YmdHis' );

		if (!empty($data['grd_SrcCRMCode'])) :
			$source = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ApplicantSource WHERE src_CRMCode = %s", $data['grd_SrcCRMCode'] ) );
			if (!empty($source->src_Description)) :
				$data['grd_SourceDescription'] = $source->src_Description;
			endif;
		endif;
		
		$resp = $wpdb->insert( 'GuardApply', $data );
		
		$redirect = home_url( '/lifeguards/how-to-apply/applied/' );
		
		if ( $url = get_post_meta( get_the_ID(), 'redirect_url', true ) )
		{
			$redirect = $url;
		}
		$redirect .= '?_st=' . rawurlencode( $clean['WorkState'] ) . '&_a=' . rawurlencode( $clean['WorkArea'] );

		$content = get_field( 'email_content' );
		
		$keys = array_keys( $clean );
		foreach ( $keys as $k => $v )
		{
			$keys[ $k ] = '{' . $v . '}';
		}

		$content = str_replace( $keys, $clean, $content );

		ob_start();
		include get_stylesheet_directory() . '/emails/email-template.html';
		//include __DIR__ . '/lib/views/email-template.php';
		$content = ob_get_contents();
		ob_end_clean();

		wp_mail( $clean['Email'], 'Thank you for your interest in Continental Pools', $content, array( 'Content-Type: text/html' ) );

		wp_redirect( $redirect, 303 );
		die;
	}
}

$applicant_sources = $wpdb->get_results("SELECT * FROM ApplicantSource");
?>
<div id="quick-apply-page">
	<section class="aligncenter" id="page-banner">
		<div class="bin">
			<?php if ( count( $errors ) > 0 ) : ?>
				<div class="message errors">
					<h4>Error(s) occurred with your submission!</h4>
					<p><?php echo implode( '<br>', $errors ); ?></p>
				</div>
			<?php endif; ?>
			
			<div>
				
				<?php if ( !post_password_required() ) : ?>

				<form method="post" action="">
					<div class="row">
						<div class="col">
							<p>
								<label for="FirstName">
									First Name
								</label>
								<input type="text" required name="data[FirstName]" id="FirstName" value="<?php gfl_output_value( 'FirstName' ); ?>">
							</p>
						</div>
						<div class="col">
							<p>
								<label for="LastName">
									Last Name
								</label>
								<input type="text" required name="data[LastName]" id="LastName" value="<?php gfl_output_value( 'LastName' ); ?>">
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<p>
								<label for="MobilePhone">
									Mobile Phone
								</label>
								<input type="text" name="data[MobilePhone]" id="MobilePhone" value="<?php gfl_output_value( 'MobilePhone' ); ?>">
							</p>
						</div>
						<div class="col">
							<p>
								<label for="HomePhone">
									Home Phone
								</label>
								<input type="text" name="data[HomePhone]" id="HomePhone" value="<?php gfl_output_value( 'HomePhone' ); ?>">
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<p>
								<label for="Address">
									Address
								</label>
								<input type="text" required name="data[Address]" id="Address" value="<?php gfl_output_value( 'Address' ); ?>">
							</p>
						</div>
						<div class="col">
							<p>
								<label for="City">
									City
								</label>
								<input type="text" required name="data[City]" id="City" value="<?php gfl_output_value( 'City' ); ?>">
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<p>
								<label for="State">
									State
								</label>
								<select required id="State" name="data[State]">
								<option value="">Choose a State</option>
								<?php foreach ( $states as $state ) : ?>
									<option <?php selected( $state->State, $_POST['data']['State'] ); ?> value="<?php echo esc_attr( $state->State ); ?>"><?php echo esc_html( $state->Name );?></option>
								<?php endforeach; ?>
							</select>
								<!-- <input type="text" required maxlength="2" size="2" name="data[State]" id="State" value="<?php gfl_output_value( 'State' ); ?>"> -->
							</p>
						</div>
						<div class="col">
							<p>
								<label for="Zip">
									Zip
								</label>
								<input type="text" required maxlength="5" name="data[Zip]" id="Zip" value="<?php gfl_output_value( 'Zip' ); ?>">
							</p>
						</div>
					</div>

					<div class="row">
						<div class="col">
							<p>
								<label for="Email">
									Email
								</label>
								<input type="email" required name="data[Email]" id="Email" value="<?php gfl_output_value( 'Email' ); ?>">
							</p>
						</div>
						<div class="col">
							<p>
								<label for="DOB">
									Date of Birth
								</label>
								<input type="text" placeholder="MM/DD/YYYY" required name="data[DOB]" id="DOB" value="<?php gfl_output_value( 'DOB' ); ?>">
							</p>
						</div>
					</div>
					<div class="row aligncenter">
						<div class="col">
							<p>
								<label for="PositionName">
									Position of Interest *
								</label>
								<select name="data[PositionName]" id="PositionName">
									<option <?php selected( '', $_POST['data']['PositionName'] ); ?> value="">Choose a Position</option>
									<?php
										$options = $wpdb->get_results("SELECT * FROM GuardPosition ORDER BY PositionSequence ASC");
										foreach ( $options as $option ) :
									?>
										<option value="<?php echo esc_attr( $option->Position ); ?>" <?php selected( $_POST['data']['PositionName'], $option->Position ); ?>><?php
											echo esc_html( $option->Position );
										?></option>

									<?php endforeach; ?>

									<?php /*
									<option <?php selected( 'Lifeguard', $_POST['data']['PositionName'] ); ?> value="Lifeguard">Lifeguard</option>
									<option <?php selected( 'Gate Guard', $_POST['data']['PositionName'] ); ?> value="Gate Guard">Gate Guard</option>
									<option <?php selected( 'Supervisor', $_POST['data']['PositionName'] ); ?> value="Supervisor">Supervisor</option>
									*/ ?>
								</select>
							</p>
						</div>
						<div class="col">
							<strong>Are you certified?</strong>
							<br>
							<br>
							<label for="certYes" class="radio">
								<input type="radio" id="certYes" name="data[Certind]" value="Y" <?php checked( true, empty( $_POST['data']['Certind'] ) || $_POST['data']['Certind'] == 'Y' ); ?>>Yes
							</label>
							<label for="certNo" class="radio">
								<input type="radio" id="certNo" name="data[Certind]" value="N" <?php checked( true, $_POST['data']['Certind'] == 'N' ); ?>>No
							</label>
							<br>&nbsp;
						</div>
					</div>
					<div class="row aligncenter">
						<strong>Where would you like to work?</strong>
						<br><br>
						<div class="col">
							<label for="WorkState">Choose a Work State:</label>
							<select required id="WorkState" name="data[WorkState]">
								<option value="">Choose a State</option>
								<?php foreach ( $work_states as $state ) : ?>
									<option <?php selected( $state, $_POST['data']['WorkState'] ); ?> value="<?php echo esc_attr( $state ); ?>"><?php echo esc_html($state);?></option>
								<?php endforeach; ?>
							</select>
							<br><br>
						</div>
						<div class="col">
							<label for="WorkArea">Choose a Work Area:</label>
							<select required id="WorkArea" name="data[WorkArea]">
								<option value="">Choose a Work Area</option>
							</select>
							<br><br>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="SrcCRMCode">How did you hear about us?</label>
							<select required id="SrcCRMCode" name="data[SrcCRMCode]">
								<option value="">Choose a Source</option>
								<?php foreach ($applicant_sources as $row) : ?>
									<option value="<?=$row->src_CRMCode;?>"><?=$row->src_Description;?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="captcha">
								<div class="g-recaptcha" data-sitekey="6LcGPEUUAAAAACOqf5fEa-r25-DRzF1AmGTObecu"></div>
							</div>
						</div>
					</div>
					<div class="submit aligncenter">
						<input type="submit" value="Apply Now &rarr;" class="button">
						<?php wp_nonce_field( 'submit-apply', 'szbl-nonce' ); ?>
				</form>
				
				<?php endif; ?>

			</div>
			<div style="clear:both;text-align:center;">&nbsp;</div>
		</div>
	</section>
</div>

<style type="text/css">
#quick-apply-page #page-banner .message { border: 1px solid #ccc; background: lightYellow; padding: 1em; margin-bottom: 1em; }
#quick-apply-page #page-banner .message p { margin: 1em 0 0; }
#quick-apply-page #page-banner .message.errors h4,
#quick-apply-page #page-banner .message.errors p,
#quick-apply-page #page-banner .message.errors { color: #c00; border-color: #c00; }
#quick-apply-page #page-banner .message.success h4,
#quick-apply-page #page-banner .message.success p,
#quick-apply-page #page-banner .message.success { color: #0c0; border-color: #0c0; }
#quick-apply-page #page-banner { color: #333; padding: 1em 0; }
#quick-apply-page #page-banner h1 { color: #db423d; }
#page-banner .bin { max-width: 1160px; margin: 50px auto; text-align: left; }
#page-banner div { max-width: 100%; width: 100%; }
/* #page-banner div form { margin-left: 1em; } */
#page-banner .row { clear: both; width: 100%; margin-bottom:10px;}
#page-banner .row .col { width: 50%; float: left; }
#page-banner .row .col label { font-weight: bold; }
#page-banner .row .col select {
    font-size: 1em;
    width: 87%;
    height: 47px;
}
#page-banner .row .col input[type="text"],
#page-banner .row .col input[type="email"] { width: 82%; border: 1px solid #eee; font-size: 1em; }
#page-banner .row label.radio { display: inline; font-weight: normal;}
#page-banner .row .col input[type="text"], #page-banner .row .col input[type="email"] {
    width: 82%;
    border: 1px solid #ddd;
    font-size: 1em;
}



@media (max-width: 767px) {
	#page-banner div { float: none; max-width: 100%; width: 100%; }
}
</style>

<script>
jQuery(document).ready(function($){
	var date = document.getElementById('DOB');

	function checkValue(str, max) {
	  if (str.charAt(0) !== '0' || str == '00') {
	    var num = parseInt(str);
	    if (isNaN(num) || num <= 0 || num > max) num = 1;
	    str = num > parseInt(max.toString().charAt(0)) && num.toString().length == 1 ? '0' + num : num.toString();
	  };
	  return str;
	};
	
	date.addEventListener('input', function(e) {
	  this.type = 'text';
	  var input = this.value;
	  if (/\D\/$/.test(input)) input = input.substr(0, input.length - 3);
	  var values = input.split('/').map(function(v) {
	    return v.replace(/\D/g, '')
	  });
	  if (values[0]) values[0] = checkValue(values[0], 12);
	  if (values[1]) values[1] = checkValue(values[1], 31);
	  var output = values.map(function(v, i) {
	    return v.length == 2 && i < 2 ? v + ' / ' : v;
	  });
	  this.value = output.join('').substr(0, 14);
	});
	
	date.addEventListener('blur', function(e) {
	  this.type = 'text';
	  var input = this.value;
	  var values = input.split('/').map(function(v, i) {
	    return v.replace(/\D/g, '')
	  });
	  var output = '';
	  
	  if (values.length == 3) {
	    var year = values[2].length !== 4 ? parseInt(values[2]) + 2000 : parseInt(values[2]);
	    var month = parseInt(values[0]) - 1;
	    var day = parseInt(values[1]);
	    var d = new Date(year, month, day);
	    if (!isNaN(d)) {
	      document.getElementById('result').innerText = d.toString();
	      var dates = [d.getMonth() + 1, d.getDate(), d.getFullYear()];
	      output = dates.map(function(v) {
	        v = v.toString();
	        return v.length == 1 ? '0' + v : v;
	      }).join(' / ');
	    };
	  };
	  this.value = output;
	});

	$( 'div form .col' ).each(function(){
		if ( $( 'input[type="text"],input[type="email"],select', this ).size() > 0 ) 
		{
			if ($( 'input', this ).attr( 'placeholder') != 'MM/DD/YYYY') {
				$( 'input', this ).attr( 'placeholder', $( 'label', this ).text().trim() );
			}
			//$( 'label', this ).hide();
		}
	});

	var locations = <?php echo json_encode( $locations ); ?>;

	$( '#WorkState' ).change(function(){

		var html = '<option value="">Choose a Work Area</option>';

		$( '#WorkArea' ).html( html );

		for ( var i in locations )
		{
			if ( locations[ i ].loc_State == $( this ).val() )
			{
				html += '<option value="' + locations[ i ].loc_Area + '">' + locations[ i ].loc_Area + '</option>';
			}
		}

		$( '#WorkArea' ).html( html );
	}).change();

	<?php if ( isset( $clean['WorkArea'] ) ) : ?>
	
	$( '#WorkArea option' ).each(function(){
		var value = '<?php echo $clean['WorkArea'] ?>';
		if ( $(this).val() == value )
		{
			$( this ).parent().get(0).selectedIndex = $( this ).index();
		}
	});

	<?php endif; ?>

});
</script>
<?php
 get_footer(); ?>
<?php
/*
Plugin Name: Paid Memberships Pro - Shipping Add On
Plugin URI: http://www.paidmembershipspro.com/wp/pmpro-shipping/
Description: Add shipping to the checkout page and other updates.
Version: .3.3
Author: Stranger Studios
Author URI: http://www.strangerstudios.com
 
Note that this plugin requires PMPro 1.3.19 or higher to function fully.
*/

define('PMPRO_SHIPPING_SHOW_REQUIRED', true);	//if false required fields won't have asterisks and non-required fields will say (optional)

//add a shipping address field to the checkout page with "sameas" checkbox
function pmproship_pmpro_checkout_boxes()
{	
	global $gateway, $pmpro_states, $sameasbilling, $sfirstname, $slastname, $saddress1, $saddress2, $scity, $sstate, $szipcode, $scountry, $shipping_address, $pmpro_requirebilling, $pmpro_review;	
?>
	<table id="pmpro_shipping_address_fields" class="pmpro_checkout top1em" width="100%" cellpadding="0" cellspacing="0" border="0" <?php if($pmpro_review) { ?>style="display: none;"<?php } ?> >
	<thead>
		<tr>
			<th><?php _e('Shipping Address', 'pmpro');?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
			
		<p style="margin-left:130px; display: none;" id="sameasbilling_wrapper">
			<input type="checkbox" id="sameasbilling" name="sameasbilling" value="1" <?php if(!empty($sameasbilling)) { ?>checked="checked"<?php } ?> /> 
			<label for="sameasbilling" style="float: none; font-weight: normal; cursor: pointer;">
				<?php _e('Ship to the billing address used above.', 'pmpro');?>
			</label>
		</p>
		<script>
			jQuery(document).ready(function() {				
				//checking if sameas checkbox should show
				function checkBillingAddressVisibilityForSameAsCheckbox()
				{
					var baddress = jQuery('#baddress1');
					var pmpro_shipping_address_fields = jQuery('#pmpro_shipping_address_fields');
					
					if(jQuery('#sameasbilling').is(':checked'))
					{					
						jQuery('#shipping-fields').hide();
					}
		
					if(baddress.length && baddress.is(':visible'))
					{
						jQuery('#sameasbilling_wrapper').show();
					}
					else if (pmpro_shipping_address_fields.is(':visible'))
					{
						jQuery('#sameasbilling').attr('checked', false);
						jQuery('#sameasbilling_wrapper').hide();						
						jQuery('#shipping-fields').show();
					}

					//check again in .2 seconds
					pmpro_shipping_show_sameas_timer = setTimeout(function(){checkBillingAddressVisibilityForSameAsCheckbox();}, 200);
				}								
				
				//run on page load
				checkBillingAddressVisibilityForSameAsCheckbox();
			});
		</script>
		
		<div id="shipping-fields">
			<div>
				<label for="sfirstname"><?php _e('First Name', 'pmpro');?></label>
				<input id="sfirstname" name="sfirstname" type="text" class="input <?php echo pmpro_getClassForField("sfirstname");?>" size="20" value="<?php echo esc_attr($sfirstname);?>" />
				<?php if(PMPRO_SHIPPING_SHOW_REQUIRED) { ?><span class="pmpro_asterisk"> *</span><?php } ?>
			</div>	
			
			<div>
				<label for="slastname"><?php _e('Last Name', 'pmpro');?></label>
				<input id="slastname" name="slastname" type="text" class="input <?php echo pmpro_getClassForField("slastname");?>" size="20" value="<?php echo esc_attr($slastname);?>" /> 
				<?php if(PMPRO_SHIPPING_SHOW_REQUIRED) { ?><span class="pmpro_asterisk"> *</span><?php } ?>
			</div>	
							
			<div>
				<label for="saddress1"><?php _e('Address 1', 'pmpro');?></label>
				<input id="saddress1" name="saddress1" type="text" class="input <?php echo pmpro_getClassForField("saddress1");?>" size="20" value="<?php echo esc_attr($saddress1);?>" />
				<?php if(PMPRO_SHIPPING_SHOW_REQUIRED) { ?><span class="pmpro_asterisk"> *</span><?php } ?>
			</div>
			
			<div>
				<label for="saddress2"><?php _e('Address 2', 'pmpro');?></label>
				<input id="saddress2" name="saddress2" type="text" class="input <?php echo pmpro_getClassForField("saddress2");?>" size="20" value="<?php echo esc_attr($saddress2);?>" /> 
				<?php if(!PMPRO_SHIPPING_SHOW_REQUIRED) { ?><small class="lite">(optional)</small><?php } ?>
			</div>
			
			<div>
				<label for="scity"><?php _e('City', 'pmpro');?></label>
				<input id="scity" name="scity" type="text" class="input <?php echo pmpro_getClassForField("scity");?>" size="30" value="<?php echo esc_attr($scity)?>" /> 
				<?php if(PMPRO_SHIPPING_SHOW_REQUIRED) { ?><span class="pmpro_asterisk"> *</span><?php } ?>
			</div>
			<div>
				<label for="sstate"><?php _e('State', 'pmpro');?></label>																
				<input id="sstate" name="sstate" type="text" class="input <?php echo pmpro_getClassForField("sstate");?>" size="30" value="<?php echo esc_attr($sstate)?>" /> 					
				<?php if(PMPRO_SHIPPING_SHOW_REQUIRED) { ?><span class="pmpro_asterisk"> *</span><?php } ?>
			</div>
			<div>
				<label for="szipcode"><?php _e('Postal Code', 'pmpro');?></label>
				<input id="szipcode" name="szipcode" type="text" class="input <?php echo pmpro_getClassForField("szipcode");?>" size="30" value="<?php echo esc_attr($szipcode)?>" />
				<?php if(PMPRO_SHIPPING_SHOW_REQUIRED) { ?><span class="pmpro_asterisk"> *</span><?php } ?>
			</div>	
			<div>
				<label for="scountry"><?php _e('Country', 'pmpro');?></label>
				<select name="scountry" class="<?php echo pmpro_getClassForField("scountry");?>">
					<?php
						global $pmpro_countries, $pmpro_default_country;
						foreach($pmpro_countries as $abbr => $country)
						{
							if(!$scountry)
								$scountry = $pmpro_default_country;
						?>
						<option value="<?php echo $abbr?>" <?php if($abbr == $scountry) { ?>selected="selected"<?php } ?>><?php echo $country?></option>
						<?php
						}
					?>
				</select>
				<?php if(PMPRO_SHIPPING_SHOW_REQUIRED) { ?><span class="pmpro_asterisk"> *</span><?php } ?>
			</div>
			
			<?php /* old non-long form method
			<div>
				<label for="scity_state_zip"><span class="red">*</span>City, State Zip</label>
				<input id="scity" name="scity" type="text" class="input" size="14" style="width: 125px;" value="<?php echo esc_attr($scity)?>" />, 
				
				<?php // <input id="sstate" name="sstate" type="text" class="input" size="2" value="<?php echo esc_attr($sstate)?>" /> ?>
				
				<select name="sstate">
					<option value="">--</option>
					<?php 
						$sstate = get_user_meta($user->ID, 'pmpro_sstate', true);
						foreach($pmpro_states as $ab => $st) 
						{ 
					?>
						<option value="<?=$ab?>" <?php if($ab == $sstate) { ?>selected="selected"<?php } ?>><?=$st?></option>
					<?php } ?>
				</select>
				<input id="szipcode" name="szipcode" type="text" class="input" size="5" style="width: 75px" value="<?php echo esc_attr($szipcode)?>" /> 
			</div>
			*/ ?>
		</div>	
				
		<script>
			jQuery('#sameasbilling').change(function() {				
				if(jQuery('#sameasbilling').is(':checked'))
				{					
					jQuery('#shipping-fields').hide();
				}
				else
				{
					jQuery('#shipping-fields').show();
				}
			});
		</script>

		</td>
	</tr>
	</tbody>
	</table>
<?php	
}
add_action("pmpro_checkout_after_billing_fields", "pmproship_pmpro_checkout_boxes");

//get fields on checkout page (abusing the pmpro_valid_gateways filter for this since it comes early on the checkout page)
function pmproship_pmpro_valid_gateways($gateways)
{
	global $sameasbilling, $sfirstname, $slastname, $saddress1, $saddress2, $scity, $sstate, $szipcode, $scountry, $shipping_address, $pmpro_requirebilling, $current_user;
	
	if(!empty($_REQUEST['sameasbilling']))
		$sameasbilling = true;	//we'll get the fields further down below
	elseif(!empty($_REQUEST['saddress1']))
	{
		//grab the fields entered by the user at checkout
		$sfirstname = $_REQUEST['sfirstname'];		
		$slastname = $_REQUEST['slastname'];		
		$saddress1 = $_REQUEST['saddress1'];
		if(!empty($_REQUEST['saddress2'])) {
	    	$saddress2 = $_REQUEST['saddress2'];
		}	
		$scity = $_REQUEST['scity'];
		
		$sstate = $_REQUEST['sstate'];
		
		//convert long state names to abbreviations
		if(!empty($sstate))
		{
			global $pmpro_states;
			foreach($pmpro_states as $abbr => $state)
			{
				if($sstate == $state)
				{
					$sstate = $abbr;
					break;
				}
			}
		}
		
		$szipcode = $_REQUEST['szipcode'];
		$scountry = $_REQUEST['scountry'];
	}
	elseif(!empty($_SESSION['sameasbilling']))
	{
		//coming back from PayPal. same as billing
		$sameasbilling = true;
	}
	elseif(!empty($_SESSION['saddress1']))
	{
		//coming back from PayPal. grab the fields from session
		$sfirstname = $_SESSION['sfirstname'];
		$slastname = $_SESSION['slastname'];
		$saddress1 = $_SESSION['saddress1'];
		if(!empty($_SESSION['saddress2'])) {
			$saddress2 = $_SESSION['saddress2'];
		}
		$scity = $_SESSION['scity'];
		$sstate = $_SESSION['sstate'];
		$szipcode = $_SESSION['szipcode'];
		$scountry = $_SESSION['scountry'];				
	}
    elseif(!empty($current_user->ID))
	{
        //get shipping fields from user meta
        $user_id = $current_user->ID;
        $sfirstname = get_user_meta($user_id, "pmpro_sfirstname", true);
        $slastname = get_user_meta($user_id, "pmpro_slastname", true);
        $saddress1 = get_user_meta($user_id, "pmpro_saddress1", true);
        $saddress2 = get_user_meta($user_id, "pmpro_saddress2", true);
        $scity = get_user_meta($user_id, "pmpro_scity", true);
        $sstate = get_user_meta($user_id, "pmpro_sstate", true);
        $szipcode = get_user_meta($user_id, "pmpro_szipcode", true);
        $scountry = get_user_meta($user_id, "pmpro_scountry", true);
    }

	return $gateways;
}
add_filter('pmpro_valid_gateways', 'pmproship_pmpro_valid_gateways');

//update a user meta value on checkout
function pmproship_pmpro_after_checkout($user_id)
{	
	global $sameasbilling, $sfirstname, $slastname, $saddress1, $saddress2, $scity, $sstate, $szipcode, $scountry, $shipping_address, $pmpro_requirebilling;			
	
	if(!empty($sameasbilling))
	{			
		//set the shipping fields to be the same as the billing fields		
		$sfirstname = get_user_meta($user_id, "pmpro_bfirstname", true);
		$slastname = get_user_meta($user_id, "pmpro_blastname", true);
		$saddress1 = get_user_meta($user_id, "pmpro_baddress1", true);
		$saddress2 = get_user_meta($user_id, "pmpro_baddress2", true);
		$scity = get_user_meta($user_id, "pmpro_bcity", true);
		$sstate = get_user_meta($user_id, "pmpro_bstate", true);
		$szipcode = get_user_meta($user_id, "pmpro_bzipcode", true);			
		$scountry = get_user_meta($user_id, "pmpro_bcountry", true);					
	}
	
	if(!empty($saddress1))
	{
		//update the shipping user meta
		update_user_meta($user_id, "pmpro_sfirstname", $sfirstname);
		update_user_meta($user_id, "pmpro_slastname", $slastname);	
		update_user_meta($user_id, "pmpro_saddress1", $saddress1);
		update_user_meta($user_id, "pmpro_saddress2", $saddress2);
		update_user_meta($user_id, "pmpro_scity", $scity);
		update_user_meta($user_id, "pmpro_sstate", $sstate);
		update_user_meta($user_id, "pmpro_szipcode", $szipcode);		
		update_user_meta($user_id, "pmpro_scountry", $scountry);		
	}
	
	//unset session vars (Note: updated to run after checkout in version .3.1		
	$vars = array('sfirstname', 'slastname', 'saddress1', 'saddress2', 'scity', 'sstate', 'szipcode', 'scountry', 'sameasbilling');
	foreach($vars as $var)
	{
		if(isset($_SESSION[$var]))
			unset($_SESSION[$var]);
	}	
}
add_action("pmpro_after_checkout", "pmproship_pmpro_after_checkout");

//show the shipping address in the profile
function pmproship_show_extra_profile_fields($user)
{
	global $pmpro_states;
?>
	<h3><?php _e('Shipping Address', 'pmpro');?></h3>
 
	<table class="form-table">
 
		<tr>
			<th><?php _e('First Name', 'pmpro');?></th>			
			<td>
				<input id="sfirstname" name="sfirstname" type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta($user->ID, 'pmpro_sfirstname', true) ); ?>" />
			</td>
		</tr>
		<tr>
			<th><?php _e('Last Name', 'pmpro');?></th>	
			<td>
				<input id="slastname" name="slastname" type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta($user->ID, 'pmpro_slastname', true) ); ?>" />
			</td>
		</tr>
		<tr>
			<th><?php _e('Address 1', 'pmpro');?></th>	
			<td>
				<input id="saddress1" name="saddress1" type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta($user->ID, 'pmpro_saddress1', true) ); ?>" />
			</td>
		</tr>
		<tr>
			<th><?php _e('Address 2', 'pmpro');?></th>	
			<td>
				<input id="saddress2" name="saddress2" type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta($user->ID, 'pmpro_saddress2', true) ); ?>" />
			</td>
		</tr>
		<tr>
			<th><?php _e('City', 'pmpro');?></th>	
			<td>
				<input id="scity" name="scity" type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta($user->ID, 'pmpro_scity', true) ); ?>" />
			</td>
		</tr>
		<tr>		
			<th><?php _e('State', 'pmpro');?></th>				
			<td>
				<?php /*
				<select id="sstate" name="sstate">
					<option value="">--</option>
					<?php 
						$sstate = get_user_meta($user->ID, 'pmpro_sstate', true);
						foreach($pmpro_states as $ab => $st) 
						{ 
					?>
						<option value="<?=$ab?>" <?php if($ab == $sstate) { ?>selected="selected"<?php } ?>><?=$st?></option>
					<?php } ?>
				</select>
				*/ ?>
								
				<input id="sstate" name="sstate" type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta($user->ID, 'pmpro_sstate', true) ); ?>" />				
			</td>
		</tr>
		<tr>		
			<th><?php _e('Postal Code', 'pmpro');?></th>	
			<td>
				<input id="szipcode" name="szipcode" type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta($user->ID, 'pmpro_szipcode', true) ); ?>" />
			</td>
		</tr>
		<tr>		
			<th><?php _e('Country', 'pmpro');?></th>	
			<td>
				<input id="scountry" name="scountry" type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta($user->ID, 'pmpro_scountry', true) ); ?>" />
			</td>
		</tr>		
 
	</table>
<?php
}
add_action( 'show_user_profile', 'pmproship_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'pmproship_show_extra_profile_fields' );
 
function pmproship_save_extra_profile_fields( $user_id ) 
{
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;
 
	update_user_meta( $user_id, 'pmpro_sfirstname', $_POST['sfirstname'] );
	update_user_meta( $user_id, 'pmpro_slastname', $_POST['slastname'] );
	update_user_meta( $user_id, 'pmpro_saddress1', $_POST['saddress1'] );
	update_user_meta( $user_id, 'pmpro_saddress2', $_POST['saddress2'] );
	update_user_meta( $user_id, 'pmpro_scity', $_POST['scity'] );
	update_user_meta( $user_id, 'pmpro_sstate', $_POST['sstate'] );
	update_user_meta( $user_id, 'pmpro_szipcode', $_POST['szipcode'] );
	update_user_meta( $user_id, 'pmpro_scountry', $_POST['scountry'] );
}
add_action( 'personal_options_update', 'pmproship_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'pmproship_save_extra_profile_fields' );
 
/*
	These bits are required for PayPal Express only.
*/
function pmproship_pmpro_paypalexpress_session_vars()
{
	//save our added fields in session while the user goes off to PayPal	
	$_SESSION['sameasbilling'] = $_REQUEST['sameasbilling'];
	
	//assume the request is set
	$_SESSION['saddress1'] = $_REQUEST['saddress1'];
	$_SESSION['sfirstname'] = $_REQUEST['sfirstname'];
    $_SESSION['slastname'] = $_REQUEST['slastname'];
    $_SESSION['sstate'] = $_REQUEST['sstate'];
    $_SESSION['scity'] = $_REQUEST['scity'];
	$_SESSION['szipcode'] = $_REQUEST['szipcode'];		
	$_SESSION['scountry'] = $_REQUEST['scountry'];		
	
	//check this one cause it's optional
	if(!empty($_REQUEST['saddress2']))
		$_SESSION['saddress2'] = $_REQUEST['saddress2'];
	else
		$_SESSION['saddress2'] = "";
}
add_action("pmpro_paypalexpress_session_vars", "pmproship_pmpro_paypalexpress_session_vars");
 
/*
	Require the shipping fields (optional)
*/
function pmproship_pmpro_registration_checks($okay)
{	
	//only check if we're okay so far and same as billing wasn't checked
	if(empty($_REQUEST['sameasbilling']))
	{
		global $pmpro_msg, $pmpro_msgt, $pmpro_error_fields;	
		
		$required_shipping_fields = array('sfirstname', 'slastname', 'saddress1', 'scity', 'sstate', 'szipcode', 'scountry');
		
		foreach($required_shipping_fields as $field)
		{
			if(empty($_REQUEST[$field]))
			{
				$okay = false;
				pmpro_setMessage(__("Please complete all required fields.", "pmpro"), "pmpro_error");
				$pmpro_error_fields[] = $field;
			}
		}
	}
	
	return $okay;
}
add_filter("pmpro_registration_checks", "pmproship_pmpro_registration_checks");
 
//adding shipping address to confirmation page
function pmproship_pmpro_confirmation_message($confirmation_message, $pmpro_invoice)
{
	global $current_user;		
 
	//does the user have a shipping address?
	$sfirstname = get_user_meta($current_user->ID, "pmpro_sfirstname", true);
	$slastname = get_user_meta($current_user->ID, "pmpro_slastname", true);
	$saddress1 = get_user_meta($current_user->ID, "pmpro_saddress1", true);
	$saddress2 = get_user_meta($current_user->ID, "pmpro_saddress2", true);
	$scity = get_user_meta($current_user->ID, "pmpro_scity", true);
	$sstate = get_user_meta($current_user->ID, "pmpro_sstate", true);
	$szipcode = get_user_meta($current_user->ID, "pmpro_szipcode", true);
	$scountry = get_user_meta($current_user->ID, "pmpro_scountry", true);
	
	if(!empty($scity) && !empty($sstate))
	{
		$shipping_address = $sfirstname . " " . $slastname . "<br />" . $saddress1 . "<br />";
		if($saddress2)
			$shipping_address .= $saddress2 . "<br />";
		$shipping_address .= $scity . ", " . $sstate . " " . $szipcode;
		$shipping_address .= "<br />" . $scountry;		
		
		$confirmation_message .= '<br /><h3>' . __('Shipping Information:', 'pmpro') . '</h3><p>' . $shipping_address . '</p>';
	}
			
	return $confirmation_message;
}
add_filter("pmpro_confirmation_message", "pmproship_pmpro_confirmation_message", 10, 2);
 
//adding shipping address to confirmation email
function pmproship_pmpro_email_body($body, $pmpro_email)
{
	global $wpdb;
 
	//get the user_id from the email
	$user_id = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE user_email = '" . $pmpro_email->data['user_email'] . "' LIMIT 1");
	
	if(!empty($user_id))
	{
		//does the user being emailed have a shipping address?		
		$sfirstname = get_user_meta($user_id, "pmpro_sfirstname", true);
		$slastname = get_user_meta($user_id, "pmpro_slastname", true);
		$saddress1 = get_user_meta($user_id, "pmpro_saddress1", true);
		$saddress2 = get_user_meta($user_id, "pmpro_saddress2", true);
		$scity = get_user_meta($user_id, "pmpro_scity", true);
		$sstate = get_user_meta($user_id, "pmpro_sstate", true);
		$szipcode = get_user_meta($user_id, "pmpro_szipcode", true);
		$scountry = get_user_meta($user_id, "pmpro_scountry", true);
		
		if(!empty($scity) && !empty($sstate))
		{
			$shipping_address = $sfirstname . " " . $slastname . "<br />" . $saddress1 . "<br />";
			if($saddress2)
				$shipping_address .= $saddress2 . "<br />";
			$shipping_address .= $scity . ", " . $sstate . " " . $szipcode;								
		}
		$shipping_address .= "<br />" . $scountry;
		
		if(!empty($shipping_address))
		{
			//squeeze the shipping address above the billing information or above the log link
			if(strpos($body, "Billing Information:"))
				$body = str_replace("Billing Information:", "Shipping Address:<br />" . $shipping_address . "<br /><br />Billing Information:", $body);
			else
				$body = str_replace("Log in to your membership", "Shipping Address:<br />" . $shipping_address . "<br /><br />Log in to your membership", $body);
		}		
	}
 
	return $body;
}
add_filter("pmpro_email_body", "pmproship_pmpro_email_body", 10, 2);
 
 
 
 
//use a dropdown for state in the billing fields
function pmproship_pmpro_state_dropdowns($use)
{
	return true;
}
add_filter("pmpro_state_dropdowns", "pmproship_pmpro_state_dropdowns");



/*
	add shipping address column to members list
*/
//heading

function pmproship_pmpro_memberslist_extra_cols_header()
{
?>
<th><?php _e('Shipping Address', 'pmpro');?></th>
<?php
}
add_action("pmpro_memberslist_extra_cols_header", "pmproship_pmpro_memberslist_extra_cols_header");

//columns
function pmproship_pmpro_memberslist_extra_cols_body($theuser)
{
?>
<td>
	<?php 
		if(empty($theuser->pmpro_sfirstname))
			$theuser->pmpro_sfirstname = "";
		if(empty($theuser->pmpro_slastname))
			$theuser->pmpro_slastname = "";
		echo trim($theuser->pmpro_sfirstname . " " . $theuser->pmpro_slastname);
	?><br />
	<?php if(!empty($theuser->pmpro_saddress1)) { ?>
		<?php echo $theuser->pmpro_saddress1; ?><br />
		<?php if(!empty($theuser->pmpro_saddress2)) echo $theuser->pmpro_saddress2 . "<br />"; ?>										
		<?php if($theuser->pmpro_scity && $theuser->pmpro_sstate) { ?>
			<?php echo $theuser->pmpro_scity?>, <?php echo $theuser->pmpro_sstate?> <?php echo $theuser->pmpro_szipcode?>  <?php if(!empty($theuser->pmpro_scountry)) echo $theuser->pmpro_scountry?><br />												
		<?php } ?>
	<?php } ?>
	<?php if(!empty($theuser->pmpro_sphone)) echo formatPhone($theuser->pmpro_sphone);?>
</td>
<?php
}
add_action("pmpro_memberslist_extra_cols_body", "pmproship_pmpro_memberslist_extra_cols_body");

/*
	add column to export
*/
//columns
function pmproship_pmpro_members_list_csv_extra_columns($columns)
{
	$new_columns = array(
		"sfirstname" => "pmproship_extra_column_sfirstname",
		"slastname" => "pmproship_extra_column_slastname",
		"saddress1" => "pmproship_extra_column_saddress1",
		"saddress2" => "pmproship_extra_column_saddress2",
		"scity" => "pmproship_extra_column_scity",
		"sstate" => "pmproship_extra_column_sstate",
		"szipcode" => "pmproship_extra_column_szipcode",
		"scountry" => "pmproship_extra_column_scountry"
	);
	
	$columns = array_merge($columns, $new_columns);
	
	return $columns;
}
add_filter("pmpro_members_list_csv_extra_columns", "pmproship_pmpro_members_list_csv_extra_columns");

//call backs
function pmproship_extra_column_sfirstname($user){if(!empty($user->metavalues->pmpro_sfirstname)){return $user->metavalues->pmpro_sfirstname;}else{return "";}}
function pmproship_extra_column_slastname($user){if(!empty($user->metavalues->pmpro_slastname)){return $user->metavalues->pmpro_slastname;}else{return "";}}
function pmproship_extra_column_saddress1($user){if(!empty($user->metavalues->pmpro_saddress1)){return $user->metavalues->pmpro_saddress1;}else{return "";}}
function pmproship_extra_column_saddress2($user){if(!empty($user->metavalues->pmpro_saddress2)){return $user->metavalues->pmpro_saddress2;}else{return "";}}
function pmproship_extra_column_scity($user){if(!empty($user->metavalues->pmpro_scity)){return $user->metavalues->pmpro_scity;}else{return "";}}
function pmproship_extra_column_sstate($user){if(!empty($user->metavalues->pmpro_sstate)){return $user->metavalues->pmpro_sstate;}else{return "";}}
function pmproship_extra_column_szipcode($user){if(!empty($user->metavalues->pmpro_szipcode)){return $user->metavalues->pmpro_szipcode;}else{return "";}}
function pmproship_extra_column_scountry($user){if(!empty($user->metavalues->pmpro_scountry)){return $user->metavalues->pmpro_scountry;}else{return "";}}

/*
	Add checkbox to hide shipping address on some levels.
*/
//show the checkbox on the edit level page
function pmproship_pmpro_membership_level_after_other_settings()
{	
	$level_id = isset($_REQUEST['edit']) ? intval($_REQUEST['edit']) : 0;
	if($level_id > 0)
		$hide_shipping = get_option('pmpro_shipping_hidden_level_' . $level_id);	
	else
		$hide_shipping = false;
?>
<h3 class="topborder">Shipping Address</h3>
<table>
<tbody class="form-table">
	<tr>
		<th scope="row" valign="top"><label for="hide_shipping"><?php _e('Hide Shipping Address:', 'pmpro');?></label></th>
		<td>
			<input type="checkbox" id="hide_shipping" name="hide_shipping" value="1" <?php checked($hide_shipping, 1);?> />
			<label for="hide_shipping"><?php _e('Check this if you DO NOT want to ask for a shipping address with this level.', 'pmpro');?></label>
		</td>
	</tr>
</tbody>
</table>
<?php
}
add_action('pmpro_membership_level_after_other_settings', 'pmproship_pmpro_membership_level_after_other_settings');

//save hide shipping setting when the level is saved/added
function pmproship_pmpro_save_membership_level($level_id)
{
	if(isset($_REQUEST['hide_shipping']))
		$hide_shipping = intval($_REQUEST['hide_shipping']);
	else
		$hide_shipping = 0;
	update_option('pmpro_shipping_hidden_level_' . $level_id, $hide_shipping);
}
add_action("pmpro_save_membership_level", "pmproship_pmpro_save_membership_level");

//actually hide/disable shipping address for these levels
function pmproship_hide_shipping($level)
{
	$hide_shipping = get_option('pmpro_shipping_hidden_level_' . $level->id, false);
	if($hide_shipping)
	{
		remove_filter("pmpro_registration_checks", "pmproship_pmpro_registration_checks");
		remove_action("pmpro_checkout_after_billing_fields", "pmproship_pmpro_checkout_boxes");
		remove_filter('pmpro_valid_gateways', 'pmproship_pmpro_valid_gateways');
		remove_action("pmpro_after_checkout", "pmproship_pmpro_after_checkout");
		remove_action("pmpro_paypalexpress_session_vars", "pmproship_pmpro_paypalexpress_session_vars");
	}

	return $level;
}
add_filter('pmpro_checkout_level', 'pmproship_hide_shipping', 99);

/*
Function to add links to the plugin row meta
*/
function pmproship_plugin_row_meta($links, $file) {
	if(strpos($file, 'pmpro-shipping.php') !== false)
	{
		$new_links = array(
			'<a href="' . esc_url('http://www.paidmembershipspro.com/add-ons/plugins-on-github/shipping-address-membership-checkout/')  . '" title="' . esc_attr( __( 'View Documentation', 'pmpro' ) ) . '">' . __( 'Docs', 'pmpro' ) . '</a>',
			'<a href="' . esc_url('http://paidmembershipspro.com/support/') . '" title="' . esc_attr( __( 'Visit Customer Support Forum', 'pmpro' ) ) . '">' . __( 'Support', 'pmpro' ) . '</a>',
		);
		$links = array_merge($links, $new_links);
	}
	return $links;
}
add_filter('plugin_row_meta', 'pmproship_plugin_row_meta', 10, 2);

<?php
/*
Plugin Name: Paid Memberships Pro - Shipping Add On
Plugin URI: https://www.paidmembershipspro.com/add-ons/shipping-address-membership-checkout/
Description: Add shipping address to the checkout page and other locations.
Version: 1.1
Author: Paid Memberships Pro
Author URI: https://www.paidmembershipspro.com
Text Domain: pmpro-shipping
Domain Path: /languages
*/

if(!defined('PMPRO_SHIPPING_SHOW_REQUIRED'))
	define( 'PMPRO_SHIPPING_SHOW_REQUIRED', true );    //if false required fields won't have asterisks and non-required fields will say (optional)
define( 'PMPRO_SHIPPING_VERSION', '1.1' );

/**
 * Load plugin textdomain.
 */
function pmproship_pmpro_load_textdomain() {
	load_plugin_textdomain( 'pmpro-shipping', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

add_action( 'init', 'pmproship_pmpro_load_textdomain' );

/**
 * Add a shipping address field to the checkout page with "sameas" checkbox
 */
function pmproship_pmpro_checkout_boxes() {
	global $gateway, $pmpro_states, $sameasbilling, $sfirstname, $slastname, $saddress1, $saddress2, $scity, $sstate, $szipcode, $sphone, $scountry, $shipping_address, $pmpro_requirebilling, $pmpro_review;
	?>
    <div id="pmpro_shipping_address_fields" class="pmpro_checkout"
	     <?php if ( $pmpro_review ) { ?>style="display: none;"<?php } ?> >
        <h3>
            <span class="pmpro_checkout-h3-name"><?php esc_html_e( 'Shipping Address', 'pmpro-shipping' ); ?></span>
        </h3>
        <div class="pmpro_checkout-fields">
			<?php if ( apply_filters( 'pmpro_include_billing_address_fields', true ) ) { ?>
                <p id="sameasbilling_wrapper">
                    <input type="checkbox" id="sameasbilling" name="sameasbilling" value="1" <?php checked($sameasbilling, 1);?> />
                    <label for="sameasbilling" class="pmpro_label-inline pmpro_clickable">
						<?php esc_html_e( 'Ship to the billing address used above.', 'pmpro-shipping' ); ?>
                    </label>
                </p>
			<?php } ?>
            <div id="shipping-fields">
                <div class="pmpro_checkout-field pmpro_checkout-field-sfirstname">
                    <label for="sfirstname"><?php esc_html_e( 'First Name', 'pmpro-shipping' ); ?></label>
                    <input id="sfirstname" name="sfirstname" type="text"
                           class="input <?php echo pmpro_getClassForField( "sfirstname" ); ?>" size="30"
                           value="<?php echo esc_attr( $sfirstname ); ?>"/>
					<?php if ( PMPRO_SHIPPING_SHOW_REQUIRED ) { ?><span class="pmpro_asterisk"> *</span><?php } ?>
                </div> <!-- end pmpro_checkout-field pmpro_checkout-field-sfirstname -->
                <div class="pmpro_checkout-field pmpro_checkout-field-slastname">
                    <label for="slastname"><?php esc_html_e( 'Last Name', 'pmpro-shipping' ); ?></label>
                    <input id="slastname" name="slastname" type="text"
                           class="input <?php echo pmpro_getClassForField( "slastname" ); ?>" size="30"
                           value="<?php echo esc_attr( $slastname ); ?>"/>
					<?php if ( PMPRO_SHIPPING_SHOW_REQUIRED ) { ?><span class="pmpro_asterisk"> *</span><?php } ?>
                </div> <!-- end pmpro_checkout-field pmpro_checkout-field-slastname -->
                <div class="pmpro_checkout-field pmpro_checkout-field-saddress1">
                    <label for="saddress1"><?php esc_html_e( 'Address 1', 'pmpro-shipping' ); ?></label>
                    <input id="saddress1" name="saddress1" type="text"
                           class="input <?php echo pmpro_getClassForField( "saddress1" ); ?>" size="30"
                           value="<?php echo esc_attr( $saddress1 ); ?>"/>
					<?php if ( PMPRO_SHIPPING_SHOW_REQUIRED ) { ?><span class="pmpro_asterisk"> *</span><?php } ?>
                </div> <!-- end pmpro_checkout-field pmpro_checkout-field-saddress1 -->
                <div class="pmpro_checkout-field pmpro_checkout-field-saddress2">
                    <label for="saddress2"><?php esc_html_e( 'Address 2', 'pmpro-shipping' ); ?></label>
                    <input id="saddress2" name="saddress2" type="text"
                           class="input <?php echo pmpro_getClassForField( "saddress2" ); ?>" size="30"
                           value="<?php echo esc_attr( $saddress2 ); ?>"/>
					<?php if ( ! PMPRO_SHIPPING_SHOW_REQUIRED ) { ?>
                        <small class="lite">(<?php esc_html_e( 'optional', 'pmpro-shipping' ); ?>)</small><?php } ?>
                </div> <!-- end pmpro_checkout-field pmpro_checkout-field-saddress2 -->
                <div class="pmpro_checkout-field pmpro_checkout-field-scity">
                    <label for="scity"><?php esc_html_e( 'City', 'pmpro-shipping' ); ?></label>
                    <input id="scity" name="scity" type="text"
                           class="input <?php echo pmpro_getClassForField( "scity" ); ?>" size="30"
                           value="<?php echo esc_attr( $scity ) ?>"/>
					<?php if ( PMPRO_SHIPPING_SHOW_REQUIRED ) { ?><span class="pmpro_asterisk"> *</span><?php } ?>
                </div> <!-- end pmpro_checkout-field pmpro_checkout-field-scity -->
                <div class="pmpro_checkout-field pmpro_checkout-field-sstate">
                    <label for="sstate"><?php esc_html_e( 'State', 'pmpro-shipping' ); ?></label>
                    <input id="sstate" name="sstate" type="text"
                           class="input <?php echo pmpro_getClassForField( "sstate" ); ?>" size="30"
                           value="<?php echo esc_attr( $sstate ) ?>"/>
					<?php if ( PMPRO_SHIPPING_SHOW_REQUIRED ) { ?><span class="pmpro_asterisk"> *</span><?php } ?>
                </div> <!-- end pmpro_checkout-field pmpro_checkout-field-sstate -->
                <div class="pmpro_checkout-field pmpro_checkout-field-szipcode">
                    <label for="szipcode"><?php esc_html_e( 'Postal Code', 'pmpro-shipping' ); ?></label>
                    <input id="szipcode" name="szipcode" type="text"
                           class="input <?php echo pmpro_getClassForField( "szipcode" ); ?>" size="30"
                           value="<?php echo esc_attr( $szipcode ) ?>"/>
					<?php if ( PMPRO_SHIPPING_SHOW_REQUIRED ) { ?><span class="pmpro_asterisk"> *</span><?php } ?>
                </div>     <!-- end pmpro_checkout-field pmpro_checkout-field-sphone -->
                <div class="pmpro_checkout-field pmpro_checkout-field-sphone">
                    <label for="sphone"><?php _e( 'Phone', 'pmpro-shipping' ); ?></label>
                    <input id="sphone" name="sphone" type="text"
                           class="input <?php echo pmpro_getClassForField( "sphone" ); ?>" size="30"
                           value="<?php echo esc_attr( $sphone ) ?>"/>
					<?php if ( PMPRO_SHIPPING_SHOW_REQUIRED ) { ?><span class="pmpro_asterisk"> *</span><?php } ?>
                </div>     <!-- end pmpro_checkout-field pmpro_checkout-field-sphone -->
                <div class="pmpro_checkout-field pmpro_checkout-field-scountry">
                    <label for="scountry"><?php esc_html_e( 'Country', 'pmpro-shipping' ); ?></label>
                    <select name="scountry" id="scountry" class="input <?php echo pmpro_getClassForField( "scountry" ); ?>">
						<?php
						global $pmpro_countries, $pmpro_default_country;
						foreach ( $pmpro_countries as $abbr => $country ) {
							if ( ! $scountry ) {
								$scountry = $pmpro_default_country;
							}
							?>
                            <option value="<?php echo $abbr ?>"
							        <?php if ( $abbr == $scountry ) { ?>selected="selected"<?php } ?>><?php echo $country ?></option>
							<?php
						}
						?>
                    </select>
					<?php if ( PMPRO_SHIPPING_SHOW_REQUIRED ) { ?><span class="pmpro_asterisk"> *</span><?php } ?>
                </div> <!-- end pmpro_checkout-field pmpro_checkout-field-scountry -->
            </div> <!-- end shipping-fields -->
        </div> <!-- end pmpro_checkout-fields -->
    </div> <!-- end pmpro_shipping_address_fields -->
	<?php
}

add_action( "pmpro_checkout_after_billing_fields", "pmproship_pmpro_checkout_boxes" );

/**
 * Get fields on checkout page
 */
function pmproship_pmpro_checkout_preheader()
{
	global $sameasbilling, $sfirstname, $slastname, $saddress1, $saddress2, $scity, $sstate, $szipcode, $sphone, $scountry, $shipping_address, $pmpro_requirebilling, $current_user;

	if ( ! empty( $_REQUEST['sameasbilling'] ) ) {
		$sameasbilling = true;
	}    //we'll get the fields further down below
	else if ( ! empty( $_REQUEST['saddress1'] ) ) {
		//grab the fields entered by the user at checkout
		$sfirstname = sanitize_text_field( $_REQUEST['sfirstname'] );
		$slastname  = sanitize_text_field( $_REQUEST['slastname'] );
		$saddress1  = sanitize_text_field( $_REQUEST['saddress1'] );
		if ( ! empty( $_REQUEST['saddress2'] ) ) {
			$saddress2 = sanitize_text_field( $_REQUEST['saddress2'] );
		}
		$scity = sanitize_text_field( $_REQUEST['scity'] );

		$sstate = sanitize_text_field( $_REQUEST['sstate'] );

		//convert long state names to abbreviations
		if ( ! empty( $sstate ) ) {
			global $pmpro_states;
			foreach ( $pmpro_states as $abbr => $state ) {
				if ( $sstate == $state ) {
					$sstate = $abbr;
					break;
				}
			}
		}

		$sphone   = sanitize_text_field( $_REQUEST['sphone'] );
		$szipcode = sanitize_text_field( $_REQUEST['szipcode'] );
		$scountry = sanitize_text_field( $_REQUEST['scountry'] );
	} else if ( ! empty( $_SESSION['sameasbilling'] ) ) {
		//coming back from PayPal. same as billing
		$sameasbilling = true;
	} else if ( ! empty( $_SESSION['saddress1'] ) ) {
		//coming back from PayPal. grab the fields from session
		$sfirstname = sanitize_text_field( $_SESSION['sfirstname'] );
		$slastname  = sanitize_text_field( $_SESSION['slastname'] );
		$saddress1  = sanitize_text_field( $_SESSION['saddress1'] );
		if ( ! empty( $_SESSION['saddress2'] ) ) {
			$saddress2 = sanitize_text_field( $_SESSION['saddress2'] );
		}
		$scity    = sanitize_text_field( $_SESSION['scity'] );
		$sstate   = sanitize_text_field( $_SESSION['sstate'] );
		$sphone   = sanitize_text_field( $_SESSION['sphone'] );
		$szipcode = sanitize_text_field( $_SESSION['szipcode'] );
		$scountry = sanitize_text_field( $_SESSION['scountry'] );
	} else if ( ! empty( $current_user->ID ) ) {
		//get shipping fields from user meta
		$user_id    = $current_user->ID;
		$sfirstname = get_user_meta( $user_id, "pmpro_sfirstname", true );
		$slastname  = get_user_meta( $user_id, "pmpro_slastname", true );
		$saddress1  = get_user_meta( $user_id, "pmpro_saddress1", true );
		$saddress2  = get_user_meta( $user_id, "pmpro_saddress2", true );
		$scity      = get_user_meta( $user_id, "pmpro_scity", true );
		$sstate     = get_user_meta( $user_id, "pmpro_sstate", true );
		$szipcode   = get_user_meta( $user_id, "pmpro_szipcode", true );
		$sphone     = get_user_meta( $user_id, "pmpro_sphone", true );
		$scountry   = get_user_meta( $user_id, "pmpro_scountry", true );
	}
}
add_action('pmpro_checkout_preheader', 'pmproship_pmpro_checkout_preheader');

/**
 * Choose which hook to use to update user meta values.
 * For PayPal Standard, 2Checkout, CCBill, and Payfast, we need to
 * run this code before we redirect away.
 * For other gateways, including onsite gateways and PayPal express,
 * we run this code after checkout.
 */
function pmproship_pmpro_checkout_preheader_check_gateway() {
	//if we're not going offsite, we don't need to save things in session
	global $gateway;

	if( 1 === preg_match( '/paypalstandard|paypalexpress|twocheckout|ccbill|payfast/i', $gateway ) ) {
		add_action('pmpro_checkout_before_change_membership_level', 'pmproship_save_shipping_to_usermeta', 1);
	} else {
		add_action('pmpro_after_checkout', 'pmproship_save_shipping_to_usermeta');
	}
}
add_action('pmpro_checkout_preheader', 'pmproship_pmpro_checkout_preheader_check_gateway', 9);

/**
 * Update a user meta values.
 */
function pmproship_save_shipping_to_usermeta($user_id)
{
	global $sameasbilling, $sfirstname, $slastname, $saddress1, $saddress2, $scity, $sstate, $szipcode, $sphone, $scountry, $shipping_address, $pmpro_requirebilling;

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
		$sphone = get_user_meta($user_id, "pmpro_bphone", true);
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
		update_user_meta($user_id, "pmpro_sphone", $sphone);
		update_user_meta($user_id, "pmpro_scountry", $scountry);
	}

	//unset session vars
	$vars = array('sfirstname', 'slastname', 'saddress1', 'saddress2', 'scity', 'sstate', 'szipcode', 'sphone', 'scountry', 'sameasbilling');
	foreach($vars as $var)
	{
		if(isset($_SESSION[$var]))
			unset($_SESSION[$var]);
	}
}

/**
 * Show the shipping address in the profile
 */
function pmproship_show_extra_profile_fields( $user ) {
	global $current_user, $pmpro_states;

	$show_shipping = false;

	// Make sure PMPro is activated.
	if ( function_exists( 'pmpro_getMembershipLevelsForUser') ) {
		// Make sure their level shows shipping fields.
		$membership_levels = pmpro_getMembershipLevelsForUser( $user->ID );

		foreach ( $membership_levels as $membership_level ) {
			if ( empty( get_option( 'pmpro_shipping_hidden_level_' . $membership_level->id, false ) ) ) {
				$show_shipping = true;
				break;
			}
		}
	}

	// Show the shipping fields if the membership level includes fields or the user is an admin.
	if ( ! empty( $show_shipping ) || current_user_can( 'manage_options', $current_user->ID ) ) { ?>
	    <h3><?php esc_html_e( 'Shipping Address', 'pmpro-shipping' ); ?></h3>

	    <table class="form-table">

	        <tr>
	            <th><?php esc_html_e( 'First Name', 'pmpro-shipping' ); ?></th>
	            <td>
	                <input id="sfirstname" name="sfirstname" type="text" class="regular-text"
	                       value="<?php echo esc_attr( get_user_meta( $user->ID, 'pmpro_sfirstname', true ) ); ?>"/>
	            </td>
	        </tr>
	        <tr>
	            <th><?php esc_html_e( 'Last Name', 'pmpro-shipping' ); ?></th>
	            <td>
	                <input id="slastname" name="slastname" type="text" class="regular-text"
	                       value="<?php echo esc_attr( get_user_meta( $user->ID, 'pmpro_slastname', true ) ); ?>"/>
	            </td>
	        </tr>
	        <tr>
	            <th><?php esc_html_e( 'Address 1', 'pmpro-shipping' ); ?></th>
	            <td>
	                <input id="saddress1" name="saddress1" type="text" class="regular-text"
	                       value="<?php echo esc_attr( get_user_meta( $user->ID, 'pmpro_saddress1', true ) ); ?>"/>
	            </td>
	        </tr>
	        <tr>
	            <th><?php esc_html_e( 'Address 2', 'pmpro-shipping' ); ?></th>
	            <td>
	                <input id="saddress2" name="saddress2" type="text" class="regular-text"
	                       value="<?php echo esc_attr( get_user_meta( $user->ID, 'pmpro_saddress2', true ) ); ?>"/>
	            </td>
	        </tr>
	        <tr>
	            <th><?php esc_html_e( 'City', 'pmpro-shipping' ); ?></th>
	            <td>
	                <input id="scity" name="scity" type="text" class="regular-text"
	                       value="<?php echo esc_attr( get_user_meta( $user->ID, 'pmpro_scity', true ) ); ?>"/>
	            </td>
	        </tr>
	        <tr>
	            <th><?php esc_html_e( 'State', 'pmpro-shipping' ); ?></th>
	            <td>
	                <input id="sstate" name="sstate" type="text" class="regular-text"
	                       value="<?php echo esc_attr( get_user_meta( $user->ID, 'pmpro_sstate', true ) ); ?>"/>
	            </td>
	        </tr>
	        <tr>
	            <th><?php esc_html_e( 'Postal Code', 'pmpro-shipping' ); ?></th>
	            <td>
	                <input id="szipcode" name="szipcode" type="text" class="regular-text"
	                       value="<?php echo esc_attr( get_user_meta( $user->ID, 'pmpro_szipcode', true ) ); ?>"/>
	            </td>
	        </tr>
	        <tr>
	            <th><?php _e( 'Phone', 'pmpro-shipping' ); ?></th>
	            <td>
	                <input id="sphone" name="sphone" type="text" class="regular-text"
	                       value="<?php echo esc_attr( get_user_meta( $user->ID, 'pmpro_sphone', true ) ); ?>"/>
	            </td>
	        </tr>
	        <tr>
			<th><?php esc_html_e( 'Country', 'pmpro-shipping' ); ?></th>
	            <td>
	                <input id="scountry" name="scountry" type="text" class="regular-text"
	                       value="<?php echo esc_attr( get_user_meta( $user->ID, 'pmpro_scountry', true ) ); ?>"/>
	            </td>
	        </tr>

	    </table>
		<?php
	}
}
add_action( 'show_user_profile', 'pmproship_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'pmproship_show_extra_profile_fields' );

/**
 * Show the shipping address in the frontend profile
 */
function pmproship_show_extra_frontend_profile_fields( $user ) {
	global $pmpro_states;

	$show_shipping = false;

	// Make sure PMPro is activated.
	if ( function_exists( 'pmpro_getMembershipLevelsForUser') ) {
		// Make sure their level shows shipping fields.
		$membership_levels = pmpro_getMembershipLevelsForUser( $user->ID );

		foreach ( $membership_levels as $membership_level ) {
			if ( empty( get_option( 'pmpro_shipping_hidden_level_' . $membership_level->id, false ) ) ) {
				$show_shipping = true;
				break;
			}
		}
	}

	// Show the shipping fields.
	if ( ! empty( $show_shipping ) ) { ?>
		<div class="pmpro_checkout_box-shipping">
			<h3><?php esc_html_e( 'Shipping Address', 'pmpro-shipping' ); ?></h3>
			<div class="pmpro_member_profile_edit-fields">
				<div class="pmpro_checkout-field pmpro_checkout-field-sfirstname">
					<label for="sfirstname"><?php esc_html_e( 'First Name', 'pmpro-shipping' ); ?></label>
					<input id="sfirstname" name="sfirstname" type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta( $user->ID, 'pmpro_sfirstname', true ) ); ?>" size="30" />
				</div> <!-- end pmpro_checkout-field-sfirstname -->
				<div class="pmpro_checkout-field pmpro_checkout-field-slastname">
					<label for="slastname"><?php esc_html_e( 'Last Name', 'pmpro-shipping' ); ?></label>
					<input id="slastname" name="slastname" type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta( $user->ID, 'pmpro_slastname', true ) ); ?>" size="30" />
				</div> <!-- end pmpro_checkout-field-slastname -->
				<div class="pmpro_checkout-field pmpro_checkout-field-saddress1">
					<label for="saddress1"><?php esc_html_e( 'Address 1', 'pmpro-shipping' ); ?></label>
					<input id="saddress1" name="saddress1" type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta( $user->ID, 'pmpro_saddress1', true ) ); ?>" size="30" />
				</div> <!-- end pmpro_checkout-field-saddress1 -->
				<div class="pmpro_checkout-field pmpro_checkout-field-saddress2">
					<label for="saddress2"><?php esc_html_e( 'Address 2', 'pmpro-shipping' ); ?></label>
					<input id="saddress2" name="saddress2" type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta( $user->ID, 'pmpro_saddress2', true ) ); ?>" size="30" />
				</div> <!-- end pmpro_checkout-field-saddress2 -->
				<div class="pmpro_checkout-field pmpro_checkout-field-scity">
					<label for="scity"><?php esc_html_e( 'City', 'pmpro-shipping' ); ?></label>
					<input id="scity" name="scity" type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta( $user->ID, 'pmpro_scity', true ) ); ?>" size="14" />
				</div> <!-- end pmpro_checkout-field-scity -->
				<div class="pmpro_checkout-field pmpro_checkout-field-sstate">
					<label for="sstate"><?php esc_html_e( 'State', 'pmpro-shipping' ); ?></label>
					<input id="sstate" name="sstate" type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta( $user->ID, 'pmpro_sstate', true ) ); ?>"/>
				</div> <!-- end pmpro_checkout-field-sstate -->
				<div class="pmpro_checkout-field pmpro_checkout-field-szipcode">
					<label for="szipcode"><?php esc_html_e( 'Postal Code', 'pmpro-shipping' ); ?></label>
					<input id="szipcode" name="szipcode" type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta( $user->ID, 'pmpro_szipcode', true ) ); ?>" size="5" />
				</div><!-- end pmpro_checkout-field-szipcode -->
				<div class="pmpro_checkout-field pmpro_checkout-field-sphone">
					<label for="sphone"><?php esc_html_e( 'Phone', 'pmpro-shipping' ); ?></label>
					<input id="sphone" name="sphone" type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta( $user->ID, 'pmpro_sphone', true ) ); ?>" size="30" />
				</div> <!-- end pmpro_checkout-field-sphone -->
				<div class="pmpro_checkout-field pmpro_checkout-field-scountry">
					<label for="scountry"><?php esc_html_e( 'Country', 'pmpro-shipping' ); ?></label>
					<input id="scountry" name="scountry" type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta( $user->ID, 'pmpro_scountry', true ) ); ?>" size="30" />
				</div> <!-- end pmpro_checkout-field-scountry -->
			</div> <!-- end pmpro_member_profile_edit-fields -->
		</div> <!-- end pmpro_checkout_box-shipping -->
		<?php
	}
}
add_action( 'pmpro_show_user_profile', 'pmproship_show_extra_frontend_profile_fields' );

/**
 * Save profile fields
 */
function pmproship_save_extra_profile_fields( $user_id ) {

	// Bail if the user cannot edit the profile or they aren't updating.
	if ( ! current_user_can( 'edit_user', $user_id ) || ! isset( $_REQUEST['submit'] ) ) {
		return false;
	}

	// Bail if the shipping fields are hidden.
	if ( ! isset( $_POST['saddress1'] ) ) {
		return false;
	}

	update_user_meta( $user_id, 'pmpro_sfirstname', sanitize_text_field( $_POST['sfirstname'] ) );
	update_user_meta( $user_id, 'pmpro_slastname', sanitize_text_field( $_POST['slastname'] ) );
	update_user_meta( $user_id, 'pmpro_saddress1', sanitize_text_field( $_POST['saddress1'] ) );
	update_user_meta( $user_id, 'pmpro_saddress2', sanitize_text_field( $_POST['saddress2'] ) );
	update_user_meta( $user_id, 'pmpro_scity', sanitize_text_field( $_POST['scity'] ) );
	update_user_meta( $user_id, 'pmpro_sstate', sanitize_text_field( $_POST['sstate'] ) );
	update_user_meta( $user_id, 'pmpro_szipcode', sanitize_text_field( $_POST['szipcode'] ) );
	update_user_meta( $user_id, 'pmpro_sphone', sanitize_text_field( $_POST['sphone'] ) );
	update_user_meta( $user_id, 'pmpro_scountry', sanitize_text_field( $_POST['scountry'] ) );
}
add_action( 'personal_options_update', 'pmproship_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'pmproship_save_extra_profile_fields' );
add_action( 'pmpro_personal_options_update', 'pmproship_save_extra_profile_fields' );

/**
 * These bits are required for PayPal Express
 * Save fields to session so we can update them
 * after returning from PayPal
 */
function pmproship_save_shipping_to_session() {
	//if we're not going offsite, we don't need to save things in session
	global $gateway;
	if( 1 !== preg_match( '/paypalexpress/', $gateway ) ) {
		return;
	}

	//we got some fields, let's add them to a session var
	$shipping_fields = array(
		'sameasbilling',
		'sfirstname',
		'slastname',
		'saddress1',
		'saddress2',
		'sstate',
		'scity',
		'szipcode',
		'sphone',
		'scountry',
	);

	//save our added fields in session while the user goes off to PayPal
	foreach ( $shipping_fields as $field_name ) {
		$val = isset( $_REQUEST[ $field_name ] ) ? $_REQUEST[ $field_name ] : '';
		$_SESSION[ $field_name ] = $val;
	}
}
add_action( "pmpro_checkout_before_processing", "pmproship_save_shipping_to_session", 9 );

/**
 * Are one of the shipping address data fields set?
 *
 * @param array $object
 *
 * @return bool
 */
function pmproship_is_shipping_set( $object = NULL ) {

	if(empty($object) && (!empty($_REQUEST['sameasbilling']) || !empty($_REQUEST['saddress1'])))
		$object = $_REQUEST;
	elseif(empty($object) && (!empty($_SESSION['sameasbilling']) || !empty($_REQUEST['saddress1'])))
		$object = $_SESSION;

	return isset( $object['sameasbilling'] ) ||
	       isset( $object['saddress1'] ) || isset( $object['saddress2'] ) ||
	       isset( $object['sfirstname'] ) || isset( $object['slastname'] ) ||
	       isset( $object['sstate'] ) || isset( $object['scity'] ) ||
	       isset( $object['szipcode'] ) || isset( $object['sphone'] ) || isset( $object['scountry'] );
}

/**
 * Require the shipping fields (optional)
 */
function pmproship_pmpro_registration_checks( $okay ) {
	//only check if we're okay so far and same as billing wasn't checked
	if ( empty( $_REQUEST['sameasbilling'] ) ) {
		global $pmpro_msg, $pmpro_msgt, $pmpro_error_fields;

		$required_shipping_fields['sfirstname'] = 'sfirstname';
		$required_shipping_fields['slastname'] = 'slastname';
		$required_shipping_fields['saddress1'] = 'saddress1';
		$required_shipping_fields['scity'] = 'scity';
		$required_shipping_fields['sstate'] = 'sstate';
		$required_shipping_fields['szipcode'] = 'szipcode';
		$required_shipping_fields['sphone'] = 'sphone';
		$required_shipping_fields['scountry'] = 'scountry';

		$required_shipping_fields = apply_filters( "pmproship_required_shipping_fields", $required_shipping_fields );

		foreach ( $required_shipping_fields as $field ) {
			if ( empty( $_REQUEST[ $field ] ) ) {
				$okay = false;
				pmpro_setMessage( __( 'Please complete all required fields.', 'pmpro-shipping' ), 'pmpro_error' );
				$pmpro_error_fields[] = $field;
			}
		}
	}

	return $okay;
}
add_filter( "pmpro_registration_checks", "pmproship_pmpro_registration_checks" );

/**
 * Adding shipping address to confirmation page
 */
function pmproship_pmpro_confirmation_message( $confirmation_message, $pmpro_invoice ) {
	global $current_user;

	//does the user have a shipping address?
	$sfirstname = get_user_meta( $current_user->ID, "pmpro_sfirstname", true );
	$slastname  = get_user_meta( $current_user->ID, "pmpro_slastname", true );
	$saddress1  = get_user_meta( $current_user->ID, "pmpro_saddress1", true );
	$saddress2  = get_user_meta( $current_user->ID, "pmpro_saddress2", true );
	$scity      = get_user_meta( $current_user->ID, "pmpro_scity", true );
	$sstate     = get_user_meta( $current_user->ID, "pmpro_sstate", true );
	$szipcode   = get_user_meta( $current_user->ID, "pmpro_szipcode", true );
	$sphone   	= get_user_meta( $current_user->ID, "pmpro_sphone", true );
	$scountry   = get_user_meta( $current_user->ID, "pmpro_scountry", true );

	$shipping_address = pmpro_formatAddress( trim( $sfirstname . ' ' . $slastname ), $saddress1, $saddress2, $scity, $sstate, $szipcode, $scountry, $sphone );

	$confirmation_message .= '<h3>' . __( 'Shipping Information:', 'pmpro-shipping' ) . '</h3><p>' . $shipping_address . '</p>';


	return $confirmation_message;
}
add_filter( "pmpro_confirmation_message", "pmproship_pmpro_confirmation_message", 10, 2 );

/**
 * Adding shipping address to confirmation email
 */
function pmproship_pmpro_email_body( $body, $pmpro_email ) {

	global $wpdb;

	// Init variables
	$user_id          = null;
	$shipping_address = null;

	//get the user_id from the email
	$user = isset( $pmpro_email->data['user_email'] ) ? get_user_by( 'email', $pmpro_email->data['user_email'] ) : null;

	if ( ! empty( $user ) ) {
		$user_id = $user->ID;
	}

	if ( ! empty( $user_id ) ) {
		//does the user being emailed have a shipping address?
		$sfirstname = get_user_meta( $user_id, "pmpro_sfirstname", true );
		$slastname  = get_user_meta( $user_id, "pmpro_slastname", true );
		$saddress1  = get_user_meta( $user_id, "pmpro_saddress1", true );
		$saddress2  = get_user_meta( $user_id, "pmpro_saddress2", true );
		$scity      = get_user_meta( $user_id, "pmpro_scity", true );
		$sstate     = get_user_meta( $user_id, "pmpro_sstate", true );
		$szipcode   = get_user_meta( $user_id, "pmpro_szipcode", true );
		$sphone  	= get_user_meta( $user_id, "pmpro_sphone", true );
		$scountry   = get_user_meta( $user_id, "pmpro_scountry", true );

		$shipping_address = pmpro_formatAddress( trim( $sfirstname . ' ' . $slastname ), $saddress1, $saddress2, $scity, $sstate, $szipcode, $scountry, $sphone );

		if ( ! empty( $shipping_address ) ) {
			//squeeze the shipping address above the billing information or above the log link
			if ( strpos( $body, "Billing Information:" ) ) {
				$body = str_replace( "Billing Information:", __( "Shipping Address", "pmpro-shipping" ) . ":<br />" . $shipping_address . "<br /><br />" . __( "Billing Information", "pmpro-shipping" ) . ":", $body );
			} else {
				$body = str_replace( "Log in to your membership", __( "Shipping Address", "pmpro-shipping" ) . ":<br />" . $shipping_address . "<br /><br />" . __( "Log in to your membership", "pmpro-shipping" ), $body );
			}
		}
	}

	return $body;
}
add_filter( "pmpro_email_body", "pmproship_pmpro_email_body", 10, 2 );


/**
 * Use a dropdown for state in the billing fields
 */
function pmproship_pmpro_state_dropdowns( $use ) {
	return true;
}
add_filter( "pmpro_state_dropdowns", "pmproship_pmpro_state_dropdowns" );


/**
 * Add shipping address column to members list
*/
//heading
function pmproship_pmpro_memberslist_extra_cols_header() {
	?>
    <th><?php esc_html_e( 'Shipping Address', 'pmpro-shipping' ); ?></th>
	<?php
}
add_action( "pmpro_memberslist_extra_cols_header", "pmproship_pmpro_memberslist_extra_cols_header" );

//columns
function pmproship_pmpro_memberslist_extra_cols_body( $theuser ) {
	?>
    <td>
		<?php
		if ( empty( $theuser->pmpro_sfirstname ) ) {
			$theuser->pmpro_sfirstname = "";
		}
		if ( empty( $theuser->pmpro_slastname ) ) {
			$theuser->pmpro_slastname = "";
		}
		echo trim( $theuser->pmpro_sfirstname . " " . $theuser->pmpro_slastname );
		?><br/>
		<?php if ( ! empty( $theuser->pmpro_saddress1 ) ) { ?>
			<?php echo $theuser->pmpro_saddress1; ?><br/>
			<?php if ( ! empty( $theuser->pmpro_saddress2 ) ) {
				echo $theuser->pmpro_saddress2 . "<br />";
			} ?>
			<?php if ( $theuser->pmpro_scity && $theuser->pmpro_sstate ) { ?>
				<?php echo $theuser->pmpro_scity ?>, <?php echo $theuser->pmpro_sstate ?> <?php echo $theuser->pmpro_szipcode ?> <?php if ( ! empty( $theuser->pmpro_scountry ) )
					echo $theuser->pmpro_scountry ?><br/>
			<?php } ?>
		<?php } ?>
		<?php if ( ! empty( $theuser->pmpro_sphone ) ) {
			echo formatPhone( $theuser->pmpro_sphone );
		} ?>
    </td>
	<?php
}

add_action( "pmpro_memberslist_extra_cols_body", "pmproship_pmpro_memberslist_extra_cols_body" );

/**
 * Add column to export
*/
//columns
function pmproship_pmpro_members_list_csv_extra_columns( $columns ) {
	$new_columns = array(
		"sfirstname" => "pmproship_extra_column_sfirstname",
		"slastname"  => "pmproship_extra_column_slastname",
		"saddress1"  => "pmproship_extra_column_saddress1",
		"saddress2"  => "pmproship_extra_column_saddress2",
		"scity"      => "pmproship_extra_column_scity",
		"sstate"     => "pmproship_extra_column_sstate",
		"szipcode"   => "pmproship_extra_column_szipcode",
		"sphone"     => "pmproship_extra_column_sphone",
		"scountry"   => "pmproship_extra_column_scountry",
	);

	$columns = array_merge( $columns, $new_columns );

	return $columns;
}

add_filter( "pmpro_members_list_csv_extra_columns", "pmproship_pmpro_members_list_csv_extra_columns" );

//call backs
function pmproship_extra_column_sfirstname( $user ) {
	if ( ! empty( $user->metavalues->pmpro_sfirstname ) ) {
		return $user->metavalues->pmpro_sfirstname;
	} else {
		return "";
	}
}

function pmproship_extra_column_slastname( $user ) {
	if ( ! empty( $user->metavalues->pmpro_slastname ) ) {
		return $user->metavalues->pmpro_slastname;
	} else {
		return "";
	}
}

function pmproship_extra_column_saddress1( $user ) {
	if ( ! empty( $user->metavalues->pmpro_saddress1 ) ) {
		return $user->metavalues->pmpro_saddress1;
	} else {
		return "";
	}
}

function pmproship_extra_column_saddress2( $user ) {
	if ( ! empty( $user->metavalues->pmpro_saddress2 ) ) {
		return $user->metavalues->pmpro_saddress2;
	} else {
		return "";
	}
}

function pmproship_extra_column_scity( $user ) {
	if ( ! empty( $user->metavalues->pmpro_scity ) ) {
		return $user->metavalues->pmpro_scity;
	} else {
		return "";
	}
}

function pmproship_extra_column_sstate( $user ) {
	if ( ! empty( $user->metavalues->pmpro_sstate ) ) {
		return $user->metavalues->pmpro_sstate;
	} else {
		return "";
	}
}

function pmproship_extra_column_szipcode( $user ) {
	if ( ! empty( $user->metavalues->pmpro_szipcode ) ) {
		return $user->metavalues->pmpro_szipcode;
	} else {
		return "";
	}
}


function pmproship_extra_column_sphone( $user ) {
	if ( ! empty( $user->metavalues->pmpro_sphone ) ) {
		return $user->metavalues->pmpro_sphone;
	} else {
		return "";
	}
}

function pmproship_extra_column_scountry( $user ) {
	if ( ! empty( $user->metavalues->pmpro_scountry ) ) {
		return $user->metavalues->pmpro_scountry;
	} else {
		return "";
	}
}

/**
 * Add checkbox to hide shipping address on some levels.
 */
//show the checkbox on the edit level page
function pmproship_pmpro_membership_level_after_other_settings() {
	$level_id = isset( $_REQUEST['edit'] ) ? intval( $_REQUEST['edit'] ) : 0;
	if ( $level_id > 0 ) {
		$hide_shipping = get_option( 'pmpro_shipping_hidden_level_' . $level_id );
	} else {
		$hide_shipping = false;
	}
	?>
    <h3 class="topborder"><?php	 esc_html_e( 'Shipping Address', 'pmpro-shipping' ); ?></h3>
    <table>
        <tbody class="form-table">
        <tr>
            <th scope="row" valign="top"><label
                        for="hide_shipping"><?php esc_html_e( 'Hide Shipping Address:', 'pmpro-shipping' ); ?></label></th>
            <td>
                <input type="checkbox" id="hide_shipping" name="hide_shipping" value="1" <?php checked( $hide_shipping, 1 ); ?> />
                <label for="hide_shipping"><?php esc_html_e( 'Check this if you DO NOT want to ask for a shipping address with this level.', 'pmpro-shipping' ); ?></label>
            </td>
        </tr>
        </tbody>
    </table>
	<?php
}

add_action( 'pmpro_membership_level_after_other_settings', 'pmproship_pmpro_membership_level_after_other_settings' );

/**
 * Save hide shipping setting when the level is saved/added
 */
 function pmproship_pmpro_save_membership_level( $level_id ) {
	if ( isset( $_REQUEST['hide_shipping'] ) ) {
		$hide_shipping = intval( $_REQUEST['hide_shipping'] );
	} else {
		$hide_shipping = 0;
	}
	update_option( 'pmpro_shipping_hidden_level_' . $level_id, $hide_shipping );
}

add_action( "pmpro_save_membership_level", "pmproship_pmpro_save_membership_level" );

/**
 * Actually hide/disable shipping address for these levels
 */
function pmproship_hide_shipping() {
	global $pmpro_level;

	$hide_shipping = get_option( 'pmpro_shipping_hidden_level_' . $pmpro_level->id, false );
	if ( $hide_shipping ) {
		remove_action('pmpro_checkout_preheader', 'pmproship_pmpro_checkout_preheader_check_gateway', 9);
		remove_filter( "pmpro_registration_checks", "pmproship_pmpro_registration_checks" );
		remove_action( "pmpro_checkout_after_billing_fields", "pmproship_pmpro_checkout_boxes" );
		remove_action('pmpro_checkout_preheader', 'pmproship_pmpro_checkout_preheader');
		remove_action('pmpro_checkout_before_change_membership_level', 'pmproship_save_shipping_to_usermeta', 1);
		remove_action('pmpro_after_checkout', 'pmproship_save_shipping_to_usermeta');
		remove_action( "pmpro_checkout_before_processing", "pmproship_save_shipping_to_session", 9 );
	}
}
add_filter( 'pmpro_checkout_preheader', 'pmproship_hide_shipping', 5 );

/**
 * Load our javascript on the checkout page only.
 */
function pmproship_load_js() {
	if ( function_exists( 'pmpro_is_checkout' ) && pmpro_is_checkout() ) {
		wp_enqueue_script( 'pmproship', plugins_url( 'js/pmpro-shipping.js', __FILE__ ), array( 'jquery' ), PMPRO_SHIPPING_VERSION );
	}
}
add_action( 'wp_enqueue_scripts', 'pmproship_load_js' );

/**
 * Function to add links to the plugin row meta
 */
function pmproship_plugin_row_meta( $links, $file ) {
	if ( strpos( $file, 'pmpro-shipping.php' ) !== false ) {
		$new_links = array(
			'<a href="' . esc_url( 'https://www.paidmembershipspro.com/add-ons/shipping-address-membership-checkout/' ) . '" title="' . esc_attr( __( 'View Documentation', 'pmpro-shipping' ) ) . '">' . __( 'Docs', 'pmpro-shipping' ) . '</a>',
			'<a href="' . esc_url( 'https://paidmembershipspro.com/support/' ) . '" title="' . esc_attr( __( 'Visit Customer Support Forum', 'pmpro-shipping' ) ) . '">' . __( 'Support', 'pmpro-shipping' ) . '</a>',
		);
		$links     = array_merge( $links, $new_links );
	}

	return $links;
}
add_filter( 'plugin_row_meta', 'pmproship_plugin_row_meta', 10, 2 );

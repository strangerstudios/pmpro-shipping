<?php
/*
Plugin Name: Paid Memberships Pro - Shipping Add On
Plugin URI: https://www.paidmembershipspro.com/add-ons/shipping-address-membership-checkout/
Description: Add shipping address to the checkout page and other locations.
Version: 1.3
Author: Paid Memberships Pro
Author URI: https://www.paidmembershipspro.com
Text Domain: pmpro-shipping
Domain Path: /languages
*/

define( 'PMPRO_SHIPPING_VERSION', '1.3' );

/**
 * Load plugin textdomain.
 */
function pmproship_pmpro_load_textdomain() {
	load_plugin_textdomain( 'pmpro-shipping', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

add_action( 'init', 'pmproship_pmpro_load_textdomain' );

include_once( plugin_dir_path( __FILE__ ) . 'includes/deprecated.php' );

/**
 * Set up user fields for shipping address.
 *
 * @since 1.2
 */
function pmproship_add_user_fields() {
	global $pmpro_countries, $pmpro_default_country;

	// Don't break if PMPro is out of date or not loaded.
	if ( ! function_exists( 'pmpro_add_user_field' ) ) {
		return false;
	}

	// Get the list of level IDs that should have shipping fields.
	$all_levels      = pmpro_getAllLevels( true );
	$shipping_levels = array();
	foreach( $all_levels as $level_id => $level ) {
		if ( ! empty( get_option( 'pmpro_shipping_hidden_level_' . $level_id, false ) ) ) {
			continue;
		}
		$shipping_levels[] = $level_id;
	}

	// Add a user field group to put our fields into.
	pmpro_add_field_group( 'pmproship', esc_html__( 'Shipping Address', 'pmpro-shipping' ) );

	// Show the "same as billing" checkbox.
	pmpro_add_user_field(
		'pmproship',
		new PMPro_Field(
			'pmproship_same_billing_address',
			'checkbox',
			array(
				'label' => esc_html__( 'Ship to the billing address used above.', 'pmpro-shipping' ),
				'profile' => false,
				'required' => false,
				'levels' => $shipping_levels,
			)
		)
	);

	// Add text shipping address fields.
	$text_fields_map = array(
		'pmpro_sfirstname' => esc_html__( 'First Name', 'pmpro-shipping' ),
		'pmpro_slastname' => esc_html__( 'Last Name', 'pmpro-shipping' ),
		'pmpro_saddress1' => esc_html__( 'Address 1', 'pmpro-shipping' ),
		'pmpro_saddress2' => esc_html__( 'Address 2', 'pmpro-shipping' ),
		'pmpro_scity' => esc_html__( 'City', 'pmpro-shipping' ),
		'pmpro_sstate' => esc_html__( 'State', 'pmpro-shipping' ),
		'pmpro_szipcode' => esc_html__( 'Postal Code', 'pmpro-shipping' ), 
		'pmpro_sphone' => esc_html__( 'Phone', 'pmpro-shipping' ),
	);
	foreach( $text_fields_map as $meta_name => $label ) {
		pmpro_add_user_field(
			'pmproship',
			new PMPro_Field(
				$meta_name,
				'text',
				array(
					'label' => $label,
					'profile' => true,
					'required' => $meta_name !== 'pmpro_saddress2',
					'levels' => $shipping_levels,
					'memberslistcsv' => true,
				)
			)
		);
	}

	// Add a select field for country.
	pmpro_add_user_field(
		'pmproship',
		new PMPro_Field(
			'pmpro_scountry',
			'select',
			array(
				'label' => esc_html__( 'Country', 'pmpro-shipping' ),
				'profile' => true,
				'required' => true,
				'levels' => $shipping_levels,
				'options' => $pmpro_countries,
				'memberslistcsv' => true,
				'value' => $pmpro_default_country,
			)
		)
	);
}
add_action( 'init', 'pmproship_add_user_fields' );

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

	$confirmation_message .= '<h2>' . __( 'Shipping Information:', 'pmpro-shipping' ) . '</h2><p>' . $shipping_address . '</p>';


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

	if ( class_exists( 'MemberOrder' ) ) {
		//Get the order from the email. We need to determine if the user coming matches with order user.
		$order_id = isset( $pmpro_email->data['order_id'] ) ? $pmpro_email->data['order_id'] : null;
		//if we have an order_id, we can get the user_id from the order
		if( ! empty( $order_id ) ) {
			$order = new MemberOrder( $order_id );
			//If the user id from the order is different from the user id from the email, we will use the user id from the order.
			if( $user_id != $order->user_id ) {
				$user_id = $order->user_id;
			}
		}
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
    <h2 class="topborder"><?php	 esc_html_e( 'Shipping Address', 'pmpro-shipping' ); ?></h2>
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

<?php

/**
 * Add a shipping address field to the checkout page with "sameas" checkbox.
 *
 * @deprecated 1.2
 */
function pmproship_pmpro_checkout_boxes() {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}


/**
 * Get fields on checkout page.
 *
 * @deprecated 1.2
 */
function pmproship_pmpro_checkout_preheader() {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}

/**
 * Choose which hook to use to update user meta values.
 * For PayPal Standard, 2Checkout, CCBill, and Payfast, we need to
 * run this code before we redirect away.
 * For other gateways, including onsite gateways and PayPal express,
 * we run this code after checkout.
 *
 * @deprecated 1.2
 */
function pmproship_pmpro_checkout_preheader_check_gateway() {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}

/**
 * Update a user meta values.
 *
 * @deprecated 1.2
 */
function pmproship_save_shipping_to_usermeta($user_id) {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}


/**
 * Show the shipping address in the profile
 *
 * @deprecated 1.2
 */
function pmproship_show_extra_profile_fields( $user ) {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}

/**
 * Show the shipping address in the frontend profile
 *
 * @deprecated 1.2
 */
function pmproship_show_extra_frontend_profile_fields( $user ) {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}

/**
 * Save profile fields
 *
 * @deprecated 1.2
 */
function pmproship_save_extra_profile_fields( $user_id ) {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}

/**
 * These bits are required for PayPal Express
 * Save fields to session so we can update them
 * after returning from PayPal
 *
 * @deprecated 1.2
 */
function pmproship_save_shipping_to_session() {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}

/**
 * Are one of the shipping address data fields set?
 *
 * @deprecated 1.2
 *
 * @param array $object
 *
 * @return bool
 */
function pmproship_is_shipping_set( $object = NULL ) {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}

/**
 * Require the shipping fields (optional)
 *
 * @deprecated 1.2
 */
function pmproship_pmpro_registration_checks( $okay ) {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}

/**
 * Use a dropdown for state in the billing fields
 *
 * @deprecated 1.2
 */
function pmproship_pmpro_state_dropdowns( $use ) {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}

/**
 * Add column to export
*/
//columns
function pmproship_pmpro_members_list_csv_extra_columns( $columns ) {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}


//call backs
function pmproship_extra_column_sfirstname( $user ) {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}

function pmproship_extra_column_slastname( $user ) {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}

function pmproship_extra_column_saddress1( $user ) {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}

function pmproship_extra_column_saddress2( $user ) {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}

function pmproship_extra_column_scity( $user ) {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}

function pmproship_extra_column_sstate( $user ) {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}

function pmproship_extra_column_szipcode( $user ) {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}


function pmproship_extra_column_sphone( $user ) {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}

function pmproship_extra_column_scountry( $user ) {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}

/**
 * Actually hide/disable shipping address for these levels.
 *
 * @deprecated 1.2
 */
function pmproship_hide_shipping() {
	_deprecated_function( __FUNCTION__, '1.2', 'pmproship_add_user_fields' );
}
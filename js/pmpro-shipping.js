/**
 * Copyright (c) 2017 - Stranger Studios, LLC
 */
jQuery(document).ready(function($){
    "use strict";

	function pmproship_billing_fields_visible() {
		return $('#pmpro_billing_address_fields').length && $('#pmpro_billing_address_fields').css('display') !== 'none';
	}

	function pmproship_sync_with_billing() {
		if (pmproship_billing_fields_visible()) {
			$('#pmproship_same_billing_address_div').show();

			// Move the shipping address fields to after the billing address fields.
			// Post 3.1
			$('#pmpro_billing_address_fields').after( $('#pmpro_form_fieldset-pmproship') );
			// Pre 3.1
			$('#pmpro_billing_address_fields').after( $('#pmpro_checkout_box-pmproship') );
		} else {
			$('#pmproship_same_billing_address_div').hide();
		}

		pmproship_update_shipping_fields();
	}

	function pmproship_update_shipping_fields() {
		// If the "same as billing" checkbox is checked, hide the shipping fields and copy the values. Otherwise, show them.
		if (pmproship_billing_fields_visible() && $('#pmproship_same_billing_address').is(':checked')) {
			// Post 3.1
			$('#pmpro_form_fieldset-pmproship .pmpro_form_field-text, #pmpro_form_fieldset-pmproship .pmpro_form_field-select').each(function (index, element) {
				$(element).hide();
			});

			// Pre 3.1
			$('#pmpro_checkout_box-pmproship .pmpro_checkout-field-text, #pmpro_checkout_box-pmproship .pmpro_checkout-field-select').each(function (index, element) {
				$(element).hide();
			});

			// Copy the billing fields to the shipping fields.
			$('#pmpro_billing_address_fields input, #pmpro_billing_address_fields select').each(function (index, element) {
				// Get the name of the shipping field.
				let shipping_field_name = element.name;

				// Replace the first character with 'pmpro_s' to get the name of the shipping field.
				shipping_field_name = 'pmpro_s' + shipping_field_name.substr(1);

				// Set the value of the shipping field to the value of the billing field.
				$( '#' + shipping_field_name ).val( element.value );
			} );
		} else {
			$('#pmpro_form_fieldset-pmproship .pmpro_form_field-text, #pmpro_form_fieldset-pmproship .pmpro_form_field-select').each(function (index, element) {
				$(element).show();
			});

			$('#pmpro_checkout_box-pmproship .pmpro_checkout-field-text, #pmpro_checkout_box-pmproship .pmpro_checkout-field-select').each(function (index, element) {
				$(element).show();
			});
		}
	}

	// Update the shipping fields even if billing fields are initially hidden.
	$( '#pmproship_same_billing_address' ).on( 'change', pmproship_update_shipping_fields );
	$( '#pmpro_btn-submit' ).on( 'click', pmproship_update_shipping_fields );

	// Other add-ons can show or hide the billing fields after document ready.
	if ($('#pmpro_billing_address_fields').length) {
		var billing_observer = new MutationObserver(pmproship_sync_with_billing);
		billing_observer.observe($('#pmpro_billing_address_fields')[0], { attributes: true, attributeFilter: ['style'] });
	}
	$(window).on('load', pmproship_sync_with_billing);
	pmproship_sync_with_billing();
});

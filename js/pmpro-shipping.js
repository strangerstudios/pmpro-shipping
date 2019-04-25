/**
 * Copyright (c) 2017 - Stranger Studios, LLC
 */

var pmpro_shipping = {};

jQuery(document).ready(function($){
    "use strict";

    pmpro_shipping = {
        init: function() {
            this.sameas_checkbox = $('#sameasbilling');
            this.fields = $('#shipping-fields');
			this.inputs = $('#pmpro_shipping_address_fields').find('input');
			this.show_sameas_timer = null;
			
            var self = this;			
			
			//hide/show shipping fields and copy when clicking sameas
            self.sameas_checkbox.unbind('change').on('change', function() {              
				//maybe copy
				self.maybe_copy_data( this );				
            });
			
			//hide the sameas button if the billing address is not visible
			self.checkBillingAddressVisibilityForSameAsCheckbox();
        },
        maybe_copy_data: function( element ) {

            var self = this;

            if (element.checked) {				
				//hide the fields

				jQuery( '#scountry' ).val( jQuery( '#bcountry' ).val() );

				self.fields.hide();
				
				//copy the fields			
                self.inputs.each( function() {					
					var me = $(this);
										
					//skip the sameas checkbox
					if(!me.attr('id') != 'sameasbilling') {					
						var $bfield_name = me.attr('id').replace('s', 'b');
						//window.console.log("Replaced " + me.attr('id') + ' to locate ' + $bfield_name );
						// Copy content of billing field to shipping field
						me.val( $("#" + $bfield_name ).val() );
					}
                });
            } else {				
				//show the fields
				self.fields.show();				
			}
        },
		checkBillingAddressVisibilityForSameAsCheckbox: function() {
			var baddress = $('#baddress1');
			var pmpro_shipping_address_fields = $('#pmpro_shipping_address_fields');
			
			var self = this;
			
			if(this.sameas_checkbox.is(':checked')) {					
				this.fields.hide();
			}

			if(baddress.length && baddress.is(':visible')) {
				$('#sameasbilling_wrapper').show();
			}
			else if (pmpro_shipping_address_fields.is(':visible'))
			{
				this.sameas_checkbox.attr('checked', false);
				$('#sameasbilling_wrapper').hide();						
				this.fields.show();
			}
			//check again in .2 seconds
			this.show_sameas_timer = setTimeout(function(){self.checkBillingAddressVisibilityForSameAsCheckbox();}, 200);
		}			
    };

    pmpro_shipping.init();			
});
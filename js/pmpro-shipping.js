/**
 * Copyright (c) 2017 - Stranger Studios, LLC
 */

var pmpro_shipping = {};

jQuery(document).ready(function($){
    "use strict";

    pmpro_shipping = {
        init: function() {
            this.sameas_checkbox = $('#sameasbilling');
            this.inputs = $('#pmpro_shipping_address_fields').find('input');

            var self = this;

            //
            self.sameas_checkbox.unbind('change').on('change', function() {
                self.maybe_copy_data( this );
            });
        },
        maybe_copy_data: function( element ) {

            var self = this;

            if (element.checked) {

                self.inputs.each( function() {
                    var me = $(this);
                    var $bfield_name = me.attr('id').replace('s', 'b');
                    window.console.log("Replaced " + me.attr('id') + ' to locate ' + $bfield_name );
                    // Copy content of billing field to shipping field
                    $(me).val( $("#" + $bfield_name ).val() );
                });
            }
        }
    };

    pmpro_shipping.init();
});
=== Paid Memberships Pro - Shipping Add On ===
Contributors: strangerstudios
Tags: paid memberships pro, shipping, shipping address, 
Requires at least: 3.0
Tested up to: 4.5
Stable tag: .3.3

Adds shipping fields to the Paid Memberships Pro checkout.

== Description ==

Adds shipping fields to the checkout page, confirmation page, confirmation emails, member's list and edit user profile pages.

== Installation ==

1. Make sure you have the Paid Memberships Pro plugin installed and activated.
1. Upload the `pmpro-shipping` directory to the `/wp-content/plugins/` directory of your site.
1. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= I found a bug in the plugin. =

Please post it in the GitHub issue tracker here: https://github.com/strangerstudios/pmpro-shipping/issues

= I need help installing, configuring, or customizing the plugin. =

Please visit our premium support site at http://www.paidmembershipspro.com for more documentation and our support forums.

== Changelog ==
= .3.3 =
* BUG/ENHANCEMENT: Now sanitizing and validating the hide_shipping/edit parameter when editing a level.
* BUG/ENHANCEMENT: Wrapped the Shipping Information label for localization in the confirmation message. (Thanks, shr3k on GitHub)

= .3.2 =
* BUG: Fixed warning with hide_shipping option when saving a level in the dashboard.

= .3.1 =
* BUG: Now unestting SESSION variables after checkout in case someone refreshes the review page with PayPal Express.
* ENHANCEMENT: Updated to hide the shipping fields on the review page when using PayPal Express.

= .3 =
* FEATURE: Added a checkbox to hide the shipping address fields for certain levels.
* ENHANCEMENT: Now hiding the "same as Billing Address" checkbox if the billing address is not visible.

= .2.6 =
* Shipping information is now populated on the checkout page.

= .2.5 =
* PMPro Shipping will no longer override other members list CSV export columns added by other addons/code.

= .2.4 =
* State field on profile page is now a free text field instead of a dropdown.
* Wrapped strings with localization functions. They use the "pmpro" domain.
* Fixed code to require the shipping fields.

= .2.3 =
* Updated required fields to show an asterisk. Set PMPRO_SHIPPING_SHOW_REQUIRED to false to set back to the old method where only optional fields showed (optional).
* Using JavaScript to show the #sameasbilling checkbox only if the #baddress1 field is on the page and visible.

= .2.2.1 =
* Fixed bug with members list CSV columns.

= .2.2 =
* Upgraded from gist to GitHub plugin.
* First version with a readme.

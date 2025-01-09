=== Paid Memberships Pro - Mailing Address Add On ===
Contributors: strangerstudios
Tags: paid memberships pro, mailing, mailing address,
Requires at least: 5.0
Tested up to: 6.5
Stable tag: 1.3

Adds mailing fields to the Paid Memberships Pro checkout.

== Description ==

Adds mailing fields to the checkout page, confirmation page, confirmation emails, members list and edit user profile pages.

[Read the full documentation for the Mailing Address Add On](https://www.paidmembershipspro.com/add-ons/shipping-address-membership-checkout/)

= Official Paid Memberships Pro Add On =

This is an official Add On for [Paid Memberships Pro](https://www.paidmembershipspro.com), the most complete member management and membership subscriptions plugin for WordPress.

== Installation ==

1. Make sure you have the Paid Memberships Pro plugin installed and activated.
1. Upload the `pmpro-shipping` directory to the `/wp-content/plugins/` directory of your site.
1. Activate the plugin through the 'Plugins' menu in WordPress.

Fields will automatically be captured for all membership levels. You can remove the fields for a level on the Memberships > Settings > Edit Membership Level > "Hide Mailing Address" ssetting.

== Frequently Asked Questions ==

= I found a bug in the plugin. =

Please post it in the GitHub issue tracker here: https://github.com/strangerstudios/pmpro-shipping/issues

= I need help installing, configuring, or customizing the plugin. =

Please visit our premium support site at http://www.paidmembershipspro.com for more documentation and our support forums.

== Changelog ==
= 1.3 - 2024-07-10 =
* ENHANCEMENT: Added support for V3.1+ Paid Memberships Pro frontend changes and kept backwards compatibility for older versions. (@MaximilianoRicoTabo, @andrewlimaza)

= 1.2 - 2024-04-24 =
* ENHANCEMENT: Added shipping fields to the "Edit Member" page for PMPro v3.0+. #56 (@dparker1005)
* ENHANCEMENT: Updated `<h3>` tags to `<h2>` tags for better accessibility. #56 (@michaelbeil)
* BUG FIX: Fixed issue where shipping fields were not being saved when using PayPal Express. #56 (@dparker1005)
* BUG FIX: Fixed issue where shipping fields were not being saved when using Stripe Checkout. #56 (@dparker1005)
* REFACTOR: Now creating shipping fields as User Fields instead of coding them manually in the plugin. #56 (@dparker1005)
* DEPRECATED: Removed functionality for the `PMPRO_SHIPPING_SHOW_REQUIRED` constant. #56 (@dparker1005)

= 1.1 - 2020-11-27 =
* BUG FIX/ENHANCEMENT: Updated to use pmpro_is_checkout to conditionally load the JavaScript.
* BUG FIX: Fixed spacing for address in Members List.
* BUG FIX: Fixed incorrect textdomain for "Phone" field.
* BUG FIX: Removed <br> tag before output of Shipping Address details on Membership Confirmation page.

= 1.0 - 2020-04-30 =
* BUG FIX/ENHANCEMENT: Checking if user has a membership that includes shipping fields or is an admin before displaying fields.
* ENHANCEMENT: Added support for PMPro v2.3+ frontend profile.
* ENHANCEMENT: Setting to v1.0 to reflect the stability of the functionality and code base.

= .8 - 2020-01-06 =
* ENHANCEMENT: Added phone data to confirmation message, email and Member's List area.
* ENHANCEMENT: General code improvements and optimization.
* BUG FIX: Improved registration checks for when users did not select the "Same as Billing" option.
* BUG FIX/ENHANCEMENT: Better support for PayPal and other offsite gateways.

= .7 =
* ENHANCEMENT: Support State Dropdown Add On.
* ENHANCEMENT: Added in phone field support for shipping address.
* ENHANCEMENT: Improved internationalization for translating the plugin.

= .6 =
* BUG FIX: Fixed bugs where shipping address was not being saved. Rewrote the logic that figures out when and how to save shipping to user meta based on the chosen gateway.
* BUG FIX: Fixed bugs where the "same as" checkbox was no longer toggling the shipping address fields or being hidden when there was no billing address to copy.
* BUG FIX/ENHANEMENT: Now checking if PMPRO_SHIPPING_SHOW_REQUIRED is already defined so you can override it in wp-config.php instead of having to edit this plugin.

= .5 =
* ENHANCEMENT: Copying billing to shipping address when using the Add PayPal Express Option at Checkout and Pay By Check add-ons
* ENHANCEMENT/FIX: Didn't save Shipping Address when using PayPal Standard
* ENHANCEMENT: Improved fields display on membership checkout page to use no tables for compatibility with Paid Memberships Pro v1.9.4.

= .4 =
* BUG FIX: Fixed warnings related to use of get_usermeta.
* BUG FIX: Fixed issue where shipping fields continued to show when "same as" was selected.
* ENHANCEMENT: Added a pmproship_required_shipping_fields filter.

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

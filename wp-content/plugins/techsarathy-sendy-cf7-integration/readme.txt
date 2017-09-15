=== Techsarathy Sendy CF7 Integration ===
Contributors: rktaiwala, techsarathy
Donate link: http://ko-fi.com/Buttons/Buy/645MTM78N8ZC
Tags: email, campaign, email campaign, email marketing, sendy email, sendy, sendy campaign, contactform7, contact form 7
Requires at least: 4.1.1
Tested up to: 4.5
Stable tag: 1.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Sendy integration for Contact Form 7. 

== Description ==
**Please drop me a message, if there is any problem in using the plugin.**

If you are using Sendy to handle your subscription, then this plugin is for you.

Integrate your Sendy Lists in your subscription froms easily.

Create form using Contact Form 7 plugin.

Use any number of Lists.

Manage Sendy Lists from WordPress.

Shows number of subscribers subscribed to a particular list right on the WordPress.

How to use it?

1. Get your Sendy API key from your Sendy installation.
2. Keep Sendy installation URL handy.
3. Open your WordPress Dashboard.
4. Locate Sendy List in the menu.
5. Under Sendy List menu choose Settings.
6. Enter Sendy API and Sendy installation URL.
7. Now create New Sendy List, enter your Sendly List ID (To get Sendy list ID, go to your Sendy Installation and select the brand, under the brand select all lists, List ID will be on the left side of List Name )
8. Create the Form Using Contact Form 7, you can use any number of fields just name them as ts_your-field-name. You need to include hidden field [hidden ts_sendy_hidden “true”] in your form.
9. Include the shortcode [tssendy] in the form to list all the lists from Sendy.
10. If you just want to subscribe users to a particular list you can do so by using the shortcode **[tssendy listID “your_id”]**. You can get the listID from the Sendy List Screen.
11. Use the contact form 7 shortcode as usual.
12. Thats it. No more steps.


== Installation ==

How to install?

**Note:** It needs Contact Form 7 and Contact Form 7 Modules installed

1. Upload `techsarathy-sendy-cf7-integration` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

Or
Install it via WordPress Plugins menu.

== Frequently Asked Questions ==

Initial Version yet to get some questions
== Usuage ==

How to use it?

1. Get your Sendy API key from your Sendy installation.
2. Keep Sendy installation URL handy.
3. Open your WordPress Dashboard.
4. Locate Sendy List in the menu.
5. Under Sendy List menu choose Settings.
6. Enter Sendy API and Sendy installation URL.
7. Now create New Sendy List, enter your Sendly List ID (To get Sendy list ID, go to your Sendy Installation and select the brand, under the brand select all lists, List ID will be on the left side of List Name )
8. Create the Form Using Contact Form 7, you can use any number of fields just name them as ts_your-field-name. You need to include hidden field [hidden ts_sendy_hidden “true”] in your form.
9. Include the shortcode [tssendy] in the form to list all the lists from Sendy.
10. If you just want to subscribe users to a particular list you can do so by using the shortcode **[tssendy listID “your_id”]**. You can get the listID from the Sendy List Screen.
11. Use the contact form 7 shortcode as usual.
12. Thats it. No more steps.

== Screenshots ==

1. Admin Settings Screen.
2. Sendy List Screen
3. Add New List Screen


== Changelog ==
Version 1.1.0 
— Bug Fixes
— Translation supported

Version 1.0.10 Resolved the issue caused by change in accessing the Contact Form 7 messages property. This fix seems to fix all the issue that was caused by the last update.

Version 1.0.8 Fixed issues with contact form 7 shortcode atts extraction, which was causing problem when listId was used.

Version 1.0.7 Fixed Radio Button CSS Issue

Version 1.0.5 Add Feature to Enable/Disable Skip Mail

Version 1.0.1 Updated to allow single list subscription

Version 1.0.0 Initial Version
== Upgrade Notice ==
Version 1.1.0 Added support for translation, bug fixes

Version 1.0.5 Added option to Send Mail while Subscribing

Version 1.0.4 Fixed List Output

Version 1.0.3 Fixed Shortcode display error

Version 1.0.1 Updated to allow single list subscription

Version 1.0.0 Initial Version

Version 1.1.1 Temporary fix for checkbox.
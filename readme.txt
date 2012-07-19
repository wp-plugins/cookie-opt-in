=== Cookie Opt In ===
Contributors: clearsite
Donate link: http://clearsite.nl/
Tags: european union, cookie, legal, consent
Requires at least: 3.2.1
Tested up to: 3.4.1
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

European Union law state you must ask permission for cookies. This plugin handles that for you.

== Description ==

European law states:

+ A website must inform the visitor about both presence and function of each cookie the website creates
+ A website must ask permission for all cookies other than cookies required for the correct function of the website

Cookies you ARE ALLOWED to create WITHOUT permission are
* Session cookies
* E-commerce cookies that provide a function for the visitor, like shopping cart or product filter settings
* Cookies that define the cookie-preferences of the user

You still need to INFORM the visitor.

Cookies you are NOT allowed to create without permission are
* Analytics cookies
* Advertisement cookies
* Any cookie from a third party (i.e. e.g. neither your website nor your visitor)

Again, you also need to INFORM the visitor.

This plugin will handle all these for you, but it takes some configuration.
If the "offending" scripts are added by action, you can configure the plugin to remove_action it when appropriate.
If an action-removal is not possible you must adapt your plugins and themes.

Technical instructions are available in the plugin after installation.
Also help is available*, for contact details, see the plugin admin pages.

(*) Pricing for help, if applicable, available upon request.

== Installation ==

The plugin installation is pretty straightforward.
1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. See the admin pages for more info.

== Frequently Asked Questions ==

No questions asked as of yet, leave a comment on wordpress.org if you need help or contact us by other means.

== Screenshots ==

1. First visit shows this form. The content of the form is dependant on the configuration, the styling is done by CSS.
1. The INFO that is set in settings is visable, in this case, by clicking the ? . A read-more link is only shown when an URL is filled in.
1. When the visitor has made a choice, (s)he can change it by clicking the cookie (also highly customisable).

== Changelog ==

= 1.0.1 =
* Initial release to WordPress.org

== Arbitrary section ==

You may provide arbitrary sections, in the same format as the ones above.  This may be of use for extremely complicated
plugins where more information needs to be conveyed that doesn't fit into the categories of "description" or
"installation."  Arbitrary sections will be shown below the built-in sections outlined above.

== Upgrade Notice ==

* No upgrade notice yet.

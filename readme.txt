=== JM Instagram Feed Widget ===
Contributors: jmlapam
Donate Link: http://www.amazon.fr/registry/wishlist/1J90JNIHBBXL8
Tags: widget, instagram, image, feed, media
Tested up to: 3.9.1
License: GPLv2 or later
Stable tag: trunk
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easy integration of your latest Instagram Pics in WordPress !

== Description ==

The plugin adds a widget you can set to display your Instagram feed. No need to configure any application, just logged in <a href="http://instagram.com/developer/api-console/">Instagram API Console</a> to get your user ID and access token.
You have full control ! No email registration, no third-party service (except Instagram of course), just you, your WordPress and your instagram ^^

<a href="http://twitter.com/intent/user?screen_name=tweetpressfr">Follow me on Twitter</a>


== Installation ==

1. Upload plugin files to the /wp-content/plugins/ directory
2. Activate the plugin through the Plugins menu in WordPress
3. A new widget will appear, just grab it and define your settings
4. Use the customizer to set it the first time

== Frequently asked questions ==

= How can I get this "userID" and "access_token" parameters ? =

1. Go to <a href="http://instagram.com/developer/api-console/">Instagram API Console</a>
2. Log in with your credentials (the same you use for your mobile app)
3. Select "OAuth2" in the dropdown menu for "Authentication" column, you'll see a popup appear to authorize the authentication ("sign in with Instagram")
4. Then just sign in with Instagram and you'll be able to select request in the dropdown menu for "Service" column (the 1rst column)
5. Just select "GET users/{user-id}" and click on the "send" button => you will get your user ID and access token, user ID is the first figures of the access token : userID.xxxxxxx.xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx 
6. Copy past these credentials in the widget settings to get your latest pics in WordPress
7. Enjoy ^^

== Changelog ==

= 1.0 =
* 19 June 2014
* Initial release
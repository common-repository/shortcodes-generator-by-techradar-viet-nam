=== Shortcodes Generator by TechRadar Việt Nam ===
Tags: shortcodes generator, bootstrap, shortcode
Author URI: http://techradar.vn
Requires at least: 4.9
Tested up to: 4.9.2
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Shortcodes Generator By TechRadar Việt Nam

== Description ==
Now you can with the Shortcodes Generator By TechRadar Việt Nam
you can create as many shortcodes as you want, and use them where ever you need them.
You can add them to pages, posts, template files, or even add a shortcode as a widget!
It built base on bootstrap 3 and allows you can disable bootstrap 3 in case your theme loaded already bootstrap 3.

Features:
    - Create unlimited shortcodes
    - Add shortcodes to pages, posts, or template files
    - Allows overwrite to custom template of shortcode
    - Allows developer add extra new shortcode
    - Add a shortcode as a widget
    - Add a shortcode using a WYSIWYG editor, or a plain text
    - Base on bootstrap 3
    - 24 Shortcodes

== Screenshots ==
1. Create unlimited shortcodes
2. Base on bootstrap 3

== Installation ==
1. Download and unzip plugin
2. Upload the 'zf-shortcodes' folder to the '/wp-content/plugins/' directory,
3. Activate the plugin through the 'Plugins' menu in WordPress.
== For developer ==

1, Add shortcode

You can add new shortcode with this hook
do_action(‘zf_shortcode_configs’, $this);

2, Custom template of shortcode

Create a zf-shortcodes folder on active theme, then copy default template of plugin into this folder

3, Disable assets

In while your theme loaded this assets with filter, the plugin support 3 filters to disable it

// Bootstrap 3
apply_filters(‘zf_enable_bootrap3’, true);
// Awesome Fonts
apply_filters(‘zf_enable_awesomefont’, true);
// Animation
apply_filters(‘zf_enable_animation’, true);

== Changelog ==



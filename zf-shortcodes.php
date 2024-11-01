<?php
/*
Plugin Name: Shortcodes Generator By TechRadar Việt Nam
Plugin URI: https://techradar.vn/lap-trinh/wordpress/shortcodes-generator-by-techradar-viet-nam.html
Description: A shortcode generator base on bootstrap 3.
Version: 1.0.0
Author: TechRadar Việt Nam
Author URI: https://techradar.vn
License:      GPL2
License URI:  GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: zf-shortcodes
*/

// define
define('ZF_SHORTCODES_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('ZF_SHORTCODES_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define('ZF_SHORTCODES_PLUGIN_FILE', plugin_dir_path(__FILE__) . 'zf-shortcodes.php');
define('ZF_SHORTCODES_THEME_PATH', get_template_directory() . '/');
define('ZF_SHORTCODES_LANG',  'zf-shortcodes');
// Require Core
require_once(ZF_SHORTCODES_PLUGIN_PATH . 'inc/core.php');
$GLOBALS['ZF_Shortcodes'] = ZF_Shortcodes::get_instance();


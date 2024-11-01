<?php
/**
 * @version    $Id$
 * @package    Shortcodes Generator By TechRadar Việt Nam
 * @author     TechRadar Việt Nam
 * @copyright  Copyright (C) 2018 TechRadar Việt Nam All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */



/**
 * Class ZF_Shortcodes base
 */
class ZF_Shortcodes
{

    protected static $instance = null;

    public $configs = null;


    public $out_custom_style = '';

    public $scripts = '';

    public function __construct() {

        // require
        require_once(ZF_SHORTCODES_PLUGIN_PATH . 'inc/config.php');
        require_once(ZF_SHORTCODES_PLUGIN_PATH . 'inc/functions.php');
        require_once(ZF_SHORTCODES_PLUGIN_PATH . 'inc/register.php');

        // Actions
        add_action('plugins_loaded', array( &$this, 'load_textdomain' ) );
        add_action('init', array(&$this, 'init'));
        add_action('wp_enqueue_scripts', array(&$this, 'load_assets'));
        add_action('wp_footer', array ( $this, 'output_custom_style' ), 100 );
        // Filters
        add_filter('the_content', array($this, 'zf_clean_shortcode'));
    }

    /**
     * Return an instance of this class.
     */
    public static function get_instance() {

        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Init
     */
    public function init()
    {
        $this->configs = ZF_Shortcodes_Configs::get_instance();
        $this->shortcodes = $this->configs->get_shortcodes();
        $this->register = new ZF_Shortcodes_Register($this->configs, $this);
    }

    /**
     * Load Localisation files.
     */
    public function load_textdomain() {

        $domain = ZF_SHORTCODES_LANG;
        $locale = apply_filters( 'zf_plugin_locale', get_locale(), $domain );

        if ( $loaded = load_textdomain( 'zf-shortcodes', trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' ) ) {
            return $loaded;
        } else {
            load_plugin_textdomain( 'zf-shortcodes', FALSE, basename(ZF_SHORTCODES_PLUGIN_PATH) . '/languages/' );
        }

    }

    /**
     * Display assets for shortcode
     */
    public function output_custom_style() {

        if ( $this->out_custom_style ) {
            echo '<style type="text/css" id="zf-output-custom-style">' . $this->out_custom_style . '</style>';
        }

        if ($this->scripts) {
            echo $this->scripts;
        }
    }

    /**
     * Add a custom style
     * @param $data
     */
    public function add_custom_style($data) {
        $this->out_custom_style .= $data;
    }

    /**
     * Add extra javascript
     * @param $data
     */
    public function add_scripts($data) {
        $this->scripts .= $data;
    }

    /**
     * load assets for plugins
     */
    public function load_assets()
    {
        wp_enqueue_script('jquery');

        // Bootstrap 3
        $enable_bootstrap3 = apply_filters('zf_enable_bootrap3', true);
        // Awesome Fonts
        $enable_awesome_font = apply_filters('zf_enable_awesomefont', true);
        // Animation
        $enable_animation = apply_filters('zf_enable_animation', true);
        $animation_on_mobile = apply_filters('zf_animation_on_mobile', true);
        $animation_offset = apply_filters('zf_animation_offset', 200);
        if ($enable_bootstrap3) {
            wp_enqueue_style('zf-shortcodes-bootstrap3', ZF_SHORTCODES_PLUGIN_URL . 'assets/libs/bootstrap/css/bootstrap.min.css', array(), null, 'all');
            wp_enqueue_script('zf-shortcodes-bootstrap3', ZF_SHORTCODES_PLUGIN_URL . 'assets/libs/bootstrap/js/bootstrap.min.js', array('jquery'), null, true);
        }

        if ($enable_awesome_font)  {
            wp_enqueue_style('zf-shortcodes-font-awesome4', ZF_SHORTCODES_PLUGIN_URL . 'assets/libs/font-awesome/css/font-awesome.min.css', array(), null, 'all');
        }
        if ($enable_animation) {
            wp_enqueue_style('zf-shortcodes-animation', ZF_SHORTCODES_PLUGIN_URL . 'assets/css/animate.css', array(), null, 'all');
            wp_enqueue_script('zf-shortcodes-wow', ZF_SHORTCODES_PLUGIN_URL . 'assets/libs/wow/wow.min.js', array('jquery'), null, true);
        }

        wp_enqueue_style('zf-shortcodes-style', ZF_SHORTCODES_PLUGIN_URL . 'assets/css/style.css', array(), null, 'all');

        wp_enqueue_script('zf-shortcodes', ZF_SHORTCODES_PLUGIN_URL . 'assets/js/zf-shortcodes.min.js', array('jquery'), null, true);
        wp_localize_script( 'zf-shortcodes', 'zfv_shortcode_front', array(
            'theme_url' => '',
            'animation' => $enable_animation,
            'animation_on_mobile' => (bool)$animation_on_mobile,
            'animation_offset' => $animation_offset
        ));
    }


    /**
     * Clean shortcode
     * @param $content
     * @return mixed
     */
    function zf_clean_shortcode($content) {
        global $shortcode_tags;

        $zf_shortcodes = array_filter(array_keys($shortcode_tags), function ($key) {
            if (preg_match('/^zf_/', $key)) {
                return true;
            }
        });

        $block = join("|", array_map('preg_quote', $zf_shortcodes));

        // opening tag
        $content = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>|<br>)?/", "[$2$3]", $content);

        // closing tag
        $content = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>|<br>)/", "[/$2]", $content);
        /* Remove any instances of ''. */
        $content = str_replace(array('<p></p>', '</p> </p>', '<br>', '<br />'), '', $content);

        return $content;
    }

}

<?php
/**
 * @version    $Id$
 * @package    Shortcodes Generator By TechRadar Việt Nam
 * @author     TechRadar Việt Nam
 * @copyright  Copyright (C) 2018 TechRadar Việt Nam All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

class ZF_Shortcode_Admin
{

    private $configs = null;


    public function __construct($configs) {
        $this->configs = $configs;
        add_action('media_buttons', array( $this, 'button' ), 300 );
        add_action('admin_enqueue_scripts', array($this, 'assets'), 100);
    }


    /**
     * Generator button
     */
    public function button( $element_id = 'content') {

        $button = '';

        $img = '';
        $attributes = '';
        $button .= sprintf( '<a href="javascript:void(0);"%s class="button zf-insert-shortcode-button" data-mfp-src="%s" title="%s">%s</a>',
            $attributes,
            esc_attr('#zf-shortcode-popup'),
            __( 'Insert Shortcode' , ZF_SHORTCODES_LANG ),
            $img . __( 'Insert Shortcode' , ZF_SHORTCODES_LANG ));

        // template dialog
        add_action( 'admin_footer', array( $this, 'dialog' ) );
        // assets
        wp_enqueue_media();
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_style('jquery-ui-tabs');
        wp_enqueue_script('jquery-ui-tabs');

        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');

        wp_enqueue_style('zf-magnific-popup');
        wp_enqueue_style('zf-magnific-effect');
        wp_enqueue_script('zf-magnific-popup');

        wp_enqueue_style('zf-shortcodes-font-awesome4');
        wp_enqueue_style('zf-shortcode-popup');
        wp_enqueue_script('zf-popup');


        echo $button;
    }

    public function assets() {

        wp_register_style('zf-shortcodes-font-awesome4', ZF_SHORTCODES_PLUGIN_URL . 'assets/libs/font-awesome/css/font-awesome.min.css');
        wp_register_style('zf-shortcode-popup', ZF_SHORTCODES_PLUGIN_URL . 'inc/admin/assets/css/popup.css');

        wp_register_style('zf-magnific-popup', ZF_SHORTCODES_PLUGIN_URL . 'assets/libs/magnific-popup/magnific-popup.css');
        wp_register_style('zf-magnific-effect', ZF_SHORTCODES_PLUGIN_URL . 'assets/libs/magnific-popup/effect.css');
        wp_register_script('zf-magnific-popup', ZF_SHORTCODES_PLUGIN_URL . 'assets/libs/magnific-popup/jquery.magnific-popup.min.js', array(), null, true);
        wp_register_script('zf-popup', ZF_SHORTCODES_PLUGIN_URL . 'inc/admin/assets/js/popup.min.js', array(), null, true);
        wp_localize_script('jquery', 'zf_shortcode_var', array(
            'plugin_url' => ZF_SHORTCODES_PLUGIN_URL,
            'remove_tab' => __('Cannot remove! if it only one tab item', ZF_SHORTCODES_LANG)
        ));

    }

    public function dialog() {
        include_once ( dirname(__FILE__) . '/dialog.php');
    }

}

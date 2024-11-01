<?php
/**
 * @version    $Id$
 * @package    Shortcodes Generator By TechRadar Việt Nam
 * @author     TechRadar Việt Nam
 * @copyright  Copyright (C) 2018 TechRadar Việt Nam All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

if( file_exists( dirname(__FILE__) . '/options.php') ) {
    require_once(dirname(__FILE__) . '/options.php');
} else {
    return __('Not found', ZF_SHORTCODES_LANG);
}

do_action('zf-dialog-header');
?>

<div id="zf-shortcode-popup" class="mfp-with-anim mfp-hide">
    <div class="zf-popup-header"><h3><?php _e('Shortcodes Generator', ZF_SHORTCODES_LANG);?></h3></div>
    <?php do_action('zf-popup-header'); ?>
<!--    --><?php //$shortcode->render(); ?>
    <span class="zf-menu-shortcodes">M<span></span></span>
    <div class="zf-popup-content">
        <div class="content-left">

            <div class="zf-shortcode-filter">
                <label for="filter-by-type"><?php _e('Filter by type', ZF_SHORTCODES_LANG);?>: </label>
                <?php
                $types = $this->configs->get_shortcodes_types();
                ?>
                <select name="filter-by-type" id="filter-by-type">
                    <option value="all"><?php _e('All', ZF_SHORTCODES_LANG);?></option>
                    <?php
                    foreach ($types as $type => $value) {
                        echo '<option value="'.$type.'">'. ucfirst($type) .'</option>';
                    }
                    ?>
                </select>
            </div>
            <hr/>
            <div class="zf-shortcode-list">
                <ul>
                    <?php
                    $shortcodes = $this->configs->get_shortcodes();

                    if (!empty($shortcodes)) {
                        $first_tab = 0;

                        foreach ($shortcodes as $key => $configs) {
                            $first_tab++;
                            $first_current = '';
                            if ($first_tab == 1) {
                                $first_current = ' sc-current';
                            }
                            echo '<li class="zf-shortcode-tab'.$first_current.'" data-tab="tab-'.$key.'" data-filter="'.$this->configs->get_shortcode_type($key).'">'.$configs['title'].'</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="content-right">
            <?php
                $shortcodes = $this->configs->get_shortcodes();
                if (!empty($shortcodes)) {
                    $first_tab = 0;
                    foreach ($shortcodes as $key => $configs) {
                        $first_tab++;
                        $first_current = '';
                        if ($first_tab == 1) {
                            $first_current = ' sc-current';
                        }

                        $has_child = isset($configs['child_shortcode']) ? true : false;
                        echo '<div id="tab-'.$key.'" class="zf-shortcode-content'.$first_current.'" data-tab="tab-'.$key.'">';
                        $shortcode = new ZF_Shortcodes_Options($key, $has_child);
                        echo $shortcode->render(true);
                        echo '<input id="zf_shortcode" type="hidden" value="'.$shortcode->get_shortcode().'"/>';
                        echo '<input id="zf_child_shortcode" type="hidden" value="'.$shortcode->get_child_shortcode().'"/>';
                        echo '<input id="zf_has_child" type="hidden" value="'.$has_child.'"/>';
                        echo '</div>';
                    }
                }
            ?>
        </div>
    </div>
    <div class="footer-button">
        <a href="#" id="insert-shortcode" class="zf-button zf-button-primary"><?php _e('Insert shortcode', ZF_SHORTCODES_LANG);?></a>
        <a href="#" id="reset-shortcode" class="zf-button zf-button-red"><?php _e('Reset', ZF_SHORTCODES_LANG);?></a>
    </div>
    <?php do_action('zf-popup-footer');?>

</div>


<?php
do_action('zf-dialog-footer');

?>
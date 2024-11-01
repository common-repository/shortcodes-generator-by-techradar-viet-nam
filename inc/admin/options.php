<?php
/**
 * @version    $Id$
 * @package    Shortcodes Generator By TechRadar Việt Nam
 * @author     TechRadar Việt Nam
 * @copyright  Copyright (C) 2018 TechRadar Việt Nam All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

class ZF_Shortcodes_Options
{
    public $shortcodes_configs = null;

    public $shortcode_tag = null;

    public $has_child = false;

    public $child_shortcode = '';

    public $child_shortcode_tag = '';

    public $shortcode = '';

    public function __construct($shortcode_tag, $has_child)  {
        $this->shortcodes_configs = ZF_Shortcodes_Configs::get_instance()->get_shortcodes();
        $this->shortcode_tag = $shortcode_tag;
        $this->has_child = $has_child;
    }

    public function get_shortcode() {
        return $this->shortcode;
    }

    public function get_child_shortcode() {
        return $this->child_shortcode ;
    }


    /**
     * render fields for shortcode
     * @param bool $echo
     * @return string
     */
    public function render($echo = true) {


        $html = '';

        if (isset($this->shortcodes_configs[$this->shortcode_tag])) {

            $this->shortcode = $this->shortcodes_configs[$this->shortcode_tag]['shortcode'];

            if ($this->has_child) {
                $this->child_shortcode_tag = isset($this->shortcodes_configs[$this->shortcode_tag]['child_shortcode']) ? $this->shortcodes_configs[$this->shortcode_tag]['child_shortcode'] : '' ;
                $this->child_shortcode = isset($this->shortcodes_configs[$this->child_shortcode_tag]) ? $this->shortcodes_configs[$this->child_shortcode_tag]['shortcode'] : '';
                // Ignored content param if the shortcode has child shortcodes
                if (isset($this->shortcodes_configs[$this->shortcode_tag]['child_shortcode'])) {
                    unset($this->shortcodes_configs[$this->shortcode_tag]['params']['content']);
                }
            }
            $html .= '<div id="parent-shortcode" class="parent-shortcode">';
            $html .= $this->build_elements($this->shortcode_tag, $this->shortcodes_configs[$this->shortcode_tag]);

            $html .= '</div>';
            if ($this->has_child && $this->child_shortcode_tag != '') {

                $html .= '<div id="child-shortcode" class="child-shortcode">';
                $html .= '<h3>'.sprintf(__('Add %s', ZF_SHORTCODES_LANG), $this->shortcodes_configs[$this->child_shortcode_tag]['title']).'<a href="#" id="button-add-item" class="button button-add-item">'.__('Add', ZF_SHORTCODES_LANG) .'</a></h3>';
                $html .= '<div id="items">';
                $html .= '<ul>';
                $html .= '<li><a href="#item-1" data-tab-title="'.$this->shortcodes_configs[$this->child_shortcode_tag]['title'].'">'.$this->shortcodes_configs[$this->child_shortcode_tag]['title'].'<span> #1</span></a><span class="ui-icon ui-icon-close" role="presentation"></span></li>';
                $html .= '</ul>';
                $html .= '<div id="item-1">';
                $html .= $this->build_elements($this->child_shortcode_tag, $this->shortcodes_configs[$this->child_shortcode_tag]);

                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';

            }

        } else {
            $html = __('Shortcode undefined', ZF_SHORTCODES_LANG);
        }

        if ($echo) {
            echo $html;
        } else {
            return $html;
        }
    }

    /**
     * build elements for shortcode
     * @param $shortcode_tag
     * @param $configs
     *
     * @return string
     */
    public function build_elements($shortcode_tag, $configs) {

        $html = '';


        if (empty($configs['params'])) {
            $html .= '<h2>'.__('This shortcode doesn\'t have any attributes', ZF_SHORTCODES_LANG).'</h2>';
        } else {
            if (isset($configs['use_tab']) && !empty($configs['use_tab'])) {

                $html .= '<div class="zf-element-tabs">';
                $html .= '<ul>';
                $html .= '<li><a href="#zf-element-general">'.__('General', ZF_SHORTCODES_LANG).'</a></li>';
                $html .= '<li><a href="#zf-element-custom">'.__('Custom', ZF_SHORTCODES_LANG).'</a></li>';
                $html .= '</ul>';
                $html .= ' <div id="zf-element-general">';
                foreach($configs['params'] as $field_key => $param) {
                    $html .= $this->build_element($shortcode_tag, $field_key, $param);
                }
                $html .= ' </div>';
                $html .= ' <div id="zf-element-custom">';
                foreach($configs['use_tab'] as $field_key => $param) {
                    $html .= $this->build_element($shortcode_tag, $field_key, $param);
                }
                $html .= ' </div>';

                $html .= ' </div>';

            } else {
                foreach($configs['params'] as $field_key => $param) {
                    $html .= $this->build_element($shortcode_tag, $field_key, $param);
                }
            }
        }

        return $html;
    }

    /**
     * build element field
     * @param $shortcode_tag
     * @param $key
     * @param $param
     *
     * @return string
     */
    public function build_element($shortcode_tag, $key, $param) {

        $require = '';
        if (isset($param['required']) && ($param['required'] == 'true')) {
            $require = '<span class="zf-field-required">*</span>';
        }
        // default value if it wasn't set default
        if (!isset($param['std'])) { $param['std'] = '';}

        $field_type = $param['type'];

        $field = '<div class="zf-shortcode-element">';
        if (isset($param['label'])) {
            $field .= '<label for="' . $key .'">' . $require . $param['label'] . ' : </label>';
        }

        switch( $field_type )
        {
            case 'text' :
                $field .= '<input type="text" class="form-text zf-field" name="' . $key . '" id="' . $key . '" value="' . $param['std'] . '" data-reset="'.$param['std'].'"/>' . "\n";
                break;

            case 'select' :
				$field .= '<select name="' . $key . '" id="' . $key . '" class="form-select zf-field" data-reset="'.$param['std'].'">' . "\n";
				foreach( $param['options'] as $value => $option ) {
                    $field .= '<option value="' . $value . '"'.selected($value, $param['std'], false).'>' . $option . '</option>' . "\n";
                }
				$field .= '</select>' . "\n";

				break;
            case 'radio' :
                $random_radio = rand() ;
                $field .= '<div class="form-radio zf-radio-field zf-field" data-field="'.$key.'" data-reset="'.$param['std'].'">';
				foreach( $param['options'] as $value => $option ) {
                    $field .= '<label><input type="radio" name="' . $key . $random_radio. '" value="' . $value . '" class="form-radio" '.checked($value, $param['std'], false).'> '.$option.'</label>' . "\n";
                }
                $field .= '</div>';
				break;
            case 'animation' :

                $effect = array(
                    "bounce","flash","pulse","rubberBand","shake","swing","tada","wobble","bounceIn","bounceInDown","bounceInLeft",
                    "bounceInRight","bounceInUp","bounceOut","bounceOutDown","bounceOutLeft","bounceOutRight","bounceOutUp","fadeIn","fadeInDown","fadeInDownBig","fadeInLeft","fadeInLeftBig","fadeInRight",
                    "fadeInRightBig","fadeInUp","fadeInUpBig","fadeOut","fadeOutDown","fadeOutDownBig","fadeOutLeft","fadeOutLeftBig","fadeOutRight","fadeOutRightBig","fadeOutUp","fadeOutUpBig",
                    "flipInX","flipInY","flipOutX","flipOutY","lightSpeedIn","lightSpeedOut","rotateIn","rotateInDownLeft","rotateInDownRight","rotateInUpLeft","rotateInUpRight","rotateOut","rotateOutDownLeft","rotateOutDownRight",
                    "rotateOutUpLeft","rotateOutUpRight","slideInDown","slideInLeft","slideInRight","slideOutLeft","slideOutRight","slideOutUp","hinge","rollIn","rollOut","zoomIn","zoomInDown","zoomInLeft","zoomInRight","zoomInUp",
                    "zoomOut","zoomOutDown","zoomOutLeft","zoomOutRight","zoomOutUp"
                );

				$field .= '<select name="' . $key . '" id="' . $key . '" class="form-select zf-field" data-reset="'.$param['std'].'">' . "\n";
                if ($shortcode_tag !='zf_animation') {
                    $field .= '<option value=""'.selected('', $param['std'], false).'>' . __('None', ZF_SHORTCODES_LANG) . '</option>' . "\n";
                }
                foreach( $effect as $option ) {
                    $field .= '<option value="' . $option . '"'.selected($option, $param['std'], false).'>' . $option . '</option>' . "\n";
                }
				$field .= '</select>' . "\n";
				$field .= '' . "\n";

				break;
            case 'textarea' :
                $field .= '<textarea rows="10" cols="20" name="' . $key . '" id="' . $key . '" class="form-textarea zf-textarea-field zf-field" data-reset="">' . $param['std'] . '</textarea>' . "\n";
                break;
            case 'shortcode_content' :

//                $settings = array(
//                    'dfw' => true,
//                    'textarea_name' => $key,
//                    'editor_class' => 'form-textarea zf-field is-content',
//                    'textarea_rows' => 10, //Wordpress default
//                    'teeny'         => true,
//                );
//                ob_start();
//                wp_editor($param['std'], $key, $settings );
//                $editor = ob_get_clean();
                $field .= '<textarea rows="10" cols="20" name="' . $key . '" id="' . $key . '" class="form-textarea zf-textarea-field zf-field is-content" data-reset="">' . $param['std'] . '</textarea>' . "\n";
                break;
            case 'image_url' :
                $field .='<div class="form-image-url zf-image-field">';
                $field .= '<input type="text" class="form-image zf-field" name="' . $key . '" id="' . $key . '" value="' . $param['std'] . '" data-reset=""/>' . "\n";
                $field .= '<a href="#" class="button '.$key.'-zf-upload-image zf-upload-image" data-field="'.$key.'" title="'.__('Add Media', ZF_SHORTCODES_LANG).'"><span class="wp-media-buttons-icon"></span> '.__('Upload image', ZF_SHORTCODES_LANG).'</a>' . "\n";
                $field .= '</div>';
                break;

            case 'color' :
                $field .= '<input type="text" class="form-color zf-color-picker zf-field" name="' . $key . '" id="' . $key . '" value="' . $param['std'] . '" data-reset="'.$param['std'].'"/>' . "\n";
                break;
            case 'icon' :
                ob_start();
                include ('fields/icon.php');
                $field .= ob_get_clean();

                break;
            case 'column_size' :

               $column_size = array(
                   "1"  => '1 column',
                   "2"   => '2 columns',
                   "3"   => '3 columns',
                   "4"   => '4 columns',
                   "5"  => '5 columns',
                   "6"   => '6 columns',
                   "7"  => '7 columns',
                   "8"   => '8 columns',
                   "9"   => '9 columns',
                   "10"   => '10 columns',
                   "11" => '11 columns',
                   "12"   => '12 columns',
                );

                $field .= '<select name="' . $key . '" id="' . $key . '" class="form-column-size zf-column-size-field zf-field" data-reset="'.$param['std'].'">' . "\n";
                foreach( $column_size as $key => $option ) {
                    $field .= '<option value="' . $key . '"'.selected($key, $param['std'], false).'>' . $option . '</option>' . "\n";
                }
                $field .= '</select>' . "\n";
                break;

            case 'column_responsive' :
                // only use this type for shortcode column
                if ($shortcode_tag != 'zf_column') {
                    $field .= __('Only use for shortcode column', ZF_SHORTCODES_LANG);
                    break;
                }

                $column_sizes = array(
                    "1"  => '1 column',
                    "2"   => '2 columns',
                    "3"   => '3 columns',
                    "4"   => '4 columns',
                    "5"  => '5 columns',
                    "6"   => '6 columns',
                    "7"  => '7 columns',
                    "8"   => '8 columns',
                    "9"   => '9 columns',
                    "10"   => '10 columns',
                    "11" => '11 columns',
                    "12"   => '12 columns',
                );

                $column_size_options = '';

                foreach ( $column_sizes as $size_val => $title1 ) {
                    $column_size_options .= '<option value="' . $size_val . '">' . $title1 . '</option>' . "\n";
                }

                $column_offset = array(
                    "offset-0"  => __( 'No Offset', ZF_SHORTCODES_LANG ),
                    "offset-1"  => '1 column',
                    "offset-2"  => '2 columns',
                    "offset-3"  => '3 columns',
                    "offset-4"  => '4 columns',
                    "offset-5"  => '5 columns',
                    "offset-6"  => '6 columns',
                    "offset-7"  => '7 columns',
                    "offset-8"  => '8 columns',
                    "offset-9"  => '9 columns',
                    "offset-10" => '10 columns',
                    "offset-11" => '11 columns',
                    "offset-12" => '12 columns',
                );
                $column_offset_options = '';

                foreach ( $column_offset as $offset_val => $title2 ) {
                    $column_offset_options .= '<option value="' . $offset_val . '">' . $title2 . '</option>' . "\n";
                }

                $field .= '<table class="form-column-responsive zf-column-responsive-field zf-field" data-field="'.$key.'">';
                $field .= '<tbody>';
                $field .= '<tr>';
                $field .= '<th width="120">'.__('Device', ZF_SHORTCODES_LANG).'</th>';
                $field .= '<th width="180">'.__('Column size', ZF_SHORTCODES_LANG).'</th>';
                $field .= '<th width="180">'.__('Offset', ZF_SHORTCODES_LANG).'</th>';
                $field .= '<th>'.__('Hidden', ZF_SHORTCODES_LANG).'</th>';
                $field .= '</tr>';
                $field .= '<tr data-device="xs" class="zf-device-row">';
                    $field .= '<td>'.__('Phones', ZF_SHORTCODES_LANG).'</td>';
                    $field .= '<td>';
                    $field .= '<select class="responsive-column-size" data-reset="">' . "\n";
                        $field .= '<option value="" selected>' . __('No set', ZF_SHORTCODES_LANG) . '</option>' . "\n";
                        $field .= $column_size_options;

                    $field .= '</select>' . "\n";
                    $field .= '</td>';
                    $field .= '<td>';
                        $field .= '<select class="responsive-column-offset" data-reset="">' . "\n";
                            $field .= '<option value="" selected>' . __('No set', ZF_SHORTCODES_LANG) . '</option>' . "\n";
                            $field .= $column_offset_options;
                        $field .= '</select>' . "\n";
                    $field .= '</td>';
                    $field .= '<td>';
                    $field .= '<label><input type="checkbox" name="zf-hidden-device" value="1" class="responsive-column-hidden">'.__('Yes', ZF_SHORTCODES_LANG).'</label>';
                    $field .= ' </td > ';
                $field .= '</tr>';
                $field .= '<tr data-device="sm" class="zf-device-row">';
                    $field .= '<td>'.__('Tablets', ZF_SHORTCODES_LANG).'</td>';
                    $field .= '<td>';
                    $field .= __('Default', ZF_SHORTCODES_LANG);
                    $field .= '</td>';
                    $field .= '<td>';
                        $field .= '<select class="responsive-column-offset" data-reset="">' . "\n";
                        $field .= '<option value="" selected>' . __('Inherit', ZF_SHORTCODES_LANG) . '</option>' . "\n";
                        $field .= $column_offset_options;

                        $field .= '</select>' . "\n";
                    $field .= '</td>';
                    $field .= '<td>';
                    $field .= '<label><input type="checkbox" name="zf-hidden-device" value="1" class="responsive-column-hidden">'.__('Yes', ZF_SHORTCODES_LANG).'</label>';
                    $field .= ' </td > ';
                $field .= '</tr>';
                $field .= '<tr data-device="md" class="zf-device-row">';
                    $field .= '<td>'.__('Desktops', ZF_SHORTCODES_LANG).'</td>';
                    $field .= '<td>';
                    $field .= '<select class="responsive-column-size" data-reset="">' . "\n";
                        $field .= '<option value="" selected>' . __('Inherit', ZF_SHORTCODES_LANG) . '</option>' . "\n";
                        $field .= $column_size_options;
                    $field .= '</select>' . "\n";
                    $field .= '</td>';
                    $field .= '<td>';
                        $field .= '<select class="responsive-column-offset" data-reset="">' . "\n";
                        $field .= '<option value="" selected>' . __('Inherit', ZF_SHORTCODES_LANG) . '</option>' . "\n";
                        $field .= $column_offset_options;
                        $field .= '</select>' . "\n";
                    $field .= '</td>';
                    $field .= '<td>';
                    $field .= '<label><input type="checkbox" name="zf-hidden-device" value="1" class="responsive-column-hidden">'.__('Yes', ZF_SHORTCODES_LANG).'</label>';
                    $field .= ' </td > ';
                $field .= '</tr>';
                $field .= '<tr data-device="lg" class="zf-device-row">';
                    $field .= '<td>'.__('Large Desktops', ZF_SHORTCODES_LANG).'</td>';
                    $field .= '<td>';
                    $field .= '<select class="responsive-column-size" data-reset="">' . "\n";
                    $field .= '<option value="" selected>' . __('Inherit', ZF_SHORTCODES_LANG) . '</option>' . "\n";
                    $field .= $column_size_options;
                    $field .= '</select>' . "\n";
                    $field .= '</td>';
                    $field .= '<td>';
                        $field .= '<select class="responsive-column-offset" data-reset="">' . "\n";
                        $field .= '<option value="" selected>' . __('Inherit', ZF_SHORTCODES_LANG) . '</option>' . "\n";
                        $field .= $column_offset_options;
                        $field .= '</select>' . "\n";
                    $field .= '</td>';
                    $field .= '<td>';
                    $field .= '<label><input type="checkbox" name="zf-hidden-device" value="1" class="responsive-column-hidden">'.__('Yes', ZF_SHORTCODES_LANG).'</label>';
                    $field .= ' </td > ';
                $field .= '</tr>';
                $field .= '</tbody>';
                $field .= '</table>';

                break;

            case 'spacing' :
                $spacing = (array)$param['std'];
                $spacing_top = isset($spacing['top']) ? $spacing['top'] : "";
                $spacing_right = isset($spacing['right']) ? $spacing['right'] : "";
                $spacing_bottom = isset($spacing['bottom']) ? $spacing['bottom'] : "";
                $spacing_left = isset($spacing['left']) ? $spacing['left'] : "";
                $spacing_type = isset($spacing['spacing_type']) ? $spacing['spacing_type'] : "px";

                $field .='<div class="form-spacing zf-spacing-field zf-field" data-field="'.$key.'" data-top="'.$spacing_top.'" data-right="'.$spacing_right.'" data-bottom="'.$spacing_bottom.'" data-left="'.$spacing_left.'" data-type="'.$spacing_type.'">';
                $field .= '<label>'.__('Top', ZF_SHORTCODES_LANG).' <input type="text" name="spacing-top" id="spacing-top" value="'.$spacing_top.'"/></label>';
                $field .= '<label>'.__('Right', ZF_SHORTCODES_LANG).' <input type="text" name="spacing-right" id="spacing-right" value="'.$spacing_right.'"/></label>';
                $field .= '<label>'.__('Bottom', ZF_SHORTCODES_LANG).' <input type="text" name="spacing-bottom" id="spacing-bottom" value="'.$spacing_bottom.'"/></label>';
                $field .= '<label>'.__('Left', ZF_SHORTCODES_LANG).' <input type="text" name="spacing-left" id="spacing-left" value="'.$spacing_left.'"/></label>';
                $field .= ' - ';
                $field .= '<select name="spacing-type" id="spacing-type" class="spacing-type">' . "\n";
                    $field .= '<option value="px"'.selected($spacing_type, 'px', false).'>' . __('px', ZF_SHORTCODES_LANG) . '</option>' . "\n";
                    $field .= '<option value="em"'.selected($spacing_type, 'em', false).'>' . __('em', ZF_SHORTCODES_LANG) . '</option>' . "\n";
                    $field .= '<option value="rem"'.selected($spacing_type, 'rem', false).'>' . __('rem', ZF_SHORTCODES_LANG) . '</option>' . "\n";
                    $field .= '<option value="%"'.selected($spacing_type, '%', false).'>' . __('%', ZF_SHORTCODES_LANG) . '</option>' . "\n";
                $field .= '</select>' . "\n";
                $field .= '</div>';
                break;

        }
        $field = apply_filters('zf_field_option', $field, $param);
        if (isset($param['desc']) && $param['desc'] !='' ) {
            $field .= '<div class="form-desc">' . $param['desc'] . '</div>' . "\n";
        }
        $field .= '</div>';

        return $field;


    }

}
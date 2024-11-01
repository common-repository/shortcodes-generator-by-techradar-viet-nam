<?php
/**
 * @version    $Id$
 * @package    Shortcodes Generator By TechRadar Việt Nam
 * @author     TechRadar Việt Nam
 * @copyright  Copyright (C) 2018 TechRadar Việt Nam All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

class ZF_Shortcodes_Configs
{
    private static $zf_shortcodes_type = array();

    private static $zf_shortcodes = array();

    protected static $instance = null;

    function __construct() {
        $this->default_configs();
        do_action('zf_shortcode_configs', $this);
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
     * set shortcode configs
     * @param $shortcode_tag
     * @param $configs
     * @param $type the shortcode type
     */

    public function set_shortcode($shortcode_tag, $configs, $type = '') {

        if (!isset(self::$zf_shortcodes[$shortcode_tag])) {

            self::$zf_shortcodes[$shortcode_tag] = $configs;

            if ($type != '') {
                self::$zf_shortcodes_type[$type][] = $shortcode_tag;
            }

        }

    }

    /**
     * Return all shortcodes type
     * @return array
     */

    public function get_shortcodes_types() {
        return self::$zf_shortcodes_type;
    }

    /**
     * get shortcode type
     * @return array
     */

    public function get_shortcode_type($shortcode_tag) {

        $types = $this->get_shortcodes_types();

        foreach ($types as $type => $values) {
            if (in_array($shortcode_tag, $values)) {
                return $type;
            }
        }

        // in case not found then return other type
        return '';
    }

    /**
     * Return all shortcodes or special shortcode configs
     * @param bool $shortcode_tag
     * @return array
     */

    public function get_shortcodes($shortcode_tag = false) {

        if ($shortcode_tag != false) {
            return self::$zf_shortcodes[$shortcode_tag];
        } else {
            return self::$zf_shortcodes;
        }
    }

    public function default_configs() {
        /*==== Section params ====*/
        $this->set_shortcode('zf_section', array(
            'title' => __('Section', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_section{{attributes}}]{{content}}[/zf_section]',
            'params' => array(
                'section_tag' => array(
                    'type' => 'select',
                    'std' => '',
                    'label' => __('Using section tag', ZF_SHORTCODES_LANG),
                    'desc' => __('Choose No, The content will be wrapped in DIV instead of SECTION.', ZF_SHORTCODES_LANG),
                    'options' => array(
                        '' => __('Yes', ZF_SHORTCODES_LANG),
                        'no' => __('No', ZF_SHORTCODES_LANG),
                    )
                ),

                'no_padding' => array(
                    'type' => 'radio',
                    'std' => '',
                    'label' => __('No padding', ZF_SHORTCODES_LANG),
                    'desc' => __('No padding for section', ZF_SHORTCODES_LANG),
                    'options' => array(
                        'yes' => __('Yes', ZF_SHORTCODES_LANG),
                        '' => __('No', ZF_SHORTCODES_LANG),
                    )
                ),

                'container' => array(
                    'type' => 'radio',
                    'std' => 'full-width',
                    'label' => __('Container', ZF_SHORTCODES_LANG),
                    'desc' => __('Using Fixed Width to wrap content with a container. or Full Width ', ZF_SHORTCODES_LANG),
                    'options' => array(
                        'fixed-width' => __('Fixed Width', ZF_SHORTCODES_LANG),
                        'full-width' => __('Full Width', ZF_SHORTCODES_LANG),
                    )
                ),
                'html_id' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('ID', ZF_SHORTCODES_LANG),
                    'desc' => __('The id attribute in HTML', ZF_SHORTCODES_LANG),
                ),

                'html_class' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Extra Class', ZF_SHORTCODES_LANG),
                    'desc' => __('The class attribute in HTML', ZF_SHORTCODES_LANG),
                ),

                'animation' => array(
                    'type' => 'animation',
                    'std' => '',
                    'label' => __('Animation', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),

                'content' => array(
                    'type' => 'shortcode_content',
                    'std' => 'Content Here',
                    'label' => __('Content', ZF_SHORTCODES_LANG),
                    'desc' => '',
                )
            ),

            'use_tab' => array(

                'margin' => array(
                    'type' => 'spacing',
                    'label' => __('Margin', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),

                'padding' => array(
                    'type' => 'spacing',
                    'label' => __('Padding', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),

                'background_color' => array(
                    'type' => 'color',
                    'label' => __('Background Color', ZF_SHORTCODES_LANG),
                    'std' => '',
                ),

                'background_image' => array(
                    'type' => 'image_url',
                    'label' => __('Background Image', ZF_SHORTCODES_LANG),
                    'std' => '',
                ),

                'background_repeat' => array(
                    'type' => 'radio',
                    'label' => __('Background Repeat', ZF_SHORTCODES_LANG),
                    'options' => array(
                        '' => __('Default', ZF_SHORTCODES_LANG),
                        'no-repeat' => __('No Repeat', ZF_SHORTCODES_LANG),
                        'repeat'    => __('Repeat', ZF_SHORTCODES_LANG),
                    ),
                    'std' => '',
                ),
                'background_attachment' => array(
                    'type' => 'radio',
                    'label' => __('Background Attachment', ZF_SHORTCODES_LANG),
                    'options' => array(
                        '' => __('Default', ZF_SHORTCODES_LANG),
                        'fixed' => __('Fixed', ZF_SHORTCODES_LANG),
                        'scroll'  => __('Scroll', ZF_SHORTCODES_LANG),
                    ),
                    'std' => '',
                ),
            )
        ));


        /*==== Row with column params ====*/
        $this->set_shortcode('zf_row', array(
            'title' => __('Row', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_row{{attributes}}]{{content}}[/zf_row]',
            'child_shortcode' => 'zf_column',
            'params' => array(
                'html_id' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('ID', ZF_SHORTCODES_LANG),
                    'desc' => __('The id attribute in HTML', ZF_SHORTCODES_LANG),
                ),
                'html_class' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Extra Class', ZF_SHORTCODES_LANG),
                    'desc' => __('The class attribute in HTML', ZF_SHORTCODES_LANG),
                ),
                'animation' => array(
                    'std' => '',
                    'type' => 'animation',
                    'label' => __('Animation', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),
            ),

            'use_tab' => array(

                'margin' => array(
                    'type' => 'spacing',
                    'label' => __('Margin', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),

                'padding' => array(
                    'type' => 'spacing',
                    'label' => __('Padding', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),

                'background_color' => array(
                    'type' => 'color',
                    'label' => __('Background Color', ZF_SHORTCODES_LANG),
                    'std' => '',
                ),

                'background_image' => array(
                    'type' => 'image_url',
                    'label' => __('Background Image', ZF_SHORTCODES_LANG),
                    'std' => '',
                ),

                'background_repeat' => array(
                    'type' => 'radio',
                    'label' => __('Background Repeat', ZF_SHORTCODES_LANG),
                    'options' => array(
                        '' => __('Default', ZF_SHORTCODES_LANG),
                        'no-repeat' => __('No Repeat', ZF_SHORTCODES_LANG),
                        'repeat'    => __('Repeat', ZF_SHORTCODES_LANG),
                    ),
                    'std' => '',
                ),
                'background_attachment' => array(
                    'type' => 'radio',
                    'label' => __('Background Attachment', ZF_SHORTCODES_LANG),
                    'options' => array(
                        '' => __('Default', ZF_SHORTCODES_LANG),
                        'fixed' => __('Fixed', ZF_SHORTCODES_LANG),
                        'scroll'  => __('Scroll', ZF_SHORTCODES_LANG),
                    ),
                    'std' => '',
                ),
            )
        ));

        /*==== column params ====*/
        $this->set_shortcode('zf_column', array(
            'title' => __('Column', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_column{{attributes}}]{{content}}[/zf_column]',
            'params' => array(
                'column_size' => array(
                    'type' => 'column_size',
                    'std' => '12',
                    'label' => __('Column Size', ZF_SHORTCODES_LANG),
                    'desc' => __('The column size of 12 columns. It use for Tablets or larger.', ZF_SHORTCODES_LANG),
                ),
                'responsive' => array(
                    'type' => 'column_responsive',
                    'std' => '',
                ),
                'html_id' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('ID', ZF_SHORTCODES_LANG),
                    'desc' => __('The id attribute in HTML', ZF_SHORTCODES_LANG),
                ),
                'html_class' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Extra Class', ZF_SHORTCODES_LANG),
                    'desc' => __('The class attribute in HTML', ZF_SHORTCODES_LANG),
                ),
                'animation' => array(
                    'std' => '',
                    'type' => 'animation',
                    'label' => __('Animation', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),
                'content' => array(
                    'type' => 'shortcode_content',
                    'std' => 'Content Here',
                    'label' => __('Content', ZF_SHORTCODES_LANG),
                    'desc' => '',
                )

            ),
            'use_tab' => array(

                'margin' => array(
                    'type' => 'spacing',
                    'label' => __('Margin', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),

                'padding' => array(
                    'type' => 'spacing',
                    'label' => __('Padding', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),

                'background_color' => array(
                    'type' => 'color',
                    'label' => __('Background Color', ZF_SHORTCODES_LANG),
                    'std' => '',
                ),

                'background_image' => array(
                    'type' => 'image_url',
                    'label' => __('Background Image', ZF_SHORTCODES_LANG),
                    'std' => '',
                ),

                'background_repeat' => array(
                    'type' => 'radio',
                    'label' => __('Background Repeat', ZF_SHORTCODES_LANG),
                    'options' => array(
                        '' => __('Default', ZF_SHORTCODES_LANG),
                        'no-repeat' => __('No Repeat', ZF_SHORTCODES_LANG),
                        'repeat'    => __('Repeat', ZF_SHORTCODES_LANG),
                    ),
                    'std' => '',
                ),
                'background_attachment' => array(
                    'type' => 'radio',
                    'label' => __('Background Attachment', ZF_SHORTCODES_LANG),
                    'options' => array(
                        '' => __('Default', ZF_SHORTCODES_LANG),
                        'fixed' => __('Fixed', ZF_SHORTCODES_LANG),
                        'scroll'  => __('Scroll', ZF_SHORTCODES_LANG),
                    ),
                    'std' => '',
                ),
            )
        ));

        /*==== Blockquote params ====*/
        $this->set_shortcode('zf_blockquote', array(
            'title' => __('Blockquote', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_blockquote{{attributes}}]{{content}}[/zf_blockquote]',
            'params' => array(
                'align' => array(
                    'type' => 'select',
                    'label' => __('Alignment', ZF_SHORTCODES_LANG),
                    'desc' => '',
                    'options' => array(
                        'left' => 'Left',
                        'right' => 'Right',
                    )
                ),
                'animation' => array(
                    'std' => '',
                    'type' => 'animation',
                    'label' => __('Animation', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),
                'html_class' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Extra Class', ZF_SHORTCODES_LANG),
                    'desc' => __('The class attribute in HTML', ZF_SHORTCODES_LANG),
                ),
                'content' => array(
                    'type' => 'shortcode_content',
                    'std' => 'Content Here',
                    'label' => __('Content', ZF_SHORTCODES_LANG),
                    'desc' => '',
                )

            )
        ), 'boxes');

        /*==== Heading params ====*/
        $this->set_shortcode('zf_heading', array(
            'title' => __('Heading', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_heading{{attributes}}]{{content}}[/zf_heading]',
            'params' => array(
                'type' => array(
                    'type' => 'select',
                    'label' => __('Type', ZF_SHORTCODES_LANG),
                    'desc' => __('h1 -> h6', ZF_SHORTCODES_LANG),
                    'options' => array(
                        'h1' => 'H1',
                        'h2' => 'H2',
                        'h3' => 'H3',
                        'h4' => 'H4',
                        'h5' => 'H5',
                        'h6' => 'H6',
                    ),
                    'std' => 'h1',
                ),

                'html_id' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('ID', ZF_SHORTCODES_LANG),
                    'desc' => __('The id attribute in HTML', ZF_SHORTCODES_LANG),
                ),
                'html_class' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Extra Class', ZF_SHORTCODES_LANG),
                    'desc' => __('The class attribute in HTML', ZF_SHORTCODES_LANG),
                ),

                'animation' => array(
                    'std' => '',
                    'type' => 'animation',
                    'label' => __('Animation', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),
                'content' => array(
                    'type' => 'shortcode_content',
                    'std' => 'Content Here',
                    'label' => __('Content', ZF_SHORTCODES_LANG),
                    'desc' => '',
                )

            )
        ), 'typography');

        $this->set_shortcode('zf_strong', array(
            'title' => __('Strong', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_strong{{attributes}}]{{content}}[/zf_strong]',
            'params' => array(

                'html_class' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Extra Class', ZF_SHORTCODES_LANG),
                    'desc' => __('The class attribute in HTML', ZF_SHORTCODES_LANG),
                ),

                'content' => array(
                    'type' => 'shortcode_content',
                    'std' => 'Content Here',
                    'label' => __('Content', ZF_SHORTCODES_LANG),
                    'desc' => '',
                )

            )
        ), 'typography');

        $this->set_shortcode('zf_span', array(
            'title' => __('Span', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_span{{attributes}}]{{content}}[/zf_span]',
            'params' => array(

                'html_class' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Extra Class', ZF_SHORTCODES_LANG),
                    'desc' => __('The class attribute in HTML', ZF_SHORTCODES_LANG),
                ),

                'content' => array(
                    'type' => 'shortcode_content',
                    'std' => 'Content Here',
                    'label' => __('Content', ZF_SHORTCODES_LANG),
                    'desc' => '',
                )

            )
        ), 'typography');

        $this->set_shortcode('zf_small', array(
            'title' => __('Small', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_small{{attributes}}]{{content}}[/zf_small]',
            'params' => array(

                'html_class' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Extra Class', ZF_SHORTCODES_LANG),
                    'desc' => __('The class attribute in HTML', ZF_SHORTCODES_LANG),
                ),

                'content' => array(
                    'type' => 'shortcode_content',
                    'std' => 'Content Here',
                    'label' => __('Content', ZF_SHORTCODES_LANG),
                    'desc' => '',
                )

            )
        ), 'typography');

        $this->set_shortcode('zf_p', array(
            'title' => __('P', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_p{{attributes}}]{{content}}[/zf_p]',
            'params' => array(

                'html_class' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Extra Class', ZF_SHORTCODES_LANG),
                    'desc' => __('The class attribute in HTML', ZF_SHORTCODES_LANG),
                ),

                'content' => array(
                    'type' => 'shortcode_content',
                    'std' => 'Content Here',
                    'label' => __('Content', ZF_SHORTCODES_LANG),
                    'desc' => '',
                )

            )
        ), 'typography');

        $this->set_shortcode('zf_ul', array(
            'title' => __('List (ul)', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_ul{{attributes}}]{{content}}[/zf_ul]',
            'child_shortcode' => 'zf_li',
            'params' => array(

                'html_id' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('ID', ZF_SHORTCODES_LANG),
                    'desc' => __('The id attribute in HTML', ZF_SHORTCODES_LANG),
                ),

                'html_class' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Extra Class', ZF_SHORTCODES_LANG),
                    'desc' => __('The class attribute in HTML', ZF_SHORTCODES_LANG),
                ),

            )
        ), 'typography');

        $this->set_shortcode('zf_li', array(
            'title' => __('List Item (li)', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_li{{attributes}}]{{content}}[/zf_li]',
            'params' => array(

                'html_id' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('ID', ZF_SHORTCODES_LANG),
                    'desc' => __('The id attribute in HTML', ZF_SHORTCODES_LANG),
                ),

                'html_class' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Extra Class', ZF_SHORTCODES_LANG),
                    'desc' => __('The class attribute in HTML', ZF_SHORTCODES_LANG),
                ),

                'content' => array(
                    'type' => 'shortcode_content',
                    'std' => 'Content Here',
                    'label' => __('Content', ZF_SHORTCODES_LANG),
                    'desc' => '',
                )

            )
        ), 'typography');

        /*==== icon params ====*/
        $this->set_shortcode('zf_icon', array(
            'title' => __('Icon', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_icon{{attributes}}]',
            'params' => array(

                'icon' => array(
                    'type' => 'icon',
                    'std' => '',
                    'label' => __('Icon', ZF_SHORTCODES_LANG),
                ),

                'color' => array(
                    'type' => 'color',
                    'std' => '',
                    'label' => __('Font Color', ZF_SHORTCODES_LANG),
                ),

                'size' => array(
                    'type' => 'select',
                    'std' => '',
                    'label' => __('Size', ZF_SHORTCODES_LANG),
                    'desc' => __('The size of font', ZF_SHORTCODES_LANG),
                    'options' => array(
                        '' => __('Default', ZF_SHORTCODES_LANG),
                        'fa-lg' => __('Smallest', ZF_SHORTCODES_LANG),
                        'fa-2x' => __('Small', ZF_SHORTCODES_LANG),
                        'fa-3x' => __('Medium', ZF_SHORTCODES_LANG),
                        'fa-4x' => __('Larger', ZF_SHORTCODES_LANG),
                        'fa-5x' => __('Very Larger', ZF_SHORTCODES_LANG),
                    )
                ),

                'html_class' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Extra Class', ZF_SHORTCODES_LANG),
                    'desc' => __('The class attribute in HTML', ZF_SHORTCODES_LANG),
                ),

            )
        ), 'media');

        /*==== Image params ====*/
        $this->set_shortcode('zf_image', array(
            'title' => __('Image', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_image{{attributes}}]',
            'params' => array(

                'src' => array(
                    'type' => 'image_url',
                    'std' => '',
                    'label' => __('Image url', ZF_SHORTCODES_LANG),
                    'desc' => __('the image url, or leave blank it will use default image', ZF_SHORTCODES_LANG),
                ),

                'title' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Image title', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),

                'html_id' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('ID', ZF_SHORTCODES_LANG),
                    'desc' => __('The id attribute in HTML', ZF_SHORTCODES_LANG),
                ),
                'html_class' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Extra Class', ZF_SHORTCODES_LANG),
                    'desc' => __('The class attribute in HTML', ZF_SHORTCODES_LANG),
                ),

                'width' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Width', ZF_SHORTCODES_LANG),
                    'desc' => __('The with of image', ZF_SHORTCODES_LANG),
                ),
                'height' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Height', ZF_SHORTCODES_LANG),
                    'desc' => __('The height of image', ZF_SHORTCODES_LANG),
                ),
                'animation' => array(
                    'std' => '',
                    'type' => 'animation',
                    'label' => __('Animation', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),
            )
        ), 'media');

        /*==== Alert params ====*/
        $this->set_shortcode('zf_alert', array(
            'title' => __('Alert', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_alert{{attributes}}]{{content}}[/zf_alert]',
            'params' => array(
                'type' => array(
                    'type' => 'select',
                    'label' => __('Alert type', ZF_SHORTCODES_LANG),
                    'desc' => '',
                    'options' => array(
                        'success' => 'Success',
                        'info' => 'Info',
                        'warning' => 'Warning',
                        'danger' => 'Danger',
                    ),
                    'std' => 'success'
                ),

                'close' => array(
                    'type' => 'select',
                    'label' => __('Close Alert', ZF_SHORTCODES_LANG),
                    'desc' => '',
                    'options' => array(
                        'true' => __('Yes', ZF_SHORTCODES_LANG),
                        'false' => __('No', ZF_SHORTCODES_LANG),
                    ),
                    'std' => 'false'
                ),

                'content' => array(
                    'type' => 'shortcode_content',
                    'std' => 'Content Here',
                    'label' => __('Content', ZF_SHORTCODES_LANG),
                    'desc' => '',
                )


            )
        ));

        /*==== Link params ====*/
        $this->set_shortcode('zf_link', array(
            'title' => __('Link', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_link{{attributes}}]{{content}}[/zf_link]',
            'params' => array(
                'url' => array(
                    'type' => 'text',
                    'std' => '#',
                    'label' => __('Url', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),
                'title' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Title', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),
                'open_new_window' => array(
                    'type' => 'radio',
                    'label' => __('Open new window', ZF_SHORTCODES_LANG),
                    'desc' => '',
                    'options' => array(
                        'yes' => __('Yes', ZF_SHORTCODES_LANG),
                        '' => __('No', ZF_SHORTCODES_LANG),
                    ),
                    'std' => ''
                ),

                'html_id' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('ID', ZF_SHORTCODES_LANG),
                    'desc' => __('The id attribute in HTML', ZF_SHORTCODES_LANG),
                ),
                'html_class' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Extra Class', ZF_SHORTCODES_LANG),
                    'desc' => __('The class attribute in HTML', ZF_SHORTCODES_LANG),
                ),

                'content' => array(
                    'type' => 'shortcode_content',
                    'std' => 'Content Here',
                    'label' => __('Content', ZF_SHORTCODES_LANG),
                    'desc' => '',
                )


            )
        ));

        /*==== Button params ====*/
        $this->set_shortcode('zf_button', array(
            'title' => __('Button', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_button{{attributes}}]{{content}}[/zf_button]',
            'params' => array(
                'type' => array(
                    'type' => 'select',
                    'label' => __('Button type', ZF_SHORTCODES_LANG),
                    'desc' => '',
                    'options' => array(
                        'default' => 'Default',
                        'primary' => 'Primary',
                        'success' => 'Success',
                        'info' => 'Info',
                        'warning' => 'Warning',
                        'danger' => 'Danger',
                        'link' => 'Link',
                    ),
                    'std' => 'default'
                ),
                'size' => array(
                    'type' => 'select',
                    'label' => __('Button size', ZF_SHORTCODES_LANG),
                    'desc' => '',
                    'options' => array(
                        '' => 'Default',
                        'xs' => 'Xs',
                        'sm' => 'Sm',
                        'lg' => 'Lg',
                    ),
                    'std' => ''
                ),

                'title' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Title', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),

                'html_id' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('ID', ZF_SHORTCODES_LANG),
                    'desc' => __('The id attribute in HTML', ZF_SHORTCODES_LANG),
                ),
                'html_class' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Extra Class', ZF_SHORTCODES_LANG),
                    'desc' => __('The class attribute in HTML', ZF_SHORTCODES_LANG),
                ),

                'content' => array(
                    'type' => 'shortcode_content',
                    'std' => 'Content Here',
                    'label' => __('Content', ZF_SHORTCODES_LANG),
                    'desc' => '',
                )


            )
        ));

        /*==== Label params ====*/
        $this->set_shortcode('zf_label', array(
            'title' => __('Label', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_label{{attributes}}]',
            'params' => array(
                'type' => array(
                    'type' => 'select',
                    'label' => __('Label type', ZF_SHORTCODES_LANG),
                    'desc' => '',
                    'options' => array(
                        'default' => 'Default',
                        'primary' => 'Primary',
                        'success' => 'Success',
                        'info' => 'Info',
                        'warning' => 'Warning',
                        'danger' => 'Danger',
                    ),
                    'std' => 'default'
                ),

                'title' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Title', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),

            )
        ));

        /*==== Animation params ====*/
        $this->set_shortcode('zf_animation', array(
            'title' => __('Animation', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_animation{{attributes}}]{{content}}[/zf_animation]',
            'params' => array(

                'animation' => array(
                    'std' => 'bounceInDown',
                    'type' => 'animation',
                    'label' => __('Animation', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),

                'delay' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __('Delay', ZF_SHORTCODES_LANG),
                    'desc' => __('Animation delay (in seconds)'),
                ),

                'duration' => array(
                    'std' => '',
                    'type' => 'text',
                    'label' => __('Duration', ZF_SHORTCODES_LANG),
                    'desc' => __('Animation duration (in seconds)'),
                ),

                'span' => array(
                    'std' => '',
                    'type' => 'select',
                    'label' => __('Using span', ZF_SHORTCODES_LANG),
                    'desc' => __('Choose YES, The content will be wrapped in SPAN instead of DIV. The SPAN is used to group inline-elements in a content.'),
                    'options' => array(
                        'yes' => __('Yes', ZF_SHORTCODES_LANG),
                        '' => __('No', ZF_SHORTCODES_LANG),
                    ),
                ),

                'html_id' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('ID', ZF_SHORTCODES_LANG),
                    'desc' => __('The id attribute in HTML', ZF_SHORTCODES_LANG),
                ),
                'html_class' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Extra Class', ZF_SHORTCODES_LANG),
                    'desc' => __('The class attribute in HTML', ZF_SHORTCODES_LANG),
                ),

                'content' => array(
                    'type' => 'shortcode_content',
                    'std' => 'Content Here',
                    'label' => __('Content', ZF_SHORTCODES_LANG),
                    'desc' => '',
                )

            )
        ));

        /*==== Highlight params ====*/
        $this->set_shortcode('zf_highlight', array(
            'title' => __('Highlight', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_highlight{{attributes}}]{{content}}[/zf_highlight]',
            'params' => array(

                'color' => array(
                    'type' => 'color',
                    'label' => __('Color', ZF_SHORTCODES_LANG),
                    'desc' => '',
                    'std' => '#ffffff',
                ),

                'html_id' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('ID', ZF_SHORTCODES_LANG),
                    'desc' => __('The id attribute in HTML', ZF_SHORTCODES_LANG),
                ),

                'html_class' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Extra Class', ZF_SHORTCODES_LANG),
                    'desc' => __('The class attribute in HTML', ZF_SHORTCODES_LANG),
                ),

                'content' => array(
                    'type' => 'shortcode_content',
                    'std' => 'Content Here',
                    'label' => __('Content', ZF_SHORTCODES_LANG),
                    'desc' => '',
                )

            )
        ), 'typography');

        /*==== Clearfix params ====*/
        $this->set_shortcode('zf_clearfix', array(
            'title' => __('Clearfix', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_clearfix]',
            'params' => array(

            )
        ), 'other');

        /*==== Divider params ====*/
        $this->set_shortcode('zf_divider', array(
            'title' => __('Divider', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_divider{{attributes}}]',
            'params' => array(

                'type' => array(
                    'type' => 'select',
                    'label' => __('Type', ZF_SHORTCODES_LANG),
                    'options' => array(
                        'space' => __('Space', ZF_SHORTCODES_LANG),
                        'line' => __('Line', ZF_SHORTCODES_LANG),
                    ),
                    'std' => 'space',
                ),

                'height' => array(
                    'type' => 'text',
                    'std' => 15,
                    'label' => __('Height', ZF_SHORTCODES_LANG),
                    'desc' => __('The divider height', ZF_SHORTCODES_LANG),
                ),

            )
        ), 'other');

        /*==== Dropcap params ====*/
        $this->set_shortcode('zf_dropcap', array(
            'title' => __('Dropcap', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_dropcap{{attributes}}]{{content}}[/zf_dropcap]',
            'params' => array(

                'color' => array(
                    'type' => 'color',
                    'label' => __('Color', ZF_SHORTCODES_LANG),
                    'std' => '#ffffff',
                ),

                'background' => array(
                    'type' => 'color',
                    'label' => __('Background', ZF_SHORTCODES_LANG),
                    'std' => '#66afe9',
                ),

                'html_id' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('ID', ZF_SHORTCODES_LANG),
                    'desc' => __('The id attribute in HTML', ZF_SHORTCODES_LANG),
                ),

                'html_class' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Extra Class', ZF_SHORTCODES_LANG),
                    'desc' => __('The class attribute in HTML', ZF_SHORTCODES_LANG),
                ),

                'content' => array(
                    'type' => 'shortcode_content',
                    'std' => 'Content Here',
                    'label' => __('Content', ZF_SHORTCODES_LANG),
                    'desc' => '',
                )

            )
        ), 'typography');
        /*==== Text params ====*/
        $this->set_shortcode('zf_text', array(
            'title' => __('Text', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_text{{attributes}}]{{content}}[/zf_text]',
            'params' => array(
                'alignment' => array(
                    'type' => 'select',
                    'label' => __('Alignment', ZF_SHORTCODES_LANG),
                    'options' => array(
                        '' => __('Left', ZF_SHORTCODES_LANG),
                        'text-center' => __('Center', ZF_SHORTCODES_LANG),
                        'text-right' => __('Right', ZF_SHORTCODES_LANG),
                    ),
                    'desc' => '',
                    'std' => '',
                ),
                'width' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Width', ZF_SHORTCODES_LANG),
                    'desc' => __('The width of text. Leave blank for full width', ZF_SHORTCODES_LANG),
                ),

                'width_type' => array(
                    'type' => 'select',
                    'std' => '%',
                    'label' => __('Width type', ZF_SHORTCODES_LANG),
                    'options' => array(
                        '%' => __('%', ZF_SHORTCODES_LANG),
                        'px' => __('Px', ZF_SHORTCODES_LANG),
                    ),

                ),

                'html_id' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('ID', ZF_SHORTCODES_LANG),
                    'desc' => __('The id attribute in HTML', ZF_SHORTCODES_LANG),
                ),

                'html_class' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Extra Class', ZF_SHORTCODES_LANG),
                    'desc' => __('The class attribute in HTML', ZF_SHORTCODES_LANG),
                ),
                'animation' => array(
                    'std' => '',
                    'type' => 'animation',
                    'label' => __('Animation', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),
                'content' => array(
                    'type' => 'shortcode_content',
                    'std' => 'Content Here',
                    'label' => __('Content', ZF_SHORTCODES_LANG),
                    'desc' => '',
                )
            ),

            'use_tab' => array(

                'margin' => array(
                    'type' => 'spacing',
                    'label' => __('Margin', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),

                'padding' => array(
                    'type' => 'spacing',
                    'label' => __('Padding', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),

                'background_color' => array(
                    'type' => 'color',
                    'label' => __('Background Color', ZF_SHORTCODES_LANG),
                    'std' => '',
                ),

                'background_image' => array(
                    'type' => 'image_url',
                    'label' => __('Background Image', ZF_SHORTCODES_LANG),
                    'std' => '',
                ),

                'background_repeat' => array(
                    'type' => 'radio',
                    'label' => __('Background Repeat', ZF_SHORTCODES_LANG),
                    'options' => array(
                        '' => __('Default', ZF_SHORTCODES_LANG),
                        'no-repeat' => __('No Repeat', ZF_SHORTCODES_LANG),
                        'repeat'    => __('Repeat', ZF_SHORTCODES_LANG),
                    ),
                    'std' => '',
                ),
                'background_attachment' => array(
                    'type' => 'radio',
                    'label' => __('Background Attachment', ZF_SHORTCODES_LANG),
                    'options' => array(
                        '' => __('Default', ZF_SHORTCODES_LANG),
                        'fixed' => __('Fixed', ZF_SHORTCODES_LANG),
                        'scroll'  => __('Scroll', ZF_SHORTCODES_LANG),
                    ),
                    'std' => '',
                ),
            )
        ));
        /*==== Video params ====*/
        $this->set_shortcode('zf_video', array(
            'title' => __('Video', ZF_SHORTCODES_LANG),
            'shortcode' => '[zf_video{{attributes}}]',
            'params' => array(

                'type' => array(
                    'type' => 'select',
                    'label' => __('Type', ZF_SHORTCODES_LANG),
                    'options' => array(
                        'dailymotion' => __('Dailymotion', ZF_SHORTCODES_LANG),
                        'vimeo' => __('Vimeo', ZF_SHORTCODES_LANG),
                        'youtube' => __('Youtube', ZF_SHORTCODES_LANG),
                    ),
                    'std' => 'vimeo',
                ),

                'id' => array(
                    'type' => 'text',
                    'std' => '',
                    'label' => __('Video ID', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),

                'width' => array(
                    'type' => 'text',
                    'std' => 530,
                    'label' => __('Video Width', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),

                'height' => array(
                    'type' => 'text',
                    'std' => 300,
                    'label' => __('Video height', ZF_SHORTCODES_LANG),
                    'desc' => '',
                ),

                'autoplay' => array(
                    'type' => 'select',
                    'label' => __('Autoplay', ZF_SHORTCODES_LANG),
                    'options' => array(
                        'yes' => __('Yes', ZF_SHORTCODES_LANG),
                        'no' => __('No', ZF_SHORTCODES_LANG),
                    ),
                    'std' => 'no',
                ),

            )
        ), 'media');

    }
}

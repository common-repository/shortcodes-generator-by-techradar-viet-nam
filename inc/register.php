<?php
/**
 * @version    $Id$
 * @package    Shortcodes Generator By TechRadar Việt Nam
 * @author     TechRadar Việt Nam
 * @copyright  Copyright (C) 2018 TechRadar Việt Nam All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Shortcode loader
 */
Class ZF_Shortcode_Loader {


	protected $shortcode_tag = null;

	protected $params = null;

	protected $html_attrs = array();

	protected static $custom_style = array();


	public function __construct( $shortcode_tag, $params, $zf_shortcodes ) {
		$this->zf_shortcodes = $zf_shortcodes;
		$this->shortcode_tag = $shortcode_tag;
		$this->params        = $params;
		add_shortcode( $this->shortcode_tag, array( $this, 'callback' ) );
	}


	/**
	 * Get attributes of shortcode
	 * @param $shortcode_tag
	 * @return array
	 */
	protected function get_shortcode_attrs() {
		// empty attributes when rendering a shortcode. It must be called before calling set_html_attrs function
		$this->html_attrs = array();

		$attrs = array();

		if ( is_array( $this->params ) ) {

			foreach ( $this->params as $field => $param ) {
				if ( $field != 'content' ) {
					$attrs[ $field ] = isset( $param['std'] ) ? $param['std'] : '';
				}
			}

		}

		return $attrs;
	}

	public function output_custom_style() {

		$style = '';
		if ( count( self::$custom_style ) ) {
			$style .= '<style type="text/css" class="zf-output-custom-style">';
			foreach ( self::$custom_style as $script ) {
				$style .= $script;
			}
			$style .= '</style>';
		}

		return $style;
	}

	/**
	 * callback shortcode
	 * @param      $atts
	 * @param null $content
	 * @return string
	 */
	public function callback( $atts, $content = null ) {
		return $this->get_template_file( $atts, $content );
	}

	/**
	 * display shortcode
	 * @param      $atts
	 * @param null $content
	 * @return string
	 */
	public function output( $out = '' ) {
		echo $out;
	}

	/**
	 * Get style by attr string or attr array
	 * @param $attr
	 */
	public function get_style( $attrs ) {

		$style = '';

		if ( is_array( $attrs ) ) {
			foreach ( $attrs as $attr => $value ) {
				if ( $value != '' ) {
					$style .= $attr . ':' . $value . ';';
				}
			}
		} else {
			$style = $attrs;
		}

		return $style;
	}

	/**
	 * set html attributes. this function call after get_shortcode_attrs
	 * @param $key
	 * @param $val
	 */
	public function set_html_attrs( $key, $val ) {
		$this->html_attrs[ $key ] = trim( $val );
	}

	/**
	 * get html's attributes. this function call after get_shortcode_attrs
	 * @param $attrs array
	 */
	public function get_html_attrs() {

		$collect_attrs  = array();
		$html_attrs_str = '';
		//        // replace inline style with css
		//        if (isset($this->html_attrs['style'])) {
		//
		//            if (isset($this->html_attrs['class'])) {
		//                $this->html_attrs['class'] = $this->html_attrs['class'] . ' ' . $this->append_custom_style($this->html_attrs['style']);
		//            } else {
		//                $this->html_attrs['class'] = $this->append_custom_style($this->html_attrs['style']);
		//            }
		//            unset($this->html_attrs['style']);
		//        }

		if ( ! empty( $this->html_attrs ) ) {
			foreach ( $this->html_attrs as $attr => $val ) {
				if ( $val != '' ) {
					$collect_attrs[] = $attr . '="' . $val . '"';
				}
			}
		}

		if ( $collect_attrs ) {
			$html_attrs_str = implode( ' ', $collect_attrs );
			$html_attrs_str = ' ' . $html_attrs_str;
		}

		// empty attributes after processing done
		$this->html_attrs = array();

		return $html_attrs_str;
	}

	/**
	 * Append custom style and return selector
	 * @param $style
	 * @return string
	 */
	public function append_custom_style( $style ) {

		$selector             = 'zf-custom-style-' . time();
		self::$custom_style[] = '.' . $selector . '{' . $style . '}';

		return $selector;
	}

	/**
	 * Parse spacing string to arrays
	 * @param $value
	 * @return array
	 */
	public function get_spacing( $value ) {

		$key_values = array();

		if ( $value != '' ) {

			$values = explode( '|', $value );
			foreach ( $values as $val ) {
				$attr                   = explode( ':', $val );
				$key_values[ $attr[0] ] = $attr[1];
			}
		}

		return $key_values;
	}

	/**
	 * get style spacing
	 * @param $value
	 * @return array
	 */
	public function get_style_spacing( $type = 'margin', $arr = array() ) {
		$key_values = array();
		if ( isset( $arr['top'] ) ) {
			$key_values[ $type . '-top' ] = $arr['top'];
		}
		if ( isset( $arr['right'] ) ) {
			$key_values[ $type . '-right' ] = $arr['right'];
		}
		if ( isset( $arr['bottom'] ) ) {
			$key_values[ $type . '-bottom' ] = $arr['bottom'];
		}
		if ( isset( $arr['left'] ) ) {
			$key_values[ $type . '-left' ] = $arr['left'];
		}

		return $key_values;
	}

	/**
	 * Get shortcode template file from theme, plugin
	 * @param      $atts
	 * @param null $content
	 * @return string
	 */
	public function get_template_file( $atts, $content = null ) {
		$_template_file = $this->shortcode_tag;
		$_template_file = $_template_file . '.php';

		extract( shortcode_atts( $this->get_shortcode_attrs(), $atts ) );
		if ( file_exists( ZF_SHORTCODES_THEME_PATH . 'zf-shortcodes/' . $_template_file ) ) {
			ob_start();
			include( ZF_SHORTCODES_THEME_PATH . 'zf-shortcodes/' . $_template_file );
			$html = ob_get_clean();

			return $html;
		} else if ( file_exists( ZF_SHORTCODES_PLUGIN_PATH . 'templates/' . $_template_file ) ) {
			ob_start();
			include( ZF_SHORTCODES_PLUGIN_PATH . 'templates/' . $_template_file );
			$html = ob_get_clean();

			return $html;
		} else {
			return sprintf( __( 'The %s shortcode not found template', ZF_SHORTCODES_LANG ), str_replace( '.php', '', $_template_file ) );
		}

	}

}

/**
 * ZF_Shortcodes_Register
 */
Class ZF_Shortcodes_Register {

	private $shortcodes = null;

	public $core = null;

	public function __construct( $configs, $core ) {

		$this->shortcodes = $configs->get_shortcodes();
		$this->core       = $core;
		$this->register_shortcode();

		if ( is_admin() ) {
			require_once( 'admin/main.php' );
			new ZF_Shortcode_Admin( $configs );
		}
	}

	/**
	 * Resgister shortcdes
	 */
	public function register_shortcode() {
		if ( is_array( $this->shortcodes ) ) {
			foreach ( $this->shortcodes as $shortcode_tag => $configs ) {

				if ( isset( $configs['params'] ) ) {
					$configs_merged = $configs['params'];
					if ( isset( $configs['use_tab'] ) ) {
						$configs_merged = array_merge( $configs_merged, $configs['use_tab'] );
					}

					$loader = new ZF_Shortcode_Loader( $shortcode_tag, $configs_merged, $this->core );
				}
			}
		}

	}

}

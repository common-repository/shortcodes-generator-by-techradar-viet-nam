<?php


$this->set_html_attrs( 'id', $html_id );
$class = 'section';
if ( $animation != '' ) {
	$class .= ' wow';
	$class .= ' ' . $animation;
}
if ( $no_padding != '' && $no_padding == 'yes' ) {
	$class .= ' no-padding';
}
if ( $html_class !== '' ) {
	$class .= ' ' . $html_class;
}
$this->set_html_attrs( 'class', $class );

$margin_spacing  = $this->get_spacing( $margin );
$padding_spacing = $this->get_spacing( $padding );
if ( $background_image != '' ) {
	$background_image = 'url(' . $background_image . ')';
}
$style_attrs = array(
	'background-color'      => $background_color,
	'background-image'      => $background_image,
	'background-repeat'     => $background_repeat,
	'background-attachment' => $background_attachment,
);
$style_attrs = array_merge( $style_attrs, $this->get_style_spacing( 'margin', $margin_spacing ), $this->get_style_spacing( 'padding', $padding_spacing ) );
$this->set_html_attrs( 'style', $this->get_style( $style_attrs ) );
$output = '';

if ( $container == 'fixed-width' ) {
	$output .= '<div class="container">';
	$output .= zf_do_shortcode_content( $content );
	$output .= '</div>';
} else if ( $container == 'full-width' ) {
	$output .= '<div class="container-fluid">';
	$output = zf_do_shortcode_content( $content );
	$output .= '<div class="container">';
}
if ($section_tag == 'no') {
	$this->output( '<div' . $this->get_html_attrs() . '>' . $output . '</div>' );
} else {
	$this->output( '<section' . $this->get_html_attrs() . '>' . $output . '</section>' );
}

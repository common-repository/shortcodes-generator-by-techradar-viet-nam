<?php

$class = ( $column_size != '' ) ? 'col-sm-' . $column_size : 'col-sm-12';
if ( $responsive != '' ) {
	$class .= ' ' . $responsive;
}
$this->set_html_attrs( 'id', $html_id );
if ( $animation != '' ) {
	$class .= ' wow';
	$class .= ' ' . $animation;
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

$style_attrs['background-color']      = $background_color;
$style_attrs['background-image']      = $background_image;
$style_attrs['background-repeat']     = $background_repeat;
$style_attrs['background-attachment'] = $background_attachment;

$style_attrs = array_merge( $style_attrs, $this->get_style_spacing( 'margin', $margin_spacing ), $this->get_style_spacing( 'padding', $padding_spacing ) );
$this->set_html_attrs( 'style', $this->get_style( $style_attrs ) );

$this->output( '<div' . $this->get_html_attrs() . '>' . zf_do_shortcode_content( $content ) . '</div>' );
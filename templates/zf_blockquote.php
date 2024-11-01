<?php

$class = '';

$this->set_html_attrs( 'id', $html_id );
$class = '';
if ( $animation != '' ) {
	$class .= ' wow';
	$class .= ' ' . $animation;
}
if ( $align == 'right' ) {
	$class .= ' blockquote-reverse';
}
if ( $html_class !== '' ) {
	$class .= ' ' . $html_class;
}
$this->set_html_attrs( 'class', $class );

$this->output( '<blockquote' . $this->get_html_attrs() . '>' . zf_do_shortcode_content( $content ) . '</blockquote>' );
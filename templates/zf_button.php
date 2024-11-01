<?php

$class = 'btn btn-' . $type;

$this->set_html_attrs( 'type', 'button' );
$this->set_html_attrs( 'id', $html_id );
$this->set_html_attrs( 'title', $title );

if ( $size != '' ) {
	$class .= ' btn-' . $size;
}

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

$this->output( '<button' . $this->get_html_attrs() . '>' . zf_do_shortcode_content( $content ) . '</button>' );

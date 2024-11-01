<?php


$class = 'img-responsive';
$this->set_html_attrs( 'id', $html_id );
if ( $animation != '' ) {
	$class .= ' wow';
	$class .= ' ' . $animation;
}
if ( $html_class !== '' ) {
	$class .= ' ' . $html_class;
}

$this->set_html_attrs( 'class', $class );
$this->set_html_attrs( 'alt', $title );

if ( $src != '' ) {
	$this->set_html_attrs( 'src', $src );
} else {
	$default_width  = ( $width > 0 ) ? $width : 50;
	$default_height = ( $height > 0 ) ? $height : 50;
	$this->set_html_attrs( 'src', 'http://placehold.it/' . $default_width . 'x' . $default_height . '' );
}
if ( $width > 0 ) {
	$this->set_html_attrs( 'width', $width );
}
if ( $height > 0 ) {
	$this->set_html_attrs( 'height', $height );
}
$this->output( '<img ' . $this->get_html_attrs() . ' />' );

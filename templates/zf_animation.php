<?php

$class = '';

$this->set_html_attrs( 'id', $html_id );
if ( $animation != '' ) {
	$class .= ' wow';
	$class .= ' ' . $animation;
}
if ( $html_class !== '' ) {
	$class .= ' ' . $html_class;
}
$this->set_html_attrs( 'class', $class );

if ($delay != '') {
	$this->set_html_attrs( 'data-wow-delay', $delay .'s' );
}

if ($duration != '') {
	$this->set_html_attrs( 'data-wow-duration', $duration .'s' );
}

if ($span == 'yes') {
	$this->output( '<span' . $this->get_html_attrs() . '>' . zf_do_shortcode_content( $content ) . '</span>' );
} else {
	$this->output( '<div' . $this->get_html_attrs() . '>' . zf_do_shortcode_content( $content ) . '</div>' );
}


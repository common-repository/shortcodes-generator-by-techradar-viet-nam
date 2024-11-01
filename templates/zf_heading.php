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

$this->output( '<' . $type . '' . $this->get_html_attrs() . '>' . zf_do_shortcode_content( $content ) . '</' . $type . '>' );
<?php

$class = '';

if ( $html_class !== '' ) {
	$class .= ' ' . $html_class;
}
$this->set_html_attrs( 'class', $class );

$this->output( '<p' . $this->get_html_attrs() . '>' . zf_do_shortcode_content( $content ) . '</p>' );
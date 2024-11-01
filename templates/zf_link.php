<?php

$class = '';
$this->set_html_attrs( 'id', $html_id );

if ( $html_class !== '' ) {
	$class .= ' ' . $html_class;
}

$this->set_html_attrs( 'class', $class );

if ( $url != '' ) {
	$this->set_html_attrs( 'href', $url );
}
if ( $open_new_window == 'yes' ) {
	$this->set_html_attrs( 'target', '_blank' );
}
if ( $title != '' ) {
	$this->set_html_attrs( 'title', $title );
}

$this->output( '<a' . $this->get_html_attrs() . '>' . zf_do_shortcode_content( $content ) . '</a>' );

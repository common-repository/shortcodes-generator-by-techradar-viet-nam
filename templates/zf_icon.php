<?php
$class = 'fa fa-';

if ( $icon !== '' ) {

	$class .= '' . $icon;

	if ( $size !== '' ) {
		$class .= ' ' . $size;
	}

	if ( $html_class !== '' ) {
		$class .= ' ' . $html_class;
	}

	$this->set_html_attrs( 'class', $class );

	if ( $color != '' ) {
		$this->set_html_attrs( 'style', 'color: ' . $color . ';' );
	}

	$this->output( '<span class="zf-icon"><i' . $this->get_html_attrs() . '></i></span>' );
}

<?php

$close_html = '';
if ( $close == 'true' ) {
	$close_html = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
}

$class = 'alert alert-' . $type . '';
$this->set_html_attrs( 'class', $class );
$this->output( '<div' . $this->get_html_attrs() . '>' . $close_html . '' . zf_do_shortcode_content( $content ) . '</div>' );
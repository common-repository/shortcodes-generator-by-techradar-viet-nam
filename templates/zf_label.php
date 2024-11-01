<?php

$this->set_html_attrs( 'class', 'label label-' . $type );
$this->output( '<span' . $this->get_html_attrs() . '>' . $title . '</span>' );
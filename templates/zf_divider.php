<?php

if ( $type == 'space' ) {
	$this->output( '<div class="zf-space" style="margin-bottom: ' . $height . 'px;"></div>' );
} elseif ( $type == 'line' ) {
	$this->output( '<div class="zf-line" style="line-height: ' . $height . 'px;"></div>' );
}
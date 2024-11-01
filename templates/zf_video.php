<?php

$html = '';
if ( ! empty( $id ) ) {

	$autoplay = ( $autoplay == 'yes' ? '1' : false );

	if ( $type == "dailymotion" ) {
		$html = "<div class='video-embed'><iframe src='http://www.dailymotion.com/embed/video/$id?width=$width&amp;autoPlay={$autoplay}&foreground=%23FFFFFF&highlight=%23bbbbbb&background=%23ffffff&logo=0&hideInfos=1' width='$width' height='$height' class='iframe'></iframe></div>";
	} else if ( $type == "vimeo" ) {
		$html = "<div class='video-embed'><iframe src='http://player.vimeo.com/video/$id?autoplay=$autoplay&amp;title=0&amp;byline=0&amp;portrait=0' width='$width' height='$height' class='iframe'></iframe></div>";
	} else if ( $type == "youtube" ) {
		$html = "<div class='video-embed'><iframe src='http://www.youtube.com/embed/$id?autoplay=$autoplay&amp;HD=1;rel=0;showinfo=0' width='$width' height='$height' class='iframe'></iframe></div>";
	}


}
$this->output( $html );
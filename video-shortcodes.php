<?php

function html5video( $atts, $content = null ) {
    if (empty($atts['src'])) return;

    $content_text = '<video class="wp-video-shortcode" id="video" preload="auto" controls="controls" height="auto" width="100%">';
    $content_text .= '<source type="video/mp4" src="'.$atts['src'].'">';
    $content_text .= '<a href="'.$atts['src'].'">'.$atts['src'].'</a></source></video>';

    return $content_text;
}

// Register the shortcode
add_shortcode("html5video", "html5video");

function youtubeEmbedVideo($atts, $content = null){

	//$content .= '<iframe webkitallowfullscreen mozallowfullscreen allowfullscreen width="100%" height="auto" src="http://www.youtube.com/embed/XGSy3_Czz8k"></iframe>';
    if (empty($atts['src'])) return;
	$content .= '<a href="'.$atts['src'].'" target="_blank">';
	$content .= '<img class="img-responsive" style="cursor: pointer;" src="'.site_url().'/wp-content/themes/je-theme/img/rounded-play-button_318-9366.jpg" alt="" />';	
	$content .= '</a>';

	return $content;
}

add_shortcode("youtubeEmbedVideo" , "youtubeEmbedVideo");

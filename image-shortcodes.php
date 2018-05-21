<?php

function jeimage( $atts, $content = null ) {
    if (empty($atts['id'])) return;

    $img = wp_get_attachment_image_src( $atts['id'], 'full' );
    $content .= '<img class="img-responsive product-'.$atts['id'].'" src="'.$img[0].'"/>';
    return $content;
}

// Register the shortcode
add_shortcode("jeimage", "jeimage");


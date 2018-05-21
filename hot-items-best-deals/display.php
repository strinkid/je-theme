<?php
function display_hot_items( $atts, $content = null ) {
    return display_products("hot_items_", "HOT ITEMS");
}
function display_best_deals( $atts, $content = null ) {
    return display_products("best_deals_", "BEST DEALS");
}

function display_products($option_name, $title_name) {
    $product_list = array();
    for ($i = 1; $i < 5; $i++) {
        $post_id = get_option($option_name.$i);
        if (empty($post_id) || $post_id == 'undefined') continue;
        array_push($product_list, $post_id);
    }

    $content = '';
    $content .= '<div class="hotItemsTitle">';
    $content .= $title_name     ;
    $content .= '</div>';
    $content .= '<div class="row">';
    if ( count($product_list) == 0 ) return $content;

    $query_args = array(
        'posts_per_page' => 5,
        'no_found_rows'  => 1,
        'post_status'    => 'publish',
        'post_type'      => 'product',
        'post__in'       => $product_list
    );
    $products = new WP_Query($query_args);

    foreach($products->posts as $product){
        $post_id = $product->ID;
       /* $args = array(
            'post_type' => 'attachment',
            'numberposts' => -1,
            'post_status' => null,
            'post_parent' => $post_id
        );

        $attachments = get_posts( $args );
		*/
		
		
		$img_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'thumbnail' );
		$img_thumb = !isset($img_thumb[0]) ? get_template_directory_uri() . '/img/placeholder-150x150.png' : $img_thumb[0];
		
		/*$imgsrc = get_template_directory_uri() . '/img/placeholder-150x150.png';
		$AliasItem  = wp_get_attachment_image_src( $attachments[0]->ID, 'thumbnail' );
        if (count($attachments)>0) $imgsrc = $AliasItem [0];
		*/

		$AliasItem  = get_post_meta($product->ID,'_regular_price');
        $regular_price = $AliasItem[0];
		$AliasItem = get_post_meta($product->ID,'_sale_price');
        $sale_price = $AliasItem[0];
        $sale_percentage = calculate_sale_percentage($regular_price, $sale_price);

        $content .= '<div class="col-xs-6 col-sm-3 col-md-12 col-lg-12 hotItemsContent">';
        $content .= '<li class="product">';
        $content .= '<a href="'.get_permalink( $post_id ).'">';
        $content .= '<div class="hotItemsSaleIconParent">';
        $content .= '<div class="hotItemsSaleIconChild"><div class="sale-percentage">'.$sale_percentage.'</div></div>';
        $content .= '<img src="' . $img_thumb . '" alt="Placeholder"><br/>';
        $content .= '</div>';
        if(strlen($product->post_title) < 35){
        $content .= '<div class="productTitle-mostView-panel">'.$product->post_title.'</div>';
        }else{
        $content .= '<div class="productTitle-mostView-panel">'.balanceTags(substr($product->post_title , 0, 35), true).'...</div>';
        }
		$content .= '</a>';
        $content .= '<div class="regularPriceText">'.getCurrencyDisplay($regular_price).'</div>';
        $content .= '<div class="salePriceText">'.getCurrencyDisplay($sale_price).'</div>';
        
        $content .= '</li>';
        $content .= '</div>';
    }
    $content .= '</div>';
    return $content;
}

// Register the shortcode
add_shortcode("display_hot_items", "display_hot_items");
add_shortcode("display_best_deals", "display_best_deals");

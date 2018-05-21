<?php
function recent_view_items_function( $atts, $content = null ) {
    global $woocommerce;

    extract(shortcode_atts(array("count" => '5'), $atts));

    // Get recently viewed product cookies data
    $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
    $viewed_products = array_filter( array_map( 'absint', $viewed_products ) );

    // If no data, quit
    if ( empty( $viewed_products ) )
        //return __( 'You have not viewed any product yet!', 'rc_wc_rvp' );
        return __( '', 'rc_wc_rvp' );

    // Get products per page
    if( !isset( $count ) ? $number = 5 : $number = $count )
        // Create query arguments array
        $query_args = array(
            'posts_per_page' => $number,
            'no_found_rows'  => 1,
            'post_status'    => 'publish',
            'post_type'      => 'product',
            'post__in'       => $viewed_products,
            'orderby'        => 'rand'
        );

    // Add meta_query to query args
    $query_args['meta_query'] = array();

    // Create a new query
    $products = new WP_Query($query_args);

    // If query return results
    $content .= '<div class="homeViewItems">';
    $content .= '<div class="recent-view-title">';
    $content .= '<h3 class="MainTitle-viewHistory"><b>BARANG YANG BARU SAJA DILIHAT</b></h3>';
    $content .= '</div>';
    $content .= '<div class="recent-view-productList">';
	$content .= '<div class="row">';
    $product_list = array();
    $product_count = count($products->posts);
    for ($i = 0; $i < 5-$product_count-1; $i++) {
        if ($i==0) $content .= '<div class="col-md-10p"></div>';
        else $content .= '<div class="col-md-20p"></div>';
    }

    foreach($products->posts as $product){
        $post_id = $product->ID;
        $args = array(
            'post_type' => 'attachment',
            'numberposts' => -1,
            'post_status' => null,
            'post_parent' => $post_id
        );

        $attachments = get_posts( $args );

        $content .= '<div class="col-xs-6 col-sm-4 col-md-20p">';
        $content .= '<li class="product productlist-viewHistory">';
        $content .= '<a href="'.get_permalink( $post_id ).'">';
        if (has_post_thumbnail( $post_id )>0) $content .= get_the_post_thumbnail( $post_id, 'thumbnail' ).'<br/>';
        else $content .= '<img src="' . get_template_directory_uri() . '/img/placeholder-150x150.png" alt="Placeholder"><br/>';
        $content .= '<div class="productTitle-mostView-panel">'.$product->post_title.'</div>';
        if(strlen($product->post_excerpt) < 100){
        //$content .= '<div class="short-desc-MostView-panel">'.$product->post_excerpt.'</div>';
        }else{
        //$content .= '<div class="short-desc-MostView-panel">'.balanceTags(substr($product->post_excerpt , 0, 100), true).'...</div>';
        }
		$AliasMeta = get_post_meta($product->ID,'_regular_price');
		$content .= '</a>';
        $content .= '<div class="salePriceText">'.getCurrencyDisplay($AliasMeta[0]).'</div>';
        
        $content .= '</li>';
        $content .= '</div>';
    }
	$content .= '</div>';
    $content .= '</div>';
    $content .= '</div>';

    // Return whole content
    if($product_count < 2){
        return "";
    } else {
    return $content;
    }
}


// Register the shortcode
add_shortcode("recent_view_items", "recent_view_items_function");

// Register the shortcode
//add_action("woocommerce_after_single_product", "recent_view_items_single_product",10);


function recent_view_items_single_product( $atts, $content = null ) {
    global $woocommerce;

    extract(shortcode_atts(array("count" => '5'), $atts));

    // Get recently viewed product cookies data
    $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
    $viewed_products = array_filter( array_map( 'absint', $viewed_products ) );

    // If no data, quit
    if ( empty( $viewed_products ) )
        //return __( 'You have not viewed any product yet!', 'rc_wc_rvp' );
        return __( '', 'rc_wc_rvp' );

    // Get products per page
    if( !isset( $count ) ? $number = 5 : $number = $count )
        // Create query arguments array
        $query_args = array(
            'posts_per_page' => $number,
            'no_found_rows'  => 1,
            'post_status'    => 'publish',
            'post_type'      => 'product',
            'post__in'       => $viewed_products,
            'orderby'        => 'rand'
        );

    // Add meta_query to query args
    $query_args['meta_query'] = array();

    // Create a new query
    $products = new WP_Query($query_args);

    // If query return results
    $content .= '<div class="homeViewItems">';
    //$content .= '<div class="recent-view-title">';
    $content .= '<h2 class="MainTitle-viewHistory m-b-md" style="padding-bottom:0px !important">Barang Yang Baru Saja Dilihat</h2>';
    //$content .= '</div>';
    $content .= '<div class="row">';
    $product_list = array();
    $product_count = count($products->posts);
    for ($i = 0; $i < 5-$product_count-1; $i++) {
        if ($i==0) $content .= '<div class="col-md-10p"></div>';
        else $content .= '<div class="col-md-20p"></div>';
    }

    foreach($products->posts as $product){
        $post_id = $product->ID;
        $args = array(
            'post_type' => 'attachment',
            'numberposts' => -1,
            'post_status' => null,
            'post_parent' => $post_id
        );

        $attachments = get_posts( $args );

        $content .= '<div class="col-xs-6 col-md-2">';
        $content .= '<li class="product productlist-viewHistory">';
        $content .= '<a href="'.get_permalink( $post_id ).'">';
        if (has_post_thumbnail( $post_id )>0) $content .= get_the_post_thumbnail( $post_id, 'thumbnail' ).'<br/>';
        else $content .= '<img src="' . get_template_directory_uri() . '/img/placeholder-150x150.png" alt="Placeholder"><br/>';
        $content .= '<div class="productTitle-mostView-panel">'.$product->post_title.'</div>';
        if(strlen($product->post_excerpt) < 100){
        //$content .= '<div class="short-desc-MostView-panel">'.$product->post_excerpt.'</div>';
        }else{
        //$content .= '<div class="short-desc-MostView-panel">'.balanceTags(substr($product->post_excerpt , 0, 100), true).'...</div>';
        }
		$AliasMeta = get_post_meta($product->ID,'_regular_price');
		$content .= '</a>';
        $content .= '<div class="salePriceText">'.getCurrencyDisplay($AliasMeta[0]).'</div>';
        
        $content .= '</li>';
        $content .= '</div>';
    }
    $content .= '</div>';
    $content .= '</div>';

    // Return whole content
    if($product_count < 2){
        return "";
    } else {
    echo $content;
    }
}

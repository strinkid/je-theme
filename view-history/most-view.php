<?php
function most_view_items( $atts, $content = null ) {
    global $wpdb;
    global $product;
    global $wp_scripts;
    optimizeHomePageScripts();

    if (empty($atts['count'])) $count = 5;
    else $count = $atts['count'];

    /*$sql = "select id, post_title, meta_value, post_excerpt ";
    $sql .= "from wp_posts a, wp_postmeta b, ";
    $sql .= "(select post_id from wp_postmeta where meta_key='users_who_view' ";
    $sql .= "order by (LENGTH(meta_value) - LENGTH(REPLACE(meta_value, ',', ''))) desc limit 20) c ";
    $sql .= "where a.id=b.post_id ";
    $sql .= "and meta_key='_regular_price' ";
    $sql .= "and b.post_id = c.post_id ";
    $sql .= "and a.post_status = 'publish' ";*/
	
	$sql = "SELECT c.id,c.post_title,d.meta_value as _price,e.meta_value as _regular_price 
		FROM wp_postmeta a
		LEFT JOIN wp_postmeta b on a.post_id=b.post_id
		LEFT JOIN wp_posts c on a.post_id=c.ID
		LEFT JOIN wp_postmeta d on a.post_id=d.post_id
		LEFT JOIN wp_postmeta e on e.post_id=d.post_id
		where a.meta_key='users_who_view' AND b.meta_value='instock' AND c.post_status='publish' 
		AND d.meta_key='_price'
		AND e.meta_key='_regular_price'
		order by (LENGTH(a.meta_value) - LENGTH(REPLACE(a.meta_value, ',', ''))) desc limit 20";
	//$content .=$sql;
    $results = $wpdb->get_results($sql);

    $content .= '<div class="homeViewItems">';
    $content .= '<div class="most-view-title">';
    $content .= '<h3 class="MainTitle-viewHistory"><b>BARANG YANG PALING SERING DILIHAT</b></h3>';
    $content .= '</div>';
    $content .= '<div class="most-view-productList">';
    $content .= '<div class="row">';
    $product_list = array();
	$i = 1;
    foreach($results as $result){
		if($i <= 20){
        $post_id = $result->id;
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
		
        /*if (count($attachments)>0) $content .= get_the_post_thumbnail( $post_id, 'thumbnail' ).'<br/>';
        else $content .= '<img align="left" src="' . get_template_directory_uri() . '/img/placeholder-150x150.png" alt="Placeholder"><br/>';*/
		
		if (has_post_thumbnail( $post_id )>0) $content .= get_the_post_thumbnail( $post_id, 'thumbnail' ).'<br/>';
        else $content .= '<img align="left" src="' . get_template_directory_uri() . '/img/placeholder-150x150.png" alt="Placeholder"><br/>';
        
		$content .= '<div class="productTitle-mostView-panel">'.$result->post_title.'</div>';
        //if(strlen($result->post_excerpt) < 100){
        //$content .= '<div class="short-desc-MostView-panel">'.$result->post_excerpt.'</div>';
        //}else{
        //$content .= '<div class="short-desc-MostView-panel">'.balanceTags(substr($result->post_excerpt , 0, 100), true).'...</div>';
        //}
		$content .= '</a>';
		if($result->_price < $result->_regular_price){
			$content .= '<span class="regularPriceText">Rp. '.$result->_regular_price.'</span>';	
		}
        $content .= '<div class="salePriceText">'.getCurrencyDisplay($result->_price).'</div>';
        
        $content .= '</li>';
        $content .= '</div>';
		}
		$i++;
    }
    $content .= '</div>';
    $content .= '</div>';
    $content .= '</div>';
    return $content;
}

// Register the shortcode
add_shortcode("most_view_items", "most_view_items");


<?php
function customer_who_view_also_buy($atts, $content = null)
{
    $per_page = get_option('total_items_display');
    $plugin_title = get_option('customer_who_viewed_title');
    $category_filter = get_option('category_filter');
    $show_image_filter = get_option('show_image_filter');
    $show_price_filter = get_option('show_price_filter');
    $show_addtocart_filter = get_option('show_addtocart_filter');
    $product_order = get_option('product_order');
    // Get WooCommerce Global
    global $woocommerce;
    global $post;
    global $wpdb;
	
	$AliasMeta = get_post_meta($post->ID, 'users_who_view');
    $users_who_view_meta = $AliasMeta[0];
    $sql = "select d.meta_value ";
    $sql .= "from wp_posts a , wp_postmeta b, wp_woocommerce_order_items c, wp_woocommerce_order_itemmeta d ";
    $sql .= "where a.id=b.post_id ";
    $sql .= "and a.id=c.order_id ";
    $sql .= "and c.order_item_id=d.order_item_id ";
    $sql .= "and a.post_type='shop_order' ";
    $sql .= "and b.meta_key = '_customer_user' ";
    $sql .= "and b.meta_value in (" . substr($users_who_view_meta, 0, strlen($users_who_view_meta) - 1) . ") ";
    $sql .= "and d.meta_key = '_product_id' group by d.meta_value order by count(d.meta_value) desc, d.meta_value ";
    $sql .= "LIMIT 6 ";
	//echo $sql;
    $results = $wpdb->get_results($sql);

    $customer_also_viewed = '';
    foreach ($results as $result) {
        if ($customer_also_viewed == '') $customer_also_viewed = $result->meta_value;
        else $customer_also_viewed .= ',' . $result->meta_value;
    }

    if (!empty($customer_also_viewed)) {
        $customer_also_viewed = explode(',', $customer_also_viewed);

        //Skip same product on product page from the list
        if (($key = array_search($post->ID, $customer_also_viewed)) !== false) {
            unset($customer_also_viewed[$key]);
        }

        $per_page = ($per_page == "") ? $per_page = 5 : $per_page;
        $plugin_title = ($plugin_title == "") ? $plugin_title = 'Customer Who Viewed This Item Also Viewed' : $plugin_title;

        // Create the object
        ob_start();

        $categories = get_the_terms($post->ID, 'product_cat');

        // Create query arguments array
        $query_args = array(
            'posts_per_page' => $per_page,
            'no_found_rows' => 1,
            'post_status' => 'publish',
            'post_type' => 'product',
            'post__in' => $customer_also_viewed
        );

        //Executes if category filter applied on product page
        if ($category_filter == 1 && !empty($categories)) {
            foreach ($categories as $category) {
                if ($category->parent == 0) {
                    $category_slug = $category->slug;
                }
            }
            $query_args['product_cat'] = $category_slug;
        }

        // Add meta_query to query args
        $query_args['meta_query'] = array();

        // Check products stock status
        $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();

        // Create a new query
        $products = new WP_Query($query_args);

        // If query return results
        if (!$products->have_posts()) {
            // If no data, quit
            exit;
        } else { //Displays title
            // If query return results
            $content .= '<div class="homeViewItems">';
            //$content .= '<div class="row">';
            $content .= '<h2 class="MainTitle-viewHistory m-b-md">Recommended Products</h2>';
            //$content .= '</div>';
            $content .= '<div class="row">';
            $product_list = array();
            $product_count = count($products->posts);


            $offsetClass = '';
            //if ($product_count < 6) $offsetClass = '<div class="visible-md visible-lg col-md-'.(6-$product_count).'"></div>';
            $content .= $offsetClass;
            foreach ($products->posts as $product) {
                $post_id = $product->ID;
                $args = array(
                    'post_type' => 'attachment',
                    'numberposts' => -1,
                    'post_status' => null, 
                    'post_parent' => $post_id
                );

                $attachments = get_posts($args);

                $content .= '<div class="col-xs-6 col-md-2">';
                $content .= '<li class="product productlist-viewHistory">';
                $content .= '<a class="customer_also_viewed_title" href="' . get_permalink($post_id) . '">';
                if (has_post_thumbnail( $post_id ) > 0) $content .= get_the_post_thumbnail($post_id, 'thumbnail') . '<br/>';
                else $content .= '<img src="' . get_template_directory_uri() . '/img/placeholder-150x150.png" alt="Placeholder"><br/>';
                $content .= '<div class="productTitle-mostView-panel">'.$product->post_title . '</div>';
                if(strlen($product->post_excerpt) < 100){
                //$content .= '<div class="short-desc-MostView-panel">'.$product->post_excerpt.'</div>'; // untuk deskripsi
                }else{
                //$content .= '<div class="short-desc-MostView-panel">'.balanceTags(substr($product->post_excerpt , 0, 100), true).'..</div>'; // untuk deskripsi
                }
				$AliasMeta = get_post_meta($product->ID, '_regular_price');
                $content .= '<div class="salePriceText">'.getCurrencyDisplay($AliasMeta[0]).'</div>';
                $content .= '</a>';
                $content .= '</li>';
                $content .= '</div>';
            }
            $content .= '</div>';
            $content .= '</div>';

        }
    }

    echo $content;
}

// Register the shortcode
//add_action("woocommerce_after_single_product", "customer_who_view_also_buy", 10);
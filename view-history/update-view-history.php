<?php

add_action('woocommerce_after_single_product', 'update_user_who_view_posts');

function update_user_who_view_posts()
{
    global $post;
	$AliasMeta = get_post_meta( $post->ID, 'users_who_view' );
    $users_who_view_meta = $AliasMeta[0];
    if(!empty($users_who_view_meta)){
        $users_who_view = (array) explode( ',', $users_who_view_meta );
        if(($key = array_search(get_current_user_id(), $users_who_view)) !== false) { return; }
    }
    $users_who_view_meta .= get_current_user_id() . ',';
    update_post_meta( $post->ID, 'users_who_view', $users_who_view_meta );

    /*$customer_also_viewed = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
    if(($key = array_search($post->ID, $customer_also_viewed)) !== false) { unset($customer_also_viewed[$key] ); }

    if(!empty($customer_also_viewed))
    {
        foreach($customer_also_viewed as $viewed)
        {
            $option = 'customer_also_viewed_'.$viewed;
            $option_value = get_option($option);

            if(isset($option_value) && !empty($option_value))
            {
                $option_value = explode(',', $option_value);
                if(!in_array($post->ID,$option_value))
                {
                    $option_value[] = $post->ID;
                }
            }

            $option_value = (count($option_value) > 1) ? implode(',', $option_value) : $post->ID;

            update_option($option, $option_value);
        }
    } */
}

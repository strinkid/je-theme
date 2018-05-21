<?php

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

function displayFullDescription()
{
	
	if(isset($_GET['tab'])){
		displayFullDescriptionTab();
		return;
	}
	
    global $product;
    $tabs = apply_filters( 'woocommerce_product_tabs', array() );
if ( ! empty( $tabs ) ) : ?>

	<div class="woocommerce-tabs" id="spesifikasibawah">
    
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<?php //echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?>
			<?php endforeach; ?>
		
		<?php foreach ( $tabs as $key => $tab ) : ?>
			
				<?php call_user_func( $tab['callback'], $key, $tab ); ?>

		<?php endforeach; ?>
	</div>
<?php endif;
}
/*function displayFullDescriptionTab()
{
    global $product;
    $tabs = apply_filters( 'woocommerce_product_tabs', array() );
if ( ! empty( $tabs ) ) : ?>

	<div class="woocommerce-tabs" id="spesifikasibawah">
    	<hr>
		<ul class="tabs">
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<li class="<?php echo esc_attr( $key ); ?>_tab">
					<a href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php foreach ( $tabs as $key => $tab ) : ?>
			<div class="panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>">
				<?php call_user_func( $tab['callback'], $key, $tab ); ?>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif;
}
*/
add_action("woocommerce_after_single_product", "displayFullDescription", 20);

function add_compare_link_je($product_id = false)
{

    if (!$product_id) {
        global $product;
        $product_id = isset($product->id) && $product->exists() ? $product->id : 0;
    }

    // return if product doesn't exist
    if (empty($product_id) || apply_filters('yith_woocompare_remove_compare_link_by_cat', false, $product_id))
        return;

    $is_button = !isset($button_or_link) || !$button_or_link ? get_option('yith_woocompare_is_button') : $button_or_link;


    if (!isset($button_text) || $button_text == 'default') {
        $button_text = get_option('yith_woocompare_button_text', __('Compare', 'yith-wcmp'));
        $button_text = function_exists('icl_translate') ? icl_translate('Plugins', 'plugin_yit_compare_button_text', $button_text) : $button_text;
    }
    $classes = 'compare';
    $products_list = isset($_COOKIE['yith_woocompare_list']) ? unserialize($_COOKIE['yith_woocompare_list']) : array();

    $styleAdd = '';
    $styleRemove = ' style="display:none"';
    if (in_array($product_id, $products_list)) {
        $styleAdd = ' style="display:none"';
        $styleRemove = '';
    }
    printf('<div class="compareButtonAdd"' . $styleAdd . '><a href="%s" class="%s" data-product_id="%d">%s</a></div>', add_product_url($product_id), 'compare' . ($is_button == 'button' ? ' button' : ''), $product_id, '<input type="checkbox">Compare');

    ?><div class="compareButtonRemove" <?php echo $styleRemove; ?>><?php

    printf('<div class="view-BtnCompare"><ul><a style="text-decoration:underline!important" href="%s" class="%s" data-product_id="%d">%s</a></ul></div>', '/?action=yith-woocompare-view-table&iframe=1', 'compare added' . ($is_button == 'button' ? ' button' : ''), $product_id, 'View Compare');

    ?>
    <div class="pull-right">
    <div class="remove">
        <a href="<?php echo add_query_arg('redirect', 'view', remove_all_product_url()) ?>" data-product_id="all"><?php _e('Clear All', 'yit') ?></a>
    </div><?php

    ?><div class="remove">
        <a href="<?php echo add_query_arg('redirect', 'view', remove_product_url($product_id)) ?>" data-product_id="<?php echo $product_id; ?>"><?php _e('<input type="checkbox" checked>Clear', 'yit') ?></a>
    </div><?php

    ?></div></div><?php


}

function add_product_url($product_id)
{
    $url_args = array(
        'action' => 'yith-woocompare-add-product',
        'id' => $product_id
    );
    return apply_filters('yith_woocompare_add_product_url', wp_nonce_url(esc_url_raw(add_query_arg($url_args)), 'yith-woocompare-add-product'));
}

function remove_product_url($product_id)
{
    $url_args = array(
        'action' => 'yith-woocompare-remove-product',
        'id' => $product_id
    );
    return apply_filters('yith_woocompare_remove_product_url', wp_nonce_url(esc_url_raw(add_query_arg($url_args)), 'yith-woocompare-remove-product'));
}

function remove_all_product_url()
{
    $url_args = array(
        'action' => 'yith-woocompare-remove-all-product',
        'id' => 'all'
    );
    return apply_filters('yith_woocompare_remove_all_product_url', wp_nonce_url(esc_url_raw(add_query_arg($url_args)), 'yith-woocompare-remove-all-product'));
}

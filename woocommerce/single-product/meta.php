<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );

?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

    <div class="productDetailsMeta">Gratis Ongkos Kirim ke seluruh Indonesia</div>
    <div class="productDetailsMeta">Garansi 2 Bulan</div>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
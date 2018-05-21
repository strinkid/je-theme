<?php
/**
 * Empty cart page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version    3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

?>
<h1 class="cart-empty"><?php _e( 'Your Shopping Cart is empty.', 'woocommerce' ) ?></h1>
<p>Tidak ada barang dalam keranjanga belanja Anda, gunakan tombol Add To Cart untuk memasukan barang yang akan Anda beli ke Keranjang Belanja.</p>
<?php do_action( 'woocommerce_cart_is_empty' ); ?>
<div class="empty-cart2">
<a class="wc-backward" href="<?php echo apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ); ?>"><p class="roll-button"><span data-title="LANJUTKAN BELANJA"><?php _e( 'LANJUTKAN BELANJA', 'woocommerce' ) ?></span></p></a></div>
<?php
add_action('recent_view_items_cart','recent_view_items_single_product');
do_action('recent_view_items_cart' );
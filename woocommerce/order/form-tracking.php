<?php
/**
 * Order tracking form
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;
?>
<!-- CUSTOM ORDER TRACKING FORM -->
<div class="row">
  <div class="col-md-12">
	  <h1 class="cart-empty">Track Your Order.</h1>
      <p><?php _e( 'To track your order please enter your Order ID in the box below and press the "Track" button. This was given to you on your receipt and in the confirmation email you should have received.', 'woocommerce' ); ?></p>
  </div>
  <div class="col-md-5">
	<form action="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" method="post" class="track_order">
		<div id="box-order">
			<div id="order-id">
				<label for="orderid"><?php _e( 'Order ID', 'woocommerce' ); ?></label><input class="input-text" type="text" name="orderid" id="orderid" placeholder="<?php _e( 'Found in your order confirmation email.', 'woocommerce' ); ?>" /></p>
			</div>

			<div id="order-email">
				<label for="order_email"><?php _e( 'Billing Email', 'woocommerce' ); ?></label><input class="input-text" type="text" name="order_email" id="order_email" placeholder="<?php _e( 'Email you used during checkout.', 'woocommerce' ); ?>" /></p>
			</div>
		</div>
		<div class="clear"></div>

		<p class="form-row"><input type="submit" class="button" name="track" value="<?php _e( 'Track', 'woocommerce' ); ?>" /></p>
		<?php wp_nonce_field( 'woocommerce-order_tracking' ); ?>

	</form>
  </div>
</div>
<div class="empty-cart2"></div>
<?php
add_action('recent_view_items_tracking','recent_view_items_single_product');
do_action('recent_view_items_tracking' );
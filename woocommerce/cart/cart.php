<?php
/**
 * Cart Page
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<div class="container">
<h1 class="cart-title">SHOPPING CART</h1><br/>
<?php $link = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $woocommerce->cart->get_cart_url(); ?>
<form action="<?php echo esc_url( $link ); ?>" method="post" class="m-b-lg">

    <?php do_action( 'woocommerce_before_cart_table' ); ?>
    <div class="table-responsive">
    <table class="shop_table cart table" cellspacing="0">
        <thead class="cart-thead">
        <tr>
            <th class="product-name cart-th"><?php _e( 'Product', 'woocommerce' ); ?></th>
            <th class="product-thumbnail">&nbsp;</th>
            <th class="product-price cart-th"><?php _e( 'Price', 'woocommerce' ); ?></th>
            <th class="product-quantity cart-th"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
            <th class="product-subtotal cart-th"><?php _e( 'Total', 'woocommerce' ); ?></th>
            <th class="product-remove">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php do_action( 'woocommerce_before_cart_contents' ); ?>

        <?php
        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
            $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                ?>
                <tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

                    <td class="product-thumbnail">
                        <?php
                        $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                        if ( ! $_product->is_visible() ) {
                            echo $thumbnail;
                        } else {
                            printf( '<a href="%s">%s</a>', esc_url( $_product->get_permalink( $cart_item ) ), $thumbnail );
                        }
                        ?>
                    </td>

                    <td class="product-name">
                        <?php
                        if ( ! $_product->is_visible() ) {
                            echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
                        } else {
                            echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', esc_url( $_product->get_permalink( $cart_item ) ), $_product->get_title() ), $cart_item, $cart_item_key );
                            echo '<br/>Product No: '.$_product->get_sku();
                        }

                        // Meta data
                        echo WC()->cart->get_item_data( $cart_item );

                        // Backorder notification
                        if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                            echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
                        }
                        ?>
                    </td>

                    <td class="product-price">
                        <?php
                        echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                        ?>
                    </td>

                    <td class="product-quantity">
                        <?php
                        if ( $_product->is_sold_individually() ) {
                            $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                        } else {
                            $product_quantity = woocommerce_quantity_input( array(
                                'input_name'  => "cart[{$cart_item_key}][qty]",
                                'input_value' => $cart_item['quantity'],
                                'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
                                'min_value'   => '0'
                            ), $_product, false );
                        }

                        echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
                        ?>
                    </td>

                    <td class="product-subtotal">
                        <?php
                        echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
                        ?>
                    </td>

                    <td class="product-remove">
                        <?php
                        echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove" title="%s">&times;</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'woocommerce' ) ), $cart_item_key );
                        ?>
                    </td>
                </tr>
            <?php
            }
        }

        do_action( 'woocommerce_cart_contents' );
        ?>

        <!-- CART SUBTOTAL -->
        <tr class="cart-subtotal" style="text-align:right">
            <th colspan="3" class="cart-label"></th>
            <th class="cart-label"><?php _e( 'Subtotal', 'woocommerce' ); ?></th>
            <td><p class="cart-label" style="float:right"><?php wc_cart_totals_subtotal_html(); ?></p></td>
        </tr>
        <!-- END CART SUBTOTAL -->

        <!-- RETURN TO SHOP PAGE -->

        <!-- END RETURN TO SHOP PAGE -->

        <?php do_action( 'woocommerce_after_cart_contents' ); ?>
        </tbody>
    </table>
</div>
<div class="cart-collaterals">

    <?php do_action( 'woocommerce_cart_collaterals' ); ?>

</div>
    <!-- CHECKOUT URL BUTTON -->
    <div class="checkout-btn">
        <div class="pull-left m-b-sm">
            <a href="/shop/">< TUTUP DAN BELANJA PRODUK LAINNYA</a>
        </div>

        <div class="pull-right wc-proceed-to-checkout">
            <div class="update-cart-Button m-b-sm">
                <input type="submit" class="checkout-button button aLT" name="update_cart" value="<?php _e( 'UPDATE CART', 'woocommerce' ); ?>" />
                <i class="fa fa-shopping-cart"></i>
            </div>    
            <?php do_action( 'woocommerce_cart_actions' ); ?>
            <?php wp_nonce_field( 'woocommerce-cart' ); ?>

            <div class="proceed-cart-Button m-b-sm">
                <?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
                <i class="fa fa-money"></i>
                <div class="update-cart-Button"></div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

            <!-- END CHECKOUT URL BUTTON -->
            <?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<?php do_action( 'woocommerce_after_cart' ); ?>
<?php
wp_enqueue_script('je-cart', get_template_directory_uri() . '/js/je.cart.js', array('jquery'), null, true);
optimizeCartPageScripts();

?>

</div>
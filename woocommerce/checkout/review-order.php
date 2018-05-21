<?php
/**
 * Review order table
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     2.5.0
 */

if (!defined('ABSPATH')) {
    exit;
}

global $woocommerce;
?>
<div class="shop_table woocommerce-checkout-review-order-table">
<div id="checkoutConfirmationSection">
<div class="row">
    <div class="col-md-8">
    <div class="table-responsive">
        <table class="shop_table cart table" cellspacing="0" style="margin-top:25px;">
            <thead class="table-shoppping" style="background-color:#f6f6f6;">
            <tr class="table-shoppping">
                <th class="product-name"><?php _e('Product', 'woocommerce'); ?></th>
                <th class="product-thumbnail">&nbsp;</th>
                <th class="product-price"><?php _e('Price', 'woocommerce'); ?></th>
                <th class="product-quantity"><?php _e('Quantity', 'woocommerce'); ?></th>
                <th class="product-subtotal"><?php _e('Total', 'woocommerce'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php do_action('woocommerce_before_cart_contents'); ?>

            <?php
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                    ?>
                    <tr class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

                        <td class="product-thumbnail">
                            <?php
                            $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                            if (!$_product->is_visible()) {
                                echo $thumbnail;
                            } else {
                                printf('<a href="%s">%s</a>', esc_url($_product->get_permalink($cart_item)), $thumbnail);
                            }
                            ?>
                        </td>

                        <td class="product-name">
                            <?php
                            if (!$_product->is_visible()) {
                                echo apply_filters('woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key) . '&nbsp;';
                            } else {
                                echo apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s </a>', esc_url($_product->get_permalink($cart_item)), $_product->get_title()), $cart_item, $cart_item_key);
                            }

                            // Meta data
                            echo WC()->cart->get_item_data($cart_item);

                            // Backorder notification
                            if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                echo '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>';
                            }
                            ?>
                        </td>

                        <td class="product-price">
                            <?php
                            echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                            ?>
                        </td>

                        <td class="product-quantity">
                            <?php
                            if ($_product->is_sold_individually()) {
                                $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                            } else {
                                $product_quantity = woocommerce_quantity_input(array(
                                    'input_name' => "cart[{$cart_item_key}][qty]",
                                    'input_value' => $cart_item['quantity'],
                                    'max_value' => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
                                    'min_value' => '0'
                                ), $_product, false);
                            }

                            echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key);
                            ?>
                        </td>

                        <td class="product-subtotal">
                            <?php
                            echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                            ?>
                        </td>
                    </tr>
                <?php
                }
            }

            do_action('woocommerce_cart_contents');
            ?>

            <?php do_action('woocommerce_after_cart_contents'); ?>
            </tbody>
        </table>
        <p class="p-confirmation-warning">Pastikan bahwa semua data yang tampil sudah benar.</p>

        <!-- <div id="checkout-order-btn"> -->
            <!-- <input type="button" class="checkout-button" value="PREVIOUS" name="confirmation-previous-btn" id="confirmation-previous-btn"> -->
            <a id="confirmation-previous-btn">< PREVIOUS TO PAYMENT METHOD</a>
        <!-- </div> -->
    </div>
    </div>

    <?php
    /*$first_name = getValueFromCheckoutPostData($_POST['post_data'], 'first_name=');
    $last_name = getValueFromCheckoutPostData($_POST['post_data'], 'last_name=');
    $billing_address1 = getValueFromCheckoutPostData($_POST['post_data'], 'billing_address_1=');

    $kota[] = getValueFromCheckoutPostData($_POST['post_data'], 'billing_state=');
    $kota[] = getValueFromCheckoutPostData($_POST['post_data'], 'billing_kota=');
    $kota[] = getValueFromCheckoutPostData($_POST['post_data'], 'billing_city=');
    $kota[] = getValueFromCheckoutPostData($_POST['post_data'], 'billing_postcode=');
    $kotaString = '';
    foreach($kota as $kotaDetail){
        if (empty($kotaString)) $kotaString = $kotaDetail;
        else $kotaString .= ', '.$kotaDetail;
    }
    if (!empty($billing_state)) $kota = '';*/
    ?>


    <div class="col-md-4">
        <div id="short-detail">
            <div id="receiver-detail">
                <label for="send-to" class="label-short-detail">
                    KIRIM KE
                </label> | <a style="font-size:12px" data-toggle="modal" data-target="#editalamatkirim" onClick="editalamat()">Edit</a> <!-- Trigger the modal with a button -->

                <p class="p-short-detail">Nama Dikirim: <span id="checkoutConfirmationName"></span></p>

                <p class="p-short-detail">Alamat: <span id="checkoutConfirmationAddress"></span></p>

                <p class="p-short-detail">Kota: <span id="checkoutConfirmationCity"></span></p>
            </div>
            <div id="shipping-detail">


                <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>

                    <?php do_action('woocommerce_review_order_before_shipping'); ?>

                    <?php wc_cart_totals_shipping_html(); ?>

                    <?php do_action('woocommerce_review_order_after_shipping'); ?>

                <?php endif; ?>
            </div>
            <?php
              //custom by limamultimedia
              do_action('limamultimedia_kado');
            ?>


            <div id="total-detail">
              

                <div>
                    <label for="subtotal-detail" class="p-short-detail">SUBTOTAL</label>
                    <?php wc_cart_totals_subtotal_html(); ?>
                </div>
				
				<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
					<div>
					  <label for="subtotal-detail" class="p-short-detail cart-discount coupon-<?php echo esc_attr( $code ); ?>">
						<?php //wc_cart_totals_coupon_label( $coupon ); ?>
						<?php _e( 'CART DISCOUNT', 'woocommerce' ); ?>
					  </label>
					  <?php wc_cart_totals_coupon_html( $coupon ); ?>		
					</div>	
				<?php endforeach; ?>
				
				
				<?php
                //custom by limamultimedia
                foreach ( WC()->cart->get_fees() as $fee ) :
					
					if($fee->id == 'biaya-admin') { continue; }
				?>
				  <div>
					<label class="p-short-detail"><?php echo esc_html( $fee->name ); ?></label>
					<?php 
					if ( $woocommerce->cart->tax_display_cart == 'excl' )
							echo wc_price ( $fee->amount );
						else
							echo wc_price ( $fee->amount + $fee->tax );
					?>
				  </div>
              <?php endforeach;?>
				
				
                <div>
                    <label for="subtotal-detail" class="p-short-detail">BIAYA PENGIRIMAN</label>
                    <?php echo wc_price (get_our_shipping_fee());//getShippingFeeJe(); ?>
                </div>
				
				
				<?php
                //custom by limamultimedia
                foreach ( WC()->cart->get_fees() as $fee ) :
					
					if($fee->id !== 'biaya-admin') { continue; }
				?>
				  <div>
					<label class="p-short-detail"><?php echo esc_html( $fee->name ); ?></label>
					<?php 
					if ( $woocommerce->cart->tax_display_cart == 'excl' )
							echo wc_price ( $fee->amount );
						else
							echo wc_price ( $fee->amount + $fee->tax );
					?>
				  </div>
              <?php endforeach;?>
				
                <div>
                    <label for="subtotal-detail" class="label-short-detail">TOTAL</label>
                    <?php wc_cart_totals_order_total_html(); //echo $woocommerce->cart->get_total(); ?>
                </div>
            </div>
            <?php
            if (!is_user_logged_in()) { ?>

                <div id="account-create">
                    <label for="create-account" class="label-create-account">
                        BIKIN AKUN (opsional)
                    </label>

                    <p class="p-create-account"></p>
                    <input name="registerAccountName" id="registerAccountName" type="text" placeholder="Email" value="<?php echo $current_user->user_email; ?>" class="input-text">
                    <input name="registerPassword" id="registerPassword" type="password" placeholder="password" class="input-text"><br/>
                    <input type="password" placeholder="confirm password" class="input-text">
                    <div class="checkbox">
                      <label><input type="checkbox"  name="bikin-akun" value=""> Bikin Akun?</label>
                    </div>
                </div>

            <?php } else {

            }
            ?>


        </div>
        <div class="form-row place-order" id="iAgreeSection">

            <noscript><?php _e('Since your browser does not support JavaScript, or it is disabled, please ensure you click the <em>Update Totals</em> button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce'); ?>
                <br/><input type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php _e('Update totals', 'woocommerce'); ?>"/>
            </noscript>

            <?php wp_nonce_field('woocommerce-process_checkout'); ?>

            <?php do_action('woocommerce_review_order_before_submit'); ?>


            <?php if (wc_get_page_id('terms') > 0 && apply_filters('woocommerce_checkout_show_terms', true)) : ?>
                <p class="form-row terms">
                    <label for="terms" class="checkbox"><?php printf(__('I&rsquo;ve read and accept the <a href="%s" target="_blank">terms &amp; conditions</a>', 'woocommerce'), esc_url(wc_get_page_permalink('terms'))); ?></label>
                    <input type="checkbox" checked class="input-checkbox" name="terms" <?php checked(apply_filters('woocommerce_terms_is_checked_default', isset($_POST['terms'])), true); ?> id="terms"/>
                </p>
            <?php endif; ?>

            <div class="btnStepCheckout" style="margin-top:15px;">
                <?php echo apply_filters('woocommerce_order_button_html', '<input type="submit" class="checkout-button alt" name="woocommerce_checkout_place_order" id="place_order" value="CONFIRM" data-value="CONFIRM" />'); ?>
                <li class="fa fa-lock"></li>
            </div>

            <?php do_action('woocommerce_review_order_after_submit'); ?>
        </div>
    </div>

    <?php
    if (!is_user_logged_in()) {
        ?>
        <script>
            $(document).ready(function () {
                registerGuestDuringCheckout();
				
				var email = jQuery('#registerEmail').val();
				jQuery('#registerAccountName').val(email);
				
            });
        </script><?php
    }
    ?>
    <?php optimizeCheckoutPageScripts(); ?>
</div>
</div>
</div>

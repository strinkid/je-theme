<?php
/**
 * Checkout shipping information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div class="woocommerce-shipping-fields">
	<?php if ( WC()->cart->needs_shipping_address() === true ) : ?>

		<?php
			if ( empty( $_POST ) ) {

				$ship_to_different_address = get_option( 'woocommerce_ship_to_destination' ) === 'shipping' ? 1 : 0;
				$ship_to_different_address = apply_filters( 'woocommerce_ship_to_different_address_checked', $ship_to_different_address );

			} else {

				$ship_to_different_address = $checkout->get_value( 'ship_to_different_address' );

			}
		?>

		<h3 id="ship-to-different-address">
			<!-- <label for="ship-to-different-address-checkbox" class="checkbox checkout-label"><?php _e( 'Ship to a different address?', 'woocommerce' ); ?></label> -->
			<!-- <input id="ship-to-different-address-checkbox" class="input-checkbox" <?php checked( $ship_to_different_address, 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" /> -->
		</h3>

		<div class="shipping_address">

			<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

			<?php //foreach ( $checkout->checkout_fields['shipping'] as $key => $field ) : ?>

				<?php //woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

			<?php //endforeach; ?>

			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php //if ( apply_filters( 'woocommerce_enable_order_notes_field', get_option( 'woocommerce_enable_order_comments', 'yes' ) === 'yes' ) ) : ?>

		<?php //if ( ! WC()->cart->needs_shipping() || WC()->cart->ship_to_billing_address_only() ) : ?>

			<!-- <h3><?php _e( 'Additional Information', 'woocommerce' ); ?></h3> -->

		<?php //endif; ?>

		<?php //foreach ( $checkout->checkout_fields['order'] as $key => $field ) : ?>

			<?php //woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

		<?php //endforeach; ?>

	<?php //endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>

	<!-- <div id="shipping-policy">
		<h3 class="shipping-policy-h">SHIPPING POLICY</h3>
		<p class="shipping-policy-p">We ship items out as soon as possible, but this will not always be the same day as your order. In general, please add 2-3 business days to allow processing
		time. If we anticipate a longer lead time, it will be noted in the item description. If you have any question about the lead time on a specific
		item, please contact us at http://makerbot.com/support with your questions.<br/><br/>

		You should receive an email confirming your order shortly after you've placed it. If you don't receive that email, please check your spam folder and see if
		you can locate. This is especially important because, if you haven't received the order confirmation email, you also won't receive the email with your shipment
		notification and tracking information.<br/><br/>

		If you are offered insurance, but do not accept it, we cannot be held responsible for damaged, lost, or stolen packages.
		</p>
	</div> -->

	<div id="shipping-info">
		<div id="nama" class="layout-billing-form">
			<div class="kolom-1">
				<p class="huruf-billing-form">Nama Awal</p>
			</div>
			<div class="kolom-2">
				<input type="text" name="shipping_first_name" class="tbox-billing-form" value="<?php echo $checkout->get_value('shipping_first_name') ?>">
			</div>
		</div>
	
		<div id="nama-2" class="layout-billing-form">
			<div class="kolom-1">
				<p class="huruf-billing-form">Nama Akhir</p>
			</div>
			<div class="kolom-2">
				<input type="text" class="tbox-billing-form" name="shipping_last_name" value="<?php echo $checkout->get_value('shipping_last_name') ?>">
			</div>
		</div>

		<div id="company" class="layout-billing-form">
			<div class="kolom-1">
				<p class="huruf-billing-form">Company</p>
			</div>
			<div class="kolom-2">
				<input type="text" class="tbox-billing-form" name="shipping_company" value="<?php echo $checkout->get_value('shipping_company') ?>">
			</div>
		</div>
		<div id="company" class="layout-billing-form">
			<div class="kolom-1">
				<p class="huruf-billing-form">Address</p>
			</div>
			<div class="kolom-2">
				<input type="text" class="input-text " name="shipping_address_1" id="shipping_address_1" placeholder="Street address" value="">
			</div>
		</div>
		<div id="company" class="layout-billing-form">
			<div class="kolom-1">
				<p class="huruf-billing-form">Apartment</p>
			</div>
			<div class="kolom-2">
				<input type="text" class="input-text " name="shipping_address_2" id="shipping_address_2" placeholder="Apartment, suite, unit etc. (optional)" value="">
			</div>
		</div>
		<div id="company" class="layout-billing-form">
			<div class="kolom-1">
				<p class="huruf-billing-form">Kota</p>
			</div>
			<div class="kolom-2">
				<input type="text" class="input-text " name="shipping_city" id="shipping_city" placeholder="Town / City" value="">
			</div>
		</div>
		<div id="company" class="layout-billing-form">
			<div class="kolom-1">
				<p class="huruf-billing-form">Province</p>
			</div>
			<div class="kolom-2">
				<select name="shipping_state" id="shipping_state" class="state_select " placeholder=""><option value="">Select an option…</option><option value="AC">Daerah Istimewa Aceh</option><option value="SU">Sumatera Utara</option><option value="SB">Sumatera Barat</option><option value="RI">Riau</option><option value="KR">Kepulauan Riau</option><option value="JA">Jambi</option><option value="SS">Sumatera Selatan</option><option value="BB">Bangka Belitung</option><option value="BE">Bengkulu</option><option value="LA">Lampung</option><option value="JK">DKI Jakarta</option><option value="JB">Jawa Barat</option><option value="BT">Banten</option><option value="JT">Jawa Tengah</option><option value="JI">Jawa Timur</option><option value="YO">Daerah Istimewa Yogyakarta</option><option value="BA">Bali</option><option value="NB">Nusa Tenggara Barat</option><option value="NT">Nusa Tenggara Timur</option><option value="KB">Kalimantan Barat</option><option value="KT">Kalimantan Tengah</option><option value="KI">Kalimantan Timur</option><option value="KS">Kalimantan Selatan</option><option value="KU">Kalimantan Utara</option><option value="SA">Sulawesi Utara</option><option value="ST">Sulawesi Tengah</option><option value="SG">Sulawesi Tenggara</option><option value="SR">Sulawesi Barat</option><option value="SN">Sulawesi Selatan</option><option value="GO">Gorontalo</option><option value="MA">Maluku</option><option value="MU">Maluku Utara</option><option value="PA">Papua</option><option value="PB">Papua Barat</option></select>
			</div>
		</div>
		<div id="company" class="layout-billing-form">
			<div class="kolom-1">
				<p class="huruf-billing-form">Postcode</p>
			</div>
			<div class="kolom-2">
				<input type="text" class="input-text " name="shipping_postcode" id="shipping_postcode" placeholder="Postcode / Zip" value="">
			</div>
		</div>
		<div id="company" class="layout-billing-form">
			<div class="kolom-1">
				<p class="huruf-billing-form">Order Notes</p>
			</div>
			<!--<div class="kolom-2">
				<textarea name="order_comments" class="input-text " id="order_comments" placeholder="Notes about your order, e.g. special notes for delivery." rows="2" cols="5"></textarea>
			</div>-->
		</div>
        
	</div>
</div>

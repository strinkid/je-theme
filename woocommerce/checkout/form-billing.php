<?php
/**
 * Checkout billing information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/** @global WC_Checkout $checkout */
global $current_user;
wp_get_current_user();
?>

<div class="woocommerce-billing-fields">
	<?php if ( wc_ship_to_billing_address_only () && WC()->cart->needs_shipping() ) : ?>

		<h3 class="checkout-label"><?php _e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h3>

	<?php else : ?>

		<h3 class="checkout-label"><?php _e( 'ALAMAT PENGIRIMAN', 'woocommerce' ); ?></h3>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<?php //foreach ( $checkout->checkout_fields['billing'] as $key => $field ) : ?>

		<?php //woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

	<?php //endforeach; ?>

    <?php do_action('woocommerce_after_checkout_billing_form', $checkout ); ?>


		<div id="billing-information-form">
			<!-- START CUSTOM BILLING DETAILS FORM -->

            <input id="billing_email" type="hidden" placeholder="Email" name="billing_email" value="<?php echo $current_user->user_email; ?>"><br/><br/>
            <span id="nama" class="layout-billing-form">
				<div class="kolom-1">
					<p class="huruf-billing-form">Nama Awal<span class="mandatory-field"> *</span></p>
				</div>
				<span class="kolom-2">
                    <?php displayCheckoutInputForm($checkout, 'billing_first_name'); ?>
				</span>
			</span>

			<span id="nama-2" class="layout-billing-form">
				<div class="kolom-1">
					<span class="huruf-billing-form">Nama Akhir</span>
				</div>
				<span class="kolom-2">
                    <?php displayCheckoutInputForm($checkout, 'billing_last_name'); ?>
				</span>
			</span>

			<span id="gender" class="layout-billing-form">
				<div class="kolom-1">
					<span class="huruf-billing-form">Jenis Kelamin</span>
				</div>
				<span class="kolom-2">
					<input name="billing_gender" id="man-radio" type="radio" value="male" style="float:left; margin-left:5px;" <?php  echo(get_user_meta( get_current_user_id(), 'billing_gender', true )=='male' ? 'checked':''); ?> >
					<span class="radio-billingText" style="float:left;padding-left:5px;"><label style="font-weight:500" for="man-radio">Laki - Laki</label></span>
					<!-- <span class="radio-billingText" style="float:left;padding-left:5px"> Laki - Laki</span> --> &nbsp;&nbsp;&nbsp;&nbsp;
					
					<input name="billing_gender" id="woman-radio" type="radio" value="female" style="float:left; margin-left:20px" <?php  echo(get_user_meta( get_current_user_id(), 'billing_gender',true )=='female' ? 'checked':''); ?> >
					<span class="radio-billingText" style="float:left;padding-left:5px"><label for="woman-radio" style="font-weight:500">Perempuan</label></span>
				</span>
			</span>

			<?php
				if(function_exists('pickup_store_html')){ //plugins/lima-login
					pickup_store_html();
				}
			?>	
			
			<span id="alamat" class="layout-billing-form">
				<div class="kolom-1">
					<span class="huruf-billing-form">Alamat<span class="mandatory-field"> *</span></span>
				</div>
				<span class="kolom-2">
                    <?php displayCheckoutInputForm($checkout, 'billing_address_1'); ?>
				</span>
			</span>

			<span id="provinsi" class="layout-billing-form">
				<div class="kolom-1">
					<span class="huruf-billing-form">Propinsi<span class="mandatory-field"> *</span></span>
				</div>
				<span class="kolom-2">
                    <?php displayCheckoutInputForm($checkout, 'billing_state'); ?>
				</span>
			</span>

            <?php if (isset($checkout->checkout_fields['billing']['billing_kota'])){ ?>
            <span id="kabupaten" class="layout-billing-form">
                <div class="kolom-1">
                    <span class="huruf-billing-form">Kota/Kabupaten<span class="mandatory-field"> *</span></span>
                </div>
                <span class="kolom-2">
                    <?php displayCheckoutInputForm($checkout, 'billing_kota'); ?>
                </span>
            </span>
            <?php } ?>

            <span id="kota" class="layout-billing-form">
				<div class="kolom-1">
					<span class="huruf-billing-form">Kecamatan<span class="mandatory-field"> *</span></span>
				</div>
				<span class="kolom-2">
                    <?php displayCheckoutInputForm($checkout, 'billing_city'); ?>
				</span>
			</span>

            <span id="kodepos" class="layout-billing-form">
				<div class="kolom-1">
                    <span class="huruf-billing-form">Kode Pos</span>
                </div>
				<span class="kolom-2">
                    <input class="input-text " name="billing_postcode" value="<?php echo $checkout->get_value('billing_postcode');?>" id="billing_postcode" placeholder="Postcode / Zip" type="text">
				</span>
			</span>


			<span id="telepon" class="layout-billing-form">
                <div class="billing-note" style="margin-left:30%;">
                    Mohon diisi salah satu atau dua-duanya*
                </div>
                <div class="kolom-1">
					<span class="huruf-billing-form">Telepon <span class="mandatory-field"> *</span></span>
				</div>
				<span class="kolom-2">
                    <?php displayCheckoutInputForm($checkout, 'billing_phone'); ?>
				</span>
				<span class="billing-note" style="margin-left:30%;">
					Contoh: 021 - 41113444
				</span>
			</span>

			<span id="ponsel" class="layout-billing-form">
				<div class="kolom-1">
					<span class="huruf-billing-form">Ponsel</span>
				</div>
				<span class="kolom-2">
                    <?php displayCheckoutInputForm($checkout, 'billing_mobile'); ?>
				</span>
				<div class="billing-note" style="margin-left:30%">
					Contoh: 0818 - 41113444
				</div>
			</span>
    		<!-- asefur mukti -->
	    	<span id="company" class="layout-billing-form">
				<div class="kolom-1">
					<p class="huruf-billing-form">Order Notes</p>
				</div>
				<div class="kolom-2">
					<textarea name="order_comments" class="input-text " id="order_comments" placeholder="Notes about your order, e.g. special notes for delivery." rows="2" cols="5"></textarea>
				</div>
			</span> <!-- asefur -->
			<div class="billing-note">
				* harus diisi
			</div>
            <input type="hidden" name="billing_country" class="country_to_state" value="ID">

		    <!-- END Custom Form Billing Details -->

			<div class="billing-error" style="display:none">
				Kolom * harus diisi
			</div>
			<div class="billing-error-phoneField" style="display:none; color:red">
				Masukkan angka pada kolom Phone
			</div>
		</div>
	</div>
    <?php do_action('lima_after_billing_field',$checkout); ?>
    <hr>
	<br/>
	<br/>
	<br/>
	<div class="btnStepCheckout" id="delivery-next-btn">
		<input type="button" value="NEXT" class="checkout-button" name="delivery-next-btn" style="margin-left:10px">
		<li class="fa fa-arrow-right"></li>
	</div>
    <br/>
	<br/>
    <!-- <div class="btnStepCheckoutPrevious" id="guest-prev-btn" style="display:none">
		<li class="fa fa-arrow-left"></li>
		<input type="button" value="PREVIOUS" class="checkout-button" name="guest-prev-btn">
	</div> -->
			<a id="guest-prev-btn"> < PREVIOUS</a>	
	

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<?php

        if(is_user_logged_in()){
            ?><script src="<?php echo get_template_directory_uri();?>/js/je.checkout.member.js"></script><?php
        } else{
            ?><script src="<?php echo get_template_directory_uri();?>/js/je.checkout.guest.js"></script><?php
        }
    ?>


<?php
function displayCheckoutInputForm($checkout, $key){
    if ( (strpos($key, 'phone') != FALSE) || strpos($key, 'mobile') != FALSE )
        displayCheckoutInputFormPhone($checkout, $key);
    else
        displayCheckoutInputFormOther($checkout, $key);
}
function displayCheckoutInputFormPhone($checkout, $key){

   $userID = get_current_user_id();
    $userBillingMobile = get_user_meta( $userID, 'billing_mobile', true );
    $fullNumber = $checkout->get_value( $key );
    
    if(empty($fullNumber)){
        $fullNumber = $userBillingMobile;
    }

    $phoneNumber1 = '';
    $phoneNumber2 = '';
	if(isset($fullNumber)){	
    		$dashPosition = strpos($fullNumber, '-');

    		if ($dashPosition == FALSE){
        		$phoneNumber2 = $fullNumber;
		}	
    		else{
        		$phoneNumber1 = explode('-',$fullNumber)[0];
        		$phoneNumber2 = explode('-',$fullNumber)[1];
		}
	}
    $field= isset($checkout->checkout_fields['billing'][$key]) ? $checkout->checkout_fields['billing'][$key] : array();
    $field['label']='';

    ?>
    <div class="kolom-2-1">
        <input id="<?php echo $key.'1' ?>" name="<?php echo $key.'1' ?>" type="text" class="input-text" value="<?php echo $phoneNumber1 ?>">
    </div>
    <div class="kolom-sempil">
        <p class="tanda">-</p>
    </div>
    <div class="kolom-2-2">
        <input id="<?php echo $key.'2'  ?>" name="<?php echo $key.'2'  ?>" type="text" class="input-text" value="<?php echo $phoneNumber2 ?>">
    </div>
    <input id="<?php echo $key ?>" type="hidden" name="<?php echo $key ?>" value="<?php echo $fullNumber  ?>">
    <?php


}
function displayCheckoutInputFormOther($checkout, $key){
    $field = $checkout->checkout_fields['billing'][$key];
    $field['label']='';

    if ( strpos($key, 'gender') != FALSE){
        $field['type']='radio';
    }
    else if ( strpos($key, 'address_1') != FALSE){
        $field['type']='textarea';
    }

    woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
}

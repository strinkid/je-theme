<?php
/**
 * Checkout Payment Section
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


?>

<div id="checkoutPaymentSection" class="woocommerce-checkout-payment" style="background-color:#FFF !important">

	<?php if ( WC()->cart->needs_payment() ) : ?>
        <?php
		
        if ( ! empty( $available_gateways ) ) {
            ?>

    <div class="row m-b-lg">
            <div class="col-sm-3" id="list-payment-img"> 
                <div id="payment-method-form">
                    <?php 
				 
					
					$arr = get_cicilan_array(); //adjust by Limamultimedia
					$array_payment = array(); //adjust by Limamultimedia
															
					foreach ( $available_gateways as $gateway ) {
						
						
						$array_payment =  array_merge($array_payment,array($gateway->id)); //adjust by Limamultimedia						
						if (!in_array($gateway->id , $arr)) { //adjust by Limamultimedia
						
							$imagePath = get_template_directory() .'/img/'.$gateway->id.'.png';
							$imageURL = get_site_url() .'/wp-content/themes/je-theme/img/'.$gateway->id.'.png';
							?>
							<a>
							<div id="payment_method_icon_<?php echo $gateway->id; ?>" class="paymentSelectionIcon" keyForClick="<?php echo $gateway->id; ?>">
								<?php 
								if (file_exists($imagePath)) { ?>
									<img src="<?php echo $imageURL ?>">
								<?php 
								} else {
									echo $gateway->get_title();	 
								}
								?>
							</div>
							</a>
                    <?php 
						}
					} 
					?>
                </div>

            </div>

            <div id="payment_method_desc_section" class="col-sm-9">
                <?php
			
                $loop = 0;
                $paymentMethodCode = '';
                foreach ( $available_gateways as $gateway ) {
                    $hidden = 'style="display:none"';
                    if ($loop == 0) {
                        $hidden = '';
                        $paymentMethodCode = $gateway->id;
						
                    }
					
					$current_user = wp_get_current_user();
					
					if($gateway->id == 'lima_homecredit' and $current_user->user_login !== 'wahyu123' ){	continue; }

$billing_payment_method_bank_name = $billing_payment_method_account_name = '';
			if(isset($_POST['post_data'])){
                    $billing_payment_method_bank_name = getValueFromCheckoutPostData($_POST['post_data'], 'billing_payment_method_bank_name=');
                    $billing_payment_method_account_name = getValueFromCheckoutPostData($_POST['post_data'], 'billing_payment_method_account_name=');
}
                    $loop++; ?>
                    <div id="payment_method_desc_<?php echo $gateway->id; ?>" class="paymentMethodDesc" <?php echo $hidden; ?>>
                            <?php if ( $gateway->id == "bacs" ) { ?>
                                <div class="additional-payment-label">
                                    <!-- <label for="label-payment">Pemesanan dengan Bank Transfer akan otomatis dibatalkan oleh sistem kami jika pembayaran tidak diterima
                                        dalam waktu 24 jam.:
                                    </label> -->
                                    <p class="p-short-detail">Bank yang anda gunakan:</p>
                                    <input type="text" placeholder="Nama Bank" class="form-control" id="billing_payment_method_bank_name" name="billing_payment_method_bank_name" value="<?php echo $billing_payment_method_bank_name; ?>">
                                </div>
                                <div class="additional-payment-label">
                                    <p class="p-short-detail">Nama Pengirim</p>
                                    <input type="text" placeholder="Nama yang tertera di rekening" id="billing_payment_method_account_name" class="form-control" name="billing_payment_method_account_name" value="<?php echo $billing_payment_method_account_name; ?>">
                                </div>
                                <div id="text-descriptionMethodPayment">
                                <?php //echo $gateway->get_description(); ?>
                                Order anda akan dikirim setelah kami mengkonfirmasi pembayaran
                                </div>
							<!-- Adjust by Limamultimedia -->	
								<div class="billing_payment-error" style="display:none">
                                    Nama Bank dan akun wajib diisi.
                                </div>
							
                            <?php }else if($gateway->id == 'wccpg4'){
																
								 echo $gateway->get_description();
								
								?>
								
								 <h3><?php __('Pilih Jenis Cicilan :','woocommerce'); ?></h3>
								
								<div class="opsi-cicilan-group">
								
								<?php get_cicilan_html(); ?>
								
								</div>	
								
								<?php
								
							}else if($gateway->id == 'cod'){
								
								?>
								<div class="cod-description"><?php  echo $gateway->get_description(); ?></div>
								<h3 class="billing_payment-error not-cod" style="display:none;">NOT Available</h3>	
								
								<?php
								
							} /* End Adjust */
							else if ( $gateway->has_fields() || $gateway->get_description() ){
                                //echo $gateway->get_description();
								$gateway->payment_fields(); //limamultimedia update for homecredit or other gateway with stadart WC
                            } ?>
                                

                    </div>
                <?php } ?>
				
				<?php
$payment_method = '';
if(isset($_POST['post_data'])){
				$payment_method = getValueFromCheckoutPostData($_POST['post_data'], 'payment_method=');
                    }
				?>
				
                <input id="payment_method" type="hidden" name="payment_method" value="<?php if($payment_method) { echo $payment_method;}else { echo $paymentMethodCode; } ?>"/>
				
            </div>
            <?php


        } else {
            if ( ! WC()->customer->get_country() ) {
                $no_gateways_message = __( 'Please fill in your details above to see available payment methods.', 'woocommerce' );
            } else {
                $no_gateways_message = __( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' );
            }

            echo '<p>' . apply_filters( 'woocommerce_no_available_payment_methods_message', $no_gateways_message ) . '</p>';
        }
        ?>

	<?php endif; ?>

    </div>
	

    <div class="btnStepCheckout">
        <input type="button" class="checkout-button" value="NEXT" name="payment-next-btn" id="payment-next-btn" style="margin-left:10px;float:left">
        <li class="fa fa-arrow-right" style="position:relative;top:8px;"></li>
    </div>

    <!-- <div class="btnStepCheckoutPrevious">
        <li class="fa fa-arrow-left"style=""></li>
        <input type="button" class="checkout-button" value="PREVIOUS" name="payment-previous-btn" id="payment-previous-btn">
    </div> -->

    <a id="payment-previous-btn"> < PREVIOUS TO BILLING INFORMARTION</a>

	<div class="clear"></div>
</div>

    <script src="<?php echo get_template_directory_uri();?>/js/je.checkout.js"></script>
<?php

function get_cicilan_html(){
	
	$total_cart = WC()->cart->cart_contents_total;
	
	$arr = get_cicilan_array('wccpg4');
	$loop = 1;
	foreach($arr as $ar) {
		
		/** Exclude cicilan ketika total cart < 1000.000 & 2000.000 **/
		
		if($total_cart < 500000){	
			
			if($ar == 'wccpg5' or $ar == 'wccpg6' or $ar == 'wccpg7'){
				continue;
			}
			
		}/*elseif($tota_cart < 2000000){
			
			if($ar == 'wccpg6' or $ar == 'wccpg7'){
				continue;
			}
			
		}*/
		
		
		if($loop == '1'){
			$checked = 'checked="checked"';
		}else {
			$checked = '';
		}
		
		$option = get_custom_admin_fee($ar);
			
		?>
		
		<?php if($option['enabled'] == 'yes') { ?>
		<div class="additional-payment-label form-inline radio">
			<label>
            	<input type="radio" class=" opsi-cicilan" name="cicilan" <?php echo $checked; ?> value="<?php echo $ar; ?>" > 
				<?php echo $option['title']; ?>
			</label>
		</div>
		<?php } ?>

		<?php
		$loop++;
	}
	
}

function get_cicilan_array($arr=''){
	
	if(!empty($arr)){
		$array = array($arr,'wccpg5','wccpg6','wccpg7');
	}else{
		$array = array('wccpg5','wccpg6','wccpg7');
	}
	return $array;
}
?>

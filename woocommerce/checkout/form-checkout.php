<?php
	global $current_user;
	global $wpdb;
	wp_get_current_user();			
?>
<div class="container">

	<div id="multi-step-image">	
				
		<?php
        $memberHideStyle = '';
        $guestHideStyle = '';

        if(is_user_logged_in()){
            $memberHideStyle = 'style="display:none"';
        } else {
            $guestHideStyle = 'style="display:none"';
            ?><img id="topIconSignOff" class="topIcon" src="<?php echo get_template_directory_uri() ?>/img/sign-in-icon.png" style="display:none">
            <img id="topIconSignOn" class="topIcon" src="<?php echo get_template_directory_uri() ?>/img/sign-in-active-icon.png" <?php echo $memberHideStyle;?>><?php
        }?>

        <img id="topIconDeliveryOff" class="topIcon" src="<?php echo get_template_directory_uri() ?>/img/pengiriman_bulboff.png" <?php echo $memberHideStyle;?>>
        <img id="topIconDeliveryOn" class="topIcon" src="<?php echo get_template_directory_uri() ?>/img/pengiriman_bulbon.png" <?php echo $guestHideStyle;?>>
        <img id="topIconPaymentOff" class="topIcon" src="<?php echo get_template_directory_uri() ?>/img/pembayaran-icon.png">
        <img id="topIconPaymentOn" class="topIcon" src="<?php echo get_template_directory_uri() ?>/img/pembayaran-active-icon.png" style="display:none">
        <img id="topIconConfirmOff" class="topIcon" src="<?php echo get_template_directory_uri() ?>/img/konfirmasi-icon.png">
        <img id="topIconConfirmOn" class="topIcon" src="<?php echo get_template_directory_uri() ?>/img/konfirmasi-active-icon.png" style="display:none">

		
	</div>
</div>
<!-- End C.O Step Image -->
<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', wc_get_checkout_url() ); ?>

<!-- CheckoutLogin -->
<div class="container">
	<?php if(is_user_logged_in()){ ?>
    
		<div id="guest-login" style="display:none">
	<?php }else{ ?>
		<div id="guest-login" class="col-sm-6">
	<?php } ?>
		<h3 class="checkout-label">SIGN IN</h3>
		<h3 class="checkout-p">Sudah pernah berbelanja di jualelektronik.com</h3>
			<form method="post" class="login">
				<?php do_action( 'woocommerce_login_form_start' ); ?>

				<p class="form-row form-row-wide" style="margin-bottom:10px !important;">
					<input type="text" placeholder="Email" class="input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
				</p>
				<p class="form-row form-row-wide">
					<input class="input-text" placeholder="Password" type="password" name="password" id="password" />
				</p>

				<?php do_action( 'woocommerce_login_form' ); ?>

				<p class="form-row">
					<?php wp_nonce_field( 'woocommerce-login' ); ?>
					<input type="submit" style="float:right; margin-top:15px" class="checkout-button" name="login" value="<?php _e( 'SIGN IN', 'woocommerce' ); ?>" />
					<!-- <label for="rememberme" class="inline">
						<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'woocommerce' ); ?>
					</label> -->
				</p>
				<p class="lost_password">
					<a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Lupa Password?', 'woocommerce' ); ?></a>
				</p>

				<?php do_action( 'woocommerce_login_form_end' ); ?>
			</form>
		</div>

	<style type="text/css">
		form.login{
			border: 0px!important;
			padding: 0px !important;
			margin: 0px !important;

		}
		p.form-row.form-row-first{
			width: 100%;		
		}
		p.form-row.form-row-last{
			width: 100%;		
		}
	</style>

<!-- END Checkout Login -->
<form id="jecheckout"  name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">
	<!-- <div class="container"> -->
		<br/>
        <?php if(is_user_logged_in()){ $hideGuest = ' style="display:none;"';}else{$hideblmlogin = ' style="display:none;"';}?>
		<div id="guest-checkout"<?php echo $hideGuest ?> class="col-sm-6">
				<h3 class="checkout-label">GUEST</h3>
				<p class="checkout-p">Pelanggan Baru</p>
				<input id="registerEmail" class="tbox-billing-form input-text" type="text" placeholder="Email" name="email" value="<?php echo $current_user->user_email; ?>"><br/><br/>
				<input class="checkout-button" type="button" id="guest-nxt-btn" value="NEXT" style="float:right;">
                <span id="loading-input-new-email" style="display:none;"><i class='fa fa-spinner fa-spin' style="color:#000000 !important;"></i> Loading...</span>
				<span class="error-message-1" style="display:none;color:red">Something Wrong in this field</span>
				<span class="format-error-msg" style="display:none;color:red">This is wrong format email. </span>
				<span class="error-message-2" style="display:none;color:red">Choose another email. Email Already Registered</span>
				<span class="success-msg" style="display:none; color:green">This email will be registered on jualelektronik.com. Please press Next</span>
				<span class="empty-msg" style="display:none; color:red">Email must be filled</span>
                <?php wp_nonce_field( 'woocommerce-register','registerWpNonce' ); ?>
		</div>

		<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

			<div class="row" id="customer_details" style="display:none;">
				<div class="col-sm-6">
					<?php do_action( 'woocommerce_checkout_billing' ); ?>
				</div>
				<div class="col-sm-6">
					<?php do_action( 'woocommerce_checkout_shipping' ); ?>
				</div>
			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

		<div id="order_review" class="woocommerce-checkout-review-order" style="display:none;">
			<?php do_action( 'woocommerce_checkout_order_review' ); ?>
		</div>

		<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
        <div class="row" >
	            <div class="col-sm-12">
					<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
                </div>
			</div>
	<!-- </div> -->
    <!--<div id="fb-login">

        <a href="<?php get_home_url(); ?>/wp-login.php?loginFacebook=1&redirect=<?php get_home_url(); ?>" onclick="window.location = '<?php get_home_url(); ?>/wp-login.php?loginFacebook=1&redirect='+window.location.href; return false;">
            <img id="fb-img" class="center-block" src="<?php echo get_template_directory_uri() ?>/img/fb-login-btn.png">
        </a>
    </div>-->
</form>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
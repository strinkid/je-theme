<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices(); ?>
<?php /**
 * My Account navigation.
 * @since 2.6.0
 */
//do_action( 'woocommerce_account_navigation' );
 ?>

<div class="woocommerce-MyAccount-content">
	<?php
		/**
		 * My Account content.
		 * @since 2.6.0
		 */
		do_action( 'woocommerce_account_content' );
	?>
</div>

<?php
// Get Info Current User
global $current_user;
$current_user = wp_get_current_user();

$name = $current_user->display_name;
// Get Info Customer
global $woocommerce;
//$wc_get_something = $woocommerce->customer->getData();
//$customer_billing_address = $woocommerce->customer->get_billing_address();

$billing_address_1 = get_user_meta( $current_user->ID, 'billing_address_1', true );
$billing_postcode = get_user_meta( $current_user->ID, 'billing_postcode', true );
$billing_city = get_user_meta( $current_user->ID, 'billing_city', true );
$billing_phone = get_user_meta( $current_user->ID, 'billing_phone', true );

$shipping_address = get_user_meta( $current_user->ID, 'shipping_address_1', true );
$shipping_city = get_user_meta( $current_user->ID, 'shipping_city', true );
$shipping_postcode = get_user_meta( $current_user->ID, 'shipping_postcode', true );

$permalink = get_permalink( get_option('woocommerce_myaccount_page_id') );

// print_r($shipping_address);
?>
<style>
.my-account-box{
	margin-bottom:30px;
	font-size:12px;
}
.box-border{
	border:1px solid #d3d3d3;
	padding:10px;
	width:100%;
}
.box-border h1{
	border-bottom:1px solid #d3d3d3;
	padding-bottom:10px;
	
}
</style>
	<h3 style="font-size:22px;">MY ACCOUNT</h3><hr/>

	<div class="row my-account-box">

		<div class="col-xs-12 col-md-3">
		<div id="account-details" class="box-border">
			<h1 class="account-detail-label"><a class="toggle-orderHistory" href="#">ACCOUNT DETAILS</a> <i class="fa fa-arrow-circle-right fa-lg" style="color:#FF8F00 !important; float:right;"></i></h1>
			<p><?php printf( __( '<a href="%s">Edit Personal Details</a>', 'woocommerce' ), wc_customer_edit_account_url()); ?></p>
			<p><a href="<?php echo wc_get_endpoint_url( 'edit-address', $name,$permalink ); ?>billing">Edit Billing Address</a></p>
			<p><a href="<?php echo wc_get_endpoint_url( 'edit-address', $name,$permalink ); ?>shipping">Edit Shipping Address</a></p>

			<h1 class="order-history-toogle"><a class="" href="#">ORDER HISTORY</a></h1>
		</div>
		</div>

		<div class="col-xs-12 col-md-9">
		<div id="toogleWhenOrderBtnClicked">
			<div class="row">
				<div class="col-sm-4">
					<div id="personal-details" class="box-border">
						<div class="top-accountDetailLayout">
							<h1 class="acc-details-label">Personal Details&nbsp;<a class="link-edit-account" <?php printf( __( '<a href="%s">Edit</a>', 'woocommerce' ), wc_customer_edit_account_url()); ?> </a></h1>
						</div>
						<p class="details-attr">First Name :  <?php echo $current_user->user_firstname; ?></p>
						<p class="details-attr">Last Name : <?php echo $current_user->user_lastname; ?> </p>
						<p class="details-attr">Email : <?php echo $current_user->user_email; ?> </p>
						<p class="details-attr">Phone : <?php echo $billing_phone ?> </p>
					</div>
				</div>
				<div class="col-sm-4">
					<div id="billing-address-details" class="box-border">
						<div class="top-accountDetailLayout">
							<h1 class="acc-details-label">Billing Address&nbsp;<a class="link-edit-account" href="<?php echo wc_get_endpoint_url( 'edit-address', $name,$permalink ); ?>billing">Edit</a></h1>
						</div>
						<p class="details-attr"><?php echo $billing_address_1; ?></p>
						<p class="details-attr"><?php echo $billing_city ?></p>
						<p class="details-attr"><?php echo $billing_postcode ?></p>
					</div>
				</div>

				<div class="col-sm-4">
					<div id="shipping-address-details" class="box-border">
						<div class="top-accountDetailLayout">
							<h1 class="acc-details-label">Shipping Address&nbsp;<a class="link-edit-account" href="<?php echo wc_get_endpoint_url( 'edit-address', $name,$permalink ); ?>shipping">Edit</a></h1>
						</div>
						<p class="details-attr"><?php echo $shipping_address ?></p>
						<p class="details-attr"><?php echo $shipping_city ?></p>
						<p class="details-attr"><?php echo $shipping_postcode ?></p>
					</div>
				</div>

			</div>

		</div>

			<?php do_action( 'woocommerce_before_my_account' ); ?>
				<?php wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>
			<?php do_action( 'woocommerce_after_my_account' ); ?>
	</div>

<p class="myaccount_user" style="display:none">
	<?php
	printf(
		__( 'Hello <strong>%1$s</strong> (not %1$s? <a href="%2$s">Sign out</a>).', 'woocommerce' ) . ' ',
		$current_user->display_name,
		wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) )
	);

	printf( __( 'From your account dashboard you can view your recent orders, manage your shipping and billing addresses and <a href="%s">edit your password and account details</a>.', 'woocommerce' ),
		wc_customer_edit_account_url()
	);
	?>
</p>

<?php
optimizeMyAccountOnLoginPageScripts();
?>

<?php do_action( 'woocommerce_before_my_account' ); ?>

<?php wc_get_template( 'myaccount/my-downloads.php' ); ?>

<?php //wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>

<?php wc_get_template( 'myaccount/my-address.php' ); ?>

<?php do_action( 'woocommerce_after_my_account' ); ?>

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
<script type="text/javascript">
	var $ = jQuery;	
	$(".my-address-title").hide();
	$(".myaccount_address").hide();
	$(".address").hide();
	$(".shipping").hide();

	$(document).ready(function(){
		$(".account-detail-label").click(function(e){
			$("h1.order-history-toogle").html('<a class="" href="#">ORDER HISTORY</a>');
			$(this).html('<a class="toggle-orderHistory" href="#">ACCOUNT DETAILS</a>');
			$(this).append(' <i class="fa fa-arrow-circle-right fa-lg" style="color:#FF8F00 !important;float:right;"></i>');
			//$(this).addClass('alert-success');
			e.preventDefault();
			$("#personal-details").slideDown(200);
			$("#billing-address-details").slideDown(200);
			$("#shipping-address-details").slideDown(200);
			$(".shop_table.shop_table_responsive.my_account_orders").hide();
			$('.order-history-title').hide();

			$(".account-detail-label").removeClass('toggle-orderHistoryActive');
			$(".account-detail-label").removeClass('toggle-orderHistory');
			$("h1.order-history-toogle").removeClass('toggle-orderHistoryActive');
			$("h1.order-history-toogle").removeClass('toggle-orderHistory');
			$("h1.order-history-toogle > a").removeClass('toggle-orderHistoryActive');

			$(".account-detail-label > a").addClass('toggle-orderHistoryActive');
			$("h1.order-history-toogle").addClass('toggle-orderHistory');

		});
		$("h1.order-history-toogle").click(function(e){
			$(".account-detail-label").html('<a class="toggle-orderHistory" href="#">ACCOUNT DETAILS</a>');
			$(this).html('<a class="" href="#">ORDER HISTORY</a>');
			$(this).append(' <i class="fa fa-arrow-circle-right fa-lg" style="color:#FF8F00 !important;float:right;"></i>');
			e.preventDefault();
			$("#personal-details").hide();
			$("#billing-address-details").hide();
			$("#shipping-address-details").hide();
			$(".shop_table.shop_table_responsive.my_account_orders").slideDown(200);
			$('.order-history-title').slideDown(200);

			$(".account-detail-label").removeClass('toggle-orderHistoryActive');
			$(".account-detail-label").removeClass('toggle-orderHistory');
			$("h1.order-history-toogle").removeClass('toggle-orderHistoryActive');
			$("h1.order-history-toogle").removeClass('toggle-orderHistory');
			$(".account-detail-label > a").removeClass('toggle-orderHistoryActive');

			$(".account-detail-label").addClass('toggle-orderHistory');
			$("h1.order-history-toogle > a").addClass('toggle-orderHistoryActive');
		});
	});
</script>
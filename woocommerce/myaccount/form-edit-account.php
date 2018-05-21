<?php
/**
 * Edit account form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>
<style>
.woocommerce-edit-account{
	margin-top:20px;
	font-family:Arial,sans-serif;
	font-size:12px;
	
}
.woocommerce-edit-account h2{
	font-size:22px;
}
.woocommerce-edit-account [type="submit"]{
	margin-top:10px !important;

}
.box-border{
	margin-top:20px;
	padding-left:10px;
	padding-right:10px;
	padding-bottom:15px;
}
</style>
<div class="col-md-6 woocommerce-edit-account">
<form action="" method="post">
  <div class="box-border">
	<legend><?php _e( 'Your Account', 'woocommerce' ); ?></legend>
	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

	<p class="form-row form-row-first">
		<label for="account_first_name"><?php _e( 'First name', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="text" class="input-text" name="account_first_name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" />
	</p>
	<p class="form-row form-row-last">
		<label for="account_last_name"><?php _e( 'Last name', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="text" class="input-text" name="account_last_name" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>" />
	</p>
	<div class="clear"></div>

	<p class="form-row form-row-wide">
		<label for="account_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="email" class="input-text" name="account_email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>" />
	</p>
  </div>    
  <div class="box-border">
	<fieldset class="m-t-md">
		<legend><?php _e( 'Password Change', 'woocommerce' ); ?></legend>

		<p class="form-row form-row-wide">
			<label for="password_current"><?php _e( 'Current Password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
			<input type="password" class="input-text" name="password_current" id="password_current" />
		</p>
		<p class="form-row form-row-wide">
			<label for="password_1"><?php _e( 'New Password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
			<input type="password" class="input-text" name="password_1" id="password_1" />
		</p>
		<p class="form-row form-row-wide">
			<label for="password_2"><?php _e( 'Confirm New Password', 'woocommerce' ); ?></label>
			<input type="password" class="input-text" name="password_2" id="password_2" />
		</p>
	</fieldset>
  </div>
	<div class="clear"></div>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<p class="form-row">
		<?php wp_nonce_field( 'save_account_details' ); ?>
		<input type="submit" class="button" name="save_account_details" value="<?php _e( 'Save changes', 'woocommerce' ); ?>" />
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>

</form>
</div>
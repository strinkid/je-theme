<?php
/**
 * Additional Information tab
 *
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version      3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

do_action('woocommerce_before_additional_information');

$heading = apply_filters( 'woocommerce_product_additional_information_heading', __( 'Additional Information', 'woocommerce' ) );

?>

<?php if ( $heading ): ?>
	<h2><?php echo $heading; ?></h2>
<?php endif; ?>

<?php 
wc_display_product_attributes( $product );
//$product->list_attributes(); ?>

<?php do_action('woocommerce_after_additional_information'); ?>
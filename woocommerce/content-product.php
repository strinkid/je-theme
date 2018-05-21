<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Extra post classes
$classes = array();
?>
<div class="col-sm-3 col-xs-6" style="min-height:300px;">
	
	<div <?php post_class( $classes ); ?> style="text-align: left; text-align: -moz-left;">

		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

		<a href="<?php the_permalink(); ?>">

			<?php
				/**
				 * woocommerce_before_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_show_product_loop_sale_flash - 10
				 * @hooked woocommerce_template_loop_product_thumbnail - 10
				 */
				do_action( 'woocommerce_before_shop_loop_item_title' );
			?>

			<p class="productTitle-mostView-panel"><?php the_title(); ?></span><span style="font-size: 12px;color:black;"> <?php displayStockLeft();?></p>
		</a>
		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
		<div>
			<?php

			/**
			 * woocommerce_after_shop_loop_item hook
			 *
			 * @hooked woocommerce_template_loop_add_to_cart - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item' );
			add_compare_link_je(get_the_ID());
			?>
		</div>

	</div>
</div>
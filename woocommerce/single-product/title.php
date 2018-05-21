<?php
/**
 * Single Product title
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
$brands = wc_get_product_terms( get_the_ID(), 'pa_brand', array( 'fields' => 'names' ) );
$current_url = "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI'];
?>
<h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>
<div id="prod-info" style="text-align:left; font-weight:bold">
	<?php if($brands[0] != ''){ ?>
	<div class="product_attributes">Brand : <?php echo $brands[0] ?></div>
    <?php } ?>
	<div class="product_attributes" style="display:inline;">Product SKU : <?php echo $product->get_sku(); ?></div>
    <?php do_action('after_title_product',$current_url); ?>
    <br/>
</div>

<input type="hidden" value="<?php wc_get_product( get_the_ID() )->get_price()?>" id="the-product-price">
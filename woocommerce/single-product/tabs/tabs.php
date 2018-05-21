<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>
        <div class="productDetailsDescription">
        
            <?php
			//print_r($product->get_attribute( 'pa_brand' ));
            if (empty(get_the_excerpt())){
                $postContent = get_the_content();
                echo wpautop(wp_trim_words($postContent, 100));
            }
            else{
                echo wpautop(get_the_excerpt());
            }
            ?>
            <div class="clearfix"><em><a href="#spesifikasibawah">Spesifikasi Produk Dapat Dilihat Di Sini...</a></em></div>
        </div>
    </div>
</div>
<script>
$('[href="#spesifikasibawah"]').click(function(){
    $('html, body').animate({
        scrollTop: $( $.attr(this, 'href') ).offset().top
    }, 500);
    return false;
});
</script>
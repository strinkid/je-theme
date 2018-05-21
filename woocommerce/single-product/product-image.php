<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;

?>
<div>
	<div class="row">
		<div class="col-md-4">
			<div class="images">
				<?php  
				if(!isMobile()){ #IF NOT MOBILE
					do_action( 'woocommerce_product_thumbnails' ); 

					if ( has_post_thumbnail() ) {

						$image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
						$image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
						$image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );
                        $image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' )[0];
						$image_featured       	= get_the_post_thumbnail( $post->ID, 'full', array(
							'title'	=> $image_title,
							'alt'	=> $image_title,
                            'id' => 'thumb'
							) );

						$attachment_count = count( $product->get_gallery_image_ids() );

						if ( $attachment_count > 0 ) {
							$gallery = '[product-gallery]';
						} else {
							$gallery = '';
						}
                        ?><div id="productDetailsViewedImage">
                            <a class="magnifier-thumb-wrapper" style="margin:auto;width:300px;height:300px;">
                                <img width="300" height="300" src="<?php echo $image_url; ?>" class="attachment-shop_single wp-post-image opaque" id="zoom_03" data-zoom-image="<?php echo $image_url; ?>">
                            </a>
                            <?php do_action('after_je_product_image',$post->ID); ?><!-- FOR YOUTUBE -->
                        </div><?php

					} else {

						echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );

					}
				}else{ #IF MOBILE
					do_action( 'woocommerce_product_thumbnails' ); 
				}
				?>
				
				
			</div>
		</div>
<?php 
if(!isMobile()){ ?>
<script>
//initiate the plugin and pass the id of the div containing gallery images
$("#zoom_03").elevateZoom({
		gallery:'gallery_01', 
		cursor: 'crosshair', 
		galleryActiveClass: 'active', 
		zoomWindowWidth:600,
        zoomWindowHeight:400,
		lensSize:10000,
		lensBorder:0,
		zoomLens:false,
		borderSize:0
		
	}); 

//pass the images to Fancybox
$("#zoom_03").bind("click", function(e) {  
  var ez =   $('#zoom_03').data('elevateZoom');	
	$.fancybox(ez.getGalleryList());
  return false;
});
</script>
<?php } ?>
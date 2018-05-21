<?php
/**
 * Single Product Thumbnails
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.1.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $post, $product, $woocommerce;

$thumb_id = get_post_thumbnail_id(get_the_ID());
$post_thumbnail = wp_get_attachment_url( $thumb_id );
$post_thumbnail_smal = wp_get_attachment_thumb_url( $thumb_id);

$attachment_ids = $product->get_gallery_image_ids();

if(isMobile()){ ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/swiper.min.js"></script>

  <style>
  .product_thumb{
        width: 200px;
        height: 200px;
    }

   .product_thumb .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;

        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }
    </style>
    <div class="swiper-container product_thumb">
        <div class="swiper-wrapper">
          <img class="swiper-slide" src="<?php echo $post_thumbnail;?>"/>
            <?php foreach( $attachment_ids as $attachment_id ){ ?>
              <img class="swiper-slide" src="<?php echo wp_get_attachment_url($attachment_id);?>"/>
            <?php } ?>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
    <script>
    var swiper = new Swiper('.swiper-container.product_thumb', {
        pagination: '.swiper-pagination',
        paginationClickable: true
    });
    </script>
<?php
}else{ #IF NOT MOBILE
?>
<script src='<?php echo get_template_directory_uri()  ?>/js/jquery.elevatezoom.js'></script>
<style>
  /*set a border on the images to prevent shifting*/
 #gallery_01 img{border:2px solid white;}
 
 /*Change the colour*/
 .active img{
   border:1px solid #e77600 !important;}
#altImages{
  width:50px;
/*  background-color:#E80105;*/
  float:left;
}
#gallery_01{
  width:50px;
}
#gallery_01 a img{
  width:50px;
  border:1px solid #ddd;
  margin-bottom:2px;
  cursor:pointer;
}
.zoomWindowContainer{
  z-index:999;
}
</style>
<div id="altImages">
  <div id="gallery_01">
      <a data-image="<?php echo $post_thumbnail;?>" data-zoom-image="<?php echo $post_thumbnail;?>">
          <?php echo '<img id="img_01" src="'.$post_thumbnail_smal.'">';?>
         </a>
      <?php
    foreach( $attachment_ids as $attachment_id ) 
    {
      ?>
            <a data-image="<?php echo wp_get_attachment_url($attachment_id);?>" data-zoom-image="<?php echo wp_get_attachment_url($attachment_id);?>">
             <?php echo '<img id="img_01" src="'.wp_get_attachment_thumb_url( $attachment_id ).'">';?>
            </a>
            <?php
    }
    do_action('after_product_thumbnail',get_the_ID()); #FOR YOUTUBE
    ?>
    </div>
  <div class="clearfix"></div>
</div>

<script>
  $("#gallery_01 a").hover(function(){
    $("#zoom_03").show();
    $("#youtub-emb-1").hide();  
    $('.zoomContainer').show();
  });
  $(".video-single-prod").hover(function(){
    var key = $(this).attr('data-code');
    $("#zoom_03").hide();
    $('.zoomContainer').hide();
    $(".frame-youtube").hide(); 
    $("#youtub-emb-"+key).show();   
  });
</script>
<?php
}
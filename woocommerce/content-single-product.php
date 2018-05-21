<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author    WooThemes
 * @package   WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

?>

<?php
  /**
   * woocommerce_before_single_product hook
   *
   * @hooked wc_print_notices - 10
   */
   do_action( 'woocommerce_before_single_product' );

   if ( post_password_required() ) {
    echo get_the_password_form();
    return;
   }

?>

<div itemscope itemtype="<?php echo schema_org_markup(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php woocommerce_breadcrumb(); ?>
  

  <?php
  
    /**
     * woocommerce_before_single_product_summary hook
     *
     * @hooked woocommerce_show_product_sale_flash - 10
     * @hooked woocommerce_show_product_images - 20
     */
    do_action( 'woocommerce_before_single_product_summary' );
  ?>

  <div id="productDetailsSummary" class="col-md-6 summary entry-summary ">
    <?php
      /**
       * woocommerce_single_product_summary hook
       *
       * @hooked woocommerce_template_single_title - 5
       * @hooked woocommerce_template_single_rating - 10
       * @hooked woocommerce_template_single_price - 10
       * @hooked woocommerce_template_single_excerpt - 20
       * @hooked woocommerce_template_single_add_to_cart - 30
       * @hooked woocommerce_template_single_meta - 40
       * @hooked woocommerce_template_single_sharing - 50
       */
      do_action( 'woocommerce_single_product_summary' );
    ?>

  </div><!-- .summary -->

  <?php
    /**
     * woocommerce_after_single_product_summary hook
     *
     * @hooked woocommerce_output_product_data_tabs - 10
     * @hooked woocommerce_upsell_display - 15
     * @hooked woocommerce_output_related_products - 20
     */
    do_action( 'woocommerce_after_single_product_summary' );
  ?>

  <div class="col-md-2" id="priceContainer">
  <?php 
    displayEditableStarJe(); 
    global $current_user, $product;
    $display_name = (isset($current_user->data->display_name) && $current_user->data->display_name != '') ? $current_user->data->display_name : '';
    $email = (isset($current_user->data->user_email) && $current_user->data->user_email != '') ? $current_user->data->user_email : '';
  ?>
    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            <div class="product_attributes">HARGA: </div>
            <div class="price"><?php echo getCurrencyDisplay($product->get_price()); ?></div>

      <meta itemprop="price" content="<?php echo $product->get_price(); ?>" />
      <meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
      <link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
 
            <?php if ($product->is_on_sale()){ ?>
      <div class="product_attributes">Sebelum: <span style="text-decoration: line-through;"><?php echo getCurrencyDisplay($product->get_regular_price()); ?></span></div>
      <div class="product_attributes">Hemat: <?php echo getCurrencyDisplay(($product->get_regular_price() - $product->get_sale_price())); ?> </div>
            <br/>
            <?php } ?>
      
      <?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

            <form class="cart" method="post" enctype='multipart/form-data'>
            <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

        <?php

                if(  $product->is_type( 'variable' ) ){
                    $attributes = $product->get_attributes();
                    $variations = $product->get_available_variations();

                    foreach($attributes as $slug=>$attribute){
                        $options = get_the_terms( get_the_ID(), $attribute['name']);
                        $taxonomy_details = get_taxonomy( $attribute['name'] );
          
            if($attribute['is_visible'] == 1){
                        ?><div class="productAttributeSelection"><?php
                            ?><div><?php echo $taxonomy_details->label;?></div><?php
                            ?><select class="attribute_<?php echo $attribute['name'];?>" name="attribute_<?php echo $attribute['name'];?>"><?php
                                foreach($options as $key=>$option){
                                    ?><option value="<?php echo $option->slug;?>"><?php echo $option->name;?></option><?php
                                }
                                ?></select></div>
                        <input type="hidden" class="variation_id" name="variation_id" value=""/>
                        <script>
                            $(document).ready(function(){
                                var variations = <?php echo json_encode($variations);?>;
                                $('#btn-buy').click(function(e){
                                    for(var i=0;i<variations.length;i++){
                                        var allAttributesSame = true;
                                        for(var key in variations[i]['attributes']){
                                            if (variations[i]['attributes'][key] != $('.'+key).val()) allAttributesSame = false;
                                        }
                                        if (allAttributesSame) $('.variation_id').val(variations[i]['variation_id'])
                                    }
                                });
                            });
                        </script>
                    <?php
          }
                    }     
                }

                ?>
        
            <?php
            if ( ! $product->is_sold_individually() )
                woocommerce_quantity_input( array(
                    'min_value' => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
                    'max_value' => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product )
                ) );
            ?>

            <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( get_the_ID() ); ?>" />

            <?php if($product->is_in_stock()) { ?>
                <div><button type="submit" id="btn-buy" class="btn btn-default" type="submit"><b>ADD TO CART</b></button></div>
                <?php } else { ?>
                      <!--<div class="productDetailsMeta habis-terjual">HABIS TERJUAL</div>-->
                <?php } ?>

            <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

        </form>
       <?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
        <!--div class="productDetailsMeta">Gratis Ongkos <br>Kirim ke Jabodetabek</div-->
    </div>  
        <div class="corporate_buying">Corporate buying? <a href="#" target="_blank" data-toggle="modal" data-target="#myModal-pembelian-corporate"><img style="width:60px;" src="<?php echo get_template_directory_uri();?>/img/telp-je3.gif"></a></div>
  </div>

  <meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->
<!-- Modal pembelian corporate-->
<div id="myModal-pembelian-corporate" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Pembelian dalam Jumlsh Besar?</h4>
            </div>
            <div class="modal-body">
            
                <h4 style="font-size:16px;" id="tanyahead-corporate">Silahkan isi data diri Anda untuk kami hubungi.</h4>
                <div id="cor_tanya_pabrik_reason" style="display:none;"></div>
                <div class="form-horizontal" role="form" id="form-tanya-corporate">
                    <div class="form-group">
                        <label class="control-label col-sm-4">Nama:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm" name="tn" value="<?php echo $display_name;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Email:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm" name="te" value="<?php echo $email;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Telephone:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm" name="tt">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Nama Produk:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm" name="tnp" value="<?php echo get_the_title();?>">
                        </div>
                    </div>
                    <div class="form-group">
                  <?php 
                  $harga_produk = $product->get_price();
                  if($harga_produk > 3000000){
                    $min_qty = 3;
                  }else{
                    $min_qty = 10;
                  }
                  ?>
                        <label class="control-label col-sm-4">Jumlah Pesanan:</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control input-sm" name="jml" style="width: 20%;" min="<?php echo $min_qty;?>" value="<?php echo $min_qty;?>">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="tanyakan-corporate" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Tanya Ke Pabrik</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(e){
  jQuery("#tanyakan-corporate").click(function(e) {
    var $this = $(this);
      $this.button('loading');
    var id = "<?php echo get_the_ID();?>";
        var nama = jQuery('[name="tn"]').val();
        var email = jQuery('[name="te"]').val();
        var tlp = jQuery('[name="tt"]').val();
        var nama_produk = jQuery('[name="tnp"]').val();
        var jumlah = jQuery('[name="jml"]').val();
        jQuery.ajax({
      url:"<?php echo admin_url( 'admin-ajax.php' );?>",
      cache:false,
      type:"POST",
      data:{'action':'corporate_tanya_ke_pabrik','id':id,'nama':nama,'email':email,'tlp':tlp,'nama_produk':nama_produk, 'jumlah':jumlah},
      success: function(msg){
        $this.button('reset');
        var obj = JSON.parse(msg);
        if(obj.code == 1){
          $('#cor_tanya_pabrik_reason').addClass('alert alert-success').html('<i class="fa fa-check fa-lg" style="color:#3c763d !important;"></i> '+obj.reason).show();
          $('#form-tanya-corporate').hide();
          $('#tanyakan-corporate').hide();
          $('#tanyahead-corporate').hide();
          
        }else{
          $('#cor_tanya_pabrik_reason').addClass('alert alert-danger').html('<i class="fa fa-exclamation-triangle fa-lg" style="color:#a94442 !important;"></i> '+obj.reason).show();
        }
      }
    });
    });
});

</script>
<?php do_action( 'woocommerce_after_single_product' ); ?>

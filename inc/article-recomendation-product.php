<?php
/**
 * Register meta box(es).
 */
function wpdocs_register_meta_boxes() {
    add_meta_box( 
    'meta-box-recommended-product', 
    __( 'Product Recomendation', 'textdomain' ), 
    'wpdocs_my_display_callback', 
    'post');
}
add_action( 'add_meta_boxes', 'wpdocs_register_meta_boxes' );
 
/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function wpdocs_my_display_callback( $post ) {
  $key_cprec = get_post_meta( $post->ID, '_cp_recommend', true ); 
    // Display code/markup goes here. Don't forget to include nonces!
  global $lima_query,$wpdb;

  ?>
  <label>Attributes : </label> 
  <select name="post_product_recommended[]" id="post_product_recommended" multiple="yes" style="width:300px;">
    <option value="">-Pilih Attribute</option>
    
  </select>
    
    <script>
  jQuery(function(){  
    //jQuery('#cp_recommend').select2({width: "95%",height:"30px",allow_single_deselect:true});
    
    jQuery('#publish').prop('disabled',true);
    var data = {'action':'lima_post_load_attributes','id':'<?php echo $post->ID; ?>'};
    // jQuery('#meta-box-recommended-product').block({message:null});
    jQuery.ajax({
            url: ajaxurl,
            method: "POST",
            data: data,
            dataType: "html",
            success: function(data) {
        jQuery('#post_product_recommended').html(data); 
        // jQuery('#post_product_recommended').select2();     
        // jQuery('#meta-box-recommended-product').unblock();
        jQuery('#publish').prop('disabled',false);
      }
    });
    
    change_post_product_recommended();
        
  });
  
  function change_post_product_recommended(){
    
    jQuery('body').on('hover','#publish',function(){
      
      jQuery('.hidden-tax').remove();
      
      lima_generate_taxonomy_post_product_recommended();      
      
    });
  }
  
  function lima_generate_taxonomy_post_product_recommended(){
    
    var html = '';
    var val = jQuery('#post_product_recommended').val();
    val.forEach(function(v){
      console.log(v);
      var opt = jQuery('#post_product_recommended').find('option[value="'+v+'"]');
      var tax = opt.attr('data-tax');
      var l = jQuery('body').find('#'+tax+'-'+v).length;
      if(!l){
        html += '<input id="'+tax+'-'+v+'" type="hidden" name="recommended_attributes[]" class="hidden-tax" value="'+tax+'--'+v+'" />';
      }
       
    });   
     
    jQuery('#post_product_recommended').after(html);
    
  }
  
  function lima_get_attribute_selected_data(text_selected){
      
      jQuery('#post_product_recommended').find('option').each(function(){
            
        var option_text = jQuery(this).text();
        if(option_text == text_selected){
          
          var data = {
            'tax' : jQuery(this).attr('data-tax'),
            'id' : jQuery(this).attr('value')
          }
          
          return data;
          
        }
        
      });
      
    }
  
  //jQuery('#cp_recommend').chosen({width: "95%",height:"30px",allow_single_deselect:true});
  </script>
    <?php

}
 
/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function wpdocs_save_meta_box( $post_id ) {
    // Save logic goes here. Don't forget to include nonce checks!
  // if( ! add_post_meta( $post_id, '_cp_recommend', $_POST['cp_recommend'], true ) ){ 
  //     //update_post_meta( $post_id, '_cp_recommend', $_POST['cp_recommend'] );
  // } 
  if(isset($_POST['post_product_recommended'])) {
    $post_product_recommended = implode(',', $_POST['post_product_recommended']);
    
    if ( ! add_post_meta( $post_id, '_post_product_recommended', $post_product_recommended,true) ) { 
      update_post_meta( $post_id, '_post_product_recommended', $post_product_recommended );
    }
  }
  
  $taxonomy = '';
  $data_arr = array();
  $recommended_attributes = isset($_POST['recommended_attributes']) ? $_POST['recommended_attributes'] : array();
  $count = count($recommended_attributes);
  $val = '';
  for($i=0; $i<$count; $i++){
    
    $val = $recommended_attributes[$i];
    $x = explode('--',$val);
    $tax = trim($x[0]);
    $id = trim($x[1]);
    
    $data[] = array('tax' => $tax, 'id'=>$id);
    
    //$data_arr = array_merge($data_arr,$data);
    
  }
  
  if($val){
    $taxonomy = lima_merge_taxonomy($data);
  }
  //$taxonomy = serialize($taxonomy);
    
  if ( ! add_post_meta( $post_id, '_post_product_recommended_taxonomy', $taxonomy,true) ) { 
      update_post_meta( $post_id, '_post_product_recommended_taxonomy', $taxonomy );
  }
  
}
add_action( 'save_post', 'wpdocs_save_meta_box' );

add_action('je_theme_post_sidebar','show_recomend_prod_topost');
function show_recomend_prod_topost($post_id){
  $key_cprec = get_post_meta( $post_id, '_cp_recommend', true );
  
  $rec_tax = get_post_meta($post_id,'_post_product_recommended_taxonomy',true);
    
  if(!$key_cprec and !$rec_tax) return get_sidebar( 'right' );
  
  $content = get_post_field('post_content', $post_id);
  $perpage = ( strlen($content) / 700 )+ 1;
  $args = array(
    'orderby'           => 'rand',
      'post_type'             => 'product',
      'post_status'           => 'publish', 
      'ignore_sticky_posts'   => 1,
      'posts_per_page'        => $perpage,  
      'meta_query'            => array(
          array(
              'key'           => '_visibility',
              'value'         => array('catalog', 'visible'),
              'compare'       => 'IN'
          )
      ),
      'tax_query'             => array(  
          array(
              'taxonomy'      => 'product_cat',
              'field'     => 'term_id', //This is optional, as it defaults to 'term_id'
              'terms'         => $key_cprec,
              'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
          )
      )
  );
  
  if($rec_tax){
    
    foreach($rec_tax as $tax){
      
      $taxonomy = $tax['taxonomy'];
      $term_id = $tax['term_id'];
      
      $tax_query[] = array(
              'taxonomy'      => $taxonomy,
              'field'     => 'term_id', //This is optional, as it defaults to 'term_id'
              'terms'         => $term_id,
              'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
            );
      
    }
    
    $args['tax_query'] = array(
                'relation' => 'OR',   
                $tax_query
              );   
  }
  
  $products = new WP_Query($args); ?>
  <h2 class="MainTitle-viewHistory" style="padding-bottom:1px;">Recommended Products</h2><hr/>
  <?php 
  foreach($products->posts as $product){
    $meta = get_post_meta($product->ID);
    $_regular_price = $meta['_regular_price'][0];
    $_sale_price  = $meta['_sale_price'][0];
    ?>
        <div class="col-xs-6 col-sm-3 col-md-12 col-lg-12 hotItemsContent post-recomend">
            <li class="product">
                <a href="<?php echo get_permalink($product->ID)?>">
                    <div class="hotItemsSaleIconParent">
                        <?php echo get_the_post_thumbnail( $product->ID, 'thumbnail' );?>
                    </div>
                    <div class="productTitle-mostView-panel"><?php echo $product->post_title; ?></div>
                </a>
                <?php if($_sale_price != '') { ?>
                <div class="regularPriceText">Rp <?php echo number_format($_regular_price,0);?></div>
                <div class="salePriceText">Rp <?php echo $_sale_price;?></div>
                <?php }else{ ?>
                <div class="salePriceText">Rp <?php echo $_regular_price;?></div>
                <?php } ?>
            </li>
        </div>
        <?php
  } 
}


add_action('wp_ajax_lima_post_load_attributes','lima_post_load_attributes');
function lima_post_load_attributes(){
  
  $post_id = $_POST['id'];
  
  $recommended_products = get_post_meta($post_id,'_post_product_recommended',true);
  
  $attribute_options = '';
  
  $attributes = lima_get_all_attributes();
    
  $attr = lima_get_exist_attributes('',$attributes);
    
  $labels = get_attr_title();
  
  $attribute_options = '';  
  foreach($labels as $label){
    $attribute_options .= ' <optgroup label="'.$label['label'].'">';
    
    $count = 0;
    foreach($attr as $att){
      
      $tax = $att['taxonomy'];
      if($tax !== $label['taxonomy'] ){       
        continue;
      }else{
        $count++;
      }
      $product_count = ($att['count'] >= 200) ? '200+' : $att['count'];
      
      $selected =(strpos($recommended_products, $att['id']) !==false) ? 'selected="selected"' : '';
      
      $attribute_options .= '<option value="'.$att['id'].'" '.$selected.' data-tax="'.$att['taxonomy'].'" >'.$att['name'].' ('.$product_count.') </option>';
      
    }
      
    if(!$count){
      continue;
    }
    
    $attribute_options .= '</optgroup>';
  }
  
  echo $attribute_options;
  die();
  
}

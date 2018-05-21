<?php
/*
* Template Name: Product cat
* Description: A Page Template 
*/
?> 
<?php get_header(); ?>
    <div id="main">
        <div class="limitWidth clearfix woocommerce">
		<div class="col-md-3 filter-sidebar">
			<?php //dynamic_sidebar('front-page'); ?>
			<img src="<?php //echo site_url(); ?>/wp-content/themes/je-theme/img/banner-shop-<?php echo(rand(1,5));?>.jpg" />
			<?php lima_toggle_filter(); ?>
			<div id="filter-attributes"></div>
		
		</div>
        <div id="lima-content" class="col-md-9">
        	<div class="row">
                <?php //if(isset($_GET["pc"])): ?>

                    <?php 
                    global $wpbd;
                    $value = get_post_meta( $post->ID, '_my_meta_product_cat', true );
                    $value2 = get_post_meta( $post->ID, '_my_meta_product_perpage', true );
                    $value2 = $value2 ? $value2 : 16;
                    $args = array( 'type' => 'product', 'taxonomy' => 'product_cat' ); 
                    
                    add_filter('term_link', 'term_link_filter', 10, 3);
                function term_link_filter( $url, $term, $taxonomy ) {

                if($taxonomy == 'product_cat'){ 
                $id = $term->ID; 
                //cari page dengan content like $id
                $url = site_url() . '/harga-pompa-booster/';
                return $url;
                 
                    }else{ return $url; }

                    return $url;

                }

                        //query_posts( "cat=22" );

                    ?>

                <?php if(isset($_GET["pc"])): ?>
                <?php //$qr=query_posts( "ca=".$value );
                       // print_r($qr);
                echo get_permalink(16510);
                

                ?>
                <?php endif; ?>
				<?php //echo do_shortcode('[woof sid="auto_shortcode" autohide=0 price_filter=1 taxonomies=product_cat:'.$value.']'); ?>
				<!-- <div class="col-md-9"> -->

            <?php if (have_posts()) : while (have_posts()) : 
                    //echo do_shortcode('[woof_products per_page='.$value2.' columns=4 is_ajax=1 taxonomies=product_cat:'.$value.']');
					echo do_shortcode('[lima_product_filter cat_id="'.$value.'" posts_per_page="'.$value2.'"]');
                    the_post(); 
            ?>

                <?php the_content('Read more...'); ?>
                <?php endwhile;
            else: ?>
                <?php _e('Sorry, no posts matched your criteria.'); ?><?php endif; ?>
            <!-- </div> -->
			<div class="clearfix"></div>
			</div>
        </div>
        </div> 
    </div>
<?php get_footer(); ?>
<script>
    $(document).ready(function(){
        console.log($(document).height());
        console.log($('#header').height());
        console.log($('#footer').height());
        console.log($('#wpadminbar').height());
        var fullHeight = $(document).height();
        var newHeight = fullHeight - $('#header').height() - 224 - $('#wpadminbar').outerHeight(true);
        $('#main').css('min-height',newHeight+'px');
    });
</script> 

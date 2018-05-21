<?php get_header('shop'); ?>
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
                <?php 
                    global $wpbd;
                    $value = 0;
                    $value2 = 20;

                 ?>

            <?php
					if(isset($_GET['s'])){
						$s = $_GET['s'];
					}else{
						$s = '';
					}
        			echo do_shortcode('[lima_product_filter cat_id="'.$value.'" srch="'.$s.'"]');
                    //the_post(); 
            ?>

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
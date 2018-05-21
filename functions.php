<?php
if (stripos(get_option('siteurl'), 'https://') === 0) {
    $_SERVER['HTTPS'] = 'on';
}

function je_theme_support(){
    	add_theme_support('menus');
	add_theme_support( 'woocommerce' );	
    	register_nav_menu('Header Menu','Header Menu besides logo');
    	register_nav_menu('Footer Menu','Footer Menu');
}
add_action('init','je_theme_support');

function je_theme_customizer( $wp_customize ) {
    //add Header section in CUSTOMIZE
    $wp_customize->add_section( 'je_header_section' , array(
        'title'       => __( 'Header', 'je' ),
        'priority'    => 30,
        'description' => 'Upload a logo and Header Menu',
    ) );
    $wp_customize->add_setting( 'je_logo' );
    $wp_customize->add_setting( 'je_1stImg' );
    $wp_customize->add_setting( 'je_1stUrl' );
    $wp_customize->add_setting( 'je_2ndImg' );
    $wp_customize->add_setting( 'je_2ndUrl' );
    $wp_customize->add_setting( 'je_3rdImg' );
    $wp_customize->add_setting( 'je_3rdUrl' );
    $wp_customize->add_setting( 'je_VoucherImg' );
    $wp_customize->add_setting( 'je_VoucherUrl' );

    //START editable details in Header section
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'je_logo', array(
        'label'    => __( 'Logo', 'je_logo' ),
        'section'  => 'je_header_section',
        'settings' => 'je_logo',
    ) ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'je_1stImg', array(
        'label'    => __( '1st Image', 'je_1stImg' ),
        'section'  => 'je_header_section',
        'settings' => 'je_1stImg',
    ) ) );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'je_1stUrl', array(
        'label'    => __( '1st Image URL', 'vv' ),
        'section'  => 'je_header_section',
        'settings' => 'je_1stUrl',
        'type'     => 'text',
    ) ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'je_2ndImg', array(
        'label'    => __( '2nd Image', 'ff' ),
        'section'  => 'je_header_section',
        'settings' => 'je_2ndImg',
    ) ) );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'je_2ndUrl', array(
        'label'    => __( '2nd Image URL', 'dd' ),
        'section'  => 'je_header_section',
        'settings' => 'je_2ndUrl',
        'type'     => 'text',
    ) ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'je_3rdImg', array(
        'label'    => __( '3rd Image', 'je' ),
        'section'  => 'je_header_section',
        'settings' => 'je_3rdImg',
    ) ) );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'je_3rdUrl', array(
        'label'    => __( '3rd Image URL', 'je' ),
        'section'  => 'je_header_section',
        'settings' => 'je_3rdUrl',
        'type'     => 'text',
    ) ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'je_VoucherImg', array(
        'label'    => __( 'Voucher Image', 'je' ),
        'section'  => 'je_header_section',
        'settings' => 'je_VoucherImg',
    ) ) );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'je_VoucherUrl', array(
        'label'    => __( 'Voucher Image URL', 'je' ),
        'section'  => 'je_header_section',
        'settings' => 'je_VoucherUrl',
        'type'     => 'text',
    ) ) );
//END editable details in Header section
}
add_action( 'customize_register', 'je_theme_customizer' );

//start FOOTER
function getMenuByThemeLocation($themeLocation){
    $theme_locations = get_nav_menu_locations();
    $menu_obj = get_term( $theme_locations[$themeLocation], 'nav_menu' );
    $menu_name = $menu_obj->name;
    $items = wp_get_nav_menu_items( $menu_name );
    return $items;
}
function printMenuFooter($themeLocation){
    $items = getMenuByThemeLocation($themeLocation);
    $columnCount = 0;
    foreach ($items as $item) {
        if ($item->menu_item_parent == '0') $columnCount++;
    }
    if ($columnCount > 4) $columnCount = 4;

    $colMd = 'col-md-'.(12/$columnCount);

    foreach ($items as $item) {
        $class = 'footerSubMenu';
        if ($item->menu_item_parent == '0'){
            if ($item->menu_order != 1) echo '</ul></div>';
            echo '<div class="'.$colMd.' footerMenuBorder">';
            $class = 'footerHeaderMenu';
			echo '<span class="'.$class.'">'.$item->title.'<br/>'.'</span>
<ul class="menu-footer-double">';
        }else{
	        echo '<li class="'.$class.'"><a href="'.$item->url.'">'.$item->title.'<br/></a>'.'</li>';
		}
    }
    echo '</ul></div>';
}
//end FOOTER

//start WIDGET
function je_widgets_init() {

    register_sidebar( array(
        'name'          => 'Front Page',
        'id'            => 'je_front_page',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
    ) );

}
add_action( 'widgets_init', 'je_widgets_init' );
//end WIDGET

//start HEADER
function displaySearchForm(){
    $form = '<form role="search" method="get" id="searchForm" action="' . esc_url(home_url('/')) . '">
                <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="Cari produk, kategori atau merek" />
                <button class="btn btn-default" type="submit"><span class="fa fa-search"></span>
                    <input type="hidden" name="post_type" value="product" />
                </button>
            </form>';
    echo $form;
}

function displayShopByCategoryMenu()
{
    $args = array(
        'taxonomy' => 'product_cat'
    );
$site_url = site_url();
    $categories = get_categories($args);
    $parents_cat = array();
    $childs_cat = array();
    $allchilds_cat = array();
	$url_image = array(
						$site_url . "/product/brand/wasser-pompa-air-pc250ea",
						$site_url . "/product/panasonic/panasonic-microwave-convectiongrill-23l-nn-df383btte",
						$site_url . "/product/brand/hurom-slow-juicer-silver-stainless-hg-sbe11",
						$site_url . "/?swoof=1&post_type=product&product_cat=hair-curler-catokan&page=1",
						$site_url . "/product-category/brand/our-brand",
						"#");
    foreach ($categories as $category) {
        if ($category->category_parent == '0') array_push($parents_cat, $category);
        else array_push($allchilds_cat, $category);
    }
    foreach ($parents_cat as $category) {
        $child = array();
        foreach ($allchilds_cat as $category_child) {
            if ($category_child->category_parent == $category->cat_ID)
                array_push($child, $category_child);
        }
        array_push($childs_cat, $child);
    }
    foreach ($childs_cat as $child_group_category) {
        foreach ($child_group_category as $child_category) {
            $sub_child = array();
            foreach ($allchilds_cat as $sub_child_category) {
                if ($sub_child_category->category_parent == $child_category->cat_ID)
                    array_push($sub_child, $sub_child_category);
            }
            $child_category->subchild = $sub_child;
        }
    }
    ?>
    <ul id="shopByCategory" class="navbar nav navbar-nav">
        <li class="dropdown headerCategory">
            <a id="dropdown-toggle-shopCategory" class="dropdown-toggle" data-toggle="dropdown" href="#">Shop By Category
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu multi-level" style="height:300px">
                <?php for ($i = 0; $i < count($parents_cat); $i++) { ?>
                    <li class="subMenuClass" data-submenu-id="submenu-<?php echo $i ?>">
                        <a class="dropdown-toggle bgToggle" data-toggle="dropdown" href="#">
                            <div class="category-icon arrow_box">
                                <div class="category-icon-<?php echo ($i+1) ?>">&nbsp;</div>
                                <div><?php echo $parents_cat[$i]->name ?></div>
                            </div>
                        </a>
                        <div id="submenu-<?php echo $i ?>" class="popover bgToggle" style="display:none;">
                            <div>
                                <ul class="shopCategory-menu">
                                    <?php foreach ($childs_cat[$i] as $child) { ?>
                                        <li>
                                        	<?php
											$ua=getBrowser();
											if($ua['name'] == 'Mozilla Firefox'){
											?>
                                            <ul>
                                            <?php
											}else{
												echo '<ul style="padding-bottom:15px;">';
											}
											?>
                                                <div class="shopCategory-menuTitle"><?php echo $child->name ?></div>
                                                <?php foreach ($child->subchild as $subchild) { ?>
                                                    <li class="shopCategory-list">
                                                        
                                                           <a href="<?php echo esc_url( get_term_link( $subchild->slug, 'product_cat' ) ); ?>">

                                                           <div class="shopCategory-submenu-name"><span><?php echo ucwords($subchild->name) ?></span></div>
                                                            <?php if ($subchild->description != null && $subchild->description != ''){ ?><div class="shopCategory-submenu-description"><span><?php echo $subchild->description ?></span></div><?php } ?>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="popOverBackground"></div>
                            <div class="popOverImage" style="display:none">
                                <a href="<?=$url_image[$i]?>"><img src="/wp-content/themes/je-theme/img/background-popover-<?php echo ($i+1) ?>.png"></a>
                            </div>

                        </div>
                    </li>
                <?php } ?>

            </ul>
        </li>
    </ul> <?php
}
//end HEADER

function getCurrencyDisplay($amount){
    if (empty($amount)) return;
    return get_woocommerce_currency_symbol().'. '.number_format($amount, 0, '.', ',');
}

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

//add theme specific menu
require_once( dirname(__FILE__) . '/admin-menu.php' );

//add view history module
require_once( dirname(__FILE__) . '/view-history/view-history.php' );

//add hot items & best deals module
require_once( dirname(__FILE__) . '/hot-items-best-deals/hot-items-best-deals.php' );

//add HTML5 video shortcodes
require_once( dirname(__FILE__) . '/video-shortcodes.php' );
require_once( dirname(__FILE__) . '/image-shortcodes.php' );

require_once( dirname(__FILE__) . '/single-product-je.php' );
require_once( dirname(__FILE__) . '/checkout-je.php' );
require_once( dirname(__FILE__) . '/myaccount-je.php' );
require_once( dirname(__FILE__) . '/ratingstar-je/ratingstar-je.php' );
require_once( dirname(__FILE__) . '/scriptsoptimizer-je.php' );

#BY ASEFUR MUKTI
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/my-functions.php';
require get_template_directory() . '/inc/article-recomendation-product.php';
require get_template_directory() . '/inc/youtube-galery.php';

require get_template_directory() . '/woocommerce/checkout/edit-alamat.php';
require get_template_directory() . '/woocommerce/checkout/shipping-map.php';



// Remove Add to Cart on the shop page
function remove_loop_button(){
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10, 2 );
}
add_action('init','remove_loop_button');

function RemoveWrapperStart(){
    remove_action('woocommerce_before_main_content' , 10);
}
function RemoveWrapperEnd(){
    remove_action('woocommerce_after_main_content' , 10);
}

function displayStockLeft(){
    global $product;
    $stockLeft = number_format($product->stock,0,'','');
    $minStockToNotify = 0;
    $minStockToNotifySetting = get_option('maximumItemLeftInStock');
    if (!empty($minStockToNotifySetting)) $minStockToNotify = $minStockToNotifySetting;

    if($stockLeft <= 0){
        return;
    }else if($stockLeft <= $minStockToNotify){
        echo 'only '.$stockLeft.' left in stock';
    }else{
        return;
    }
}
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price');
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 1 );
//add_action('woocommerce_after_shop_loop_item_title', 'displayStockLeft', 15);

function displayBestSeller( $atts, $content = null ){

    // for get Product ID
    global $post;
    // for get Product Category
    global $product;
    // for get result of query
    global $wpdb;

    if (empty($atts['count'])) $count = 5;
    else $count = $atts['count'];

    //$getCategory = $product->get_categories( ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', sizeof( get_the_terms( $post->ID, 'product_cat' ) ), 'woocommerce' ) . ' ', '.</span>' );

    //$getCategory = $product->get_categories(sizeof( get_the_terms( $post->ID, 'product_cat' )));

    // Get Categories
    $getCategory = $product->get_categories();


    $splitCtg = $getCategory;
    // split category by ","
    $categoryList = split(',',$splitCtg);

    foreach ($categoryList as $categoryItem) {
        // get 1 category
        // split a href become string
        $categoryItem = strip_tags($categoryItem, '></a>');
		$categoryItem = addslashes($categoryItem);
		$categoryItem = trim($categoryItem);
        //echo $getCategory;

        // Get product id
        $product_id = $post->ID;

        $sql = "select a.id ";
        $sql .= "from wp_posts a, wp_woocommerce_order_itemmeta c, wp_terms d, wp_term_relationships e, wp_term_taxonomy f ";
        $sql .= "where c.meta_key = '_product_id' ";
        $sql .= "and c.meta_value = a.id ";
        $sql .= "and a.post_type = 'product' ";
        $sql .= "and d.term_id = f.term_id ";
        $sql .= "and e.term_taxonomy_id = f.term_taxonomy_id ";
        $sql .= "and f.taxonomy='product_cat' ";
        $sql .= "and d.name = '".$categoryItem."' ";
        $sql .= "and e.object_id = a.id ";
        $sql .= "group by a.id ";
        $sql .= "order by count(a.id) desc limit 1";

        $attempts = $wpdb->get_results($sql);

        if(intval($attempts[0]->id) == $product_id){
            $content .= '<div class="displayBestSeller">';
            $content .= '<img id="bestseller-img" src="'.get_template_directory_uri().'/img/bestsale.png">';
            $content .= '<p id="in-category">in '.$categoryItem;
            $content .= '</p>';
            $content .= '</div>';

            echo $content;
        }else{
            echo "";
        }
    }
}
add_action('woocommerce_after_shop_loop_item_title', 'displayBestSeller', 99);

function woocommerce_template_loop_product_thumbnail(){
    global $post;
	$AliasMeta = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' );
    $image_url = $AliasMeta[0];
    ?><img src="<?php echo $image_url; ?>" class="attachment-shop_catalog wp-post-image" alt="" height="150" width="150"><?php
}
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

add_filter('woocommerce_login_redirect', 'wcs_login_redirect');
function wcs_login_redirect( $redirect ) {
     $redirect = "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI'];
     return $redirect;
}

add_filter( 'woocommerce_default_address_fields' , 'custom_override_default_address_fields' );
function custom_override_default_address_fields( $address_fields ) {
    $address_fields['postcode']['required'] = false;
	
    return $address_fields;
}

add_filter( 'woocommerce_billing_fields', 'wc_npr_filter_phone', 10, 1 );
function wc_npr_filter_phone( $address_fields ) {
	$address_fields['billing_last_name']['required'] = false;
	return $address_fields;
}

add_filter( 'woocommerce_breadcrumb_defaults', 'jk_woocommerce_breadcrumbs' );
function jk_woocommerce_breadcrumbs() {
    return array(
            'delimiter'   => ' › ',
            'wrap_before' => '<nav class="woocommerce-breadcrumb je-breadcrumb" itemprop="breadcrumb">',
            'wrap_after'  => '</nav>',
            'before'      => '',
            'after'       => '',
            'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
        );
}

function je_show_products($atts, $content = null){
	extract($atts);
	if (!isset($show) || $show == '') $show = 'all';
  	if (!isset($per_page) || $per_page == '') $per_page = '-1';
	if (!isset($orderby) || $orderby == '') $orderby = 'menu_order';
	if (!isset($order) || $order == '') $order = 'desc';

	$args = array(
		'post_type'	=> 'product',
		'post_status' => 'publish',
		'posts_per_page' => $per_page,
		'ignore_sticky_posts'	=> 1,
		'orderby' => $orderby,
		'order' => $order,
		'meta_query' => '',
	);

    //Ordering by price
    if( $orderby == 'meta_value_num' ) {
        $args['meta_key'] = '_price';
    }

    if( $pagination == 'yes' ) {
        $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
        $args['paged'] = $paged;
    }

	if (strcmp($show, 'all') == 0) { // show all products

		$args['meta_query'][] = array(
      		'key' 		=> '_visibility',
      		'value' 	=> array('catalog', 'visible'),
				'compare' 	=> 'IN'
    	);

	}elseif (strcmp($show, 'featured') == 0) { // show featured products

  		$args['meta_query'][] = array(
      		'key' 		=> '_featured',
      		'value' 	=> 'yes'
    	);

	}elseif (strcmp($show, 'best_sellers') == 0) { // show best sellers products

  		$args['meta_key'] = 'total_sales';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'DESC';

	}elseif (strcmp($show, 'onsale') == 0) { // show onsale products

  		$args['meta_query'][] = array(
	    	'key' => '_sale_price',
	        'value' 	=> 0,
			'compare' 	=> '>'
        );

	}

	if(isset($skus)){
		$skus = explode(',', $skus);
	  	$skus = array_map('trim', $skus);
    	$args['meta_query'][] = array(
      		'key' 		=> '_sku',
      		'value' 	=> $skus,
      		'compare' 	=> 'IN'
    	);
  	}

	if(isset($ids)){
		$ids = explode(',', $ids);
	  	$ids = array_map('trim', $ids);
    	$args['post__in'] = $ids;
	}

    if(!empty( $category )) {
        $tax = 'product_cat';
        $category = array_map( 'trim', explode( ',', $category ) );
        if ( count($category) == 1 ) $category = $category[0];
        $args['tax_query'] = array(
            array(
                'taxonomy' => $tax,
                'field' => 'slug',
                'terms' => $category
            )
        );
    }

	if ( $show == 'best_sellers' ) { // show best sellers products
        $query_args['meta_key'] = 'total_sales';
        $query_args['orderby'] = 'meta_value_num';
        $query_args['order'] = 'DESC';
    }

	$products = new WP_Query( $args );

	global $woocommerce_loop;
	$woocommerce_loop['loop'] = 0;
	if ( isset( $layout ) && $layout != 'default' ) $woocommerce_loop['layout'] = $layout;
	//$woocommerce_loop['columns'] = $columns;

	if ( $products->have_posts() ) : ?>

		<ul class="products show_products woocommerce">

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php woocommerce_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		</ul>

        <div class="clear"></div>
		<hr style="border:2px solid !important">

		<?php
        if( $pagination == 'yes' ) {
			yit_pagination( $products->max_num_pages );
        }
		?>

	<?php endif;

	wp_reset_query();

	$woocommerce_loop['loop'] = 0;
}
add_shortcode("show_products" , "je_show_products");

add_theme_support( 'post-thumbnails' );

add_action('init','override_cookie_time_recent_view');
function override_cookie_time_recent_view(){

	if(empty($_COOKIE['woocommerce_recently_viewed'])){
		return;
	}

	setcookie( 'woocommerce_recently_viewed', $_COOKIE['woocommerce_recently_viewed'], time() + (86400 * 7), COOKIEPATH, COOKIE_DOMAIN );

}

add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
	$ponesel = get_post_meta( $order->id, '_billing_mobile', true );
	if($ponesel != ''){
    	echo '<p><strong>'.__('Ponsel').':</strong> <br/>' . $ponesel . '</p>';
	}
}

#RADIRECT AFTER RESET PASSWORD
function woocommerce_new_pass_redirect( $user ) {
  wp_redirect( get_home_url());
  exit;
}
add_action( 'woocommerce_customer_reset_password', 'woocommerce_new_pass_redirect' );

#IF LOGIN FAILED
add_action( 'wp_login_failed', 'my_front_end_login_fail' );  // hook failed login
function my_front_end_login_fail( $username ) {
   add_action('wp_footer','if_login_failed');
}

function if_login_failed(){ ?>
	<style>
	.warning-login{
		background-color:#ED0003;
		color:#FFFFFF;
		padding:3px;
	}
	</style>
	<script>
	jQuery(document).ready(function(e) {
        jQuery('.headerMyAccount').addClass('open');
		jQuery(".nav-signin-tooltip-footer").append('<p class="warning-login">Username/Password salah.</p><a href="<?php echo wp_lostpassword_url(); ?>" title="Lost Password">Lost Password?</a>');
		jQuery("#my-account-link-header").attr('aria-expanded','true');
    });
	</script>
	<?php
}
add_action('woocommerce_after_add_to_cart_button','func_tanyakan_ke_pabrik',0);

function func_tanyakan_ke_pabrik($product){
	//if(!isset($_GET['t'])) return;
	require get_template_directory() . '/inc/tanyakan-ke-pabrik.php';
}
add_action('wp_ajax_tanya_ke_pabrik','tanya_ke_pabrik_response');
add_action('wp_ajax_nopriv_tanya_ke_pabrik','tanya_ke_pabrik_response');

function tanya_ke_pabrik_response(){
	$id  = $_POST['id'];
	$n   = $_POST['n'];
	$e   = $_POST['e'];
	$t   = $_POST['t'];
	$res = array('code'=> 0,'reason'=>'Terjadi kesalahan.');

	if($n == '' || $t == '' || $e == ''){
		$res['reason'] = 'Mohon isi data dengan lengkap.';
	}else if(!is_email($e)){
		$res['reason'] = 'Email tidak benar.';
	}else{
		if ( is_user_logged_in() ) {
			 $user_id = get_current_user_id();
			 $pernah_tanya = get_user_meta($user_id,  '_tanya_kepabrik', true );
			 if(!is_array($pernah_tanya)){
				$pernah_tanya = array();
			 }else{
				foreach($pernah_tanya as $k => $v){
					if($v == $id){
						unset($pernah_tanya[$k]);
					}
				}
			 }
			 $pernah_tanya[] = $id;
			 update_user_meta( $user_id, '_tanya_kepabrik', $pernah_tanya );
		}
		$url 		= get_permalink( $id );
		$to  		= get_option('admin_email');
		$subject 	= 'Permintaan tanya ke pabrik.';
		$headers  	= array('Content-Type: text/html; charset=UTF-8','From: '.$n.' <'.$e.'>');
		$body 		= "Produk yang di tanya ke pabrik: <a href='$url'>".get_the_title($id)."</a><br/>Nama: $n <br/> Email: $e <br/> Tlp: $t";
		//if($e != 'asep@jualelektronik.com'){
			wp_mail( $to, $subject, $body,$headers);
		//}
		$res['code'] 	= 1;
		$res['reason'] 	= 'Terima kasih, kami akan menghubungi Anda segera.';
	}
	echo json_encode($res);
	wp_die();
}

add_action('after_signin_menu_not_login','sign_in_menu');

function sign_in_menu(){
//if($_SERVER['REMOTE_ADDR'] == '182.253.32.106'){
	if(is_account_page()) return;
	include 'inc/popup-signin.php';
//}
}

add_filter( 'woo_breadcrumbs_trail', 'woo_custom_breadcrumbs_trail_single', 10, 1 );

function woo_custom_breadcrumbs_trail_single ( $trail ) {
    if ( ( get_post_type() == 'product' ) && is_singular() ) {
        // The ID of the page you want to add to the breadcrumb. Replace this with your own.
        $page_id = 2;

        // Get the page's title and permalink, and group them in an HTML anchor tag.
        $title = get_the_title( $page_id );
        $permalink = get_permalink( $page_id );
        $page_link = '<a href="' . $permalink . '" title="' . esc_attr( $title ) . '">' . $title . '</a>';

        // Add the new page link, and the original trail's end, back into the trail.
        array_splice( $trail, 1, count( $trail ) - 1, array( $page_link, $trail['trail_end'] ) );
    } // End IF Statement

    return $trail;
} // End woo_custom_breadcrumbs_trail_single

//adjust by limamultimedia
add_filter('term_link', 'lima_term_link_filter', 10, 3);
function lima_term_link_filter( $url, $term, $taxonomy ) {

   global $wpdb;

	if($taxonomy == 'product_cat'){

		$id = $term->term_id;
		$page_id = $wpdb->get_var("SELECT ID FROM ".$wpdb->posts." a LEFT JOIN ".$wpdb->postmeta." b ON a.ID=b.post_id
					WHERE a.post_status='publish' and meta_key='_my_meta_product_cat' and meta_value='".$id."' ORDER BY ID ASC LIMIT 1 ");
		if($page_id){

			$url = get_permalink($page_id);
		}else{

			if(!isset($_GET['xxxx'])){
				return $url;
			}

			$my_post = array(
			  'post_title'    =>  $term->name,
			  'post_status'   => 'publish',
			  'post_author'   => 1,
			  'post_type'	  => 'page'
			);

			// Insert the post into the database
			$page_id = wp_insert_post( $my_post );

			update_post_meta($page_id,'_my_meta_product_cat',$id);
			update_post_meta( $page_id, '_wp_page_template', 'template-product-cat.php' );

			$url = get_permalink($page_id);
		}
	}
    return $url;

}

 add_filter('loop_shop_columns', 'wc_product_columns_frontend');
function wc_product_columns_frontend() {
	global $woocommerce;

	// Default Value also used for categories and sub_categories
    $columns = 4;

	// Product List
    if ( is_product_category() ) :
    	$columns = 4;
	endif;

	//Related Products
    if ( is_product() ) :
    	$columns = 2;
	endif;

	//Cross Sells
    if ( is_checkout() ) :
    	$columns = 4;
    endif;

	return $columns;
}
function wc_ninja_remove_password_strength() {
	if ( wp_script_is( 'wc-password-strength-meter', 'enqueued' ) ) {
		wp_dequeue_script( 'wc-password-strength-meter' );
	}
}
add_action( 'wp_print_scripts', 'wc_ninja_remove_password_strength', 100 );



  class ip_address_memory_usage {

  var $memory = false;
  var $server_ip_address = false;

  public function __construct() {
     $this->memory = array();
    $this->memory['limit'] = (int) ini_get('memory_limit') ;
  }
    
  public function check_memory_usage() {
    $this->memory['usage'] = function_exists('memory_get_peak_usage') ? round(memory_get_peak_usage(TRUE) / 1024 / 1024, 2) : 0;      
    
    if ( !empty($this->memory['usage']) && !empty($this->memory['limit']) ) {
      $this->memory['percent'] = round ($this->memory['usage'] / $this->memory['limit'] * 100, 0);
      $this->memory['color'] = 'font-weight:normal;';
      if ($this->memory['percent'] > 75) $this->memory['color'] = 'font-weight:bold;color:#E66F00';
      if ($this->memory['percent'] > 90) $this->memory['color'] = 'font-weight:bold;color:red';
    }   
  }

  public function format_wp_limit( $size ) {
    $value  = substr( $size, -1 );
    $return = substr( $size, 0, -1 );

    $return = (int)$return; // Solved: PHP 7.1 Notice: A non well formed numeric value encountered 

    switch ( strtoupper( $value ) ) {
      case 'P' :
        $return*= 1024;
      case 'T' :
        $return*= 1024;
      case 'G' :
        $return*= 1024;
      case 'M' :
        $return*= 1024;
      case 'K' :
        $return*= 1024;
    }
    return $return;
  }  
  public function check_wp_limit() {
    $memory = $this->format_wp_limit( WP_MEMORY_LIMIT );
    $memory = size_format( $memory );
    return ($memory) ? $memory : __( 'N/A', 'server-ip-memory-usage' );
  }

  public function add_footer($content) {
    $this->check_memory_usage();
    //$server_ip_address = $_SERVER[ 'SERVER_ADDR' ];
    $server_ip_address = (!empty($_SERVER[ 'SERVER_ADDR' ]) ? $_SERVER[ 'SERVER_ADDR' ] : "");
    if ($server_ip_address == "") { // Added for IP Address in IIS
      $server_ip_address = (!empty($_SERVER[ 'LOCAL_ADDR' ]) ? $_SERVER[ 'LOCAL_ADDR' ] : "");
    }
    $content .= ' | ' . __( 'Memory', 'server-ip-memory-usage' ) . ': ' . $this->memory['usage'] . ' ' . __( 'of', 'server-ip-memory-usage' ) . ' ' . $this->memory['limit'] . ' MB (<span style="' . $this->memory['color'] . '">' . $this->memory['percent'] . '%</span>) | ' . __( 'WP LIMIT', 'server-ip-memory-usage' ) . ': ' . $this->check_wp_limit() . ' | IP ' . $server_ip_address . ' (' . gethostname() . ') | PHP ' . PHP_VERSION . ' @' . (PHP_INT_SIZE * 8) . 'BitOS';
    return $content;
  }

}

function your_function() {
    $memory = new ip_address_memory_usage();
print $memory->add_footer('Memory Testing');
}
//add_action( 'wp_footer', 'your_function', 100 );

/**
 * The Following code Done By Faysal Mahamud
 *
 * Todo
 *
 * @author 		Faysal Mahamud
 * @package 	https://www.linkedin.com/in/turjo
 * @version     faysal.turjo@gmail.com
 */
if ( ! function_exists( 'schema_org_markup' ) ) {
  function schema_org_markup($type = 'Product') {
  	$schema = 'http://schema.org/';
	
	  if($type == 'application'){
		$schema = "SoftwareApplication";
	  }elseif($type == 'MusicAlbum'){
	  	$schema = "MusicAlbum";
	  }else{
	  	$schema = $type;
	  }
    
	return 'http://schema.org/' . $schema;
  }
}  

function get_min_meta_value( ){
        global $wpdb;
        $result = $wpdb->get_var(" SELECT min(cast(meta_value as unsigned)) FROM `wp_postmeta` WHERE `meta_key` = '_price' AND `meta_value` <> '' ");
        return $result;
}

function get_max_meta_value( ){
        global $wpdb;
        $result = $wpdb->get_var("SELECT max(cast(meta_value as unsigned)) FROM wp_postmeta WHERE meta_key='_price'");
        return $result;
}


/**
 * The Following code Done By Asefur Mukti
 *
 * Todo
 *
 * @author 		Asefur Mukti
 * @package 	https://www.linkedin.com/in/asefur-mukti-03660985/
 * @version     asefurmukti@gmail.com
 */
add_action('init', 'update_status_orderan');
function update_status_orderan(){

	//if (strpos($_SERVER['REQUEST_URI'], 'update_status_orderan') !== false) {

		//echo '<pre>';
		global $wpdb;

		$Date = date('Y-m-d');
		$mundur_3hari = date('Y-m-d', strtotime($Date. ' - 3 day'));

		$query = "SELECT a.ID FROM wp_posts a WHERE DATE(a.post_date) < '$mundur_3hari' AND a.post_type='shop_order' 
			AND a.post_status='wc-on-hold'";
		$results = $wpdb->get_results( "$query", OBJECT );

		foreach ($results as $key => $post) {
			// $query = "UPDATE {$wpdb->prefix}posts SET post_status='wc-cancelled' WHERE ID='{$post->ID}'";

			$wpdb->update( 
				"{$wpdb->prefix}posts", 
				array( 
					'post_status' => 'wc-cancelled',	// string
					// 'column2' => 'value2'	// integer (number) 
				), 
				array( 'ID' => $post->ID ), 
				array( 
					'%s',	// value1
					// '%d'	// value2
				), 
				array( '%d' ) 
			);
		}
		//print_r($mundur_3hari);
		//print_r($results);
	    //exit;
	//}
}


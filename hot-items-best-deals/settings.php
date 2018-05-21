<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

//Register options of this plugin
add_action('admin_init', 'hot_items_best_deals_settings');
//Use default woocommerce stylesheet
$stylefile = plugins_url() . '/woocommerce/assets/css/woocommerce.scss';
if (file_exists($stylefile)) {
    wp_enqueue_style('woocommerce-style', $stylefile);
}

//Set up menu under woocommerce
add_action('admin_menu', 'hot_items_best_deals_setup_menu');
function hot_items_best_deals_setup_menu()
{
    add_submenu_page('je_theme', 'Hot Items & Best Deals', 'Hot Items & Best Deals', 'manage_options', 'hot-items-best-deals-settings', 'admin_hot_items_best_deals_init');
}

//START remove default text for plugins/themes
if (!function_exists('dashboard_footer')) {
    function dashboard_footer(){ }
}
add_filter('admin_footer_text', 'dashboard_footer');
function remove_footer() {
    remove_filter( 'update_footer', 'core_update_footer' );
}
add_action( 'admin_menu', 'remove_footer' );
//END remove default text for plugins/themes


/**
 * Initialize the plugin and display all options at admin side
 */
function admin_hot_items_best_deals_init()
{


    ?>
    <style>
        .select2-container .select2-choice > .select2-chosen {
            white-space: normal !important;
        }
    </style>
    <div class="updated fade" id="update_notification" style="visibility: hidden"><p>Updated</p></div>
    <h1>Hot Items & Best Deals</h1>
    <?php
    wp_enqueue_script('wc-enhanced-select');
    wp_enqueue_style('woocommerce_admin_styles', WC()->plugin_url() . '/assets/css/admin.css', array(), WC_VERSION);

    ?>
    <script src="<?php echo get_template_directory_uri() . '/hot-items-best-deals/settings.js'?>"></script>

    <form method="post" action="options.php">
        <?php settings_fields('hot-items-best-deals-settings'); ?>
        <?php do_settings_sections('hot-items-best-deals-settings'); ?>
        <?php

        $options = array('hot_items_1','hot_items_2','hot_items_3','hot_items_4','best_deals_1','best_deals_2','best_deals_3','best_deals_4');
        $regular_price_names = array('_regular_price_hi_1','_regular_price_hi_2','_regular_price_hi_3','_regular_price_hi_4','_regular_price_bd_1','_regular_price_bd_2','_regular_price_bd_3','_regular_price_bd_4');
        $sale_price_names = array('_sale_price_hi_1','_sale_price_hi_2','_sale_price_hi_3','_sale_price_hi_4','_sale_price_bd_1','_sale_price_bd_2','_sale_price_bd_3','_sale_price_bd_4');
        $sale_price_label_names = array('_sale_price_label_hi_1','_sale_price_label_hi_2','_sale_price_label_hi_3','_sale_price_label_hi_4','_sale_price_label_bd_1','_sale_price_label_bd_2','_sale_price_label_bd_3','_sale_price_label_bd_4');
        $products = array();
        $products_ids = array();
        $regular_prices = array();
        $sale_prices = array();
        $sale_percentages = array();

        foreach($options as $option){
            $product_id = get_option($option);

            if (empty($product_id) || $product_id == 'undefined'){
                $product = '';
                $regular_price = '';
                $sale_price = '';
                $sale_percentage = 0;
            }
            else {
                $product = wc_get_product(get_post($product_id));

                $regular_price = get_post_meta($product_id, '_regular_price');
                $sale_price = get_post_meta($product_id, '_sale_price');
                if ($regular_price) $regular_price = $regular_price[0];
                if ($sale_price) $sale_price = $sale_price[0];

                $sale_percentage = 0;
                if ($regular_price && $sale_price) {
                    $sale_percentage = ($regular_price - $sale_price) / $regular_price;
                    $sale_percentage = round($sale_percentage * 100, 2);
                }
            }

            array_push($products_ids, $product_id);
            array_push($products, $product);
            array_push($regular_prices, $regular_price);
            array_push($sale_prices, $sale_price);
            array_push($sale_percentages, $sale_percentage);
        }
    echo '';

        ?>
        <table class="form-table">

            <tr valign="top">
                <th style="width: 10%;" scope="row">Hot Items:</th>
                <?php for ($i = 0; $i < 4; $i++) { ?>
                <td style="width: 22.5%;" >
                    <input type="hidden" class="wc-product-search" id="<?php echo $options[$i]; ?>" name="<?php echo $options[$i]; ?>"
                           data-placeholder="<?php _e('Search for a product&hellip;', 'woocommerce'); ?>"
                           data-action="woocommerce_json_search_products" data-multiple="false"
                           data-selected="<?php if(!empty($products[$i]) ) echo $products[$i]->get_formatted_name(); ?>" value="<?php if(!empty($products_ids[$i]) ) echo $products_ids[$i]; ?>"/>
                </td>
                <?php } ?>
            </tr>
            <tr>
                <th scope="row">Regular Price (<?php echo get_woocommerce_currency_symbol(); ?>)</th>
                <?php for ($i = 0; $i < 4; $i++) { ?>
                <td>
                    <input class="short wc_input_price" style="" name="<?php echo $regular_price_names[$i] ?>" id="<?php echo $regular_price_names[$i] ?>" value="<?php echo $regular_prices[$i]; ?>" placeholder="" type="text">
                    <div class="spinner"></div>
                </td>
                <?php } ?>
            </tr>
            <tr>
                <th scope="row">Sale Price (<?php echo get_woocommerce_currency_symbol(); ?>)</th>
                <?php for ($i = 0; $i < 4; $i++) { ?>
                <td>
                    <input class="short wc_input_price" style="" name="<?php echo $sale_price_names[$i] ?>" id="<?php echo $sale_price_names[$i] ?>" value="<?php echo $sale_prices[$i]; ?>" placeholder="" type="text">
                    <div class="spinner"></div>
                    <br/><label>Sale (<span id="<?php echo $sale_price_label_names[$i] ?>"><?php echo $sale_percentages[$i]; ?></span>%)</label>
                </td>
                <?php } ?>
            </tr>

            <tr valign="top">
                <th style="width: 10%;" scope="row">Best Deals:</th>
                <?php for ($i = 4; $i < 8; $i++) { ?>
                    <td style="width: 22.5%;" >
                        <input type="hidden" class="wc-product-search" id="<?php echo $options[$i]; ?>" name="<?php echo $options[$i]; ?>"
                               data-placeholder="<?php _e('Search for a product&hellip;', 'woocommerce'); ?>"
                               data-action="woocommerce_json_search_products" data-multiple="false"
                               data-selected="<?php if(!empty($products[$i]) ) echo $products[$i]->get_formatted_name(); ?>" value="<?php if(!empty($products_ids[$i]) ) echo $products_ids[$i]; ?>"/>
                    </td>
                <?php } ?>
            </tr>
            <tr>
                <th scope="row">Regular Price (<?php echo get_woocommerce_currency_symbol(); ?>)</th>
                <?php for ($i = 4; $i < 8; $i++) { ?>
                    <td>
                        <input class="short wc_input_price" style="" name="<?php echo $regular_price_names[$i] ?>" id="<?php echo $regular_price_names[$i] ?>" value="<?php echo $regular_prices[$i]; ?>" placeholder="" type="text">
                        <div class="spinner"></div>
                    </td>
                <?php } ?>
            </tr>
            <tr>
                <th scope="row">Sale Price (<?php echo get_woocommerce_currency_symbol(); ?>)</th>
                <?php for ($i = 4; $i < 8; $i++) { ?>
                    <td>
                        <input class="short wc_input_price" style="" name="<?php echo $sale_price_names[$i] ?>" id="<?php echo $sale_price_names[$i] ?>" value="<?php echo $sale_prices[$i]; ?>" placeholder="" type="text">
                        <div class="spinner"></div>
                        <br/><label>Sale (<span id="<?php echo $sale_price_label_names[$i] ?>"><?php echo $sale_percentages[$i]; ?></span>%)</label>
                    </td>
                <?php } ?>
            </tr>
        </table>
        <div class="submit" style="float:left;"><input name="submit" id="submit" class="button button-primary" value="Save Changes" type="button"/><div class="spinner"></div></div>
        </div>
    </form>

<?php
}

/**
 * Registers all the setting options
 */
function hot_items_best_deals_settings()
{
    register_setting('hot-items-best-deals-settings', 'hot_items_1');
    register_setting('hot-items-best-deals-settings', 'hot_items_2');
    register_setting('hot-items-best-deals-settings', 'hot_items_3');
    register_setting('hot-items-best-deals-settings', 'hot_items_4');
    register_setting('hot-items-best-deals-settings', 'best_deals_1');
    register_setting('hot-items-best-deals-settings', 'best_deals_2');
    register_setting('hot-items-best-deals-settings', 'best_deals_3');
    register_setting('hot-items-best-deals-settings', 'best_deals_4');

}
function calculate_sale_percentage($regular_price, $sale_price){
  
    $sale_percentage = 0;
    if (!empty($regular_price) && !empty($sale_price)) {
        $sale_percentage = ($regular_price - $sale_price) / $regular_price;
        $sale_percentage = round($sale_percentage * 100, 0);
    }
    return $sale_percentage;
}

//START ajax call
function update_hot_items_best_deals(){
    for ($i = 1; $i < 5; $i++) {
        update_product(("hot_items_".$i), ("_regular_price_hi_".$i), ("_sale_price_hi_".$i));
        update_product(("best_deals_".$i), ("_regular_price_bd_".$i), ("_sale_price_bd_".$i));
    }
};
function update_product($post_id_name, $regular_price, $sale_price){
    $post_id = $_GET[$post_id_name];
    $regular_price = $_GET[$regular_price];
    $sale_price = $_GET[$sale_price];
    if( !empty($post_id_name) && $post_id_name!='undefined'){
        update_option($post_id_name, $post_id);
        update_post_meta($post_id, '_regular_price', $regular_price);
        update_post_meta($post_id, '_sale_price', $sale_price);
    }
};
add_action('wp_ajax_update_hot_items_best_deals', 'update_hot_items_best_deals');

function get_product_price(){
    $post_id = $_GET["post_id"];
  $AliasMeta = get_post_meta($post_id, '_regular_price');
    $regular_price = $AliasMeta[0];
  $AliasMeta = get_post_meta($post_id, '_sale_price');
    $sale_price = $AliasMeta[0];
    $data = array('_regular_price'=>$regular_price, '_sale_price'=>$sale_price);
    $a = json_encode($data);
    echo json_encode($data);
};
add_action('wp_ajax_get_product_price', 'get_product_price');

//END ajax call

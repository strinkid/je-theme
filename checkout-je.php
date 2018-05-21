<?php
//add_action('wp_enqueue_scripts', 'override_woo_frontend_scripts');
function override_woo_frontend_scripts()
{
    $assets_path = str_replace(array('http:', 'https:'), '', WC()->plugin_url()) . '/assets/';
    $frontend_script_path = $assets_path . 'js/frontend/';

    wp_deregister_script('wc-checkout');
    //wp_deregister_script('wc-country-select');
    //wp_register_script( 'wc-country-select', $frontend_script_path . 'country-select.js', array('jquery') );
    wp_enqueue_script('wc-checkout', get_template_directory_uri() . '/js/checkout.js', array('jquery', 'woocommerce', 'wc-country-select', 'wc-address-i18n'), null, true);
}

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields($fields)
{
    $fields['billing']['billing_mobile'] = array(
        'label' => __('Mobile', 'woocommerce'),
        'placeholder' => _x('Mobile', 'placeholder', 'woocommerce'),
        'required' => true,
        'class' => array('form-row-wide'),
        'clear' => true
    );
    $fields['billing']['billing_payment_method_bank_name'] = array(
        'label' => __('Bank Name', 'woocommerce'),
        'placeholder' => _x('Bank Name', 'placeholder', 'woocommerce'),
        'required' => false,
        'class' => array('form-row-wide'),
        'clear' => true
    );
    $fields['billing']['billing_payment_method_account_name'] = array(
        'label' => __('Bank Name', 'woocommerce'),
        'placeholder' => _x('Bank Name', 'placeholder', 'woocommerce'),
        'required' => false,
        'class' => array('form-row-wide'),
        'clear' => true
    );
    $fields['billing']['billing_gender'] = array(
        'label' => __('Account Name', 'woocommerce'),
        'placeholder' => _x('Account Name', 'placeholder', 'woocommerce'),
        'required' => false,
        'class' => array('form-row-wide'),
        'clear' => true
    );

    return $fields;
}

add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');


function woo_custom_checkout_button_text()
{
    $checkout_url = wc_get_checkout_url();

    ?>
    <a href="<?php echo $checkout_url; ?>" class="checkout-button button alt wc-forward"><?php _e('LANJUT KE PEMBAYARAN', 'woocommerce'); ?></a><?php
}

remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
add_action('woocommerce_proceed_to_checkout', 'woo_custom_checkout_button_text');

function getShippingFeeJe()
{
    $shippingFee = 0;

    $packages = WC()->shipping->get_packages();
    foreach ($packages as $i => $package) {
        $chosen_method = isset(WC()->session->chosen_shipping_methods[$i]) ? WC()->session->chosen_shipping_methods[$i] : '';
        if ( 1 === count( $package['rates'] ) ) {
            $shippingFee = $package['rates'][0]->cost;
        }
        else if (0 === count( $package['rates'] )){

        }
        else{
            foreach ($package['rates'] as $method) {
            if ($chosen_method == $method->id){
                    $shippingFee = $method->cost;
                }
            }
        }
    }
    echo '<span class="amount">' . getCurrencyDisplay($shippingFee) . '</span>';
}

function getValueFromCheckoutPostData($post_data, $key){
    $value = '';
    if (isset($post_data)){
        $post_data = explode('&', $post_data);
        foreach ($post_data as $data){
            if (strpos($data, $key) !== false){
                $value = substr($data, strpos($data, '=') + 1, strlen($data) );
            }
        }
    }
    return $value;
}

function wpmu_validate_user_signup($user_email=''){
    global $wpdb;
    $email = isset($_POST['email']) ? $_POST['email'] : $user_email;
    $check = $wpdb->get_var("select count(user_email) from wp_users where user_email = '$email'");
    
    $regAlready = "email sudah terdaftar";
    $success = "ok";

    $regArr = array(
        'regAlready' => 'email sudah terdaftar',
        'success' => 'ok',
    );


    if($check > 0){
        // echo $regAlready;
        echo json_encode($regArr['regAlready']);
    }else
    {
        // echo $success;
        echo json_encode($regArr['success']);
    }
    die();
}
add_action('wp_ajax_wpmu_validate_user_signup' , 'wpmu_validate_user_signup');
add_action('wp_ajax_nopriv_wpmu_validate_user_signup','wpmu_validate_user_signup');

// function email_check(){
    
//     global $wpdb;



//     $email = $_POST['email'];
//     if(email_exists($email)){
//         echo "data eksis";
        
//     }else{
//         echo "sukes";
//     }
//     die();
//     // echo "test";
//     // die();
// };
// add_action('wp_ajax_email_check' , 'email_check');
// add_action('wp_ajax_nopriv_email_check','email_check');

function my_custom_checkout_field_update_order_meta( $order_id ) {
    global $current_user;
    $user = wp_get_current_user();
    if ( ! empty( $_POST['billing_mobile'] ) ) {
        update_user_meta( $current_user->ID, 'billing_mobile', sanitize_text_field( $_POST['billing_mobile'] ) );
        update_post_meta( $order_id, '_billing_mobile', sanitize_text_field( $_POST['billing_mobile'] ) );
    }
    if ( ! empty( $_POST['billing_payment_method_bank_name'] ) ) {
        update_user_meta( $current_user->ID, 'billing_payment_method_bank_name', sanitize_text_field( $_POST['billing_payment_method_bank_name'] ) );
        update_post_meta( $order_id, '_billing_payment_method_bank_name', sanitize_text_field( $_POST['billing_payment_method_bank_name'] ) );
    }
    if ( ! empty( $_POST['billing_payment_method_account_name'] ) ) {
        update_user_meta( $current_user->ID, 'billing_payment_method_account_name', sanitize_text_field( $_POST['billing_payment_method_account_name'] ) );
        update_post_meta( $order_id, '_billing_payment_method_account_name', sanitize_text_field( $_POST['billing_payment_method_account_name'] ) );
    }
    if ( ! empty( $_POST['billing_gender'] ) ) {
        update_user_meta( $current_user->ID, 'billing_gender', sanitize_text_field( $_POST['billing_gender'] ) );
        update_post_meta( $order_id, '_billing_gender', sanitize_text_field( $_POST['billing_gender'] ) );
    }
}
add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );


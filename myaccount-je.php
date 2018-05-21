<?php
function createCustomer() {
    if(!is_user_logged_in() && isset($_POST['bikin-akun'])){
        $username = $_POST['registerAccountName'];
        $password = $_POST['registerPassword'];
        $email    = $_POST['email'];
        $new_customer = wc_create_new_customer( sanitize_email( $email ), wc_clean( $username ), $password );

        update_user_meta($new_customer, 'first_name', $_POST['billing_first_name']);
        update_user_meta($new_customer, 'last_name', $_POST['billing_last_name']);

        foreach($_POST as $key=>$value){
            if (strpos($key, 'billing_') == 0 || strpos($key, 'shipping_')== 0)
                update_user_meta($new_customer, $key, $value);
        }

        if ( is_wp_error( $new_customer ) ) {
            throw new Exception( $new_customer->get_error_message() );
        }
        if ( apply_filters( 'woocommerce_registration_auth_new_customer', true, $new_customer ) ) {
            wc_set_customer_auth_cookie( $new_customer );
        }
    }
}
add_action('woocommerce_checkout_process', 'createCustomer', 99);

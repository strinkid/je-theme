<?php

function optimizeComparePageScripts(){
    $scriptNameList = array(
        "contact-form-7",
        "wc-add-to-cart",
        "wc-cart-fragments",
        "yith-woocompare-main",
        "jquery-colorbox",
        "wc-checkout",
        "masterslider-core",
        "woof_front",
        "woof_radio_html_items",
        "woof_checkbox_html_items",
        "woof_color_html_items",
        "woof_select_html_items",
        "woof_mselect_html_items",
        "chosen-drop-down",
        "mousewheel",
        "malihu-custom-scrollbar",
        "malihu-custom-scrollbar-concat",
        "jquery-ui-core",
        "jquery-ui-slider",
        "wc-jquery-ui-touchpunch",
        "wc-price-slider");
    optimizeScripts($scriptNameList);

}

function optimizeCheckoutPageScripts(){
    $scriptNameList = array(
        "wc-country-select",
        "contact-form-7",
        "wc-add-to-cart",
        "wc-cart-fragments",
        "yith-woocompare-main",
        "masterslider-core",
        "woof_front",
        "woof_radio_html_items",
        "woof_checkbox_html_items",
        "woof_color_html_items",
        "woof_select_html_items",
        "woof_mselect_html_items",
        "chosen-drop-down",
        "mousewheel",
        "malihu-custom-scrollbar",
        "malihu-custom-scrollbar-concat",
        "wc-jquery-ui-touchpunch",
        "wc-price-slider");
    optimizeScripts($scriptNameList);
}

function optimizeCartPageScripts(){
    $scriptNameList = array(
        "contact-form-7",
        "yith-woocompare-main",
        "jquery-colorbox",
        "wc-checkout",
        "masterslider-core",
        "woof_front",
        "woof_radio_html_items",
        "woof_checkbox_html_items",
        "woof_color_html_items",
        "woof_select_html_items",
        "woof_mselect_html_items",
        "chosen-drop-down",
        "mousewheel",
        "malihu-custom-scrollbar",
        "malihu-custom-scrollbar-concat",
        "jquery-ui-core",
        "jquery-ui-slider",
        "wc-jquery-ui-touchpunch",
        "wc-price-slider");
    optimizeScripts($scriptNameList);
}

function optimizeShopPageScripts(){
    $scriptNameList = array(
        "contact-form-7",
        "mousewheel",
        "malihu-custom-scrollbar",
        "malihu-custom-scrollbar-concat",
        "jquery-ui-core",
        "jquery-ui-slider",
        "wc-jquery-ui-touchpunch",
        "chosen-drop-down"
    );
    optimizeScripts($scriptNameList);
}

function optimizeHomePageScripts(){
    $scriptNameList  = array(
        "woof_front",
        "woof_radio_html_items",
        "woof_checkbox_html_items",
        "woof_color_html_items",
        "woof_select_html_items",
        "woof_mselect_html_items",
        "contact-form-7",
        "yith-woocompare-main",
        "jquery-colorbox",
        "wc-checkout",
        "chosen-drop-down",
        "malihu-custom-scrollbar",
        "malihu-custom-scrollbar-concat",
        "wc-price-slider",
        "wc-cart-fragments",
        "wc-add-to-cart"
        );
    optimizeScripts($scriptNameList);
}

function optimizeMyAccountPageScripts(){
    $scriptNameList = array(
            "yith-woocompare-main",
            "woof_front",
            "woof_radio_html_items",
            "woof_checkbox_html_items",
            "woof_color_html_items",
            "woof_select_html_items",
            "woof_mselect_html_items",
            "contact-form-7",
            "jquery-colorbox",
            "wc-add-to-cart",
            "mousewheel",
            "wc-price-slider",
            "malihu-custom-scrollbar",
            "malihu-custom-scrollbar-concat",
            "chosen-drop-down",
            "wc-jquery-ui-touchpunch"

        );
    optimizeScripts($scriptNameList);
}

function optimizeMyAccountOnLoginPageScripts(){
        $scriptNameList = array(
            "contact-form-7",
            "wc-add-to-cart",
            "wc-cart-fragments",
            "yith-woocompare-main",
            "woof_front",
            "woof_radio_html_items",
            "woof_checkbox_html_items",
            "woof_color_html_items",
            "woof_select_html_items",
            "woof_mselect_html_items",
            "chosen-drop-down",
            "mousewheel",
            "malihu-custom-scrollbar",
            "malihu-custom-scrollbar-concat",
            "jquery-ui-core",
            "jquery-ui-slider",
            "wc-jquery-ui-touchpunch",
            "wc-price-slider"
            );

    optimizeScripts($scriptNameList);
}


function optimizeScripts($scriptNameList){
    foreach($scriptNameList as $scriptName){
        wp_dequeue_script( $scriptName );
    }
}
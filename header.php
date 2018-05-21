<?php
 add_action('wp_enqueue_scripts','load_basic_je_scripts');
 function load_basic_je_scripts(){
wp_enqueue_script('jquery');
//wp_enqueue_script('jquery.1.11.3', get_template_directory_uri() . '/js/jquery.min.js', array(), '1.11.3', 'all');
wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '3.3.4', true);
wp_enqueue_script('jquery.aim', get_template_directory_uri() . '/js/jquery.menu-aim.js', array('jquery'), '1.70', true);
wp_enqueue_script('je.jquery.aim', get_template_directory_uri() . '/js/je.jquery.menu-aim.js', array('jquery'), '1.70', true);
 }
?>
<html>
<head>
    <title>Jual Elektronik</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	

    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.png" />
    
    <?php wp_head(); ?>
</head>
<body>

<!-- Facebook Login -->
<script>
var $ = jQuery;
    /*window.fbAsyncInit = function () {
        FB.init({
            appId: '532584946895931',
            xfbml: true,
            version: 'v2.4'
        });
    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));*/
</script>
<!-- End Script -->
<script src="<?php echo site_url(); ?>/wp-content/themes/je-theme/js/jquery.min.js?ver=1.11.3"></script>

<!-- Start Show Opened Dropdown on Homepage Only -->
<?php
if (is_front_page()) { ?>
    <script type="text/javascript">
        $(document).ready(function () {

			if(jQuery('body').width()>=1000) {
				$('#topHeader').show();
				$("li.dropdown.headerCategory").addClass("open");
				$("#dropdown-toggle-shopCategory").removeAttr("data-toggle");
			}


            $(".dropdown-menu").mouseleave(function () {
                $(".popover").hide();
                $(".dropdown-toggle").removeClass("maintainHover");
                $("#keluargaDapur").hide();
            });

            // $(".subMenuClass").mouseenter(function(){
            // 	$(this).each(function(){
            // 		// console.log($(this).find("data-submenu-id"));
            // 	});
            // });
        });
    </script>
<?php
} else {

}
?>
<!-- End Script -->

<!-- Start Mouse Leave Popover -->
<?php
if (!is_front_page()) { ?>
    <script type="text/javascript">

        $(document).ready(function () {
            $('#topHeader').hide();


            /*$("#dropdown-toggle-shopCategory")
                .mouseenter(function () {
                    clearTimeout($(this).data('timeoutId'));
                    enablePopOver();
                })
                .mouseleave(function () {
                    var someElement = $(this),
                        timeoutId = setTimeout(function () {
                            disablePopOver();
                        }, 650);
                    someElement.data('timeoutId', timeoutId);
                });
            $(".dropdown-menu")
                .mouseenter(function () {
                    clearTimeout($("#dropdown-toggle-shopCategory").data('timeoutId'));
                    enablePopOver();
                })
                .mouseleave(function () {
                    var someElement = $("#dropdown-toggle-shopCategory"),
                        timeoutId = setTimeout(function () {
                            disablePopOver();
                        }, 650);
                    someElement.data('timeoutId', timeoutId);
                });*/

            $("#shopByCategory").mouseenter(function () {
                enablePopOver();
            });
            $("#shopByCategory").mouseleave(function () {
                disablePopOver();
            });

        });

        function enablePopOver() {
            $("li.dropdown.headerCategory").addClass("open");
        }
        function disablePopOver() {
            $("li.dropdown.headerCategory").removeClass("open");
            $(".popover").hide();
            $(".dropdown-toggle").removeClass("maintainHover");
        }
    </script>
<?php
}
?>


<!-- END Script -->

<div id="wrapper">
    <div id="header">
        <!-- <div id="topHeader">
            <div class="container">
                <div class="row">
                    <div class="top-info col-sm-3">
                        <a href="<?php //echo esc_url(get_theme_mod('je_1stUrl')); ?>"><img src="<?php //echo esc_url(get_theme_mod('je_1stImg')); ?>"/></a>
                    </div>
                    <div class="top-info col-sm-3">
                        <a href="<?php //echo esc_url(get_theme_mod('je_2ndUrl')); ?>"><img src="<?php //echo esc_url(get_theme_mod('je_2ndImg')); ?>"/></a>
                    </div>
                    <div class="top-info col-sm-3">
                        <a href="<?php //echo esc_url(get_theme_mod('je_3rdUrl')); ?>"><img src="<?php //echo esc_url(get_theme_mod('je_3rdImg')); ?>"/></a>
                    </div>
                    <div class="top-info col-sm-3">
                        <a href="<?php //echo esc_url(get_theme_mod('je_VoucherUrl')); ?>"><img src="<?php //echo esc_url(get_theme_mod('je_VoucherImg')); ?>"/></a>
                    </div>
                </div>
            </div>
        </div> -->
        <div id="midHeader">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 text-center">
						<!-- Mobile Nav Icon -->
						<a href="javascript:;" class="icon-menu" style="display:none;"><i class="fa fa-bars fa-2x"></i></a>
						<!-- End Mobile-->
                        <a href="<?php echo get_site_url(); ?>" id="image-logo">
                            <img class="headerImage" src="<?php echo esc_url(get_theme_mod('je_logo')); ?>"/>
                        </a>
                    </div>

                    <div class="col-md-8">
                        <div style="padding-top: 12px;">
                            <?php displaySearchForm(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="searchHeader">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 je-menu-category">
                        <?php displayShopByCategoryMenu(); ?>
                    </div>
                    <div class="col-md-9">
                        <div class="cartNavBar">
                        <div class="navbar-collapse" id="myNavbar">

                            <ul class="nav navbar-nav">
                                <li class="dropdown headerStatusOrder">
                                    <a id="status-order-link" class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="midHeader-font">Order Status</span></a>
                                    <ul class="dropdown-menu dropdown-rightForm">
                                        <div class="dropdown-title">Cek status pesanan Anda</div>
                                        <form action="/order-tracking/" method="post" class="track_order" id="form-track-order">
                                            <div id="box-order">
                                                <div id="order-id">
                                                    <span>Order Number</span>
                                                    <input class="input-text" name="orderid" id="orderid" placeholder="" type="text" style="border-radius:3px !important; position:relative!important;left:-5px!important;box-sizing:border-box!important;outline:0!important;border:1px solid rgba(0,0,0,0.5)!important;">
                                                </div>

                                                <div id="order-email">
                                                    <span> Email Address</span>
                                                    <input class="input-text" name="order_email" id="order_email" placeholder="" type="text" style="border-radius:3px !important; position:relative!important;left:-5px!important;box-sizing:border-box!important;outline:0!important;border:1px solid rgba(0,0,0,0.5)!important;">
                                                </div>
                                            </div>
                                            <div class="clear"></div>

                                            <!-- <p class="form-row"><input class="button" name="track" value="CHECK" type="submit"></p> -->

                                            <div class="FormHeaderButton">
                                                <input class="button-FormHeader" name="track" value="CHECK" type="submit">
                                                <!-- <i class="fa fa-check-square-o"></i> -->
                                            </div>
                                            <?php wp_nonce_field('woocommerce-order_tracking'); ?>
                                        </form>
                                    </ul>
                                </li>
                                <?php if (is_user_logged_in()) { ?>
                                    <li class="dropdown headerMyAccount">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="midHeader-font">Hello, <?php echo ucfirst(wp_get_current_user()->display_name); ?></span>
                                            <span class="caret"></span>
											<?php do_action('my_saldo_affiliate'); ?>
                                        </a>
                                        <ul class="dropdown-menu dropdown-rightForm">
                                            <li><a class="my-account-menu" href="/my-account/">My Account</a></li>
											<?php if(function_exists('affiliate_menu')) { 
													//ob_start(); 
													echo affiliate_menu();
													//return ob_get_clean();
											} ?>
											<li><a class="my-account-menu" href="/my-account/">Order List</a></li>

                                            <li><a class="my-account-menu" href="/my-account/customer-logout/">Logout</a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php } else { ?>
                                    <li class="dropdown headerMyAccount">
                                        <a id="my-account-link-header" class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="midHeader-font">Sign In</span></a>
                                        <?php do_action('after_signin_menu_not_login'); ?>
                                        <ul class="dropdown-menu dropdown-rightForm">
                                            <form method="post" class="login" id="form-my-account">
                                                <div id="box-order">
                                                    <div class="box-login-error" style="color:red;">
                                                        <?php //wc_print_notices(); ?>
                                                        <?php do_action('woocommerce_before_customer_login_form'); ?>
                                                    </div>
                                                    <div id="order-id">
                                                        <span class="homeLoginLabel">Email or Username</span>
                                                        <input class="input-text" name="username" id="username" placeholder="" type="text" value="<?php if (!empty($_POST['username'])) echo esc_attr($_POST['username']); ?>" style="border-radius:3px !important; position:relative!important;left:-5px!important;box-sizing:border-box!important;outline:0!important;border:1px solid rgba(0,0,0,0.5)!important;margin-bottom:15px!important;">
                                                    </div>

                                                    <div id="order-email">
                                                        <span class="homeLoginLabel">Password</span>
                                                        <input class="input-text" name="password" id="order_email" placeholder="" type="password" style="border-radius:3px !important; position:relative!important;left:-5px!important;box-sizing:border-box!important;outline:0!important;border:1px solid rgba(0,0,0,0.5)!important;margin-bottom:15px!important;">
                                                    </div>
                                                </div>
                                                <div class="clear"></div>

                                                <!-- <p class="form-row"><input class="button" name="login" value="LOGIN" type="submit"></p> -->
                                                <div class="FormHeaderButton">
                                                    <input class="button-FormHeader" name="login" value="LOGIN" type="submit">
                                                    <i class="fa fa-sign-in"></i>
                                                </div>
                                                <div class="nav-signin-tooltip-footer">New customer? <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="nav-a">Start here.</a></div>
                                                <?php wp_nonce_field('woocommerce-login'); ?>
                                                <?php do_action('woocommerce_login_form_end'); ?>
                                            </form>
                                        </ul>
                                    </li>
                                <?php }; ?>

								<li>
									 <div id="cartContainer">
										<a href="<?php echo wc_get_cart_url(); ?>" style="float:right !important;">
											<div>
												<img class="img-responsive" src="<?php echo get_template_directory_uri() ?>/img/cart.png"/>
											</div>
											<div class="cartBubble">
												<?php echo sprintf(_n('%d', '%d', WC()->cart->cart_contents_count), WC()->cart->cart_contents_count); ?>
											</div>
											<div>Cart</div>
										</a>
									</div>
								</li>

                            </ul>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("li.shopcategory-list").mouseenter(function(){
                $("li.shopcategory-list").addClass("shopCategory-hover");
            });
            $("li.shopcategory-list").mouseleave(function(){
                $("li.shopcategory-list").removeClass("shopCategory-hover");
            });
        });
    </script> -->

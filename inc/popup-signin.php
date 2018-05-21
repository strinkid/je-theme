<style>
.drop-saya{
	background-color:#FFFFFF;
	display:block;
	position:absolute;
	top:9px;
	left:-40px;
	margin-top:20px;
	width:164px;;
	z-index:1500;
	border:1px solid #bbb;
	color:#333;
	border-radius:3px;
	padding:14px;
}
.drop-saya .arrow-top{
	top:-20px;
	position:absolute;
	left:70px;
}
.nav-action-button, .nav-action-button:link {
    display: block;
    height: 33px;
    margin: 0 10px 0 11px;
    cursor: pointer;
    outline: 0;
    border: 1px solid;
    border-color: #c89411 #b0820f #99710d;
    -webkit-border-radius: 3px 3px 3px 3px;
    -moz-border-radius: 3px 3px 3px 3px;
    border-radius: 3px 3px 3px 3px;
    border-radius: 0\9;
    -webkit-box-shadow: inset 0 1px 0 0 #fcf3dc;
    -moz-box-shadow: inset 0 1px 0 0 #fcf3dc;
    box-shadow: inset 0 1px 0 0 #fcf3dc;
    background: #f3ce72;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFF8E3AD', endColorstr='#FFEEBA37', GradientType=0);
    background: linear-gradient(to bottom,#f8e3ad,#eeba37);
    background: -moz-linear-gradient(top,#f8e3ad,#eeba37);
    background: -webkit-linear-gradient(top,#f8e3ad,#eeba37);
    background: -o-linear-gradient(top,#f8e3ad,#eeba37);
    background: -ms-linear-gradient(top,#f8e3ad,#eeba37);
    text-align: center;
    line-height: 31px;
    vertical-align: middle;
    color: #111 !important;
    font-family: arial,sans-serif;
    text-decoration: none;
    line-height: 30px;
    font-size: 13px;
}
.nav-action-button:hover {
    background: #f1c65a;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFF6DA95', endColorstr='#FFECB21F', GradientType=0);
    background: linear-gradient(to bottom,#f6da95,#ecb21f);
    background: -moz-linear-gradient(top,#f6da95,#ecb21f);
    background: -webkit-linear-gradient(top,#f6da95,#ecb21f);
    background: -o-linear-gradient(top,#f6da95,#ecb21f);
    background: -ms-linear-gradient(top,#f6da95,#ecb21f);
    text-decoration: none;
}
.nav-action-button:active {
    background: #eeba37;
    -webkit-box-shadow: inset 0 1px 3px 0 #b0820f;
    -moz-box-shadow: inset 0 1px 3px 0 #b0820f;
    box-shadow: inset 0 1px 3px 0 #b0820f;
}
.nav-action-inner{
	color:#111;
}
</style>
<div class="drop-saya" style="display:none;">
	<i class="fa fa-caret-up fa-2x arrow-top"></i>
    <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="nav-action-button"><span class="nav-action-inner">Sign in</span></a>
	<div class="nav-signin-tooltip-footer">New customer? <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="nav-a">Start here.</a></div>
</div>
<script>
jQuery(document).ready(function(e) {
	setTimeout(function(){ jQuery(".drop-saya").fadeIn(1000); }, 1000);
	setTimeout(function(){ jQuery(".drop-saya").fadeOut(1000); }, 11000);
	jQuery('#my-account-link-header, #status-order-link').click(function(e) {
        jQuery(".drop-saya").hide();
    });
});
</script>
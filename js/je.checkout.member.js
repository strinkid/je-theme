$(document).ready(function(){
    checkoutDisplayForMember();
});

function checkoutDisplayForMember(){
    $("#guest-checkout").hide();
	$("#guest-prev-btn").hide();
    $("#guest-login").hide();
    $("#fb-login").hide();
    $("#customer_details").show();
    $("#order_review").hide();
    $("#checkoutConfirmationSection").hide();
    $("#checkoutPaymentSection").hide();
}
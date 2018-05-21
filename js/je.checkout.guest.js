$(document).ready(function () {
    $("#guest-checkout").show();
    $("#guest-login").show();
    $("#fb-login").show();
    $("#customer_details").hide();
    $("#order_review").hide();
    $("#checkoutConfirmationSection").hide();
    $("#checkoutPaymentSection").hide();
    $("#guest-prev-btn").show();
    // $("#guest-nxt-btn").hide();

    $("#guest-nxt-btn").click(function (e) {
		$("#loading-input-new-email").show();
        var url = "/wp-admin/admin-ajax.php?action=wpmu_validate_user_signup";
        var emailTxt = $("#registerEmail").val();
               
        if (validateEmail(emailTxt)) {
            $.ajax({
            type:'POST',
            url:url,
            data:"email="+ emailTxt,
            dataType:'json',
                success: function(data){
                    var ok = data == "ok";
                    var not_ok = data == "email sudah terdaftar";
                    var not_filled = data == "Email belum diisi";

                    if(ok == true){
                        $(".success-msg").show();
                        $(".error-message-2").hide();
                        $(".empty-msg").hide();
                        $(".format-error-msg").hide();
                        e.preventDefault();
                        checkOutDisplayDelivery();
                        activateTopIcon('Delivery');
						$("#loading-input-new-email").hide();
                    }
                    else if(not_ok == true){
                        $(".error-message-2").show();
                        $(".success-msg").hide();
                        $(".empty-msg").hide();
                        $(".format-error-msg").hide();
						$("#loading-input-new-email").hide();
                    }else{
						$("#loading-input-new-email").hide();
					}
                }
            });
        }
        else if(emailTxt == ""){
            $(".empty-msg").show();
            $(".format-error-msg").hide();
            $(".success-msg").hide();
            $(".error-message-2").hide();

        }
        else{
            $(".empty-msg").hide();
            $(".format-error-msg").show();
            $(".success-msg").hide();
            $(".error-message-2").hide();
        }
        
    });

    $("#guest-prev-btn").click(function (e) {
        e.preventDefault();
        $("#guest-checkout").show();
        $("#guest-login").show();
        $("#fb-login").show();
        $("#customer_details").hide();
        $("#order_review").hide();
        $("#checkoutConfirmationSection").hide();
        $("#checkoutPaymentSection").hide();
        activateTopIcon('Sign');

    });
});

function validateEmail(emailTxt) {
    var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    if (filter.test(emailTxt)) {
        return true;
    }
    else {
        $(".format-error-msg").show;
        return false;
    }
}
$(document).ready(function () {
    assignAutoFill("billing_phone");
    assignAutoFill("billing_mobile");
    paymentMethodSelection();

    $('#order_review').ready(function () {
        if ($('#topIconDeliveryOn').css('display') != 'none') {
            checkOutDisplayDelivery();
        }
        else if ($('#topIconPaymentOn').css('display') != 'none') {
            checkOutDisplayPayment();
        }
        else if ($('#topIconConfirmOn').css('display') != 'none') {
            checkOutDisplayConfirmation();
        }
        fillCheckoutConfirmationDetails();
    });
    $('#billing_state').change(fillCheckoutConfirmationDetails());
    $('#billing_kota').change(fillCheckoutConfirmationDetails());
    $('#billing_city').change(fillCheckoutConfirmationDetails());
    $('#billing_postcode').change(fillCheckoutConfirmationDetails());
    $('#billing_first_name').change(fillCheckoutConfirmationDetails());
    $('#billing_last_name').change(fillCheckoutConfirmationDetails());
    $('#billing_address_1').change(fillCheckoutConfirmationDetails());
	
	auto_fill_account();
	
});


function auto_fill_account(){
	
	jQuery('body').on('keyup','#registerEmail',function(){
		var email = jQuery(this).val();
		jQuery('#registerAccountName').val(email);
	});
	
}

function paymentMethodSelection() {
    $('.paymentSelectionIcon').click(function () {
        var key = $(this).attr('keyForClick');
        var hideBorder = $(this).css({"border-right": "0px !important;"});
        var showBorder = $(this).css({"border-right": "1px solid #bababa !important;"});

        $('.paymentMethodDesc').each(function () {
            if ($(this).attr('id') == "payment_method_desc_" + key) {
                $(this).show();
            }
            else {
                $(this).hide();
            }
        });
        $(".paymentSelectionIcon").each(function () {
            if ($(this).attr('id') == "payment_method_icon_" + key) {
                /*$(this).css({
                    "border-right": "0px",
                    "-webkit-box-shadow": "inset 0px 0px 0px 0px rgba(0,0,0,0)",
                    "-moz-box-shadow": "inset 0px 0px 0px 0px rgba(0,0,0,0)",
                    "box-shadow": "inset 0px 0px 0px 0px rgba(0,0,0,0)",
                    "position":"relative",
                    "right":"2px"
                });
				*/
				$(this).removeClass('payment_disable');
				$(this).addClass('payment_active');
            } else {
                /*$(this).css({
                    "border-right": "1px solid #bababa",
                    "box-shadow": "inset -5px 0 9px -7px rgba(0,0,0,0.7)",
                    "right":"0"
                });*/
				$(this).removeClass('payment_active');
				$(this).addClass('payment_disable');
            }
        });
        $('#payment_method').val(key);
    });
}
function assignAutoFill(key) {
    $("#" + key + "1").keyup(function () {
        assignAutoFillSub(key);
    });
    $("#" + key + "2").keyup(function () {
        assignAutoFillSub(key);
    });
}
function assignAutoFillSub(key) {
    var before = $("#" + key + "1").val();
    var after = $("#" + key + "2").val();
    var fullNumber = "";
    if (before == null || before == "") {
        fullNumber = after;
    }
    else if (after == null || after == "") {
        fullNumber = before;
    }
    else {
        fullNumber = before + "-" + after;
    }
    $("#" + key).val(fullNumber);
}

$(document).ready(function () {
    $("#payment-previous-btn").click(function (e) {
        e.preventDefault();
        activateTopIcon('Delivery');
        checkOutDisplayDelivery();
    });

    $("#delivery-next-btn").click(function (e) {
		
		var validate = validate_next_delivery_pickup(e);
		if(validate){ return; }
		
        var first_name_field = $("#billing_first_name").val();
        var address_field = $("#billing_address_1").val();
        var state_field = $("#billing_state").val();
		var billing_kota = $("#billing_kota").val();
        var city_field = $("#billing_city").val();
        var phone_field = $("#billing_phone2").val();
       // var mobilePhone_field = $("#billing_mobile2").val();
		
        if (first_name_field == "" || address_field == "" || state_field == '' || billing_kota == '' || city_field == "") {
            $(".billing-error").show();
        } else if (phone_field == "") {
            $("div.billing-note").addClass('oneMustbeFilled');
        } else if (!($.isNumeric(phone_field)) && !($.isNumeric(mobilePhone_field))) {
            $(".billing-error-phoneField").show();
        } else {
            e.preventDefault();
			fillCheckoutConfirmationDetails();
            activateTopIcon('Payment');
            checkOutDisplayPayment();
            $(".billing-error").hide();
            $(".billing-error-phoneField").hide();
            $("div.billing-note").removeClass('oneMustbeFilled');
			
			$("html, body").animate({ scrollTop: 0 }, "slow");
			  
        }
    });

    $("#confirmation-previous-btn").click(function (e) {
        e.preventDefault();
        activateTopIcon('Payment');
        checkOutDisplayPayment();
    });

    $("#payment-next-btn").click(function (e) {

        var bankNameField = $("#billing_payment_method_bank_name").val();
        var bankAccountField = $("#billing_payment_method_account_name").val();
        var error_PaymentMethod = $(".billing_payment-error");
        var paymentMethodField = $("#payment_method").val();

        if (paymentMethodField == "bacs" && (bankNameField == "" || bankAccountField == "")) {
            error_PaymentMethod.show();
        } else {
            e.preventDefault();
            activateTopIcon('Confirm');
            checkOutDisplayConfirmation();
			
			$("html, body").animate({ scrollTop: 0 }, "slow");
        }
    });
});
function activateTopIcon(key) {
    $('.topIcon').each(function () {
        if ($(this).attr('id').indexOf(key) > -1) {
            $('#topIcon' + key + 'Off').hide();
            $('#topIcon' + key + 'On').show();
        } else {
            if ($(this).attr('id').indexOf('Off') > -1) $(this).show();
            if ($(this).attr('id').indexOf('On') > -1) $(this).hide();
        }
    });
}
function registerGuestDuringCheckout() {
    $('#place_order').click(function (e) {
        $("#billing_email").val($("#registerEmail").val());
    });
}
function checkOutDisplayDelivery() {
    $("#customer_details").show();
    $("#order_review").hide();
    $("#checkoutConfirmationSection").hide();
    $("#checkoutPaymentSection").hide();

    $("#guest-checkout").hide();
    $("#guest-login").hide();
    $("#fb-login").hide();
}
function checkOutDisplayPayment() {
    $("#customer_details").hide();
    $("#order_review").show();
    $("#checkoutConfirmationSection").hide();
    $("#checkoutPaymentSection").show();
}
function checkOutDisplayConfirmation() {
    $("#customer_details").hide();
    $("#order_review").show();
    $("#checkoutConfirmationSection").show();
    $("#checkoutPaymentSection").hide();
}
function fillCheckoutConfirmationDetails(){
    var alamat = '';
    alamat += $('#billing_state option:selected').text();
    if (alamat != '') alamat += ', ';
    alamat += $('#billing_kota option:selected').text();
    if (alamat != '') alamat += ', ';
    alamat += $('#billing_city option:selected').text();
    if (alamat != '') alamat += ', ';
    alamat += $('#billing_postcode').val();

    $('#checkoutConfirmationName').text($('#billing_first_name').val() + ' ' + $('#billing_last_name').val());
    $('#checkoutConfirmationAddress').text($('#billing_address_1').val());
    $('#checkoutConfirmationCity').text(alamat);

}

function validate_next_delivery_pickup(e){
	
	if(jQuery('#billing-information-form').find('#pickup_store').is(':checked')){
		
		var first_name_field = $("#billing_first_name").val();
        var phone_field = $("#billing_phone2").val();
        var mobilePhone_field = $("#billing_mobile2").val();
			
		 if (first_name_field == "" ) {
            $(".billing-error").show();
        } else if (phone_field == "" && mobilePhone_field == "") {
            $("div.billing-note").addClass('oneMustbeFilled');
        } else if (!($.isNumeric(phone_field)) && !($.isNumeric(mobilePhone_field))) {
            $(".billing-error-phoneField").show();
        } else {
            e.preventDefault();
			fillCheckoutConfirmationDetails();
            activateTopIcon('Payment');
            checkOutDisplayPayment();
            $(".billing-error").hide();
            $(".billing-error-phoneField").hide();
            $("div.billing-note").removeClass('oneMustbeFilled');
			
			return true;
        }
		
		
	}
	
	return false;
	
}


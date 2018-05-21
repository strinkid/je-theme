$(document).ready(function(){
    $('input.input-text.qty.text').change(function(){
        var qty = $(this).val();
        var cartItem = $(this).parent().parent().parent();
        var price = $(cartItem.find('.product-price span')[0]).html();
        var subTotalElement = $(cartItem.find('.product-subtotal span')[0]);

        price = price.replace("Rp","");
        price = price.replace(",","");
        price = price.replace(".","");
        price = price.replace("&nbsp;","");

        var newSubtotal = Number(qty) * Number(price);
        var newSubtotalText = (Number(newSubtotal)).formatMoney(0, '.', ',');
        subTotalElement.html("Rp "+newSubtotalText);
        setTotal();


    });
});
function setTotal(){
    var total = 0;
    var totalElement = $($('table tbody .cart-subtotal span.amount')[0]);

    $('table tbody .product-subtotal span').each(function(){
        var subtotal = $(this).html();
        subtotal = subtotal.replace("Rp","");
        subtotal = subtotal.replace(/,/gi,"");
        subtotal = subtotal.replace(".","");
        subtotal = subtotal.replace("&nbsp;","");
        total += Number(subtotal);
    });
    var newTotalText = (Number(total)).formatMoney(0, '.', ',');
    totalElement.html("Rp "+newTotalText);
}
Number.prototype.formatMoney = function(c, d, t){
    var n = this,
        c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};
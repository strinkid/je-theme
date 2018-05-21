jQuery( function( $ ) {


    for (i = 1; i < 5; i++) {
        auto_calculate_sale_percentage("#_regular_price_hi_"+i, "#_sale_price_hi_"+i, "#_sale_price_label_hi_"+i);
        auto_calculate_sale_percentage("#_regular_price_bd_"+i, "#_sale_price_bd_"+i, "#_sale_price_label_bd_"+i);
        auto_populate_price("#hot_items_"+i,"#_regular_price_hi_"+i, "#_sale_price_hi_"+i, "#_sale_price_label_hi_"+i);
        auto_populate_price("#best_deals_"+i,"#_regular_price_bd_"+i, "#_sale_price_bd_"+i, "#_sale_price_label_bd_"+i);
    }

    //START auto populate sale & regular price, when product selected
    function auto_populate_price(product_id, regular_id, sale_id, sale_label_id){
        $(product_id).change(function(e) {
            var spinner_element1 = $($(regular_id).parent().find('.spinner')[0]);
            var spinner_element2 = $($(sale_id).parent().find('.spinner')[0]);
            spinner_element1.addClass('is-active');
            spinner_element2.addClass('is-active');

            var url = "/wp-admin/admin-ajax.php?action=get_product_price";
            url += "&post_id="+$(product_id).select2('data').id;
            $.ajax({
                type:'GET',
                url: url,
                success: function (data) {
                    data = data.substr(0,data.length-1);
                    var dataObject = JSON.parse(data);
                    $(regular_id).val(dataObject._regular_price);
                    $(sale_id).val(dataObject._sale_price);
                    calculate_sale_percentage(regular_id, sale_id, sale_label_id);

                    spinner_element1.removeClass('is-active');
                    spinner_element2.removeClass('is-active');
                }
            });
        });
    };
    //END auto populate sale & regular price, when product selected

    //START auto update sale percentage label
    function auto_calculate_sale_percentage(regular_id, sale_id, sale_label_id){
        $( sale_id ).keyup(function() {
            calculate_sale_percentage(regular_id, sale_id, sale_label_id);
        });
        $( regular_id ).keyup(function() {
            calculate_sale_percentage(regular_id, sale_id, sale_label_id);
        });
    }
    function calculate_sale_percentage(regular_id, sale_id, sale_label_id) {
        var sale_percentage = 0;
        var regular_price = $(regular_id).val();
        var sale_price = $(sale_id).val();
        if (regular_price != 0 && regular_price != '' && sale_price != 0 && sale_price != '') {
            sale_percentage = (regular_price - sale_price) / regular_price;
            sale_percentage = Math.ceil(sale_percentage * 100)
        }
        $(sale_label_id).html(sale_percentage);
    }
    //END auto update sale percentage label

    //START submit will update price then update option
    $( '#submit').click(function(){
        var spinner_element = $($(this).parent().find('.spinner')[0]);
        spinner_element.addClass('is-active');

        var url = "/wp-admin/admin-ajax.php?action=update_hot_items_best_deals";
        for (i = 1; i < 5; i++) {
            url += "&hot_items_"+i+"="+$('#hot_items_'+i).val();
            url += "&best_deals_"+i+"="+$('#best_deals_'+i).val();
            url += "&_regular_price_hi_"+i+"="+$('#_regular_price_hi_'+i).val();
            url += "&_regular_price_bd_"+i+"="+$('#_regular_price_bd_'+i).val();
            url += "&_sale_price_hi_"+i+"="+$('#_sale_price_hi_'+i).val();
            url += "&_sale_price_bd_"+i+"="+$('#_sale_price_bd_'+i).val();
        }
        $.ajax({
            type:'GET',
            url: url,
            success: function (data) {
                spinner_element.removeClass('is-active');
                $('#update_notification').fadeTo( 0, 1 );
                $('#update_notification').css('visibility','visible');
                $('#update_notification').show();
                $('#update_notification').fadeTo( 5000, 0 );
            }
        });
    });
    //END submit
});
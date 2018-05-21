$( document ).ready(function() {
    //if($(window).width() > 991){
        var evt = new Event(),
            m = new Magnifier(evt);


        $('.productDetailsThumbnail img').mouseenter(function(){
            $('#productDetailsViewedImage img').attr('src', $(this).attr('src'));
            $('.productDetailsThumbnail img').removeClass('productDetailsThumbnailSelected');
            $(this).addClass('productDetailsThumbnailSelected');

            $('#thumb-lens').css('background-image', 'url('+$('#thumb').attr('src')+')');
            $('#thumb-large').attr('src', $('#thumb').attr('src'));
            $('#thumb-lens').css('background-size', '100%');
            m.setLargeUrl('thumb',$('#thumb').attr('src'));
        });
        $('#productDetailsImageSliderNext').click(function(){
            var highestVisible = Number($('#productDetailsImageSliderNext').attr('highestVisible'));
            var lowestVisible = highestVisible - 3;
            var max = Number($('#productDetailsImageSliderNext').attr('highestVisibleMax'));

            if (max == highestVisible) return;
            if (0 == lowestVisible) $('#productDetailsImageSliderPrev').removeClass('productDetailsSliderHide');

            $('#productDetailsThumbnail'+lowestVisible).addClass('productDetailsThumbnailHide');
            highestVisible += 1;
            lowestVisible += 1;
            $('#productDetailsThumbnail'+highestVisible).removeClass('productDetailsThumbnailHide');
            $('#productDetailsImageSliderNext').attr('highestVisible', highestVisible);
            if (max == highestVisible) $('#productDetailsImageSliderNext').addClass('productDetailsSliderHide');
        });
        $('#productDetailsImageSliderPrev').click(function(){
            var highestVisible = Number($('#productDetailsImageSliderNext').attr('highestVisible'));
            var lowestVisible = highestVisible - 3;
            var max = Number($('#productDetailsImageSliderNext').attr('highestVisibleMax'));

            if (0 == lowestVisible) return;
            if (max == highestVisible) $('#productDetailsImageSliderNext').removeClass('productDetailsSliderHide');

            $('#productDetailsThumbnail'+highestVisible).addClass('productDetailsThumbnailHide');
            highestVisible -= 1;
            lowestVisible -= 1;
            $('#productDetailsThumbnail'+lowestVisible).removeClass('productDetailsThumbnailHide');
            $('#productDetailsImageSliderNext').attr('highestVisible', highestVisible);
            if (0 == lowestVisible) $('#productDetailsImageSliderPrev').addClass('productDetailsSliderHide');
        });

        var mouseEnterLeaveBlock = false;
        $('#productDetailsViewedImage a').mouseenter(function(){
            $('#productDetailsImageZoomed').height($('#productDetailsSummary').outerHeight());
            $('#productDetailsSummary').addClass('productDetailsThumbnailHide');
            $('#priceContainer').addClass('productDetailsThumbnailHide');
            $('#productDetailsImageZoomed').removeClass('productDetailsThumbnailHide');
        });
        $('#productDetailsViewedImage a').mouseleave(function(){
            $('#productDetailsSummary').removeClass('productDetailsThumbnailHide');
            $('#priceContainer').removeClass('productDetailsThumbnailHide');
            $('#productDetailsImageZoomed').addClass('productDetailsThumbnailHide');
        });

        $('#productDetailsSummary').addClass('productDetailsThumbnailHide');
        $('#priceContainer').addClass('productDetailsThumbnailHide');
        $('#productDetailsImageZoomed').removeClass('productDetailsThumbnailHide');
        m.attach({
            thumb: '#thumb',
            large: $('#thumb').attr('src'),
            largeWrapper: 'preview'
        });
        $('#productDetailsSummary').removeClass('productDetailsThumbnailHide');
        $('#priceContainer').removeClass('productDetailsThumbnailHide');
        $('#productDetailsImageZoomed').addClass('productDetailsThumbnailHide');
		
        var maxHeight = $('#productDetailsImageZoomed #preview').height();
        if (maxHeight < $('#productDetailsSummary').height()) maxHeight = $('#productDetailsSummary').height();

        $('#productDetailsImageZoomed #preview').height(maxHeight);
        $('#productDetailsSummary').height(maxHeight);
    //}
});
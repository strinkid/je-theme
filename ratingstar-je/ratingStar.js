$(document).ready(function(){
    var emptyStarImgUrl = $('#emptyStarImgUrl').val();
    var halfStarImgUrl = $('#halfStarImgUrl').val();
    var fullStarImgUrl = $('#fullStarImgUrl').val();
    var hoverStarImgUrl = $('#hoverStarImgUrl').val();

    $('div[class^="starRating"]').click(function(){
        var rating = $(this).attr('class').substring(10, 11);

        var url = "/wp-admin/admin-ajax.php?action=update_star_je";
        url += "&rating="+rating;
        url += "&productId="+$('#ratingStarProductId').val();
        $.ajax({
            type:'GET',
            url: url,
            success: function (data) {
				
				jQuery('.alert-login').remove();
				if(data == '0'){
					jQuery('#starRatingSection').after('<span style="padding:2px;" class="alert alert-danger alert-login">Silahkan Login !</span>');
					return;
				}
				
                var rating = data.split('|')[0]
                var count = data.split('|')[1]
                $('div[class^="starRating"]').each(function(index){
                    var halfStar = index + 1 - 0.75;
                    var fullStar = index + 1 - 0.25;

                    var imageName = emptyStarImgUrl;
                    if(rating > fullStar){
                        imageName = fullStarImgUrl;
                    }
                    else if(rating > halfStar){
                        imageName = halfStarImgUrl;
                    }

                    $($(this).find('img')[0]).attr('src', imageName);
                });
                $('.ratingReviewTotal').html(count);
            }
        });
    });
});

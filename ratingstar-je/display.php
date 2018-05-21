<?php

function displayEditableStarJe(){
    global $product;
    //if (is_user_logged_in()){
		$content = displayStar('edit');
		$content .= '<input type="hidden" name="ratingStarProductId" id="ratingStarProductId" value="'.get_the_ID().'">';
        $content .= '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>';
        $content .= '<script src="'.get_template_directory_uri().'/ratingstar-je/ratingStar.js"></script>';
        echo $content;
    //}
};
add_action('woocommerce_after_shop_loop_item_title','displayNonEditableStarJe', 102);
function displayNonEditableStarJe(){
	$content = displayStar('view');
    echo $content;
};

function displayStar($action){
    global $product;

    $averageOutput = getCurrentAvrgRating(get_the_ID());
    $countOutput = getCurrentCountRating(get_the_ID());
    $starClass = 'starOnDetail';

    if ($countOutput == 0 && $action =='view') return;
    if ($action =='view') $starClass = 'star';

    $content = '<div id="starRatingSection">';
    for($i=1; $i<=5; $i++){
        $halfStar = $i - 0.75;
        $fullStar = $i - 0.25;

        $imageName = 'star-rating-empty.png';
        if($averageOutput > $fullStar){
            $imageName = 'star-rating-full.png';
        }
        else if($averageOutput > $halfStar){
            $imageName = 'star-rating-half.png';
        }

        $content .= '<div class="starRating'.$i.' '.$starClass.'">
        <img id="yellow-star-img" src="'.get_template_directory_uri().'/img/'.$imageName.'"/>
        </div>';
    }


    $content .= '<div class="ratingReviewSection">';
    $content .= '<img id="reviewList-icon" src="'.get_template_directory_uri().'/img/reviewList-icon.png">';
    $content .= '<span class="ratingReviewTotal">'.$countOutput.'</span>';
    $content .= '</div>';

    $content .= '</div>';
    $content .= '<br/>';
    $content .= '<input type="hidden" id="emptyStarImgUrl" value="'.get_template_directory_uri().'/img/star-rating-empty.png">';
    $content .= '<input type="hidden" id="halfStarImgUrl" value="'.get_template_directory_uri().'/img/star-rating-half.png">';
    $content .= '<input type="hidden" id="fullStarImgUrl" value="'.get_template_directory_uri().'/img/star-rating-full.png">';
    $content .= '<input type="hidden" id="hoverStarImgUrl" value="'.get_template_directory_uri().'/img/star-rating-hover.png">';

	return $content;

    echo $script;
}
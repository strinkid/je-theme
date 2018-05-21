<?php

function update_star_je(){
    if (is_user_logged_in()){
        global $current_user;
        extract($_GET);
		$aliasItem = get_post_meta($productId, 'starRatingAllJe');
        $currentRating = $currentRating = $aliasItem[0];
        $key = '"'.$current_user->id.'"';
        if (empty($currentRating)){
            $currentRating = '"'.$current_user->id.'":'.$rating;
            $avrgRating = $rating;
        }
        else if (strpos($currentRating, $key) > -1){
            $ratingPosition = strpos($currentRating, '"'.$current_user->id.'"') + strlen('"'.$current_user->id.'":');
            $stringBefore = substr($currentRating, 0, $ratingPosition);
            $stringAfter = substr($currentRating, $ratingPosition + 1, strlen($currentRating));
            $currentRating = $stringBefore.$rating.$stringAfter;
            $avrgRating = getNewAvrgRating($currentRating);
        }
        else{
            $currentRating .= ',"'.$current_user->id.'":'.$rating;
            $avrgRating = getNewAvrgRating($currentRating);
        }
        update_post_meta($productId, 'starRatingAllJe', $currentRating);
        update_post_meta($productId, 'starRatingAverageJe', $avrgRating);
        echo $avrgRating.'|'.count(explode(",",$currentRating));
        die();
    }else{
		echo '0';
		die();
	}
};
add_action('wp_ajax_update_star_je', 'update_star_je');
add_action('wp_ajax_nopriv_update_star_je', 'update_star_je');

function getNewAvrgRating($allRating){
    $currentRatingArray = explode(",",$allRating);
    $countRating = 0;
    $totalRating = 0;
    foreach($currentRatingArray as $eachRating){
        $countRating++;
		$aliasItem = explode(":", $eachRating);
        $totalRating += intval($aliasItem[1]);
    }
    $avrgRating = $totalRating / $countRating;
    return round($avrgRating, 2);
}
function getCurrentAvrgRating($productId){
	$a = get_post_meta($productId, 'starRatingAverageJe');
	if(isset($a[0])){
    	return $a[0];
	}else{
		return '';
	}
}
function getCurrentCountRating($productId){
	$a = get_post_meta($productId, 'starRatingAllJe');
	if(isset($a[0])){
   		 $fullRating = $a[0];
    		if (empty($fullRating)) return 0;
    			return count(explode(",",$fullRating));
	}else{
		return '';
	}
	
}
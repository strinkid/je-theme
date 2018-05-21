<?php
/**
 * Register meta box(es).
 */
function youtube_galery_meta_boxes() {
    add_meta_box( 
		'youtube-galery', 
		__( 'Youtube Galery', 'textdomain' ), 
		'youtube_galery_callback', 
		'product' ,
		'side');
}
add_action( 'add_meta_boxes', 'youtube_galery_meta_boxes' );
 
/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function youtube_galery_callback( $post ) {
    // Display code/markup goes here. Don't forget to include nonces!
	$key_1_value = get_post_meta( $post->ID, '_youtube_galery', true );
	?>
    <div id="youtube_galey_01">
    	<?php if(is_array($key_1_value)){ foreach($key_1_value as $val){ ?>
        	<span><input type="text" name="youtube_galery[]" value="<?php echo $val;?>"> <a class="button" onclick="delyoutubegalery(this)">x</a></span>
        <?php }} ?>
    </div>
    <a class="button" id="add-youtube-galery">Add</a>
    <script>

	jQuery("#add-youtube-galery").click(function(e) {
        jQuery("#youtube_galey_01").append('<span><input type="text" name="youtube_galery[]"> <a class="button" onclick="delyoutubegalery(this)">x</a></span>');
    });
	function delyoutubegalery(e){
		e.parentNode.parentNode.removeChild(e.parentNode);
	}

	</script>
	<?php
}
 
/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function youtube_galery_save_meta_box( $post_id ) {
    // Save logic goes here. Don't forget to include nonce checks!
	if(isset($_POST['youtube_galery'])){
		$youtube_galery = array();
		foreach($_POST['youtube_galery'] as $you){
			if($you != ''){
				$youtube_galery[] = $you;
			}
		}
		
		if(count($youtube_galery) != 0){
			if ( ! add_post_meta( $post_id, '_youtube_galery', $youtube_galery, true ) ) { 
	   			update_post_meta( $post_id, '_youtube_galery', $youtube_galery );
			}
		}
	}else{
		delete_post_meta($post_id,'_youtube_galery');
	}
}
add_action( 'save_post', 'youtube_galery_save_meta_box' );

add_action('after_product_thumbnail','youtube_galery_thumbnail');

function youtube_galery_thumbnail($product_id){
	$key_1_value = get_post_meta( $product_id, '_youtube_galery', true );
	if(is_array($key_1_value)){
		$key = 1;
		foreach($key_1_value as $val){
			echo '<a class="video-single-prod" data-code="'.$key.'">';
			echo '<img src="http://img.youtube.com/vi/'.$val.'/default.jpg">';	
			echo '</a>';
			$key++;
		}
	}
}
add_action('after_je_product_image','youtube_thumbnail_to_play');

function youtube_thumbnail_to_play($product_id){
	$key_1_value = get_post_meta( $product_id, '_youtube_galery', true );
	if(is_array($key_1_value)){
		$key = 1;
		foreach($key_1_value as $val){
			echo '<iframe id="youtub-emb-'.$key.'" class="frame-youtube" style="display:none;" width="300" height="300" src="https://www.youtube.com/embed/'.$val.'?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>';
			$key++;
		}
	}
}

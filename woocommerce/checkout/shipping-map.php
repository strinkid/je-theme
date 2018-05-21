<?php
function themeslug_enqueue_script() {
	if(is_checkout() || is_admin()){
		//wp_enqueue_script( 'google-map-js', 'https://maps.google.com/maps/api/js?sensor=false', false );	
	}
}
add_action( 'admin_enqueue_scripts', 'themeslug_enqueue_script' );
add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_script' );

//add_action('woocommerce_checkout_shipping','shipping_map_func');

function shipping_map_func(){
?>
<style>
#map {
  border: 1px solid #DDD; 
  width:100%;
  height: 400px;
  float:left;  
}
#map img { 
  max-width: none;
}
#map label { 
  width: auto; display:inline; 
}
.map-message{
	height:30px;
	background-color:#00e64d;
	color:hsla(0,0%,100%,1.00);
	padding:5px;
}
</style>
<div class="map-message" style="display:none;"><strong>Optional:</strong> <span style="font-size:12px !important;">Pastikan lokasi yang anda tandai di peta sesuai dengan alamat Anda.</span></div>
<div id="map" style="display:none;"></div>
<input type="hidden" name='_shipping_google_lat' id='lat' class='input-xlarge' >
<input type="hidden" name='_shipping_google_lng' id='lng' class='input-xlarge'>
<div id="msgmm"></div>
<script>
jQuery(document).ready(function(){
	jQuery('body').on('change','#billing_city',function(){
		get_geolocation_muk($(this).val());
	});
	var kecamatan =$("#billing_city").val();
	if(kecamatan != ''){
		get_geolocation_muk(kecamatan);
	}else{
		get_geolocation_muk('Jakarta');
	}
	function get_geolocation_muk(string){
		var data = {'action':'get_geolocation_muk','location':string};
		$.ajax({
			url:"<?php echo admin_url('admin-ajax.php')?>",
			type:"POST",
			data: data,
			cache:false,
			success: function(msg){
				var myOptions = {
      				zoom: 16,
			        scaleControl: true,
    				center:  new google.maps.LatLng(msg.lat,msg.lng),
				    mapTypeId: google.maps.MapTypeId.ROADMAP
    			};
	
    			var map = new google.maps.Map(document.getElementById("map"),
        			myOptions);

				var marker1 = new google.maps.Marker({
					position : new google.maps.LatLng(msg.lat,msg.lng),
					title : 'lokasi',
					map : map,
					draggable : true,
					icon:'https://jualelektronik.com/wp-content/uploads/2016/05/pin-jualelektronik-edit.png'
				});
				google.maps.event.addListener(marker1, 'drag', function() {
					updateMarkerPosition(marker1.getPosition());
				});
				$("#map, [class='map-message']").show();
			}
		}); //END AJAX
	}
   function updateMarkerPosition(latLng) {
		document.getElementById('lat').value = [latLng.lat()];
		document.getElementById('lng').value = [latLng.lng()];
	}
    
	//AIzaSyCwFJ-ckxJ9Qi_blTal5xhkdVYuAXfCBPc
	//updateMarkerPosition(latLng);
});
</script>
<?php }
add_action('wp_ajax_nopriv_get_geolocation_muk','get_geolocation_muk');
add_action('wp_ajax_get_geolocation_muk','get_geolocation_muk');
function get_geolocation_muk(){
	$data = array(
		'address'=>$_REQUEST['location'],
		'key'=>'AIzaSyCwFJ-ckxJ9Qi_blTal5xhkdVYuAXfCBPc');
	$string = http_build_query($data);
	$homepage = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?'.$string);
	$map = json_decode($homepage);
	echo wp_send_json($map->results[0]->geometry->location);
	wp_die();
}
/**
 * Update the order meta with field value
 */
add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta2' );

function my_custom_checkout_field_update_order_meta2( $order_id ) {
    if ( ! empty( $_POST['_shipping_google_lat'] ) ) {
        #update_post_meta( $order_id, 'My Field', sanitize_text_field( $_POST['my_field_name'] ) );
		if ( ! add_post_meta( $order_id, '_shipping_google_lat', sanitize_text_field( $_POST['_shipping_google_lat'] ), true ) ) { 
   			update_post_meta( $order_id, '_shipping_google_lat', sanitize_text_field( $_POST['_shipping_google_lat'] ) );
		}
    }
	if ( ! empty( $_POST['_shipping_google_lng'] ) ) {
        #update_post_meta( $order_id, 'My Field', sanitize_text_field( $_POST['my_field_name'] ) );
		if ( ! add_post_meta( $order_id, '_shipping_google_lng', sanitize_text_field( $_POST['_shipping_google_lng'] ), true ) ) { 
   			update_post_meta( $order_id, '_shipping_google_lng', sanitize_text_field( $_POST['_shipping_google_lng'] ) );
		}
    }
}

add_action( 'woocommerce_admin_order_data_after_shipping_address', 'google_map_shipping', 10, 1 );

function google_map_shipping($order){
	$lat = get_post_meta($order->id,'_shipping_google_lat',true);
	$lng = get_post_meta($order->id,'_shipping_google_lng',true);
	if(!empty($lat)){
    	echo '<p><a href="'.admin_url().'admin.php?page=view-shipping-map&post='.$order->id.'"><strong>'.__('View Shipping Map').'</strong></a></p>';
	}
}

add_action('admin_menu','add_map_page',99);
function add_map_page(){
	//create submenu
	add_submenu_page('woocommerce','View Map','View Map','manage_options','view-shipping-map','view_shipping_map');	
}
function view_shipping_map(){
	echo '<h3>View Map</h3>';
	if(!isset($_GET['post'])){return;}
	$order_id = $_GET['post'];
	$my_order_meta = get_post_custom( $order_id );
	if(!isset($my_order_meta['_shipping_google_lat'])){return;}
	if($my_order_meta['_shipping_google_lat'][0] == ''){return;}
	$order = new WC_Order($order_id);
	echo str_replace('<br/>',' | ',$order->get_shipping_address());
	$lat  = $my_order_meta['_shipping_google_lat'][0];
	$lng  = $my_order_meta['_shipping_google_lng'][0];
	?>
    <div class="wrap">
    <style>
    #map {
  		border: 1px solid #DDD; 
  		width:100%;
  		height: 500px;
  		float:left;  
	}
	#map img { 
 	 	max-width: none;
	}
	#map label { 
  		width: auto; display:inline; 
	}
	</style>
        <div id="map" style="width: 60%;float:left"></div>
        <div id="pano" style="width: 35%;float:left; height:500px;"></div>
    </div>
    <script>
	var myOptions = {
      	zoom: 16,
		scaleControl: true,
    	center:  new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $lng; ?>),
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		streetViewControl: true
    };
	
    var map = new google.maps.Map(document.getElementById("map"),
        	myOptions);

	var marker1 = new google.maps.Marker({
		position : new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $lng; ?>),
		title : 'lokasi',
		map : map,
		draggable : false,
		icon:'<?php print site_url(); ?>/wp-content/uploads/2016/05/pin-jualelektronik-edit.png'
	});
	
	var berkeley = {lat: <?php echo $lat;?>, lng: <?php echo $lng; ?>};
    var sv = new google.maps.StreetViewService();

    var panorama = new google.maps.StreetViewPanorama(document.getElementById('pano'));
	
	// Set the initial Street View camera to the center of the map
    sv.getPanorama({location: berkeley, radius: 50}, processSVData);

    // Look for a nearby Street View panorama when the map is clicked.
    // getPanoramaByLocation will return the nearest pano when the
    // given radius is 50 meters or less.
    map.addListener('click', function(event) {
        sv.getPanorama({location: event.latLng, radius: 50}, processSVData);
    });
		
	function processSVData(data, status) {
        if (status === google.maps.StreetViewStatus.OK) {
          var marker = new google.maps.Marker({
            position: data.location.latLng,
            map: map,
            title: data.location.description
          });
		  
          panorama.setPano(data.location.pano);
          panorama.setPov({
            heading: 270,
            pitch: 0
          });
          panorama.setVisible(true);

          marker.addListener('click', function() {
            var markerPanoID = data.location.pano;
            // Set the Pano to use the passed panoID.
            panorama.setPano(markerPanoID);
            panorama.setPov({
              heading: 270,
              pitch: 0
            });
            panorama.setVisible(true);
          });
        } else {
          console.error('Street View data not found for this location.');
        }
      }
	</script>
    <?php
}

/**
 * Display Metabox Shippment Tracking on order admin page
 **/

add_action( 'add_meta_boxes', 'BFM_add_meta_boxes',0);

function BFM_add_meta_boxes(){
    add_meta_box(
        'woocommerce-order-my-custom',
        __( 'Google Map' ),
        'order_my_custom',
        'shop_order',
        'normal',
        'default'
    );

}
function order_my_custom( $post ){
	view_shipping_map();?>
    <script>
	var myElement = document.querySelector("#woocommerce-order-my-custom");
	myElement.style.height = "650px";
	</script>
    <?php 
}


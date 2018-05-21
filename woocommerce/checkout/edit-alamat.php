<?php 
add_action('wp_head','load_modal_change_address'); 
function load_modal_change_address(){
  if(!is_checkout()){ return;}
  //$jne = new WC_JNE_Cek_Ongkir();	
  ?>
   <?php //echo get_current_user_id(); ?> 
  <!-- Modal -->
  <div class="modal fade" id="editalamatkirim" role="dialog" style="z-index:1501">
    <div class="modal-dialog">
    <form class="form-horizontal" role="form" id="formeditalamat">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Alamat Pengiriman</h4>
        </div>
        <div class="modal-body">       
		    <div class="form-group">
		      <label class="control-label col-sm-4">Nama Awal*:</label>
		      <div class="col-sm-8">
		        <input type="text" class="form-control input-sm" placeholder="Nama Awal" id="billing_first_name_modal" required>
		      </div>
		    </div>
            <div class="form-group">
		      <label class="control-label col-sm-4">Nama Akhir:</label>
		      <div class="col-sm-8">
		        <input type="text" class="form-control input-sm" placeholder="Nama Akhir" id="billing_last_name_modal">
		      </div>
		    </div>
            <div class="form-group">
		      <label class="control-label col-sm-4">Jenis Kelamin:</label>
		      <div class="col-sm-8">
		        <label class="radio-inline">
      				<input type="radio" name="billing_gender_modal" id="radio_modal_mele" value="mele">Laki - Laki
    			</label>
    			<label class="radio-inline">
      				<input type="radio" name="billing_gender_modal" id="radio_modal_femele" value="femele">Perempuan
    			</label>
		      </div>
		    </div>
            <div class="form-group">
		      <label class="control-label col-sm-4">Pick Up Store:</label>
		      <div class="col-sm-8">
		        <div class="checkbox">
      				<label><input type="checkbox" value="yes" name="pickup_store_modal" id="pickup_store_modal">Pick Up Store</label>
    			</div>
    			<?php do_action('inish_pickup_inedit_alamat'); ?>
		      </div>
		    </div>
            <div id="alamat_modal">
            <div class="form-group">
		      <label class="control-label col-sm-4">Alamat*:</label>
		      <div class="col-sm-8">
		        <textarea class="form-control input-sm" placeholder="Nama Akhir" id="billing_address_1_modal" required></textarea>
		      </div>
		    </div>
            <?php
            if ( !defined( 'WOOCOMMERCE_JNE' ) ) { exit; } // Exit if accessed directly
			$fields = array(
			'provinsi'	=> array(
				'type'		=> 'select',
				'option'	=>	WC()->countries->get_states( 'ID' ),
				'label'		=> __( 'Provinsi', 'woocommerce' ),
			),
			'kota'		=> array(
				'type'		=> 'select',
				'option'	=>	array( '0' => __( 'Pilih Kotamadya/Kabupaten', 'woocommerce' ), '1' => __( 'Pilih Provinsi terlebih dahulu', 'woocommerce' ) ),
				'label'		=> __( 'Kotamadya/Kabupaten', 'woocommerce' ),
			),
			'kecamatan'	=> array(
				'type'		=> 'select',
				'option'	=>	array( '0' => __( 'Pilih Kecamatan', 'woocommerce' ), '1' => __( 'Pilih Kota terlebih dahulu', 'woocommerce' ) ),
				'label'		=> __( 'Kecamatan', 'woocommerce' ),
			)
		);
			?>
    
    <?php foreach( $fields as $id_fields => $args ):?>
    	<div class="form-group">
		      <label class="control-label col-sm-4"><?php echo $args['label']?>*:</label>
		      <div class="col-sm-8">
		     
        <?php $id_field = 'edit_alamat_kirim_' . $id_fields;?>
        
            	<?php switch( $args['type'] ):
				
                	case 'select' : ?>
                    	
	   					<div class="co-lom co-3">
                        
                        <select name="<?php echo $id_field;?>" id="<?php echo $id_field;?>_modal" class="form-control input-sm" onChange="change_<?=$id_field?>(this)" required>
                        	
                        	<?php foreach( $args['option'] as $value => $label ):?>
	                            <option value="<?php echo $value;?>"><?php echo __( $label, 'agenwebsite' );?></option>

                            <?php endforeach;?>
                        
                        </select>
                        
                        </div>
                        
                    <?php break;?>
                
                <?php endswitch;?>
                
			 </div>
		   </div>        
        
    <?php endforeach;?>
	
			<div class="form-group">
		      <label class="control-label col-sm-4">Kode Pos:</label>
		      <div class="col-sm-8">
                <input type="text" class="form-control input-sm" placeholder="Kode Pos" id="billing_postcode_modal">
		      </div>
		    </div> 
            </div>   
        </div>
        <div class="modal-footer">
        	<a type="submit" class="btn btn-default" onClick="submitform('formeditalamat')">Submit</a>
            <a class="btn btn-default" data-dismiss="modal">Close</a>
        </div>
      </div>
      </form>
    </div>
  </div>

  <script>
  var $ = jQuery;
  function submitform(form){
	  
	if(checkform(form)){
		jQuery('#billing_first_name').val(jQuery('#billing_first_name_modal').val());
		jQuery('#billing_last_name').val(jQuery('#billing_last_name_modal').val());
		jQuery('#billing_address_1').val(jQuery('#billing_address_1_modal').val());
		jQuery('#billing_postcode').val(jQuery('#billing_postcode_modal').val());
		
		var provcode = jQuery("#edit_alamat_kirim_provinsi_modal").val();
		jQuery('#billing_state').val(provcode); 
		jQuery('#shipping_state').val(provcode); 
		jQuery("#select2-chosen-1").html(jQuery('[value='+provcode+']').html());
		
		var kota = 'Kota Administrasi Jakarta Pusat';//jQuery("#edit_alamat_kirim_kota_modal").val();
		jQuery("#billing_kota").html( 'Kota Administrasi Jakarta Pusat'); //jQuery("#edit_alamat_kirim_kota_modal").html());
		jQuery("#billing_kota").val(kota);
		jQuery("#s2id_billing_kota a span.select2-chosen").html(kota);
		
		var kec = jQuery("#edit_alamat_kirim_kecamatan_modal").val();
		jQuery("#billing_city").html(jQuery("#edit_alamat_kirim_kecamatan_modal").html());
		jQuery("#billing_city").val(kec).trigger('change');
		jQuery("#s2id_billing_city a span.select2-chosen").html(jQuery('option[value="'+kec+'"]').html());
		
		var gendremd = jQuery("input[name=billing_gender_modal]:checked").val();
 		if(gendremd == 'male'){
  			jQuery('#man-radio').prop('checked',true);
 		}else if(gendremd == 'female'){
  			jQuery('#woman-radio').prop('checked',true);
 		}
		
		if(jQuery("#pickup_store_modal").prop('checked')){
			
			jQuery('#pickup_store').prop('checked',true).trigger('change');
			submit_pickup_store_status('yes'); //function on lima-save-login-pickup-sore
			
		}else{ 
			
			jQuery('#pickup_store').prop('checked',false).trigger('change');
			submit_pickup_store_status('no'); //function on lima-save-login-pickup-sore
			
		}
		jQuery('#payment-next-btn').trigger('click');
		//jQuery('body').trigger('update_checkout');
		
		jQuery('#editalamatkirim').modal('hide'); 
	}else{
		alert("Please fill all required fields");
	}
  }
  function checkform(form){
	var form = document.getElementById(form);
    // get all the inputs within the submitted form
    var inputs = form.getElementsByTagName('input');
    for (var i = 0; i < inputs.length; i++) {
        // only validate the inputs that have the required attribute
        if(inputs[i].hasAttribute("required")){
            if(inputs[i].value == ""){
                // found an empty field that is required
                return false;
				
            }
        }
    }
	if(!jQuery("#pickup_store_modal").prop('checked')){
		var iselect = form.getElementsByTagName('select');
    	for (var i = 0; i < iselect.length; i++) {
    	    // only validate the inputs that have the required attribute
    	    if(iselect[i].hasAttribute("required")){
    	        if(iselect[i].value == ""){
    	            // found an empty field that is required
    	            return false;
					
        	    }
        	}
    	}
		if($("#billing_address_1_modal").val() == ""){
			return false;	
		}
	}
    return true;
  }
  function editalamat(){
	$("#billing_first_name_modal").val($("#billing_first_name").val());
 	$("#billing_last_name_modal").val($("#billing_last_name").val());
 	$("#billing_address_1_modal").val($("#billing_address_1").val());
 	$("#billing_postcode_modal").val($("#billing_postcode").val());
 	
 	//check_value_storehouse(); //lima-multi-stock
 	
	if(document.getElementById('pickup_store').checked) {
    	$("#pickup_store_modal").attr('checked',true);
		$("#alamat_modal").hide();
		$('#edit_alamat_kirim_provinsi_modal').val(""); 
		$("#edit_alamat_kirim_kota_modal").html("");
		$("#edit_alamat_kirim_kota_modal").val("");	
		$("#edit_alamat_kirim_kecamatan_modal").html("");
		$("#edit_alamat_kirim_kecamatan_modal").val("");
				
	} else {
    	$("#pickup_store_modal").attr('checked',false);
		$("#alamat_modal").show();
		$('#edit_alamat_kirim_provinsi_modal').val($("#billing_state").val()); 
		$("#edit_alamat_kirim_kota_modal").html($("#billing_kota").html());
		$("#edit_alamat_kirim_kota_modal").val($("#billing_kota").val());	
		$("#edit_alamat_kirim_kecamatan_modal").html($("#billing_city").html());
		$("#edit_alamat_kirim_kecamatan_modal").val($("#billing_city").val());
	}
	
	var card_type = $("input[name=billing_gender]:checked").val();
 	if(card_type == 'male'){
  		$('#radio_modal_mele').prop('checked',true);
 	}else if(card_type == 'female'){
  		$('#radio_modal_femele').prop('checked',true);
 	}
	
	
  }
  function change_edit_alamat_kirim_provinsi(provinsi){
	  $("#edit_alamat_kirim_kota_modal").attr("disabled", true);
	  $("#edit_alamat_kirim_kota_modal").html('<option>Meminta Data...</option>');
	  
	  $("#edit_alamat_kirim_kecamatan_modal").attr("disabled", true);
	  $("#edit_alamat_kirim_kecamatan_modal").html('<option>Meminta Data...</option>');
	  //alert(sel.value);
	  var data =  "provinsi="+provinsi.value;
	  var xhttp = new XMLHttpRequest();
 	  	xhttp.onreadystatechange = function() {
      	if (xhttp.readyState == 4 && xhttp.status == 200) {
      		var myArr  = JSON.parse(xhttp.responseText);
			var text = '<option value="">Pilih Kota/Kabupaten</option>';
			for(var i = 0;i < myArr.length; i++){
				text += '<option value="'+myArr[i]+'">'+myArr[i]+'</option>';
			}
			$("#edit_alamat_kirim_kota_modal").attr("disabled", false);
	  		$("#edit_alamat_kirim_kota_modal").html(text);
			$("#edit_alamat_kirim_kecamatan_modal").html('<option>...</option>');
      	}
  	  };
     xhttp.open("POST", "<?=admin_url('admin-ajax.php?action=get_kota_kab')?>", true);
  	 xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	 xhttp.send(data);
  }
  function change_edit_alamat_kirim_kota(kota){
	  $("#edit_alamat_kirim_kecamatan_modal").attr("disabled", true);
	  $("#edit_alamat_kirim_kecamatan_modal").html('<option>Meminta Data...</option>');
	  var provinsi 	= $("#edit_alamat_kirim_provinsi_modal").val();
	  var data 		=  "kota="+kota.value+"&provinsi="+provinsi;

	  var xhttp = new XMLHttpRequest();
 	  xhttp.onreadystatechange = function() {
       if (xhttp.readyState == 4 && xhttp.status == 200) {
      	var myArr  = JSON.parse(xhttp.responseText);
		var text = '<option value="">Pilih Kecamatan</option>';
		for(var i = 0;i < myArr.length; i++){
			text += '<option value="'+myArr[i]+', '+kota.value+'">'+myArr[i]+'</option>';
		}
		//document.getElementById("demo").innerHTML = xhttp.responseText;
		$("#edit_alamat_kirim_kecamatan_modal").attr("disabled", false);
	  	$("#edit_alamat_kirim_kecamatan_modal").html(text);
      }
  	 };
     xhttp.open("POST", "<?=admin_url('admin-ajax.php?action=get_kecamatan')?>", true);
  	 xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	 xhttp.send(data);
  }
  	
	jQuery(document).ready(function(){
		$("#pickup_store_modal").bind('change', function(){
			if(this.checked){
    			$("#pickup_store_modal").attr('checked',true);
				$("#alamat_modal").hide();	
			} else {
    			$("#pickup_store_modal").attr('checked',false);
				$("#alamat_modal").show();
				jQuery('#billing_citty').val('');
			}
		});
		<?php if ( is_user_logged_in() ) { ?>
		//UPDATE BILING AND SHIPPING ADDRESS
	  	$('#billing-information-form input, #billing-information-form textarea, #billing-information-form select').bind('change', function(){
			var uid = "<?=get_current_user_id()?>";
			var meta_value = $(this).val();
			var meta_key = $(this).attr("name");
			$.ajax({
				url:"<?=admin_url('admin-ajax.php')?>",
				cache:false,
				data: {"uid":uid,"meta_value":meta_value,"action":"update_billing_mukti","meta_key":meta_key},
				type:"POST",
				success: function(msg){
					//$("#demo2").html(msg.meta_value);
				}
			});
	  	});
		
		<?php } ?>
	});

</script>
<div id="demo2"></div>
<?php }
add_action('wp_ajax_update_billing_mukti','update_billing_mukti');
//add_action('wp_ajax_nopriv_update_billing_mukti','update_billing_mukti');
function update_billing_mukti(){
 	global $wpdb;
	$user_id = $_REQUEST['uid'];
	$meta_key = $_REQUEST['meta_key'];
	$meta_value = $_REQUEST['meta_value'];
    $count = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->users." WHERE ID = '$user_id'");
    if($count == 1 && $_REQUEST['meta_value'] != ''){ 
		 update_user_meta( $user_id, $meta_key, $meta_value );
		 if($meta_key == 'billing_phone1'){
			 update_user_meta( $user_id, 'billing_phone', $meta_value.'-'.get_user_meta($user_id,'billing_phone2',true) );
		 }elseif($meta_key == 'billing_phone2'){
			 update_user_meta( $user_id, 'billing_phone', get_user_meta($user_id,'billing_phone1',true).'-'.$meta_value );
		 }
		 
		 if($meta_key == 'billing_mobile1'){
			 update_user_meta( $user_id, 'billing_mobile', $meta_value.'-'.get_user_meta($user_id,'billing_mobile2',true) );
		 }elseif($meta_key == 'billing_mobile2'){
			 update_user_meta( $user_id, 'billing_mobile', get_user_meta($user_id,'billing_mobile1',true).'-'.$meta_value );
		 }
		 
	}
	//echo wp_send_json( $_REQUEST );
	wp_die();
}
add_action('wp_ajax_nopriv_get_kecamatan','get_kecamatan');
add_action('wp_ajax_get_kecamatan','get_kecamatan');
function get_kecamatan(){
	$datakota = WC_JNE()->shipping->get_datakota();
	$provinsi = WC()->countries->get_states( 'ID' );
	$result = array();
	if( count( $datakota ) ){
		if( is_array( $datakota ) ){
			foreach( $datakota as $nama_provinsi => $data_kota ){
				if( $provinsi[$_POST['provinsi']] === $nama_provinsi ){
					foreach( $data_kota as $nama_kota => $data_kecamatan ){
						if( $_POST['kota'] === $nama_kota ){
							foreach( $data_kecamatan as $nama_kecamatan => $data_harga ){
								$result[] = $nama_kecamatan;
							}
						}
					}
				}
			}
		}
	}
	wp_send_json( $result );
	wp_die();	
}

add_action('wp_ajax_nopriv_get_kota_kab','get_kota_kab');
add_action('wp_ajax_get_kota_kab','get_kota_kab');
function get_kota_kab(){
	//echo '<pre>';
	$provinsi = WC()->countries->get_states( 'ID' );
	$datakota = WC_JNE()->shipping->get_datakota();	
	if( count( $datakota ) ){
		if( is_array( $datakota ) ){
			foreach( $datakota as $nama_provinsi => $data_kota ){
				if( $provinsi[$_REQUEST['provinsi']] === $nama_provinsi ){
					foreach( $data_kota as $nama_kota => $data_kecamatan ){
						$result[] = $nama_kota;
					}
				}
			}
		}
	}
	echo wp_send_json( $result );
	wp_die();
}

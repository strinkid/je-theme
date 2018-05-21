<?php 
global $current_user,$product;
if($product->is_in_stock()) return;
$display_name = $current_user->data->display_name != '' ? $current_user->data->display_name : '';
$email = $current_user->data->user_email != '' ? $current_user->data->user_email : '';
?> 
<div class="productDetailsMeta habis-terjual" style="display:none;">
    <span>Special Product</span>
    <p>Tanya CS?</p>
    <span class="btn btn-warning btn-xs" style="width:50%" data-toggle="modal" data-target="#myModal-tanyakepabrik">Ya</span> <span style="font-size: 10px; color: #979392; float:right; margin-top:5px;">Sen-Sab</span>
    <div style="font-size: 10px; color: #979392; text-align:right">08:00-15:00
        <br>Dijawab Maks. 1 Jam</div>
</div>
<!-- Modal Tanya Ke Pabrik-->
<div id="myModal-tanyakepabrik" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">OK, akan kita tanyakan ke pabrik.</h4>
      </div>
      <div class="modal-body">

        <h4 style="font-size:16px;" id="tanyahead">Silahkan isi data diri Anda untuk kami hubungi.</h4>
        <div id="tanya_pabrik_reason" style="display:none;"></div>
        <div class="form-horizontal" role="form" id="form-tanya-pabrik">
  		  <div class="form-group">
    		<label class="control-label col-sm-2">Nama:</label>
    		<div class="col-sm-10">
      			<input type="text" class="form-control input-sm" name="n" value="<?php echo $display_name;?>">
    		</div>
  		  </div>
          <div class="form-group">
    		<label class="control-label col-sm-2">Email:</label>
    		<div class="col-sm-10">
      			<input type="text" class="form-control input-sm" name="e" value="<?php echo $email;?>">
    		</div>
  		  </div>
          <div class="form-group">
    		<label class="control-label col-sm-2">Telephone:</label>
    		<div class="col-sm-10">
      			<input type="text" class="form-control input-sm" name="t">
    		</div>
  		  </div>
		</div>
        
      </div>
	  <div class="modal-footer">
      	<button type="button" class="btn btn-primary" id="tanyakan" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Tanya Ke Pabrik</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
jQuery(document).ready(function(e) {
	var $ = jQuery;
	jQuery( '[data-target="#myModal-tanyakepabrik"]' ).on('click', function(){
    	$('#tanya_pabrik_reason').attr('class','').hide();
	});

    $('.habis-terjual').fadeIn();
	$('#tanyakan').click(function(e) {
		var $this = $(this);
  		$this.button('loading');
		$('#tanya_pabrik_reason').attr('class','').hide();
		var id = "<?php echo get_the_ID();?>";
		var n = $('[name="n"]').val();
		var e = $('[name="e"]').val();
		var t = $('[name="t"]').val();
        $.ajax({
			url:"<?php echo admin_url( 'admin-ajax.php' );?>",
			cache:false,
			type:"POST",
			data:{'action':'tanya_ke_pabrik','id':id,'n':n,'e':e,'t':t},
			success: function(msg){
				$this.button('reset');
				var obj = JSON.parse(msg);
				if(obj.code == 1){
					$('#tanya_pabrik_reason').addClass('alert alert-success').html('<i class="fa fa-check fa-lg" style="color:#3c763d !important;"></i> '+obj.reason).show();
					$('#form-tanya-pabrik').hide();
					$('#tanyakan').hide();
					$('#tanyahead').hide();
					
				}else{
					$('#tanya_pabrik_reason').addClass('alert alert-danger').html('<i class="fa fa-exclamation-triangle fa-lg" style="color:#a94442 !important;"></i> '+obj.reason).show();
				}
			}
		});
	});
});
</script>
<!-- BEGIN PAGE HEADER-->
<div class="row-fluid">
   <div class="span12">
      <!-- BEGIN STYLE CUSTOMIZER -->
      <div class="color-panel hidden-phone">
         <div class="color-mode-icons icon-color"></div>
         <div class="color-mode-icons icon-color-close"></div>
         <div class="color-mode">
            <p>THEME COLOR</p>
            <ul class="inline">
               <li class="color-black current color-default" data-style="default"></li>
               <li class="color-blue" data-style="blue"></li>
               <li class="color-brown" data-style="brown"></li>
               <li class="color-purple" data-style="purple"></li>
               <li class="color-white color-light" data-style="light"></li>
            </ul>
            <label class="hidden-phone">
            <input type="checkbox" class="header" checked value="" />
            <span class="color-mode-label">Fixed Header</span>
            </label>                   
         </div>
      </div>
      <!-- END BEGIN STYLE CUSTOMIZER -->
      <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <h3 class="page-title">
      Transaction <small>Registrasi Perpanjang Tabber </small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Transaction</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Registrasi Perpanjangan Tabber</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->





<!-- BEGIN ADD USER -->
<div id="add" class="">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Registrasi Perpanjangan Tabber</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_add" class="form-horizontal">

            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Berhasil!
            </div>
            </br>
                     <div class="control-group">
              <label class="control-label">No Rekening<span class="required">*</span></label>
              <div class="controls">
                 <input type="text" name="account_saving_no" readonly="" id="account_saving_no" data-required="1" class="medium m-wrap" style="background-color:#eee;"/>
                 <input type="hidden" id="branch_code" name="branch_code">
                 <input type="hidden" id="cif_no" name="cif_no">
                 
                 <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                    <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                       <h3>Cari CIF</h3>
                    </div>
                    <div class="modal-body">
                       <div class="row-fluid">
                          <div class="span12">
                            <h4>Masukan Kata Kunci</h4>
							  <?php /*
                              if($this->session->userdata('cif_type')==0){
                              ?>
                                <input type="hidden" id="cif_type" name="cif_type" value="0">
                                <p id="pcm" style="height:32px">
                                <select id="cm" class="span12 m-wrap chosen" style="width:530px !important;">
                                <option value="">Pilih Rembug</option>
                                <?php foreach($rembugs as $rembug): ?>
                                <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
                                <?php endforeach; ?>;
                                </select></p>
                              <?php
                              }else if($this->session->userdata('cif_type')==1){
                                echo '<input type="hidden" id="cif_type" name="cif_type" value="1">';
                              }else{
                                  */
                              ?>
                                <p><select name="cif_type" id="cif_type" class="span12 m-wrap">
                                <option value="">Pilih Tipe CIF</option>
                                <option value="" class="hidden">All</option>
                                <option value="1">Individu</option>
                                <option value="0" selected="selected">Kelompok</option>
                                </select></p>
                                <p class="hide" id="pcm" style="height:32px">
                                <select id="cm" class="span12 m-wrap chosen" style="width:530px !important;">
                                <option value="">Pilih Rembug</option>
                                <?php foreach($rembugs as $rembug): ?>
                                <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
                                <?php endforeach; ?>;
                                </select></p>
                              <?php
                              //}
                              ?>
                            <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                            <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
                           
                          </div>
                       </div>
                    </div>
                    <div class="modal-footer">
                       <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
                       <button type="button" id="select" class="btn blue">Select</button>
                    </div>
                 </div>

               <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
              </div>
           </div>        
                    <div class="control-group">
                       <label class="control-label">Nama Lengkap</label>
                       <div class="controls">
                          <input type="text" name="nama" id="nama" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Majlis</label>
                       <div class="controls">
                          <input type="text" name="majlis" id="majlis" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Nama Panggilan</label>
                       <div class="controls">
                          <input type="text" name="panggilan" id="panggilan" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                       
                    <div class="control-group">
                       <label class="control-label">Nama Ibu Kandung</label>
                       <div class="controls">
                          <input type="text" name="ibu_kandung" id="ibu_kandung" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                    
                    <div class="control-group">
                       <label class="control-label">Tempat Lahir</label>
                       <div class="controls">
                          <input type="text" name="tmp_lahir" id="tmp_lahir" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                 
                    <div class="control-group">
                       <label class="control-label">Tanggal Lahir</label>
                       <div class="controls">
                          <input type="text" name="tgl_lahir" id="tgl_lahir" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                
                    <div class="control-group">
                       <label class="control-label">Produk</label>
                       <div class="controls">
                       <input type="text" class="medium m-wrap" readonly="" id="product" name="product" style="background-color:#eee;" >
                       <input type="hidden" class="medium m-wrap" readonly="" id="product_code" name="product_code" >
                         
                       </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label">Biaya Administrasi</label>
                      <div class="controls">
                        <div class="input-preppend input-append">
                          <div class="add-on">Rp</div>
                          <input type="text" class="mask-money m-wrap small" readonly="" id="biaya_administrasi" name="biaya_administrasi" style="background-color:#eee;" >
                          <div class="add-on">,00</div>
                        </div>
                      </div>
                    </div>
                   
                    <hr> 
                  <div id="tabungan_berencana">   
                    <div class="control-group">
                       <label class="control-label" style="text-decoration:underline">Tabungan Berencana</label>
                    </div>     
                    <div class="control-group">
                       <label class="control-label">Setoran</label>
                       <div class="controls">
                          <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" name="rencana_setoran" style="width:120px; background-color:#eee;" id="rencana_setoran" data-required="1" readonly="" class="m-wrap mask-money" maxlength="10"/>
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Periode Setoran</label>
                       <div class="controls">
                          <select id="rencana_periode_setoran" name="rencana_periode_setoran" class="m-wrap" data-required="1" style="width:120px;background-color:#f5f5f5;" disabled="disabled">
                              <option value="0" disabled>Bulanan</option>
                              <option value="1" disabled>Mingguan</option>
                              <option value="2" disabled>Harian</option>
                          </select>
                       </div>
                    </div>  
                    
                    <div class="control-group">
                       <label class="control-label">Rencana Awal Setoran</label>
                       <div class="controls">
                          <input type="text" name="rencana_setoran_next" id="rencana_setoran_next" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                          
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Tanggal Pembukaan</label>
                       <div class="controls">
                          <input type="text" name="tanggal_pembukaan" id="tanggal_pembukaan" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                          
                       </div>
                    </div>  
                  </div>
                  <hr>
                  <!-- START PERPANJANGAN TABBER -->
                  <div id="tabungan_berencana2">   
                    <div class="control-group">
                       <label class="control-label" style="text-decoration:underline">Perpanjang Tabber</label>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu Awal</label>
                       <div class="controls">
                          <input type="text" name="rencana_jangka_waktu" style="width:50px;background-color:#eee;" id="rencana_jangka_waktu" data-required="1" class="m-wrap"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="3" readonly="" />
                           <input type="hidden" name="counter_angsruan"  style="width:50px;background-color:#eee;" id="counter_angsruan" data-required="1" class="m-wrap" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="3" />
                       </div>
                    </div>       
                    
                    <div class="control-group">
                       <label class="control-label">Perpanjangan J Waktu <span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="rencana_jangka_waktu2"  style="width:50px;" id="rencana_jangka_waktu2" data-required="1" class="m-wrap" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="3" />

                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu Akhir</label>
                       <div class="controls">
                          <input type="text" name="rencana_jangka_waktu_akhir2"  style="width:50px;background-color:#eee;" id="rencana_jangka_waktu_akhir2" data-required="1" class="m-wrap" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="3" readonly="" />

                       </div>
                    </div>  
                    
                    <div class="control-group">
                       <label class="control-label">Tanggal Perpanjangan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_perpanjangan" style="width:120px;" id="tanggal_perpanjangan" data-required="1" class="date-picker small m-wrap"/>
                       </div>
                    </div> 
                     
                  </div>
                  <!-- END PERPANJANGAN TABBER -->
            <div class="form-actions">
               <button type="submit" class="btn green">Simpan</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END ADD USER -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/jquery.json-2.2.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/index.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>       
<script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script> 
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
    
      $("#tgl_lahir").inputmask("y/m/d", {autoUnmask: true});  //direct mask
      //$("#rencana_setoran_next").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("#rencana_setoran_next2").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("#tanggal_pembukaan").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("#tanggal_perpanjangan").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      //$("#rencana_setoran_next").inputmask("d/m/y", {autoUnmask: true});
      $("#tanggal_jtempo").inputmask("d/m/y", {autoUnmask: true});

   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->

<script type="text/javascript">
      $(function(){
		  $('#browse_rembug').click(function(){
			  $("select#cif_type").trigger('change');
		  });

        $("#cif_type","#form_add").change(function(){
          type = $("#cif_type","#form_add").val();
          cm_code = $("select#cm").val();
          if(type=="0"){
            $("p#pcm").show();
          }else{
            $("p#pcm").hide().val('');

			  $.ajax({
				type: "POST",
				url: site_url+"cif/search_account_no",
				data: {keyword:$("#keyword").val(),cif_type:type,cm_code:''},
				dataType: "json",
				success: function(response){
					var option = '';
					if(type=="0"){
					  for(i = 0 ; i < response.length ; i++){
						option += '<option value="'+response[i].account_saving_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_saving_no+' - '+response[i].cm_name+'</option>';
					  }
					}else if(type=="1"){
					  for(i = 0 ; i < response.length ; i++){
						option += '<option value="'+response[i].account_saving_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_saving_no+'</option>';
					  }
					}else{
					  for(i = 0 ; i < response.length ; i++){
						if(response[i].cm_name!=null){
						  cm_name = " - "+response[i].cm_name;   
						}else{
						  cm_name = "";
						}
						option += '<option value="'+response[i].account_saving_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_saving_no+''+cm_name+'</option>';
					  }
					}
				  // console.log(option);
				  $("#result").html(option);
				}
			  });
          }
          
        })

        $('#keyword').on('keypress',function(e){
			if(e.which == 13){
				cm_code = $('select#cm').val();
				type = $("#cif_type").val();
				keyword = $(this).val();
				
				if(cm_code == ''){
					$('#result').html('');
				} else {
					$.ajax({
						type: 'POST',
						url: site_url+'cif/search_account_no',
						data: {
							keyword:keyword,
							cif_type:type,
							cm_code:cm_code
						},
						dataType: 'json',
						async: false,
						success: function(response){
							var option = '';
							var length = response.length;

							for(i = 0 ; i < length ; i++){
								var rekening = response[i].account_saving_no;
								var nama = response[i].nama;
								var produk = response[i].nick_name;
	
								option += '<option value="'+rekening+'">'+nama+' - '+rekening+' - '+produk+'</option>';
							}
	
							$('#result').html(option);
						}
					});
				}
			}
		})
        
        $("select#cm").on('change',function(e){
          cm_code = $(this).val();
		  type = $("#cif_type").val();
		  keyword = $('#keyword').val();

          if(cm_code == ''){
			  $('#result').html('');
          } else {
			  $.ajax({
				  type: 'POST',
				  url: site_url+'cif/search_account_no',
				  data: {
					  keyword:keyword,
					  cif_type:type,
					  cm_code:cm_code
				  },
				  dataType: 'json',
				  success: function(response){
					  var option = '';
					  var length = response.length;
					  for(i = 0 ; i < length ; i++){
						  var rekening = response[i].account_saving_no;
						  var nama = response[i].nama;
						  var produk = response[i].nick_name;

						  option += '<option value="'+rekening+'">'+nama+' - '+rekening+' - '+produk+'</option>';
					  }

					  $('#result').html(option);
				  }
			  });
		  }
        });
      
        $('#select').click(function(){
			var rekening = $('#result').val();

            $.ajax({
              type: 'POST',
              dataType: 'json',
              data: {rekening:rekening},
              url: site_url+'rekening_nasabah/search_rekening_tabungan',
              success: function(response){
				  var account_no = response.account_saving_no;
				  var nama = response.nama;
				  var majelis = response.majelis;
				  var ibu_kandung = response.ibu_kandung;
				  var tmp_lahir = response.tmp_lahir;
				  var tgl_lahir = response.tgl_lahir;
				  var product_name = response.product_name;
				  var biaya_administrasi = response.biaya_administrasi;
				  var rencana_setoran = response.rencana_setoran;
				  var rencana_periode_setoran = response.rencana_periode_setoran;
				  var rencana_setoran_next = response.rencana_setoran_next;
				  var tanggal_buka = response.tanggal_buka;
				  var rencana_jangka_waktu = response.rencana_jangka_waktu;
				  var counter_angsruan = response.counter_angsruan;

				  $('#account_saving_no').val(account_no);
				  $("#nama").val(response.nama);
				  $('#majlis').val(majelis);
				  $('#panggilan').val(nama);
				  $('#ibu_kandung').val(ibu_kandung);
				  $('#tmp_lahir').val(tmp_lahir);
				  $('#tgl_lahir').val(tgl_lahir);
				  $('#product').val(response.product_name);
				  $('#biaya_administrasi').val(biaya_administrasi);
				  $('#rencana_setoran').val(rencana_setoran);
				  $('#rencana_periode_setoran').val(rencana_periode_setoran);
				  $('#rencana_setoran_next').val(rencana_setoran_next);
				  $('#tanggal_pembukaan').val(tanggal_buka);
				  $('#rencana_jangka_waktu').val(rencana_jangka_waktu);
				  $('#counter_angsruan').val(counter_angsruan);
              }
            }); 

			$('#close','#dialog_rembug').trigger('click');
        });

		$('#rencana_jangka_waktu,#rencana_jangka_waktu2').change(function(){
			var rencana_jangka_waktu = $('#rencana_jangka_waktu').val();
			var rencana_jangka_waktu2 = $('#rencana_jangka_waktu2').val();
			var rencana_jangka_waktu_akhir = parseFloat(rencana_jangka_waktu) + parseFloat(rencana_jangka_waktu2);

			$('#rencana_jangka_waktu_akhir2').val(rencana_jangka_waktu_akhir);
		});
        
        $("#result option").live('dblclick',function(){
          $("#select").trigger('click');

        });

      });


  // BEGIN FORM EDIT VALIDATION
  var form2 = $('#form_add');
  var error2 = $('.alert-error', form2);
  var success2 = $('.alert-success', form2);

  form2.validate({
	  errorElement: 'span',
      errorClass: 'help-inline',
      focusInvalid: false,
      errorPlacement: function(error, element) {
        element.closest('.controls').append(error);
      },
      rules: {
          rencana_jangka_waktu2: {
            required: true
          },
          tanggal_perpanjangan: {
            required: true
          }
      },

      invalidHandler: function (event, validator) {
          success2.hide();
          error2.show();
          App.scrollTo(error2, -200);
      },

      highlight: function (element) {
          $(element)
              .closest('.help-inline').removeClass('ok');
          $(element)
              .closest('.control-group').removeClass('success').addClass('error');
      },

      unhighlight: function (element) {
          $(element)
              .closest('.control-group').removeClass('error');
      },

      success: function (label) {
        if(label.closest('.input-append').length==0)
        {
          label
              .addClass('valid').addClass('help-inline ok')
          .closest('.control-group').removeClass('error').addClass('success');
        }
        else
        {
           label.closest('.control-group').removeClass('error').addClass('success')
           label.remove();
        }
      },

      submitHandler: function (form){
		  $.ajax({
			  type: 'POST',
			  url: site_url+'transaction/do_perpanjang_tabber',
			  async: true,
			  dataType: 'json',
			  data: form2.serialize(),
			  success: function(response){
				  if(response.success == true){
                    success2.show();
                    error2.hide();
                    $('div.control-group').removeClass('success');
					$('span.help-inline').removeClass('ok');
					form2.trigger('reset');
                  }else{
                    alert(response.message);
                    success2.hide();
                    error2.show();
                  }

                  App.scrollTo(error2, -500);
			  },
			  error:function(){
				  success2.hide();
				  error2.show();
				  App.scrollTo(error2, -500);
			  }
        });
      }
});
//  END FORM EDIT VALIDATION
</script>


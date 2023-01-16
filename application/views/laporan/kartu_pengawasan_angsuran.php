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
      <!-- BEGIN PAGE TITLE-->
      <h3 class="form-section">
        Laporan <small>Kartu Pengawasan Angsuran</small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->


<form action="#" id="form_add" class="form-horizontal">
<!-- BEGIN FILTER-->
<div class="row-fluid">
  <div class="span8">
    <div class="control-group" style="margin-bottom:0;">
       <label class="control-label" style="text-align:left;width:130px;">No Rekening<span class="required">*</span></label>
       <div class="controls" style="margin-left:0;">
          <input type="text" name="account_financing_no" id="account_financing_no" data-required="1" class="medium m-wrap" style="background-color:#eee;"/>
          <input type="hidden" id="branch_code" name="branch_code">
          <input type="hidden" id="account_type" name="account_type">
          <input type="hidden" id="jenis_tabungan" name="jenis_tabungan">
          
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
                <button type="button" id="select_res" class="btn blue">Select</button>
             </div>
          </div>

        <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
       </div>
    </div>            
  </div>
  <div class="span4 text-right">
    <input type="hidden" name="hidden_account_financing_no" id="hidden_account_financing_no">
    <button type="button" id="export_pdf_lengkap" class="btn green">Cetak Lengkap</button>
    <button type="button" id="export_pdf" class="btn green">Cetak Standar</button>
  </div>
</div>
</form>
<table width="100%" style="border:solid 1px #CCC;margin-bottom:20px;" >
    <tr>
        <td>
          
          <table align="center" style="border:solid 1px #CCC; margin:10px auto;"  width="70%">
                <tr>
                    <td style="background:#EEE; padding:5px;" width="15%" >Nama</td>
                    <td style="background:#EEE; padding:5px;" width="2%" >:</td>
                    <td style="background:#EEE; padding:5px;" width="25%" ><input id="res_nama" type="text" style="font-size:12px;width:100px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;" readonly="readonly"></td>
                    <td style="background:#EEE; padding:5px;" width="15%">Plafon</td>
                    <td style="background:#EEE; padding:5px;" width="2%">:</td>
                    <td style="background:#EEE; padding:5px;" width="35%"><input id="res_plafon" type="text" style="font-size:12px;width:90px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;" readonly="readonly"></td>
                    <td style="background:#EEE; padding:5px;" >Angs. Pokok</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="angsuran_pokok" type="text" style="font-size:12px;width:100px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;" readonly="readonly"></td>
                </tr>
                
                <tr>
                    <td style="background:#EEE; padding:5px;" >Rembug</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_rembug" type="text" style="font-size:12px;width:100px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;" readonly="readonly"></td>
                    <td style="background:#EEE; padding:5px;" >Margin</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_margin" type="text" style="font-size:12px;width:90px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;" readonly="readonly"></td>
                     <td style="background:#EEE; padding:5px;" >Angs. Margin</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="angsuran_margin" type="text" style="font-size:12px;width:90px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;" readonly="readonly"></td>    
                </tr>
               
                <tr>
                    <td style="background:#EEE; padding:5px;" >Desa</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_desa" type="text" style="font-size:12px;width:100px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;" readonly="readonly"></td>
                    <td style="background:#EEE; padding:5px;" >Jangka Waktu</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;"><input id="jangka_waktu" type="text" style="font-size:12px;width:90px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;" readonly="readonly"></td>
                    <td style="background:#EEE; padding:5px;" >Angs. Catab</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="angsuran_catab" type="text" style="font-size:12px;width:90px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;" readonly="readonly"></td>
                </tr>
                
                <tr>
                    <td style="background:#EEE; padding:5px;" >Produk</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_produk" type="text" style="font-size:12px;width:100px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;" readonly="readonly"></td>
                    <td style="background:#EEE; padding:5px;" >Tgl. Cair</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_cair" type="text" style="font-size:12px;width:90px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;" readonly="readonly"></td>
                    <td style="background:#EEE; padding:5px;" >Tab Wajib</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="tab_wajib" type="text" style="font-size:12px;width:90px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;" readonly="readonly"></td>
                </tr>
                
                <tr>
                    <td style="background:#EEE; padding:5px;" >Untuk</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_untuk" type="text" style="font-size:12px;width:100px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;" readonly="readonly"></td>
                    <td style="background:#EEE; padding:5px;" >Tgl. J. Tempo</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_jtempo" type="text" style="font-size:12px;width:90px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;" readonly="readonly"></td>
                    <td style="background:#EEE; padding:5px;" >Tab Kelompok</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="tab_kelompok" type="text" style="font-size:12px;width:90px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;" readonly="readonly"></td>
                </tr>

                <tr>
                    
                    <td style="background:#EEE; padding:5px;" > Rek. Tabungan</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_no_rekening_tabungan" type="text" style="font-size:12px;width:100px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;" readonly="readonly"></td>
                    
                    <td style="background:#EEE; padding:5px;" >PYD Ke</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_pydke" type="text" style="font-size:12px;width:90px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;" readonly="readonly"></td>
                    <td style="background:#EEE; padding:5px;" >Status Rekening</td>
                    <td style="background:#EEE; padding:5px;" >:</td>
                    <td style="background:#EEE; padding:5px;" ><input id="res_statrek" type="text" style="font-size:12px;width:90px;padding:1px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;border:#eee; background-color:#eee;" readonly="readonly"></td>
                </tr>
          </table>

        </td>
    </tr>
    <tr>
        <td>
            <table align="center" style="border:solid 1px #CCC; margin:10px auto;"  width="70%"  id="isi_data">
              <thead>                  
                <tr>
                    <td colspan="2" style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center;">Tanggal</td>
                    <td colspan="2" style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center;">Angsuran</td>
                    <td rowspan="2" style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center;">Saldo Pokok</td>
                    <td rowspan="2" style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center;">Saldo Margin</td>
                    <td rowspan="2" style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center;">Saldo Catab</td>
                    <td rowspan="2" style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center;">Validasi</td>
                </tr>
                <tr>
                    <td style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center;">Angsur</td>
                    <td style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center;">Bayar</td>
                    <td style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center;">Ke</td>
                    <td style="background:#EEE; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; text-align:center;">Jumlah</td>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
        </td>
    </tr>
</table>



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
     
      $("#tanggal").inputmask("d/m/y", {autoUnmask: true});  //direct mask       
      $("#tanggal2").inputmask("d/m/y", {autoUnmask: true});  //direct mask      
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
      
      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
           var dTreload = function()
      {
        var tbl_id = 'saldo_kas_petugas';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }
	  
	  $('#browse_rembug').click(function(){
		  $("select#cif_type").trigger('change');
	  });
    

 $("#button-dialog").click(function(){
          $("#dialog").dialog('open');
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
              url: site_url+"cif/search_no_pembiayaan",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                  if(response[i].status_rekening == 0){
                    var status_rekening = 'Baru Registrasi';
                  } else if(response[i].status_rekening == 1){
                    var status_rekening = 'Aktif';
                  } else if(response[i].status_rekening == 2){
                    var status_rekening = 'Lunas';
                  } else {
                    var status_rekening = 'Verified';
                  }
                  option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].account_financing_no+' - '+response[i].nama+' - '+response[i].nick_name+' - '+status_rekening+'</option>';
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
          }
        });

        $("#keyword").on('keypress',function(e){
          if(e.which==13){
            type = $("#cif_type","#form_add").val();
            cm_code = $("select#cm").val();
            if(type=="0"){
              $("p#pcm").show();
            }else{
              $("p#pcm").hide().val('');
            }
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_no_pembiayaan",
              data: {keyword:$(this).val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              async: false,
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                  if(response[i].status_rekening == 0){
                    var status_rekening = 'Baru Registrasi';
                  } else if(response[i].status_rekening == 1){
                    var status_rekening = 'Aktif';
                  } else if(response[i].status_rekening == 2){
                    var status_rekening = 'Lunas';
                  } else {
                    var status_rekening = 'Verified';
                  }
                   option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].account_financing_no+' - '+response[i].nama+' - '+response[i].nick_name+' - '+status_rekening+'</option>';
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
            return false;
          }
        });

        $("select#cm").on('change',function(e){
          type = $("#cif_type","#form_add").val();
          cm_code = $(this).val();

            $.ajax({
              type: "POST",
              url: site_url+"cif/search_no_pembiayaan",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                  if(response[i].status_rekening == 0){
                    var status_rekening = 'Baru Registrasi';
                  } else if(response[i].status_rekening == 1){
                    var status_rekening = 'Aktif';
                  } else if(response[i].status_rekening == 2){
                    var status_rekening = 'Lunas';
                  } else {
                    var status_rekening = 'Verified';
                  }
                   option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].account_financing_no+' - '+response[i].nama+' - '+response[i].nick_name+' - '+status_rekening+'</option>';
                }
                $("#result").html(option);
              }
            });

          if(cm_code=="")
          {
            $("#result").html('');
          }
        });
      

      // VIEW DATA YANG TERPILIH
      $("#select_res","#form_add").click(function()
        {
          $("#close","#dialog_rembug").trigger('click');
          var account_financing_no = $("#result").val();
          $("#account_financing_no").val(account_financing_no);
          $("#hidden_account_financing_no").val(account_financing_no);
            $.ajax({
              type: "POST",
              url: site_url+"laporan/get_kartu_pengawasan_angsuran_by_account_no",
              data: {account_financing_no:account_financing_no},
              dataType: "json",
              success: function(response)
              {
                  $("#res_nama").val(response.nama);
                  $("#res_rembug").val(response.cm_name);
                  $("#res_desa").val(response.desa);
                  $("#res_produk").val(response.product_name);
                  $("#res_untuk").val(response.untuk);
                  $("#res_no_rekening_tabungan").val(response.account_saving_no);
                  $("#res_plafon").val(number_format(response.pokok,0,',','.'));
                  $("#res_margin").val(number_format(response.margin,0,',','.'));
                  $("#res_cair").val(response.droping_date);
                  $("#res_jtempo").val(response.tanggal_jtempo);
                  $("#res_pydke").val(response.pydke);
                  $("#angsuran_pokok").val(number_format(response.angsuran_pokok,0,',','.'));
                  $("#angsuran_margin").val(number_format(response.angsuran_margin,0,',','.'));
                  $("#angsuran_catab").val(number_format(response.angsuran_catab,0,',','.'));

                  $("#jangka_waktu").val(response.jangka_waktu);
                  $("#tab_wajib").val(response.angsuran_tab_wajib);
                  $("#tab_kelompok").val(response.angsuran_tab_kelompok);
                  //$("#status_rekening").val(response.status_rekening);

                  var stat_rek = response.status_rekening;

                  if(stat_rek == 0){
                    var statusrek = 'Baru Registrasi';
                  } else if(stat_rek == 1){
                    var statusrek = 'Aktif'
                  } else if(stat_rek == 2){
                    var statusrek = 'Lunas'
                  } else {
                    var statusrek = 'Verified'
                  }

                  $("#res_statrek").val(statusrek);

                if(response.nama!=undefined)
                {
                   $.ajax({
                      type: "POST",
                      url: site_url+"laporan/get_row_pembiayaan_by_account_no",
                      data: {account_financing_no:account_financing_no,cif_no:response.cif_no,cif_type:response.cif_type,financing_type:response.financing_type},
                      dataType: "html",
                      success: function(response)
                      {
                        $("#isi_data tbody").html(response);
                      },
					  error: function(){
						  alert('Maaf! Koneksi Anda tidak stabil');
					  }
                    });
                 }
                 else
                 {
                    $("#isi_data tbody").html('');
                 }
              }
            });

        });

   

      //export PDF
      $("#export_pdf").live('click',function()
      {
        var account_financing_no    = $("#hidden_account_financing_no").val();
        window.open('<?php echo site_url();?>laporan_to_pdf/export_kartu_pengawasan_angsuran/'+account_financing_no+'/');
      });

      //export PDF Lengkap
      $("#export_pdf_lengkap").live('click',function()
      {
        var account_financing_no    = $("#hidden_account_financing_no").val();
        window.open('<?php echo site_url();?>laporan_to_pdf/export_kartu_pengawasan_angsuran_lengkap/'+account_financing_no+'/');
      });

      //export XLS
      $("#export_excel").live('click',function()
      {
        var account_financing_no    = $("#hidden_account_financing_no").val();
        window.open('<?php echo site_url();?>laporan_to_excel/export_kartu_pengawasan_angsuran/'+account_financing_no+'/');
      });



      $(".dataTables_filter").parent().hide(); //menghilangkan serch
      
      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

</script>
<!-- END JAVASCRIPTS -->


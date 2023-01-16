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
      CIF Kelompok
    </h3>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- DIALOG BRANCH -->
<div id="dialog_kantor_cabang" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Kantor Cabang</h3>
   </div>
   <div class="modal-body">
      <div class="row-fluid">
         <div class="span12">
            <h4>Masukan Kata Kunci</h4>
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


<!-- BEGIN ADD USER -->
<div id="add">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Mutasi Anggota Keluar</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM--> 
         <form action="#" id="form_add" class="form-horizontal">  <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Anggota Berhasil Dikeluarkan !
            </div>
            <br>
            <!-- DIALOG CM -->
            <div id="dialog_cm" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h3>Cari Rembug Pusat</h3>
               </div>
               <div class="modal-body">
                  <div class="row-fluid">
                     <div class="span12">
                        <h4>Masukan Kata Kunci</h4>
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
            <div style="clear:both;overflow:auto;">

          <div class="control-group">
             <label class="control-label">Kantor Cabang</label>
             <div class="controls">
                <input type="text" name="branch_name" id="branch_name" data-required="1" class="medium m-wrap" value="<?php echo $this->session->userdata('branch_name'); ?>" readonly style="background:#EEE"/>
                <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code') ?>">
                <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id') ?>">
                <?php if($this->session->userdata('flag_all_branch')=='1'){ ?><a id="browse_branch" class="btn blue" data-toggle="modal" href="#dialog_kantor_cabang">...</a><?php } ?>
             </div>
          </div>
          <hr>

            <div style="width:50%;float:left">
            <div class="control-group">
               <label class="control-label">Rembug<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="rembug" id="rembug" data-required="1" class="medium m-wrap" readonly=""  style="background-color:#f9f9f9;"/>  
                  <input type="hidden" name="cm_code" id="cm_code">
                <a id="browse_cm" class="btn blue" data-toggle="modal" href="#dialog_cm">...</a>
               </div>
            </div>  
            <div class="control-group">
               <label class="control-label">ID Anggota<span class="required">*</span></label>
               <div class="controls">
                    <select name="id_anggota" id="id_anggota" class="large m-wrap"></select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama </label>
               <div class="controls">
                  <input type="text" name="nama" id="nama" data-required="1" class="medium m-wrap" readonly=""  style="background-color:#f9f9f9;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Mutasi<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" id="tanggal_mutasi" name="tanggal_mutasi" class="datemask date-picker m-wrap medium" placeholder="DD/MM/YYYY">
               </div> 
            </div> 
            <div class="control-group">
               <label class="control-label">Alasan<span class="required">*</span></label>
               <div class="controls">
                <select class="m-wrap medium" name="alasan">
                  <option value="">PILIH</option>
                  <?php foreach ($alasan as $key):?>
                    <option value="<?php echo $key['code_value'];?>"><?php echo $key['display_text'];?></option>
                  <?php endforeach;?>
                </select>
               </div> 
            </div> 
            <div class="control-group">
               <label class="control-label">keterangan<span class="required">*</span></label>
               <div class="controls">
                  <textarea id="keterangan" name="keterangan" class="m-wrap medium"></textarea>
               </div> 
            </div> 

            <div class="control-group">
               <label class="control-label">Saldo Pembiayaan</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="saldo_pembiayaan" id="saldo_pembiayaan" data-required="1" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Margin</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="saldo_margin" id="saldo_margin" data-required="1" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                  <span style="line-height:32px;margin-left:10px"><input type="checkbox" id="flag_saldo_margin" name="flag_saldo_margin" value="1" checked="checked"></span>
                </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Catab</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="saldo_catab" id="saldo_catab" data-required="1" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                  <span style="line-height:32px;margin-left:10px;display:none;"><input type="checkbox" id="flag_saldo_catab" name="flag_saldo_catab" value="1" checked="checked"></span>
                </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Tabungan Wajib</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="saldo_tabungan_wajib" id="saldo_tabungan_wajib" data-required="1" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                  <span style="line-height:32px;margin-left:10px;display:none;"><input type="checkbox" id="flag_saldo_tabungan_wajib" name="flag_saldo_tabungan_wajib" value="1" checked="checked"></span>                  
                </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Tabungan Kelompok</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="saldo_tabungan_kelompok" id="saldo_tabungan_kelompok" data-required="1" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                  <span style="line-height:32px;margin-left:10px;display:none;"><input type="checkbox" id="flag_saldo_tabungan_kelompok" name="flag_saldo_tabungan_kelompok" value="1" checked="checked"></span>
                </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Sukarela</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="saldo_sukarela" id="saldo_sukarela" data-required="1" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Tabungan Mingguan</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="saldo_tabungan_mingguan" id="saldo_tabungan_mingguan" data-required="1" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Tabungan Berencana</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="saldo_tabungan_berencana" id="saldo_tabungan_berencana" data-required="1" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                </div>
                <div style="font-size:11px;" id="product_saving_description"><!-- ket produk --></div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Deposito</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="saldo_deposito" id="saldo_deposito" data-required="1" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Cadangan Resiko</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="saldo_cadangan_resiko" id="saldo_cadangan_resiko" data-required="1" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Simpanan Pokok</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="saldo_simpanan_pokok" id="saldo_simpanan_pokok" data-required="1" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo SMK</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="saldo_smk" id="saldo_smk" data-required="1" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Bonus Bagihasil</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="bonus_bagihasil" id="bonus_bagihasil" data-required="1" class="small m-wrap" readonly="" style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div>
            <!-- <div class="control-group">
               <label class="control-label">Infaq</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="infaq" id="infaq" data-required="1" class="small m-wrap" readonly="" style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div> -->   

            </div>
            <div style="width:50%;float:left;padding-top:160px;">
              <div class="control-group">
                 <label class="control-label">Saldo Hutang</label>
                 <div class="controls">
                    <div class="input-append input-prepend">
                      <span class="add-on">Rp</span>
                        <input type="text" name="saldo_hutang" id="saldo_hutang" data-required="1" value="0" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                      <span class="add-on">,00</span>
                    </div>
                 </div> 
              </div> 
              <div class="control-group">
                 <label class="control-label">Potongan Pembiayaan</label>
                 <div class="controls">
                    <div class="input-append input-prepend">
                      <span class="add-on">Rp</span>
                        <input type="text" name="potongan_pembiayaan" id="potongan_pembiayaan" value="0" class="small m-wrap mask-money" style="text-align:right"/>
                      <span class="add-on">,00</span>
                    </div>
                 </div> 
              </div> 
              <div class="control-group">
                 <label class="control-label">Saldo Simpanan</label>
                 <div class="controls">
                    <div class="input-append input-prepend">
                      <span class="add-on">Rp</span>
                        <input type="text" name="saldo_simpanan" id="saldo_simpanan" class="small m-wrap" value="0" readonly style="text-align:right;background:#f9f9f9"/>
                      <span class="add-on">,00</span>
                    </div>
                 </div> 
              </div> 
              <div class="control-group">
                 <label class="control-label">Setoran Tambahan</label>
                 <div class="controls">
                    <div class="input-append input-prepend">
                      <span class="add-on">Rp</span>
                        <input type="text" name="setoran_tambahan" id="setoran_tambahan" data-required="1" value="0" class="small m-wrap mask-money" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                      <span class="add-on">,00</span>
                    </div>
                 </div> 
              </div> 
              <input type="hidden" id="penarikan_tabungan_sukarela" name="penarikan_tabungan_sukarela">
            </div>       
            </div>       
            <div class="form-actions">
               <input type="hidden" id="cif_no" name="cif_no">
               <button type="submit" class="btn green">Save</button>
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
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>  
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/index.js" type="text/javascript"></script>       
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
   jQuery(document).ready(function() {    
     App.init(); // initlayout and core plugins
     $(".datemask").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
     });
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

// BEGIN SEARCH BRANCH
$("#keyword","#dialog_kantor_cabang").keypress(function(e){
   keyword = $(this).val();
   if(e.which==13){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         data: {keyword:keyword},
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            $("#result","#dialog_kantor_cabang").html(html);
         }
      })
   }
});

$("a#browse_branch").click(function(){
   keyword = $("#keyword","#dialog_kantor_cabang").val();
   $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         data: {keyword:keyword},
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            $("#result","#dialog_kantor_cabang").html(html);
         }
      })
});

$("#select","#dialog_kantor_cabang").click(function(){
  $(".close","#dialog_kantor_cabang").trigger('click');
  branch_code = $("#result","#dialog_kantor_cabang").val();
  branch_name = $("#result option:selected","#dialog_kantor_cabang").attr('branch_name');
  branch_id = $("#result option:selected","#dialog_kantor_cabang").attr('branch_id');
  $("#branch_code").val(branch_code);
  $("#branch_name").val(branch_name);
  $("#branch_id").val(branch_id);
});

$("#result option","#dialog_kantor_cabang").live('dblclick',function(){
  $("#select","#dialog_kantor_cabang").trigger('click');
});

$(function(){

      global_saldo_margin=0;
      global_saldo_pokok=0;
      global_saldo_simpanan=0;
      global_saldo_catab=0;
      global_saldo_tabungan_wajib=0;
      global_saldo_tabungan_kelompok=0;

      // BEGIN FORM ADD USER VALIDATION
      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);
      
      $("#btn_add").click(function(){
        $("#wrapper-table").hide();
        $("#add").show();
        form1.trigger('reset');
      });

      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          errorPlacement: function(error, element) {
            element.closest('.controls').append(error);
          },
          rules: {
              desa: {
                  required: true
              },
              rembug: {
                  required: true
              },
              id_anggota: {
                  required: true
              },
              tanggal_mutasi: {
                  required: true,
                  cek_trx_kontrol_periode: true
              },
              alasan: {
                  required: true
              }
          },

          invalidHandler: function (event, validator) { //display error alert on form submit              
              success1.hide();
              error1.show();
              App.scrollTo(error1, -200);
          },

          highlight: function (element) { // hightlight error inputs
              $(element)
                  .closest('.help-inline').removeClass('ok'); // display OK icon
              $(element)
                  .closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
          },

          
          unhighlight: function (element) { // revert the change dony by hightlight
              $(element)
                  .closest('.control-group').removeClass('error'); // set error class to the control group
          },

          success: function (label) {
            if(label.closest('.input-append').length==0)
            {
              // .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              label.closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
            }
            else
            {
               label.closest('.control-group').removeClass('error').addClass('success')
               label.remove();
            }
          },

          submitHandler: function (form) {

            $.ajax({
              type: "POST",
              url: site_url+"kelompok/proses_anggota_keluar",
              dataType: "json",
              data: form1.serialize(),
              success: function(response){
                if(response.success==true){
                  alert(response.message);
                  window.location.reload(true);
                }else{
                  alert(response.message);
                }
              },
              error:function(){
                  success1.hide();
                  error1.show();
                App.scrollTo(error1, -200);
              }
            });

          }
      });

      // event untuk kembali ke tampilan data table (ADD FORM)
      $("#cancel","#form_add").click(function(){
        success1.hide();
        error1.hide();
        $("#add").hide();
        $("#wrapper-table").show();
        dTreload();
      });



      $("#button-dialog").click(function(){
        $("#dialog").dialog('open');
      });

        // fungsi untuk 
      $(function(){

      $("#browse_cm").click(function(){
          if($("#keyword","#dialog_cm").val()==""){
            branch_code=$("#branch_code").val();
            $.ajax({
               type: "POST",
               url: site_url+"kelompok/get_rembug_by_keyword",
               dataType: "json",
               data: {keyword:'',branch_code:branch_code},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
                  }
                  $("#result","#dialog_cm").html(html);
               }
            })
          }
        })

        $("#keyword","#dialog_cm").keypress(function(e){
          keyword = $(this).val();
          branch_code=$("#branch_code").val();
          if(e.which==13){
            $.ajax({
               type: "POST",
               url: site_url+"kelompok/get_rembug_by_keyword",
               dataType: "json",
               data: {keyword:keyword,branch_code:branch_code},
               async: false,
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
                  }
                  $("#result","#dialog_cm").html(html);
               }
            });
            return false;
          }
        });

        //mencari anggota rembug sesuai rembug yang dipilih
        $("#select","#dialog_cm").click(function(){
          $("#close","#dialog_cm").trigger('click');
            var cm_code = $("#result","#dialog_cm").val();
            nama_rembug = $("#result option:selected","#dialog_cm").attr('cm_name');
            $("#rembug").val(nama_rembug);  
            $("#cm_code").val(cm_code);  
           $.ajax({
             type: "POST",
             url: site_url+"kelompok/get_anggota_rembug_by_cm_code",
             dataType: "json",
             data: {cm_code:cm_code},
             success: function(response){
                html = '<option value="">PILIH</option>';
                for ( i = 0 ; i < response.length ; i++ )
                {
                   html += '<option value="'+response[i].cif_no+'" cif_no="'+response[i].cif_no+'" cif_id="'+response[i].cif_id+'">'+response[i].nama+' - '+response[i].cif_no+'</option>';
                }
                $("#id_anggota").html(html);
                  //meload data cif berdasarkan cif_no yang dipilih
                  $.ajax({
                    type: "POST",
                    url: site_url+"kelompok/get_cif_by_cif_no",
                    async: false,
                    dataType: "json",
                    data: {cif_no:$("#id_anggota").val()},
                    success: function(response)
                    {                      
                        $("#nama").val(response.nama);  
                        $("#cif_no").val(response.cif_no);                     
                    }
                  });
             }
           });        
        }); 

        $("#result option","#dialog_cm").live('dblclick',function(){
            $("#select","#dialog_cm").trigger('click');
        });

        //meload data cif berdasarkan cif_no yang dipilih
        $("select[name='id_anggota']").change(function(){
            var cm_code = $("#cm_code").val();
           $.ajax({
              type: "POST",
              url: site_url+"kelompok/get_cif_by_cif_no",
              async: false,
              dataType: "json",
              data: {cif_no:$("#id_anggota").val()},
              success: function(response)
              {                      
                  $("#nama").val(response.nama);   
                  $("#cif_no").val(response.cif_no);                     
              }
            });      
        }); 


        function pembulatan_bonus_bagihasil(nominal)
        {
          nominal = convert_numeric(Math.round(nominal));
          nr = nominal.substr(nominal.length-3);
          nl = nominal.substr(0,nominal.length-3);

          if(nr>500){
            n=parseFloat(nl+'500');
          }else if(nr>0){
            n=parseFloat(nl+'000');
          }else{
            n=parseFloat(nominal);
          }
          // console.log('nl:'+nl);
          // console.log('nr:'+nr);
          // console.log('n:'+n);
          // console.log('nominal:'+nominal);
          ntmblangpkk=parseFloat(nominal)-parseFloat(n);
          // console.log('ntmblangpkk:'+ntmblangpkk);
          return {nominal:n,sisa:ntmblangpkk};
        }

        //meload data saldo-saldo berdasarkan cif_no yang dipilih
        $("select[name='id_anggota']").change(function(){
            var cif_no = $("#id_anggota").val();
           $.ajax({
              type: "POST",
              url: site_url+"kelompok/get_saldo_by_cif_no",
              async: false,
              dataType: "json",
              data: {cif_no:cif_no},
              success: function(response)
              {
                // bbh = pembulatan_bonus_bagihasil(response.bonus_bagihasil);
                saldo_pokok = (response.saldo_pokok==null)?0:response.saldo_pokok;
                saldo_margin = (response.saldo_margin==null)?0:response.saldo_margin;
                saldo_catab = (response.saldo_catab==null)?0:response.saldo_catab;
                saldo_tabungan_wajib = (response.tabungan_wajib==null)?0:response.tabungan_wajib;
                saldo_tabungan_kelompok = (response.tabungan_kelompok==null)?0:response.tabungan_kelompok;
                saldo_sukarela = (response.tabungan_sukarela==null)?0:response.tabungan_sukarela;
                saldo_tabungan_mingguan = (response.tabungan_minggon==null)?0:response.tabungan_minggon;
                saldo_tabungan_berencana = (response.saldo_memo==null)?0:response.saldo_memo;
                saldo_deposito = (response.nominal==null)?0:response.nominal;
                saldo_cadangan_resiko = (response.cadangan_resiko==null)?0:response.cadangan_resiko;
                saldo_simpanan_pokok = (response.simpanan_pokok==null)?0:response.simpanan_pokok;
                saldo_smk = (response.smk==null)?0:response.smk;
                bonus_bagihasil = (response.bonus_bagihasil==null)?0:response.bonus_bagihasil;
                // infaq = (bbh.sisa==null)?0:bbh.sisa;

                $("#saldo_pembiayaan").val(number_format(saldo_pokok,0,',','.'));
                $("#saldo_margin").val(number_format(saldo_margin,0,',','.'));
                $("#saldo_catab").val(number_format(saldo_catab,0,',','.'));
                $("#saldo_tabungan_wajib").val(number_format(saldo_tabungan_wajib,0,',','.'));
                $("#saldo_tabungan_kelompok").val(number_format(saldo_tabungan_kelompok,0,',','.'));
                $("#saldo_sukarela").val(number_format(saldo_sukarela,0,',','.'));
                $("#saldo_tabungan_mingguan").val(number_format(saldo_tabungan_mingguan,0,',','.'));
                $("#saldo_tabungan_berencana").val(number_format(saldo_tabungan_berencana,0,',','.'));
                $("#saldo_deposito").val(number_format(saldo_deposito,0,',','.'));
                $("#saldo_cadangan_resiko").val(number_format(saldo_cadangan_resiko,0,',','.'));
                $("#saldo_simpanan_pokok").val(number_format(saldo_simpanan_pokok,0,',','.'));
                $("#saldo_smk").val(number_format(saldo_smk,0,',','.'));
                $("#bonus_bagihasil").val(number_format(bonus_bagihasil,0,',','.'));
                // $("#infaq").val(number_format(infaq,0,',','.'));

                penarikan_tabungan_sukarela = 0;
                saldo_hutang = parseFloat(saldo_pokok)+parseFloat(saldo_margin);
                saldo_simpanan = parseFloat(saldo_catab)+parseFloat(saldo_tabungan_wajib)+parseFloat(saldo_tabungan_kelompok)+parseFloat(saldo_sukarela)+parseFloat(saldo_tabungan_mingguan)+parseFloat(saldo_tabungan_berencana)+parseFloat(saldo_deposito)+parseFloat(saldo_cadangan_resiko)+parseFloat(saldo_simpanan_pokok)+parseFloat(saldo_smk);
                setoran_tambahan = parseFloat(saldo_simpanan-saldo_hutang);
                if(setoran_tambahan>=0){
                  penarikan_tabungan_sukarela = setoran_tambahan;
                  setoran_tambahan=0;
                }else{
                  setoran_tambahan = setoran_tambahan*(-1);
                }
                $("#saldo_hutang").val(number_format(saldo_hutang,0,',','.'));
                $("#saldo_simpanan").val(number_format(saldo_simpanan,0,',','.'));
                $("#setoran_tambahan").val(number_format(setoran_tambahan,0,',','.'));
                $("#penarikan_tabungan_sukarela").val(penarikan_tabungan_sukarela);

                // set global
                global_saldo_margin=saldo_margin;
                global_saldo_pokok=saldo_pokok;
                global_saldo_simpanan=saldo_simpanan;
                global_saldo_catab=saldo_catab;
                global_saldo_tabungan_wajib=saldo_tabungan_wajib;
                global_saldo_tabungan_kelompok=saldo_tabungan_kelompok;

                // check checkboxnya
                $("#flag_saldo_margin").attr('checked',true);
                $("#flag_saldo_margin").parent().attr('class','checked');
                $("#flag_saldo_catab").attr('checked',true);
                $("#flag_saldo_catab").parent().attr('class','checked');
                $("#flag_saldo_tabungan_wajib").attr('checked',true);
                $("#flag_saldo_tabungan_wajib").parent().attr('class','checked');
                $("#flag_saldo_tabungan_kelompok").attr('checked',true);
                $("#flag_saldo_tabungan_kelompok").parent().attr('class','checked');


              }
            });

            $.ajax({
              type:"POST",
              dataType:"json",
              url:site_url+"kelompok/ajax_get_product_savingplan",
              data:{cif_no:cif_no},
              success:function(response){
                html='';
                if(response.length>0)
                {
                  html += '<ul style="margin-left:12px;margin-top:5px;">';
                  for(i in response){
                    html += '<li>'+response[i].product_name+'</li>';
                  }
                  html += '</ul>';
                }
                $("#product_saving_description").html(html);
              }
            })
        }); 

      });

      $("#potongan_pembiayaan").keyup(function(e){
        e.preventDefault();
        penarikan_tabungan_sukarela = 0;
        saldo_hutang = convert_numeric($("#saldo_hutang").val());
        potongan_pembiayaan = convert_numeric(($(this).val()=="")?0:$(this).val());
        saldo_simpanan = convert_numeric($("#saldo_simpanan").val());
        setoran_tambahan = parseFloat(saldo_simpanan)-(parseFloat(saldo_hutang)-parseFloat(potongan_pembiayaan));
        if(setoran_tambahan>=0){
          penarikan_tabungan_sukarela = setoran_tambahan;
          setoran_tambahan=0;
        }else{
          setoran_tambahan = setoran_tambahan*(-1);
        }
        $("#setoran_tambahan").val(number_format(setoran_tambahan,0,',','.'))
        $("#penarikan_tabungan_sukarela").val(number_format(penarikan_tabungan_sukarela,0,',','.'));
      })
  
      $("#flag_saldo_margin").click(function(e){
        saldo_margin=parseFloat(global_saldo_margin);
        saldo_pokok=parseFloat(global_saldo_pokok);
        saldo_simpanan=parseFloat(global_saldo_simpanan);
        saldo_hutang=parseFloat(saldo_margin+saldo_pokok);
        penarikan_tabungan_sukarela=0;

        if($(this).is(':checked')==false){
          saldo_margin=0;
          saldo_hutang=saldo_pokok;
        }

        $("#saldo_margin").val(number_format(saldo_margin,0,',','.'));
        $("#saldo_hutang").val(number_format(saldo_hutang));

        setoran_tambahan = parseFloat(saldo_simpanan-saldo_hutang);
        if(setoran_tambahan>=0){
          penarikan_tabungan_sukarela = setoran_tambahan;
          setoran_tambahan=0;
        }else{
          setoran_tambahan = setoran_tambahan*(-1);
        }
        $("#saldo_hutang").val(number_format(saldo_hutang,0,',','.'));
        $("#saldo_simpanan").val(number_format(saldo_simpanan,0,',','.'));
        $("#setoran_tambahan").val(number_format(setoran_tambahan,0,',','.'));
        $("#penarikan_tabungan_sukarela").val(number_format(penarikan_tabungan_sukarela,0,',','.'));
      })

      $("#flag_saldo_catab").click(function(e){
        saldo_catab=global_saldo_catab;
        if($(this).is(':checked')==false){
          saldo_catab=0;
        }
        $("#saldo_catab").val(number_format(saldo_catab,0,',','.'));
      })
      $("#flag_saldo_tabungan_kelompok").click(function(e){
        saldo_tabungan_kelompok=global_saldo_tabungan_kelompok;
        if($(this).is(':checked')==false){
          saldo_tabungan_kelompok=0;
        }
        $("#saldo_tabungan_kelompok").val(number_format(saldo_tabungan_kelompok,0,',','.'));
      })
      $("#flag_saldo_tabungan_wajib").click(function(e){
        saldo_tabungan_wajib=global_saldo_tabungan_wajib;
        if($(this).is(':checked')==false){
          saldo_tabungan_wajib=0;
        }
        $("#saldo_tabungan_wajib").val(number_format(saldo_tabungan_wajib,0,',','.'));
      })
    
      jQuery('#desa_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#desa_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->


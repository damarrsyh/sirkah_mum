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
        Pendebetan Angsuran Pembiayaan <small></small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN PROSES PINBUK -->

  <!-- BEGIN FORM-->
  <div class="portlet-body form">
    <div class="alert alert-error hide">
       Please Fill All Field Below !
    </div>
    <div class="alert alert-success hide">
       Pendebetan Sukses !
    </div>
      <form id="form_process" class="form-horizontal">

        <!-- DIALOG BRANCH -->
        <div id="dialog_branch" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
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

        <!-- DIALOG CM -->
        <div id="dialog_cm" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
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

        <table>
          <tr>
            <td width="200">Kantor Cabang</td>
            <td>
              <input type="text" name="branch" tabindex="1" readonly value="<?php echo $this->session->userdata('branch_name'); ?>" style="background-color:#DDD;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> 
              <!-- <a id="browse_branch" class="btn blue" style="padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a> -->
            </td>
          <tr>
            <td width="200" valign="top">Tanggal Jatuh Tempo</td>
            <td valign="top"><input type="text" name="tanggal_jto" tabindex="2" placeholder="dd/mm/yyyy" value="<?php echo $current_date; ?>" class="date-picker mask_date" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"></td>
          </tr>
          <tr>
            <td></td>
            <td>
               <button type="submit" tabindex="12" class="btn green search" id="search">Filter</button>
            </td>
          </tr>
        </table>
      </form>
            
      <p><hr></p>

      <form id="pendebetan" method="post">

        <input type="hidden" name="branch_code" value="<?php echo $this->session->userdata('branch_code') ?>">
        <input type="hidden" name="branch_id" value="<?php echo $this->session->userdata('branch_id') ?>">
        <input type="hidden" name="tanggal_jto2" value="<?php echo $current_date; ?>">
        <!-- <div style="padding:10px;border-left:solid 1px #CCC; border-right:solid 1px #CCC; border-top:solid 1px #CCC"> -->
          <table width="100%" id="form">
            <thead>
              <tr>
              	<td align="center" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="21%">No. Account</td>
              	<td align="center" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="17%">Nama</td>
                <td align="center" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">Angsuran</td>
                <td align="center" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="7%">JTO <br> Angsuran</td>
                <td align="center" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">Pembayaran</td>
              	<td align="center" style="padding:5px 0;background:#EEE;border-left:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;">Saldo Tabungan</td>
              	<td align="center" style="padding:5px 0;background:#EEE;border:solid 1px #CCC;" width="50">
              		
              	</td>
              </tr>
            </thead>
            <tbody>
              <tr>
              	
              <tr>
            </tbody>
          </table>
      <!-- </div> -->
      </form>
      <div align="center" style="margin-top:20px;">
         <button type="submit" style="margin-right:20px;" tabindex="12" class="btn blue" id="save_trx">Save</button>
         <button type="reset" class="btn red" tabindex="13" id="cancel_trx">Cancel</button>
      </div>
  </div>
  <!-- END FORM-->

<!-- END PROSES PINBUK -->


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
     
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y", {autoUnmask: true});  //direct mask
      });
   });
</script>

<script type="text/javascript">
$(function(){

  $("input[name='tanggal']").change(function(){
    $("input[name='tanggal2']").val($(this).val());
  });
  $("input[name='no_referensi']").keyup(function(){
    $("input[name='no_referensi2']").val($(this).val());
  });
  $("input[name='deskripsi']").keyup(function(){
    $("input[name='deskripsi2']").val($(this).val());
  });

  $("#keyword","#dialog_branch").keypress(function(e){
    e.preventDefault();
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
            $("#result","#dialog_branch").html(html);
         }
      })
    }
  });

  $("#select","#dialog_branch").click(function(){
    branch_id = $("#result option:selected","#dialog_branch").attr('branch_id');
    result_name = $("#result option:selected","#dialog_branch").attr('branch_name');
    result_code = $("#result","#dialog_branch").val();
    if(result_code!=null)
    {
      $("input[name='branch']").val(result_name);
      $("input[name='branch_code']").val(result_code);
      $("input[name='branch_id']").val(branch_id);
      $("#close","#dialog_branch").trigger('click');
    }
  });
  $("#result option","#dialog_branch").live('dblclick',function(){
     $("#select","#dialog_branch").trigger('click');
  });
  var form1 = $('#form_process');
  var error1 = $('.alert-error');
  var success1 = $('.alert-success');

  form1.validate({
    errorElement: 'span', //default input error message container
    errorClass: 'help-inline', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    errorPlacement: function(error, element) {
      error.appendTo( element.parent(".controls") );
    },
    rules: {
         branch: 'required'
        ,tanggal: 'required'
        ,cm: 'required'
        ,fa: 'required'
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
        label
            .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
        .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
      }
      else
      {
         label.closest('.control-group').removeClass('error').addClass('success')
         label.remove();
      }
    },

    submitHandler: false
  
  });

  $(".search").click(function(e){
    e.preventDefault();
    if(form1.valid()===true)
    {

      $("input[name='tanggal_jto2']").val($("input[name='tanggal_jto']").val());

      error1.hide();
      var branch_code = $("input[name='branch_code']").val();
      var tanggal_jto = $("input[name='tanggal_jto2']").val();
      $.ajax({
        url: site_url+"transaction/ajax_get_data_pendebetan_angsuran_pembiayaan",
        type: "POST",
        dataType: "json",
        data: { branch_code : branch_code, tanggal_jto : tanggal_jto },
        async: false,
        success: function(response){
          
          html = '';
          for(i = 0 ; i < response.length ; i++)
          {
            html += '<tr> \
                      <td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px 12px 5px 10px;"> \
                        <input type="text" readonly name="account_financing_no[]" value="'+response[i].account_financing_no+'" style="width:100%;padding:4px 0;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;" > \
                      </td> \
                      <td align="left" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;"> \
                        '+response[i].nama+' \
                        <input type="hidden" id="angsuran_pokok" name="angsuran_pokok[]" value="'+response[i].angsuran_pokok+'"> \
                        <input type="hidden" id="angsuran_margin" name="angsuran_margin[]" value="'+response[i].angsuran_margin+'"> \
                        <input type="hidden" id="angsuran_tabungan" name="angsuran_tabungan[]" value="'+response[i].angsuran_tabungan+'"> \
                        <input type="hidden" id="jtempo_angsuran_next" name="jtempo_angsuran_next[]" value="'+response[i].jtempo_angsuran_next+'"> \
                      </td> \
                      <td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px 12px 5px 10px;"> \
                        <input type="text" name="angsuran[]" id="angsuran" readonly="readonly" value="'+response[i].angsuran+'" style="background:#EEEEEE;  width:100%;padding:4px 0;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;" > \
                      </td> \
                      <td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;padding:5px 12px 5px 10px;"> \
                        <input type="text" name="jto_angsuran[]" id="jto_angsuran" value="'+response[i].freq_bayar+'" style=" width:100%;padding:4px 0;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;" > \
                      </td> \
                      <td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;padding:5px 12px 5px 10px;"> \
                        <input type="text" nam="pembayaran[]" id="pembayaran" readonly="readonly" value="'+(response[i].angsuran*response[i].freq_bayar)+'" style="background:#EEEEEE;  width:100%;padding:4px 0;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;" > \
                      </td> \
                      <td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;padding:5px 12px 5px 10px;"> \
                        <input type="text" name="saldo_tabungan[]" id="saldo_tabungan" readonly="readonly" value="'+response[i].saldo_tabungan+'" style="background:#EEEEEE;  width:100%;padding:4px 0;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;" > \
                      </td> \
                      <td align="center" style="border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> \
                        <a href="javascript:void(0);" id="yes" name="yes[]"><img src="<?php echo base_url("assets/img/yes.png"); ?>" width="26"/></a> \
                        <a href="javascript:void(0);" id="cancel" style="display:none;" name="cancel[]"><img src="<?php echo base_url("assets/img/cancel.png"); ?>" width="26"/></a> \
                      </td> \
                    <tr> \
                    ';
          }

          $("#pendebetan tbody").html(html);
        }
      });
    }
  });

  $("input#jto_angsuran").live('keyup',function(){
    var jto_angsuran = parseFloat($(this).val());
    var angsuran = parseFloat($(this).parent().parent().find("input#angsuran").val());
    if(isNaN(angsuran)===true){
      angsuran=0;
    }
    if(isNaN(jto_angsuran)===true){
      jto_angsuran = 0;
    }
    var pembayaran = jto_angsuran*angsuran;
    $(this).parent().parent().find("input#pembayaran").val(pembayaran);
  });

  $("a#yes").live('click',function(){
    pembayaran = parseFloat($(this).parent().parent().find("input#pembayaran").val());
    saldo_tabungan = parseFloat($(this).parent().parent().find("input#saldo_tabungan").val());
    if(pembayaran>saldo_tabungan){
      alert("Saldo Tabungan Tidak Mencukupi untuk melakukan Pembayaran.");
    }else{
      $(this).parent().parent().find("input#jto_angsuran").attr('readonly',true);
      $(this).hide();
      $(this).parent().parent().find("a#cancel").show();
    }
  });

  $("a#cancel").live('click',function(){
    $(this).parent().parent().find("input#jto_angsuran").attr('readonly',false);
    $(this).hide();
    $(this).parent().parent().find("a#yes").show();
  });

  $("#save_trx").click(function(){
    bValid = true;
    $("a#yes").each(function(){
      if($(this).is(':visible')==true){
        bValid = false;
      }
    });

    if(bValid==true)
    {
      $.ajax({
        type: "POST",
        dataType: "json",
        data: $("#pendebetan").serialize(),
        url: site_url+"transaction/process_pendebetan_angsuran_pembiayaan",
        success: function(response){
          if(response.success===true){
            alert("Pendebetan Angsuran Berhasil !");
            $("#pendebetan tbody").html('<tr></tr>');
            $(".search").trigger('click');
          }else{
            alert("Pendebetan Angsuran Gagal");
          }
        },
        error: function(){
          alert("Failed to Connect into Database, Please Contact Your Administrator !");
        }
      });
    }
    else
    {
      alert("Ada inputan yang belum di selesaikan. proses tidak dapat dilanjutkan !");
    }
  });

  $("#cancel_trx").click(function(){
      $("#pendebetan tbody").html('<tr></tr>');
      $(".search").trigger('click');
  });

});
</script>
<style type="text/css" media="print">
  @media print{
    body {background-color:#FFFFFF; background-image:none; color:#000000;}
    #ad {display:none;}
    #leftbar {display:none;}
    #contentarea {width:100%;}
     @page{
        size: auto;   /* auto is the current printer page size */
        margin: 0mm;  /* this affects the margin in the printer settings */
    }
    header{display: none;}
    body{height: 100%;}

  }
</style>
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
      Transaction <small>Transaksi Pencairan Deposito</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Transaction</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Transaksi Pencairan Deposito</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Pencairan Deposito</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
         <div class="btn-group">
            <button id="btn_add" class="btn green">
            Add New <i class="icon-plus"></i>
            </button>
         </div>
      </div>
      <table class="table table-striped table-bordered table-hover" id="pencairan_deposito_table">
         <thead>
            <tr>
               <th width="20%">Tanggal Buka</th>
               <th width="20%">No. Rekening</th>
               <th width="20%">Nama Lengkap</th>
               <th width="20%">Nominal</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- BEGIN TRX -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Transaksi Pembukaan Deposito</div>
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
               Transaksi Setoran Tabungan Sukses. Silahkan Cetak Validasi Transaksi !
            </div>
            </br>
                    <div class="control-group">
                       <label class="control-label">No Rekening<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" style="background-color:#eee;" name="account_deposit_no" id="account_deposit_no" data-required="1" class="medium m-wrap" readonly="" /><input type="hidden" id="branch_id" name="branch_id">
                          
                          <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                             <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Cari No Rekening</h3>
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

                        <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Lengkap <span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" style="background-color:#eee;" name="nama" id="nama" data-required="1" class="medium m-wrap" readonly=""/>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Produk<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" style="background-color:#eee;" name="product_name" id="product_name" data-required="1" class="medium m-wrap" readonly=""/>
                       </div>
                    </div>         
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" style="background-color:#eee;" name="jangka_waktu" id="jangka_waktu" data-required="1" class="medium m-wrap" readonly=""/>
                       </div>
                    </div>                    
                    <div class="control-group">
                       <label class="control-label">Saldo Efektif<span class="required">*</span></label>
                          <div class="controls">
                            <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                                  <input type="text" class="medium m-wrap mask-money"  style="background-color:#eee;" readonly="" name="nominal" id="nominal">
                               <span class="add-on">,00</span>
                            </div>
                         </div>
                    </div> 
<!--
                    <div class="control-group">
                       <label class="control-label">Saldo Efektif<span class="required">*</span></label>
                          <div class="controls">
                            <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                                  <input type="text" class="medium m-wrap mask-money"  style="background-color:#eee;" readonly="" name="saldo_efektif" id="saldo_efektif">
                               <span class="add-on">,00</span>
                            </div>
                         </div>
                    </div> 
-->
                    <hr>                   
                    <div class="control-group">
                       <label class="control-label">Tanggal Transaksi<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_buka" id="tanggal_buka" value="<?php echo $current_date; ?>" data-required="1" class="medium m-wrap date-picker mask_date" />
                       </div>
                    </div> 
                    <input type="hidden" id="branch_id" name="branch_id">
                    <div class="control-group">
                       <label class="control-label">Kas Petugas<span class="required">*</span></label>
                       <div class="controls">
                          <select class="m-wrap medium chosen" id="account_cash_code" name="account_cash_code">
                            <option value="">PILIH KAS/BANK</option>
                            <?php foreach($account_cash as $kas){ ?>
                            <option value="<?php echo $kas['account_cash_code'] ?>"><?php echo $kas['account_cash_name'] ?></option>
                            <?php } ?>
                          </select>
                       </div>
                    </div>
                    <div class="form-actions">
                       <button type="submit" class="btn green">Save</button>
                       <button type="reset" class="btn red" id="cancel">Reset</button>
                    </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END TRX -->

<!-- print voucher area -->
<div id="print_validasi_setoran" style="font-size:10px;display:none">

  <div style="padding:10px;">

    <table style="width:70%" id="pa_transaction" align="center">
      <thead>
        <tr>
          <th style="">&nbsp;</th>
          <th style="">&nbsp;</th>
          <th style="">&nbsp;</th>
          <th style="font-size:12px;color:blue;font-weight:normal;" width="50%" align="left"><span id="span_validasi_row1"></span></th>
        </tr>
        <tr>
          <th style="">&nbsp;</th>
          <th style="">&nbsp;</th>
          <th style="">&nbsp;</th>
          <th style="font-size:12px;color:blue;font-weight:normal;" width="50%" align="left"><span id="span_validasi_row2"></span></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td></td>
        </tr>
      </tbody>
    </table>
    <br>
  </div>

</div>


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
      Index.init();
      // Index.initCalendar(); // init index page's custom scripts
      // Index.initChat();
      // Index.initDashboardDaterange();
      // Index.initIntro();
      $(".mask_date").inputmask("d/m/y");  //direct mask        
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){

// fungsi untuk reload data table
// di dalam fungsi ini ada variable tbl_id
// gantilah value dari tbl_id ini sesuai dengan element nya
var dTreload = function()
{
  var tbl_id = 'pencairan_deposito_table';
  $("select[name='"+tbl_id+"_length']").trigger('change');
  $(".paging_bootstrap li:first a").trigger('click');
  $("#"+tbl_id+"_filter input").val('').trigger('keyup');
}

/**
* DELETE SETORAN TUNAI
* element : link-delete
* @author : sayyid
* date : 25 agustus 2014
*/

$("a#link-delete").live('click',function(e){
  e.preventDefault();
  var trx_detail_id=$(this).attr('trx_detail_id');
  var nama=$(this).attr('nama');
  var account_deposito_no=$(this).attr('account_deposito_no');
  var conf=confirm("Akan melakukan Delete Transaksi Setoran Tunai "+account_deposito_no+" ("+nama+"), Apakah anda Yakin?");
  if(conf){
    $.ajax({
      type:"POST",
      dataType:"json",
      url:site_url+"transaction/delete_setoran_tunai",
      data:{trx_detail_id:trx_detail_id},
      success:function(response){
        if(response.success==true){
          alert("Delete Transaksi Setoran Tunai, Sukses!");
        }else{
          alert("Internal Server Error");
        }
        dTreload();
      },
      error: function(){
        alert("Failed to Connect into Databases, Please Contact Your Administrator");
      }
    })
  }
})

  $("#browse_rembug").click(function(){

    account_deposito_no = $("input[name='account_deposito_no']").val();
    $("#keyword","#dialog_rembug").val()
    setTimeout(function(){
      var e = $.Event('keypress');
      e.which = 13; // Character 'A'
      $('#keyword',"#dialog_rembug").trigger(e);
    },300)
  })        
        $("#keyword", "#dialog_rembug").keypress(function(e){
          if(e.which==13){
            e.preventDefault();
            $.ajax({
              type: "POST",
              url: site_url+"transaction/get_pencairan_verified",
              data: {keyword:$(this).val()},
              dataType: "json",
              async: false,
              success: function(response){
                option = '';
                for(i = 0 ; i < response.length ; i++){
                   option += '<option value="'+response[i].account_deposit_no+'" asn="'+response[i].account_deposit_no+'" reference="'+response[i].cif_no+'">'+response[i].account_deposit_no+' - '+response[i].nama+' - '+response[i].product_name+' - '+response[i].cm_name+'</option>';
                }
                // console.log(option);
                $("#result", "#dialog_rembug").html(option).focus();
                $("#result option:first-child","#dialog_rembug").attr('selected',true);
              }
            });
          }
        });

        $("#select","#dialog_rembug").click(function()
        {
          var account_deposit_no = $("#result option:selected").val();          
          var account_deposit_no = $("#result option:selected").attr('asn');
		      var ref_no = $("#result option:selected").attr('reference');

            $("#close","#dialog_rembug").trigger('click');
            $.ajax({
              type:"POST",
              url: site_url+"transaction/search_cif_by_account_deposit_no",
              data:{account_deposit_no:account_deposit_no},
              dataType:"json",
              success: function(response)
              {
				  $("#account_deposit_no").val(response.account_deposit_no);
                  $("#nama").val(response.nama);
                  $("#product_name").val(response.product_name);
                  $("#jangka_waktu").val(response.jangka_waktu);
                  $("#nominal").val(number_format(response.nominal,0,',','.')); 
				  //$('#no_referensi').val(ref_no);
                  // var d = new Date(); 
                  // var bulan = parseFloat(d.getMonth()); 
                  // var month = bulan+1;
                  // var date =d.getFullYear()+'-'+month+'-'+d.getDate();                 
                  // $("#tgl_trx").val(date);   

                  //$("#branch_id").val(response.branch_id);   
              },
              error:function(){
                  alert("No Rekening telah ditransaksi pembukaan deposito");
              }
            });
          
        });
      
        $("#result option","#dialog_rembug").live('dblclick',function(){
           $("#select","#dialog_rembug").trigger('click');
        });

      // BEGIN FORM ADD SETOR TUNAI VALIDATION
      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);

      $("#btn_add").click(function()
      {
        $("#wrapper-table").hide();
        $("#add").show();
        form1.trigger('reset');
      });

      $("#no_referensi","#form_add").change(function(){
         var no_referensi = $("#no_referensi").val();
          $.ajax({
            type: "POST",
            url: site_url+"transaction/check_no_referensi",
            async: false,
            dataType: "json",
            data: {no_referensi:no_referensi},
            success: function(response){
              if(response.success==true){
                $("#error_no_referensi").hide();                  
              }else{
                $("#error_no_referensi").show();
                $("#error_no_referensi").html('<span style="color:red;">'+response.message+'</span>');
              }
            }
          });
        });

      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          
          rules: {
              account_deposit_no: {
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

          submitHandler: function (form) {
            // var now = new Date();
            // var time = now.format("h:mm:tt");
            var session_id = "<?php $this->session->userdata('user_id');?>";
            var branch_code = "<?php $this->session->userdata('branch_code');?>";
            var nama = $("#nama",form1).val();
            var norek = $("#account_deposit_no",form1).val();

            $.ajax({
              url: site_url+"transaction/get_pencairan_by_norek",
              type: "POST",
              dataType: "html",
              async:false,
          data: {account_deposit_no:$("#account_deposit_no",form1).val()},
              success: function(response)
              {
              if(response=='1'){
                  $("#cancel").trigger('click');
                  alert("Transaksi pencairan deposito an. "+nama+" nomer rekening "+norek+" sudah pernah dilakukan. Transaksi dibatalkan");
              }else
              {                
                  $.ajax({
                    type: "POST",
                    url: site_url+"transaction/add_pencairan_deposito",
                    dataType: "json",
                    data: form1.serialize(),
                    success: function(response){
                      if(response.success==true){
                        error1.hide();
                        form1.children('div').removeClass('success');
                        $("#span_validasi_row1").html(response.account_saving+', '+$("#nama").val());
                        $("#span_validasi_row2").html(response.amount+', '+response.teller+', '+response.date_time);
                        $("#add").hide();
                        $("#wrapper-table").show();
                        dTreload();
                        $("#cancel").trigger('click');
                        alert("Transaksi Pembukaan Deposito berhasil");
                      }else{
                        success1.hide();
                        error1.show();
                alert(response.message);
                      }
                      App.scrollTo(error1, -200);
                    },
                    error:function(){
                        success1.hide();
                        error1.show();
                      App.scrollTo(error1, -200);
                    }
                  });
              }
              },
              error: function(){
              bValid = false;
              error_message = "Kesalahan database, harap hubungi IT Support";
              }
            });
          }
      });

      // begin first table
      $('#pencairan_deposito_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"transaction/datatable_pencairan_deposito",
          "aoColumns": [
            null,
            null,
            null,
            { "bSortable": false }
          ],
          "aLengthMenu": [
              [15, 30, 45, -1],
              [15, 30, 45, "All"] // change per page values here
          ],
          // set the initial value
          "iDisplayLength": 15,
          "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
          "sPaginationType": "bootstrap",
          "oLanguage": {
              "sLengthMenu": "_MENU_ records per page",
              "oPaginate": {
                  "sPrevious": "Prev",
                  "sNext": "Next"
              }
          },
          "aoColumnDefs": [{
                  'bSortable': false,
                  'aTargets': [0]
              }
          ]
      });
      
      jQuery('#pencairan_deposito_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#pencairan_deposito_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS -->
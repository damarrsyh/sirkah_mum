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
      Verifikasi <small>Verifikasi Pembukaan Rekening</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Verifikasi</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Verifikasi Pembukaan Rekening</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Verifikasi Pembukaan Rekening</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
         
      </div>
      <hr style="margin:0;">
      <div class="clearfix" style="background:#EEE" id="form-filter">
        <label style="margin-bottom:0;line-height:44px;float:left;padding-left:10px;">CABANG</label>
        <div style="padding:5px;float:left;">
          <select id="param_branch_code" style="width:100px;padding:4px;margin-top:2px;margin-left:5px;margin-bottom:5px;box-shadow:0 0 0;">
            <?php foreach($branchs as $branch): ?>
            <option value="<?php echo $branch['branch_code'] ?>"><?php echo $branch['branch_name'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <label style="margin-bottom:0;line-height:44px;float:left;padding-left:10px;">Tanggal</label>
        <div style="padding:5px;float:left;">
          <input id="tanggal_buka" name="tanggal_buka" class="mask_date date-picker mask_date" type="text" style="width:100px;padding:4px;margin-top:2px;margin-left:5px;margin-bottom:5px;box-shadow:0 0 0;" value="<?php echo date('d/m/Y'); ?>" maxlength="10" placeholder="dd/mm/yyyy" tabindex="2">
          <input id="tanggal_buka2" name="tanggal_buka2" class="mask_date date-picker mask_date" type="text" style="width:100px;padding:4px;margin-top:2px;margin-left:5px;margin-bottom:5px;box-shadow:0 0 0;" value="<?php echo date('d/m/Y'); ?>" maxlength="10" placeholder="dd/mm/yyyy" tabindex="2">
        </div>
        <div style="padding:5px;float:left;">
          <button class="btn blue" id="btn-filter">Filter</button>
        </div>
      </div>
      <hr style="margin:0 0 10px;">
      <p>
      <table class="table table-striped table-bordered table-hover" id="rekening_tabungan_table">
         <thead>
            <tr>
               <th width="15%">No. Rekening</th>
               <th width="15%">Rembug</th>
               <th width="20%">Nama</th>
               <th width="25%">Produk</th>
               <th width="15%">Setoran</th>
               <th width="20%">Tgl.Buka</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
      
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- BEGIN FORM VERIFIKASI -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Verifikasi Pembukaan Rekening</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
            <input type="hidden" id="account_saving_id" name="account_saving_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>

            <div class="control-group">
               <label class="control-label">No Customer</label>
               <div class="controls">
                  <input type="text" name="cif_no2" id="cif_no2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/><input type="hidden" id="branch_code2" name="branch_code2">
               </div>
            </div>            
            <div class="control-group">
               <label class="control-label">Nama Lengkap</label>
               <div class="controls">
                  <input type="text" name="nama2" id="nama2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
               </div>
            </div>            
            <div class="control-group">
               <label class="control-label">Majlis</label>
               <div class="controls">
                  <input type="text" name="majlis2" id="majlis2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
               </div>
            </div>            
            <div class="control-group">
               <label class="control-label">Nama Panggilan</label>
               <div class="controls">
                  <input type="text" name="panggilan2" id="panggilan2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
               </div>
            </div>                       
            <div class="control-group">
               <label class="control-label">Nama Ibu Kandung</label>
               <div class="controls">
                  <input type="text" name="ibu_kandung2" id="ibu_kandung2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
               </div>
            </div>                    
            <div class="control-group">
               <label class="control-label">Tempat Lahir</label>
               <div class="controls">
                  <input type="text" name="tmp_lahir2" id="tmp_lahir2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
               </div>
            </div>                 
            <div class="control-group">
               <label class="control-label">Tanggal Lahir</label>
               <div class="controls">
                  <input type="text" name="tgl_lahir2" id="tgl_lahir2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
               </div>
            </div>               
            <div class="control-group">
               <label class="control-label">Produk<span class="required">*</span></label>
               
               <div class="controls">
                  <input type="hidden" name="product2_old" id="product2_old"/>
                  <input type="hidden" id="product2_code_old" name="product2_code_old">
               </div>
               <div class="controls">
                  <input type="text" class="m-wrap medium" id="product2" name="product2" readonly="" value="" style="background-color:#eee;">
                  <!-- <select id="product2" name="product2" class="medium m-wrap" data-required="1">        -->
                  <!-- </select> -->
               </div>
            </div>
            <div class="control-group">
              <label class="control-label">Biaya Administrasi <span class="required">*</span></label>
              <div class="controls">
                <div class="input-preppend input-append">
                  <div class="add-on">Rp</div>
                  <input type="text" class="mask-money m-wrap medium" id="biaya_administrasi" name="biaya_administrasi" readonly=""  style="background-color:#eee;">
                  <div class="add-on">,00</div>
                </div>
              </div>
            </div>
            <div class="control-group">
               <label class="control-label">No. Rekening</label>
               <div class="controls">
                  <input type="text" name="account_saving_no2" id="account_saving_no2" readonly="" class="medium m-wrap" style="background-color:#eee;"/>
                  <!-- <input type="hidden" id="account_saving_no2_old" name="account_saving_no2_old"> -->
               </div>
            </div>  
            <hr> 
          <div id="tabungan_berencana2">   
            <div class="control-group">
               <label class="control-label" style="text-decoration:underline">Tabungan Berencana</label>
            </div>     
            <div class="control-group">
               <label class="control-label">Setoran<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                     <input type="text" name="rencana_setoran2" style="width:120px;background-color:#eee;" id="rencana_setoran2" data-required="1" class="m-wrap mask-money" maxlength="10" readonly="" />
                     <span class="add-on">,00</span>
                   </div>
               </div>
            </div>   
            <div class="control-group">
               <label class="control-label">Periode Setoran<span class="required">*</span></label>
               <div class="controls">
                  <select id="rencana_periode_setoran2" name="rencana_periode_setoran2" style="width:120px;background-color:#eee;" class="m-wrap" data-required="1" disabled="">
                    <option value="">PILIH</option>
                      <option value="0">Bulanan</option>
                      <option value="1">Mingguan</option>
                      <option value="2">Harian</option>
                  </select>
               </div>
            </div>  
            <div class="control-group">
               <label class="control-label">Jangka Waktu<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="rencana_jangka_waktu2" id="rencana_jangka_waktu2" data-required="1" class="medium m-wrap" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" readonly="" style="background-color:#eee;" />
               </div>
            </div>  
            <div class="control-group">
               <label class="control-label">Rencana Awal Setoran<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="rencana_setoran_next2" id="rencana_setoran_next2" data-required="1" class="small m-wrap" readonly="" style="background-color:#eee;"/>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Tanggal Pembukaan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="tanggal_pembukaan2" style="width:120px;background-color:#eee;" id="tanggal_pembukaan2" data-required="1" class="small m-wrap" readonly=""/>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Kas Petugas<span class="required">*</span></label>
               <div class="controls">
                  <select id="kas_petugas" name="kas_petugas" class="m-wrap large chosen">
                    <option value="">SILAHKAN PILIH</option>
                  </select>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Kas Teller<span class="required">*</span></label>
               <div class="controls">
                  <select id="kas_teller" name="kas_teller" class="m-wrap large chosen">
                    <option value="">SILAHKAN PILIH</option>
                  </select>
               </div>
            </div>

            <div class="form-actions">
               <button type="button" id="btn_reject" class="btn red">Reject</button>
               <button type="submit" class="btn purple">Approve</button>
               <button type="button" class="btn" id="btn_cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END FORM VERIFIKASI -->
  

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
  $("input.mask_date").inputmask("d/m/y", {autoUnmask: true});  //direct mask
});
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

var table = $('#rekening_tabungan_table').dataTable({
    "bProcessing": true,
    "bServerSide": true,
    "sAjaxSource": site_url+"rekening_nasabah/datatable_verifikasi_pembukaan_rekening",
    "fnServerParams": function ( aoData ) {
        aoData.push( { "name": "tanggal_buka", "value": $("#tanggal_buka").val() } );
        aoData.push( { "name": "tanggal_buka2", "value": $("#tanggal_buka2").val() } );
        aoData.push( { "name": "param_branch_code", "value": $("#param_branch_code").val() } );
    },
    "aLengthMenu": [
        [30, 45, -1],
        [30, 45, "All"] // change per page values here
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
            'aTargets': [6]
        }
    ]
});

jQuery('#rekening_tabungan_table_wrapper .row-fluid').hide(); // modify table search input
jQuery('#rekening_tabungan_table_wrapper .dataTables_filter').hide(); // modify table search input
jQuery('#rekening_tabungan_table_wrapper .dataTables_length').hide(); // modify table per page dropdown

$(function(){

$('#btn-filter').click(function(){
  tanggal_buka = $("#tanggal_buka").val();
  table.fnReloadAjax();
})

function get_kas_petugas_by_branch_code(branch_code) {
  $.ajax({
    type:"POST",dataType:"json",data:{branch_code:branch_code},
    url:site_url+'rekening_nasabah/get_kas_petugas_by_branch_code',
    success:function(response) {
      opt = '<option value="">SILAHKAN PILIH</option>';
      for (i in response) {
        opt += '<option value="'+response[i].account_cash_code+'">'+response[i].account_cash_name+'</option>';
      }
      $('#kas_petugas').html(opt).trigger('liszt:updated');
    }
  })
}

function get_kas_teller_by_branch_code(branch_code) {
  $.ajax({
    type:"POST",dataType:"json",data:{branch_code:branch_code},
    url:site_url+'rekening_nasabah/get_kas_teller_by_branch_code',
    success:function(response) {
      opt = '<option value="">SILAHKAN PILIH</option>';
      for (i in response) {
        opt += '<option value="'+response[i].account_cash_code+'">'+response[i].account_cash_name+'</option>';
      }
      $('#kas_teller').html(opt).trigger('liszt:updated');
    }
  })
}

$("a#link-verifikasi").live('click',function(){
  $("#wrapper-table").hide();
  $("#edit").show();
  var account_saving_id = $(this).attr('account_saving_id');
  $.ajax({
    type: "POST",
    dataType: "json",
    data: {account_saving_id:account_saving_id},
    url: site_url+"transaction/get_account_saving_by_account_saving_id",
    success: function(response)
    {
      $.ajax({
        type: "POST",
        url: site_url+"transaction/ajax_get_tabungan_by_cif_type",
        dataType: "json",
        async: false,
        data: {cif_type:response.cif_type},
        success: function(response2){
          html = '';
          for ( i = 0 ; i < response2.length ; i++ )
          {
            html += '<option value="'+response2[i].jenis_tabungan+''+response2[i].product_code+'">'+response2[i].product_name+'</option>';
          }
          $("#product2").html(html);
        }
      });  
           
      $("#form_edit input[name='account_saving_id']").val(response.account_saving_id);
      $("#form_edit input[name='branch_code2']").val(response.branch_code);
      $("#form_edit input[name='cif_no2']").val(response.cif_no);
      $("#form_edit input[name='nama2']").val(response.nama);
      $("#form_edit input[name='majlis2']").val(response.majlis);
      $("#form_edit input[name='panggilan2']").val(response.panggilan);
      $("#form_edit input[name='ibu_kandung2']").val(response.ibu_kandung);
      $("#form_edit input[name='tmp_lahir2']").val(response.tmp_lahir);
      $("#form_edit input[name='tgl_lahir2']").val(response.tgl_lahir);
      $("#form_edit textarea[name='alamat2']").val(response.alamat);
      $("#form_edit input[name='rt_rw2']").val(response.rt_rw);
      $("#form_edit input[name='desa2']").val(response.desa);
      $("#form_edit input[name='kecamatan2']").val(response.kecamatan);
      $("#form_edit input[name='kabupaten2']").val(response.kabupaten);
      $("#form_edit input[name='biaya_administrasi']").val(number_format(response.biaya_administrasi,0,',','.'));
      $("#form_edit input[name='kodepos2']").val(response.kodepos);
      $("#form_edit input[name='telpon_rumah2']").val(response.telpon_rumah);
      $("#form_edit input[name='telpon_seluler2']").val(response.telpon_seluler);
      $("#form_edit input[name='account_saving_no2']").val(response.account_saving_no);
      $("#form_edit input[name='account_saving_no2_old']").val(response.account_saving_no);
      $("#form_edit input[name='product2_old']").val(response.product_name);
      $("#form_edit input[name='product2_code_old']").val(response.product_code);
      
      $("#form_edit input[name='product2']").val(response.product_name);
      get_kas_petugas_by_branch_code(response.branch_code);
      get_kas_teller_by_branch_code(response.branch_code);

      //fungsi untuk menampilkan input TABUNGAN BERENCANA JIKA jenis_tabungan == "1" 
      jenis_tabungan = response.jenis_tabungan;
      if(jenis_tabungan=='1')
      {
        $("#tabungan_berencana2").show();
      }
      else
      {
        $("#tabungan_berencana2").hide();
      }

      $("#form_edit input[name='rencana_setoran2']").val(number_format(response.rencana_setoran,0,',','.'));
      $("#form_edit select[name='rencana_periode_setoran2']").val(response.rencana_periode_setoran);
      $("#form_edit input[name='rencana_jangka_waktu2']").val(response.rencana_jangka_waktu);
      tgl_rencana_setoran_next = '';
      if(response.rencana_setoran_next!=null){
        tgl_rencana_setoran_next = response.rencana_setoran_next.substring(8,12)+'/'+response.rencana_setoran_next.substring(5,7)+'/'+response.rencana_setoran_next.substring(0,4);
      }
      $("#form_edit input[name='rencana_setoran_next2']").val(tgl_rencana_setoran_next);
      tgl_buka = '';
      if(response.tanggal_buka!=null){
        tgl_buka = response.tanggal_buka.substring(8,12)+'/'+response.tanggal_buka.substring(5,7)+'/'+response.tanggal_buka.substring(0,4);
      }
      $("#form_edit input[name='tanggal_pembukaan2']").val(tgl_buka);
               
    }
  })
}); /*end of #('#link-verifikasi') */

/*begin of #('#form_edit') */

// BEGIN FORM EDIT VALIDATION
var form2 = $('#form_edit');
var error2 = $('.alert-error', form2);
var success2 = $('.alert-success', form2);

form2.validate({
    errorElement: 'span', //default input error message container
    errorClass: 'help-inline', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    // ignore: "",
    errorPlacement: function(error, element) {
      element.closest('.controls').append(error);
    },
    rules: {
        rencana_setoran2: {
            required: true
        },
        rencana_periode_setoran2: {
            required: true
        },
        rencana_jangka_waktu2: {
            required: true
        },
        rencana_setoran_next2: {
            required: true
        },
        kas_petugas: {
            required: true
        },
        kas_teller: {
            required: true
        }
    },

    invalidHandler: function (event, validator) { //display error alert on form submit              
        success2.hide();
        error2.show();
        App.scrollTo(error2, -200);
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
      var bValid=true;
      var kas_petugas = $('#kas_petugas','#form_edit').val();
      var kas_teller = $('#kas_teller','#form_edit').val();
      if (kas_petugas=='') {
        bvalid=false;
      }
      if (kas_teller=='') {
        bValid=false;
      }
      if (bValid==false) {
        alert('Kas tidak boleh kosong!');
      } else {
        // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
        $.ajax({
          type: "POST",
          url: site_url+"rekening_nasabah/approve_pembukaan_tabungan",
          dataType: "json",
          data: form2.serialize(),
          success: function(response){
            if(response.success==true){
              success2.show();
              error2.hide();
              form2.children('div').removeClass('success');
              table.fnReloadAjax();
              $("#btn_cancel",form_edit).trigger('click')
              alert('Successfully Updated Data');
            }else{
              alert(response.message);
              success2.hide();
              error2.show();
            }
            App.scrollTo(error2, -200);
          },
          error:function(){
              success2.hide();
              error2.show();
              App.scrollTo(error2, -200);
          }
        });
      }

    }
}); /* end of $('#form_edit') */

/*begin of btn_reject*/
$('#btn_reject').click(function(){
var account_saving_id = $('#account_saving_id',form_edit).val();
$.ajax({
  type:"POST",dataType:"json",data:{account_saving_id:account_saving_id},
  url:site_url+"rekening_nasabah/reject_pembukaan_tabungan",
  success:function(response){ 
    if (response.success==true) {
      alert("Successfully Rejected Data");
      $('#btn_cancel',form_edit).trigger('click');
      table.fnReloadAjax();
    } else {
      alert("FAILED TO CONNECT INTO DATABASES, PLEASE CONTACT YOUR ADMINISTRATOR!");
    }
  }, error : function(){
    alert("FAILED TO CONNECT INTO DATABASES, PLEASE CONTACT YOUR ADMINISTRATOR!");
  }
})
}) /*end of btn_reject*/

/* begin btn_cancel */
$('#btn_cancel',form_edit).click(function(){
  $('#edit').hide();
  $('#wrapper-table').show();
  App.scrollTo(0,0)
}) /*end of btn_cancel*/


}) /*end of $(function(){}) */
</script>
<!-- END JAVASCRIPTS -->


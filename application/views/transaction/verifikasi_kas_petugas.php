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
      Verifikasi Transaksi <small>Kas Petugas</small>
    </h3>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- dialog search cabang -->

<div id="dialog_branch" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Kantor Cabang</h3>
   </div>
   <div class="modal-body">
      <div class="row-fluid">
         <div class="span12">
            <h4>Masukan Kata Kunci</h4>
            <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"><br><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
      <button type="button" id="select" class="btn blue">Select</button>
   </div>
</div>


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Verifikasi Transaksi Kas Petugas</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div style="margin-bottom:10px;border-bottom:solid 1px #CCC;padding-bottom:8px;">
        Kantor Cabang &nbsp; : &nbsp;
        <input type="text" name="src_branch_name" id="src_branch_name" class="medium m-wrap" style="background:#eee;" disabled value="<?php echo $this->session->userdata('branch_name'); ?>">
        <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code'); ?>">
        <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id'); ?>">
        <a id="browse_branch" class="btn blue" data-toggle="modal" href="#dialog_branch">...</a>
        &nbsp; &nbsp; Tanggal Transaksi&nbsp; : &nbsp; <input type="text" class="m-wrap date date-picker" id="from_date" placeholder="DD/MM/YYYY"> s.d&nbsp; <input type="text" class="m-wrap date date-picker" id="thru_date" placeholder="DD/MM/YYYY"> <button id="btn_filter" class="btn green">Filter</button>
      </div>
      <table class="table table-striped table-bordered table-hover" id="transaksi_kas_petugas">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#transaksi_kas_petugas .checkboxes" /></th>
               <th style="text-align:center" width="16.5%">Tanggal Transaksi</th>
               <th style="text-align:center" width="16.5%">Akun Kas</th>
               <th style="text-align:center" width="16.5%">Akun Teller</th>
               <th style="text-align:center" width="16.5%">Jenis Transaksi</th>
               <th style="text-align:center" width="13.5%">Nominal</th>
               <th style="text-align:center" width="19.5%">Keterangan</th>
               <th style="text-align:center">Verifikasi</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->


<!-- BEGIN verifikasi USER -->
<div id="verifikasi" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Verifikasi Transaksi Kas Petugas</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_verifikasi" class="form-horizontal">
          <input type="hidden" id="trx_gl_cash_id" name="trx_gl_cash_id">
          <input type="hidden" id="kas_petugas2_hidden" name="kas_petugas2_hidden">
          <input type="hidden" id="kas_teller2_hidden" name="kas_teller2_hidden">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Approve Transaksi Kas Petugas Sukses !
            </div>
            <div class="alert alert-success2 hide">
               <button class="close" data-dismiss="alert"></button>
               Reject Transaksi Kas Petugas Sukses !
            </div>
          </br>
                    <div class="control-group">
                       <label class="control-label">Cabang<span class="required">*</span></label>
                       <div class="controls">
                         <input type="text" class="medium m-wrap" id="branch_code2" name="branch_code2" readonly="readonly" style="background:#eee;">
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Tanggal<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="trx_date2" id="trx_date2" data-required="1" class="small m-wrap" style="background:#EEE" readonly/>
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Kas Petugas<span class="required">*</span></label>
                       <div class="controls">
                        <input type="text" name="kas_petugas2" id="kas_petugas2" class="large m-wrap" readonly="readonly" style="background:#eee">
                       </div>
                    </div>             
                    <div class="control-group">
                       <label class="control-label">Jenis Transaksi<span class="required">*</span></label>
                       <div class="controls">
                         <select name="jenis_transaksi2" id="jenis_transaksi2" class="medium m-wrap" data-required="1" disabled>                     
                            <option value="">PILIH</option>
                              <option value="1">Droping Kas</option>
                              <option value="4">Setor Ke Teller</option>
                          </select>
                       </div>
                    </div>     
                    <div class="control-group">
                       <label class="control-label">Kas Teller / Bank<span class="required">*</span></label>
                       <div class="controls">
                        <input type="text" name="kas_teller2" id="kas_teller2" class="large m-wrap" readonly="readonly" style="background:#eee">
                       </div>
                    </div>     
                    <div class="control-group">
                      <label class="control-label">Nominal<span class="required">*</span></label>
                         <div class="controls">
                            <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                                  <input type="text" class="medium m-wrap mask-money" id="jumlah_setoran2" name="jumlah_setoran2" style="background:#EEE" readonly>
                               <span class="add-on">,00</span>
                            </div>
                         </div>
                    </div>       
                    <div class="control-group">
                       <label class="control-label">No. Referensi</label>
                       <div class="controls">
                          <input type="text" name="no_referensi2" id="no_referensi2" data-required="1" class="medium m-wrap" style="background:#EEE" readonly/>
                          <!-- <div id="error_no_referensi2"></div> -->
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Keterangan</label>
                       <div class="controls">
                          <textarea id="keterangan2" name="keterangan2" class="m-wrap medium" style="background:#EEE" readonly></textarea>
                       </div>
                    </div>
            <div class="form-actions">
               <button type="submit" id="approve" class="btn green">Approve</button>
               <button type="button" id="reject" class="btn red">Reject</button>
               <button type="button" id="cancel" class="btn blue">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END VERIFIKASI USER -->



<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.1.10.4.min.js" type="text/javascript"></script>
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
      $(".date").inputmask("d/m/y");  //direct mask        
      $("#trx_date").inputmask("d/m/y");  //direct mask        
      $("#trx_date2").inputmask("d/m/y");  //direct mask        
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){

  $("#browse_branch").click(function(){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: site_url+"transaction/search_branch_by_keyword",
        data: {keyword:$("input#keyword","#dialog_branch").val()},
        async: false,
        success: function(respon){
          option = '';
          for(i = 0 ; i < respon.length ; i++)
          {
            option += '<option value="'+respon[i].branch_id+'" branch_code="'+respon[i].branch_code+'" branch_name="'+respon[i].branch_name+'">'+respon[i].branch_code+' - '+respon[i].branch_name+'</option>';
          }
          $("#result","#dialog_branch").html(option);
        }
      });
  });

  $("#result option","#dialog_branch").live('dblclick',function(){
    $("#select","#dialog_branch").trigger('click');
  });

  $("input#keyword","#dialog_branch").keypress(function(e){
    if(e.which==13){
      $.ajax({
        type: "POST",
        dataType: "json",
        url: site_url+"transaction/search_branch_by_keyword",
        data: {keyword:$(this).val()},
        async: false,
        success: function(respon){
          option = '';
          for(i = 0 ; i < respon.length ; i++)
          {
            option += '<option value="'+respon[i].branch_id+'" branch_code="'+respon[i].branch_code+'" branch_name="'+respon[i].branch_name+'">'+respon[i].branch_code+' - '+respon[i].branch_name+'</option>';
          }
          $("#result","#dialog_branch").html(option);
        }
      });
    }
  });

  // select
  $("#select","#dialog_branch").click(function(){
    branch_name = $("#result option:selected","#dialog_branch").attr('branch_name');
    branch_code = $("#result option:selected","#dialog_branch").attr('branch_code');
    branch_id = $("#result","#dialog_branch").val();
    $("#src_branch_name").val(branch_name);
    $("#branch_code").val(branch_code);
    $("#branch_id").val(branch_id);
    $(".close","#dialog_branch").click();
  });

      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'transaksi_kas_petugas';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#transaksi_kas_petugas .group-checkable').live('change',function () {
          var set = jQuery(this).attr("data-set");
          var checked = jQuery(this).is(":checked");
          jQuery(set).each(function () {
              if (checked) {
                  $(this).attr("checked", true);
              } else {
                  $(this).attr("checked", false);
              }
          });
          jQuery.uniform.update(set);
      });

      $("#transaksi_kas_petugas .checkboxes").livequery(function(){
        $(this).uniform();
      });

      // begin first table
      var table = $('#transaksi_kas_petugas').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"transaction/datatable_verifikasi_transaksi_kas_petugas",
           "fnServerParams": function ( aoData ) {
                aoData.push( { "name": "from_date", "value": $("#from_date").val() } );
                aoData.push( { "name": "thru_date", "value": $("#thru_date").val() } );
                aoData.push( { "name": "branch_code", "value": $("#branch_code").val() } );
            },
          "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            { "bSortable": false, "bSearchable": false }
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

      $("#btn_filter").click(function(){
        dTreload();
      })

      // event button Edit ketika di tekan
      $("a#link-verifikasi").live('click',function(){
        $("#wrapper-table").hide();
        $("#verifikasi").show();
        var trx_gl_cash_id = $(this).attr('trx_gl_cash_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {trx_gl_cash_id:trx_gl_cash_id},
          url: site_url+"transaction/get_trx_by_trx_gl_cash_id",
          success: function(response)
          {
            $("#form_verifikasi input[name='trx_gl_cash_id']").val(response.trx_gl_cash_id);
            tgl_trx_date = response.trx_date.substring(8,12)+'/'+response.trx_date.substring(5,7)+'/'+response.trx_date.substring(0,4);
            $("#form_verifikasi input[name='trx_date2']").val(tgl_trx_date);
            $("#form_verifikasi input[name='kas_petugas2']").val(response.account_cash_name);
            $("#form_verifikasi input[name='kas_petugas2_hidden']").val(response.account_cash_code);
            $("#form_verifikasi select[name='jenis_transaksi2']").val(response.trx_gl_cash_type);
            $("#form_verifikasi input[name='kas_teller2']").val(response.account_teller_name);
            $("#form_verifikasi input[name='kas_teller2_hidden']").val(response.account_teller_code);
            $("#form_verifikasi input[name='jumlah_setoran2']").val(number_format(response.amount,0,',','.'));
            $("#form_verifikasi input[name='no_referensi2']").val(response.voucher_ref);
            $("#form_verifikasi textarea[name='keterangan2']").val(response.description);
            $("#form_verifikasi #branch_code2").val(response.branch_name); //informasi doank
                  
          }
        })

      });

      // BEGIN FORM EDIT VALIDATION
      var form2 = $('#form_verifikasi');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);
      var success3 = $('.alert-success2', form2);

      $("#approve").click(function(e){
        e.preventDefault();
        // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
        $.ajax({
          type: "POST",
          url: site_url+"transaction/verifikasi_approve_kas_petugas",
          dataType: "json",
          data: form2.serialize(),
          success: function(response){
            if(response.success==true){
              alert("Approve Transaksi Kas Petugas Sukses!")
              $("#cancel","#form_verifikasi").trigger('click')
              // trx_gl_cash_id=$("#trx_gl_cash_id").val();
              // $("#link-verifikasi[trx_gl_cash_id='"+trx_gl_cash_id+"']").parent().parent().parent().remove();
            }else{
              alert("Approve Transaksi Kas Petugas Error!")
            }
            App.scrollTo(0,-200);
          },
          error:function(){
            alert("Failed to Connect into Databases, Please Contact Your Administartor!")
            App.scrollTo(0,-200);
          }
        });
      });

      $("#reject").click(function(e){
        e.preventDefault();
        // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
        $.ajax({
          type: "POST",
          url: site_url+"transaction/verifikasi_reject_kas_petugas",
          dataType: "json",
          data: form2.serialize(),
          success: function(response){
            if(response.success==true){
              alert("Reject Transaksi Kas Petugas Sukses!")
              $("#cancel","#form_verifikasi").trigger('click');
              // trx_gl_cash_id=$("#trx_gl_cash_id").val();
              //$("#link-verifikasi[trx_gl_cash_id='"+trx_gl_cash_id+"']").parent().parent().remove();
              // table.ajax.reload(null,false);
            }else{
              alert("Reject Transaksi Kas Petugas Error!")
            }
          },
          error:function(){
            alert("Failed to Connect into Databases, Please Contact Your Administartor!")
            App.scrollTo(0,-200);
          }
        });
      });



      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel","#form_verifikasi").click(function(){
        $("#verifikasi").hide();
        $("#wrapper-table").show();
        // dTreload();
        table.fnReloadAjax();
        success2.hide();
        error2.hide();
      });
      
      jQuery('#deposito_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#deposito_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS
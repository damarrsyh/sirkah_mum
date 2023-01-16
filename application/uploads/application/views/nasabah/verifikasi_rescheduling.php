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
      Verifikasi Re-Scheduling
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>
         <li><a href="#">Pembiayaan</a><i class="icon-angle-right"></i></li>
         <li><a href="#">Verifikasi Re-Scheduling</a></li>
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<div id="table-verifikasi-rescheduling">
  <div class="portlet box green">
    <div class="portlet-title">
       <div class="caption"><i class="icon-reorder"></i>Verifikasi Re-Scheduling</div>
       <div class="tools">
          <a href="javascript:;" class="collapse"></a>
       </div>
    </div>
    <div class="portlet-body form">
      <div class="clearfix" style="background:#EEE" id="form-filter">
        <label style="line-height:43px;float:left;margin-bottom:0;padding:0 5px 0 10px">Tanggal Re-Schedule</label>
        <div style="padding:5px;float:left;">
          <input type="text" class="m-wrap small date-picker date-mask" placeholder="dd/mm/yyyy" style="background:white;margin:0;" id="tanggal">
        </div>
        <div style="padding:5px;float:left;line-height:30px;;">
          <button class="btn blue" id="btn-filter">Filter</button>
        </div>
      </div>
      <hr style="margin:0 0 10px;">
      <table class="table table-striped table-bordered table-hover" id="verifikasi-rescheduling">
         <thead>
            <tr>
               <th width="15%">No.Rekening</th>
               <th width="20%">Nama</th>
               <th width="13%">Pokok</th>
               <th width="13%">Margin</th>
               <th width="14%">Tanggal Jtempo</th>
               <th width="15%">Pembaharuan Ke</th>
               <th>Verifikasi</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
    </div>
  </div>

</div>

<!-- BEGIN ADD RE-SCHEDULING -->
<div id="form-verifikasi-rescheduling" style="display:none;">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Verifikasi Re-Scheduling</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" method="post" enctype="multipart/form-data" id="form_act" class="form-horizontal">
            <input type="hidden" id="cif_type">
            <input type="hidden" id="cif_no" name="cif_no">
            <input type="hidden" name="product_code" id="product_code"/>
            <input type="hidden" name="account_rescheduling_id" id="account_rescheduling_id"/>
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Droping telah dikoreksi!
            </div>
            <br>
            <div class="control-group">
              <label class="control-label">No. Pembiayaan<span class="required">*</span></label>
              <div class="controls">
                <input type="text" name="account_financing_no" id="account_financing_no" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
              </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Lengkap</label>
               <div class="controls">
                  <input name="nama" id="nama" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Ibu Kandung</label>
               <div class="controls">
                  <input name="nama_ibukandung" id="nama_ibukandung" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tempat Lahir</label>
               <div class="controls">
                  <input name="tempatlahir" id="tempatlahir" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                  <span style="line-height:33px;">Tanggal Lahir&nbsp;</span>
                  <input name="tanggallahir" id="tanggallahir" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
                  <input name="usia" id="usia" data-required="1" type="text" class="m-wrap" readonly="readonly" style="width:30px;background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group" id="wrap_cm_name" style="display:none;">
               <label class="control-label">Majelis</label>
               <div class="controls">
                  <input name="cm_name" id="cm_name" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <hr size="1">
            <div class="row-fluid">
              <div class="span6" id="datasebelumnya">
                <h3>Data Sebelum Pembaharuan</h3>
                <div class="control-group">
                   <label class="control-label">Pokok</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="pokok_o" id="pokok_o" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Margin</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="margin_o" id="margin_o" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Saldo Pokok</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="saldopokok_o" id="saldopokok_o" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Saldo Margin</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="saldomargin_o" id="saldomargin_o" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Saldo Catab</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="saldocatab_o" id="saldocatab_o" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Jangka Waktu</label>
                   <div class="controls">
                     <input name="jangkawaktu_o" id="jangkawaktu_o" data-required="1" type="text" class="m-wrap" readonly="readonly" style="width:30px;background-color:#eee;"/>
                     <select class="m-wrap medium" style="background-color:#eee;" disabled="disabled" id="pjw_o">
                       <option value="">PILIH</option>
                       <option value="0">Harian</option>
                       <option value="1">Mingguan</option>
                       <option value="2">Bulanan</option>
                       <option value="3">Jatuh Tempo</option>
                     </select>
                     <input type="hidden" name="periodejangkawaktu_o" id="periodejangkawaktu_o">
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Angsuran Pokok</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="angsuranpokok_o" id="angsuranpokok_o" data-required="1" type="text" class="small mask-money m-wrap" readonly="readonly" style="background-color:#eee;"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Angsuran Margin</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="angsuranmargin_o" id="angsuranmargin_o" data-required="1" type="text" class="small mask-money m-wrap" readonly="readonly" style="background-color:#eee;"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Angsuran Catab</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="angsurancatab_o" id="angsurancatab_o" data-required="1" type="text" class="small mask-money m-wrap" readonly="readonly" style="background-color:#eee;"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tabungan Wajib</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="angsurantabwajib_o" id="angsurantabwajib_o" data-required="1" type="text" class="small mask-money m-wrap" readonly="readonly" style="background-color:#eee;"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tabungan Kelompok</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="angsurantabkelompok_o" id="angsurantabkelompok_o" data-required="1" type="text" class="small mask-money m-wrap" readonly="readonly" style="background-color:#eee;"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tanggal Akad</label>
                   <div class="controls">
                      <input name="tanggalakad_o" id="tanggalakad_o" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tanggal Mulai Angsur</label>
                   <div class="controls">
                      <input name="tanggalmulaiangsur_o" id="tanggalmulaiangsur_o" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tanggal Jtempo</label>
                   <div class="controls">
                      <input name="tanggaljtempo_o" id="tanggaljtempo_o" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
                   </div>
                </div>
              </div>
              <div class="span6" id="datasetelahnya">
              <h3>Data Setelah Pembaharuan</h3>
                <div class="control-group">
                   <label class="control-label">Pokok</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="saldopokok_n" id="saldopokok_n" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background:#EEE"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Margin</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="saldomargin_n" id="saldomargin_n" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background:#EEE"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Saldo Catab</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="saldocatab_n" id="saldocatab_n" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background:#EEE"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Saldo Jangka Waktu</label>
                   <div class="controls">
                     <input name="jangkawaktu_n" id="jangkawaktu_n" data-required="1" type="text" class="m-wrap" readonly="readonly" style="width:30px;background:#EEE"/>
                     <select class="m-wrap medium" id="pjw_n" name="pjw_n" disabled="disabled" style="background:#EEE">
                      <option value="">PILIH</option>
                      <option value="0">Harian</option>
                      <option value="1">Mingguan</option>
                      <option value="2">Bulanan</option>
                      <option value="3">Jatuh Tempo</option>
                     </select>
                     <input type="hidden" name="periodejangkawaktu_n" id="periodejangkawaktu_n">
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Angsuran Pokok</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="angsuranpokok_n" id="angsuranpokok_n" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background:#EEE"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Angsuran Margin</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="angsuranmargin_n" id="angsuranmargin_n" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background:#EEE"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Angsuran Catab</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="angsurancatab_n" id="angsurancatab_n" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background:#EEE"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tabungan Wajib</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="angsurantabwajib_n" id="angsurantabwajib_n" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background:#eee;" />
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tabungan Kelompok</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="angsurantabkelompok_n" id="angsurantabkelompok_n" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background:#eee;" />
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tgl Pembaharuan/Akad</label>
                   <div class="controls">
                      <input name="tanggal_reschedule" id="tanggal_reschedule" data-required="1" type="text" placeholder="dd/mm/yyyy" class="date-picker date-mask small m-wrap" readonly="readonly" style="background:#EEE"/>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tanggal Mulai Angsur</label>
                   <div class="controls">
                      <input name="tanggalmulaiangsur_n" id="tanggalmulaiangsur_n" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#EEE" />
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tanggal Jtempo</label>
                   <div class="controls">
                      <input name="tanggaljtempo_n" id="tanggaljtempo_n" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#EEE" />
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Pembaharuan Ke</label>
                   <div class="controls">
                      <input name="reschedule_ke" id="reschedule_ke" data-required="1" type="text" class="m-wrap" readonly="readonly" style="width:30px;background:#EEE"/>
                   </div>
                </div>
              </div>
            </div>
            <div class="form-actions">
               <button type="button" class="btn green" id="approve">Approve</button>
               <button type="button" class="btn purple" id="reject">Reject</button>
               <button type="button" class="btn red" id="cancel">Cancel</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END ADD REMBUG -->

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
    
      $(".date-mask").inputmask("d/m/y");  //direct mask        
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
$(function(){
  $("#btn-filter").click(function(){
    $("select[name='verifikasi-rescheduling_length']").trigger('change');
  })
  // begin first table
  $('#verifikasi-rescheduling').dataTable({
     "bDestroy":true,
     "bProcessing": true,
     "bServerSide": true,
     "sAjaxSource": site_url+"rekening_nasabah/datatable_verifikasi_rescheduling",
     "fnServerParams": function ( aoData ) {
          aoData.push( { "name": "tanggal_reschedule", "value": $("#tanggal").val() } );
      },
     "aoColumns": [
        null,
        null,
        null,
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
     "sZeroRecords" : "Data Tidak Ditemukan",
     "aoColumnDefs": [{
             'bSortable': false,
             'aTargets': [0]
         }
     ]
  });
  $("#verifikasi-rescheduling_length").closest('.row-fluid').hide();

  $("a#link-edit").live('click',function(e){
    $("#form-verifikasi-rescheduling").show();
    $("#table-verifikasi-rescheduling").hide();
    aData = $(this);
    account_rescheduling_id=aData.attr('account_rescheduling_id');
    account_financing_no=aData.attr('account_financing_no');
    cm_name=aData.attr('cm_name');
    nama=aData.attr('nama');
    ibu_kandung=aData.attr('ibu_kandung');
    tmp_lahir=aData.attr('tmp_lahir');
    tgl_lahir=aData.attr('tgl_lahir');
    usia=aData.attr('usia');
    
    pokok_o=aData.attr('pokok_o');
    margin_o=aData.attr('margin_o');
    saldopokok_o=aData.attr('saldo_pokok_o');
    saldomargin_o=aData.attr('saldo_margin_o');
    saldocatab_o=aData.attr('saldo_catab_o');
    jangkawaktu_o=aData.attr('jangka_waktu_o');
    periodejangkawaktu_o=aData.attr('periode_jangka_waktu_o');
    angsuranpokok_o=aData.attr('angsuran_pokok_o');
    angsuranmargin_o=aData.attr('angsuran_margin_o');
    angsurancatab_o=aData.attr('angsuran_catab_o');
    angsurantabwajib_o=aData.attr('angsuran_tab_wajib_o');
    angsurantabkelompok_o=aData.attr('angsuran_tab_kelompok_o');
    tanggalakad_o=aData.attr('tanggal_akad_o');
    tanggalmulaiangsur_o=aData.attr('tanggal_mulai_angsur_o');
    tanggaljtempo_o=aData.attr('tanggal_jtempo_o');

    saldopokok_n=aData.attr('pokok_n');
    saldomargin_n=aData.attr('margin_n');
    saldocatab_n=aData.attr('saldo_catab_o');
    jangkawaktu_n=aData.attr('jangka_waktu_n');
    periodejangkawaktu_n=aData.attr('periode_jangka_waktu_n');
    angsuranpokok_n=aData.attr('angsuran_pokok_n');
    angsuranmargin_n=aData.attr('angsuran_margin_n');
    angsurancatab_n=aData.attr('angsuran_catab_n');
    angsurantabwajib_n=aData.attr('angsuran_tab_wajib_n');
    angsurantabkelompok_n=aData.attr('angsuran_tab_kelompok_n');
    // tanggalakad_n=aData.attr('tanggal_akad_o');
    tanggalmulaiangsur_n=aData.attr('tanggal_mulai_angsur_n');
    tanggaljtempo_n=aData.attr('tanggal_jtempo_n');

    reschedule_ke=aData.attr('reschedule_ke');
    tanggal_reschedule=aData.attr('tanggal_reschedule');

    ts=tgl_lahir.split('-');
    tgl_lahir=ts[2]+'/'+ts[1]+'/'+ts[0];
    ts=tanggalakad_o.split('-');
    tanggalakad_o=ts[2]+'/'+ts[1]+'/'+ts[0];
    ts=tanggalmulaiangsur_o.split('-');
    tanggalmulaiangsur_o=ts[2]+'/'+ts[1]+'/'+ts[0];
    ts=tanggaljtempo_o.split('-');
    tanggaljtempo_o=ts[2]+'/'+ts[1]+'/'+ts[0];
    // ts=tanggalakad_n.split('-');
    // tanggalakad_n=ts[2]+'/'+ts[1]+'/'+ts[0];
    ts=tanggalmulaiangsur_n.split('-');
    tanggalmulaiangsur_n=ts[2]+'/'+ts[1]+'/'+ts[0];
    ts=tanggaljtempo_n.split('-');
    tanggaljtempo_n=ts[2]+'/'+ts[1]+'/'+ts[0];
    ts=tanggal_reschedule.split('-');
    tanggal_reschedule=ts[2]+'/'+ts[1]+'/'+ts[0];

    if(cm_name!=""){
      $("#wrap_cm_name").show();
      $("#cm_name").val(cm_name);
    }else{
      $("#wrap_cm_name").hide();
      $("#cm_name").val('');
    }
    
    $("#account_rescheduling_id").val(account_rescheduling_id);
    $("#account_financing_no").val(account_financing_no);
    $("#nama").val(nama);
    $("#nama_ibukandung").val(ibu_kandung);
    $("#tempatlahir").val(tmp_lahir);
    $("#tanggallahir").val(tgl_lahir);
    $("#usia").val(usia);

    $("#pokok_o").val(number_format(pokok_o,0,',','.'));
    $("#margin_o").val(number_format(margin_o,0,',','.'));
    $("#saldopokok_o").val(number_format(saldopokok_o,0,',','.'));
    $("#saldomargin_o").val(number_format(saldomargin_o,0,',','.'));
    $("#saldocatab_o").val(number_format(saldocatab_o,0,',','.'));
    $("#jangkawaktu_o").val(jangkawaktu_o);
    $("#pjw_o").val(periodejangkawaktu_o);
    $("#periodejangkawaktu_o").val(periodejangkawaktu_o);
    $("#angsuranpokok_o").val(number_format(angsuranpokok_o,0,',','.'));
    $("#angsuranmargin_o").val(number_format(angsuranmargin_o,0,',','.'));
    $("#angsurancatab_o").val(number_format(angsurancatab_o,0,',','.'));
    $("#angsurantabwajib_o").val(number_format(angsurantabwajib_o,0,',','.'));
    $("#angsurantabkelompok_o").val(number_format(angsurantabkelompok_o,0,',','.'));
    $("#tanggalakad_o").val(tanggalakad_o);
    $("#tanggalmulaiangsur_o").val(tanggalmulaiangsur_o);
    $("#tanggaljtempo_o").val(tanggaljtempo_o);

    $("#saldopokok_n").val(number_format(saldopokok_n,0,',','.'));
    $("#saldomargin_n").val(number_format(saldomargin_n,0,',','.'));
    $("#saldocatab_n").val(number_format(saldocatab_n,0,',','.'));
    $("#jangkawaktu_n").val(jangkawaktu_n);
    $("#pjw_n").val(periodejangkawaktu_n);
    $("#periodejangkawaktu_n").val(periodejangkawaktu_n);
    $("#angsuranpokok_n").val(number_format(angsuranpokok_n,0,',','.'));
    $("#angsuranmargin_n").val(number_format(angsuranmargin_n,0,',','.'));
    $("#angsurancatab_n").val(number_format(angsurancatab_n,0,',','.'));
    $("#angsurantabwajib_n").val(number_format(angsurantabwajib_n,0,',','.'));
    $("#angsurantabkelompok_n").val(number_format(angsurantabkelompok_n,0,',','.'));
    // $("#tanggalakad_n").val(tanggalakad_n);
    $("#tanggalmulaiangsur_n").val(tanggalmulaiangsur_n);
    $("#tanggaljtempo_n").val(tanggaljtempo_n);

    $("#reschedule_ke").val(reschedule_ke);
    $("#tanggal_reschedule").val(tanggal_reschedule);

  });

  /*UP UNTUK FUNGSI ADD ENTER*/
  $("input,select").live('keypress',function(e){

    if(e.keyCode==13)
    {
     e.preventDefault();
      if($(this).next().prop('tagName')=='SELECT' || $(this).next().prop('tagName')=='INPUT')
      {
        $(this).next().focus();
      }
      else
      {

        if($(this).closest('.control-group').next('.form-actions').length==1){
          $(this).closest('.control-group').next('.form-actions').find('button:first').focus();
        }else{
          if(typeof($(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select').attr('readonly'))!='undefined'){
            $(this).closest('.control-group').nextAll('.control-group2:visible').filter(':first').find('input,select').focus();
          }else{
            $(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select').focus();
          }
        }
        
      }
    }
    
  });

  /*
  | APPROVE
  */
  form=$("#form_act");
  $("#approve").click(function(e){
    e.preventDefault();
    account_financing_no=$("#account_financing_no");
    bValid=true;
    if(account_financing_no.val()==""){
      alert("Mohon pilih No.Pembiayaan terlebih dahulu!")
      bValid=false;
    }
    if(bValid==true){
      var conf = confirm("Approve Re-Scheduling. Anda yakin?");
      if(conf){
        $.ajax({
          type:"POST",
          dataType:"json",
          data:form.serialize(),
          url:site_url+"/rekening_nasabah/approve_rescheduling",
          async: false,
          success: function(response){
            if(response.success===true){
              alert("Approve Re-Scheduling SUKSES!");
            }else{
              alert("Something wrong when processing. Please contact your Adminstrator!");
            }
            $("#cancel").trigger('click');
          },
          error: function(){
            alert("Something wrong when processing. Please contact your Adminstrator!");
          }
        });
      }
    }
  });

  $("#reject").click(function(e){
    e.preventDefault();
    account_financing_no=$("#account_financing_no");
    bValid=true;
    if(account_financing_no.val()==""){
      alert("Mohon pilih No.Pembiayaan terlebih dahulu!")
      bValid=false;
    }
    if(bValid==true){
      var conf = confirm("Reject Re-Scheduling. Anda yakin?");
      if(conf){
        $.ajax({
          type:"POST",
          dataType:"json",
          data:form.serialize(),
          url:site_url+"/rekening_nasabah/reject_rescheduling",
          async: false,
          success: function(response){
            if(response.success===true){
              alert("Reject Re-Scheduling SUKSES!");
            }else{
              alert("Something wrong when processing. Please contact your Adminstrator!");
            }
            $("#cancel").trigger('click');
          },
          error: function(){
            alert("Something wrong when processing. Please contact your Adminstrator!");
          }
        });
      }
    }
  });

  $("#cancel").click(function(e){
    e.preventDefault();
    $("#form-verifikasi-rescheduling").hide();
    $("#table-verifikasi-rescheduling").show();
    $("select[name='verifikasi-rescheduling_length']").trigger('change');
  });

});
</script>
<!-- END JAVASCRIPTS -->

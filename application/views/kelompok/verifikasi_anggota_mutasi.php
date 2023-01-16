BEGIN PAGE HEADER-->
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
      VERIFIKASI <small>Mutasi Anggota Pindah</small>
    </h3>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

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
      <div class="caption"><i class="icon-globe"></i>Verifikasi Mutasi Anggota Pindah</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
         <label>
            Kantor Cabang &nbsp; : &nbsp;
            <input type="text" name="src_branch_name" id="src_branch_name" class="medium m-wrap" disabled>
            <input type="hidden" name="branch_code" id="branch_code">
            <input type="hidden" name="branch_id" id="branch_id">
            <a id="browse_branch" class="btn blue" data-toggle="modal" href="#dialog_branch">...</a>
            &nbsp; &nbsp;
            Tanggal Transaksi &nbsp; : &nbsp;
            <input type="text" name="src_trx_date" id="src_trx_date" value="<?php echo $current_date; ?>" class="small m-wrap date-picker date-mask">
            <input type="submit" id="search" value="Filter" class="btn green">
         </label>
      </div>
      <table class="table table-striped table-bordered table-hover" id="mutasi_anggota_keluar" style="margin-top:30px;">
         <thead>
            <tr>
               <th style="text-align:center" width="15%">Rembug</th>
               <th style="text-align:center" width="15%">ID Anggota</th>
               <th style="text-align:center" width="25%">Nama</th>
               <th style="text-align:center" width="15%">Tgl Mutasi</th>
               <th style="text-align:center" width="15%">Created Date</th>
               <th style="text-align:center" width="15%">Created By</th>
               <th style="text-align:center">Verifikasi</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- BEGIN ADD USER -->
<div id="verifikasi" style="display:none;">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Verifikasi Pindah Majlis Anggota</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM--> 
         <form action="#" id="form_add" class="form-horizontal">  
            <input type="hidden" id="cif_mutasi_id" name="cif_mutasi_id">
            <div class="alert alert-error hide">
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
            <div style="width:50%;float:left">

            <div class="control-group">
               <label class="control-label">Rembug Asal<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="rembug" id="rembug" data-required="1" class="medium m-wrap" readonly=""  style="background-color:#f9f9f9;"/>  
               </div>
            </div>  
            <div class="control-group">
               <label class="control-label">ID Anggota<span class="required">*</span></label>
               <div class="controls">
                    <input type="text" name="id_anggota" id="id_anggota" class="medium m-wrap" readonly="" style="background-color:#f9f9f9" data-required="1" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama </label>
               <div class="controls">
                  <input type="text" name="nama" id="nama" data-required="1" class="medium m-wrap" readonly=""  style="background-color:#f9f9f9;"/>
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
               <label class="control-label">Saldo Tab. Wajib</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="saldo_tab_wajib" id="saldo_tab_wajib" data-required="1" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                  <span style="line-height:32px;margin-left:10px;display:none;"><input type="checkbox" id="flag_saldo_tabungan_wajib" name="flag_saldo_tabungan_wajib" value="1" checked="checked"></span>                  
                </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Tab. Kelompok</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="saldo_tab_kelompok" id="saldo_tab_kelompok" data-required="1" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                  <span style="line-height:32px;margin-left:10px;display:none;"><input type="checkbox" id="flag_saldo_tabungan_kelompok" name="flag_saldo_tabungan_kelompok" value="1" checked="checked"></span>
                </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Tab. Sukarela</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="saldo_tab_sukarela" id="saldo_tab_sukarela" data-required="1" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div>
            
            <div class="control-group">
               <label class="control-label">Saldo Tab. Berencana</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="saldo_tab_berencana" id="saldo_tab_berencana" data-required="1" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                </div>
                <div style="font-size:11px;" id="product_saving_description"><!-- ket produk --></div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Tab. Individu</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="saldo_individu" id="saldo_individu" data-required="1" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
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

            <!--
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
            

            <div class="control-group hidden">
               <label class="control-label">Saldo Cadangan Resiko</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="saldo_cadangan_resiko" id="saldo_cadangan_resiko" data-required="1" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div>

            -->

            
            <div class="control-group">
               <label class="control-label">Saldo Simpok / LWK</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="saldo_lwk" id="saldo_lwk" data-required="1" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div> 

            <div class="control-group">
               <label class="control-label">Saldo Simwa</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="saldo_tabu_mingguan" id="saldo_tab_mingguan" data-required="1" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div>

            <!--
            <div class="control-group">
               <label class="control-label">Saldo Tabungan Majelis</label>
               <div class="controls">
                <div class="input-append input-prepend">
                  <span class="add-on">Rp</span>
                    <input type="text" name="saldo_mingguan" id="saldo_mingguan" data-required="1" class="small m-wrap" readonly=""  style="text-align:right;background-color:#f9f9f9;"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div>
            -->

            <div class="control-group">
               <label class="control-label">Saldo Set. Pokok</label>
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
               <label class="control-label">Tanggal Mutasi<span class="required">*</span></label>
               <div class="controls">
                <input type="text" name="tanggal_mutasi" id="tanggal_mutasi" class="small m-wrap" readonly="" style="background-color:#f9f9f9;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Rembug Tujuan<span class="required">*</span></label>
               <div class="controls">
                  <input type="hidden" id="var_cm_code_baru" name="var_cm_code_baru">
                  <input type="text" name="rembug_baru" id="rembug_baru" data-required="1" class="medium m-wrap" readonly=""  style="background-color:#f9f9f9;"/>  
               </div>
            </div>  
            <div class="control-group">
               <label class="control-label">Alasan<span class="required">*</span></label>
               <div class="controls">
                  <textarea id="alasan" name="alasan" class="m-wrap medium" readonly="" style="background-color:#f9f9f9"></textarea>
               </div> 
            </div>    

            </div>    
            </div>       
            <div class="form-actions">
               <input type="hidden" id="cif_no" name="cif_no">
               <button type="button" class="btn green" id="approve">Approve</button>
               <button type="button" class="btn red" id="reject">Reject</button>
               <button type="button" class="btn blue" id="cancel">Cancel</button>
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
<!-- <script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js" type="text/javascript"></script>aa -->
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
     
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){

  /**
  * ----------------------------------------------------------------------------------------
  * DATATABLE BEGIN
  * ----------------------------------------------------------------------------------------
  */
  // fungsi untuk reload data table
  // di dalam fungsi ini ada variable tbl_id
  // gantilah value dari tbl_id ini sesuai dengan element nya
  var dTreload = function()
  {
    var tbl_id = 'mutasi_anggota_keluar';
    $("select[name='"+tbl_id+"_length']").trigger('change');
    $(".paging_bootstrap li:first a").trigger('click');
    $("#"+tbl_id+"_filter input").val('').trigger('keyup');
  }

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
    $("#close").click();
  });

  // begin first table

  $("#search").click(function(){
      table=$('#mutasi_anggota_keluar').dataTable({
          "bDestroy":true,
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"kelompok/datatable_verifikasi_mutasi_anggota_pindah",
           "fnServerParams": function ( aoData ) {
                aoData.push( { "name": "branch_id", "value": $("#branch_id").val() } );
                aoData.push( { "name": "branch_code", "value": $("#branch_code").val() } );
                aoData.push( { "name": "trx_date", "value": $("#src_trx_date").val() } );
            },
          "aoColumns": [
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
      
      $(".dataTables_length,.dataTables_filter").parent().hide();
  })


  /**
  * ----------------------------------------------------------------------------------------
  * DATATABLE END
  * ----------------------------------------------------------------------------------------
  */

  $("a#link-verifikasi").live('click',function(){
    $("#wrapper-table").hide();
    $("#verifikasi").show();
    var cif_mutasi_id = $(this).attr('cif_mutasi_id');
    var cm_code = $(this).attr('cm_code');
    var cm_name = $(this).attr('cm_name');
    var cif_no = $(this).attr('cif_no');
    var nama = $(this).attr('nama');

    var saldo_pembiayaan = $(this).parent().find("#h_saldo_pembiayaan").val();  
    var saldo_margin = $(this).parent().find("#h_saldo_margin").val(); 
    var saldo_catab = $(this).parent().find("#h_saldo_catab").val(); 
    var saldo_tab_wajib = $(this).parent().find("#h_saldo_tab_wajib").val(); 
    var saldo_tab_kelompok = $(this).parent().find("#h_saldo_tab_kelompok").val(); 
    var saldo_tab_sukarela = $(this).parent().find("#h_saldo_tab_sukarela").val(); 
    var saldo_tab_berencana = $(this).parent().find("#h_saldo_tab_berencana").val(); 
    var saldo_individu = $(this).parent().find("#h_saldo_individu").val(); 
    var bonus_bagihasil = $(this).parent().find("#bonus_bagihasil").val(); 
    var saldo_simpanan_pokok = $(this).parent().find("#h_saldo_simpanan_pokok").val(); 
    var saldo_simpanan_wajib = $(this).parent().find("#h_saldo_simpanan_wajib").val(); 
    var saldo_smk =  $(this).parent().find("#h_saldo_smk").val(); 
    var saldo_lwk = $(this).parent().find("#h_saldo_lwk").val(); 

    var tanggal_mutasi = $(this).attr('tanggal_mutasi');
    var alasan = $(this).parent().find("#h_alasan").val();
    var cm_code_baru = $(this).parent().find("#h_cm_code_baru").val();
    var rembug_baru = $(this).parent().find("#h_rembug_baru").val();





    $("#var_cm_code_baru").val(cm_code_baru);
    $("#rembug_baru").val(rembug_baru);

    $("#cif_mutasi_id").val(cif_mutasi_id);
    $("#rembug").val(cm_name);
    $("#id_anggota").val(cif_no);
    $("#nama").val(nama);
    $("#saldo_pembiayaan").val(saldo_pembiayaan);
    $("#saldo_margin").val(saldo_margin);
    $("#saldo_catab").val(saldo_catab); 
    $("#saldo_tab_wajib").val(saldo_tab_wajib);
    $("#saldo_tab_kelompok").val(saldo_tab_kelompok);
    $("#saldo_tab_sukarela").val(saldo_tab_sukarela);
    $("#saldo_tab_berencana").val(saldo_tab_berencana);
    $("#saldo_individu").val(saldo_individu);
    $("#bonus_bagihasil").val(bonus_bagihasil);
    $("#saldo_simpanan_pokok").val(saldo_simpanan_pokok);
    $("#saldo_simpanan_wajib").val(saldo_simpanan_wajib);
    $("#saldo_smk").val(saldo_smk);
    $("#saldo_lwk").val(saldo_lwk); 

    $("#tanggal_mutasi").val(tanggal_mutasi);
    $("select[name='id_anggota']").trigger('change');

    $("#alasan").val(alasan); 

  });
  
  $("#approve","#verifikasi").click(function(){
    var_cm_code_baru = $("#var_cm_code_baru").val();
    cif_mutasi_id = $("#cif_mutasi_id").val();
    conf = confirm(" Lakukan Appoval Pindah Majlis ?")
    cif_no = $("#id_anggota").val();
    if(conf)
    {
      $.ajax({
        url:site_url+"kelompok/verifikasi_approve_mutasi_anggota_pindah",
        type:"POST",
        dataType:"json",
        data:{cif_mutasi_id:cif_mutasi_id,cif_no:cif_no,var_cm_code_baru:var_cm_code_baru},
        success: function(response){
          if(response.success==true){
            alert("Verifikasi Pindah Majelis Anggota, Berhasil !");
            $("#verifikasi").hide();
            $("#wrapper-table").show();
            table.fnReloadAjax();
            App.scrollTo(0,-200);
          }else{
            alert("Verifikasi Pindah Majelis Anggota, Gagal !");
          }
        },
        error: function(){
          alert("Failed to Connect into Databases, Please Contact Your Administrator!");
        }
      })
    }
  });

  
  $("#reject","#verifikasi").click(function(){
    cif_mutasi_id = $("#cif_mutasi_id").val();
    cif_no = $("#id_anggota").val();
    conf = confirm("Apakah anda yakin akan melakukan Reject ?")
    if(conf)
    {
      $.ajax({
        url:site_url+"kelompok/verifikasi_reject_mutasi_anggota_pindah",
        type:"POST",
        dataType:"json",
        data:{cif_mutasi_id:cif_mutasi_id,cif_no:cif_no},
        success: function(response){
          if(response.success==true){
            alert("Reject Registrasi Anggota Pindah Berhasil!");
            $("#verifikasi").hide();
            $("#wrapper-table").show();
            table.fnReloadAjax();
            App.scrollTo(0,-200);
          }else{
            alert("Reject Registrasi Anggota Pindah Error!");
          }
        },
        error: function(){
          alert("Failed to Connect into Databases, Please Contact Your Administrator!");
        }
      })
    }
  });
  
  $("#cancel","#verifikasi").click(function(){
    $("#verifikasi").hide();
    $("#wrapper-table").show();
    table.fnReloadAjax();
    App.scrollTo(0,-200);
  });

});
</script>
<!-- END JAVASCRIPTS
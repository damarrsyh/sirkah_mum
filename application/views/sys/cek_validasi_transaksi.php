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
      CEK VALIDASI TRANSAKSI <small>modul untuk mengecek validasi transaksi</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="#">Transaction</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Proses Akhir Bulan</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Cek Validasi Transaksi</a></li>  
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

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

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Cek Validasi Transaksi</div>
   </div>
   <div class="portlet-body">
    <table id="filter-form">
       <tr>
          <td style="padding-bottom:10px;" width="100">Cabang</td>
          <td>
             <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code'); ?>">
             <input type="text" name="branch" id="branch" class="m-wrap mfi-textfield" value="<?php echo $this->session->userdata('branch_name'); ?>" readonly style="background:#EEE"> 
             <?php if($this->session->userdata('flag_all_branch')=='1'){ ?><a id="browse_branch" class="btn blue" style="margin-top:8px;padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a><?php } ?>
          </td>
       </tr>
       <tr>
          <td style="padding-bottom:10px;" width="100">Tanggal</td>
          <td>
             <input type="text" name="from_date" id="from_date" class="m-wrap mfi-textfield date-picker mask_date" placeholder="dd/mm/yyyy" value="<?php echo date('d/m/Y') ?>">
             <span style="line-height:40px;height:40px;">s/d &nbsp;</span>
             <input type="text" name="thru_date" id="thru_date" class="m-wrap mfi-textfield date-picker mask_date" placeholder="dd/mm/yyyy" value="<?php echo date('d/m/Y') ?>">
          </td>
       </tr>
       <tr>
          <td style="padding-bottom:10px;" width="100"></td>
          <td>
            <button id="filter" class="btn green"><i class="icon-search"></i> Search</button>
          </td>
       </tr>
    </table>
    <hr size="1">
    <div id="unverifieds"><?php echo $unverifieds; ?></div>
    <table width="80%" border="1" id="cek-validasi" cellpadding="5">
      <thead>
        <tr>
          <th style="background:#ccc;" width="20%"></th>
          <th style="background:#ccc;" colspan="2">Ledger</th>
          <th style="background:#ccc;" colspan="2">Rinci</th>
        </tr>
        <tr>
          <th style="background:#ccc;"></th>
          <!-- <th style="background:#ccc;" width="10%">Saldo Awal</th> -->
          <th style="background:#ccc;" width="10%">Debet</th>
          <th style="background:#ccc;" width="10%">Kredit</th>
          <!-- <th style="background:#ccc;" width="10%">Saldo Akhir</th> -->
          <!-- <th style="background:#ccc;" width="10%">Saldo Awal</th> -->
          <th style="background:#ccc;" width="10%">Debet</th>
          <th style="background:#ccc;" width="10%">Kredit</th>
          <!-- <th style="background:#ccc;" width="10%">Saldo Akhir</th> -->
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="9" style="padding:5px;font-size:11px;">Data is Empty...</td>
        </tr>
      </tbody>
    </table>
    <br>
    <table width="70%" border="1" id="cek-outstanding" cellpadding="5">
      <thead>
        <tr>
          <th style="background:#ccc;" width="40%"></th>
          <th style="background:#ccc;" width="20%">Ledger</th>
          <th style="background:#ccc;" width="20%">Rinci</th>
          <th style="background:#ccc;" width="20%">Selisih</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="4" style="padding:5px;font-size:11px;">Data is Empty...</td>
        </tr>
      </tbody>
    </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->


<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/jquery.json-2.2.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/form-components.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/index.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>           
<script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>   
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/scripts/ui-modals.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
   jQuery(document).ready(function() {
      App.init() // initlayout and core plugins
      Index.init()
      $(".mask_date").inputmask("d/m/y")  //direct mask    
      // FormComponents.init();
      
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
$(function(){

   /* BEGIN DIALOG ACTION BRANCH */
  
   $("#browse_branch").click(function(){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         data: {keyword:$("#keyword","#dialog_branch").val()},
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            $("#result","#dialog_branch").html(html);
         }
      })
   })

   $("#keyword","#dialog_branch").keyup(function(e){
      e.preventDefault();
      keyword = $(this).val();
      if(e.which==13)
      {
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
      if(result!=null)
      {
         $("input[name='branch']").val(result_name);
         $("input[name='branch_code']").val(result_code);
         $("input[name='branch_id']").val(branch_id);
         $("#close","#dialog_branch").trigger('click');
      }
   });

   $("#result option:selected","#dialog_branch").live('dblclick',function(){
    $("#select","#dialog_branch").trigger('click');
   })

   /* END DIALOG ACTION BRANCH */

   $("#filter").click(function(e){
    e.preventDefault();
    var branch_code = $("#branch_code").val();
    var from_date = $("#from_date").val();
    var thru_date = $("#thru_date").val();


    $.ajax({
      type:"POST",dataType:'html',data:{branch_code:branch_code},
      url:site_url+'sys/ajax_get_unverifieds',
      success: function(response) {
        $('#unverifieds').html(response);
      }
    });
    $.ajax({
      type:"POST",
      dataType:"json",data:{
        branch_code:branch_code,from_date:from_date,thru_date:thru_date
      },
      url: site_url+"sys/load_data_cek_validasi_transaksi",
      // async:false,
      success:function(response){
        $("#cek-validasi tbody").html(response.html);
      }
    });
    $.ajax({
      type:"POST",
      dataType:"json",data:{
        branch_code:branch_code,from_date:from_date,thru_date:thru_date
      },
      //url: site_url+"sys/load_data_cek_outstanding",
	  url: site_url+'sys/load_data_cek',
      // async:false,
      success:function(response){
        $("#cek-outstanding tbody").html(response.html);
      }
    });
   })

})
</script>
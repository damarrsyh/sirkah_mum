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
        Laporan <small>Statement Tabungan Kelompok</small>
      </h3>
      <!-- END PAGE TITLE-->
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

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Laporan Statemen Tabungan Kelompok</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body form">
      <form action="#" class="form-horizontal" id="form-filter">
        <div class="control-group">
          <label class="control-label">Kantor Cabang</label>
          <div class="controls">
            <input type="text" name="branch_name" id="branch_name" data-required="1" class="medium m-wrap" value="<?php echo $this->session->userdata('branch_name'); ?>" readonly style="background:#EEE"/>
            <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code') ?>">
            <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id') ?>">
            <?php if($this->session->userdata('flag_all_branch')=='1'){ ?><a id="browse_branch" class="btn blue" data-toggle="modal" href="#dialog_kantor_cabang">...</a><?php } ?>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">Rembug</label>
          <div class="controls">
            <select class="m-wrap chosen large" name="cm_code" id="cm_code">
              <option value="">SILAHKAN PILIH</option>
              <?php foreach($cms as $cm): ?>
              <option value="<?php echo $cm['cm_code'] ?>"><?php echo $cm['cm_code'].' - '.$cm['cm_name'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">Anggota</label>
          <div class="controls">
            <select class="m-wrap chosen large" name="cif_no" id="cif_no">
              
            </select>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">Tabungan</label>
          <div class="controls">
            <select class="m-wrap chosen medium" name="tabungan" id="tabungan">
              <option value="">SILAHKAN PILIH</option>
              <option value="tab_sukarela">Tabungan Sukarela</option>
              <option value="tab_wajib">Tabungan Wajib</option>
              <option value="tab_kelompok">Tabungan Kelompok</option>
              <option value="sim_wajib">Simpanan Wajib</option>
              <option value="tab_berencana">Tabungan Berencana</option>
            </select>
          </div>
        </div>
        <div class="control-group" id="wrap-no_rekening">
          <label class="control-label">No.Rekening</label>
          <div class="controls">
            <select class="m-wrap chosen large" name="no_rekening" id="no_rekening">
              
            </select>
          </div>
        </div>        
        <div class="control-group">
           <label class="control-label">Periode<span class="required">*</span></label>
           <div class="controls">
             <input type="text" name="tanggal" id="tanggal" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" value="<?php echo $current_date; ?>" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
              sd
             <input type="text" name="tanggal2" id="tanggal2" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" value="<?php echo $current_date; ?>" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
           </div>
        </div>  
        <div class="form-actions">
          <button id="preview_pdf" class="btn green" type="button">PDF</button>
        </div>
      </form>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->


<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->  
<script type="text/javascript">
jQuery(document).ready(function() {    
  App.init(); // initlayout and core plugins

  /*start script*/


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
            html = '<option value="0000" branch_name="Semua Branch" branch_id="0000">0000 - Semua Branch</option>';
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
            html = '<option value="0000" branch_name="Semua Branch" branch_id="0000">0000 - Semua Branch</option>';
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
  $.ajax({
    type:"POST",dataType:"json",data:{branch_id:branch_id},
    url:site_url+'/laporan/get_cm_by_branch_id',
    success:function(response){
      html = '<option value="">SILAHKAN PILIH</option>';
      for ( x in response ) {
        html += '<option value="'+response[x].cm_code+'">'+response[x].cm_name+'</option>';
      }
      $('#cm_code').html(html).trigger('liszt:updated');
    }
  })
});

$("#result option","#dialog_kantor_cabang").live('dblclick',function(){
  $("#select","#dialog_kantor_cabang").trigger('click');
});

  $("#cm_code").change(function(){
    cm_code=$(this).val();
    $.ajax({
      type:"POST",
      dataType:"json",
      data:{cm_code:cm_code},
      url:site_url+'laporan/get_cif_by_cm_code',
      success:function(response){
        opt='<option value="">SILAHKAN PILIH</option>';
        for(i in response){
          opt+='<option value="'+response[i].cif_no+'">'+response[i].cif_no+' - '+response[i].nama+'</option>';
        }
        $("#cif_no").html(opt).trigger('liszt:updated');
      }
    })
  });

  $("#cif_no").change(function(){
    cif_no=$(this).val();
    $.ajax({
      type:"POST",
      dataType:"json",
      data:{cif_no:cif_no},
      url:site_url+'laporan/get_account_saving_by_cif_no',
      success:function(response){
        opt='<option value="">SILAHKAN PILIH</option>';
        for(i in response){
          opt+='<option value="'+response[i].account_saving_no+'">'+response[i].account_saving_no+' - '+response[i].product_name+'</option>';
        }
        $("#no_rekening").html(opt).trigger('liszt:updated');
      }
    })
  })

  $("#tabungan").change(function(){
    tabungan=$(this).val();
    if(tabungan=='tab_berencana'){
      $("#wrap-no_rekening").val('').show();
    }else{
      $("#wrap-no_rekening").val('').hide();
    }
  });

  $("#preview_pdf").click(function(){
    var cm_code = $("#cm_code").val();
    var cif_no = $("#cif_no").val();
    var tabungan = $("#tabungan").val();
    var no_rekening = $("#no_rekening").val();
    var tanggal = $("#tanggal").val();
    var tanggal2 = $("#tanggal2").val();
    var tanggal = tanggal.replace('/', '-');
    var tanggal2 = tanggal2.replace('/', '-');
    var tanggal = tanggal.replace('/', '-');
    var tanggal2 = tanggal2.replace('/', '-');
    if(no_rekening=="") no_rekening='-';
    var bValid=true;

    if(cm_code==""){
      bValid=false;
    }
    if(cif_no==""){
      bValid=false;
    }
    if(tabungan==""){
      bValid=false;
    }

    if(bValid==false){
      alert("Please entry an empty field!");
    }else{
      window.open(site_url+'laporan_to_pdf/statement_tab_kelompok/'+cm_code+'/'+cif_no+'/'+tabungan+'/'+no_rekening+'/'+tanggal+'/'+tanggal2,'_blank');
    }

  })
});
</script>


<!-- END JAVASCRIPTS -->
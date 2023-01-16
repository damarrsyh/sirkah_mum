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
        Channelling Report <small></small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>List Debitur</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body">
      <div class="clearfix">
            <!-- BEGIN FILTER-->
              <form action="javascript:;">
                <table id="filter-form">
                  <tr>
                    <td style="padding-bottom:10px;">Kreditur</td>
                    <td>
                     <select name="kreditur_code" class="chosen m-wrap" id="kreditur_code">
                        <option value="" selected="selected">-- Pilih --</option>
                        <option value="9">Semua</option>
                        <?php foreach($kreditur as $kredit){ ?>
                        <option value="<?php echo $kredit['code_value']; ?>"><?php echo $kredit['display_text']; ?></option>
                        <?php } ?>
                     </select>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding-bottom:10px;" width="100">No. Batch</td>
                    <td>
                      <select name="batch_no" class="chosen m-wrap" id="batch_no">
                        <option value="" selected="selected">-- Pilih --</option>
                        <?php foreach($batch as $bt){ ?>
                           <option value="<?php echo $bt['batch_no'] ?>"><?php echo $bt['batch_no'] ?></option>
                        <?php } ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding-bottom:10px;">Status</td>
                    <td>
                     <select name="status_pyd_kreditur" class="chosen m-wrap" id="status_pyd_kreditur">
                        <option value="" selected="selected">-- Pilih --</option>
                        <option value="9">Semua</option>
                        <option value="0">Baru Registrasi</option>
                        <option value="1">Aktif</option>
                        <option value="2">Tolak</option>
                        <option value="3">Pengajuan</option>
                     </select>
                    </td>
                  </tr>
                   <tr>
                      <td></td>
                      <td>
                         <button class="red btn" id="previewpdf">PDF</button>
                         <button class="green btn" id="previewxls">Excel</button>
                         <button class="purple btn" id="previewcsv">CSV</button>
                      </td>
                   </tr>
                </table>
             </form>
            <p><hr></p>
          <!-- END FILTER-->
          <div id="showin">
          <table id="list485"></table>
          <div id="plist485"></div>
          </div>
      </div>
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
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/jquery.json-2.2.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/index.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>       
<script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script> 
<!-- END PAGE LEVEL SCRIPTS -->  

<script type="text/javascript">
$(document).ready(function(){
   App.init(); // initlayout and core plugins

   $('#previewxls').click(function(){
      var kreditur_code = $('#kreditur_code').val();
      var batch_no = $('#batch_no').val();
      var status_pyd_kreditur = $('#status_pyd_kreditur').val();
      var site = '<?php echo site_url('laporan_to_excel/export_list_api_debitur'); ?>';
      var conf = true;
      
      if(kreditur_code == ''){
         alert('Kreditur belum dipilih');
         var conf = false;
      }

      if(batch_no == ''){
         alert('No. Batch belum dipilih');
         var conf = false;
      }

      if(status_pyd_kreditur == ''){
         alert('Status belum dipilih');
         var conf = false;
      }

      if(conf == true){
         window.open(site+'/'+kreditur_code+'/'+batch_no+'/'+status_pyd_kreditur);
      }
   });

   $('#previewcsv').click(function(){
      var kreditur_code = $('#kreditur_code').val();
      var batch_no = $('#batch_no').val();
      var status_pyd_kreditur = $('#status_pyd_kreditur').val();
      var site = '<?php echo site_url('laporan_to_csv/export_list_api_debitur'); ?>';
      var conf = true;
      
      if(kreditur_code == ''){
         alert('Kreditur belum dipilih');
         var conf = false;
      }

      if(batch_no == ''){
         alert('No. Batch belum dipilih');
         var conf = false;
      }

      if(status_pyd_kreditur == ''){
         alert('Status belum dipilih');
         var conf = false;
      }

      if(conf == true){
         window.open(site+'/'+kreditur_code+'/'+batch_no+'/'+status_pyd_kreditur);
      }
   });

   $('#previewpdf').click(function(){
      var kreditur_code = $('#kreditur_code').val();
      var batch_no = $('#batch_no').val();
      var status_pyd_kreditur = $('#status_pyd_kreditur').val();
      var site = '<?php echo site_url('laporan_to_pdf/export_list_api_debitur'); ?>';
      var conf = true;

      if(kreditur_code == ''){
         alert('Kreditur belum dipilih');
         var conf = false;
      }

      if(batch_no == ''){
         alert('No. Batch belum dipilih');
         var conf = false;
      }

      if(status_pyd_kreditur == ''){
         alert('Status belum dipilih');
         var conf = false;
      }

      if(conf == true){
         window.open(site+'/'+kreditur_code+'/'+batch_no+'/'+status_pyd_kreditur);
      }
   });  
});
</script>
<!-- END JAVASCRIPTS -->


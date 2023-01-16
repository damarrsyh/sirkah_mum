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
        LAPORAN <small></small>
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

<!-- DIALOG FA -->
<div id="dialog_fa" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Kas Petugas</h3>
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
      <div class="caption"><i class="icon-globe"></i>List Pengajuan Akad</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body">
      <div class="clearfix">
         <!-- BEGIN FILTER FORM -->
         <form action="javascript:;" id="export_excel" method="post">
            <table id="filter-form" class="col-md-6">
                   <tr>
                    <td style="padding-bottom:10px;" width="100">Tgl File Upload</td>
                <td style="padding-left: 20px"> 

                      <select name="debitur_upload_no" class="chosen m-wrap" id="debitur_upload_no">
                        <option value="" selected="selected">Pilih</option>

                        <?php foreach($get_chn_debitur_upload as $values){?>
                        <option value="<?php echo $values->debitur_upload_no;?>"><?php echo $values->debitur_upload_no;?></option>
                        <?php }?>

                      </select>
                    </td>
                  </tr>
               <tr>
                  <td>&nbsp;</td>
                  <td style="padding-left: 20px">
                     <button class="green btn" id="previewxls">Create Akad</button>
                     <!--<button class="green btn" id="previewcsv">CSV</button>-->
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

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>   
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>        
<!-- END PAGE LEVEL SCRIPTS -->

<script>
   jQuery(document).ready(function() {
      App.init(); // initlayout and core plugins
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });
   });
</script>


<script type="text/javascript">

  $(document).ready(function (e) {
    $('#userfile').change(function(){  
           $('#export_excel').submit();  
      });  
  $("#export_excel").on('submit',(function(e) {
    e.preventDefault();
    $.ajax({
          url: site_url+"laporan/imp_chn_akad_excel",
      type: "POST",
      data:  new FormData(this),
      contentType: false,
          cache: false,
      processData:false,
      success: function(data)
        {
        }          
     });
  }));
});

</script>

<script type="text/javascript">
$(function(){

      $('#previewxls').click(function(){ 
      var debitur_upload_no = $('#debitur_upload_no').val();
      var site = '<?php echo site_url('laporan_to_excel/create_lap_chn_akad'); ?>'; 
      
      var conf = true;
      
      if(conf == true){
        window.open(site+'/'+debitur_upload_no); 
        
      }
	  });


      $('#previewcsv').click(function(){
      /*var branch_code = $('#branch_code').val();
      var kreditur = $('#kreditur').val();
      var tanggal = $('#tanggal').val();
      var tanggal = datepicker_replace(tanggal);
      var tanggal2 = $('#tanggal2').val();
      var tanggal2 = datepicker_replace(tanggal2);*/
      var site = '<?php echo site_url('laporan_to_csv/export_lap_chn_akad'); ?>';
      var conf = true;
      
      /*if(tanggal == '' && tanggal2 == ''){
        alert('Tanggal belum diisi');
        var conf = false;
      } */

      if(conf == true){
        window.open(site);
      }
	  });


	  opsi();

   
});

</script>
<!-- END JAVASCRIPTS -->

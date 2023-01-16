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
      CIF Kelompok
    </h3>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN ADD USER -->
<div id="add">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Mutasi Anggota Pindah</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM--> 
         <form action="#" id="form_add" class="form-horizontal">  <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Anggota Berhasil Dipindahkan !
            </div>
            <br>

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
<div id="dialog_kantor_cabang2" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
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

<!-- DIALOG UNIT -->
<div id="dialog_unit" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Unit Cabang</h3>
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
<div id="dialog_unit2" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Unit Cabang</h3>
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

        <div class="control-group">
           <label class="control-label">Kantor Cabang</label>
           <div class="controls">
              <input type="text" name="branch_name" id="branch_name" data-required="1" class="medium m-wrap" value="<?php echo $this->session->userdata('branch_name'); ?>" readonly style="background:#EEE"/>
              <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code') ?>">
              <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id') ?>">
              <?php if($this->session->userdata('flag_all_branch')=='1'){ ?><a id="browse_branch" class="btn blue" data-toggle="modal" href="#dialog_kantor_cabang">...</a><?php } ?>
           </div>
        </div>
        <hr>
            <div class="control-group">
               <label class="control-label">Unit<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="unit" id="unit" data-required="1" class="medium m-wrap" readonly=""  style="background-color:#eee;"/>  
                  <a id="browse_unit" class="btn blue" data-toggle="modal" href="#dialog_unit">...</a>
               </div>
            </div>  
            <div class="control-group">
               <label class="control-label">Rembug Asal<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="rembug" id="rembug" data-required="1" class="medium m-wrap" readonly=""  style="background-color:#eee;"/>  
                  <a id="browse_cm" class="btn blue" data-toggle="modal" href="#dialog_cm">...</a>
               </div>
            </div>  
            
            <div class="control-group">
               <label class="control-label">ID Anggota<span class="required">*</span></label>
               <div class="controls">
                <select name="id_anggota" id="id_anggota" class="medium m-wrap chosen" data-required="1" >
                </select>
               </div>
            </div>
            <h3>Dipindahkan ke</h3>
            <!-- DIALOG CM -->
            <div id="dialog_cm2" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h3>Cari Rembug Tujuan Pindah</h3>
               </div>
               <div class="modal-body">
                  <div class="row-fluid">
                     <div class="span12">
                        <h4>Masukan Kata Kunci</h4>
                        <p><input type="text" name="keyword2" id="keyword2" placeholder="Search..." class="span12 m-wrap"></p>
                        <p><select name="result2" id="result2" size="7" class="span12 m-wrap"></select></p>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
                  <button type="button" id="select2" class="btn blue">Select</button>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Kantor Cabang</label>
               <div class="controls">
                  <input type="text" name="branch_name2" id="branch_name2" data-required="1" class="medium m-wrap" value="<?php echo $this->session->userdata('branch_name'); ?>" readonly style="background:#EEE"/>
                  <input type="hidden" name="branch_code2" id="branch_code2" value="<?php echo $this->session->userdata('branch_code') ?>">
                  <input type="hidden" name="branch_id2" id="branch_id2" value="<?php echo $this->session->userdata('branch_id') ?>">
                  <?php if($this->session->userdata('flag_all_branch')=='1'){ ?><a id="browse_branch2" class="btn blue" data-toggle="modal" href="#dialog_kantor_cabang2">...</a><?php } ?>
               </div>
            </div>
            <hr>
            <div class="control-group">
               <label class="control-label">Unit<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="unit2" id="unit2" data-required="1" class="medium m-wrap" readonly=""  style="background-color:#eee;"/>  
                  <a id="browse_unit2" class="btn blue" data-toggle="modal" href="#dialog_unit2">...</a>
               </div>
            </div>  
            <div class="control-group">
               <label class="control-label">Rembug Tujuan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="rembug2" id="rembug2" data-required="1" class="medium m-wrap" readonly=""  style="background-color:#eee;"/>  
                <a id="browse_cm2" class="btn blue" data-toggle="modal" href="#dialog_cm2">...</a>
               </div>
            </div>  
            <div class="control-group">
               <label class="control-label">Alasan<span class="required">*</span></label>
               <div class="controls">
                <select class="m-wrap medium" name="alasan">
                  <option value="">PILIH</option>
                  <?php foreach ($alasan as $key):?>
                    <option value="<?php echo $key['code_value'];?>"><?php echo $key['display_text'];?></option>
                  <?php endforeach;?>
                </select>
               </div> 
            </div> 
            <div class="control-group">
               <label class="control-label">Keterangan<span class="required">*</span></label>
               <div class="controls">
                  <textarea id="keterangan" name="keterangan" class="m-wrap medium"></textarea>
               </div> 
            </div>   
            <div class="control-group">
            <label class="control-label">Tanggal Mutasi<span class="required">*</span></label>
              <div class="controls">
                <input type="text" class="small m-wrap date-picker date-mask" id="tanggal_mutasi" name="tanggal_mutasi" placeholder="dd/mm/yyyy">
              </div>
            </div>        
            <div class="form-actions">
               <input type="hidden" id="branch_code_unit" name="branch_code_unit">
               <input type="hidden" id="branch_code_unit2" name="branch_code_unit2">
               <input type="hidden" id="cm_code" name="cm_code">
               <input type="hidden" id="cm_code2_unit" name="cm_code2_unit">
               <input type="hidden" id="cm_code2" name="cm_code2">
               <input type="hidden" id="cif_no" name="cif_no">
               <button type="submit" class="btn green">Save</button>
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
      $(".date-mask").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){

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
            html = '<option value="00000" branch_name="Semua Branch" branch_id="00000">00000 - Semua Branch</option>';
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
            html = '<option value="00000" branch_name="Semua Branch" branch_id="00000">00000 - Semua Branch</option>';
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
});

$("#result option","#dialog_kantor_cabang").live('dblclick',function(){
  $("#select","#dialog_kantor_cabang").trigger('click');
});

$("#keyword","#dialog_kantor_cabang2").keypress(function(e){
   keyword = $(this).val();
   if(e.which==13){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         data: {keyword:keyword},
         success: function(response){
            html = '<option value="00000" branch_name="Semua Branch" branch_id="00000">00000 - Semua Branch</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            $("#result","#dialog_kantor_cabang2").html(html);
         }
      })
   }
});

$("a#browse_branch2").click(function(){
   keyword = $("#keyword","#dialog_kantor_cabang2").val();
   $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         data: {keyword:keyword},
         success: function(response){
            html = '<option value="00000" branch_name="Semua Branch" branch_id="00000">00000 - Semua Branch</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            $("#result","#dialog_kantor_cabang2").html(html);
         }
      })
});

$("#select","#dialog_kantor_cabang2").click(function(){
  $(".close","#dialog_kantor_cabang2").trigger('click');
  branch_code = $("#result","#dialog_kantor_cabang2").val();
  branch_name = $("#result option:selected","#dialog_kantor_cabang2").attr('branch_name');
  branch_id = $("#result option:selected","#dialog_kantor_cabang2").attr('branch_id');
  $("#branch_code2").val(branch_code);
  $("#branch_name2").val(branch_name);
  $("#branch_id2").val(branch_id);
});

$("#result option","#dialog_kantor_cabang2").live('dblclick',function(){
  $("#select","#dialog_kantor_cabang2").trigger('click');
});

      // BEGIN FORM ADD USER VALIDATION
      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);
      
      $("#btn_add").click(function(){
        $("#wrapper-table").hide();
        $("#add").show();
        form1.trigger('reset');
      });

      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          errorPlacement: function(error, element) {
            element.closest('.controls').append(error);
          },
          // ignore: "",
          
          rules: {
              rembug: {
                  required: true
              },
              id_anggota: {
                  required: true
              },
              rembug2: {
                  required: true
              },
              alasan: {
                  required: true
              },
              tanggal_mutasi: {
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

            $.ajax({
              type: "POST",
              url: site_url+"kelompok/proses_anggota_pindah",
              dataType: "json",
              data: form1.serialize(),
              success: function(response){
                if(response.success==true){
                  success1.show();
                  error1.hide();
                  $("#cancel").trigger('click');
                  form1.trigger('reset');
                  form1.children('div').removeClass('success');
                }else{
                  success1.hide();
                  error1.show();
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
      });



      $("#button-dialog").click(function(){
        $("#dialog").dialog('open');
      });

      // fungsi untuk 
      $(function(){

        $("#browse_cm").click(function(){
          if($("#keyword","#dialog_cm").val()==""){
            branch_code=$("#branch_code_unit").val();
            $.ajax({
               type: "POST",
               url: site_url+"kelompok/get_rembug_by_keyword",
               dataType: "json",
               data: {keyword:'',branch_code:branch_code},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
                  }
                  $("#result","#dialog_cm").html(html);
               }
            })
          }
        })

        $("#keyword","#dialog_cm").keypress(function(e){
          keyword = $(this).val();
          if(e.which==13){
            branch_code=$("#branch_code_unit").val();
            $.ajax({
               type: "POST",
               url: site_url+"kelompok/get_rembug_by_keyword",
               dataType: "json",
               async: false,
               data: {keyword:keyword,branch_code:branch_code},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
                  }
                  $("#result","#dialog_cm").html(html);
               }
            });
            return false;
          }
        });
        
        $("#button-dialog").click(function(){
          $("#dialog").dialog('open');
        });

        //mencari anggota rembug sesuai rembug yang dipilih
        $("#select","#dialog_cm").click(function(){
            $("#close","#dialog_cm").trigger('click');
            nama_rembug = $("#result option:selected","#dialog_cm").attr('cm_name');
            $("#rembug").val(nama_rembug);  
            cm_code = $("#result","#dialog_cm").val();
            $("#cm_code").val(cm_code);  
           $.ajax({
             type: "POST",
             url: site_url+"kelompok/get_anggota_rembug_by_cm_code",
             dataType: "json",
             data: {cm_code:cm_code},
             success: function(response){
                html = '<option value="">PILIH</option>';
                for ( i = 0 ; i < response.length ; i++ )
                {
                   html += '<option value="'+response[i].cif_no+'" cif_no="'+response[i].cif_no+'" cif_id="'+response[i].cif_id+'">'+response[i].nama+'</option>';
                }
                $("#id_anggota").html(html);
                $("#id_anggota").trigger('liszt:updated');
                  //meload data cif berdasarkan cif_no yang dipilih
                  // $.ajax({
                  //   type: "POST",
                  //   url: site_url+"kelompok/get_cif_by_cif_no",
                  //   async: false,
                  //   dataType: "json",
                  //   data: {cif_no:$("#id_anggota").val()},
                  //   success: function(response)
                  //   {                      
                  //       $("#nama").val(response.nama);  
                  //       $("#cif_no").val(response.cif_no);                     
                  //   }
                  // });

             }
           });        
        }); 

        $("#result option","#dialog_cm").live('dblclick',function(){
          $("#select","#dialog_cm").trigger('click');
        });

        $("#browse_unit").click(function(){
          if($("#keyword","#dialog_unit").val()==""){
            branch_code=$("#branch_code").val();
            $.ajax({
               type: "POST",
               url: site_url+"kelompok/get_unit_by_keyword",
               dataType: "json",
               data: {keyword:'',branch_code:branch_code},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
                  }
                  $("#result","#dialog_unit").html(html);
               }
            })
          }
        })

        $("#keyword","#dialog_unit").keypress(function(e){
          keyword = $(this).val();
          if(e.which==13){
            branch_code=$("#branch_code").val();

            $.ajax({
               type: "POST",
               url: site_url+"kelompok/get_unit_by_keyword",
               dataType: "json",
               async: false,
               data: {keyword:keyword,branch_code:branch_code},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
                  }
                  $("#result","#dialog_unit").html(html);
               }
            });
            return false;
          }
        });

        //mencari anggota rembug sesuai rembug yang dipilih
        $("#select","#dialog_unit").click(function(){
            $("#close","#dialog_unit").trigger('click');
            branch_name = $("#result option:selected","#dialog_unit").attr('branch_name');
            $("#unit").val(branch_name);  
            branch_code = $("#result","#dialog_unit").val();
            $("#branch_code_unit").val(branch_code);  
        }); 

        $("#result option","#dialog_unit").live('dblclick',function(){
          $("#select","#dialog_unit").trigger('click');
        });

        $("#browse_unit2").click(function(){
          if($("#keyword","#dialog_unit2").val()==""){
            branch_code=$("#branch_code2").val();
            $.ajax({
               type: "POST",
               url: site_url+"kelompok/get_unit_by_keyword",
               dataType: "json",
               data: {keyword:'',branch_code:branch_code},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
                  }
                  $("#result","#dialog_unit2").html(html);
               }
            })
          }
        })

        $("#keyword","#dialog_unit2").keypress(function(e){
          keyword = $(this).val();
          if(e.which==13){
            branch_code=$("#branch_code2").val();

            $.ajax({
               type: "POST",
               url: site_url+"kelompok/get_unit_by_keyword",
               dataType: "json",
               async: false,
               data: {keyword:keyword,branch_code:branch_code},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
                  }
                  $("#result","#dialog_unit2").html(html);
               }
            });
            return false;
          }
        });

        //mencari anggota rembug sesuai rembug yang dipilih
        $("#select","#dialog_unit2").click(function(){
            $("#close","#dialog_unit2").trigger('click');
            branch_name = $("#result option:selected","#dialog_unit2").attr('branch_name');
            $("#unit2").val(branch_name);  
            branch_code = $("#result","#dialog_unit2").val();
            $("#branch_code_unit2").val(branch_code);  
        }); 

        $("#result option","#dialog_unit2").live('dblclick',function(){
          $("#select","#dialog_unit2").trigger('click');
        });

        //meload data cif berdasarkan cif_no yang dipilih
        // $("select[name='id_anggota']").change(function(){
        //    var cm_code = $("#rembug").val();
        //    $.ajax({
        //       type: "POST",
        //       url: site_url+"kelompok/get_cif_by_cif_no",
        //       async: false,
        //       dataType: "json",
        //       data: {cif_no:$("#id_anggota").val()},
        //       success: function(response)
        //       {                      
        //           $("#nama").val(response.nama);   
        //           $("#cif_no").val(response.cif_no);                     
        //       }
        //     });      
        // });


        //REMBUG TUJUAN PINDAH
        $("#browse_cm2").click(function(){
          if($("#keyword2","#dialog_cm2").val()==""){
            branch_code=$("#branch_code_unit2").val();

            $.ajax({
               type: "POST",
               url: site_url+"kelompok/get_rembug_by_keyword",
               dataType: "json",
               data: {keyword:'',branch_code:branch_code},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
                  }
                  $("#result2","#dialog_cm2").html(html);
               }
            })
          }
        })

        $("#keyword2","#dialog_cm2").keypress(function(e){
          keyword = $(this).val();
          if(e.which==13){
            branch_code=$("#branch_code_unit2").val();

            $.ajax({
               type: "POST",
               url: site_url+"kelompok/get_rembug_by_keyword",
               dataType: "json",
               async: false,
               data: {keyword:keyword,branch_code:branch_code},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
                  }
                  $("#result2","#dialog_cm2").html(html);
               }
            });
            return false;
          }
        });
        
        $("#button-dialog2").click(function(){
          $("#dialog2").dialog('open');
        });

        //
        $("#select2","#dialog_cm2").click(function(){
            $("#close","#dialog_cm2").trigger('click');
            nama_rembug = $("#result2 option:selected","#dialog_cm2").attr('cm_name');
            $("#rembug2").val(nama_rembug);   
            cm_code = $("#result2").val();
            $("#cm_code2").val(cm_code);    
        }); 
        $("#result2 option","#dialog_cm2").live('dblclick',function(){
          $("#select2","#dialog_cm2").trigger('click');
        });

      });
      
      


      jQuery('#desa_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#desa_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->


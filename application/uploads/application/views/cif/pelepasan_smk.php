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
      SMK Setup <small>Pelepasan Sertifikat Modal Usaha</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">CIF</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Pelepasan SMK</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Pelepasan Sertifikat MOdal Koperasi</div>
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
         <div class="btn-group">
            <button id="btn_delete" class="btn red">
              Delete <i class="icon-remove"></i>
            </button>
         </div>
         <div class="btn-group pull-right">
            <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right">
               <li><a href="#">Print</a></li>
               <li><a href="#">Save as PDF</a></li>
               <li><a href="#">Export to Excel</a></li>
            </ul>
         </div>
      </div>
      <table class="table table-striped table-bordered table-hover" id="pelepasan_smk_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#pelepasan_smk_table .checkboxes" /></th>
               <th width="23%">No. Sertifikat</th>
               <th width="23%">Nama</th>
               <th width="23%">Nominal</th>
               <th width="23%">Tanggal Setor</th>
               <th>Edit</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->




<!-- BEGIN ADD PROGRAN -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Pelepasan Sertifikat Modal Usaha</div>
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
               Pelepasan Sertifikat Modal Usaha Berhasil !
            </div>
            <br>
            <div class="control-group">
                       <label class="control-label">No Sertifikat<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="sertifikat_no" id="sertifikat_no" readonly="" data-required="1" class="medium m-wrap"/><input type="hidden" id="branch_code" name="branch_code">
                          
                          <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500">
                             <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Cari CIF NO</h3>
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
               <label class="control-label">Nama Pemilik SMK<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nama" id="nama" data-required="1" class="medium m-wrap" readonly=""/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nominal<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nominal" id="nominal" data-required="1" readonly="" class="medium m-wrap" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"/>
               </div>
            </div>            
            <div class="control-group">
               <label class="control-label">Status Keanggotaan<span class="required">*</span></label>
               <div class="controls">
                  <select name="status_anggota" id="status_anggota" class="medium m-wrap" readonly="" data-required="1">
                     <option value="">PILIH</option>
                     <option value="0">Anggota</option>
                     <option value="1">Non Anggota</option>
                  </select>
               </div>
            </div>
            <div class="control-group" id="r_cif_no">
               <label class="control-label">CIF No<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="cif_no" id="cif_no" data-required="1" readonly="" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Pelepasan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="date_close" id="date_close" data-required="1" readonly="" class="medium m-wrap"/>
               </div>
            </div>
            <div class="form-actions">
               <button type="submit" class="btn green">Save</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END ADD USER -->




<!-- BEGIN EDIT USER -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Branch</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="smk_id" name="smk_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Edit SMK Successful!
            </div>
          </br>
          <div class="control-group">
               <label class="control-label">No Sertifikat<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="sertifikat_no2" id="sertifikat_no2" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Pemilik SMK<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nama2" id="nama2" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nominal<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nominal2" id="nominal2" data-required="1" class="medium m-wrap" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"/>
               </div>
            </div>            
            <div class="control-group">
               <label class="control-label">Status Keanggotaan<span class="required">*</span></label>
               <div class="controls">
                  <select name="status_anggota2" id="status_anggota2" class="medium m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <option value="0">Anggota</option>
                     <option value="1">Non Anggota</option>
                  </select>
               </div>
            </div>
            <div class="control-group" id="r_cif_no2">
                       <label class="control-label">CIF No<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="cif_no2" id="cif_no2" data-required="1" class="medium m-wrap"/><input type="hidden" id="branch_code" name="branch_code">
                          
                          <div id="dialog_rembug2" class="modal hide fade" tabindex="-1" data-width="500">
                             <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Cari CIF NO</h3>
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
                                <button type="button" id="close2" data-dismiss="modal" class="btn">Close</button>
                                <button type="button" id="select2" class="btn blue">Select</button>
                             </div>
                          </div>

                        <a id="browse_rembug2" class="btn blue" data-toggle="modal" href="#dialog_rembug2">...</a>
                       </div>
                    </div>
            <div class="control-group">
               <label class="control-label">Tanggal Setor<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="date_issued2" id="date_issued2" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="form-actions">
               <button type="submit" class="btn purple">Save</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END EDIT USER -->


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
     
      $("#date_close").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("#date_close2").inputmask("d/m/y", {autoUnmask: true});  //direct mask
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
        var tbl_id = 'pelepasan_smk_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#pelepasan_smk_table .group-checkable').live('change',function () {
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

      $("#pelepasan_smk_table .checkboxes").livequery(function(){
        $(this).uniform();
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
          // ignore: "",
          rules: {
              sertifikat_no: {
                  required: true
              },
              nama: {
                  required: true
              },
              nominal: {
                  required: true
              },
              status_anggota: {
                  required: true
              },
              date_issued: {
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
              label
                  .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
          },

          submitHandler: function (form) {

            $.ajax({
              type: "POST",
              url: site_url+"cif/add_pelepasan_smk",
              dataType: "json",
              data: form1.serialize(),
              success: function(response){
                if(response.success==true){
                  success1.show();
                  error1.hide();
                  form1.trigger('reset');
                  form1.children('div').removeClass('success');
                }else{
                  success1.hide();
                  error1.show();
                }
              },
              error:function(){
                  success1.hide();
                  error1.show();
              }
            });

          }
      });

      // event untuk kembali ke tampilan data table (ADD FORM)
      $("#cancel","#form_add").click(function(){
        success1.hide();
        error1.hide();
        $("#add").hide();
        $("#wrapper-table").show();
        dTreload();
      });





       // event button Edit ketika di tekan
      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var smk_id = $(this).attr('smk_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {smk_id:smk_id},
          url: site_url+"cif/get_smk_by_smk_id",
          success: function(response)
          {
            $("#form_edit input[name='smk_id']").val(response.smk_id);
            $("#form_edit input[name='sertifikat_no2']").val(response.sertifikat_no);
            $("#form_edit input[name='nama2']").val(response.nama);
            $("#form_edit input[name='nominal2']").val(response.nominal);
            $("#form_edit input[name='cif_no2']").val(response.cif_no);
            $("#form_edit select[name='status_anggota2']").val(response.status_anggota);             
  
            var status_anggota = $("#form_edit select[name='status_anggota2']").val();  
            if(status_anggota=='0')
            {
              $("#r_cif_no2").show();
            }
            else
            {
              $("#r_cif_no2").hide();
            }

            var tanggal_mulai = response.date_issued;
            var tgl = tanggal_mulai.substring(8,10);
            var bln = tanggal_mulai.substring(5,7);
            var thn = tanggal_mulai.substring(0,4);
            var tgl_mulai = tgl+""+bln+""+thn;  
            $("#form_edit input[name='date_issued2']").val(tgl_mulai);

                    
          }
        })

      });



      // BEGIN FORM EDIT VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              program_code2: {
                  required: true
              },
              program_name2: {
                  required: true
              },
              program_owner2: {
                  required: true
              },
              sifat_dana2: {
                  required: true
              },
              target_customer2: {
                  required: true
              },
              target_pembiayaan2: {
                  required: true
              },
              tanggal_mulai2: {
                  required: true
              },
              tanggal_berakhir2: {
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
              label
                  .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
          },

          submitHandler: function (form) {


            // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
            $.ajax({
              type: "POST",
              url: site_url+"cif/edit_pelepasan_smk",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  form2.children('div').removeClass('success');
                  dTreload();
                }else{
                  success2.hide();
                  error2.show();
                }
              },
              error:function(){
                  success2.hide();
                  error2.show();
              }
            });

          }
      });
      //  END FORM EDIT VALIDATION

      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel","#form_edit").click(function(){
        $("#edit").hide();
        $("#wrapper-table").show();
        dTreload();
        success2.hide();
        error2.hide();
      });





      // fungsi untuk delete records
      $("#btn_delete").click(function(){

        var smk_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          smk_id[$i] = $(this).val();

          $i++;

        });

        if(smk_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"cif/delete_pelepasan_smk",
              dataType: "json",
              data: {smk_id:smk_id},
              success: function(response){
                if(response.success==true){
                  alert("Deleted!");
                  dTreload();
                }else{
                  alert("Delete Failed!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }
        }

      });


      // begin first table
      $('#pelepasan_smk_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"cif/datatable_pelepasan_smk_setup",
          "aoColumns": [
            {"bSearchable": false},
            null,
            null,
            null,
            null,
            { "bSortable": false, "bSearchable": false }
          ],
          "aLengthMenu": [
              [5, 15, 20, -1],
              [5, 15, 20, "All"] // change per page values here
          ],
          // set the initial value
          "iDisplayLength": 5,
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

//fungsi untuk menampilkan input CIF NO JIKA STATUS ANGGOTA = 1
      $(function(){
  
          $("#r_cif_no").hide();
          
          $("#status_anggota").change(function(){
            var status_anggota = $("#status_anggota").val();  
            if(status_anggota=='0')
            {
              $("#r_cif_no").show();
            }
            else
            {
              $("#r_cif_no").hide();
            }
            
          });     
          
      });

      // fungsi untuk mencari CIF_NO
      $(function(){

       $("#select").click(function(){
         result = $("#result").val();
              var sertifikat_no = $("#result").val();
              $("#close","#dialog_rembug").trigger('click');
              //alert(customer_no);
              $("#sertifikat_no").val(sertifikat_no);
                    //fungsi untuk mendapatkan value untuk field-field yang diperlukan
                    var sertifikat_no = sertifikat_no;
                    $.ajax({
                      type: "POST",
                      dataType: "json",
                      data: {sertifikat_no:sertifikat_no},
                      url: site_url+"cif/ajax_get_value_from_sertifikat_no",
                      success: function(response)
                      {
                        $("#sertifikat_no").val(response.sertifikat_no);
                        $("#nama").val(response.nama);
                        $("#nominal").val(response.nominal);
                        $("#status_anggota").val(response.status_anggota);
                        var status_anggota = $("#status_anggota").val();
                          if(status_anggota=='0')
                          {
                            $("#r_cif_no").show();
                          }
                          else
                          {
                            $("#r_cif_no").hide();
                          }

                        $("#cif_no").val(response.cif_no);
                        var date = '<?php echo $tanggal ?>';
                        $("#date_close").val(date);
                      }                 
                    });
            
        });
        $("#button-dialog").click(function(){
          $("#dialog").dialog('open');
        });

        $("#keyword").keypress(function(e){

          if(e.which==13){

            $.ajax({
              type: "POST",
              url: site_url+"cif/search_sertifikat_no",
              data: {keyword:$(this).val()},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                  option += '<option value="'+response[i].sertifikat_no+'">'+response[i].sertifikat_no+' - '+response[i].nama+'</option>';
                }
                // console.log(option);
                $("#result").html(option);
              }
            })
          }
        });
        });

//fungsi untuk menampilkan input CIF NO JIKA STATUS ANGGOTA = 1 pada form edit
      $(function(){
          
          $("#status_anggota2").change(function(){
            var status_anggota = $("#status_anggota2").val();  
            if(status_anggota=='0')
            {
              $("#r_cif_no2").show();
            }
            else
            {
              $("#r_cif_no2").hide();
            }
            
          });     
          
      });

      // fungsi untuk mencari CIF_NO pada form EDIT
      $(function(){

       $("#select2").click(function(){
         result = $("#result2").val();
              var customer_no = $("#result2").val();
              $("#close2","#dialog_rembug2").trigger('click');
              //alert(customer_no);
              $("#cif_no2").val(customer_no);
                    //fungsi untuk mendapatkan value untuk field-field yang diperlukan
                    var cif_no = customer_no;
                    $.ajax({
                      type: "POST",
                      dataType: "json",
                      data: {cif_no:cif_no},
                      url: site_url+"transaction/ajax_get_value_from_cif_no",
                      success: function(response)
                      {
                        $("#cif_no2").val(response.cif_no);
                      }                 
                    });
            
        });
        $("#button-dialog2").click(function(){
          $("#dialog2").dialog('open');
        });

        $("#keyword2").keypress(function(e){

          if(e.which==13){

            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_no",
              data: {keyword:$(this).val()},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                  option += '<option value="'+response[i].cif_no+'">'+response[i].cif_no+' - '+response[i].nama+'</option>';
                }
                // console.log(option);
                $("#result2").html(option);
              }
            })
          }
        });
        });


      jQuery('#pelepasan_smk_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#pelepasan_smk_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->


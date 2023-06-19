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
			Target Cabang <small>Form Input Target Cabang</small>
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('dashboard'); ?>">Home</a> 
				<i class="icon-angle-right"></i>
			</li>
         <li><a href="#">Group</a><i class="icon-angle-right"></i></li>  
			<li><a href="#">Target Cabang</a></li>	
		</ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->




<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Form Input Target Cabang </div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
         <div class="btn-group pull-right">
            <button id="btn_delete" class="btn red">
              Delete <i class="icon-remove"></i>
            </button>
         </div>
         <div class="btn-group pull-right">
            <button id="btn_add" class="btn green">
            Add New <i class="icon-plus"></i>
            </button>
         </div>

         <label>
            Kantor Cabang &nbsp; : &nbsp;
            <input type="text" name="branch_name" id="branch_name" class="medium m-wrap" disabled>
            <input type="hidden" name="branch_code" id="branch_code">
            <a id="browse" class="btn blue" data-toggle="modal" href="#dialog_kantor_cabang">...</a>
            <!-- <input type="submit" id="filter" value="Filter" class="btn blue"> -->
         </label>
      </div>

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

      <table class="table table-striped table-bordered table-hover" id="rembug_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#rembug_table .checkboxes" /></th>
               <th width="6%">Tahun</th>
               <th width="15%">Item target</th>
               <th >jan </th>
               <th >Feb</th>
               <th >Mar</th>
               <th >Apr</th>
               <th >Mei</th>
               <th >Jul</th>
               <th >Agt</th>
               <th >Jun</th>
               <th >Sep</th>
               <th >Okt</th>
               <th >Nov</th>
               <th >Des</th>

               <th width="5%">Edit</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->




<!-- BEGIN ADD REMBUG -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Form Input Target Cabang</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="<?php echo site_url('cif/add_target_cabang'); ?>" method="post" id="form_add" class="form-horizontal">
            <input type="hidden" name="add_branch_code" id="add_branch_code">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Data Baru Berhasil Ditambahkan !
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">Cabang<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="id_cabang" id="id_cabang" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee"  />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tahun<span class="required">*</span></label>
               <div class="controls">
                  <input type="text"  name="tahun" id="tahun"  class="medium m-wrap"/>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Item Target<span class="required">*</span></label>
               <div class="controls">
                 <select name="target_item" type="text" id="target_item" class="medium m-wrap"></select>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Jan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t1" id="t1" class="medium m-wrap"/>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Feb<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t2" id="t2" class="medium m-wrap"/>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Mar<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t3" id="t3" class="medium m-wrap"/>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Apr<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t4" id="t4" class="medium m-wrap"/>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Mei<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t5" id="t5" class="medium m-wrap"/>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Jun<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t6" id="t6" class="medium m-wrap"/>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Jul<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t7" id="t7" class="medium m-wrap"/>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Agt<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t8" id="t8" class="medium m-wrap"/>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Sep<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t9" id="t9" class="medium m-wrap"/>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Okt<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t10" id="t10" class="medium m-wrap"/>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Nov<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t11" id="t11" class="medium m-wrap"/>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Des<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t12" id="t12" class="medium m-wrap"/>
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
<!-- END ADD REMBUG -->




<!-- BEGIN EDIT USER -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Target Cabang</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
            <input type="hidden" name="edit_branch_code" id="edit_branch_code">
            <input type="hidden" id="target_id" name="target_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Data target cabang berhasil diedit !
            </div>

            <div class="control-group">
               <label class="control-label">branch_code<span class="required" >*</span></label>
               <div class="controls">
                  <input type="text" name="branch_code" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee" />
               </div>
            </div> 


            <div class="control-group">
               <label class="control-label">Tahun<span class="required" >*</span></label>
               <div class="controls">
                  <input type="text" name="tahun" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee" />
               </div>
            </div> 

            <div class="control-group">
               <label class="control-label">Target Item <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="target_item" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee" />
               </div>
            </div> 
            
            <div class="control-group">
               <label class="control-label">Jan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t1" data-required="1" class="medium m-wrap"/>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Feb<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t2" data-required="1" class="medium m-wrap"/>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Mar<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t3" data-required="1" class="medium m-wrap"/>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Apr<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t4" data-required="1" class="medium m-wrap"/>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Mei<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t5" data-required="1" class="medium m-wrap"/>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Jun<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t6" data-required="1" class="medium m-wrap"/>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Jul<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t7" data-required="1" class="medium m-wrap"/>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Agt<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t8" data-required="1" class="medium m-wrap"/>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Sep<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t9" data-required="1" class="medium m-wrap"/>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Okt<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t10" data-required="1" class="medium m-wrap"/>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Nov<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t11" data-required="1" class="medium m-wrap"/>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Des<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="t12" data-required="1" class="medium m-wrap"/>
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
<!-- END EDIT REMBUG -->






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
      Index.init();
      $("#mask_date").inputmask("d/m/y", {autoUnmask: true});  //direct mask        
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){
      // cari desa form edit

      $("#select3","#form_edit").click(function(){
         result = $("#result3").val();
         if(result != null)
         {
            $("#desa_code","#form_edit").val(result);
            $("#desa","#form_edit").val($("#result3 option:selected").attr('desa'));
            $("#close","#form_edit").trigger('click');
         }
         else
         {
            alert("Please select row first !");
         }
      });

      $("#result3 option").live('dblclick',function(){
           $("#select3").trigger('click');
        });

      $("select[name='kecamatan']","#form_edit").change(function(e){
         keyword = $("#keyword3").val();
         kecamatan = $(this).val()
          $.ajax({
             type: "POST",
             url: site_url+"cif/get_desa_by_keyword",
             dataType: "json",
             data: {keyword:keyword,kecamatan:kecamatan},
             success: function(response){
                html = '';
                for ( i = 0 ; i < response.length ; i++ )
                {
                   html += '<option value="'+response[i].desa_code+'" desa="'+response[i].desa+'">'+response[i].desa_code+' - '+response[i].desa+'</option>';
                }
                $("#result3","#form_edit").html(html);
             }
          })
      });

      $("#keyword3","#form_edit").keypress(function(e){
         keyword = $(this).val();
         kecamatan = $("select[name='kecamatan']","#form_edit").val()
         if(e.which==13){
            $.ajax({
               type: "POST",
               url: site_url+"cif/get_desa_by_keyword",
               dataType: "json",
               data: {keyword:keyword,kecamatan:kecamatan},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].desa_code+'" desa="'+response[i].desa+'">'+response[i].desa_code+' - '+response[i].desa+'</option>';
                  }
                  $("#result3","#form_edit").html(html);
               }
            })
         }
      });

      $("#browse2").click(function(){
         keyword = $("#keyword3","#dialog_desa2").val();
         kecamatan = $("select[name='kecamatan']","#form_edit").val()
         $.ajax({
               type: "POST",
               url: site_url+"cif/get_desa_by_keyword",
               dataType: "json",
               data: {keyword:keyword,kecamatan:kecamatan},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].desa_code+'" desa="'+response[i].desa+'">'+response[i].desa_code+' - '+response[i].desa+'</option>';
                  }
                  $("#result3","#form_edit").html(html);
               }
            })
      });

      // cari desa form add
      $("#select2","#form_add").click(function(){
         result = $("#result2").val();
         if(result != null)
         {
            $("#desa_code","#form_add").val(result);
            $("#desa","#form_add").val($("#result2 option:selected").attr('desa'));
            $("#close","#form_add").trigger('click');
         }
         else
         {
            alert("Please select row first !");
         }

      });

      $("#result2 option").live('dblclick',function(){
           $("#select2").trigger('click');
        });

      $("select[name='kecamatan']","#form_add").change(function(e){
         keyword = $("#keyword2").val();
         kecamatan = $(this).val()
          $.ajax({
             type: "POST",
             url: site_url+"cif/get_desa_by_keyword",
             dataType: "json",
             data: {keyword:keyword,kecamatan:kecamatan},
             success: function(response){
                html = '';
                for ( i = 0 ; i < response.length ; i++ )
                {
                   html += '<option value="'+response[i].desa_code+'" desa="'+response[i].desa+'">'+response[i].desa_code+' - '+response[i].desa+'</option>';
                }
                $("#result2","#form_add").html(html);
             }
          })
      });

      $("#keyword2","#form_add").keypress(function(e){
         keyword = $(this).val();
         kecamatan = $("select[name='kecamatan']","#form_add").val()
         if(e.which==13){
            $.ajax({
               type: "POST",
               url: site_url+"cif/get_desa_by_keyword",
               dataType: "json",
               data: {keyword:keyword,kecamatan:kecamatan},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].desa_code+'" desa="'+response[i].desa+'">'+response[i].desa_code+' - '+response[i].desa+'</option>';
                  }
                  $("#result2","#form_add").html(html);
               }
            })
         }
      });

      $("#browse2").click(function(){
         keyword = $("#keyword2","#dialog_desa").val();
         kecamatan = $("select[name='kecamatan']","#form_add").val()
         $.ajax({
               type: "POST",
               url: site_url+"cif/get_desa_by_keyword",
               dataType: "json",
               data: {keyword:keyword,kecamatan:kecamatan},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].desa_code+'" desa="'+response[i].desa+'">'+response[i].desa_code+' - '+response[i].desa+'</option>';
                  }
                  $("#result2","#form_add").html(html);
               }
            })
      });


      // cari kantor cabang
      $("#select").click(function(){
         result = $("#result").val();
         if(result != null)
         {
            $("#branch_code").val(result);
            $("#add_branch_code").val(result);
            $("#edit_branch_code").val(result);
            $("#branch_name").val($("#result option:selected").attr('branch_name'));
            $("#close","#dialog_kantor_cabang").trigger('click');

            $('#rembug_table').dataTable({
                "bDestroy":true,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": site_url+"cif/datatable_target_cabang",
                "fnServerParams": function ( aoData ) {
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
                  null,
                  null,
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
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });

            // $(".dataTables_filter").parent().hide();
         }
         else
         {
            alert("Please select row first !");
         }

      });

      $("#result option").live('dblclick',function(){
           $("#select").trigger('click');
      });

      $("#keyword","#dialog_kantor_cabang").keypress(function(e){
         keyword = $(this).val();
         if(e.which==13){
            $.ajax({
               type: "POST",
               url: site_url+"cif/get_branch_by_keyword",
               dataType: "json",
               data: {keyword:keyword},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
                  }
                  $("#result").html(html);
               }
            })
         }
      });

      $("#browse").click(function(){
         keyword = $("#keyword","#dialog_kantor_cabang").val();
         $.ajax({
               type: "POST",
               url: site_url+"cif/get_branch_by_keyword",
               dataType: "json",
               data: {keyword:keyword},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
                  }
                  $("#result").html(html);
               }
            })
      });

      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'rembug_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#rembug_table .group-checkable').live('change',function () {
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

      $("#rembug_table .checkboxes").livequery(function(){
        $(this).uniform();
      });




      // BEGIN FORM ADD REMBUG VALIDATION
      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);
      
      $("#btn_add").click(function(){
        branch_code = $("#branch_code").val();
        if(branch_code=="")
        {
          alert("Kantor Cabang belum dipilih !");
        }
        else
        {

          $("#wrapper-table").hide();
          $("#add").show();
          form1.trigger('reset');
          var branch_code = $("#branch_code").val();
          var branch_name = $("#branch_name").val();
          //mendapatkan jumlah maksimal
          $.ajax({
            url: site_url+"cif/get_ajax_branch_code_",
            type: "POST",
            dataType: "html",
            data: {branch_code:branch_code},
            success: function(response)
            {
              ///$("#id_cabang").val(response);
              $("#id_cabang").val(branch_name);
            }
          })

          $.ajax({
            type: "POST",
            url: site_url+"cif/search_target_item",
            data: {branch_code:branch_code},
            dataType: "json",
            success: function(response){
              var option = '<option value="">PILIH</option>';
              for(i = 0 ; i < response.length ; i++){
                option += '<option value="'+response[i].code_value+'">'+response[i].display_text+'</option>';
              }
              // console.log(option);
              $("#target_item").html(option);
            }
          })
        }
      });

      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          rules: {
              id_cabang: {
                  minlength: 4,
                  required: true
              },
              tahun: {
                  required: true
              }, 
              target_item: {
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

          submitHandler: false
      });


      $("button[type=submit]","#form_add").click(function(e){

        if($(this).valid()==true)
        {
          form1.ajaxForm({
              dataType: "json",
              success: function(response) {
                if(response.success==true){
                  success1.show();
                  error1.hide();
                  form1.trigger('reset');
                  form1.children('div').removeClass('success');
                  $("#cancel",form_add).trigger('click')
                  alert('Successfully Saved Data');
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
        else
        {
          alert('Please fill the empty field before.');
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





      // BEGIN FORM EDIT USER VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var target_id = $(this).attr('target_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {target_id:target_id},
          url: site_url+"cif/get_data_target_by_target_id",
          success: function(response){
            console.log(response);
            form2.trigger('reset'); 

            $("#form_edit input[name='target_id']").val(response.target_id); 
            $("#form_edit input[name='branch_code']").val(response.branch_name);
            $("#form_edit input[name='tahun']").val(response.tahun); 
            $("#form_edit input[name='target_item']").val(response.item_target);

            $("#form_edit input[name='t1']").val(response.t1);
            $("#form_edit input[name='t2']").val(response.t2);   
            $("#form_edit input[name='t3']").val(response.t3);   
            $("#form_edit input[name='t4']").val(response.t4);   
            $("#form_edit input[name='t5']").val(response.t5);   
            $("#form_edit input[name='t6']").val(response.t6);   
            $("#form_edit input[name='t7']").val(response.t7);   
            $("#form_edit input[name='t8']").val(response.t8);   
            $("#form_edit input[name='t9']").val(response.t9);     
            $("#form_edit input[name='t10']").val(response.t10);   
            $("#form_edit input[name='t11']").val(response.t11);   
            $("#form_edit input[name='t12']").val(response.t12);   

          }
        })

      });

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              branch_code: {
                  minlength: 4,
                  required: true
              },
              tahun: {
                  minlength: 4,
                  required: true
              },
              target_item: {
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

            $.ajax({
              type: "POST",
              url: site_url+"cif/edit_target_cabang",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  $("#rembug_table_filter input").val('');
                  dTreload();
                  $("#cancel",form_edit).trigger('click')
                  alert('Successfully Updated Data');
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

      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel","#form_edit").click(function(){
        success2.hide();
        error2.hide();
        $("#edit").hide();
        $("#wrapper-table").show();
        dTreload();
      });





      $("#btn_delete").click(function(){

        var cm_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          cm_id[$i] = $(this).val();

          $i++;

        });

        if(cm_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"cif/delete_rembug",
              dataType: "json",
              data: {cm_id:cm_id},
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
      $('#rembug_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"cif/datatable_target_cabang",
          "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
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
          "fnServerParams": function ( aoData ) {
              aoData.push( { "name": "branch_code", "value": $("#branch_code").val() } );
          },
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
      $(".dataTables_filter").parent().hide();

      jQuery('#user_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#user_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS -->

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
    <h3 class="page-title">
      Report Setup <small>Untuk melakukan konfigurasi Report</small>
    </h3>
    <!-- [BEGIN] REPORT -->
    <div class="row-fluid">
      <div class="span12">
       <div class="portlet box green">
          <div class="portlet-title">
             <div class="caption"><i class="icon-reorder"></i>Report Setup</div>
             <div class="tools">
                <a href="javascript:;" class="collapse"></a>
             </div>
          </div>
          <div class="portlet-body">
              <div class="btn-group pull-right">
                <button id="btn_delete" class="btn red">
                  Delete Report <i class="icon-remove"></i>
                </button>
              </div>
              <div class="btn-group pull-right">
                <a href="#dialog_add_report" data-toggle="modal" id="btn_add" class="btn green"> Add Report <i class="icon-plus"></i></a>
              </div>
              <table class="table table-striped table-bordered table-hover" id="report_table">
                 <thead>
                    <tr>
                       <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#report_table .checkboxes" /></th>
                       <th width="20%">Kode</th>
                       <th>Nama Report</th>
                       <th width="25%">Jenis Report</th>
                       <th width="20%" style="text-align:center;">Action</th>
                    </tr>
                 </thead>
                 <tbody>
                    
                 </tbody>
              </table>
          </div>
        </div>
      </div>
    </div>

    <div class="row-fluid">
      <!-- [BEGIN] REPORT ITEM -->
      <div class="span7">
       <div class="portlet box green">
        <div class="portlet-title">
           <div class="caption"><i class="icon-reorder"></i><span id="title_report_item">Item</span></div>
           <div class="tools">
              <a href="javascript:;" class="collapse"></a>
           </div>
        </div>
        <div class="portlet-body">
            <div class="btn-group pull-right">
              <button id="btn_delete_item" class="btn red">
                Delete Item<i class="icon-remove"></i>
              </button>
            </div>
            <div class="btn-group pull-right">
              <a href="#dialog_add_report_item" data-toggle="modal" id="btn_add_item" class="btn green"> Add Item <i class="icon-plus"></i></a>
            </div>
            <table class="table table-striped table-bordered table-hover" id="report_item_table">
             <thead>
                <tr>
                   <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#report_item_table .checkboxes" /></th>
                   <th style="vertical-align:middle;" width="15%">Item<br>Code</th>
                   <th style="vertical-align:middle;" width="22%">Item<br>Name</th>
                   <th style="vertical-align:middle;" width="15%" class="hidden-480">Type</th>
                   <th style="vertical-align:middle;" width="15%" class="hidden-480">Position</th>
                   <th style="vertical-align:middle;text-align:center;">Action</th>
                </tr>
             </thead>
             <tbody>
                
             </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="span5">
         <div class="portlet box green">
          <div class="portlet-title">
             <div class="caption"><i class="icon-reorder"></i><span id="title_report_item_member">Account</span></div>
             <div class="tools">
                <a href="javascript:;" class="collapse"></a>
             </div>
          </div>
          <div class="portlet-body">
            <table>
              <tr>
                <td>
                  <form>
                  </form>
                </td>
              </tr>
            </table>
            <input type="hidden" name="gl_report_item_id" id="gl_report_item_id">
              <div class="pull-left">
                GROUP BY : &nbsp;
                <select name="sort_account_type" id="sort_account_type">
                  <option value="0">SEMUA</option>
                  <?php
                  foreach($listcodes as $listcode):
                  ?>
                  <option value="<?php echo $listcode['code_value']; ?>"><?php echo $listcode['display_text'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            <div class="btn-group pull-right">
              <button id="btn_save_changes" class="btn blue">
                Save Changes <i class="icon-save"></i>
              </button>
            </div>
            <table class="table table-striped table-bordered table-hover" id="report_item_member_table" width="100%">
               <thead>
                  <tr>
                     <th style="width:8px;"><input type="checkbox" class="group-checkable" id="cek_all" data-set="#report_item_member_table .checkboxes" /></th>
                     <th width="30%">Account Code</th>
                     <th>Account Name</th>
                  </tr>
               </thead>
               <tbody>
                  
               </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- [END] REPORT ITEM -->
    </div>
    
    <!-- ADD REPORT FORM -->
    <div id="dialog_add_report" class="modal hide fade" data-width="400" style="margin-top:-200px; margin-left:-200px; width:400px; ">
       <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h3>ADD REPORT</h3>
       </div>
       <div class="modal-body">
          <div class="row-fluid">
             <div class="span12">
                <h5 style="margin-bottom:3px; margin-left:2px;">Kode</h5>
                <p><input type="text" name="report_code" id="report_code" class="span3 m-wrap"></p>
                <h5 style="margin-bottom:3px; margin-left:2px;">Nama Report</h5>
                <p><input type="text" name="report_name" id="report_name" class="span12 m-wrap"></p>
                <h5 style="margin-bottom:3px; margin-left:2px;">Jenis Report</h5>
                <p><select name="report_type" id="report_type" class="span12 m-wrap">
                   <option value="">SILAHKAN PILIH</option>
                   <option value="0">NERACA</option>
                   <option value="1">LABA RUGI</option>
                </select></p>
             </div>
          </div>
       </div>
       <div class="modal-footer">
          <button type="button" id="save" class="btn blue">Save</button>
          <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
       </div>
    </div>
    
    <!-- EDIT REPORT FORM -->
    <div id="dialog_edit_report" class="modal hide fade" data-width="400" style="margin-top:-200px; margin-left:-200px; width:400px; ">
       <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h3>EDIT REPORT</h3>
       </div>
       <div class="modal-body">
          <div class="row-fluid">
             <div class="span12">
                <input type="hidden" id="gl_report_id" name="gl_report_id">
                <h5 style="margin-bottom:3px; margin-left:2px;">Kode</h5>
                <p><input type="text" name="report_code" id="report_code" class="span3 m-wrap"></p>
                <h5 style="margin-bottom:3px; margin-left:2px;">Nama Report</h5>
                <p><input type="text" name="report_name" id="report_name" class="span12 m-wrap"></p>
                <h5 style="margin-bottom:3px; margin-left:2px;">Jenis Report</h5>
                <p><select name="report_type" id="report_type" class="span12 m-wrap">
                   <option value="">SILAHKAN PILIH</option>
                   <option value="0">NERACA</option>
                   <option value="1">LABA RUGI</option>
                </select></p>
             </div>
          </div>
       </div>
       <div class="modal-footer">
          <button type="button" id="save" class="btn blue">Save</button>
          <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
       </div>
    </div>
    <!-- [END] REPORT -->

    
    <!-- ADD REPORT ITEM FORM -->
    <div id="dialog_add_report_item" class="modal hide fade" data-width="400" style="top:10%;position:fixed">
       <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h3>ADD REPORT ITEM</h3>
       </div>
       <div class="modal-body">
          <div class="row-fluid">
             <div class="span12">
                <input type="hidden" name="report_code" id="report_code">
                <h5 style="margin-bottom:3px; margin-left:2px;">Item Code</h5>
                <p><input type="text" name="item_code" id="item_code" class="span3 m-wrap"></p>
                <h5 style="margin-bottom:3px; margin-left:2px;">Item Name</h5>
                <p><input type="text" name="item_name" id="item_name" class="span12 m-wrap"></p>
                <h5 style="margin-bottom:3px; margin-left:2px;">Item Type</h5>
                <p><select name="item_type" id="item_type" class="span12 m-wrap">
                   <option value="">SILAHKAN PILIH</option>
                   <option value="0">Title</option>
                   <option value="1">Summary</option>
                   <option value="2">Formula</option>
                   <option value="3">Total</option>
                </select></p>
                <h5 style="margin-bottom:3px; margin-left:2px;">Posisi</h5>
                <p><select name="posisi" id="posisi" class="span12 m-wrap">
                   <option value="">SILAHKAN PILIH</option>
                   <option value="0">Posisi 0</option>
                   <option value="1">Posisi 1</option>
                   <option value="2">Posisi 2</option>
                </select></p>
                <h5 style="margin-bottom:3px; margin-left:2px;">Display Saldo</h5>
                <p><select name="display_saldo" id="display_saldo" class="span12 m-wrap">
                   <option value="">SILAHKAN PILIH</option>
                   <option value="0">Normal</option>
                   <option value="1">Reverse (dikalikan -1)</option>
                </select></p>
                <div id="wrap-formula" style="display:none">
                  <h5 style="margin-bottom:3px; margin-left:2px;">Formula</h5>
                  <p><input type="text" name="formula" id="formula" class="span12 m-wrap"></p>
                  <h5 style="margin-bottom:3px; margin-left:2px;">Text Tebal</h5>
                  <p><select name="formula_text_bold" id="formula_text_bold" class="span12 m-wrap">
                     <option value="">SILAHKAN PILIH</option>
                     <option value="0">Tidak</option>
                     <option value="1">Ya</option>
                  </select></p>
                </div>
             </div>
          </div>
       </div>
       <div class="modal-footer">
          <button type="button" id="save" class="btn blue">Save</button>
          <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
       </div>
    </div>
    
    <!-- EDIT REPORT ITEM FORM -->
    <div id="dialog_edit_report_item" class="modal hide fade" data-width="400" style="top:10%;position:fixed;">
       <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h3>EDIT REPORT ITEM</h3>
       </div>
       <div class="modal-body">
          <div class="row-fluid">
             <div class="span12">
                <input type="hidden" id="gl_report_item_id" name="gl_report_item_id">
                <h5 style="margin-bottom:3px; margin-left:2px;">Item Code</h5>
                <p><input type="text" name="item_code" id="item_code" class="span3 m-wrap"></p>
                <h5 style="margin-bottom:3px; margin-left:2px;">Item Name</h5>
                <p><input type="text" name="item_name" id="item_name" class="span12 m-wrap"></p>
                <h5 style="margin-bottom:3px; margin-left:2px;">Item Type</h5>
                <p><select name="item_type" id="item_type" class="span12 m-wrap">
                   <option value="">SILAHKAN PILIH</option>
                   <option value="0">Title</option>
                   <option value="1">Summary</option>
                   <option value="2">Formula</option>
                   <option value="3">Total</option>
                </select></p>
                <h5 style="margin-bottom:3px; margin-left:2px;">Posisi</h5>
                <p><select name="posisi" id="posisi" class="span12 m-wrap">
                   <option value="">SILAHKAN PILIH</option>
                   <option value="0">Posisi 0</option>
                   <option value="1">Posisi 1</option>
                   <option value="2">Posisi 2</option>
                </select></p>
                <h5 style="margin-bottom:3px; margin-left:2px;">Display Saldo</h5>
                <p><select name="display_saldo" id="display_saldo" class="span12 m-wrap">
                   <option value="">SILAHKAN PILIH</option>
                   <option value="0">Normal</option>
                   <option value="1">Reverse (dikalikan -1)</option>
                </select></p>
                <div id="wrap-formula" style="display:none">
                  <h5 style="margin-bottom:3px; margin-left:2px;">Formula</h5>
                  <p><input type="text" name="formula" id="formula" class="span12 m-wrap"></p>
                  <h5 style="margin-bottom:3px; margin-left:2px;">Text Tebal</h5>
                  <p><select name="formula_text_bold" id="formula_text_bold" class="span12 m-wrap">
                     <option value="">SILAHKAN PILIH</option>
                     <option value="0">Tidak</option>
                     <option value="1">Ya</option>
                  </select></p>
                </div>
             </div>
          </div>
       </div>
       <div class="modal-footer">
          <button type="button" id="save" class="btn blue">Save</button>
          <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
       </div>
    </div>
    <!-- [END] REPORT ITEM -->

   </div>
</div>
<!-- END PAGE HEADER-->

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
     
      $("#mask_date").inputmask("y/m/d", {autoUnmask: true});  //direct mask        
   });
</script>

<script type="text/javascript">
$(function(){

  // $("#report_code","#dialog_add_report_item").val('');

  /* BEGIN SCRIPT FOR REPORT */

  // begin first table
  $('#report_table').dataTable({
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": site_url+"gl/datatable_report_setup",
      // "fnServerParams": function ( aoData ) {
      //     aoData.push( { "name": "cm_code", "value": $("#cm_code").val() } );
      // },
      "aoColumns": [
        null,
        null,
        null,
        null,
        { "bSortable": false }
      ],
      "aLengthMenu": [
          [15, 25, 50, -1],
          [15, 25, 50, "All"] // change per page values here
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
      "sZeroRecords" : "Data Pada Rembug ini Kosong",
      "aoColumnDefs": [{
              'bSortable': false,
              'aTargets': [0]
          }
      ]
  });
  $(".dataTables_length,.dataTables_filter").parent().hide();
  

  jQuery('#report_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
  jQuery('#report_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
  //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

  // fungsi untuk reload data table
  // di dalam fungsi ini ada variable tbl_id
  // gantilah value dari tbl_id ini sesuai dengan element nya
  var dTreload = function()
  {
    var tbl_id = 'report_table';
    $("select[name='"+tbl_id+"_length']").trigger('change');
    $(".paging_bootstrap li:first a").trigger('click');
    $("#"+tbl_id+"_filter input").val('').trigger('keyup');
  }

  $("#save","#dialog_add_report").live('click',function(){
    report_code = $("#report_code","#dialog_add_report").val();
    report_name = $("#report_name","#dialog_add_report").val();
    report_type = $("#report_type","#dialog_add_report").val();

    $.ajax({
      type: "POST",
      dataType: "json",
      url: site_url+"gl/add_report_setup",
      data: {
        report_code:report_code,
        report_name:report_name,
        report_type:report_type
      },
      async: false,
      error: function(){
        alert("Failed to Conenct into Databases !")
      },
      success: function(response){
        if(response.success==true){
          alert("Add New Report Successed !");
          $("#close","#dialog_add_report").trigger('click');
          dTreload();
        }else{
          alert("Add New Report Failed !");
        }
      }
    })
  });

  /*DELETE*/

  // fungsi untuk check all
  jQuery('#report_table .group-checkable').live('change',function () {
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

  $("#btn_delete").click(function(){

    var gl_report_id = [];
    var $i = 0;
    $("input#checkbox:checked","#report_table").each(function(){

      gl_report_id[$i] = $(this).val();

      $i++;

    });

    if(gl_report_id.length==0){
      alert("Please select some row to delete !");
    }else{
      var conf = confirm('Are you sure to delete this rows ?');
      if(conf){
        $.ajax({
          type: "POST",
          url: site_url+"gl/delete_report_setup",
          dataType: "json",
          data: {gl_report_id:gl_report_id},
          error: function(){
            alert("Failed to Conenct into Databases !")
          },
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

  /* EDIT */

  $("a#link-edit","#report_table").live('click',function(){
    var gl_report_id = $(this).attr('gl_report_id');
    $.ajax({
      type: "POST",
      dataType: "json",
      data: {gl_report_id:gl_report_id},
      url: site_url+"gl/ajax_get_report_setup",
      async: false,
      error: function(){
        alert("Failed to Conenct into Databases !")
      },
      success: function(response){
        $("#gl_report_id","#dialog_edit_report").val(response.gl_report_id);
        $("#report_code","#dialog_edit_report").val(response.report_code);
        $("#report_name","#dialog_edit_report").val(response.report_name);
        $("#report_type","#dialog_edit_report").val(response.report_type);
      }
    });
  });

  $("#save","#dialog_edit_report").live('click',function(){
    gl_report_id = $("#gl_report_id","#dialog_edit_report").val();
    report_code = $("#report_code","#dialog_edit_report").val();
    report_name = $("#report_name","#dialog_edit_report").val();
    report_type = $("#report_type","#dialog_edit_report").val();

    $.ajax({
      type: "POST",
      dataType: "json",
      url: site_url+"gl/edit_report_setup",
      data: {
        gl_report_id:gl_report_id,
        report_code:report_code,
        report_name:report_name,
        report_type:report_type
      },
      async: false,
      error: function(){
        alert("Failed to Conenct into Databases !")
      },
      success: function(response){
        if(response.success==true){
          alert("EDIT Report Successed !");
          $("#close","#dialog_edit_report").trigger('click');
          dTreload();
        }else{
          alert("EDIT Report Failed !");
        }
      }
    })
  });

  /* END SCRIPT FOR REPORT */

  /* BEGIN SCRIPT FOR REPORT ITEM */

  // show item table
  $("a#link-show-item","#report_table").live('click',function(){
    report_code = $(this).attr('report_code');
    report_name = $(this).attr('report_name');
    $("#report_code","#dialog_add_report_item").val(report_code);
    $("span#title_report_item").html('ITEM of Report \"'+report_name+'\"');
    $("div#uniform-undefined span").removeClass('checked');
    // begin first table
    $('#report_item_table').dataTable({
       "bDestroy":true,
       "bProcessing": true,
       "bServerSide": true,
       "sAjaxSource": site_url+"gl/datatable_report_item_setup",
       "fnServerParams": function ( aoData ) {
          aoData.push( { "name": "report_code", "value": report_code } );
        },
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
          // Bold the grade for all 'A' grade browsers
          $('td:eq(3)', nRow).addClass( 'hidden-480' );
          $('td:eq(4)', nRow).addClass( 'hidden-480' );
        },
       "aoColumns": [
         null,
         null,
         null,
         null,
         null,
         { "bSortable": false }
       ],
       "aLengthMenu": [
           [10, 20, -1],
           [10, 20, "All"] // change per page values here
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
       "sZeroRecords" : "Data Pada Rembug ini Kosong",
       "aoColumnDefs": [{
               'bSortable': false,
               'aTargets': [0]
           }
       ]
    });
    
    $(".dataTables_length,.dataTables_filter").parent().hide();
  });

  jQuery('#report_item_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
  jQuery('#report_item_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
  //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

  // fungsi untuk reload data table
  // di dalam fungsi ini ada variable tbl_id
  // gantilah value dari tbl_id ini sesuai dengan element nya
  var dTreload2 = function()
  {
    var tbl_id = 'report_item_table';
    $("select[name='"+tbl_id+"_length']").trigger('change');
    $(".paging_bootstrap li:first a").trigger('click');
    $("#"+tbl_id+"_filter input").val('').trigger('keyup');
  }

  $("#item_type","#dialog_add_report_item").live('change',function(){
    if($(this).val()=='2'){
      $("#wrap-formula","#dialog_add_report_item").show();
    }else{
      $("#wrap-formula","#dialog_add_report_item").hide();
    }
  })
  $("#item_type","#dialog_edit_report_item").live('change',function(){
    if($(this).val()=='2'){
      $("#wrap-formula","#dialog_edit_report_item").show();
    }else{
      $("#wrap-formula","#dialog_edit_report_item").hide();
    }
  })

  $("#save","#dialog_add_report_item").live('click',function(){
    report_code = $("#report_code","#dialog_add_report_item").val();
    item_code = $("#item_code","#dialog_add_report_item").val();
    item_name = $("#item_name","#dialog_add_report_item").val();
    item_type = $("#item_type","#dialog_add_report_item").val();
    posisi = $("#posisi","#dialog_add_report_item").val();
    display_saldo = $("#display_saldo","#dialog_add_report_item").val();
    formula = $("#formula","#dialog_add_report_item").val();
    formula_text_bold = $("#formula_text_bold","#dialog_add_report_item").val();

    $.ajax({
      type: "POST",
      dataType: "json",
      url: site_url+"gl/add_report_item_setup",
      data: {
        report_code:report_code,
        item_code:item_code,
        item_name:item_name,
        item_type:item_type,
        posisi:posisi,
        display_saldo:display_saldo,
        formula:formula,
        formula_text_bold:formula_text_bold
      },
      async: false,
      error: function(){
        alert("Failed to Conenct into Databases !")
      },
      success: function(response){
        if(response.success==true){
          alert("Add New Item Successed !");
          $("#close","#dialog_add_report_item").trigger('click');
          dTreload2();
        }else{
          alert("Add New Item Failed !");
        }
      }
    })
  });

  /*DELETE*/

  // fungsi untuk check all
  jQuery('#report_item_table .group-checkable').live('change',function () {
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

  $("#btn_delete_item").click(function(){

    var gl_report_item_id = [];
    var $i = 0;
    $("input#checkbox:checked","#report_item_table").each(function(){

      gl_report_item_id[$i] = $(this).val();

      $i++;

    });

    if(gl_report_item_id.length==0){
      alert("Please select some row to delete !");
    }else{
      var conf = confirm('Are you sure to delete this rows ?');
      if(conf){
        $.ajax({
          type: "POST",
          url: site_url+"gl/delete_report_item_setup",
          dataType: "json",
          data: {gl_report_item_id:gl_report_item_id},
          error: function(){
            alert("Failed to Conenct into Databases !")
          },
          success: function(response){
            if(response.success==true){
              alert("Deleted!");
              dTreload2();
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

  /* EDIT */

  $("a#link-edit","#report_item_table").live('click',function(){
    var gl_report_item_id = $(this).attr('gl_report_item_id');
    $.ajax({
      type: "POST",
      dataType: "json",
      data: {gl_report_item_id:gl_report_item_id},
      url: site_url+"gl/ajax_get_report_item_setup",
      async: false,
      error: function(){
        alert("Failed to Conenct into Databases !")
      },
      success: function(response){
        $("#gl_report_item_id","#dialog_edit_report_item").val(response.gl_report_item_id);
        $("#item_code","#dialog_edit_report_item").val(response.item_code);
        $("#item_name","#dialog_edit_report_item").val(response.item_name);
        $("#item_type","#dialog_edit_report_item").val(response.item_type);
        $("#posisi","#dialog_edit_report_item").val(response.posisi);
        $("#display_saldo","#dialog_edit_report_item").val(response.display_saldo);
        $("#formula","#dialog_edit_report_item").val(response.formula);
        $("#formula_text_bold","#dialog_edit_report_item").val(response.formula_text_bold);
        if(response.item_type=='2'){
          $("#wrap-formula","#dialog_edit_report_item").show();
        }else{
          $("#wrap-formula","#dialog_edit_report_item").hide();
        }
      }
    });
  });

  $("#save","#dialog_edit_report_item").live('click',function(){
    gl_report_item_id = $("#gl_report_item_id","#dialog_edit_report_item").val();
    item_code = $("#item_code","#dialog_edit_report_item").val();
    item_name = $("#item_name","#dialog_edit_report_item").val();
    item_type = $("#item_type","#dialog_edit_report_item").val();
    posisi = $("#posisi","#dialog_edit_report_item").val();
    display_saldo = $("#display_saldo","#dialog_edit_report_item").val();
    formula = $("#formula","#dialog_edit_report_item").val();
    formula_text_bold = $("#formula_text_bold","#dialog_edit_report_item").val();

    $.ajax({
      type: "POST",
      dataType: "json",
      url: site_url+"gl/edit_report_item_setup",
      data: {
        gl_report_item_id:gl_report_item_id,
        item_code:item_code,
        item_name:item_name,
        item_type:item_type,
        posisi:posisi,
        display_saldo:display_saldo,
        formula:formula,
        formula_text_bold:formula_text_bold
      },
      async: false,
      error: function(){
        alert("Failed to Conenct into Databases !")
      },
      success: function(response){
        if(response.success==true){
          alert("EDIT Item Successed !");
          $("#close","#dialog_edit_report_item").trigger('click');
          dTreload2();
        }else{
          alert("EDIT Item Failed !");
        }
      }
    })
  });
  
  /* END SCRIPT FOR REPORT ITEM */


  $("#sort_account_type").change(function(){
    // alert($("#sort_account_type").val())
    var gl_report_item_id = $("#gl_report_item_id").val();
    // begin first table
    $('#report_item_member_table').dataTable({
       "bDestroy":true,
       "bProcessing": true,
       "bServerSide": false,
       "sAjaxSource": site_url+"gl/datatable_report_item_member_setup",
       "fnServerParams": function ( aoData ) {
          aoData.push( { "name": "gl_report_item_id", "value": gl_report_item_id } );
          aoData.push( { "name": "sort_account_type", "value": $("#sort_account_type").val() } );
        },
       "aoColumns": [
         null,
         null,
         null
       ],
       "aLengthMenu": [
           // [15],
           [9999999999] // change per page values here
       ],
       // set the initial value
       "iDisplayLength": 9999999999,
       "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
       "sPaginationType": "bootstrap",
       "oLanguage": {
           "sLengthMenu": "_MENU_ records per page",
           "oPaginate": {
               "sPrevious": "Prev",
               "sNext": "Next"
           }
       },
       "sZeroRecords" : "Data Pada Rembug ini Kosong",
       "aoColumnDefs": [{
               'bSortable': false,
               'aTargets': [0]
           }
       ]
    });

    $("#report_item_member_table_info","#report_item_member_table_wrapper").hide();

    $("#report_item_member_table_info").parent().remove();
    $(".dataTables_paginate","#report_item_member_table_wrapper").parent().attr('class','span12');
    // $(".dataTables_paginate","#report_item_member_table_wrapper").parent().parent().hide();
    $(".dataTables_length,.dataTables_filter","#report_item_member_table_wrapper").parent().hide();
  })
  $("a#link-show-item-member","#report_item_table").live('click',function(){
    gl_report_item_id = $(this).attr('gl_report_item_id');
    // sort_account_type = $("#sort_account_type").val();
    item_name = $(this).attr('item_name');
    $("#gl_report_item_id").val(gl_report_item_id);
    console.log(gl_report_item_id);
    $("span#title_report_item_member").html('Account of Item \"'+((item_name.length>30) ? item_name.substring(0,30)+"..." : item_name)+'\"');
    // begin first table
    $('#report_item_member_table').dataTable({
       "bDestroy":true,
       "bProcessing": true,
       "bServerSide": false,
       "sAjaxSource": site_url+"gl/datatable_report_item_member_setup",
       "fnServerParams": function ( aoData ) {
          aoData.push( { "name": "gl_report_item_id", "value": gl_report_item_id } );
          aoData.push( { "name": "sort_account_type", "value": $("#sort_account_type").val() } );
        },
       "aoColumns": [
         null,
         null,
         null
       ],
       "aLengthMenu": [
           // [15],
           [9999999999] // change per page values here
       ],
       // set the initial value
       "iDisplayLength": 9999999999,
       "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
       "sPaginationType": "bootstrap",
       "oLanguage": {
           "sLengthMenu": "_MENU_ records per page",
           "oPaginate": {
               "sPrevious": "Prev",
               "sNext": "Next"
           }
       },
       "sZeroRecords" : "Data Pada Rembug ini Kosong",
       "aoColumnDefs": [{
               'bSortable': false,
               'aTargets': [0]
           }
       ]
    });

    $("#report_item_member_table_info","#report_item_member_table_wrapper").hide();

    $("#report_item_member_table_info").parent().remove();
    $(".dataTables_paginate","#report_item_member_table_wrapper").parent().attr('class','span12');
    // $(".dataTables_paginate","#report_item_member_table_wrapper").parent().parent().hide();
    $(".dataTables_length,.dataTables_filter","#report_item_member_table_wrapper").parent().hide();
  }); 

  /* BEGIN SCRIPT FOR REPORT ITEM MEMBER */

  /*paginate link action*/
  $(".dataTables_paginate li a","#report_item_member_table_wrapper").livequery('click',function(){
    if($("#cek_all","#report_item_member_table_wrapper").is(':checked')==true){
      $("#cek_all","#report_item_member_table_wrapper").parent().removeClass();
      $("#cek_all","#report_item_member_table_wrapper").attr('checked',false);
    }
  })

  // reload datatable
  var dTreload3 = function()
  { 
    var tbl_id = 'report_item_member_table';
    $("select[name='"+tbl_id+"_length']").trigger('change');
    $(".paging_bootstrap li:first a").trigger('click');
    $("#"+tbl_id+"_filter input").val('').trigger('keyup');
  }

  // fungsi untuk check all
  jQuery('#report_item_member_table .group-checkable').live('change',function () {
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

  // save report item member
  $("button#btn_save_changes").click(function(){
    gl_report_item_id = $("#gl_report_item_id").val();
    var account_code = [];
    var $i = 0;
    $("input#checkbox:checked","#report_item_member_table").each(function(){

      account_code[$i] = $(this).val();

      $i++;

    });

    
    $.ajax({
      type: "POST",
      url: site_url+"gl/save_report_item_member_setup",
      dataType: "json",
      data: {account_code:account_code,gl_report_item_id:gl_report_item_id},
      async: false,
      error: function(){
        alert("Failed to Conenct into Databases !")
      },
      success: function(response){
        if(response.success==true){
          alert("Account Saved!");
          dTreload3();
        }else{
          alert("Failed to Save!");
        }
      },
      error: function(){
        alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
      }
    });
  });

  // $("a#link-show-item-member","#report_item_table").live('click',function(){
  //   report_code = $(this).attr('report_code');
  //   report_name = $(this).attr('report_name');
  //   $("#report_code","#dialog_add_report_item_member").val(report_code);
  //   $("span#title_report_item_member").html('ITEM of Report <strong>'+report_name+'</strong><hr size="1">');
  //   // begin first table
  //   $('#report_item_member_table').dataTable({
  //      "bDestroy":true,
  //      "bProcessing": true,
  //      "bServerSide": true,
  //      "sAjaxSource": site_url+"gl/datatable_report_item_member_setup",
  //      "fnServerParams": function ( aoData ) {
  //         aoData.push( { "name": "report_code", "value": report_code } );
  //       },
  //      "aoColumns": [
  //        null,
  //        null,
  //        null,
  //      "aLengthMenu": [
  //          [5, 15, 20, -1],
  //          [5, 15, 20, "All"] // change per page values here
  //      ],
  //      // set the initial value
  //      "iDisplayLength": 9999999999,
  //      "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
  //      "sPaginationType": "bootstrap",
  //      "oLanguage": {
  //          "sLengthMenu": "_MENU_ records per page",
  //          "oPaginate": {
  //              "sPrevious": "Prev",
  //              "sNext": "Next"
  //          }
  //      },
  //      "sZeroRecords" : "Data Pada Rembug ini Kosong",
  //      "aoColumnDefs": [{
  //              'bSortable': false,
  //              'aTargets': [0]
  //          }
  //      ]
  //   });
  //   $(".dataTables_length,.dataTables_filter").parent().hide();
  // });

  /* END SCRIPT FOR REPORT ITEM MEMBER */

});
</script>
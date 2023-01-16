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
        CEK KTP ANGGOTA <small></small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Cek KTP Anggota</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body">
      <div class="clearfix">
         <!-- BEGIN FILTER FORM -->
         <form action="javascript:;" method="post">
            <table id="filter-form">
               <tr>
                  <td style="padding-bottom:10px;" width="100">No. KTP</td>
                  <td><input type="text" name="no_ktp" id="no_ktp" class="m-wrap"><button class="green btn" id="showgrid">Tampilkan</button></td>
               </tr>
            </table>
         </form>
          <p><hr></p>

          <table id="list485"></table>
          <div id="plist485"></div>
          <!-- END FILTER-->
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
$(function(){
/* BEGIN SCRIPT */

$("#showgrid").click(function(e){
	e.preventDefault();
	gridaja();
	$("#list485").trigger('reloadGrid')
})

//GRID SEMUA DATA ANGGOTA
var gridaja = function(){
	jQuery("#list485").jqGrid({
		url: site_url+'cif/proses_cek_ktp_anggota',
		datatype: 'json',
		height: 'auto',
		autowidth: true,
		postData: { no_ktp : function(){return $("#no_ktp").val()}},
		rowNum: 30,
		rowList: [50,100,150,200,250,300,350,400],
		colNames:['Cabang','Kumpulan','ID Anggota','Nama','Tanggal Gabung'],
		colModel:[
			{name:'branch_name',index:'branch_name'},
			{name:'cm_name',index:'cm_name'},
			{name:'cif_no',index:'cif_no'},
			{name:'nama',index:'nama'},
			{name:'tgl_gabung',index:'tgl_gabung'}
		],
		shrinkToFit: true,
		pager: "#plist485",
		viewrecords: true,
		sortname: 'branch_name',
		sortorder: 'asc' ,
		grouping:false,
		rownumbers: true
	});
}

/* BEGIN DIALOG ACTION BRANCH */
  
   $("#browse_branch").click(function(){
      $.ajax({
         type: "POST",
         url: site_url+"cif/search_cabang",
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
            url: site_url+"cif/search_cabang",
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
   });

   /* END DIALOG ACTION BRANCH */


   /* BEGIN DIALOG ACTION REMBUG */
  
   $("#browse_rembug").click(function(){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_rembug_by_keyword",
         dataType: "json",
         data: {keyword:$("#keyword","#dialog_rembug").val(),branch_code:$("#branch_code").val()},
         success: function(response){
            html = '<option value="" cm_id="" cm_name="Semua Rembug">Semua Rembug</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].cm_code+'" cm_id="'+response[i].branch_id+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
            }
            $("#result","#dialog_rembug").html(html);
         }
      })
   })

   $("#keyword","#dialog_rembug").keyup(function(e){
      e.preventDefault();
      keyword = $(this).val();
      if(e.which==13)
      {
         $.ajax({
            type: "POST",
            url: site_url+"cif/get_rembug_by_keyword_branch_id",
            dataType: "json",
            data: {keyword:keyword,branch_id:$("#branch_id").val()},
            success: function(response){
              html = '';
              html += '<option value="0000" cm_id="0000" cm_name="Semua Rembug">0000 - Semua Rembug</option>';
              for ( i = 0 ; i < response.length ; i++ )
              {
                 html += '<option value="'+response[i].cm_code+'" cm_id="'+response[i].branch_id+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
              }
              $("#result","#dialog_rembug").html(html);
            }
         })
      }
   });

   $("#select","#dialog_rembug").click(function(){
      cm_id = $("#result option:selected","#dialog_rembug").attr('cm_id');
      cm_name = $("#result option:selected","#dialog_rembug").attr('cm_name');
      cm_code = $("#result","#dialog_rembug").val();
      if(result!=null)
      {
         $("input[name='rembug']").val(cm_name);
         $("input[name='cm_code']").val(cm_code);
         $("#close","#dialog_rembug").trigger('click');
      }
   });

   $("#result option:selected","#dialog_rembug").live('dblclick',function(){
    $("#select","#dialog_rembug").trigger('click');
   })

   /* END DIALOG ACTION REMBUG */

      $(".dataTables_filter").parent().hide(); //menghilangkan serch
      
      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown
   
});
</script>
<!-- END JAVASCRIPTS -->

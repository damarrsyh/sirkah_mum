<style type="text/css">
#plist485_center input {
    margin: 0;
    padding: 3px;
    width: 10px;
    font-size:13px;
}
select {
    margin: 0;
    padding: 0;
    width: 40px;
    font-size:13px;
}
</style>

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
      List Anggota <small>Laporan</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Laporan</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Anggota</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

      <div class="clearfix">
            <input type="hidden" name="cm_code" id="cm_code" value="0000">
            <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code'); ?>">
            <input type="hidden" name="branch_id" id="branch_id" value="0000">
            Cabang <span style="color:red">*</span> &nbsp; : &nbsp;
            <input type="text" tabindex="1" name="branch" id="branch" readonly="" value="<?php echo $this->session->userdata('branch_name'); ?>"  style="background-color:#eee;" class="medium m-wrap">
            <?php if($this->session->userdata('flag_all_branch')){ ?>
            <a id="browse_branch" class="btn blue" data-toggle="modal" href="#dialog_branch">...</a>
            <?php } ?>
            &nbsp;&nbsp;
            Rembug <span style="color:red">*</span> &nbsp; : &nbsp;
            <input type="text" tabindex="2" name="cm" id="cm" style="padding:4px;margin-bottom:5px;box-shadow:0 0 0;" class="medium m-wrap">
            <a id="browse_cm" class="btn blue" tabindex="2" data-toggle="modal" href="#dialog_cm">...</a>
            <button class="btn blue" id="filter">Filter</button>
            <button class="btn red pull-right" id="exportexcel">Print CIF  <i class="icon-print"></i></button>
            <button class="btn green pull-right" id="exportcsv">Print CSV  <i class="icon-print"></i></button>
            <!-- <input type="submit" id="filter" value="Filter" class="btn blue"> -->
            <!-- <div class="btn-group pull-right">
            <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right">
               <li><a href="#" id="exportexcel">Export to Excel</a></li>
               <li><a href="#">Export to PDF</a></li>
            </ul>
            </div> -->
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
<table id="list485"></table>
<div id="plist485"></div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/jquery.json-2.2.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>

   jQuery(document).ready(function() {
      App.init(); // initlayout and core plugins
   });
   

   //BEGIN EXPORT TO EXCEL
   $("#exportexcel").click(function(){
        var cm_code   = $("input[name='cm_code']").val();
        var branch_code = $("input[name='branch_code']").val();
        var cm = $("input[name='cm']").val();
        // alert(cm_code)
        // alert(branch_code)
        if(cm==""){
          alert('Rembug Belum Dipilih');
        }else{
        window.open('<?php echo site_url();?>anggota/export_list_anggota/'+branch_code+'/'+cm_code);
        }
   });

   //BEGIN EXPORT TO CSV
   $("#exportcsv").click(function(){
        var cm_code   = $("input[name='cm_code']").val();
        var branch_code = $("input[name='branch_code']").val();
        var cm = $("input[name='cm']").val();
        // alert(cm_code)
        // alert(branch_code)
        if(cm==""){
          alert('Rembug Belum Dipilih');
        }else{
        window.open('<?php echo site_url();?>laporan_to_csv/list_anggota/'+branch_code+'/'+cm_code);
        }
   });

   //BEGIN SELECT DATA REMBUG
      $("#select","#dialog_cm").click(function(){
        result_name = $("#result option:selected","#dialog_cm").attr('cm_name');
        result_code = $("#result","#dialog_cm").val();
        if(result!=null)
        {
          $("input[name='cm']").val(result_name);
          $("input[name='cm_code']").val(result_code);
          $("#close","#dialog_cm").trigger('click');
        }
      });

      $("#result option","#dialog_cm").live('dblclick',function(){
        $("#select","#dialog_cm").trigger('click');
      });

      $("#keyword","#dialog_cm").keyup(function(e){
        e.preventDefault();
        keyword = $(this).val();
        branch_code = $("input[name='branch_code']").val();
        if(e.which==13){
          $.ajax({
             type: "POST",
             url: site_url+"cif/get_rembug_by_keyword",
             dataType: "json",
             async: false,
             data: {keyword:keyword,branch_code:branch_code},
             success: function(response){
                html = '';
                html += '<option value="0000" cm_name="Semua Rembug">0000 - Semua Rembug</option>';
                for ( i = 0 ; i < response.length ; i++ )
                {
                   html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
                }
                $("#result","#dialog_cm").html(html);
             }
          })
        }
      });

    $("#browse_cm").click(function(){
    if($("#keyword","#dialog_cm").val()==""){
      branch_code = $("input[name='branch_code']").val();
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_rembug_by_keyword",
         dataType: "json",
         async: false,
         data: {keyword:'',branch_code:branch_code},
         success: function(response){
            html = '';
            html += '<option value="0000" cm_name="Semua Rembug">0000 - Semua Rembug</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
            }
            $("#result","#dialog_cm").html(html);
         }
      })
    }
    });

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
           $("#field_rembug").show();
           $("#close","#dialog_branch").trigger('click');
        }
     });

     $("#result option:selected","#dialog_branch").live('dblclick',function(){
      $("#select","#dialog_branch").trigger('click');
     });

     /* END DIALOG ACTION BRANCH */

    $("#filter").click(function(){
          $("#close","#dialog_rembug").trigger('click');
		  gridAnggota();
          $("#list485").trigger('reloadGrid');
      })


//GRID SEMUA DATA ANGGOTA
var gridAnggota = function(){
	jQuery("#list485").jqGrid({
		url: site_url+'anggota/list_anggota_report',
		datatype: 'json',
		height: 'auto',
		postData: {
			cm : function(){return $("#cm_code").val()},
			branch : function(){return $("#branch_code").val()}
		},
		rowNum: 500,
		rowList: [500,1000,1500,2000,2500,3000,3500,4000,4500,5000],
		colNames:['ID Anggota','Nama Anggota', 'Nama Majelis', 'Kabupaten','Kecamatan','Desa','Tanggal Regis'],
		colModel:[
			{name:'cif_no',index:'cif_no', width:150},
			{name:'nama',index:'nama', width:150},
			{name:'cm_name',index:'cm_name', width:150},
			{name:'kabupaten',index:'kabupaten', width:150},
			{name:'kecamatan',index:'kecamatan', width:150},    
			{name:'desa',index:'desa', width:150},    
			{name:'created_timestamp',index:'created_timestamp', width:150}   
		],
		pager: "#plist485",
		viewrecords: true,
		sortname: 'cif_no',
		grouping:true,
		groupingView : {
			groupField : ['cm_name'],
			groupColumnShow : [true],
			groupText : ['<b style="font-size:14px;">{0} - {1} Anggota </b>'],
			groupCollapse : true,
			groupOrder: ['desc']      
		},
		caption: "List Data Anggota"
	});
}
</script>
<!-- END JAVASCRIPTS -->


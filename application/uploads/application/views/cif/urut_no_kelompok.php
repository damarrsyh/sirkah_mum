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
         Urut Nomor Kelompok <small>untuk melakukan pengurutan nomor kelompok</small>
      </h3>
      <ul class="breadcrumb">
         <li>
            <i class="icon-home"></i>
            <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
            <i class="icon-angle-right"></i>
         </li>
         <li><a href="#">Kelompok</a><i class="icon-angle-right"></i></li>  
         <li><a href="#">Urut Nomor Kelompok</a></li>  
      </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->




<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Urut Nomor Kelompok</div>
      <div class="tools">
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix" style="background:#EEE" id="form-filter">
        <label style="line-height:50px;float:left;margin-bottom:0;padding:0 5px 0 10px">Majelis</label>
        <div style="padding:5px;float:left;">
          <select id="cm_code" name="cm_code" class="large m-wrap chosen" data-required="1" style="margin:0 5px;">
            <option value="">Silahkan Pilih</option>
            <?php foreach($cms as $cm): ?>
               <option value="<?php echo $cm['cm_code'] ?>"><?php echo $cm['cm_name'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <label style="margin-left:5px;margin-right:5px;margin-bottom:0;line-height:50px;float:left;">Status Anggota</label>
        <div style="padding:5px;float:left;">
          <select id="status" name="status" class="small m-wrap chosen" data-required="1" style="margin:0 5px;">
              <option value="all">Semua</option>
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
          </select>
        </div>
        <div style="padding:5px;float:left;line-height:40px;">
          <button class="btn blue" id="btn-filter">Filter</button>
        </div>
        <div style="margin-right:5px;padding:5px;float:right;line-height:40px;display:none;" id="wrapper-button-save">
          <button class="btn green" id="btn-save"><i class="icon-save"></i> Save Changes</button>
        </div>
      </div>
      <hr style="margin:0 0 10px;">
      <form id="form-urut-no-kelompok" method="post">
      <table class="table table-striped table-bordered table-hover" id="table-cif">
         <thead>
            <tr>
               <th width="20%">Nomor CIF</th>
               <th width="20%">Nama</th>
               <th width="20%">Nama Panggilan</th>
               <th width="15%">Usia</th>
               <th width="15%">Status</th>
               <th width="10%">No. Urut</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
      </form>
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

<script>
   $(function() {    
      App.init(); // initlayout and core plugins
      Index.init();
      // Index.initCalendar(); // init index page's custom scripts
      // Index.initChat();
      // Index.initDashboardDaterange();
      // Index.initIntro();
      $("input#mask_date").inputmask("d/m/y");  //direct mask        
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){

   $("#btn-filter").click(function(e){
      e.preventDefault();
      cm_code=$("#cm_code").val();
      status=$("#status").val();
      if(cm_code==""){
         alert("Silahkan Pilih Majelis!");
      }else{
         $("#table-cif tbody").html('');
         $.ajax({
            type:"POST",dataType:"json",data:{cm_code:cm_code,status:status},
            url:site_url+"cif/get_all_data_cif_by_cm_code",
            success:function(response){
               data='';
               for(i=0;i<response.length;i++){
                  status=response[i].status;
                  status_class='purple-stripe';
                  switch(status){
                     case "0":
                     case "2":
                     status="Tidak aktif";
                     status_class='red-stripe';
                     break;
                     case "1":
                     status="Aktif";
                     status_class='green-stripe';
                     break;
                  }
                  data+=' \
                     <tr> \
                        <td style="vertical-align:middle;text-align:center"><input type="hidden" value="'+response[i].cif_id+'" name="arr_cif_id[]">'+response[i].cif_no+'</td> \
                        <td style="vertical-align:middle">'+response[i].nama+'</td> \
                        <td style="vertical-align:middle">'+response[i].panggilan+'</td> \
                        <td style="vertical-align:middle;text-align:center">'+response[i].usia+'</td> \
                        <td style="vertical-align:middle;text-align:center"><span class="btn mini '+status_class+'">'+status+'</span></td> \
                        <td style="vertical-align:middle;text-align:center"><input type="text" value="'+response[i].kelompok+'" id="arr_no_urut" name="arr_no_urut[]" class="m-wrap" style="width:20px;background:#FFF;text-align:center;margin:0;padding: 4px !important;font-size: 12px;" maxlength="2"></td> \
                     </tr> \
                  ';
               }
               $("#table-cif tbody").html(data);
               if(response.length>0){
                  $("div#wrapper-button-save").show();
               }else{
                  $("div#wrapper-button-save").hide();
               }
            }
         })
      }
   });

   $("input#arr_no_urut").live('keypress',function(e){
      if(e.keyCode==13){
         e.preventDefault();
         if($(this).closest('tr').next().length==0){
            $("#btn-save").focus();
            $(window).scrollTop(0);
         }else{
            $(this).closest('tr').next().find('input#arr_no_urut').select();
            $(window).scrollTop($(this).closest('tr').next().find('input#arr_no_urut').offset().top - 200);
         }
      }
   });
   $('input#arr_no_urut').live('change',function(){
    val = $(this).val();
    if (val.trim()=="") {
      $(this).val('0');
    }
   })

   $("#btn-save").click(function(e){
      e.preventDefault();
      $("#form-urut-no-kelompok").submit();
   });
   $("#form-urut-no-kelompok").submit(function(e){
      e.preventDefault();
      $.ajax({
         type:"POST",data:$(this).serialize(),dataType:"json",
         url:site_url+"cif/process_urut_no_kelompok",
         success:function(response){
            if(response.success==true){
               alert('Urut No. Kelompok SUKSES!');
               $("#btn-filter").trigger('click');
            }else{
               alert("Failed to Connect into Databases, Please Contact your administrator!");
            }
         },
         error:function(){
            alert("Internal Server Error, Please Contact your administrator!");
         }
      })
   })



});
</script>

<!-- END JAVASCRIPTS -->

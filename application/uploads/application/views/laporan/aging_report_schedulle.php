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
        Laporan <small>Rekapitulasi NPL</small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

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

<!-- BEGIN FORM-->


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Laporan Rekapitulasi NPL</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
    <div class="portlet-body form">
       <!-- BEGIN FILTER FORM -->
          <input type="hidden" name="branch" id="branch" value="<?php echo $this->session->userdata('branch_name'); ?>">
          <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code'); ?>">
          <input type="hidden" name="branch_class" id="branch_class" value="<?php echo $this->session->userdata('branch_class'); ?>">
          <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id'); ?>">
          <table id="filter-form">
             <tr>
                <td style="padding-bottom:10px;" width="100">Cabang</td>
                <td>
                   <input type="text" name="branch" readonly class="m-wrap mfi-textfield" style="background:#EEE;" value="<?php echo $this->session->userdata('branch_name'); ?>"> 
                   <?php if($this->session->userdata('flag_all_branch')=="1"){ ?>
                   <a id="browse_branch" class="btn blue" style="margin-top:8px;padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a>
                   <?php } ?>
                </td>
             </tr>
             <tr>
                <td style="padding-bottom:10px;" width="100">Rekap By</td>
                <td>
                   <select class="m-wrap small chosen" id="rekap_by" name="rekap_by">
                     <option value="cabang">CABANG</option>
                     <option value="petugas" style="display:none;">PETUGAS</option>
                     <option value="rembug">REMBUG</option>
                     <option value="produk">PRODUK</option>
                     <option value="peruntukan">PERUNTUKAN</option>
                     <!-- <option value="rembug">SEKTOR USAHA</option> -->
                     <option value="kol">PAR</option>
                   </select>
                </td>
             </tr>
             <tr id="wrap-petugas"<?php echo ($this->session->userdata('branch_class')!='3')?' style="display:none"':''; ?>>
                <td style="padding-bottom:10px;" width="100">Petugas</td>
                <td>
                   <select class="m-wrap large chosen" id="fa_code" name="fa_code">
                     <option value="all">SEMUA PETUGAS</option>
                     <?php foreach($data_fa as $dfa): ?>
                     <option value="<?php echo $dfa['fa_code'] ?>"><?php echo $dfa['fa_code'].' - '.$dfa['fa_name']; ?></option>
                     <?php endforeach; ?>
                   </select>
                </td>
             </tr>
             <tr id="wrap-rembug"<?php echo ($this->session->userdata('branch_class')!='3')?' style="display:none"':''; ?>>
                <td style="padding-bottom:10px;" width="100">Rembug</td>
                <td>
                   <select class="m-wrap large chosen" id="cm_code" name="cm_code">
                     <option value="all">SEMUA REMBUG</option>
                     <?php foreach($data_cm as $dcm): ?>
                     <option value="<?php echo $dcm['cm_code'] ?>"><?php echo $dcm['cm_name']; ?></option>
                     <?php endforeach; ?>
                   </select>
                </td>
             </tr>
             <tr>
                <td style="padding-bottom:10px;" width="100">Tanggal</td>
                <td>
                  <select name="tanggal_hitung" id="tanggal_hitung" style="width:170px;" class="medium m-wrap chosen">
                  </select>
                </td>
             </tr>
             <tr id="wrap-kol" style="display:none;">
                <td style="padding-bottom:10px;" width="100">PAR</td>
                <td>
                   <select class="m-wrap small chosen" id="kol" name="kol">
                     <option value="all">SEMUA PAR</option>
                     <?php foreach($data_kol as $dkol): ?>
                     <option><?php echo $dkol['par_desc']; ?></option>
                     <?php endforeach; ?>
                   </select>
                </td>
             </tr>
             <!-- <tr>
                <td></td>
                <td>
                </td>
             </tr> -->
          </table>
          <br>
          <div class="form-actions" style="padding-left:115px;">
           <button class="green btn" id="preview_pdf">Preview</button>
           <button class="green btn hidden" id="preview_xls">Preview Excel</button>
           <!-- <button type="reset" class="btn green" id="print_formulir">Print Formulir</button> -->
           <!-- <button type="submit" style="margin-left:10px;" class="btn blue" id="save_trx">Process</button> -->
           <!-- <button type="reset" style="margin-left:10px;" class="btn red" id="cancel_trx">Cancel</button> -->
          </div>
       <!-- END FILTER FORM -->
       <!-- <hr size="1"> -->
    </div>
</div>

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
   });
</script>

<script type="text/javascript">
$(function(){
/* BEGIN SCRIPT */

	change_tanggal();
	// TANGGAL PAR
	function change_tanggal(){
		var branch_code = $("#branch_code").val();
		
		var html = '<option value="">Pilih</option>';
		
		$.ajax({
			type: 'POST',
			url: site_url+'laporan/get_tanggal_par',
			dataType: 'json',
			async: false,
			data: {branch_code:branch_code},
			success: function(responses){
				var leng = responses.length;
				for(i = 0; i < leng; i++){
					var tanggal_hitung = responses[i].tanggal_hitung;
					html += '<option value="'+tanggal_hitung+'">'+tanggal_hitung+'</option>';
				}
				
				if(leng == 0){
					html += '';
				}
				
				$('#tanggal_hitung').html(html).trigger('liszt:updated');
			}
		});
	}
  
  //TAMBAHAN ADE
  change_rekap_by()
  
  function change_rekap_by()
  {
    var rekap_by = $("#rekap_by").val();
    var branch_code = $("#branch_code").val();
    var branch_class = $("#branch_class").val();
    // alert(branch_code+"|"+branch_class)

    $("#fa_code").val('').trigger('liszt:updated');
    $("#cm_code").val('').trigger('liszt:updated');
    $("#kol").val('').trigger('liszt:updated');
    switch(rekap_by){
      case "cabang":
      $("#wrap-petugas").hide();
      $("#wrap-rembug").hide();
      $("#wrap-kol").hide();
      break;
      case "rembug":
      $("#wrap-petugas").hide();
      $("#wrap-rembug").hide();
      $("#wrap-kol").hide();
      //$("#preview_pdf").hide();
      /* get rembug by branch */
      html='<option value="all">SEMUA REMBUG</option>';
      $.ajax({
        type:"POST",dataType:"json",data:{
          branch_code:branch_code,branch_class:branch_class
        },async:false,url:site_url+'laporan/get_cm_by_branch',
        success:function(response){
          for(i=0;i<response.length;i++){
            html+='<option value="'+response[i].cm_code+'">'+response[i].cm_name+'</option>';
          }
          if(response.length==0){
            html+='';
          }
          $("#cm_code").html(html).trigger('liszt:updated');
        },error:function(){
          alert("Internal Server Error. Please Contact Your Administrator!")
        }
      });
      break;
      case "petugas":
      $("#wrap-petugas").hide();
      $("#wrap-rembug").show();
      $("#wrap-kol").hide();
      //$("#preview_pdf").hide();
      /* get rembug by branch */
      html='<option value="all">SEMUA REMBUG</option>';
      $.ajax({
        type:"POST",dataType:"json",data:{
          branch_code:branch_code,branch_class:branch_class
        },async:false,url:site_url+'laporan/get_cm_by_branch',
        success:function(response){
          for(i=0;i<response.length;i++){
            html+='<option value="'+response[i].cm_code+'">'+response[i].cm_name+'</option>';
          }
          if(response.length==0){
            html+='';
          }
          $("#cm_code").html(html).trigger('liszt:updated');
        },error:function(){
          alert("Internal Server Error. Please Contact Your Administrator!")
        }
      });
      /* get data petugas by branch */
      html='<option value="all">SEMUA PETUGAS</option>';
      // $.ajax({
      //   type:"POST",dataType:"json",data:{
      //     branch_code:branch_code,branch_class:branch_class
      //   },async:false,url:site_url+'laporan/get_fa_by_branch',
      //   success:function(response){
      //     for(i=0;i<response.length;i++){
      //       html+='<option value="'+response[i].fa_code+'">'+response[i].fa_code+' - '+response[i].fa_name+'</option>';
      //     }
      //     if(response.length==0){
      //       html+='';
      //     }
      //     $("#fa_code").html(html).trigger('liszt:updated');
      //   },error:function(){
      //     alert("Internal Server Error. Please Contact Your Administrator!")
      //   }
      // });
      break;
      case "peruntukan":
      $("#wrap-petugas").hide();
      $("#wrap-rembug").hide();
      $("#wrap-kol").hide();
      //$("#preview_pdf").hide();
      break;
      case "produk":
      $("#wrap-petugas").hide();
      $("#wrap-rembug").hide();
      $("#wrap-kol").hide();
      //$("#preview_pdf").hide();
      break;
      case "kol":
      $("#wrap-petugas").hide();
      $("#wrap-rembug").hide();
      $("#wrap-kol").show();
      $("#preview_pdf").show();
      break;
    }
  }

  $("#rekap_by").change(function(){
    change_rekap_by()
  })

  // $("#fa_code").change(function(){   
  //   var fa_code =  $(this).val(); 
  //   /*generate data rembug by selected fa_code*/
  //   $.ajax({
  //     type:"POST"
  //     ,dataType:"json"
  //     ,data:{
  //       fa_code:fa_code
  //     }
  //     ,async:false
  //     ,url:site_url+'laporan/get_cm_by_fa_code',
  //     success:function(response){
  //       html='<option value="all">SEMUA REMBUG</option>';
  //       for(i=0;i<response.length;i++){
  //         html+='<option value="'+response[i].cm_code+'">'+response[i].cm_name+'</option>';
  //       }
  //       $("#cm_code").html(html).trigger('liszt:updated');
  //     },error:function(){
  //       alert("Internal Server Error. Please Contact Your Administrator!")
  //     }
  //   });
  // })
  //END TAMBAHAN ADE

   /* BEGIN DIALOG ACTION BRANCH */
  
   $("#browse_branch").click(function(){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         data: {keyword:$("#keyword","#dialog_branch").val()},
         success: function(response){
              html = '';
            // html = '<option value="0000" branch_code="0000" branch_name="Semua Branch">Semua Branch</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_id+'" branch_code="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'" branch_class="'+response[i].branch_class+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
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
            url: site_url+"cif/get_branch_by_keyword",
            dataType: "json",
            data: {keyword:keyword},
            success: function(response){
              html = '';
               // html = '<option value="0000" branch_code="0000" branch_name="Semua Branch">Semua Branch</option>';
               for ( i = 0 ; i < response.length ; i++ )
               {
                  html += '<option value="'+response[i].branch_id+'" branch_code="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'" branch_class="'+response[i].branch_class+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
               }
               $("#result","#dialog_branch").html(html);
            }
         })
      }
   });

   $("#select","#dialog_branch").click(function(){
      branch_code = $("#result option:selected","#dialog_branch").attr('branch_code');
      branch_name = $("#result option:selected","#dialog_branch").attr('branch_name');
      branch_class = $("#result option:selected","#dialog_branch").attr('branch_class');
      branch_id = $("#result","#dialog_branch").val();
      if(result!=null)
      {
         $("input[name='branch']").val(branch_name);
         $("input[name='branch_code']").val(branch_code);
         $("input[name='branch_class']").val(branch_class);
         $("input[name='branch_id']").val(branch_id);
         $("#close","#dialog_branch").trigger('click');
      }
      change_rekap_by();
	  change_tanggal();
      // if(branch_class=='3'){
      //   $("#wrap-petugas").show();
      //   $("#wrap-rembug").show();
      //   /*generate data petugas*/
      //   $.ajax({
      //     type:"POST",dataType:"json",data:{
      //       branch_code:branch_code,branch_class:branch_class
      //     },async:false,url:site_url+'laporan/get_fa_by_branch',
      //     success:function(response){
      //       html='<option value="all">SEMUA PETUGAS</option>';
      //       for(i=0;i<response.length;i++){
      //         html+='<option value="'+response[i].fa_code+'">'+response[i].fa_code+' - '+response[i].fa_name+'</option>';
      //       }
      //       $("#fa_code").html(html).trigger('liszt:updated');
      //     },error:function(){
      //       alert("Internal Server Error. Please Contact Your Administrator!")
      //     }
      //   });
      //   /*generate data rembug*/
      //   $.ajax({
      //     type:"POST",dataType:"json",data:{
      //       branch_code:branch_code,branch_class:branch_class
      //     },async:false,url:site_url+'laporan/get_cm_by_branch',
      //     success:function(response){
      //       html='<option value="all">SEMUA REMBUG</option>';
      //       for(i=0;i<response.length;i++){
      //         html+='<option value="'+response[i].cm_code+'">'+response[i].cm_name+'</option>';
      //       }
      //       $("#cm_code").html(html).trigger('liszt:updated');
      //     },error:function(){
      //       alert("Internal Server Error. Please Contact Your Administrator!")
      //     }
      //   });
      // }else{
      //   $("#wrap-petugas").hide();
      //   $("#wrap-rembug").hide();
      // }
   });

  // $("#fa_code").change(function(){
  //   if($(this).val()!=""){
  //     /*generate data rembug*/
  //     $.ajax({
  //       type:"POST",dataType:"json",data:{
  //         branch_code:$("#branch_code").val(),fa_code:$(this).val()
  //       },async:false,url:site_url+'laporan/get_cm_by_fa',
  //       success:function(response){
  //         html='<option value="all">SEMUA REMBUG</option>';
  //         for(i=0;i<response.length;i++){
  //           html+='<option value="'+response[i].cm_code+'">'+response[i].cm_name+'</option>';
  //         }
  //         $("#cm_code").html(html).trigger('liszt:updated');
  //       },error:function(){
  //         alert("Internal Server Error. Please Contact Your Administrator!")
  //       }
  //     });
  //   }
  // })

   $("#result option:selected","#dialog_branch").live('dblclick',function(){
    $("#select","#dialog_branch").trigger('click');
   })

   /* END DIALOG ACTION BRANCH */

   $("#preview_pdf").click(function(e){
      e.preventDefault();
      var rekap_by = $("#rekap_by").val();
      var branch_code = $("#branch_code").val();
      var branch_class = $("#branch_class").val();
      var fa_code = $("#fa_code").val();
      var cm_code = $("#cm_code").val();
      var kol = $("#kol").val();
      var tanggal_hitung = $("#tanggal_hitung").val();

      switch(rekap_by){
        case "cabang":
        window.open('<?php echo site_url();?>laporan_to_pdf/export_rekapitulasi_npl/'+branch_code+'/'+tanggal_hitung+'/REKAP KOLEKTIBILITAS BY CABANG');
        break;
        case "petugas":
        if(fa_code==""){
          alert("Pilih Petugas Terlebih Dahulu!");
        }else{
        window.open('<?php echo site_url();?>laporan_to_pdf/export_rekapitulasi_npl2/'+branch_code+'/'+fa_code+'/'+cm_code+'/'+tanggal_hitung+'/REKAP KOLEKTIBILITAS BY PETUGAS');
        }
        break;
        case "rembug":
        if(cm_code==""){
          alert("Pilih Rembug Terlebih Dahulu!");
        }else{
          window.open('<?php echo site_url();?>laporan_to_pdf/export_rekapitulasi_npl_rembug/'+branch_code+'/'+tanggal_hitung+'/REKAP KOLEKTIBILITAS BY REMBUG');
        }
        break;
        case "produk":
        if(tanggal_hitung==""){
          alert("Pilih Tanggal Terlebih Dahulu!");
        }else{
        window.open('<?php echo site_url();?>laporan_to_pdf/export_rekapitulasi_npl_produk/'+branch_code+'/'+tanggal_hitung+'/REKAP KOLEKTIBILITAS BY PRODUK');
		}
		break;
        case "peruntukan":
        if(tanggal_hitung==""){
          alert("Pilih Tanggal Terlebih Dahulu!");
        }else{
          window.open('<?php echo site_url();?>laporan_to_pdf/export_rekapitulasi_npl_peruntukan/'+branch_code+'/'+tanggal_hitung+'/REKAP KOLEKTIBILITAS BY PERUNTUKAN');
        }
        break;
        case "kol":
        window.open('<?php echo site_url();?>laporan_to_pdf/export_rekapitulasi_kol2/'+branch_code+'/'+kol+'/'+tanggal_hitung+'/REKAP KOLEKTIBILITAS BY PAR');
        break;
      }
   });

   $("#preview_xls").click(function(e){
      e.preventDefault();
      var rekap_by = $("#rekap_by").val();
      var branch_code = $("#branch_code").val();
      var branch_class = $("#branch_class").val();
      var fa_code = $("#fa_code").val();
      var cm_code = $("#cm_code").val();
      var kol = $("#kol").val();
      var tanggal_hitung = $("#tanggal_hitung").val();
      
      switch(rekap_by){
        case "cabang":
        if(tanggal_hitung==""){
          alert("Pilih Tanggal Terlebih Dahulu!");
        }else{
          window.open('<?php echo site_url();?>laporan_to_excel/export_rekapitulasi_npl/'+branch_code+'/'+tanggal_hitung);
        }
        break;
        case "petugas":
        if(tanggal_hitung==""){
          alert("Pilih Tanggal Terlebih Dahulu!");
        }else{
          window.open('<?php echo site_url();?>laporan_to_excel/export_rekapitulasi_npl_petugas/'+branch_code+'/'+cm_code+'/'+tanggal_hitung);
        }
        break;
        case "rembug":
        if(tanggal_hitung==""){
          alert("Pilih Tanggal Terlebih Dahulu!");
        }else{
          window.open('<?php echo site_url();?>laporan_to_excel/export_rekapitulasi_npl_rembug/'+branch_code+'/'+tanggal_hitung);
        }
        break;
        case "peruntukan":
        if(tanggal_hitung==""){
          alert("Pilih Tanggal Terlebih Dahulu!");
        }else{
          window.open('<?php echo site_url();?>laporan_to_excel/export_rekapitulasi_npl_peruntukan/'+branch_code+'/'+tanggal_hitung);
        }
        break;
        case "produk":
        if(tanggal_hitung==""){
          alert("Pilih Tanggal Terlebih Dahulu!");
        }else{
          window.open('<?php echo site_url();?>laporan_to_excel/export_rekapitulasi_npl_produk/'+branch_code+'/'+tanggal_hitung);
        }
        break;
        case "kol":
        window.open('<?php echo site_url();?>laporan_to_excel/export_rekapitulasi_kol/'+branch_code+'/'+kol+'/'+tanggal_hitung);
        break;
      }
   });

/* END SCRIPT */
})
</script>
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
        Laporan Kolektibilitas <small>untuk melihat laporan kolektibilitas</small>
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

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Laporan Kolektibilitas</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
    <div class="portlet-body form">
       <!-- BEGIN FILTER FORM -->
       <form>
            <input type="hidden" name="branch" id="branch" value="<?php echo $this->session->userdata('branch_name') ?>">
            <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code') ?>">
            <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id') ?>">
          <table id="filter-form">
             <tr>
                <td width="100">Cabang</td>
                <td><input type="text" name="branch_name" id="branch_name" data-required="1" class="medium m-wrap" value="<?php echo $this->session->userdata('branch_name'); ?>" readonly style="background:#EEE"/>
                    <?php
              if($this->session->userdata('flag_all_branch')=="1"){
              ?>
              <a id="browse_branch" class="btn blue" data-toggle="modal" href="#dialog_kantor_cabang">...</a>
              <?php } ?></td>
             </tr>
             <tr>
                <td>Tanggal</td>
                <td>
                   <select name="date" id="date" class="m-wrap medium chosen">
                    <option value="">Pilih Tanggal</option>
                   </select>
                </td>
             </tr>
             <tr>
                <td>Kolektibilitas</td>
                <td>
                   <select name="kol" id="kol" class="m-wrap medium chosen">
                    <option value="">Pilih Kolektibilitas</option>
                    <option value="all">SEMUA</option>
                    <?php foreach($param_par as $ppar): ?>
                      <option><?php echo $ppar['par_desc']; ?></option>
                    <?php endforeach; ?>
                   </select>
                </td>
             </tr>
             <tr>
                <td></td>
                <td><button class="green btn" id="previewxls">Excel</button>
                <button class="green btn" id="previewcsv">CSV</button></td>
             </tr>
          </table>
       </form>
       <!-- END FILTER FORM -->
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
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });
   });
</script>

<script type="text/javascript">
$(function(){
/* BEGIN SCRIPT */

	/* BEGIN DIALOG ACTION BRANCH */
	$("a#browse_branch").click(function(){
	   keyword = $("#keyword","#dialog_kantor_cabang").val();
	   $.ajax({
			 type: "POST",
			 url: site_url+"cif/get_branch_by_keyword",
			 dataType: "json",
			 data: {keyword:keyword},
			 success: function(response){
				html = '';
				// html = '<option value="0000" branch_name="Semua Branch" branch_id="0000">0000 - Semua Branch</option>';
				for ( i = 0 ; i < response.length ; i++ )
				{
				   html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
				}
				$("#result","#dialog_kantor_cabang").html(html);
			 }
		  })
	});
	
	  $("#keyword","#dialog_kantor_cabang").on('keypress',function(e){
		  if(e.which==13){
			$.ajax({
			  type: "POST",
			  url: site_url+"cif/search_cabang",
			  data: {keyword:$(this).val()},
			  dataType: "json",
			  success: function(response){
				var option = '';
				for(i = 0 ; i < response.length ; i++){
				   option += '<option value="'+response[i].branch_code+'" branch_code="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
				}
				// console.log(option);
				$("#result").html(option);
			  }
			});
		  }
	  });
	
	$("#select","#dialog_kantor_cabang").click(function(){
	  $(".close","#dialog_kantor_cabang").trigger('click');
	  branch_code = $("#result","#dialog_kantor_cabang").val();
	  branch_name = $("#result option:selected","#dialog_kantor_cabang").attr('branch_name');
	  branch_id = $("#result option:selected","#dialog_kantor_cabang").attr('branch_id');
	  $("#branch_code").val(branch_code);
	  $("#branch_name").val(branch_name);
	  $("#branch_id").val(branch_id);
	  tanggal_par();
	});
	
	$("#result option","#dialog_kantor_cabang").live('dblclick',function(){
	  $("#select","#dialog_kantor_cabang").trigger('click');
	});
   /* END DIALOG ACTION BRANCH */
   
   var tanggal_par = function(){
         /*get tanggal par*/
         var branch = $("#branch_code").val();
		 $.ajax({
          type:"POST",dataType:"json",data:{branch_code:branch},
          async:false,url:site_url+"laporan/get_tanggal_par",
          success:function(response){
            html='<option value="">Tanggal Kolektibilitas</option>';
            for(i=0;i<response.length;i++){
              tanggal_hitung=response[i].tanggal_hitung;
              ta=tanggal_hitung.split('-');
              html+='<option>'+ta[2]+'/'+ta[1]+'/'+ta[0]+'</option>';
            }
            $("#date").html(html);
            $(".chosen").trigger('liszt:updated')
          }
         });
   }
   
   tanggal_par();
   
   $("#previewxls").click(function(e){
      e.preventDefault();
      var branch_id = $("#branch_id").val();
      var date = $("select[name='date']").val().replace(/\//g,'');
      var kol = $("select[name='kol']").val();
      if(date==""){
        alert("Silahkan Pilih Tanggal Kolektibilitas!");
      }else if(kol==""){
        alert("Silahkan Pilih Kolektibilitas")
      }else{
        window.open(site_url+'laporan_to_excel/export_lap_aging/'+branch_id+'/'+date+'/'+kol);
      }
   });

   $("#previewcsv").click(function(e){
      e.preventDefault();
      var branch_id = $("#branch_id").val();
      var date = $("select[name='date']").val().replace(/\//g,'');
      var kol = $("select[name='kol']").val();
      if(date==""){
        alert("Silahkan Pilih Tanggal Kolektibilitas!");
      }else if(kol==""){
        alert("Silahkan Pilih Kolektibilitas")
      }else{
        window.open(site_url+'laporan_to_csv/export_lap_aging/'+branch_id+'/'+date+'/'+kol);
      }
   });

   /*$("#filter").click(function(e){
      e.preventDefault();
      $.ajax({
         type: "POST",
         dataType: "json",
         url: site_url+"laporan/get_neraca_saldo_gl",
         data: {
            branch_code : $("#branch_code").val(),
            periode_bulan : $("#periode_bulan").val(),
            periode_tahun : $("#periode_tahun").val()
         },
         success: function(response){
            html = '';
            for(i = 0 ; i < response['data'].length ; i++)
            {
               html += '<tr> \
                  <td align="center">'+response['data'][i].nomor+'</td> \
                  <td>'+response['data'][i].account+'</td> \
                  <td align="right" style="font-size:14px;">'+number_format(response['data'][i].saldo_awal,2,',','.')+'</td> \
                  <td align="right" style="font-size:14px;">'+number_format(response['data'][i].debit,2,',','.')+'</td> \
                  <td align="right" style="font-size:14px;">'+number_format(response['data'][i].credit,2,',','.')+'</td> \
                  <td align="right" style="font-size:14px;">'+number_format(response['data'][i].saldo_akhir,2,',','.')+'</td> \
               </tr>';
            }
            $("#total_debit").html(number_format(response['total_debit'],2,',','.'));
            $("#total_credit").html(number_format(response['total_credit'],2,',','.'));
            $("tbody","table#general_ledger ").html(html);
         }
      })
   });*/
  

/* END SCRIPT */
})
</script>
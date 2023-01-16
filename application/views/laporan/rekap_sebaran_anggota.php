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
        Laporan <small></small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Rekap Sebaran Anggota</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body">
      <div class="clearfix">
            <!-- BEGIN FILTER-->
              <table id="sorting_saldo">
                 <tr>
                    <td style="padding-bottom:10px;" width="100">Provinsi</td>
                    <td><input name="province" class="medium m-wrap" type="text" id="province" value="JAWA BARAT" readonly="readonly" style="background-color:#eee;" />
                    <input name="province_code" type="hidden" id="province_code" value="3200" /></td>
                 </tr>
				<tr id="r_cabang">
                  <td width="120">Cabang</td>
                  <td>
                  <input type="text" name="branch_name" id="branch_name" data-required="1" class="medium m-wrap" style="background-color:#eee;" readonly="" value="<?php echo $this->session->userdata('branch_name'); ?>" />
                  <input type="hidden" id="cabang" name="cabang" value="<?php echo $this->session->userdata('branch_code'); ?>">
                  <?php if($this->session->userdata('flag_all_branch')=='1'){ ?><a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a><?php } ?>
                    <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
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
                          <button type="button" id="select_cabang" class="btn blue">Select</button>
                       </div>
                    </div>
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                 <tr>
                   <td style="padding-bottom:10px;">Kota / Kab</td>
                   <td><input type="text" name="city_name" id="city_name" data-required="1" class="medium m-wrap" style="background-color:#eee;" readonly="" value="" />
                  <input type="hidden" id="city_code" name="city_code" value="">
                  <a id="browse_city" class="btn blue" data-toggle="modal" href="#dialog_city">...</a>
                    <div id="dialog_city" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                       <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                          <h3>Cari Kota</h3>
                       </div>
                       <div class="modal-body">
                          <div class="row-fluid">
                             <div class="span12">
                                <h4>Masukan Kata Kunci</h4>
                                <p><input type="text" name="keyword_city" id="keyword_city" placeholder="Search..." class="span12 m-wrap"></p> 
                                <p><select name="result_city" id="result_city" size="7" class="span12 m-wrap"></select></p>
                             </div>
                          </div>
                       </div>
                       <div class="modal-footer">
                          <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
                          <button type="button" id="select_city" class="btn blue">Select</button>
                       </div>
                    </div></td>
                 </tr>
                 <tr class="hidden">
                   <td style="padding-bottom:10px;">Kecamatan</td>
                   <td><input type="text" name="kecamatan_name" id="kecamatan_name" data-required="1" class="medium m-wrap" style="background-color:#eee;" readonly="" value="" />
                  <input type="hidden" id="kecamatan_code" name="kecamatan_code" value="">
                  <a id="browse_kecamatan" class="btn blue" data-toggle="modal" href="#dialog_kecamatan">...</a>
                    <div id="dialog_kecamatan" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                       <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                          <h3>Cari Kecamatan</h3>
                       </div>
                       <div class="modal-body">
                          <div class="row-fluid">
                             <div class="span12">
                                <h4>Masukan Kata Kunci</h4>
                                <p><input type="text" name="keyword_kecamatan" id="keyword_kecamatan" placeholder="Search..." class="span12 m-wrap"></p> 
                                <p><select name="result_kecamatan" id="result_kecamatan" size="7" class="span12 m-wrap"></select></p>
                             </div>
                          </div>
                       </div>
                       <div class="modal-footer">
                          <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
                          <button type="button" id="select_kecamatan" class="btn blue">Select</button>
                       </div>
                    </div></td>
                 </tr>
                 <tr class="hidden">
                   <td style="padding-bottom:10px;">Desa</td>
                   <td><input type="text" name="desa_name" id="desa_name" data-required="1" class="medium m-wrap" style="background-color:#eee;" readonly="" value="" />
                  <input type="hidden" id="desa_code" name="desa_code" value="">
                  <a id="browse_desa" class="btn blue" data-toggle="modal" href="#dialog_desa">...</a>
                    <div id="dialog_desa" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                       <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                          <h3>Cari Desa</h3>
                       </div>
                       <div class="modal-body">
                          <div class="row-fluid">
                             <div class="span12">
                                <h4>Masukan Kata Kunci</h4>
                                <p><input type="text" name="keyword_desa" id="keyword_desa" placeholder="Search..." class="span12 m-wrap"></p> 
                                <p><select name="result_desa" id="result_desa" size="7" class="span12 m-wrap"></select></p>
                             </div>
                          </div>
                       </div>
                       <div class="modal-footer">
                          <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
                          <button type="button" id="select_desa" class="btn blue">Select</button>
                       </div>
                    </div></td>
                 </tr>
                
                <tr>
                  <td></td>
                  <td>
                     <button class="green btn" id="tampilkan">Tampilkan</button>
                     <button class="green btn" id="previewpdf">Preview</button>
                     <button class="green btn" id="previewxls">Preview Excel</button>
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </table>
            <p><hr></p>
          <!-- END FILTER-->
          <p>&nbsp;</p>
            <table class="table table-striped table-bordered table-hover" id="r_sebaran_anggota">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Kota/Kab</th>
                  <th>Kecamatan</th>
                  <th>Desa</th>
                  <th>Majelis</th>
                  <th>Anggota</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
      </div>
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
   jQuery(document).ready(function() {
      App.init(); // initlayout and core plugins
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
      $("#browse_city").click(function(){
			$.ajax({
              type: "POST",
              url: site_url+"cif/search_city",
              data: {keyword:$('#keyword_city').val(), branch:$('#cabang').val()},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                   option += '<option value="'+response[i].city_code+'" city="'+response[i].city+'">'+response[i].city_code+' - '+response[i].city+'</option>';
                }
                // console.log(option);
                $("#result_city").html(option);
              }
            });
      });

      $("#keyword_city").on('keypress',function(e){
          if(e.which==13){
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_city",
              data: {keyword:$(this).val(), branch:$('#cabang').val()},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                  option += '<option value="'+response[i].city_code+'" city="'+response[i].city+'">'+response[i].city_code+' - '+response[i].city+'</option>';
                }
                // console.log(option);
                $("#result_city").html(option);
              }
            });
          }
      });

      $("#result_city option:selected").live('click',function(){
        $("#select_city").trigger('click');
      })

      $("#select_city").click(function(){
        $("#close","#dialog_city").trigger('click');
        city_code = $("#result_city option:selected","#dialog_city").val();
		city_name = $("#result_city option:selected","#dialog_city").attr('city');
        $("#city_code").val(city_code);
		$("#city_name").val(city_name);
                    
      });

      $("#browse_kecamatan").click(function(){
			$.ajax({
              type: "POST",
              url: site_url+"cif/search_kecamatan",
              data: {keyword:$('#keyword_kecamatan').val(), branch:$('#cabang').val(), city:$('#city_code').val()},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                   option += '<option value="'+response[i].kecamatan_code+'" kecamatan="'+response[i].kecamatan+'">'+response[i].kecamatan_code+' - '+response[i].kecamatan+'</option>';
                }
                // console.log(option);
                $("#result_kecamatan").html(option);
              }
            });
      });

      $("#keyword_kecamatan").on('keypress',function(e){
          if(e.which==13){
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_kecamatan",
              data: {keyword:$(this).val(), branch:$('#cabang').val(), city:$('#city_code').val()},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                   option += '<option value="'+response[i].kecamatan_code+'" kecamatan="'+response[i].kecamatan+'">'+response[i].kecamatan_code+' - '+response[i].kecamatan+'</option>';
                }
                // console.log(option);
                $("#result_kecamatan").html(option);
              }
            });
          }
      });

      $("#result_kecamatan option:selected").live('click',function(){
        $("#select_kecamatan").trigger('click');
      })

      $("#select_kecamatan").click(function(){
        $("#close","#dialog_kecamatan").trigger('click');
        kecamatan_code = $("#result_kecamatan option:selected","#dialog_kecamatan").val();
		kecamatan_name = $("#result_kecamatan option:selected","#dialog_kecamatan").attr('kecamatan');
        $("#kecamatan_code").val(kecamatan_code);
		$("#kecamatan_name").val(kecamatan_name);
                    
      });

      $("#browse_desa").click(function(){
			$.ajax({
              type: "POST",
              url: site_url+"cif/search_desa",
              data: {keyword:$('#keyword_desa').val(), branch:$('#cabang').val(), city:$('#city_code').val(), kecamatan:$('#kecamatan_code').val()},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                   option += '<option value="'+response[i].desa_code+'" desa="'+response[i].desa+'">'+response[i].desa_code+' - '+response[i].desa+'</option>';
                }
                // console.log(option);
                $("#result_desa").html(option);
              }
            });
      });

      $("#keyword_desa").on('keypress',function(e){
          if(e.which==13){
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_desa",
              data: {keyword:$('#keyword_desa').val(), branch:$('#cabang').val(), city:$('#city_code').val(), kecamatan:$('#kecamatan_code').val()},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                   option += '<option value="'+response[i].desa_code+'" desa="'+response[i].desa+'">'+response[i].desa_code+' - '+response[i].desa+'</option>';
                }
                // console.log(option);
                $("#result_desa").html(option);
              }
            });
          }
      });

      $("#result_desa option:selected").live('click',function(){
        $("#select_desa").trigger('click');
      })

      $("#select_desa").click(function(){
        $("#close","#dialog_desa").trigger('click');
        desa_code = $("#result_desa option:selected","#dialog_desa").val();
		desa_name = $("#result_desa option:selected","#dialog_desa").attr('desa');
        $("#desa_code").val(desa_code);
		$("#desa_name").val(desa_name);
                    
      });

      $("#browse_rembug").click(function(){
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
      });

      $("#keyword").on('keypress',function(e){
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

      $("#select_cabang").click(function(){
        $("#close","#dialog_rembug").trigger('click');
        branch_code = $("#result option:selected","#dialog_rembug").attr('branch_code');
        branch_name = $("#result option:selected","#dialog_rembug").attr('branch_name');
        $("#cabang").val(branch_code);
        $("#branch_name").val(branch_name);
                    
      });
    

      $("#result option:selected").live('click',function(){
        $("#select_cabang").trigger('click');
      })

      //export PDF
      $("#previewpdf").click(function(e)
      {
        e.preventDefault();
        var cabang    = $("#cabang").val();
        window.open('<?php echo site_url();?>laporan_to_pdf/export_rekap_sebaran_anggota_semua_cabang/'+cabang);
      });

      //export XLS
      $("#previewxls").click(function(e)
      {
        e.preventDefault();
        var cabang    = $("#cabang").val();

        var filter = $("#filter").val();
          if (filter=='0') 
          {            
              if(cabang=='0000' || cabang=='') 
              {            
                window.open('<?php echo site_url();?>laporan_to_excel/export_rekap_sebaran_anggota_semua_cabang/'+cabang);
              }        
              else
              {            
                window.open('<?php echo site_url();?>laporan_to_excel/export_rekap_sebaran_anggota_semua_cabang/'+cabang);
              } 
          } 
          else if (filter=='1') 
          {
            window.open('<?php echo site_url();?>laporan_to_excel/export_rekap_sebaran_anggota_semua_cabang/'+cabang);
          }
          else
          {
            alert("Parameter Kosong");
          }
        
      });
	  
	  /*
	  var DTReload = function(){
		  var tbl_id = 'r_sebaran_anggota';
		  $('select[name="'+tbl_id+'_length"]').trigger('change');
		  $('.paging_bootstrap li:first a').trigger('click');
		  $('#'+tbl_id+'_filter input').val('').trigger('keyup');
	  }
	  */
	  
	  var branch = $("#cabang").val();
	  
	  var DTReload = function (){
		  $('#r_sebaran_anggota').dataTable({
			  'bDestroy': true,
			  'bProcessing': true,
			  'bServerSide': true,
			  'async': false,
			  'sAjaxSource': site_url+'laporan/list_rekap_sebaran_anggota/',
			  'fnServerParams': function(aoData){
				  aoData.push({'name': 'branch','value': $("#cabang").val()});
				  aoData.push({'name': 'city','value': $("#city_code").val()});
			  },
			  'aoColumns': [
				null,
				null,
				null,
				null,
				null,
				null
			  ],
			  'aLengthMenu': [
				[15, 30, 45, -1],
				[15, 30, 45, "All"]
			  ],
			  'iDisplayLength': 15,
			  'sDom': '<"row-fluid"<"span6"l><"span6"f>r>t<"row-fluid"<"span6"i><"span6"p>>',
			  'sPaginationType': 'bootstrap',
			  'oLanguage': {
				  'sLengthMenu': '_MENU_ records per page',
				  'oPaginate': {
					  'sPrevious': 'Prev',
					  'sNext': 'Next'
				  }
			  },
			  'aoColumnDefs': [{
				  'bSortable': false,
				  'aTargets': [0]
			  }]
		  });
	  }
	  
	  $('#tampilkan').click(function(){
		  var valid = true;
		  var city_code = $('#city_code').val();
		  
		  if(city_code == ''){
			  var valid = false;
			  alert('Kota/Kab belum dipilih');
		  }
		  
		  if(valid == true){
			  DTReload();
		  }
	  });


</script>
<!-- END JAVASCRIPTS -->


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
      <div class="caption"><i class="icon-globe"></i>Rekap Outstanding Piutang</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body">
      <div class="clearfix">
         <div class="btn-group pull-right">
            <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right">
               <li><a href="#">Save as PDF</a></li>
               <li><a href="#">Export to Excel</a></li>
            </ul>
         </div>
            <!-- BEGIN FILTER-->
              <table id="sorting_saldo">
			  
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
                    <td style="padding-bottom:10px;" width="100">Filter By</td>
                    <td>

                      <select name="filter" id="filter" style="width:170px;">
                        <option value="">Pilih</option>
                        <option value="0">Cabang</option>
                        <option value="1">Rembug</option>
                        <option value="2">Petugas</option>
                        <!-- <option value="3">Nominal</option> -->
						<option value="3">Produk</option>
                        <option value="4">Peruntukan</option>
                        <option value="5">Sektor Usaha</option>
                      </select>
                    </td>
                 </tr>
                
                <tr>
                  <td></td>
                  <td>
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

      // $(function(){
      //   filter = $("#filter").val();
      //   if (filter=='') 
      //     {            
      //       $("#r_cabang").hide();
      //     } 
      //   else
      //     {
      //       $("#r_cabang").show();
      //     };
      // });

      // $("#filter").change(function(){
      //   filter = $("#filter").val();
      //   if (filter=='') 
      //     {            
      //       $("#r_cabang").hide();
      //     } 
      //   else
      //     {
      //       $("#r_cabang").show();
      //     };
                    
      // });
      

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
      /*$("#export_pdf").live('click',function()
      {
        var cabang    = $("#cabang").val();
        var tanggal   = $("#tanggal").val();
        var tanggal2  = $("#tanggal2").val();
        window.open('<?php echo base_url();?>laporan_to_pdf/export_rekap_jatuh_tempo/'+tanggal+'/'+cabang);
      });*/

      //export PDF
      $("#previewpdf").click(function(e)
      {
        e.preventDefault();
        var cabang    = $("#cabang").val();

        var filter = $("#filter").val();
          if (filter=='0') 
          {            
              if(cabang=='0000' || cabang=='') 
              {            
                window.open('<?php echo site_url();?>laporan_to_pdf/export_rekap_outstanding_pembiayaan_semua_cabang/'+cabang);
              }        
              else
              {            
                window.open('<?php echo site_url();?>laporan_to_pdf/export_rekap_outstanding_pembiayaan_cabang/'+cabang);
              } 
          } 
          else if (filter=='1') 
          {
            window.open('<?php echo site_url();?>laporan_to_pdf/export_rekap_outstanding_pembiayaan_rembug/'+cabang);
          }
          else if (filter=='2') 
          {
            window.open('<?php echo site_url();?>laporan_to_pdf/export_rekap_outstanding_pembiayaan_petugas/'+cabang);
          }
          else if (filter=='3') 
          {
            window.open('<?php echo site_url();?>laporan_to_pdf/export_rekap_outstanding_pembiayaan_produk/'+cabang);
          }
          else if (filter=='4') 
          {
            window.open('<?php echo site_url();?>laporan_to_pdf/export_rekap_outstanding_pembiayaan_peruntukan/'+cabang);
          }
          else if (filter=='5') 
          {
            window.open('<?php echo site_url();?>laporan_to_pdf/export_rekap_outstanding_pembiayaan_sektor_usaha/'+cabang);
          }
          else
          {
            alert("Parameter Kosong");
          }
        
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
                window.open('<?php echo site_url();?>laporan_to_excel/export_rekap_outstanding_pembiayaan_semua_cabang/'+cabang);
              }        
              else
              {            
                window.open('<?php echo site_url();?>laporan_to_excel/export_rekap_outstanding_pembiayaan_cabang/'+cabang);
              } 
          } 
          else if (filter=='1') 
          {
            window.open('<?php echo site_url();?>laporan_to_excel/export_rekap_outstanding_pembiayaan_rembug/'+cabang);
          }
          else if (filter=='2') 
          {
            window.open('<?php echo site_url();?>laporan_to_excel/export_rekap_outstanding_pembiayaan_petugas/'+cabang);
          }
          else if (filter=='3') 
          {
            window.open('<?php echo site_url();?>laporan_to_excel/export_rekap_outstanding_pembiayaan_produk/'+cabang);
          }
          else if (filter=='4') 
          {
            window.open('<?php echo site_url();?>laporan_to_excel/export_rekap_outstanding_pembiayaan_peruntukan/'+cabang);
          }
          else if (filter=='5') 
          {
            window.open('<?php echo site_url();?>laporan_to_excel/export_rekap_outstanding_pembiayaan_sektor_usaha/'+cabang);
          }
          else
          {
            alert("Parameter Kosong");
          }
        
      });


</script>
<!-- END JAVASCRIPTS -->


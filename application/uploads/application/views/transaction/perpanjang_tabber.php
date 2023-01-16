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
      Transaction <small>Registrasi Perpanjang Tabber </small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Transaction</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Registrasi Perpanjangan Tabber</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->





<!-- BEGIN ADD USER -->
<div id="add" class="">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Registrasi Perpanjangan Tabber</div>
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
               New Account Savings has been Created !
            </div>
            </br>
                     <div class="control-group">
              <label class="control-label">No Rekening<span class="required">*</span></label>
              <div class="controls">
                 <input type="text" name="account_saving_no" readonly="" id="account_saving_no" data-required="1" class="medium m-wrap" style="background-color:#eee;"/>
                 <input type="hidden" id="branch_code" name="branch_code">
                 <input type="hidden" id="cif_no" name="cif_no">
                 
                 <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                    <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                       <h3>Cari CIF</h3>
                    </div>
                    <div class="modal-body">
                       <div class="row-fluid">
                          <div class="span12">

                            <h4>Masukan Kata Kunci</h4>
                            <?php
                            if($this->session->userdata('cif_type')==0){
                            ?>
                              <input type="hidden" id="cif_type" name="cif_type" value="0">
                              <p id="pcm" style="height:32px">
                              <select id="cm" class="span12 m-wrap chosen" style="width:530px !important;">
                              <option value="">Pilih Rembug</option>
                              <?php foreach($rembugs as $rembug): ?>
                              <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
                              <?php endforeach; ?>;
                              </select></p>
                            <?php
                            }else if($this->session->userdata('cif_type')==1){
                              echo '<input type="hidden" id="cif_type" name="cif_type" value="1">';
                            }else{
                            ?>
                              <p><select name="cif_type" id="cif_type" class="span12 m-wrap">
                              <option value="">Pilih Tipe CIF</option>
                              <option value="">All</option>
                              <option value="1">Individu</option>
                              <option value="0">Kelompok</option>
                              </select></p>
                              <p class="hide" id="pcm" style="height:32px">
                              <select id="cm" class="span12 m-wrap chosen" style="width:530px !important;">
                              <option value="">Pilih Rembug</option>
                              <?php foreach($rembugs as $rembug): ?>
                              <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
                              <?php endforeach; ?>;
                              </select></p>
                            <?php
                            }
                            ?>
                            <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                            <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
                            <!-- 
                             <h4>Masukan Kata Kunci</h4>
                             <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                             <p><select name="cif_type" id="cif_type" class="span12 m-wrap">
                             <option value="">Pilih Tipe CIF</option>
                             <option value="">All</option>
                             <option value="1">Individu</option>
                             <option value="0">Kelompok</option>
                             </select></p>  
                             <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p> -->
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
                       <label class="control-label">Nama Lengkap</label>
                       <div class="controls">
                          <input type="text" name="nama" id="nama" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Majlis</label>
                       <div class="controls">
                          <input type="text" name="majlis" id="majlis" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Nama Panggilan</label>
                       <div class="controls">
                          <input type="text" name="panggilan" id="panggilan" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                       
                    <div class="control-group">
                       <label class="control-label">Nama Ibu Kandung</label>
                       <div class="controls">
                          <input type="text" name="ibu_kandung" id="ibu_kandung" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                    
                    <div class="control-group">
                       <label class="control-label">Tempat Lahir</label>
                       <div class="controls">
                          <input type="text" name="tmp_lahir" id="tmp_lahir" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                 
                    <div class="control-group">
                       <label class="control-label">Tanggal Lahir</label>
                       <div class="controls">
                          <input type="text" name="tgl_lahir" id="tgl_lahir" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                
                    <div class="control-group">
                       <label class="control-label">Produk<span class="required">*</span></label>
                       <div class="controls">
                       <input type="text" class="medium m-wrap" readonly="" id="product" name="product" style="background-color:#eee;" >
                       <input type="hidden" class="medium m-wrap" readonly="" id="product_code" name="product_code" >
                         <!-- <select name="product" id="product" class="m-wrap" data-required="1">  
                            <option value="">PILIH</option>
                          </select> -->
                       </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label">Biaya Administrasi <span class="required">*</span></label>
                      <div class="controls">
                        <div class="input-preppend input-append">
                          <div class="add-on">Rp</div>
                          <input type="text" class="mask-money m-wrap small" readonly="" id="biaya_administrasi" name="biaya_administrasi" style="background-color:#eee;" >
                          <div class="add-on">,00</div>
                        </div>
                      </div>
                    </div>
                    <!-- <div class="control-group">
                       <label class="control-label">No. Rekening</label>
                       <div class="controls">
                          <input type="text" name="account_saving_no" id="account_saving_no" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div> --> 
                    <hr> 
                  <div id="tabungan_berencana">   
                    <div class="control-group">
                       <label class="control-label" style="text-decoration:underline">Tabungan Berencana</label>
                    </div>     
                    <div class="control-group">
                       <label class="control-label">Setoran<span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" name="rencana_setoran" style="width:120px; background-color:#eee;" id="rencana_setoran" data-required="1" readonly="" class="m-wrap mask-money" maxlength="10"/>
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Periode Setoran<span class="required">*</span></label>
                       <div class="controls">
                          <select id="rencana_periode_setoran" name="rencana_periode_setoran" class="m-wrap" data-required="1" style="width:120px;background-color:#f5f5f5;" readonly="" >
                              <option value="0" disabled>Bulanan</option>
                              <option value="1" disabled>Mingguan</option>
                              <option value="2" disabled>Harian</option>
                          </select>
                          <!-- <input type="text" name="rencana_periode_setoran" id="rencana_periode_setoran" style="width:120px;background-color:#eee;"  data-required="1" class="m-wrap"  readonly="" /> -->
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="rencana_jangka_waktu" style="width:50px;background-color:#eee;" id="rencana_jangka_waktu" data-required="1" class="m-wrap"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="3" readonly="" />
                           <input type="hidden" name="counter_angsruan"  style="width:50px;background-color:#eee;" id="counter_angsruan" data-required="1" class="m-wrap" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="3" />
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Rencana Awal Setoran<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="rencana_setoran_next" id="rencana_setoran_next" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                          <!-- <input type="text" name="rencana_setoran_next" style="width:120px;" id="rencana_setoran_next" data-required="1" class="date-picker small m-wrap"/> -->
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Tanggal Pembukaan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_pembukaan" id="tanggal_pembukaan" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                          <!-- <input type="text" name="tanggal_pembukaan" style="width:120px;" id="tanggal_pembukaan" data-required="1" class="date-picker small m-wrap" value="<?php echo $current_date?>" /> -->
                       </div>
                    </div> 
                    <!-- <div class="control-group">
                       <label class="control-label">Tanggal Jtempo</label>
                       <div class="controls">
                          <input type="text" name="tanggal_jtempo" id="tanggal_jtempo" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                          <input type="text" name="tanggal_jtempo" style="width:120px;background-color:#f5f5f5;" readonly="" id="tanggal_jtempo" class="small m-wrap" />
                       </div>
                    </div> --> 
                  </div>
                  <hr>
                  <!-- START PERPANJANGAN TABBER -->
                  <div id="tabungan_berencana2">   
                    <div class="control-group">
                       <label class="control-label" style="text-decoration:underline">Perpanjang Tabber</label>
                    </div>     
                    <!-- <div class="control-group">
                       <label class="control-label">Setoran<span class="required">*</span></label>
                       <div class="controls">
                          <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" name="rencana_setoran2" style="width:120px;" id="rencana_setoran2" data-required="1" class="m-wrap mask-money" maxlength="10"/>
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div> -->   
                    <!-- <div class="control-group">
                       <label class="control-label">Periode Setoran<span class="required">*</span></label>
                       <div class="controls">
                          <select id="rencana_periode_setoran2" readonly="" name="rencana_periode_setoran2" style="width:120px;background-color:#f5f5f5;" class="m-wrap" data-required="1" >                     
                              <option value="0">Bulanan</option>
                              <option value="1">Mingguan</option>
                              <option value="2">Harian</option>
                          </select>
                       </div>
                    </div> -->  
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="rencana_jangka_waktu2"  style="width:50px;" id="rencana_jangka_waktu2" data-required="1" class="m-wrap" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="3" />

                       </div>
                    </div>  
                    <!-- <div class="control-group">
                       <label class="control-label">Rencana Awal Setoran<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="rencana_setoran_next2" id="rencana_setoran_next2" data-required="1" class="date-picker medium m-wrap"/>
                       </div>
                    </div> --> 
                    <div class="control-group">
                       <label class="control-label">Tanggal Perpanjangan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_perpanjangan" style="width:120px;" id="tanggal_perpanjangan" data-required="1" class="date-picker small m-wrap"/>
                       </div>
                    </div> 
                    <!-- <div class="control-group">
                       <label class="control-label">Tanggal Jtempo</label>
                       <div class="controls">
                          <input type="text" name="tanggal_jtempo2" style="width:120px;background-color:#f5f5f5;" readonly="" id="tanggal_jtempo2" class="small m-wrap"/>
                       </div>
                    </div> --> 
                  </div>
                  <!-- END PERPANJANGAN TABBER -->
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
    
      $("#tgl_lahir").inputmask("y/m/d", {autoUnmask: true});  //direct mask
      //$("#rencana_setoran_next").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("#rencana_setoran_next2").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("#tanggal_pembukaan").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("#tanggal_perpanjangan").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      //$("#rencana_setoran_next").inputmask("d/m/y", {autoUnmask: true});
      $("#tanggal_jtempo").inputmask("d/m/y", {autoUnmask: true});

   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->

<script type="text/javascript">
      

     
// fungsi untuk mencari account_saving_no
      $(function(){

      function generate_jtempo2()
      {
        periode_setoran = $("#rencana_periode_setoran2","#form_add").val();
        jangka_waktu = $("#rencana_jangka_waktu2","#form_add").val();
        setoran_next = $("#rencana_setoran_next2","#form_add").val();
        // alert(periode_setoran+'|'+jangka_waktu+'|'+setoran_next)
        if(periode_setoran!='' && jangka_waktu!='' && setoran_next!=''){
          $.ajax({
            type: "POST",
            url: site_url+"rekening_nasabah/generate_jtempo",
            dataType: "html",
            data: {
               periode_setoran : periode_setoran
              ,jangka_waktu : jangka_waktu
              ,setoran_next : setoran_next
            },
            success: function(response){
              $("#tanggal_jtempo2","#form_add").val(response);
            },
            error:function(){
              alert("Terjadi kesalahan, harap hubungi IT Support")
            }
          });
        }
      }

      $("#rencana_periode_setoran2","#form_add").change(function(){
        generate_jtempo2();
      })
      $("#rencana_jangka_waktu2","#form_add").change(function(){
        generate_jtempo2();
      })
      $("#rencana_setoran_next2","#form_add").change(function(){
        generate_jtempo2();
      })

        $("#keyword").on('keypress',function(e){
          if(e.which==13){
            type = $("#cif_type","#form_add").val();
            cm_code = $("select#cm").val();
            if(type=="0"){
              $("p#pcm").show();
            }else{
              $("p#pcm").hide().val('');
            }
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_account_no",
              data: {keyword:$(this).val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              async: false,
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_saving_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_saving_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_saving_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_saving_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].account_saving_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_saving_no+''+cm_name+'</option>';
                  }
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
            return false;
          }
        });
        
        $("select#cm").on('change',function(e){
          type = $("#cif_type","#form_add").val();
          cm_code = $(this).val();

            $.ajax({
              type: "POST",
              url: site_url+"cif/search_account_no",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_saving_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_saving_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_saving_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_saving_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].account_saving_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_saving_no+''+cm_name+'</option>';
                  }
                }
                // console.log(option);
                $("#result").html(option);
              }
            });

          if(cm_code=="")
          {
            $("#result").html('');
          }
        });
      
        $("#select").click(function(){
            var no_rekening = $("#result").val();
            $("#close","#dialog_rembug").trigger('click');
            $("#account_saving_no").val(no_rekening);
            var account_saving_no = no_rekening;
            $.ajax({
              type: "POST",
              dataType: "json",
              data: {account_saving_no:account_saving_no},
              url: site_url+"rekening_nasabah/get_value",
              success: function(response){
               
                $("#form_add input[name='account_saving_id']").val(response.account_saving_id);
                $("#nama").val(response.nama);
                $("#product").val(response.product_name);
                $("#product_code").val(response.product_code);
                $("#branch_code").val(response.branch_code);
                $("#cif_no").val(response.cif_no);
                $("#majlis").val(response.majlis);
                $("#panggilan").val(response.panggilan);
                $("#ibu_kandung").val(response.ibu_kandung);
                $("#tmp_lahir").val(response.tmp_lahir);
                $("#tgl_lahir").val(response.tgl_lahir);
                $("#alamat").val(response.alamat);
                $("#rt_rw").val(response.rt_rw);
                $("#desa").val(response.desa);
                $("#kecamatan").val(response.kecamatan);
                $("#kabupaten").val(response.kabupaten);
                $("#kodepos").val(response.kodepos);
                $("#telpon_rumah").val(response.telpon_rumah);
                $("#telpon_seluler").val(response.telpon_seluler);
                $("#account_type").val(response.cif_type);
                $("#biaya_administrasi").val(response.biaya_administrasi);

                $("#rencana_setoran").val(response.rencana_setoran);
                $("#rencana_periode_setoran").val(response.rencana_periode_setoran);


                $("#rencana_jangka_waktu").val(response.rencana_jangka_waktu);
                $("#counter_angsruan").val(response.counter_angsruan);
                $("#rencana_setoran_next").val(response.rencana_setoran_next);
                $("#tanggal_pembukaan").val(response.tanggal_buka);
                $("#tanggal_jtempo").val(response.tanggal_jtempo);

                       
              }
            }); 
        });
        
        $("#result option").live('dblclick',function(){
          $("#select").trigger('click');

        });

      });


  // BEGIN FORM EDIT VALIDATION
  var form2 = $('#form_add');
  var error2 = $('.alert-error', form2);
  var success2 = $('.alert-success', form2);

  form2.validate({
      errorElement: 'span', //default input error message container
      errorClass: 'help-inline', // default input error message class
      focusInvalid: false, // do not focus the last invalid input
      // ignore: "",
      errorPlacement: function(error, element) {
        element.closest('.controls').append(error);
      },
      rules: {
          rencana_jangka_waktu2: {
            required: true
          },
          tanggal_perpanjangan: {
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
        if(label.closest('.input-append').length==0)
        {
          label
              .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
          .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
        }
        else
        {
           label.closest('.control-group').removeClass('error').addClass('success')
           label.remove();
        }
      },

      submitHandler: function (form) {
        // var product_code = $("#product2 option:selected",form2).val();
        // var product_name = $("#product2 option:selected",form2).attr('product_name_attr');
        // var cif_no = $("#cif_no2",form2).val();
        // var nama = $("#nama2",form2).val();
        // var account_saving_no = $("#account_saving_no2",form2).val();
        // var account_saving_id = $("#account_saving_no2",form2).val();
        var rencana_jangka_waktu2 = $("#rencana_jangka_waktu2",form2).val();
        // product_code:product_code,cif_no:cif_no,nama:nama,account_saving_no:account_saving_no,product_name:product_name,branch_code:branch_code
        $.ajax({
                type: "POST",
                url: site_url+"transaction/do_perpanjang_tabber",
                async: false,
                data:{rencana_jangka_waktu2:rencana_jangka_waktu2},
                dataType: "json",
                data: form2.serialize(),
                success: function(response){
                  if(response.success==true){
                    alert(response.message);
                    success2.show();
                    error2.hide();
                    form2.children('div').removeClass('success');
                    $("#rekening_tabungan_table_filter input").val('');
                    dTreload();
                    $("#cancel",form_edit).trigger('click')
                    alert('Successfully Updated Data');
                  }else{
                    alert(response.message);
                    success2.hide();
                    error2.show();
                  }
                  App.scrollTo(error2, -200);
                },
                error:function(){
                    success2.hide();
                    error2.show();
                    App.scrollTo(error2, -200);
                }
        });
      }
});
//  END FORM EDIT VALIDATION




</script>



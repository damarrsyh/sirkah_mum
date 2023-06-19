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
			Update Sumber Dana Pembiayaan 
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('dashboard'); ?>">Home</a> 
				<i class="icon-angle-right"></i>
			</li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>
         <li><a href="#">Pembiayaan</a><i class="icon-angle-right"></i></li>
			   <li><a href="#">Update Sumber Dana Pembiayaan</a></li>	
		</ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

          <div id="dialog_src_account_financing_no" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
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
                   </div>
                </div>
             </div>
             <div class="modal-footer">
                <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
                <button type="button" id="select" class="btn blue">Select</button>
             </div>
          </div>

<div id="add">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Update Sumber Dana Pembiayaan </div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" method="post" enctype="multipart/form-data" id="form_act" class="form-horizontal">
                 <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Update Sumber Dana Berhasil!
            </div>
            <br>
            <input type="hidden" id="jml_angsuran" name="jml_angsuran">
            <input type="hidden" id="flag_jadwal_angsuran" name="flag_jadwal_angsuran">
            <div class="control-group">
               <label class="control-label">No. Pembiayaan<span class="required">*</span></label>
                  <div class="controls">
                     <input type="text" name="account_financing_no" id="account_financing_no" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                     <a id="browse_account_financing_no" class="btn blue" data-toggle="modal" href="#dialog_src_account_financing_no">...</a>
                  </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Lengkap</label>
               <div class="controls">
                  <input name="nama" id="nama" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Rembug</label>
               <div class="controls">
                  <input name="cm_name" id="cm_name" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>


            <table width="100%" cellpadding="10" style="border:solid 1px #CCC;margin-bottom:10px;">
              
              <tr>
                <td width="50%" valign="top">
                  <fieldset> 

                    <div class="control-group">
                       <label class="control-label">Pokok</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="pokok" id="pokok" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                     
                    <div class="control-group">
                       <label class="control-label">Margin</label>
                       <div class="controls">
                        <div class="input-prepend input-append">
                          <div class="add-on">Rp</div>
                            <input name="margin" id="margin" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                          <div class="add-on">.00</div>
                        </div>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu</label>
                       <div class="controls">
                          <input name="jangka_waktu" id="jangka_waktu" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:30px;"/>
                          <select id="periode_jangka_waktu" name="periode_jangka_waktu" class="m-wrap small" readonly="readonly" style="background-color:#eee;">
                            <option value="">PILIH</option>
                            <option value="0">Harian</option>
                            <option value="1">Mingguan</option>
                            <option value="2">Bulanan</option>
                            <option value="3">Jatuh Tempo</option>
                          </select>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Tgl.Droping</label>
                       <div class="controls">
                          <input name="tanggal_droping" id="tanggal_droping" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Tgl.Angs 1</label>
                       <div class="controls">
                          <input name="tanggal_mulai_angsur" id="tanggal_mulai_angsur" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Tgl.Jatuh Tempo</label>
                       <div class="controls">
                          <input name="tanggal_jtempo" id="tanggal_jtempo" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
                       </div>
                    </div>

                    <div class="angsuran_reguler1">
                      <div class="control-group">
                         <label class="control-label">Angs. Pokok</label>
                         <div class="controls">
                          <div class="input-prepend input-append">
                            <div class="add-on">Rp</div>
                              <input name="angsuran_pokok" id="angsuran_pokok" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                            <div class="add-on">.00</div>
                          </div>
                         </div>
                      </div>
                      <div class="control-group">
                         <label class="control-label">Angs. Margin</label>
                         <div class="controls">
                          <div class="input-prepend input-append">
                            <div class="add-on">Rp</div>
                              <input name="angsuran_margin" id="angsuran_margin" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                            <div class="add-on">.00</div>
                          </div>
                         </div>
                      </div>
                      <div class="control-group">
                         <label class="control-label">Total Angsuran</label>
                         <div class="controls">
                          <div class="input-prepend input-append">
                            <div class="add-on">Rp</div>
                              <input name="totalangsuran" id="totalangsuran" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                            <div class="add-on">.00</div>
                          </div>
                         </div>
                      </div>

                      <hr size="1"> 
                      <div class="control-group">
                          <label class="control-label">Produk Sebelumnya</label>
                           <div class="controls">
                              <input name="product_name" id="product_name" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                           </div>
                      </div>
                      <div class="control-group">
                          <label class="control-label">Sumber Dana Sblm</label>
                           <div class="controls">
                              <input name="kreditur" id="kreditur" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                           </div>
                      </div>

                      <div class="control-group">
                       <label class="control-label"> Produk Baru </label>
                         <div class="controls">
                          <select name="product_code_n" id="product_code_n" class="m-warp large chosen">
                            <option value="">Silahkan Pilih</option>
                            <?php foreach($produk as $produks): ?>
                            <option value="<?php echo $produks['product_code'] ?>"><?php echo $produks['product_name']; ?></option>
                            <?php endforeach; ?>
                          </select>
                       </div>
                      </div> 

                      <div class="control-group">
                       <label class="control-label"> Sumber Dana Baru </label>
                         <div class="controls">
                          <select name="kreditur_code_n" id="kreditur_code_n" class="m-warp large chosen">
                            <option value="">Silahkan Pilih</option>
                            <?php foreach($kreditur as $krediturs): ?>
                            <option value="<?php echo $krediturs['code_value'] ?>"><?php echo $krediturs['display_text']; ?></option>
                            <?php endforeach; ?>
                          </select>
                       </div>
                      </div>

                    </div>
                  </fieldset>
                </td>

              </tr>
              <tr>
                <td colspan="2">
                  <table class="table table-bordered" id="table_non_reguler" style="display:none;">
                    <thead>
                      <tr>
                        <th style="background:#f5f5f5">Tanggal Jtempo</th>
                        <th style="background:#f5f5f5">Angsuran Pokok</th>
                        <th style="background:#f5f5f5">Angsuran Margin</th>
                        <th style="background:#f5f5f5">Angsuran Tabungan</th>
                        <th style="background:#f5f5f5" colspan="2">Modify</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td style="background:#E8EEF8;text-align:center;">
                          <input type="text" class=" m-wrap date-mask" id="dsch_tgl_jtempo" placeholder="dd/mm/yyyy" style="background:#fff;">
                        </td>
                        <td style="background:#E8EEF8;text-align:center;">
                          <input type="text" class=" m-wrap mask-money" id="dsch_angsuran_pokok" maxlength="10" value="0" style="background:#fff;">
                        </td>
                        <td style="background:#E8EEF8;text-align:center;">
                          <input type="text" class=" m-wrap mask-money" id="dsch_angsuran_margin" maxlength="10" value="0" style="background:#fff;">
                        </td>
                        <td style="background:#E8EEF8;text-align:center;">
                          <input type="text" class=" m-wrap mask-money" id="dsch_angsuran_tabungan" maxlength="10" value="0" style="background:#fff;">
                        </td>
                        <td style="background:#E8EEF8;vertical-align:middle;text-align:center;">
                          <a href="javascript:void(0);" id="dsch_add"><img src="<?php echo base_url('assets/img/yes.png'); ?>"></a>
                        </td>
                        <td style="background:#E8EEF8;vertical-align:middle;text-align:center;">
                          <a href="javascript:void(0);" id="dsch_remove"><img src="<?php echo base_url('assets/img/cancel.png'); ?>" width="26"></a>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </td>
              </tr>
            </table>
            <div class="form-actions">
               <button type="button" class="btn green" id="koreksi" style="float:left;">Update Sumber Dana</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END ADD REMBUG -->

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
    
      $(".date-mask").livequery(function(){
        $(this).inputmask("d/m/y");
      });
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
$(function(){
var flag_jadwal_angsuran = '1';
  $("#browse_account_financing_no").click(function(e){
    e.preventDefault();
    setTimeout(function(){
      $("#keyword","#dialog_src_account_financing_no").focus();
    },600)
  });

        $("#cm").change(function(){
          type = $("#cif_type").val();
          cm_code = $("select#cm").val();
          if(type=="0"){
            $("p#pcm").show();
          }else{
            $("p#pcm").hide().val('');
          }

            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/search_account_financing_no",
              data: {keyword:$("#keyword").val(),cm_code:cm_code,status_rekening:1},
              dataType: "json",
              success: function(response){
                var opt = '';
                for(i = 0 ; i < response.length ; i++){
                  if(response[i].status_rekening == 0){
                    var status_rekening = 'Baru Registrasi';
                  } else if(response[i].status_rekening == 1){
                    var status_rekening = 'Aktif';
                  } else if(response[i].status_rekening == 2){
                    var status_rekening = 'Lunas';
                  } else {
                    var status_rekening = 'Verified';
                  }
                  //option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].account_financing_no+' - '+response[i].nama+' - '+status_rekening+'</option>';
				          opt += '<option value="'+response[i].account_financing_no+'" is_avaible_to_correct="'+response[i].is_avaible_to_correct+'" nama="'+response[i].nama+'" cm_name="'+response[i].cm_name+'" tanggal_akad="'+response[i].tanggal_akad+'" tanggal_mulai_angsur="'+response[i].tanggal_mulai_angsur+'" tanggal_jtempo="'+response[i].tanggal_jtempo+'" pokok="'+response[i].pokok+'" margin="'+response[i].margin+'" jangka_waktu="'+response[i].jangka_waktu+'" periode_jangka_waktu="'+response[i].periode_jangka_waktu+'" angsuran_pokok="'+response[i].angsuran_pokok+'" angsuran_margin="'+response[i].angsuran_margin+'" angsuran_catab="'+response[i].angsuran_catab+'" product_name="'+response[i].product_name+'" kreditur="'+response[i].kreditur+'" fa_code="'+response[i].fa_code+'" registration_no="'+response[i].registration_no+'" flag_jadwal_angsuran="'+response[i].flag_jadwal_angsuran+'" financing_type="'+response[i].financing_type+'">'+response[i].account_financing_no+' - '+response[i].nama+' - '+status_rekening+'</option>';
                }
                // console.log(option);
                $("#result").html(opt);
              }
            });

        });

  $("#keyword","#dialog_src_account_financing_no").keypress(function(e){
    if(e.keyCode==13){
      e.preventDefault();
      $.ajax({
        type:"POST",
        dataType:"json",
        //data:{keyword:$(this).val(),status_rekening:1},
		data: {keyword:$("#keyword").val(),cm_code:cm_code,status_rekening:1},
        url:site_url+"rekening_nasabah/search_account_financing_no",
		//url: site_url+"cif/search_no_pembiayaan",
        success:function(response){
          var opt = '';
          for(i=0;i<response.length;i++){
			  if(response[i].status_rekening == 0){
				var status_rekening = 'Baru Registrasi';
			  } else if(response[i].status_rekening == 1){
				var status_rekening = 'Aktif';
			  } else if(response[i].status_rekening == 2){
				var status_rekening = 'Lunas';
			  } else {
				var status_rekening = 'Verified';
			  }
        opt += '<option value="'+response[i].account_financing_no+'" is_avaible_to_correct="'+response[i].is_avaible_to_correct+'" nama="'+response[i].nama+'" cm_name="'+response[i].cm_name+'" tanggal_akad="'+response[i].tanggal_akad+'" tanggal_mulai_angsur="'+response[i].tanggal_mulai_angsur+'" tanggal_jtempo="'+response[i].tanggal_jtempo+'" pokok="'+response[i].pokok+'" margin="'+response[i].margin+'" jangka_waktu="'+response[i].jangka_waktu+'" periode_jangka_waktu="'+response[i].periode_jangka_waktu+'" angsuran_pokok="'+response[i].angsuran_pokok+'" angsuran_margin="'+response[i].angsuran_margin+'" angsuran_catab="'+response[i].angsuran_catab+'" product_name="'+response[i].product_name+'" kreditur="'+response[i].kreditur+'" fa_code="'+response[i].fa_code+'" registration_no="'+response[i].registration_no+'" flag_jadwal_angsuran="'+response[i].flag_jadwal_angsuran+'" financing_type="'+response[i].financing_type+'">'+response[i].account_financing_no+' - '+response[i].nama+' - '+status_rekening+'</option>';
          }
          $("#result","#dialog_src_account_financing_no").html(opt);
        },
        error:function(){
          alert("Something wrong when searching account. Please contact administrator!");
        }
      });
    }
  });

  $("#result","#dialog_src_account_financing_no").dblclick(function(e){
    if($(this).val()!=""){
      $("#select","#dialog_src_account_financing_no").trigger('click');
    }
  })

  $("#select","#dialog_src_account_financing_no").click(function(e){
    e.preventDefault();
    $("#close","#dialog_src_account_financing_no").trigger('click');
    res = $("#result","#dialog_src_account_financing_no");
    opt_res = res.find('option:selected');
    account_financing_no=res.val();
    nama=opt_res.attr('nama');
    cm_name=opt_res.attr('cm_name');
    tanggal_akad=opt_res.attr('tanggal_akad');
    tanggal_mulai_angsur=opt_res.attr('tanggal_mulai_angsur');
    tanggal_jtempo=opt_res.attr('tanggal_jtempo');
    pokok=opt_res.attr('pokok');
    margin=opt_res.attr('margin');
    jangka_waktu=opt_res.attr('jangka_waktu');
    periode_jangka_waktu=opt_res.attr('periode_jangka_waktu');
    angsuran_pokok=opt_res.attr('angsuran_pokok');
    angsuran_margin=opt_res.attr('angsuran_margin');
    product_name=opt_res.attr('product_name');
    kreditur=opt_res.attr('kreditur');
    //------------------------------- new

    angsuran_catab=opt_res.attr('angsuran_catab'); 
    fa_code=opt_res.attr('fa_code');
    registration_no=opt_res.attr('registration_no');
	  financing_type=opt_res.attr('financing_type');

    /*convert_tanggal_akad*/
    ta=tanggal_akad.split('-');
    tanggal_akad=ta[2]+'/'+ta[1]+'/'+ta[0];
    /*convert_tanggal_mulai_angsur*/
    ta=tanggal_mulai_angsur.split('-');
    tanggal_mulai_angsur=ta[2]+'/'+ta[1]+'/'+ta[0];
    /*convert_tanggal_jtempo*/
    ta=tanggal_jtempo.split('-');
    tanggal_jtempo=ta[2]+'/'+ta[1]+'/'+ta[0];

    v_flag_jadwal_angsuran = flag_jadwal_angsuran;
    if (flag_jadwal_angsuran=='0') { // non reguler
      $('.angsuran_reguler1').hide();
      $('.angsuran_reguler2').hide();
      $('#table_non_reguler').show();
    } else { // reguler
      $('.angsuran_reguler1').show();
      $('.angsuran_reguler2').show();
      $('#table_non_reguler').hide();
      $('#table_non_reguler tbody').html('');
    }
    $("#account_financing_no").val(account_financing_no);
    $("#nama").val(nama);
    $("#cm_name").val(cm_name);
    $("#flag_jadwal_angsuran").val(flag_jadwal_angsuran);
    $("#tanggal_droping,#tanggal_droping2").val(tanggal_akad);
    $("#tanggal_mulai_angsur,#tanggal_mulai_angsur2").val(tanggal_mulai_angsur);
    $("#tanggal_jtempo,#tanggal_jtempo2").val(tanggal_jtempo);
    $("#pokok,#pokok2").val(number_format(pokok,0,',','.'));
    $("#margin,#margin2").val(number_format(margin,0,',','.'));
    $("#jangka_waktu,#jangka_waktu2").val(jangka_waktu);
    $("#periode_jangka_waktu,#periode_jangka_waktu2").val(periode_jangka_waktu);
    $("#angsuran_pokok,#angsuran_pokok2").val(number_format(angsuran_pokok,0,',','.'));
    $("#angsuran_margin,#angsuran_margin2").val(number_format(angsuran_margin,0,',','.'));
    $("#product_name").val(product_name); 
    $("#kreditur").val(kreditur);
	  $("#financing_type").val(financing_type);
    //------------------------------- new

    $("#angsurancatab,#angsurancatab2").val(number_format(angsuran_catab,0,',','.'));
    $("#fa_code_o,#facodeo,#fa_code_n").val(fa_code).trigger('liszt:updated');
    $("#registration_no").val(registration_no);

    /*calculate total angsuran*/
    totalangsuran=parseFloat(angsuran_pokok)+parseFloat(angsuran_margin)+parseFloat(angsuran_catab);
    $("#totalangsuran,#totalangsuran2").val(number_format(totalangsuran,0,',','.'));
    /*calculate total biaya adm*/

    if (flag_jadwal_angsuran=='0') {
      $('#table_non_reguler').show();
      $.ajax({
        type:"POST",dataType:"json",data:{
          account_financing_no:account_financing_no
        },url:site_url+'rekening_nasabah/get_koreksi_droping_financing_schedulle',
        success:function(response) {
          table = '';
          for ( x in response ) {
            if (response[x].tangga_jtempo!="") {
              jto = response[x].tangga_jtempo.split('-');
              tangga_jtempo = jto[2]+'/'+jto[1]+'/'+jto[0];
            } else {
              tangga_jtempo = '';
            }

            table += ' \
              <tr> \
                <td style="text-align:center;"> \
                  <input type="text" class="m-wrap date-mask" id="sch_tgl_jtempo" name="sch_tgl_jtempo[]" placeholder="dd/mm/yyyy" value="'+tangga_jtempo+'"> \
                </td> \
                <td style="text-align:center;"> \
                  <input type="text" class="m-wrap mask-money" id="sch_angsuran_pokok" name="sch_angsuran_pokok[]" maxlength="12" value="'+number_format(response[x].angsuran_pokok,0,',','.')+'"> \
                </td> \
                <td style="text-align:center;"> \
                  <input type="text" class="m-wrap mask-money" id="sch_angsuran_margin" name="sch_angsuran_margin[]" maxlength="12" value="'+number_format(response[x].angsuran_margin,0,',','.')+'"> \
                </td> \
                <td style="text-align:center;"> \
                  <input type="text" class="m-wrap mask-money" id="sch_angsuran_tabungan" name="sch_angsuran_tabungan[]" maxlength="12" value="'+number_format(response[x].angsuran_tabungan,0,',','.')+'"> \
                </td> \
                <td style="vertical-align:middle;text-align:center;"><a href="javascript:void(0);" id="sch_add"><img src="'+base_url+'assets/img/yes.png"></a></td> \
                <td style="vertical-align:middle;text-align:center;"><a href="javascript:void(0);" id="sch_remove"><img src="'+base_url+'assets/img/cancel.png" width="26"></a></td> \
              </tr> \
            ';
          }
          $("#table_non_reguler tbody").html(table)
        }
      })
    }
    
  });

  $('a#sch_add').livequery('click',function(){
    table = ' \
              <tr> \
                <td style="text-align:center;"> \
                  <input type="text" class="m-wrap date-mask" id="sch_tgl_jtempo" name="sch_tgl_jtempo[]" placeholder="dd/mm/yyyy" value="" style="background:#E8EEF8"> \
                </td> \
                <td style="text-align:center;"> \
                  <input type="text" class="m-wrap mask-money" id="sch_angsuran_pokok" name="sch_angsuran_pokok[]" maxlength="12" value="0" style="background:#E8EEF8"> \
                </td> \
                <td style="text-align:center;"> \
                  <input type="text" class="m-wrap mask-money" id="sch_angsuran_margin" name="sch_angsuran_margin[]" maxlength="12" value="0" style="background:#E8EEF8"> \
                </td> \
                <td style="text-align:center;"> \
                  <input type="text" class="m-wrap mask-money" id="sch_angsuran_tabungan" name="sch_angsuran_tabungan[]" maxlength="12" value="0" style="background:#E8EEF8"> \
                </td> \
                <td style="vertical-align:middle;text-align:center;"><a href="javascript:void(0);" id="sch_add"><img src="'+base_url+'assets/img/yes.png" width="25"></a></td> \
                <td style="vertical-align:middle;text-align:center;"><a href="javascript:void(0);" id="sch_remove"><img src="'+base_url+'assets/img/cancel.png" width="26"></a></td> \
              </tr> \
            ';
    $(this).closest('tr').after(table);
  }); 

  $('a#sch_remove').livequery('click',function(){
    $(this).closest('tr').remove();
  })

  $('#dsch_add').click(function(){
    var dsch_tgl_jtempo = $('#dsch_tgl_jtempo').val();
    var dsch_angsuran_pokok = $('#dsch_angsuran_pokok').val();
    var dsch_angsuran_margin = $('#dsch_angsuran_margin').val();
    var dsch_angsuran_tabungan = $('#dsch_angsuran_tabungan').val();
    if (dsch_tgl_jtempo!="" && dsch_angsuran_pokok!="" && dsch_angsuran_margin!="" && dsch_angsuran_tabungan!="") {
      table = ' \
                <tr> \
                  <td style="text-align:center;"> \
                    <input type="text" class="m-wrap date-mask" id="sch_tgl_jtempo" name="sch_tgl_jtempo[]" placeholder="dd/mm/yyyy" value="'+dsch_tgl_jtempo+'" style="background:#E8EEF8"> \
                  </td> \
                  <td style="text-align:center;"> \
                    <input type="text" class="m-wrap" id="sch_angsuran_pokok" name="sch_angsuran_pokok[]" maxlength="12" value="'+dsch_angsuran_pokok+'" style="background:#E8EEF8;text-align:right;"> \
                  </td> \
                  <td style="text-align:center;"> \
                    <input type="text" class="m-wrap" id="sch_angsuran_margin" name="sch_angsuran_margin[]" maxlength="12" value="'+dsch_angsuran_margin+'" style="background:#E8EEF8;text-align:right;"> \
                  </td> \
                  <td style="text-align:center;"> \
                    <input type="text" class="m-wrap" id="sch_angsuran_tabungan" name="sch_angsuran_tabungan[]" maxlength="12" value="'+dsch_angsuran_tabungan+'" style="background:#E8EEF8;text-align:right;"> \
                  </td> \
                  <td style="vertical-align:middle;text-align:center;"><a href="javascript:void(0);" id="sch_add"><img src="'+base_url+'assets/img/yes.png"></a></td> \
                  <td style="vertical-align:middle;text-align:center;"><a href="javascript:void(0);" id="sch_remove"><img src="'+base_url+'assets/img/cancel.png" width="26"></a></td> \
                </tr> \
              ';
      $('#table_non_reguler tbody').append(table);
      $('#dsch_tgl_jtempo').val('');
      $('#dsch_angsuran_pokok').val('0');
      $('#dsch_angsuran_margin').val('0');
      $('#dsch_angsuran_tabungan').val('0');
    } else {
      alert('Mohon diisi Field yang kosong.')
    }
  })
  
  $('#dsch_remove').click(function(){
    $('#dsch_tgl_jtempo').val('').prop('');
    $('#dsch_angsuran_pokok').val('0').prop('0');
    $('#dsch_angsuran_margin').val('0').prop('0');
    $('#dsch_angsuran_tabungan').val('0').prop('0');
  })


  /*UP UNTUK FUNGSI ADD ENTER*/
  $("input,select").live('keypress',function(e){

    if(e.keyCode==13)
    {
     e.preventDefault();
      if($(this).next().prop('tagName')=='SELECT' || $(this).next().prop('tagName')=='INPUT')
      {
        $(this).next().focus();
      }
      else
      {

        if($(this).closest('.control-group').next('.form-actions').length==1){
          $(this).closest('.control-group').next('.form-actions').find('button:first').focus();
        }else{
          if(typeof($(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select').attr('readonly'))!='undefined'){
            $(this).closest('.control-group').nextAll('.control-group2:visible').filter(':first').find('input,select').focus();
          }else{
            $(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select').focus();
          }
        }
        
      }
    }
    
  });

  /* FORM ACTION */
  form=$("#form_act");
  $("#koreksi").click(function(e){
    e.preventDefault();
    account_financing_no = $("#account_financing_no");
    
    product_code_n = $("#product_code_n"); 
    kreditur_code_n = $("#kreditur_code_n"); 

    bValid=true;

    if(account_financing_no.val()==""){
      alert("Mohon pilih No.Pembiayaan terlebih dahulu!")
      bValid=false;
    }else{

      if(product_code_n.val()=="") { product_code_n.addClass('error'); bValid=false; } else { product_code_n.removeClass('error'); }

      if(kreditur_code_n.val()=="") { kreditur_code_n.addClass('error'); bValid=false; } else { kreditur_code_n.removeClass('error'); }  

      if(bValid==false){
        alert("Please entry an empty field!");
      }

    }

    if(bValid==true){

      var jml_angsuran = $("#jml_angsuran").val();

      var conf = confirm("Update Sumber Dana Pembiayaan ?");

        if(conf)
        {

            pValid=true;

            if (pValid==true) {
              $.ajax({
                type:"POST",
                dataType:"json",
                data:form.serialize(),
                url:site_url+"rekening_nasabah/proses_update_sumber_dana",
                async: false,
                success: function(response){
                  if(response.success===true){
                    alert("Update Sumber Dana SUKSES!");
					          window.location.reload(true);
                  }else{
                    alert("Something wrong when processing. Please contact your Adminstrator!");
                  }
                },
                error: function(){
                  alert("Something wrong when processing. Please contact your Adminstrator!");
                }
              });
            }
            
          // }

        }
        
      // } //end new 14-02-2015

    }

  })

});
</script>
<!-- END JAVASCRIPTS -->

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
        CHANNELING REPORT <small></small>
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

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>API Debitur</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body">
      <div class="clearfix">
         <!-- BEGIN FILTER FORM -->
         <form action="javascript:;" id="send_kreditur">
            <input type="hidden" name="branch" id="branch" value="<?php echo $this->session->userdata('branch_name'); ?>">
            <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code'); ?>">
            <input type="hidden" name="branch_class" id="branch_class" value="<?php echo $this->session->userdata('branch_class'); ?>">
            <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id'); ?>">
            <input name="fa_code" type="hidden" id="fa_code" value="00000" />
            <input name="cm_code" type="hidden" id="cm_code" value="00000" />
            <div class="alert alert-error hide">
                <button class="close" data-dismiss="alert"></button>
                <span id="span_message">You have some form errors. Please check below.</span>
            </div>
            <div class="alert alert-success hide">
                <button class="close" data-dismiss="alert"></button>
                New Account Financing has been Created !
            </div>
            <table id="filter-form" class="col-md-6">
               <tr>
                <td>Cabang</td>
                <td style="padding-left: 20px"><input type="text" name="branch" id="branch" class="medium m-wrap" readonly="" style="background:#eee;" value="<?php echo $this->session->userdata('branch_name'); ?>">
                <?php if($this->session->userdata('flag_all_branch')=='1'){ ?>
                <a id="browse_branch" class="btn blue" data-toggle="modal" href="#dialog_branch">...</a>
                <?php } ?></td>
               </tr>
               <tr>
                <td>Produk</td>
                <td style="padding-left: 20px"><select name="product" id="product" class="chosen m-wrap">
                  <option value="" selected="selected">Pilih</option>
                  <option value="00000">Semua</option>
                  <?php foreach($product as $produk): ?>
                  <option value="<?php echo $produk['product_code'] ?>"><?php echo $produk['product_name'] ?></option>
                  <?php endforeach; ?>
               </select></td>
               </tr>
               <tr>
                <td>Tanggal</td>
                <td style="padding-left: 20px"><input type="text" name="tanggal" id="tanggal" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" value="<?php echo $current_date; ?>" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                sd
                <input type="text" name="tanggal2" id="tanggal2" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" value="<?php echo $current_date; ?>" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"></td>
               </tr>
               <tr>
                <td>Kreditur Saat Ini</td>
                <td style="padding-left: 20px">   
                  <select name="kreditur_from" class="chosen m-wrap" id="kreditur_from">
                     <option value="" selected="selected">-- Pilih --</option>
                     <?php foreach($kreditur as $kredit){ ?>
                     <option value="<?php echo $kredit['code_value']; ?>"><?php echo $kredit['code_value'].' - '.$kredit['display_text']; ?></option>
                     <?php } ?>
                  </select>
                </td>
               </tr>
               <tr>
                <td>Kreditur Tujuan</td>
                <td style="padding-left: 20px">   
                  <select name="kreditur_thru" class="chosen m-wrap" id="kreditur_thru">
                     <option value="" selected="selected">-- Pilih --</option>
                     <?php foreach($kreditur as $kredit){ ?>
                     <option value="<?php echo $kredit['code_value']; ?>" group_bprs="<?php echo $kredit['display_sort']; ?>"><?php echo $kredit['code_value'].' - '.$kredit['display_text']; ?></option>
                     <?php } ?>
                  </select>
                  <input name="group_bprs" type="hidden" id="group_bprs">
                </td>
               </tr>
               <tr>
                <td>No. Batch</td>
                <td style="padding-left: 20px"><input type="text" name="batch_no" id="batch_no" class="medium m-wrap"></td>
               </tr>
               <tr>
                  <td>&nbsp;</td>
                  <td style="padding-left: 20px">
                  <button class="purple btn" id="show" type="button">Tampilkan</button>
                  <button class="green btn" id="proses" type="button">Proses</button>
                  </td>
               </tr>
            </table>
         </form>
         <div id="show_kreditur">
            <table id="list_kreditur"></table>
            <div id="page_list_kreditur"></div>
         </div>
      </div>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>   
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>        
<!-- END PAGE LEVEL SCRIPTS -->

<script type="text/javascript">
$(document).ready(function(){
   App.init();
   var form1 = $('#send_kreditur');
   var error1 = $('.alert-error', form1);
   var success1 = $('.alert-success', form1);

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
   });
   $("#result option:selected","#dialog_branch").live('dblclick',function(){
    $("#select","#dialog_branch").trigger('click');
   })
   /* END DIALOG ACTION BRANCH */

   $('#show_kreditur').hide();

   $("#show").click(function(){
      $('#show_kreditur').show();
      showup();
      $('#list_kreditur').trigger('reloadGrid');
   });

   $('#kreditur_thru').change(function(){
      var kreditur = $('#kreditur_thru option:selected').val();
      var group_bprs = $('#kreditur_thru option:selected').attr('group_bprs');
      var today = new Date();
      var year = today.getFullYear();
      var month = (today.getMonth()+1);
      var date = today.getDate();

      if(month > 0){
         if(month < 10){
            month = '0'+month;
         }
      }

      var batch_no = kreditur+''+year+''+month+''+date;

      $('#batch_no').val(batch_no);
      $('#group_bprs').val(group_bprs);
   })

   var showup = function(){
      $("#list_kreditur").jqGrid({
         url: site_url+'laporan/read_kreditur',
         datatype: 'json',
         height: '1000',
         rowNum: 1000,
         autowidth: true,
         shrinkToFit: false,
         rowList: [1000,2000,3000,4000,5000,6000,7000,8000],
         colNames:['ID','Cabang','Majelis','ID Anggota','Nama','No. Rekening','Produk','Pokok','Margin','Jangka Waktu','Tanggal Cair','Sumber Dana','Kreditur'],
         colModel:[
            {name:'id',index:'id',hidden:true},
            {name:'branch_name',index:'branch_name'},
            {name:'cm_name',index:'cm_name'},
            {name:'cif_no',index:'cif_no'},
            {name:'nama',index:'nama'},
            {name:'account_financing_no',index:'account_financing_no'},
            {name:'product_name',index:'product_name'},
            {name:'pokok',index:'pokok'},
            {name:'margin',index:'margin'},
            {name:'jangka_waktu',index:'jangka_waktu'},
            {name:'tanggal_akad',index:'tanggal_akad'},
            {name:'sumber_dana',index:'sumber_dana'},
            {name:'display_text',index:'display_text'},
         ],
         postData: {
            branch_code : function(){
               return $("#branch_code").val()
            },
            product : function(){
               return $("#product").val()
            },
            tanggal : function(){
               return $("#tanggal").val()
            },
            tanggal2 : function(){
               return $("#tanggal2").val()
            },
            kreditur_from : function(){
               return $("#kreditur_from").val()
            }
         },
         pager: "#page_list_kreditur",
         viewrecords: true,
         multiselect: true,
         grouping:true,
         sortname: 'branch_name,cm_name,cif_no'
      });
   }

   $('#proses').click(function(){
      var rowKey = $('#list_kreditur').getGridParam('selrow');
      var kreditur_from = $('#kreditur_from').val();
      var kreditur_thru = $('#kreditur_thru').val();
      var batch_no = $('#batch_no').val();
      var group_bprs = $('#group_bprs').val();

      if(kreditur_thru == ''){
         alert('Kreditur Tujuan belum dipilih');
      } else {
         if(kreditur_thru == kreditur_from){
            alert('Gagal! Kreditur Tujuan dengan Kreditur saat ini sama');
         } else {
            if(!rowKey){
               alert('Item belum dipilih');
            } else {
               if(group_bprs == ''){
                  alert('Gagal! Display Sort masih kosong. Silakkan hubungi IT Support');
               } else {
                  var conf = confirm('Yakin akan diproses?');
                  var selectedIDs = $('#list_kreditur').getGridParam('selarrrow');

                  if(conf){
                     $.ajax({
                        type: 'POST',
                        url: site_url+'laporan/proses_api_debitur',
                        data: {
                           object:selectedIDs,
                           batch_no:batch_no,
                           group_bprs:group_bprs
                        },
                        dataType: 'json',
                        success: function(response){
                           var status = response.status;
                           var message = response.message;

                           if(status == true){
                              alert(message);
                              $('#list_kreditur').trigger('reloadGrid');
                           } else {
                              alert(message);
                           }
                        },
                        error: function(){
                           alert('Jaringan Anda tidak stabil');
                        }
                     });
                  }
               }
            }
         }
      }
   });
});

</script>
<!-- END JAVASCRIPTS -->

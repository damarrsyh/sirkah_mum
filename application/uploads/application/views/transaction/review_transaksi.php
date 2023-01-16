<style type="text/css">
#pReviewTransaksi_center input {
    margin: 0;
    padding: 3px;
    width: 10px;
    font-size:13px;
}#pdReviewTransaksi_center input {
    margin: 0;
    padding: 3px;
    width: 10px;
    font-size:13px;
}
select {
  padding: 5px;
}
#t_ReviewTransaksi{
  height: 40px;
  width: 1080;
}
#t_dReviewTransaksi{
  height: 40px;
  width: 1080;
}
#t_add tr{
  margin-bottom: 0px;
  margin-top: 0px;
  padding: 0;
} 
.error {
  background-color: #f2dede !important; 
}
.fild_name{
  margin-top: 0px;
  padding-bottom: 15px;
}
.fild_name_{
  margin-top: 0px;
  padding-bottom: 5px;
}
.ui-jqgrid-title{
  font-size: 15px !important;
}
</style>

<!-- DIALOG BRANCH -->
<div id="dialog_branch" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
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
      
<div id="dialog_edit_description" title="Edit Description" style="display:none">
  <table width="100%">
    <tr>
      <td>
        <input type="hidden" id="trx_gl_id" name="trx_gl_id">
        <textarea id="description" name="description" style="width:460px;" rows="8"></textarea>
      </td>
    </tr>
  </table>
</div>

<div id="dialog_edit_detail_transaksi" title="Edit Transaksi Detail" style="display:none">
  <input type="hidden" id="trx_gl_detail_id" name="trx_gl_detail_id">
  <input type="hidden" id="trx_gl_id" name="trx_gl_id">
  <form action="">
    <table width="100%">
      <tr>
        <td>Account</td>
        <td>
          <select id="account_code" class="m-wrap large chosen">
            <option></option>
            <?php foreach($accounts as $account): ?>
            <option value="<?php echo $account['account_code']; ?>"><?php echo $account['account_code'] .' - '. $account['account_name']; ?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>
      <tr><td colspan="2" style="height:10px;"></td></tr>
      <tr>
        <td>Description</td>
        <td><textarea id="description" class="m-wrap large" style="background: #FFF;"></textarea></td>
      </tr>
      <tr>
        <td>Debit</td>
        <td><input type="text" id="debit" class="mask-money m-wrap small" style="background: #FFF;"></td>
      </tr>
      <tr>
        <td>Credit</td>
        <td><input type="text" id="credit" class="mask-money m-wrap small" style="background: #FFF;"></td>
      </tr>
    </table>
  </form>
</div>

<div id="dialog_add_detail_transaksi" title="Add Detail Transaksi" style="display:none">
  <input type="hidden" id="trx_gl_id" name="trx_gl_id">
  <form action="">
    <table width="100%">
      <tr>
        <td>Account</td>
        <td>
          <select id="account_code" class="m-wrap large chosen">
            <option></option>
            <?php foreach($accounts as $account): ?>
            <option value="<?php echo $account['account_code']; ?>"><?php echo $account['account_code'].' - '.$account['account_name']; ?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>
      <tr><td colspan="2" style="height:10px;"></td></tr>
      <tr>
        <td>Description</td>
        <td><textarea id="description" class="m-wrap large" style="background: #FFF;"></textarea></td>
      </tr>
      <tr>
        <td>Debit</td>
        <td><input type="text" id="debit" class="mask-money m-wrap small" style="background: #FFF;"></td>
      </tr>
      <tr>
        <td>Credit</td>
        <td><input type="text" id="credit" class="mask-money m-wrap small" style="background: #FFF;"></td>
      </tr>
    </table>
  </form>
</div>

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
      Review Transaksi <small>Review Transaksi</small>
    </h3>
    <ul class="breadcrumb hide">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
      <li><a href="#">Transaction</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">General Ledger</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Review Transaksi</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="row-fluid">
  <div class="span12">
    <table>
      <tr>
        <td style="width:70px;padding-top:8px;vertical-align:top;line-height:20px;">Cabang</td>
        <td style="width:10px;padding-top:8px;vertical-align:top;line-height:20px;">:</td>
        <td style="width:250px;">
        <input type="text" tabindex="1" name="branch" readonly value="<?php echo $this->session->userdata('branch_name'); ?>" style="padding:4px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> 
        <input type="hidden" id="branch_code" name="branch_code" value="<?php echo $this->session->userdata('branch_code'); ?>">
        <?php if($this->session->userdata('flag_all_branch')){ ?>
        <a id="browse_branch" class="btn blue" style="padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a>
        <?php } ?>
        </td>
        <td style="width:200xp;padding-top:8px;vertical-align:top;line-height:20px;">Periode Transaksi</td>
        <td style="width:10px;padding-top:8px;vertical-align:top;line-height:20px;">:</td>
        <td>
          <input type="text" id="from_date" class="mask_date date-picker" style="padding:4px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
        </td>
        <td style="width:30px;line-height:30px;text-align:center;">
        s/d
        </td>
        <td>
          <input type="text" id="thru_date" class="mask_date date-picker" style="padding:4px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
        </td>
        <td style="vertical-align:top;line-height:30px;padding-left:10px;">
          <input type="submit" id="search" class="btn green" value="Tampilkan" style="padding:4px 8px;">
        </td>
      </tr>
    </table>
    <hr>
  </div>
</div>
<input type="hidden" id="fromdate">
<input type="hidden" id="thrudate">
<div class="row-fluid">
   <div class="span12">
    <div id="wraper_table">
      <table id="ReviewTransaksi"></table>
      <div id="pReviewTransaksi"></div>
    </div>
  </div>
</div>
<p></p>
<div class="row-fluid">
  <div class="span12">
    <div id="wraper_table">
      <table id="dReviewTransaksi"></table>
      <div id="pdReviewTransaksi"></div>
    </div>
  </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/jquery.json-2.2.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>   
<script type="text/javascript">
  
jQuery(document).ready(function() {
  App.init(); // initlayout and core plugins
  $("input#mask_date,.mask_date").livequery(function(){
    $(this).inputmask("d/m/y");  //direct mask
  });

  $("#browse_branch").click(function(){
    if($("#keyword","#dialog_branch").val()==""){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         data: {keyword:''},
         async: false,
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_code+'" branch_class="'+response[i].branch_class+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            $("#result","#dialog_branch").html(html);
         }
      })
    }
  })

  $("#keyword","#dialog_branch").keyup(function(e){
    e.preventDefault();
    keyword = $(this).val();
    if(e.which==13){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         async: false,
         data: {keyword:keyword},
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_code+'" branch_class="'+response[i].branch_class+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            $("#result","#dialog_branch").html(html);
         }
      })
    }
  });

  $("#select","#dialog_branch").click(function(){
    // branch_id = $("#result option:selected","#dialog_branch").attr('branch_id');
    result_name = $("#result option:selected","#dialog_branch").attr('branch_name');
    branch_class = $("#result option:selected","#dialog_branch").attr('branch_class');
    result_code = $("#result","#dialog_branch").val();
    if(result!=null)
    {
      $("input[name='branch']").val(result_name);
      $("input[name='branch_code']").val(result_code);
      $("#close","#dialog_branch").trigger('click');
    }
  });

  $("#result option","#dialog_branch").livequery('dblclick',function(){
    $("#select","#dialog_branch").trigger('click');
    window.scrollTo(0,0)
  });


  //GRID SEMUA DATA
  jQuery("#ReviewTransaksi").jqGrid({
    url: site_url+'transaction/get_review_transaksi',
    datatype: 'json',
    height: '200',
    postData: {
      from_date: function(){ return $("#from_date").val() },
      thru_date: function(){ return $("#thru_date").val() },
      branch_code: function(){ return $("#branch_code").val() }
    },
    // width:1000,
    shrinkToFit: false,
    rowNum: 20,
    autowidth: true,
    rowList: [10,20,50,100,500,1000],
      colNames:['ID','Trx Date','Voucher Date','Voucher Ref','Description','Total Debit','Total Credit','Branch','Status Pengecekan'],
      colModel:[
        {name:'trx_gl_id',index:'trx_gl_id', width:150, hidden:true}
        ,{name:'trx_date',index:'trx_date', width:100, align:'center'}
        ,{name:'voucher_date',index:'voucher_date', width:100, align:'center'}
        ,{name:'voucher_ref',index:'voucher_ref', width:100, align:'center', hidden:true}
        ,{name:'description',index:'description', width:400}
        ,{name:'total_debit',index:'total_debit', width:100, align:'right', formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 2}}
        ,{name:'total_credit',index:'total_credit', width:100, align:'right', formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 2}}
        ,{name:'branch_name',index:'branch_name', width:100, align:'center'}
        ,{name:'flag_status',index:'flag_status', width:100, align:'center',formatter:function(cellvalue){
          if(cellvalue=="0"){
            return '<span style="color:red;font-size:11px;">New</span>';
          }else if(cellvalue=="1"){
            return '<span style="color:green;font-size:11px;">OK</span>';
          }else{
            return '<span style="color:red;font-size:11px;">New</span>';
          }
        }}
      ],
      pager: "#pReviewTransaksi",
      viewrecords: true,
      sortname: 'trx_date',
      rownumbers: true,
      toolbar:[true,"top"],
      caption: "REVIEW TRANSAKSI",  
      ondblClickRow: function(row_id){
        jQuery("#dReviewTransaksi").setGridParam({ 
          postData: { 
            trx_gl_id : row_id
          }
        }).trigger("reloadGrid");
        $("#trx_gl_id","#dialog_add_detail_transaksi").val(row_id);
      }
  });
  $("#t_ReviewTransaksi").append('<div class="append-bu" style="margin:2px;"><button id="btn_delete" class="btn red" style="font-size:13px;"><span class="icon-trash"></span> Delete Jurnal</button> <button id="btn_print" class="btn green" style="font-size:13px;"><span class="icon-print"></span> Print to Excel</button> <button id="btn_ok" class="btn green" style="font-size:13px;"><span class="icon-ok-sign"></span> Checked</button></div>');

  $("#btn_ok").click(function(){
    selrow=$("#ReviewTransaksi").jqGrid('getGridParam','selrow');
    data=$("#ReviewTransaksi").jqGrid('getRowData',selrow);
    trx_gl_id=data.trx_gl_id;
    if(selrow){
      $.ajax({
        Type:"POST",dataType:"json",data:{trx_gl_id:trx_gl_id},
        url:site_url+"transaction/update_flag_status_trx_gl",
        async:false,success:function(response){
          if(response.success==true){
            alert("Checked Success!");
            $("#ReviewTransaksi").trigger('reloadGrid');
          }else{
            alert("Checked Failed!");
          }
        },error:function(){
          alert("Failed to Connect into Databases, Please Contact Your Administrator!");
        }
      })
    }else{
      alert("Please select a Row");
    }
  })

  $("#btn_print").click(function(){
    from_date=$("#fromdate").val().replace(/\//g,'');
    thru_date=$("#thrudate").val().replace(/\//g,'');
    if(from_date=="") from_date = '-';
    if(thru_date=="") thru_date = '-';
    window.open(site_url+"/laporan_to_excel/laporan_jurnal_transaksi/"+from_date+"/"+thru_date,'_blank');
  });

  $("#search").click(function(){
    txt_fromdate=$("#from_date").val();
    txt_thrudate=$("#thru_date").val();

    fromdate = txt_fromdate.split('/');
    day_fromdate = fromdate[0];
    month_fromdate = fromdate[1];
    year_fromdate = fromdate[2];

    thrudate = txt_thrudate.split('/');
    day_thrudate = thrudate[0];
    month_thrudate = thrudate[1];
    year_thrudate = thrudate[2];

    from_date = new Date(<?php echo $year_periode_awal ?>,<?php echo $month_periode_awal ?>-1,<?php echo $day_periode_awal ?>);
    to_date = new Date(<?php echo $year_periode_akhir ?>,<?php echo $month_periode_akhir ?>-1,<?php echo $day_periode_akhir ?>);
    
    date_from = new Date(year_fromdate,month_fromdate-1,day_fromdate);
    date_thru = new Date(year_thrudate,month_thrudate-1,day_thrudate);

    if(date_from >= from_date && date_thru <= to_date){

      $("#fromdate").val($("#from_date").val())
      $("#thrudate").val($("#thru_date").val())
      $("#ReviewTransaksi").trigger('reloadGrid');

    }else{

      alert("Tanggal Transaksi berada diluar Periode Transaksi!");

    }
  })

  $("#btn_delete","#gview_ReviewTransaksi").click(function(){
    selrow = $("#ReviewTransaksi").jqGrid('getGridParam','selrow');
    if(selrow)
    {
      data = $("#ReviewTransaksi").jqGrid('getRowData',selrow);
      trx_gl_id = data.trx_gl_id;
      conf = confirm("Apakah anda yakin akan menghapus jurnal transaksi ini ?");
      if(conf){
        $.ajax({
          type: "POST",
          url: site_url+"transaction/delete_jurnal_transaksi",
          dataType: "json",
          data: {trx_gl_id:trx_gl_id},
          async: false,
          success: function(response){
            if(response.success==true){
              alert("Jurnal Transaksi berhasil dihapus!");
              $("#ReviewTransaksi").trigger('reloadGrid');
              $("#dReviewTransaksi").trigger('reloadGrid'); 
              $("input#trx_gl_id").val('');
            }else{
              alert("Failed to connect into databases, please contact your administrator!")
            }
          },
          error: function(){
            alert("Failed to connect into databases, please contact your administrator!")
          }
        })
      }
    }
    else
    {
      alert("please select a row")
    }
  })

  $("#btn_edit_desc","#gview_ReviewTransaksi").click(function(){
    selrow = $("#ReviewTransaksi").jqGrid('getGridParam','selrow');
    if(selrow)
    {
      data = $("#ReviewTransaksi").jqGrid('getRowData',selrow);
      description = data.description;
      trx_gl_id = data.trx_gl_id;
      $("#description","#dialog_edit_description").val(description);
      $("#trx_gl_id","#dialog_edit_description").val(trx_gl_id);
      $("#dialog_edit_description").dialog('open');
    }
    else
    {
      alert("please select a row")
    }
  })

  $("#dialog_edit_description").dialog({
    autoOpen: false,
    modal: true,
    width: 500,
    height: 310,
    buttons: {
      'Save' : function(){
        trx_gl_id = $("#trx_gl_id","#dialog_edit_description");
        description = $("#description","#dialog_edit_description");
        if(description.val()==""){
          alert("Isi Deskripsi!");
        }else{
          $.ajax({
            type: "POST",
            dataType: "json",
            data: {
              trx_gl_id: trx_gl_id.val(),
              description: description.val()
            },
            url: site_url+"transaction/update_description_acctg_trans",
            async: false,
            success: function(response){
              if(response.success==true){
                alert("Edit Description Successed!");
                jQuery("#ReviewTransaksi").trigger('reloadGrid');
                $("#dReviewTransaksi").trigger('reloadGrid');
                $("#dialog_edit_description").dialog('close');
              }else{
                alert("Failed to connect into databases, please contact your administrator!")
              }
            },
            error: function(){
              alert("Failed to connect into databases, please contact your administrator!")
            }
          })
        }
        $(this).dialog('close');
      },
      'Cancel' : function(){
        $(this).dialog('close');
      }
    }
  });

  jQuery("#dReviewTransaksi").jqGrid({
    url: site_url+'transaction/get_detail_review_transaksi',
    datatype: 'json',
    height: '200',
    // width:1000,
    shrinkToFit: false,
    rowNum: 20,
    autowidth: true,
    rowList: [10,20,50,100,500,1000],
      colNames:['trx_gl_id','acctg_trans_entry_id','account_code','Account','Description','Debit','Credit'],
      colModel:[
         {name:'trx_gl_detail_id',index:'trx_gl_detail_id', width:150, hidden:true,key:true}
        ,{name:'trx_gl_id',index:'trx_gl_id', width:150, hidden:true}
        ,{name:'account_code',index:'account_code', width:100, align:'center',hidden:true}
        ,{name:'account_name',index:'account_name', width:190}
        ,{name:'description',index:'description', width:400}
        ,{name:'debit',index:'debit', width:100, align:'right', formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0}}
        ,{name:'credit',index:'credit', width:100, align:'right', formatter:'currency', formatoptions:{decimalSeparator:",", thousandsSeparator: ".", decimalPlaces: 0}}
      ],
      pager: "#pdReviewTransaksi",
      viewrecords: true,
      sortname: 'credit',
      rownumbers: true,
      toolbar:[true,"top"],
      footerrow: true,
      loadComplete: function(){
        var $self = $(this),
        sumdebit = $self.jqGrid("getCol", "debit", false, "sum");
        sumcredit = $self.jqGrid("getCol", "credit", false, "sum");
        if(sumdebit!=sumcredit){
          alert("Debit & Credit selisih!");
        }
        $self.jqGrid("footerData", "set", {invdate: "", debit: sumdebit});
        $self.jqGrid("footerData", "set", {invdate: "", credit: sumcredit});
      },
      caption: "DETAIL TRANSAKSI"
  });
  $("#t_dReviewTransaksi").append('<div class="append-bu" style="margin:2px;"><button id="btn_add" class="btn green" style="font-size:13px;">Add</button> <button id="btn_edit" class="btn blue" style="font-size:13px;">Edit</button> <button id="btn_delete" class="btn red" style="font-size:13px;">Delete</button></div>');

  $("#btn_add","#gview_dReviewTransaksi").click(function(){
    trx_gl_id = $("#trx_gl_id","#dialog_add_detail_transaksi").val();
    if(trx_gl_id!="")
    {
      $("#account_code","#dialog_add_detail_transaksi").val('').trigger('liszt:updated');
      $("#description","#dialog_add_detail_transaksi").val('');
      $("#debit","#dialog_add_detail_transaksi").val('0');
      $("#credit","#dialog_add_detail_transaksi").val('0');
      $("#dialog_add_detail_transaksi").dialog('open');
    }
    else
    {
      alert("please select a row of journal");
    }
  });

  $("#btn_delete","#gview_dReviewTransaksi").click(function(){
    selrow = $("#dReviewTransaksi").jqGrid('getGridParam','selrow');
    if(selrow)
    {
      data = $("#dReviewTransaksi").jqGrid('getRowData',selrow);
      trx_gl_detail_id = data.trx_gl_detail_id;
      conf = confirm("Apakah anda yakin akan menghapus account jurnal transaksi ini ?");
      if(conf){
        $.ajax({
          type: "POST",
          url: site_url+"transaction/delete_jurnal_transaksi_detail",
          dataType: "json",
          data: {trx_gl_detail_id:trx_gl_detail_id},
          async: false,
          success: function(response){
            if(response.success==true){
              alert("Jurnal Transaksi Detail berhasil dihapus!");
              $("#dReviewTransaksi").trigger('reloadGrid');
              $("#ReviewTransaksi").trigger('reloadGrid');
            }else{
              alert("Failed to connect into databases, please contact your administrator!")
            }
          },
          error: function(){
            alert("Failed to connect into databases, please contact your administrator!")
          }
        })
      }
    }
    else
    {
      alert("please select a row")
    }
  })

  $("#btn_edit","#gview_dReviewTransaksi").click(function(){
    selrow = $("#dReviewTransaksi").jqGrid('getGridParam','selrow');
    if(selrow)
    {
      data = $("#dReviewTransaksi").jqGrid('getRowData',selrow);
      trx_gl_detail_id = data.trx_gl_detail_id;
      trx_gl_id = data.trx_gl_id;
      account_code = data.account_code;
      description = data.description;
      debit = data.debit;
      credit = data.credit;
      $("#trx_gl_detail_id","#dialog_edit_detail_transaksi").val(trx_gl_detail_id);
      $("#trx_gl_id","#dialog_edit_detail_transaksi").val(trx_gl_id);
      $("#account_code","#dialog_edit_detail_transaksi").val(account_code).trigger('liszt:updated');
      $("#description","#dialog_edit_detail_transaksi").val(description);
      $("#debit","#dialog_edit_detail_transaksi").val(parseFloat(debit));
      $("#credit","#dialog_edit_detail_transaksi").val(parseFloat(credit));
      $("#dialog_edit_detail_transaksi").dialog('open');
    }
    else
    {
      alert("please select a row")
    }
  });

  $("#dialog_add_detail_transaksi").dialog({
    autoOpen: false,
    modal: true,
    width: 480,
    height: 360,
    buttons: {
      'Save' : function(){
        trx_gl_id = $("#trx_gl_id","#dialog_add_detail_transaksi");
        account_code = $("#account_code","#dialog_add_detail_transaksi");
        description = $("#description","#dialog_add_detail_transaksi");
        debit = $("#debit","#dialog_add_detail_transaksi");
        credit = $("#credit","#dialog_add_detail_transaksi");
        bValid = true;

        if(account_code.val()==""){
          account_code.addClass('error');
          bValid = false;
        }else{
          account_code.removeClass('error');
        }
        if(debit.val()==""){
          debit.addClass('error');
          bValid = false;
        }else{
          debit.removeClass('error');
        }
        if(credit.val()==""){
          credit.addClass('error');
          bValid = false;
        }else{
          credit.removeClass('error');
        }

        if(bValid==false){
          alert("Lengkapi form !");
        }else{
          $.ajax({
            type: "POST",
            url: site_url+"transaction/add_acctg_trans_entry",
            dataType: "json",
            data: {
              trx_gl_id: trx_gl_id.val(),
              account_code: account_code.val(),
              description: description.val(),
              debit: debit.val(),
              credit: credit.val()
            },
            async: false,
            success: function(response){
              if(response.success==true){
                alert("Add Detail Transaksi Success!");
                jQuery("#dReviewTransaksi").trigger('reloadGrid');
                $("#ReviewTransaksi").trigger('reloadGrid');
                $("#dialog_add_detail_transaksi").dialog('close');
              }else{
                alert("Failed to connect into databases, please contact your administrator!")
              }
            },
            error: function(){
              alert("Failed to connect into databases, please contact your administrator!")
            }
          })
        }
      },
      'Cancel' : function(){
        $(this).dialog('close');
      }
    }
  });

  $("#dialog_edit_detail_transaksi").dialog({
    autoOpen: false,
    modal: true,
    width: 480,
    height: 360,
    buttons: {
      'Save' : function(){
        trx_gl_detail_id = $("#trx_gl_detail_id","#dialog_edit_detail_transaksi");
        trx_gl_id = $("#trx_gl_id","#dialog_edit_detail_transaksi");
        account_code = $("#account_code","#dialog_edit_detail_transaksi");
        description = $("#description","#dialog_edit_detail_transaksi");
        debit = $("#debit","#dialog_edit_detail_transaksi");
        credit = $("#credit","#dialog_edit_detail_transaksi");
        bValid = true;

        if(account_code.val()==""){
          account_code.addClass('error');
          bValid = false;
        }else{
          account_code.removeClass('error');
        }
        if(debit.val()==""){
          debit.addClass('error');
          bValid = false;
        }else{
          debit.removeClass('error');
        }
        if(credit.val()==""){
          credit.addClass('error');
          bValid = false;
        }else{
          credit.removeClass('error');
        }

        if(bValid==false){
          alert("Lengkapi form !");
        }else{
          $.ajax({
            type: "POST",
            dataType: "json",
            data: {
              trx_gl_detail_id: trx_gl_detail_id.val(),
              trx_gl_id: trx_gl_id.val(),
              account_code: account_code.val(),
              description: description.val(),
              debit: debit.val(),
              credit: credit.val()
            },
            url: site_url+"transaction/update_acctg_trans_entry",
            async: false,
            success: function(response){
              if(response.success==true){
                alert("Edit Detail Transaksi Successed!");
                jQuery("#dReviewTransaksi").trigger('reloadGrid');
                $("#ReviewTransaksi").trigger('reloadGrid');
                $("#dialog_edit_detail_transaksi").dialog('close');
              }else{
                alert("Failed to connect into databases, please contact your administrator!")
              }
            },
            error: function(){
              alert("Failed to connect into databases, please contact your administrator!")
            }
          })
        }
        $(this).dialog('close');
      },
      'Cancel' : function(){
        $(this).dialog('close');
      }
    }
  });

});
</script>
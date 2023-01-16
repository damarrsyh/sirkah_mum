<style type="text/css">
#form input:focus, #form select:focus {
  border: solid 1px blue;
}
</style>

<div id="dialog_saldo_outstanding" class="modal hide fade"  data-width="500" style="position:fixed;top:10%" >
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>INFO CIF</h3>
      <input type="hidden" id="cif_no">
      <input type="hidden" id="account_financing_no">
   </div>
   <div class="modal-body">
      <div class="row-fluid">
         <div class="span12">
          <table width="100%">
            <tr>
              <td style="font-size:11px;" width="29%">Angsuran Masuk</td>
              <td width="29%"><input style="width:40px;font-size:12px;padding:0 4px;text-align:right;" readonly type="text" id="angsuran_masuk"></td>
              <td width="4%"></td>
              <td style="font-size:11px;" width="18%">Jangka Waktu</td>
              <td style="font-size:11px;" width="26%"><input style="width:40px;font-size:12px;padding:0 4px;text-align:right;" readonly type="text" id="jangka_waktu"> &nbsp; <span id="periode_jangka_waktu"></span></td>
            </tr>
          </table>
         </div>
      </div>
      <div class="row-fluid">
         <div class="span7">
          <table>
            <tr>
              <td style="font-size:11px;width:150px;vertical-align:top;padding-top:3px;">Angsuran Pokok</td>
              <td colspan="2"><input type="hidden" id="nyumput_angsuran_pokok"><input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="angsuran_pokok"></td>
            </tr>
            <tr>
              <td style="font-size:11px;vertical-align:top;padding-top:3px;">Angsuran Margin</td>
              <td><input type="hidden" id="nyumput_angsuran_margin"><input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="angsuran_margin"></td>
              <td style="vertical-align:top;padding-top:0;padding-left:5px;">
                <!-- <input type="checkbox" checked="checked" id="angsuran_margin"> -->
              </td>
            </tr>
            <tr>
              <td style="font-size:11px;vertical-align:top;padding-top:3px;">Angsuran Catab</td>
              <td><input type="hidden" id="nyumput_angsuran_catab"><input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="angsuran_catab"></td>
              <td style="vertical-align:top;padding-top:0;padding-left:5px;">
                <!-- <input type="checkbox" checked="checked" id="angsuran_catab"> -->
              </td>
            </tr>
            <tr>
              <td style="font-size:11px;vertical-align:top;padding-top:3px;">Angsuran Tab. Wajib</td>
              <td><input type="hidden" id="nyumput_angsuran_tab_wajib"><input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="angsuran_tab_wajib"></td>
              <td style="vertical-align:top;padding-top:0;padding-left:5px;">
                <!-- <input type="checkbox" checked="checked" id="angsuran_tab_wajib"> -->
              </td>
            </tr>
            <tr>
              <td style="font-size:11px;vertical-align:top;padding-top:3px;">Angsuran Tab. Kelompok</td>
              <td><input type="hidden" id="nyumput_angsuran_tab_kelompok"><input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="angsuran_tab_kelompok"></td>
              <td style="vertical-align:top;padding-top:0;padding-left:5px;">
                <!-- <input type="checkbox" checked="checked" id="angsuran_tab_kelompok"> -->
              </td>
            </tr>
            <tr>
              <td style="font-size:11px;vertical-align:top;padding-top:3px;">Total Angsuran</td>
              <td colspan="2"><input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="total_angsuran"></td>
            </tr>
          </table> 
         </div>
         <div class="span5">
          <table>
            <tr>
              <td style="font-size:11px;width:106px;">Outstanding Pokok</td>
              <td><input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="outstanding_pokok"></td>
            </tr>
            <tr>
              <td style="font-size:11px;">Outstanding Margin</td>
              <td><input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="outstanding_margin"></td>
            </tr>
            <tr>
              <td style="font-size:11px;">Total Outstanding</td>
              <td><input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="total_outstanding"></td>
            </tr>
            <tr>
              <td style="font-size:11px;">Saldo Catab</td>
              <td><input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="saldo_catab"></td>
            </tr>
            <tr style="display:none;">
              <td style="font-size:11px;">Muqosha</td>
              <td><input type="text" readonly="readonly" style="background-color:#eeeeee;text-align:right;width:70px;font-size:12px;padding:0 4px;" value="0" class="mask-money" id="muqosha"></td>
            </tr>
            <tr>
              <td colspan="2" style="font-size:11px;">
              <div id="pindah-catab" style="display:none;text-align:center;border:solid 1px #CCC;padding-top:5px;">
                Catab yang akan dipindahkan<br>
                <input readonly type="text" style="text-align:right;width:70px;font-size:12px;padding:0 4px;" id="catab_pindah">
              </div>
              <div id="pindah-tabcawakel" style="display:none;text-align:center;border:solid 1px #CCC;padding-top:5px;">
                Note: Saldo Tabungan telah dipindahkan ke Tab.Sukarela!
              </div>
              </td>
            </tr>
          </table> 
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <!-- <button type="button" id="btnoksaldooutstanding" data-dismiss="modal" class="btn green">OK</button> -->
      <button type="button" id="close" data-dismiss="modal" class="btn red">Close</button>
   </div>
</div>
<a href="#dialog_saldo_outstanding" id="open_dialog_saldo_outstanding" style="display:none;" data-toggle="modal">open</a>

<!--BEGIN PAGE HEADER-->
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
      Verifikasi Transaksi Rembug <small>Untuk melakukan verifikasi transaksi rembug</small>
    </h3>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<div id="dialog_branch" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Kantor Cabang</h3>
   </div>
   <div class="modal-body">
      <div class="row-fluid">
         <div class="span12">
            <h4>Masukan Kata Kunci</h4>
            <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"><br><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
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
      <div class="caption"><i class="icon-globe"></i>Verifikasi Transaksi Rembug</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
         <label>
            Kantor Cabang &nbsp; : &nbsp;
            <input type="text" name="src_branch_name" id="src_branch_name" class="medium m-wrap" style="background:#eee;" disabled value="<?php echo $this->session->userdata('branch_name'); ?>">
            <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code'); ?>">
            <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id'); ?>">
            <a id="browse_branch" class="btn blue" data-toggle="modal" href="#dialog_branch">...</a>
            &nbsp; &nbsp;
            Tanggal Transaksi &nbsp; : &nbsp;
            <input type="text" name="src_trx_date" id="src_trx_date" value="<?php echo $current_date; ?>" class="small m-wrap date-picker date-mask">
            <input type="submit" id="search" value="Filter" class="btn green">
         </label>
      </div>
      <table class="table table-striped table-bordered table-hover" id="transaksi_kas_petugas">
         <thead>
            <tr>
               <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#transaksi_kas_petugas .checkboxes" /></th> -->
               <!-- <th width="16.5%">Kantor Cabang</th> -->
               <th width="35%" style="text-align:center;">Rembug Pusat</th>
               <th width="20%" style="text-align:center;">Tanggal</th>
               <th width="35%" style="text-align:center;">Kas Petugas</th>
               <!-- <th width="16.5%">Nominal</th> -->
               <!-- <th width="16.5%">Keterangan</th> -->
               <th width="10%" style="text-align:center;">Verifikasi</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->








<div id="edit" class="hide">
      <hr size="1">
      <table>
        <tr>
          <td width="120">Kantor Cabang <span style="color:red">*</span></td>
          <td>
            <input type="text" id="view_branch_name" readonly value="" style="padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"> 
            <!-- <a id="browse_branch" class="btn blue" style="padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a> -->
          </td>
          <td width="100"></td>
          <td width="100">Tanggal <span style="color:red">*</span></td>
          <td><input type="text" id="view_trx_date" readonly value="" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"></td>
          <td></td>
        </tr>
        <tr>
          <td width="100">Rembug Pusat <span style="color:red">*</span></td>
          <td>
            <input type="text" id="view_cm_name" readonly style="padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
          </td>
          <td width="100"></td>
          <td>Kas Petugas <span style="color:red">*</span></td>
          <td width="300">
            <input type="text" id="view_account_cash_name" readonly style="padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;width:100% !important">
          </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td></td>
        </tr>
      </table>
      <form id="process_trx_rembug" method="post" style="margin-bottom:0px;">
        <input type="hidden" name="fa_code" id="fa_code">
        <input type="hidden" name="account_cash_code" id="account_cash_code">
        <input type="hidden" name="cm_code" id="cm_code">
        <input type="hidden" name="branch_code" id="branch_code">
        <input type="hidden" name="branch_id" id="branch_id">
        <input type="hidden" name="tanggal2" id="tanggal2">
        <input type="hidden" name="trx_cm_save_id" id="trx_cm_save_id">
        <!-- <div style="padding:10px;border-left:solid 1px #CCC; border-right:solid 1px #CCC; border-top:solid 1px #CCC"> -->
          <table width="100%" id="form">
            <thead>
              <tr>
                <td style="background:#EEE;border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" rowspan="3" valign="middle" align="center"><div id="loading-overlay"></div>ID</td>
                <td style="background:#EEE;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="15%" rowspan="3" valign="middle" align="center">NAMA</td>
                <td style="background:#EEE;border-right:solid 1px #999;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="5%" rowspan="3" valign="middle" align="center">Absen</td>
                <td style="background:#EEE;border-right:solid 1px #999;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="30%" colspan="5" valign="middle" align="center">SETORAN</td>
                <td style="background:#EEE;border-right:solid 1px #999;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="10%" colspan="1" valign="middle" align="center">PENARIKAN</td>
                <td style="background:#EEE;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="20%" colspan="3" valign="middle" align="center">REALISASI PEMBIAYAAN</td>
                <td style="background:#EEE;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="5%" valign="middle" align="center" rowspan="3">KET.</td>
                <!-- <td style="background:#EEE;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC;" width="90" rowspan="3" valign="middle" align="center">+/-</td> -->
              </tr>
              <tr>
                <td style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" colspan="2" valign="middle" align="center">Angsuran</td>
                <!-- <td style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Tab. Wajib</td> -->
                <td style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Tab. Sukarela</td>
                <!-- <td style="background:#EEE;border-right:solid 1px #999;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Setoran Lain</td> -->
                <td style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Tab. Majelis<br />
                  Simpok</td>
                <td style="background:#EEE;border-right:solid 1px #999;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Tab. Berencana</td>
                <!-- <td style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Droping</td> -->
                <!-- <td style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Tab. Wajib</td> -->
                <td style="background:#EEE;border-right:solid 1px #999;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Tab. Sukarela</td>
                <td style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Plafon</td>
                <td style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Adm.</td>
                <td style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" rowspan="2" valign="middle" align="center">Asuransi</td>
              </tr>
              <tr>
                <td valign="middle" align="center" style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">Frek</td>
                <td valign="middle" align="center" style="background:#EEE;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">@</td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="padding:0 5px; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" align="center">-</td>
                <td style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" align="center">-</td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;">
                  <select name="absen[]" id="absen" disabled style="width:50px;margin-top:8px">
                    <option>H</option>
                    <option>I</option>
                    <option>S</option>
                    <option>A</option>
                  </select>
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="font-size:12px;width:20px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">
                  <!-- <input type="text" value="0" disabled style="text-align:right;font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> -->
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3" style="border-left: solid 1px #CCC"></td>
                <td align="right" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-left:solid 1px #CCC; border-right:solid 1px #CCC;">Total</td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;">
                  <input type="text" id="total_angsuran" name="total_angsuran" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;">
                  <input type="text" id="total_setoran_tab_sukarela" name="total_setoran_tab_sukarela" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;">
                  <input type="text" id="total_minggon" name="total_minggon" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #999;">
                  <input type="text" id="total_setoran_tab_berencana" name="total_setoran_tab_berencana" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #999;">
                  <input type="text" id="total_penarikan_tab_sukarela" name="total_penarikan_tab_sukarela" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;">
                  <input type="text" id="total_realisasi_plafon" name="total_realisasi_plafon" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;">
                  <input type="text" id="total_realisasi_adm" name="total_realisasi_adm" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;">
                  <input type="text" id="total_realisasi_asuransi" name="total_realisasi_asuransi" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="background:#EEE;padding:0 5px; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;">
                  <!-- <input type="text" class="mask-money" id="total_realisasi_asuransi" name="total_realisasi_asuransi" readonly value="0" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> -->
                </td>
              </tr>
              <tr>
                <td colspan="3" style="border-left: solid 1px #CCC"></td>
                <td align="right" valign="middle" style="padding:0 5px;"></td>
                <td align="center" valign="middle" style="padding:0 5px;">&nbsp;
                  
                </td>
                <td align="center" valign="middle" style="padding:0 5px;">&nbsp;
                  
                </td>
                <td align="center" valign="middle" style="padding:0 5px;">&nbsp;
                  
                </td>
                <td align="center" valign="middle" style="padding:0 5px;">&nbsp;
                  
                </td>
                <td align="center" valign="middle" style="padding:0 5px;">&nbsp;
                  
                </td>
                <td align="center" valign="middle" style="padding:0 5px;">&nbsp;
                  
                </td>
                <td align="center" valign="middle" style="padding:0 5px;">&nbsp;
                  
                </td>
                <td align="center" valign="middle" style="padding:0 5px;">&nbsp;
                  
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;">&nbsp;
                  
                </td>
              </tr>
              <tr>               
                <td colspan="3" style="border-left:solid 1px #CCC;"></td>
                <td colspan="2" align="center" valign="middle" style="background:#EEE; padding:0 5px; border:solid 1px #CCC;">
                  Kas Awal
                </td>
                <td align="center" valign="middle" style="background:#EEE; padding: 5px; border-bottom:solid 1px #CCC; border-top:solid 1px #CCC; border-right:solid 1px #CCC;">
                  Infaq
                </td>
                <td align="center" valign="middle" style="background:#EEE; padding: 5px; border-bottom:solid 1px #CCC; border-top:solid 1px #CCC; border-right:solid 1px #CCC;">
                  Setoran
                </td>
                <td align="center" valign="middle" style="background:#EEE; padding: 5px; border-bottom:solid 1px #CCC; border-top:solid 1px #CCC; border-right:solid 1px #CCC;">
                  Penarikan
                </td>
                <td align="center" valign="middle" style="background:#EEE; padding: 5px; border-bottom:solid 1px #CCC; border-top:solid 1px #CCC; border-right:solid 1px #CCC;">
                  Saldo Kas
                </td>
                <td>&nbsp;</td>
                <td colspan="3" align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;">&nbsp;</td>
              </tr>
              <tr>               
                <td colspan="3" style="border-left:solid 1px #CCC;"></td>
                <td colspan="2" align="center" valign="middle" style="padding:0 5px; border-left:solid 1px #CCC; border-bottom:solid 1px #CCC; border-right:solid 1px #CCC;">
                  <input type="text" id="kas_awal" class="mask-money" readonly name="kas_awal" value="0" style="font-size:12px;width:100px;padding:1px;margin-top:4px;margin-bottom:4px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;">
                  <input type="text" id="infaq_kelompok" class="mask-money" readonly name="infaq_kelompok" value="0" style="font-size:12px;width:70px;padding:1px;margin-top:4px;margin-bottom:4px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;">
                  <input type="text" id="setoran" class="mask-money" name="setoran" readonly value="0" style="font-size:12px;width:70px;padding:1px;margin-top:4px;margin-bottom:4px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;">
                  <input type="text" id="penarikan" class="mask-money" name="penarikan" readonly value="0" style="font-size:12px;width:70px;padding:1px;margin-top:4px;margin-bottom:4px;box-shadow:0 0 0;">
                </td>
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC; border-bottom:solid 1px #CCC;">
                  <input type="text" id="saldo_kas" class="mask-money" name="saldo_kas" readonly value="0" style="font-size:12px;width:70px;padding:1px;margin-top:4px;margin-bottom:4px;box-shadow:0 0 0;">
                </td>
                <td>&nbsp;</td>
                <td colspan="3" align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="13" style="border-left: solid 1px #CCC; border-right:solid 1px #CCC;">&nbsp;  </td>
              </tr>
            </tfoot>
          </table>
      <!-- </div> -->
      </form>
      <div class="form-actions" align="center" style="padding-left:0; padding-right:0;border-left: solid 1px #CCC; border-right: solid 1px #CCC; border-bottom: solid 1px #CCC; border-top: solid 1px #CCC; margin-top:0px;">
         <button type="submit" class="btn green" id="save_trx">Approve</button>
         <button type="submit" style="margin-left:10px;" class="btn purple" id="reject_trx">Reject</button>
         <button type="reset" style="margin-left:10px;" class="btn red" id="cancel_trx">Cancel</button>
      </div>

</div>


























<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.1.10.4.min.js" type="text/javascript"></script>
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
      Index.init();
      $(".date-mask").inputmask("d/m/y");  //direct mask
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){

  /*
  | JUMLAH ANGSURAN DOBLE KLIK
  */

  $("input#jumlah_angsuran").livequery('dblclick',function(e){
    
    var cif_no = $(this).parent().parent().attr('cifno');
    var account_financing_no = $(this).parent().parent().find('#account_financing_no').val();
    var angsuran_pokok = $(this).parent().parent().find('#angsuran_pokok').val();
    var angsuran_margin = $(this).parent().parent().find('#angsuran_margin').val();
    var angsuran_catab = $(this).parent().parent().find('#angsuran_catab').val();
    var angsuran_tab_wajib = $(this).parent().parent().find('#angsuran_tab_wajib').val();
    var angsuran_tab_kelompok = $(this).parent().parent().find('#angsuran_tab_kelompok').val();
    var freq = $(this).parent().parent().find('#freq').val();
    var hide_angsuran_margin = $(this).parent().parent().find('#hide_angsuran_margin').val();
    var hide_angsuran_catab = $(this).parent().parent().find('#hide_angsuran_catab').val();
    var hide_angsuran_tab_wajib = $(this).parent().parent().find('#hide_angsuran_tab_wajib').val();
    var hide_angsuran_tab_kelompok = $(this).parent().parent().find('#hide_angsuran_tab_kelompok').val();
    var muqosha = parseFloat($(this).parent().parent().find('#muqosha').val());
    var status = parseFloat($(this).parent().parent().find('#status').val());
    var total_angsuran = $(this).val();

    var pembiayaan_saldo_pokok = $(this).parent().parent().find('#pembiayaan_saldo_pokok').val();
    var pembiayaan_saldo_margin = $(this).parent().parent().find('#pembiayaan_saldo_margin').val();
    var pembiayaan_saldo_catab = $(this).parent().parent().find('#pembiayaan_saldo_catab').val();
    var pembiayaan_jangka_waktu = $(this).parent().parent().find('#pembiayaan_jangka_waktu').val();
    var pembiayaan_periode_jangka_waktu = $(this).parent().parent().find('#pembiayaan_periode_jangka_waktu').val();
    var pembiayaan_counter_angsuran = $(this).parent().parent().find('#pembiayaan_counter_angsuran').val();

    sisa_angsuran = parseFloat(pembiayaan_jangka_waktu)-parseFloat(pembiayaan_counter_angsuran);
    if(sisa_angsuran==freq && sisa_angsuran!=0){
      $("#muqosha","#dialog_saldo_outstanding").parent().parent().show();
    }else{
      $("#muqosha","#dialog_saldo_outstanding").parent().parent().hide();
    }

    var catab_pindah = parseFloat(pembiayaan_saldo_catab)+(parseFloat(angsuran_catab)*parseFloat(freq));

    switch(pembiayaan_periode_jangka_waktu){
      case "0":
      periode_jangka_waktu = "Hari";
      break;
      case "1":
      periode_jangka_waktu = "Minggu";
      break;
      case "2":
      periode_jangka_waktu = "Bulan";
      break;
      case "3":
      periode_jangka_waktu = "Jatuh Tempo";
      break;
    }

    var total_outstanding = parseFloat(pembiayaan_saldo_pokok)+parseFloat(pembiayaan_saldo_margin);

    $("#account_financing_no","#dialog_saldo_outstanding").val(account_financing_no);
    $("#cif_no","#dialog_saldo_outstanding").val(cif_no);
    $("#angsuran_masuk","#dialog_saldo_outstanding").val(pembiayaan_counter_angsuran);
    $("#jangka_waktu","#dialog_saldo_outstanding").val(pembiayaan_jangka_waktu);
    $("#periode_jangka_waktu","#dialog_saldo_outstanding").text(periode_jangka_waktu);
    $("#angsuran_pokok","#dialog_saldo_outstanding").val(number_format(angsuran_pokok,0,',','.'));
    $("#angsuran_margin","#dialog_saldo_outstanding").val(number_format(angsuran_margin,0,',','.'));
    $("#nyumput_angsuran_margin","#dialog_saldo_outstanding").val(hide_angsuran_margin);
    $("#angsuran_catab","#dialog_saldo_outstanding").val(number_format(angsuran_catab,0,',','.'));
    $("#nyumput_angsuran_catab","#dialog_saldo_outstanding").val(hide_angsuran_catab);
    $("#angsuran_tab_wajib","#dialog_saldo_outstanding").val(number_format(angsuran_tab_wajib,0,',','.'));
    $("#nyumput_angsuran_tab_wajib","#dialog_saldo_outstanding").val(hide_angsuran_tab_wajib);
    $("#angsuran_tab_kelompok","#dialog_saldo_outstanding").val(number_format(angsuran_tab_kelompok,0,',','.'));
    $("#nyumput_angsuran_tab_kelompok","#dialog_saldo_outstanding").val(hide_angsuran_tab_kelompok);
    $("#total_angsuran","#dialog_saldo_outstanding").val(total_angsuran);
    $("#outstanding_pokok","#dialog_saldo_outstanding").val(number_format(pembiayaan_saldo_pokok,0,',','.'));
    $("#outstanding_margin","#dialog_saldo_outstanding").val(number_format(pembiayaan_saldo_margin,0,',','.'));
    $("#total_outstanding","#dialog_saldo_outstanding").val(number_format(total_outstanding,0,',','.'));
    $("#saldo_catab","#dialog_saldo_outstanding").val(number_format(pembiayaan_saldo_catab,0,',','.'));
    $("#muqosha","#dialog_saldo_outstanding").val(number_format(muqosha,0,',','.'));

    if(parseFloat(pembiayaan_counter_angsuran)+parseFloat(freq)==parseFloat(pembiayaan_jangka_waktu) && parseFloat(pembiayaan_jangka_waktu)!=0){
      if(status==3){
        $("#pindah-catab","#dialog_saldo_outstanding").hide();
      }else{
        $("#pindah-catab","#dialog_saldo_outstanding").show();
        $("#catab_pindah","#dialog_saldo_outstanding").val(number_format(catab_pindah,0,',','.'));
      }
    }else{
      $("#pindah-catab","#dialog_saldo_outstanding").hide();
    }

    if(status==3){
      $("#pindah-tabcawakel","#dialog_saldo_outstanding").show();
    }else{
      $("#pindah-tabcawakel","#dialog_saldo_outstanding").hide();
    }

    $("#open_dialog_saldo_outstanding").trigger('click');
    // window.scrollTo(0,0)

    // status_angsuran_margin = $(this).parent().parent().find('#status_angsuran_margin').val();
    // status_angsuran_catab = $(this).parent().parent().find('#status_angsuran_catab').val();
    // status_angsuran_tab_wajib = $(this).parent().parent().find('#status_angsuran_tab_wajib').val();
    // status_angsuran_tab_kelompok = $(this).parent().parent().find('#status_angsuran_tab_kelompok').val();
    // $("#cif_no","#dialog_saldo_outstanding").val(cif_no);
    // // alert(status_angsuran_margin);
    // console.log(status_angsuran_margin);
    // console.log($("#uniform-angsuran_margin","#dialog_saldo_outstanding").find('span'));
    // if(status_angsuran_margin=="1"){
    //   $("#uniform-angsuran_margin","#dialog_saldo_outstanding").find('span').attr('class','checked');
    //   $("#uniform-angsuran_margin","#dialog_saldo_outstanding").find('input').attr('checked','checked');
    // }else{
    //   $("#uniform-angsuran_margin","#dialog_saldo_outstanding").find('span').attr('class','');
    //   $("#uniform-angsuran_margin","#dialog_saldo_outstanding").find('input').attr('checked',false);
    // }

    // if(status_angsuran_catab=="1"){
    //   $("#uniform-angsuran_catab","#dialog_saldo_outstanding").find('span').attr('class','checked');
    //   $("#uniform-angsuran_catab","#dialog_saldo_outstanding").find('input').attr('checked','checked');
    // }else{
    //   $("#uniform-angsuran_catab","#dialog_saldo_outstanding").find('span').attr('class','');
    //   $("#uniform-angsuran_catab","#dialog_saldo_outstanding").find('input').attr('checked',false);
    // }

    // if(status_angsuran_tab_wajib=="1"){
    //   $("#uniform-angsuran_tab_wajib","#dialog_saldo_outstanding").find('span').attr('class','checked');
    //   $("#uniform-angsuran_tab_wajib","#dialog_saldo_outstanding").find('input').attr('checked','checked');
    // }else{
    //   $("#uniform-angsuran_tab_wajib","#dialog_saldo_outstanding").find('span').attr('class','');
    //   $("#uniform-angsuran_tab_wajib","#dialog_saldo_outstanding").find('input').attr('checked',false);
    // }

    // if(status_angsuran_tab_kelompok=="1"){
    //   $("#uniform-angsuran_tab_kelompok","#dialog_saldo_outstanding").find('span').attr('class','checked');
    //   $("#uniform-angsuran_tab_kelompok","#dialog_saldo_outstanding").find('input').attr('checked','checked');
    // }else{
    //   $("#uniform-angsuran_tab_kelompok","#dialog_saldo_outstanding").find('span').attr('class','');
    //   $("#uniform-angsuran_tab_kelompok","#dialog_saldo_outstanding").find('input').attr('checked',false);
    // }

  });
  /*
  | END JUMLAH ANGSURAN DOBLE KLIK
  */

  $("#browse_branch").click(function(){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: site_url+"transaction/search_branch_by_keyword",
        data: {keyword:$("input#keyword","#dialog_branch").val()},
        async: false,
        success: function(respon){
          option = '';
          for(i = 0 ; i < respon.length ; i++)
          {
            option += '<option value="'+respon[i].branch_id+'" branch_code="'+respon[i].branch_code+'" branch_name="'+respon[i].branch_name+'">'+respon[i].branch_code+' - '+respon[i].branch_name+'</option>';
          }
          $("#result","#dialog_branch").html(option);
        }
      });
  });

  $("#result option","#dialog_branch").live('dblclick',function(){
    $("#select","#dialog_branch").trigger('click');
  });

  $("input#keyword","#dialog_branch").keypress(function(e){
    if(e.which==13){
      $.ajax({
        type: "POST",
        dataType: "json",
        url: site_url+"transaction/search_branch_by_keyword",
        data: {keyword:$(this).val()},
        async: false,
        success: function(respon){
          option = '';
          for(i = 0 ; i < respon.length ; i++)
          {
            option += '<option value="'+respon[i].branch_id+'" branch_code="'+respon[i].branch_code+'" branch_name="'+respon[i].branch_name+'">'+respon[i].branch_code+' - '+respon[i].branch_name+'</option>';
          }
          $("#result","#dialog_branch").html(option);
        }
      });
    }
  });

  // select
  $("#select","#dialog_branch").click(function(){
    branch_name = $("#result option:selected","#dialog_branch").attr('branch_name');
    branch_code = $("#result option:selected","#dialog_branch").attr('branch_code');
    branch_id = $("#result","#dialog_branch").val();
    $("#src_branch_name").val(branch_name);
    $("#branch_code").val(branch_code);
    $("#branch_id").val(branch_id);
    $(".close","#dialog_branch").click();
  });

  $("#search").click(function(){
      $("#rembug_pusat").val($("#result option:selected").attr('cm_name'));
      $("span.rembug").text('"'+$("#result option:selected").attr('cm_name')+'"');
      $("#close","#dialog_rembug").trigger('click');

      // begin first table
      table=$('#transaksi_kas_petugas').dataTable({
         "bDestroy":true,
         "bProcessing": true,
         "bServerSide": true,
         "sAjaxSource": site_url+"transaction/datatable_verifikasi_trx_rembug",
         "fnServerParams": function ( aoData ) {
              aoData.push( { "name": "branch_id", "value": $("#branch_id").val() } );
              aoData.push( { "name": "branch_code", "value": $("#branch_code").val() } );
              aoData.push( { "name": "trx_date", "value": $("#src_trx_date").val() } );
          },
         "aoColumns": [
            null,
            null,
            null,
            { "bSortable": false, "bSearchable": false }
          ],
          "aLengthMenu": [
              [5, 15, 20, -1],
              [5, 15, 20, "All"] // change per page values here
          ],
          // set the initial value
          "iDisplayLength": 15,
          "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
          "sPaginationType": "bootstrap",
          "oLanguage": {
              "sLengthMenu": "_MENU_ records per page",
              "oPaginate": {
                  "sPrevious": "Prev",
                  "sNext": "Next"
              }
          },
          "aoColumnDefs": [{
                  'bSortable': false,
                  'aTargets': [3]
              }
          ]
      });
      $(".dataTables_length,.dataTables_filter").parent().hide();
  })

  // fungsi untuk reload data table
  // di dalam fungsi ini ada variable tbl_id
  // gantilah value dari tbl_id ini sesuai dengan element nya
  var dTreload = function()
  {
    var tbl_id = 'transaksi_kas_petugas';
    $("select[name='"+tbl_id+"_length']").trigger('change');
    $(".paging_bootstrap li:first a").trigger('click');
    $("#"+tbl_id+"_filter input").val('').trigger('keyup');
  }

  // begin first table
  table=$('#transaksi_kas_petugas').dataTable({
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": site_url+"transaction/datatable_verifikasi_trx_rembug",
      "fnServerParams": function ( aoData ) {
              aoData.push( { "name": "branch_id", "value": $("#branch_id").val() } );
              aoData.push( { "name": "branch_code", "value": $("#branch_code").val() } );
              aoData.push( { "name": "trx_date", "value": $("#src_trx_date").val() } );
          },
      "aoColumns": [
        null,
        null,
        null,
        { "bSortable": false, "bSearchable": false }
      ],
      "aLengthMenu": [
          [5, 15, 20, -1],
          [5, 15, 20, "All"] // change per page values here
      ],
      // set the initial value
      "iDisplayLength": 15,
      "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
      "sPaginationType": "bootstrap",
      "oLanguage": {
          "sLengthMenu": "_MENU_ records per page",
          "oPaginate": {
              "sPrevious": "Prev",
              "sNext": "Next"
          }
      },
      "aoColumnDefs": [{
              'bSortable': false,
              'aTargets': [3]
          }
      ]
  });
  $(".dataTables_length,.dataTables_filter").parent().hide();

  // event button Edit ketika di tekan
  $("a#link-verifikasi").live('click',function(){
    $("#wrapper-table").hide();
    $("#edit").show();
    var trx_cm_save_id = $(this).attr('trx_cm_save_id');
    $("#trx_cm_save_id").val(trx_cm_save_id);

    $("#fa_code","#process_trx_rembug").val($(this).attr('fa_code'));
    $("#account_cash_code","#process_trx_rembug").val($(this).attr('account_cash_code'));
    $("#cm_code","#process_trx_rembug").val($(this).attr('cm_code'));
    $("#branch_code","#process_trx_rembug").val($(this).attr('branch_code'));
    $("#branch_id","#process_trx_rembug").val($(this).attr('branch_id'));
    $("#tanggal2","#process_trx_rembug").val($(this).attr('tanggal2'));

    $("#view_branch_name").val($(this).attr('branch_name'));
    $("#view_cm_name").val($(this).attr('cm_name'));
    $("#view_trx_date").val($(this).attr('trx_date'));
    $("#view_account_cash_name").val($(this).attr('account_cash_name'));


    /* loading */
    // [begin] generate from transaksi rembug
    $.ajax({
        url: site_url+"transaction/get_trx_rembug_data",
        type: "POST",
        dataType: "json",
        data: { cm_code : $("input[name='cm_code']").val(), account_cash_code : $("input[name='account_cash_code']").val(), tanggal : $("#src_trx_date").val() },
        async: false,
        success: function(respon){
          html = '';
          total_angsuran = 0;
          response = respon['data'];
          mutasi = respon['mutasi'];
          total_realisasi_plafon = 0;
          total_realisasi_adm = 0;
          total_realisasi_asuransi = 0;
          total_setoran_tab_berencana = 0;
          total_setoran_minggon = 0;
          if(response.length>0)
          {
            for ( i = 0 ; i < response.length ; i++ )
            {
              tabungan_berencana = '';
              total_biaya_administrasi = 0;
              for ( h = 0 ; h < respon['tab_berencana'][i].length ; h++ )
              {
                counter_angsruan = respon['tab_berencana'][i][h].counter_angsruan;

                biaya_administrasi = 0;
                // if (counter_angsruan==0) {
                //   biaya_administrasi = respon['tab_berencana'][i][h].biaya_administrasi;
                // }
                total_biaya_administrasi += parseFloat(biaya_administrasi);
                tabungan_berencana += ' \
                  <tr> \
                    <td style="border:solid 1px #CCC;padding:3px 5px;"><input type="hidden" id="biaya_adm" name="detail_berencana_biaya_administrasi['+i+'][]" value="'+biaya_administrasi+'"><input type="hidden" name="detail_berencana_account_no['+i+'][]" value="'+respon['tab_berencana'][i][h].account_saving_no+'" id="detail_berencana_account_no">'+respon['tab_berencana'][i][h].account_saving_no+'</td> \
                    <td style="border:solid 1px #CCC;padding:3px 5px;">'+respon['tab_berencana'][i][h].product_name+'<input type="hidden" name="detail_berencana_product_code['+i+'][]" value="'+respon['tab_berencana'][i][h].product_code+'"></td> \
                    <td style="border:solid 1px #CCC;padding:3px;" align="center">'+respon['tab_berencana'][i][h].rencana_setoran+'</td> \
                    <td style="border:solid 1px #CCC;padding:3px;" align="center"><input type="text" name="detail_berencana_freq['+i+'][]" id="detail_berencana_freq" maxlength="2" value="0" style="text-align:center;width:20px;margin:0;background:#CCC" class="m-wrap" readonly="readonly"><input type="hidden" id="detail_berencana_setoran" name="detail_berencana_setoran['+i+'][]" value="'+respon['tab_berencana'][i][h].rencana_setoran+'"></td> \
                  </tr> \
                ';
              }
              // total_angsuran += parseFloat(response[i].jumlah_angsuran);
              total_realisasi_plafon += parseFloat(response[i].pokok);
              total_realisasi_adm += parseFloat(response[i].adm);
              total_realisasi_asuransi += parseFloat(response[i].asuransi);
              total_setoran_tab_berencana += parseFloat(response[i].setoran_berencana)+total_biaya_administrasi;
              minggon = parseFloat(response[i]['setoran_mingguan'])+parseFloat(response[i]['setoran_lwk']);
              total_setoran_minggon+=parseFloat(minggon);
              console.log(total_setoran_minggon);

              if(response[i].status==3){
                mutasi[i].account_financing_no=(mutasi[i].account_financing_no!=null)?mutasi[i].account_financing_no:'';
                mutasi[i].periode_jangka_waktu=(response[i].periode_jangka_waktu!=null)?response[i].periode_jangka_waktu:'';
                mutasi[i].counter_angsuran=(response[i].counter_angsuran!=null)?response[i].counter_angsuran:'';
                mutasi[i].angsuran_pokok=(mutasi[i].angsuran_pokok>0)?mutasi[i].angsuran_pokok:0;
                mutasi[i].angsuran_margin=(mutasi[i].angsuran_margin>0)?mutasi[i].angsuran_margin:0;
                mutasi[i].jangka_waktu=(mutasi[i].jangka_waktu>0)?mutasi[i].jangka_waktu:0;

                if(mutasi[i].flag_saldo_margin==1){
                  status_angsuran_margin=1;
                }else{
                  status_angsuran_margin=0;
                }
                status_angsuran_catab=0;
                status_angsuran_tab_wajib=0;
                status_angsuran_tab_kelompok=0;
                muqosha=mutasi[i].potongan_pembiayaan;
                freq_angsuran=(mutasi[i].freq_sisa_angsuran!=null)?mutasi[i].freq_sisa_angsuran:0;
                v_jumlah_angsuran=parseFloat(mutasi[i].angsuran_pokok)+parseFloat(mutasi[i].angsuran_margin);
                balance_pokok_pembiayaan=mutasi[i].saldo_pembiayaan_pokok;
                balance_margin_pembiayaan=mutasi[i].saldo_pembiayaan_margin;
                pembiayaan_saldo_pokok=mutasi[i].saldo_pembiayaan_pokok;
                pembiayaan_saldo_margin=mutasi[i].saldo_pembiayaan_margin;
                v_angsuran_pokok=mutasi[i].angsuran_pokok;
                v_angsuran_margin=mutasi[i].angsuran_margin;
                v_account_financing_no=mutasi[i].account_financing_no;
                v_jangka_waktu=mutasi[i].jangka_waktu;
                v_periode_jangka_waktu=mutasi[i].periode_jangka_waktu;
                v_counter_angsuran=mutasi[i].counter_angsuran;
              }else{
                status_angsuran_margin=1;
                status_angsuran_catab=1;
                status_angsuran_tab_wajib=1;
                status_angsuran_tab_kelompok=1;
                muqosha=0;
                freq_angsuran=((response[i].jumlah_angsuran>0)?1:0);
                v_jumlah_angsuran = response[i].jumlah_angsuran;
                balance_pokok_pembiayaan=response[i].pokok_pembiayaan;
                balance_margin_pembiayaan=response[i].margin_pembiayaan;
                pembiayaan_saldo_pokok=response[i].saldo_pokok;
                pembiayaan_saldo_margin=response[i].saldo_margin;
                v_angsuran_pokok=response[i].angsuran_pokok;
                v_angsuran_margin=response[i].angsuran_margin;
                v_account_financing_no=response[i].account_financing_no;
                v_jangka_waktu=response[i].jangka_waktu;
                v_periode_jangka_waktu=response[i].periode_jangka_waktu;
                v_counter_angsuran=response[i].counter_angsuran;
              }
              total_angsuran += v_jumlah_angsuran*freq_angsuran;

              var akumulasi_penarikan_tab_sukarela = parseFloat(mutasi[i].saldo_pembiayaan_catab)+parseFloat(mutasi[i].saldo_tab_wajib)+parseFloat(mutasi[i].saldo_tab_kelompok)+parseFloat(mutasi[i].saldo_tab_sukarela)+parseFloat(mutasi[i].saldo_tab_berencana)+parseFloat(mutasi[i].saldo_deposito)+parseFloat(mutasi[i].saldo_cadangan_resiko)+parseFloat(mutasi[i].saldo_simpanan_pokok)+parseFloat(mutasi[i].saldo_smk)+parseFloat(mutasi[i].saldo_individu)+parseFloat(mutasi[i].bonus_bagihasil)+parseFloat(mutasi[i].saldo_tab_minggon)+parseFloat(mutasi[i].saldo_lwk)+parseFloat(mutasi[i].infaq)+parseFloat(mutasi[i].saldo_simpanan_wajib);

              html += ' \
              <tr '+((response[i].status==3)?'bgcolor="#55ACEE"':'')+'> \
                <td style="padding:0 5px; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" align="center">'+response[i].cif_no+'<input type="hidden" name="cif_no[]" id="cif_no" value="'+response[i].cif_no+'"></td> \
                <td style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">'+response[i].nama+'</td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;"> \
                  <input type="hidden" id="absen" name="absen[]"> \
                  <select disabled readonly id="vabsen" style="width:50px;margin-top:2px;margin-bottom:2px;"> \
                    <option>H</option> \
                    <option>I</option> \
                    <option>S</option> \
                    <option>A</option> \
                  </select> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="hidden" name="account_financing_no[]" id="account_financing_no" value="'+v_account_financing_no+'"> \
                  <input type="hidden" name="status_angsuran_margin[]" id="status_angsuran_margin" value="'+status_angsuran_margin+'"> \
                  <input type="hidden" name="status_angsuran_catab[]" id="status_angsuran_catab" value="'+status_angsuran_catab+'"> \
                  <input type="hidden" name="status_angsuran_tab_wajib[]" id="status_angsuran_tab_wajib" value="'+status_angsuran_tab_wajib+'"> \
                  <input type="hidden" name="status_angsuran_tab_kelompok[]" id="status_angsuran_tab_kelompok" value="'+status_angsuran_tab_kelompok+'"> \
                  <input type="hidden" name="angsuran_pokok[]" id="angsuran_pokok" value="'+v_angsuran_pokok+'"> \
                  <input type="hidden" name="angsuran_margin[]" id="angsuran_margin" value="'+v_angsuran_margin+'"> \
                  <input type="hidden" name="hide_angsuran_margin[]" id="hide_angsuran_margin" value="'+response[i].angsuran_margin+'"> \
                  <input type="hidden" name="angsuran_catab[]" id="angsuran_catab" value="'+response[i].angsuran_catab+'"> \
                  <input type="hidden" name="hide_angsuran_catab[]" id="hide_angsuran_catab" value="'+response[i].angsuran_catab+'"> \
                  <input type="hidden" name="angsuran_tab_wajib[]" id="angsuran_tab_wajib" value="'+response[i].angsuran_tab_wajib+'"> \
                  <input type="hidden" name="hide_angsuran_tab_wajib[]" id="hide_angsuran_tab_wajib" value="'+response[i].angsuran_tab_wajib+'"> \
                  <input type="hidden" name="angsuran_tab_kelompok[]" id="angsuran_tab_kelompok" value="'+response[i].angsuran_tab_kelompok+'"> \
                  <input type="hidden" name="hide_angsuran_tab_kelompok[]" id="hide_angsuran_tab_kelompok" value="'+response[i].angsuran_tab_kelompok+'"> \
                  <input type="hidden" name="balance_angsuran[]" id="balance_angsuran" value="'+response[i].angsuran+'"> \
                  <input type="hidden" name="balance_tabungan_wajib[]" id="balance_tabungan_wajib" value="'+response[i].tabungan_wajib+'"> \
                  <input type="hidden" name="balance_tabungan_minggon[]" id="balance_tabungan_minggon" value="'+response[i].tabungan_minggon+'"> \
                  <input type="hidden" name="balance_tabungan_sukarela[]" id="balance_tabungan_sukarela" value="'+response[i].tabungan_sukarela+'"> \
                  <input type="hidden" name="balance_transaksi_lain[]" id="balance_transaksi_lain" value="'+response[i].transaksi_lain+'"> \
                  <input type="hidden" name="balance_pokok_pembiayaan[]" id="balance_pokok_pembiayaan" value="'+balance_pokok_pembiayaan+'"> \
                  <input type="hidden" name="balance_margin_pembiayaan[]" id="balance_margin_pembiayaan" value="'+balance_margin_pembiayaan+'"> \
                  <input type="hidden" name="balance_catab_pembiayaan[]" id="balance_catab_pembiayaan" value="'+response[i].catab_pembiayaan+'"> \
                  <input type="hidden" name="balance_tabungan_kelompok[]" id="balance_tabungan_kelompok" value="'+response[i].tabungan_kelompok+'"> \
                  <input type="hidden" name="pembiayaan_saldo_pokok[]" id="pembiayaan_saldo_pokok" value="'+pembiayaan_saldo_pokok+'"> \
                  <input type="hidden" name="pembiayaan_saldo_margin[]" id="pembiayaan_saldo_margin" value="'+pembiayaan_saldo_margin+'"> \
                  <input type="hidden" name="pembiayaan_saldo_catab[]" id="pembiayaan_saldo_catab" value="'+response[i].saldo_catab+'"> \
                  <input type="hidden" name="pembiayaan_jangka_waktu[]" id="pembiayaan_jangka_waktu" value="'+v_jangka_waktu+'"> \
                  <input type="hidden" name="pembiayaan_periode_jangka_waktu[]" id="pembiayaan_periode_jangka_waktu" value="'+v_periode_jangka_waktu+'"> \
                  <input type="hidden" name="pembiayaan_counter_angsuran[]" id="pembiayaan_counter_angsuran" value="'+v_counter_angsuran+'"> \
                  <input type="hidden" name="muqosha[]" id="muqosha" value="'+muqosha+'"> \
                  <input type="hidden" name="status[]" id="status" value="'+response[i].status+'"> \
                  <input type="hidden" name="saldo_tab_wajib[]" id="saldo_tab_wajib" value="'+mutasi[i].saldo_tab_wajib+'"> \
                  <input type="hidden" name="saldo_tab_kelompok[]" id="saldo_tab_kelompok" value="'+mutasi[i].saldo_tab_kelompok+'"> \
                  <input type="hidden" name="bonus_bagihasil[]" id="bonus_bagihasil" value="'+mutasi[i].bonus_bagihasil+'"> \
                  <input type="text" readonly name="freq[]" id="freq" value="0" style="font-size:12px;width:20px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" name="jumlah_angsuran[]" class="mask-money" readonly id="jumlah_angsuran" value="'+v_jumlah_angsuran+'" style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" readonly class="mask-money" name="setoran_tabungan_sukarela[]" id="setoran_tabungan_sukarela" value="0" style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" name="setoran_minggon[]" id="setoran_minggon" value="'+number_format(minggon,0,',','.')+'" readonly style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
\
                               \
                    <!-- DIALOG MINGGON --> \
                    <div id="dialog_minggon_'+i+'" class="modal hide fade"  data-width="500" style="margin-top:-200px;"> \
                       <div class="modal-header"> \
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> \
                          <h4>Setoran Pokok <span id="minggon_cif">"'+response[i]['cif_no']+'"</span></h4> \
                       </div> \
                       <div class="modal-body"> \
                          <div class="row-fluid"> \
                             <div class="span12"> \
                                <table width="500"> \
                                  <tr> \
                                    <td width="150">LWK / Simpok</td> \
                                    <td width="10">:</td> \
                                    <td><input type="text" maxlength="10" class="mask-money" name="setoran_lwk[]" id="setoran_lwk" readonly style="#EEE" value="'+response[i]['setoran_lwk']+'"></td> \
                                  </tr> \
                                  <tr> \
                                    <td>Tabungan Majelis</td> \
                                    <td>:</td> \
                                    <td><input type="text" maxlength="10" class="mask-money" name="setoran_mingguan[]" id="setoran_mingguan" readonly value="'+response[i]['setoran_mingguan']+'"></td> \
                                  </tr> \
                                </table> \
                             </div> \
                          </div> \
                       </div> \
                       <div class="modal-footer"> \
                          <button type="button" id="close" style="display:none;" data-dismiss="modal" class="btn">Close</button> \
                          <button type="button" id="btnoksetminggon" formid="'+i+'" class="btn blue">OK</button> \
                       </div> \
                    </div> \
                    <a href="#dialog_minggon_'+i+'" id="open_dialog_minggon" style="display:none;" data-toggle="modal">open</a> \
 \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;"> \
                  <input type="text" name="setoran_tab_berencana[]" readonly id="setoran_tab_berencana" value="'+number_format(response[i].setoran_berencana+total_biaya_administrasi,0,',','.')+'" style="text-align:right; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                  <input type="hidden" name="setoran_tab_berencana_product_code[]" id="setoran_tab_berencana_product_code" value="'+response[i].product_code+'"> \
 \
                               \
                    <!-- DIALOG TABUNGAN BERENCANA --> \
                    <div id="dialog_tabungan_berencana_'+i+'" class="modal hide fade"  data-width="500" style="margin-top:-200px;"> \
                       <div class="modal-header"> \
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> \
                          <h3>Form Detil Setoran Tabungan Berencana</h3> \
                       </div> \
                       <div class="modal-body"> \
                          <div class="row-fluid"> \
                             <div class="span12"> \
                                <table width="100%"> \
                                  <thead> \
                                    <tr> \
                                      <th style="border:solid 1px #CCC;">Account</th> \
                                      <th style="border:solid 1px #CCC;">Produk</th> \
                                      <th style="border:solid 1px #CCC;">Setoran</th> \
                                      <th style="border:solid 1px #CCC;">Frekuensi</th> \
                                    </tr> \
                                  </thead> \
                                  <tbody> \
                                  '+tabungan_berencana+' \
                                  </tbody> \
                                </table> \
                             </div> \
                          </div> \
                          <div class="row-fluid" style="margin-top:10px"> \
                            <div class="span3 pull-right"> \
                              <label class="control-label pull-left">Biaya Administrasi</label> \
                              <input type="text" id="biaya_administrasi" name="biaya_administrasi_tab_berencana[]" readonly="readonly" class="m-wrap pull-right" style="background-color:#eee; padding: 4px 4px 4px 0px ! important; font-size: 14px; text-align: right; margin: 0px; width: 96%;" value="'+number_format(total_biaya_administrasi,0,',','.')+'"> \
                            </div> \
                          </div> \
                       </div> \
                       <div class="modal-footer"> \
                          <button type="button" id="close" style="display:none;" data-dismiss="modal" class="btn">Close</button> \
                          <button type="button" id="btnokfrmtaberencana" formid="'+i+'" class="btn blue">OK</button> \
                       </div> \
                    </div> \
                    <a href="#dialog_tabungan_berencana_'+i+'" id="open_dialog_tabungan_berencana" style="display:none;" data-toggle="modal">open</a> \
 \
                     \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;"> \
                  <input type="text" readonly name="penarikan_tabungan_sukarela[]" class="mask-money" id="penarikan_tabungan_sukarela" value="0" style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" name="realisasi_plafon[]" id="realisasi_plafon" class="mask-money" readonly value="'+response[i].pokok+'" style="background:#EEE; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                  <input type="hidden" name="realisasi_margin[]" id="realisasi_margin" class="mask-money" readonly value="'+response[i].margin+'" style="background:#EEE; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" name="realisasi_adm[]" id="realisasi_adm" readonly class="mask-money" value="'+response[i].adm+'" style="background:#EEE; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="hidden" name="droping[]" id="droping" value="'+response[i].droping+'"> \
                  <input type="text" name="realisasi_asuransi[]" readonly class="mask-money" id="realisasi_asuransi" value="'+response[i].asuransi+'" style="background:#EEE; font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <a href="#dialog_keterangan_'+i+'" id="browse_keterangan" class="btn mini blue" data-toggle="modal">...</a> \
                  <div id="dialog_keterangan_'+i+'" class="modal hide fade" tabindex="-1" data-width="330" style="margin-top:-200px;" data-keyboard="false" data-backdrop="static"> \
                    <div class="modal-header"> \
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> \
                      <h3>Keterangan</h3> \
                    </div> \
                    <div class="modal-body"> \
                    <textarea id="keterangan" name="keterangan[]" class="m-wrap large" reaonly style="background-color:#F5F5F5;"></textarea> \
                    </div> \
                    <div class="modal-footer"> \
                      <button type="button" id="ok_dialog_keterangan" class="btn blue" data-dismiss="modal">OK</button> \
                    </div> \
                  </div> \
                </td> \
              </tr> \
              ';
            }
            
            $("#total_angsuran").val(number_format(total_angsuran,0,',','.'));
            // $("#kas_awal").val(respon['kas_awal']);
            $("#form tbody").html(html);
            $("#total_minggon").val(number_format(total_setoran_minggon,0,',','.'));
            $("#total_realisasi_plafon").val(number_format(total_realisasi_plafon,0,',','.'));
            $("#total_realisasi_adm").val(number_format(total_realisasi_adm,0,',','.'));
            $("#total_realisasi_asuransi").val(number_format(total_realisasi_asuransi,0,',','.'));
            $("#total_setoran_tab_berencana").val(number_format(total_setoran_tab_berencana,0,',','.'));
            console.log(total_setoran_minggon);
            calc_setoran();
            calc_penarikan();
            calc_saldo_kas();
          }
          else
          {
            alert("Data Peserta Tidak Ditemukan !");
            html = ' \
              <tr> \
                <td style="padding:0 5px; border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" align="center">-</td> \
                <td style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;" align="center">-</td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;"> \
                  <select name="absen[]" id="absen" disabled style="width:50px;margin-top:8px"> \
                    <option>H</option> \
                    <option>I</option> \
                    <option>S</option> \
                    <option>A</option> \
                  </select> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:20px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #999;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;"> \
                  <input type="text" value="0" disabled style="font-size:12px;width:70px;padding:1px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> \
                </td> \
                <td align="center" valign="middle" style="padding:0 5px; border-right:solid 1px #CCC;border-bottom:solid 1px #CCC;">&nbsp;</td> \
              </tr> \
            ';
            // $("#total_angsuran").val(0);
            // $("#kas_awal").val(respon['kas_awal']);
            $("#realisasi_plafon").val(0);
            $("#realisasi_adm").val(0);
            $("#realisasi_asuransi").val(0);
            $("#form tbody").html(html);
          }
        }
      });
      // [end] generate transaksi rembug

      $("#infaq_kelompok","#process_trx_rembug").val(number_format($(this).attr('infaq'),0,',','.'));
      $("#kas_awal","#process_trx_rembug").val(number_format($(this).attr('kas_awal'),0,',','.'));

      $("#loading-overlay").css({
        height:$("#form").height(),
        width:$("#form").width(),
        backgroundColor:'rgba(0,0,0,.3)',
        position:'absolute',
        margin:'-25px 0 0 0'
      })    
      $.ajax({
        type: "POST",
        url: site_url+"transaction/get_trx_cm_save_detail",
        data: {
          trx_cm_save_id:trx_cm_save_id,
          cm_code:$("input[name='cm_code']").val()
        },
        dataType: "json",
        async: false,
        success: function(respon){
          // var i = 0;
          var data = respon.data;
          var data_berencana = respon.berencana;

          var total_setoran_tab_sukarela2 = 0;
          var total_setoran_minggon2 = 0;
          var total_setoran_tab_berencana2 = 0;
          var total_penarikan_tab_sukarela2 = 0;
          var total_angsuran = 0;

          for(i=0;i<data.length;i++){
            var parent = $("input[id=cif_no][value='"+data[i].cif_no+"']").parent().parent();
            if(data[i].account_financing_no!=null){
              var parent = $("input[id=account_financing_no][value='"+data[i].account_financing_no+"']").parent().parent();
            }
            setoran_minggon = parseFloat(data[i].setoran_mingguan)+parseFloat(data[i].setoran_lwk);
            total_setoran_minggon2 += parseFloat(setoran_minggon);
            total_setoran_tab_sukarela2 += parseFloat(data[i].setoran_tab_sukarela);
            // console.log('total_percalc:'+total_setoran_tab_sukarela2);
            // console.log('data_setoran_tab_sukarela:'+data[i].setoran_tab_sukarela);
            parent.children('td').find('#absen').val(data[i].absen);
            parent.children('td').find('#vabsen').val(data[i].absen);
            parent.children('td').find('#freq').val(data[i].frekuensi);
            parent.children('td').find('#muqosha').val(data[i].muqosha);
            parent.children('td').find('#setoran_tabungan_sukarela').val(number_format(data[i].setoran_tab_sukarela,0,',','.'));
            parent.children('td').find('#setoran_lwk').val(number_format(data[i].setoran_lwk,0,',','.'));
            parent.children('td').find('#setoran_mingguan').val(number_format(data[i].setoran_mingguan,0,',','.'));
            parent.children('td').find('#setoran_minggon').val(number_format(setoran_minggon,0,',','.'));
            parent.children('td').find('#penarikan_tabungan_sukarela').val(number_format(data[i].penarikan_tab_sukarela,0,',','.'));

            var status_angsuran_margin = data[i].status_angsuran_margin;
            var status_angsuran_catab = data[i].status_angsuran_catab;
            var status_angsuran_tab_wajib = data[i].status_angsuran_tab_wajib;
            var status_angsuran_tab_kelompok = data[i].status_angsuran_tab_kelompok;
            var angsuran_margin = parseFloat(convert_numeric(parent.children('td').find('#angsuran_margin').val()));
            var angsuran_catab = parseFloat(convert_numeric(parent.children('td').find('#angsuran_catab').val()));
            var angsuran_tab_wajib = parseFloat(convert_numeric(parent.children('td').find('#angsuran_tab_wajib').val()));
            var angsuran_tab_kelompok = parseFloat(convert_numeric(parent.children('td').find('#angsuran_tab_kelompok').val()));
            var jumlah_angsuran = parseFloat(convert_numeric(parent.children('td').find('#jumlah_angsuran').val()));
            
            if(status_angsuran_margin==0){
              parent.children('td').find('#angsuran_margin').val(0);
              jumlah_angsuran -= parseFloat(angsuran_margin);
            }
            if(status_angsuran_catab==0){
              parent.children('td').find('#angsuran_catab').val(0);
              jumlah_angsuran -= parseFloat(angsuran_catab);
            }
            if(status_angsuran_tab_wajib==0){
              parent.children('td').find('#angsuran_tab_wajib').val(0);
              jumlah_angsuran -= parseFloat(angsuran_tab_wajib);
            }
            if(status_angsuran_tab_kelompok==0){
              parent.children('td').find('#angsuran_tab_kelompok').val(0);
              jumlah_angsuran -= parseFloat(angsuran_tab_kelompok);
            }

            /*
			parent.children('td').find('#setoran_tabungan_sukarela').val(number_format(data[i].setoran_tab_sukarela,0,',','.'));
            parent.children('td').find('#setoran_lwk').val(data[i].setoran_lwk);
            parent.children('td').find('#setoran_mingguan').val(data[i].setoran_mingguan);
			*/

            parent.children('td').find('#jumlah_angsuran').val(number_format(jumlah_angsuran,0,',','.'))


            /*KETERANGAN*/
            parent.children('td').find('#browse_keterangan').removeClass('blue');
            parent.children('td').find('#browse_keterangan').removeClass('purple');
            var warna_tombol_keterangan='blue';
            if(data[i].keterangan!='' || data[i].keterangan!=null){
              warna_tombol_keterangan='purple';
            }
            parent.children('td').find('#browse_keterangan').addClass(warna_tombol_keterangan);
            parent.children('td').find('#keterangan').val(data[i].keterangan);

            total_penarikan_tab_sukarela2 += (isNaN(parseFloat(data[i].penarikan_tab_sukarela))==true)?0:parseFloat(data[i].penarikan_tab_sukarela);
            var jumlah_angsuran = parseFloat(convert_numeric(parent.children('td').find('#jumlah_angsuran').val()));
            var frekuensi = data[i].frekuensi;
            total_angsuran += (isNaN(parseFloat(frekuensi*jumlah_angsuran))==true)?0:parseFloat(frekuensi*jumlah_angsuran);

            // console.log(data_berencana);
            var j = 0;
            var setoran_berencana2 = 0;
            $("input#detail_berencana_account_no",parent).each(function(){
              var parent_berencana = $(this).parent().parent();
              if(typeof(data_berencana[i][j])!="undefined"){
                biaya_adm = parseFloat($(this).parent().children('#biaya_adm').val());
                parent_berencana.children('td').find('#detail_berencana_account_no').val(data_berencana[i][j].account_saving_no);
                parent_berencana.children('td').find('#detail_berencana_setoran').val(number_format(data_berencana[i][j].amount,0,',','.'));
                parent_berencana.children('td').find('#detail_berencana_freq').val(data_berencana[i][j].frekuensi);
                hitung_setoran_berencana = parseFloat(data_berencana[i][j].amount)*parseFloat(data_berencana[i][j].frekuensi);
                setoran_berencana2 += parseFloat(hitung_setoran_berencana)+biaya_adm;
                // console.log(data_berencana[i][j]);
                // console.log(data_berencana[i][j].frekuensi);
              }
              j++;
            });
            parent.children('td').find('#setoran_tab_berencana').val(number_format(setoran_berencana2,0,',','.'));
            total_setoran_tab_berencana2 += parseFloat(setoran_berencana2);
            // console.log(parent.children('td').find('#setoran_tab_berencana'));
            // console.log(number_format(setoran_berencana2,0,',','.'));

            // $.ajax({
            //   type: "POST",
            //   dataType: "json",
            //   url: site_url+"transaction/get_trx_cm_save_berencana",
            //   data: {trx_cm_save_detail_id:data[i].trx_cm_save_detail_id},
            //   async: false,
            //   success: function(respon2){
            //     data2 = respon2;
            //     var j = 0;
            //     var setoran_berencana2 = 0;
            //     $("input#detail_berencana_account_no",parent).each(function(){
            //       var parent2 = $(this).parent().parent();
            //       if(typeof(data2[j])!="undefined"){
            //         parent2.children('td').find('#detail_berencana_account_no').val(data2[j].account_saving_no);
            //         parent2.children('td').find('#detail_berencana_setoran').val(number_format(data2[j].amount,0,',','.'));
            //         parent2.children('td').find('#detail_berencana_freq').val(data2[j].frekuensi);
            //         hitung_setoran_berencana = parseFloat(data2[j].amount)*parseFloat(data2[j].frekuensi);
            //         setoran_berencana2 += parseFloat(hitung_setoran_berencana);
            //       }
            //       j++;
            //     });
            //     parent.children('td').find('#setoran_tab_berencana').val(number_format(setoran_berencana2,0,',','.'));
            //     total_setoran_tab_berencana2 += parseFloat(setoran_berencana2);
            //   }
            // });
          }
          
          // $("input#cif_no").each(function(){
            // var parent = $(this).parent().parent();
            // setoran_minggon = parseFloat(convert_numeric(parent.children('td').find('#setoran_minggon').val()));
            // total_setoran_minggon2 += parseFloat(setoran_minggon);
          // });

          $("#total_angsuran","#process_trx_rembug").val(number_format(total_angsuran,0,',','.'));
          $("#total_setoran_tab_sukarela","#process_trx_rembug").val(number_format(total_setoran_tab_sukarela2,0,',','.'));
          $("#total_minggon").val(number_format(total_setoran_minggon2,0,',','.'));
          $("#total_setoran_tab_berencana","#process_trx_rembug").val(number_format(total_setoran_tab_berencana2,0,',','.'));
          $("#total_penarikan_tab_sukarela","#process_trx_rembug").val(number_format(total_penarikan_tab_sukarela2,0,',','.'));

          calc_setoran();
          calc_penarikan();
          calc_saldo_kas();
          $("#loading-overlay").css({
            height:0,
            width:0
          })   
        }
      })

  


  });
  
  jQuery('#deposito_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
  jQuery('#deposito_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
  //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown









  
  

  $("button#btnoksetminggon").live('click',function(){
    formid = $(this).attr('formid');
    // setoran_lwk = $("#setoran_lwk","#dialog_minggon_"+formid).val();
    // setoran_mingguan = $("#setoran_mingguan","#dialog_minggon_"+formid).val();
    // total_setoran_minggon = parseFloat(setoran_lwk)+parseFloat(setoran_mingguan);
    // $("#dialog_minggon_"+formid).parent().find("#setoran_minggon").val(total_setoran_minggon);
    
    // grand_total_setoran_minggon = 0;
    // $("input#setoran_minggon").each(function(){
    //   grand_total_setoran_minggon+= parseFloat($(this).val());
    // });
    // $("#total_minggon").val(grand_total_setoran_minggon);
    $("button#close","#dialog_minggon_"+formid).trigger('click');
    
    // calc_setoran();
    // calc_penarikan();
    // calc_saldo_kas();


  });
  

  $("button#btnokfrmtaberencana").live('click',function(){
    formid = $(this).attr('formid');
    total_tabungan_berencana = 0;
    $("input#detail_berencana_freq","#dialog_tabungan_berencana_"+formid).each(function(){
      total_tabungan_berencana += parseFloat($(this).val()) * parseFloat(convert_numeric($(this).parent().find("#detail_berencana_setoran").val()));
    });
    biaya_administrasi = parseFloat(convert_numeric($("#biaya_administrasi","#dialog_tabungan_berencana_"+formid).val()));
    setoran_tab_berencana = total_tabungan_berencana+biaya_administrasi;
    $("#dialog_tabungan_berencana_"+formid).parent().find("#setoran_tab_berencana").val(number_format(setoran_tab_berencana,0,',','.'));
    total_setoran_tabungan_berencana = 0;
    $("input#setoran_tab_berencana").each(function(){
      total_setoran_tabungan_berencana+= parseFloat(convert_numeric($(this).val()));
    });
    $("#total_setoran_tab_berencana").val(number_format(total_setoran_tabungan_berencana,0,',','.'));
    $("button#close","#dialog_tabungan_berencana_"+formid).trigger('click');
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });

  $("input#setoran_tab_berencana").live('dblclick',function(){
    $(this).parent().find('a').trigger('click');
  });

  $("input#setoran_minggon").live('dblclick',function(){
    $(this).parent().find('a').trigger('click');
    window.scrollTo(0,0);
  });
  
  function calc_setoran()
  {
    total_angsuran = parseFloat(convert_numeric($("#total_angsuran","#process_trx_rembug").val()));
    total_setoran_tab_sukarela = parseFloat(convert_numeric($("#total_setoran_tab_sukarela","#process_trx_rembug").val()));
    total_minggon = parseFloat(convert_numeric($("#total_minggon","#process_trx_rembug").val()));
    total_realisasi_adm = parseFloat(convert_numeric($("#total_realisasi_adm","#process_trx_rembug").val()));
    total_realisasi_asuransi = parseFloat(convert_numeric($("#total_realisasi_asuransi","#process_trx_rembug").val()));
    total_setoran_berencana = parseFloat(convert_numeric($("#total_setoran_tab_berencana","#process_trx_rembug").val()));
    var setoran = total_angsuran+total_setoran_tab_sukarela+total_minggon+total_realisasi_adm+total_realisasi_asuransi+total_setoran_berencana;
    
    $("#setoran").val(number_format(setoran,0,',','.'));
  }
  
  function calc_penarikan()
  {
    total_penarikan_tab_sukarela = parseFloat(convert_numeric($("#total_penarikan_tab_sukarela").val()));
    total_realisasi_plafon = parseFloat(convert_numeric($("#total_realisasi_plafon").val()));
    var penarikan = total_penarikan_tab_sukarela+total_realisasi_plafon;
    $("#penarikan").val(number_format(penarikan,0,',','.'));
  }

  function calc_saldo_kas()
  {
    kas_awal = parseFloat(convert_numeric($("#kas_awal").val()));
    if(isNaN(kas_awal)==true){
      kas_awal = 0;
    }
    infaq_kelompok = parseFloat(convert_numeric($("#infaq_kelompok").val()));
    if(isNaN(infaq_kelompok)==true){
      infaq_kelompok = 0;
    }
    setoran = parseFloat(convert_numeric($("#setoran").val()));
    if(isNaN(setoran)==true){
      setoran = 0;
    }
    penarikan = parseFloat(convert_numeric($("#penarikan").val()));
    if(isNaN(penarikan)==true){
      penarikan = 0;
    }
    saldo_kas = kas_awal+infaq_kelompok+setoran-penarikan;
    $("#saldo_kas").val(number_format(saldo_kas,0,',','.'));
  }

  /* hitung total setoran tabungan sukarela ************************************************/
  $("input#setoran_tabungan_sukarela","form#process_trx_rembug").live('keyup',function(){
    total_amount = 0;
    $("input#setoran_tabungan_sukarela").each(function(){
      total_amount += parseFloat($(this).val())
    });
    // $("#total_setoran_tab_sukarela").val(total_amount);
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });
  
  /* hitung total setoran minggon ************************************************/
  $("input#setoran_minggon","form#process_trx_rembug").live('keyup',function(){
    total_amount = 0;
    $("input#setoran_minggon").each(function(){
      total_amount += parseFloat($(this).val())
    });
    $("#total_minggon").val(total_amount);
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });
  
  /* hitung total penarikan tabungan sukarela ************************************************/
  $("input#penarikan_tabungan_sukarela","form#process_trx_rembug").live('keyup',function(){
    total_amount = 0;
    $("input#penarikan_tabungan_sukarela").each(function(){
      total_amount += parseFloat($(this).val())
    });
    $("#total_penarikan_tab_sukarela").val(total_amount);
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });
  
  /* hitung total realisasi plafon ************************************************/
  $("input#realisasi_plafon","form#process_trx_rembug").live('keyup',function(){
    total_amount = 0;
    $("input#realisasi_plafon").each(function(){
      total_amount += parseFloat($(this).val())
    });
    $("#total_realisasi_plafon").val(total_amount);
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });
  
  /* hitung total realisasi adm ************************************************/
  $("input#realisasi_adm","form#process_trx_rembug").live('keyup',function(){
    total_amount = 0;
    $("input#realisasi_adm").each(function(){
      total_amount += parseFloat($(this).val())
    });
    $("#total_realisasi_adm").val(total_amount);
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });
  
  /* hitung total realisasi asuransi ************************************************/
  $("input#realisasi_asuransi","form#process_trx_rembug").live('keyup',function(){
    total_amount = 0;
    $("input#realisasi_asuransi").each(function(){
      total_amount += parseFloat($(this).val())
    });
    $("#total_realisasi_asuransi").val(total_amount);
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });

  $("#infaq_kelompok").keyup(function(){
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });

  $("#kas_awal").keyup(function(){
    calc_setoran();
    calc_penarikan();
    calc_saldo_kas();
  });

  $("#save_trx").click(function(){
    var conf = confirm("Approve Transaksi, Apakah anda yakin ?");
    if(conf)
    {
      dont_block = true;

      $.blockUI({ message: '<div style="padding:5px 0;">Sedang Mengecek, Mohon Tunggu...</div>' ,css: { backgroundColor: '#fff', color: '#000', fontSize: '12px'} })
      $.ajax({
        type: "POST",
        dataType: "json",
        data: $("#process_trx_rembug").serialize(),
        url: site_url+"transaction/process_trx_rembug",
        timeout: 120000,
        success: function(response){
          $.unblockUI();
          if(response.success===true){
			  $.alert({
				  title:'Alhamdulillah',
				  icon:'icon-check',
				  backgroundDismiss:false,
				  content:response.message,
				  confirmButtonClass:'btn green',
				  confirm:function(){
					  $("#cancel_trx").trigger('click');
					  $("#wrapper-table").show();
					  $("#edit").hide();
					  table.fnReloadAjax();
					  App.scrollTo(0, -200);
					  trx_cm_save_id = $("#trx_cm_save_id").val();
				  }
			  });
          }else{
			  $.alert({
				  title:'Astagfirullah!',
				  icon:'icon-warning-sign',
				  backgroundDismiss:false,
				  content:response.message,
				  confirmButtonClass:'btn yellow',
				  confirm:function(){
					  $("#cancel_trx").trigger('click');
				  }
			  });
          }
        },
        error: function(response){
			$.unblockUI();

			$.alert({
				title:'Astagfirullah!',
				icon:'icon-warning-sign',
				backgroundDismiss:false,
				content:'Verifikasi Transaksi Majelis Gagal. Koneksi Anda tidak stabil. Harap hubungi IT Support secepatnya',
				confirmButtonClass:'btn yellow',
				confirm:function(){
					$("#cancel_trx").trigger('click');
				}
			});

			// WRITE LOG
			url=window.location.href;
			status=response.status;
			statusText=response.statusText;
			responseText=response.responseText;
			App.write_error_log(url,status,statusText,responseText);
        }
      });
    }
  });

  $("#reject_trx").click(function(){

    var conf = confirm("Reject Transaksi, Apakah anda yakin ?");
    if(conf)
    {
      trx_cm_save_id = $("#trx_cm_save_id").val();
      $.ajax({
        type: "POST",
        dataType: "json",
        url: site_url+"transaction/reject_trx_rembug",
        data: {trx_cm_save_id:trx_cm_save_id,cm_code:$("input[name='cm_code']").val()},
        success: function(respon){
          if(respon.success==true){
            alert(respon.message);
            $("#wrapper-table").show();
            $("#edit").hide();
            table.fnReloadAjax();
            App.scrollTo(0, -200);
            // trx_cm_save_id = $("#trx_cm_save_id").val();
            // $("#link-verifikasi[trx_cm_save_id='"+trx_cm_save_id+"']").parent().parent().parent().remove();
          }else{
            alert(respon.message);
          }
        },
        error: function(){
          alert("Failed to Connect into Databases, Please Contact Your Administrator!");
        }
      });
    }

  });

  $("#cancel_trx").click(function(){
      $("#wrapper-table").show();
      $("#edit").hide();
      table.fnReloadAjax();
      App.scrollTo(0, -200);
  });

  // --------------------------------------------------------------------
  //  KEYCODE (ASCII)
  // --------------------------------------------------------------------

  // --------------------------------------------------------------------
  //  [BEGIN] ABSEN
      
      /*DOWN*/
      $("select#absen","#form").live('keydown',function(e){
        if(e.keyCode==9){
          $(this).parent().parent().next().find("#absen").focus();
          return false;
        }
      });

      /*DOWN+NEXT*/
      $("tr:last-child select#absen","#form").live('keydown',function(e){
        if(e.keyCode==9){
          $('tr:first-child #freq').focus()
          return false;
        }
      });
      
      /*UP+PREVIOUS*/
      $("tr:first-child select#absen","#form").live('keydown',function(e){
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
      });

      /*UP*/
      $("select#absen","#form").live('keydown',function(e){
        if(e.shiftKey && e.keyCode==9){
          $(this).parent().parent().prev().find("#absen").focus();
          return false;
        }
      });

  //  [END] ABSEN
  // --------------------------------------------------------------------
  // --------------------------------------------------------------------
  //  [BEGIN] FREKUENSI

      /*UP*/
      $("input#freq","#form").live('keydown',function(e){
        if(e.keyCode==38){
          $(this).parent().parent().prev().find("#freq").select();
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });
      
      /*UP+PREVIOUS*/
      $("tr:first-child input#freq","#form").live('keydown',function(e){
        if(e.keyCode==38){
          $('tr:last-child #absen').focus()
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });
      
      /*DOWN*/
      $("input#freq","#form").live('keydown',function(e){
        if(e.keyCode==40){
          $(this).parent().parent().next().find("#freq").select();
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });

      /*DOWN+NEXT*/
      $("tr:last-child input#freq","#form").live('keydown',function(e){
        if(e.keyCode==40){
          $('tr:first-child #setoran_tabungan_sukarela').select()
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });

  //  [END] FREKUENSI
  // --------------------------------------------------------------------

  // --------------------------------------------------------------------
  //  [BEGIN] SETORAN TABUNGAN SUKARELA

      /*UP*/
      $("input#setoran_tabungan_sukarela","#form").live('keydown',function(e){
        if(e.keyCode==38){
          $(this).parent().parent().prev().find("#setoran_tabungan_sukarela").select();
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });
      
      /*UP+PREVIOUS*/
      $("tr:first-child input#setoran_tabungan_sukarela","#form").live('keydown',function(e){
        if(e.keyCode==38){
          $('tr:last-child #freq').select()
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });

      /*DOWN*/
      $("input#setoran_tabungan_sukarela","#form").live('keydown',function(e){
        if(e.keyCode==40){
          $(this).parent().parent().next().find("#setoran_tabungan_sukarela").select();
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });

      /*DOWN+NEXT*/
      $("tr:last-child input#setoran_tabungan_sukarela","#form").live('keydown',function(e){
        if(e.keyCode==40){
          $('tr:first-child #penarikan_tabungan_sukarela').select()
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });

  //  [END] SETORAN TABUNGAN SUKARELA
  // --------------------------------------------------------------------

  // --------------------------------------------------------------------
  //  [BEGIN] minggon

      /*UP*/
      // $("input#setoran_minggon","#form").live('keydown',function(e){
      //   if(e.keyCode==38){
      //     $(this).parent().parent().prev().find("#setoran_minggon").select();
      //     return false;
      //   }
      //   if(e.shiftKey && e.keyCode==9){
      //     return false;
      //   }
      //   if(e.keyCode==9){
      //     return false;
      //   }
      // });
      
      // /*UP+PREVIOUS*/
      // $("tr:first-child input#setoran_minggon","#form").live('keydown',function(e){
      //   if(e.keyCode==38){
      //     $('tr:last-child #setoran_tabungan_sukarela').select()
      //     return false;
      //   }
      //   if(e.shiftKey && e.keyCode==9){
      //     return false;
      //   }
      //   if(e.keyCode==9){
      //     return false;
      //   }
      // });

      // DOWN
      // $("input#setoran_minggon","#form").live('keydown',function(e){
      //   if(e.keyCode==40){
      //     $(this).parent().parent().next().find("#setoran_minggon").select();
      //     return false;
      //   }
      //   if(e.shiftKey && e.keyCode==9){
      //     return false;
      //   }
      //   if(e.keyCode==9){
      //     return false;
      //   }
      // });

      // /*DOWN+NEXT*/
      // $("tr:last-child input#setoran_minggon","#form").live('keydown',function(e){
      //   if(e.keyCode==40){
      //     $('tr:first-child #penarikan_tabungan_sukarela').select()
      //     return false;
      //   }
      //   if(e.shiftKey && e.keyCode==9){
      //     return false;
      //   }
      //   if(e.keyCode==9){
      //     return false;
      //   }
      // });

  //  [END] minggon
  // --------------------------------------------------------------------

  // --------------------------------------------------------------------
  //  [BEGIN] PENARIKAN TAB SUKARELA

      /*UP*/
      $("input#penarikan_tabungan_sukarela","#form").live('keydown',function(e){
        if(e.keyCode==38){
          $(this).parent().parent().prev().find("#penarikan_tabungan_sukarela").select();
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });
      
      /*UP+PREVIOUS*/
      $("tr:first-child input#penarikan_tabungan_sukarela","#form").live('keydown',function(e){
        if(e.keyCode==38){
          $('tr:last-child #setoran_tabungan_sukarela').select()
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });

      /*DOWN*/
      $("input#penarikan_tabungan_sukarela","#form").live('keydown',function(e){
        if(e.keyCode==40){
          $(this).parent().parent().next().find("#penarikan_tabungan_sukarela").select();
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });

      /*DOWN+NEXT*/
      $("tr:last-child input#penarikan_tabungan_sukarela","#form").live('keydown',function(e){
        if(e.keyCode==40){
          $('#kas_awal').select()
          return false;
        }
      });

  //  [END] PENARIKAN TAB SUKARELA
  // --------------------------------------------------------------------
  //  [BEGIN] KAS AWAL

      //PREVIOUS
      $("#kas_awal","#form").live('keydown',function(e){
        if(e.keyCode==38){
          $('tr:last-child input#penarikan_tabungan_sukarela').select()
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });
      //NEXT
      $("#kas_awal","#form").live('keydown',function(e){
        if(e.keyCode==40){
          $('#infaq_kelompok').select()
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });

  // [END] KAS AWAL
  // --------------------------------------------------------------------
  // [BEGIN] INFAQ KELOMPOK
      // PREVIOUS
      $("#infaq_kelompok","#form").live('keydown',function(e){
        if(e.keyCode==38){
          $('#kas_awal').select()
          return false;
        }
        if(e.shiftKey && e.keyCode==9){
          return false;
        }
        if(e.keyCode==9){
          return false;
        }
      });
  // [END] INFAQ KELOMPOK









  


});
</script>

<!-- END JAVASCRIPTS
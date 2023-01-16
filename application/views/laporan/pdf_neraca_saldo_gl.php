<page backbottom="10mm">
<page_footer><div style="text-align:center;width:100%;">([[page_cu]])</div></page_footer>
<h4 align="center" style="line-height:20px;"><?php echo $this->session->userdata('institution_name').'<br>'.$branch_name.'<br>NERACA SALDO'; ?></h4>
<table>
    <tr>
        <td>Periode</td>
        <td>:</td>
        <td><?php echo $periode1.' s.d '.$periode2; ?></td>
    </tr>
</table>
<hr size="1">
<br>
<table width="100" cellspacing="0" cellpadding="0" align="center">
    <thead>
        <tr>
            <th width="15" align="center" style="font-size:11px; background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:2px;">No</th>
            <th width="280" align="center" style="font-size:11px; background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:2px;">Account</th>
            <th width="90" align="center" style="font-size:11px; background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:2px;">Saldo Awal</th>
            <th width="90" align="center" style="font-size:11px; background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:2px;">Debet</th>
            <th width="90" align="center" style="font-size:11px; background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:2px;">Credit</th>
            <th width="90" align="center" style="font-size:11px; background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;padding:2px;">Saldo Akhir</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data as $row): ?>
        <tr>
            <td style="font-size:10px;padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" align="left"><?php echo $row['nomor'] ?></td>
            <td style="font-size:10px;padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC; white-space:normal; width:250;" align="left"><?php echo $row['account'] ?></td>
            <td style="font-size:10px;padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" align="right"><?php echo (($row['saldo_awal']=='')?'':number_format($row['saldo_awal'],2,',','.')) ?></td>
            <td style="font-size:10px;padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" align="right"><?php echo (($row['debit']=='')?'':number_format($row['debit'],2,',','.')) ?></td>
            <td style="font-size:10px;padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" align="right"><?php echo (($row['credit']=='')?'':number_format($row['credit'],2,',','.')) ?></td>
            <td style="font-size:10px;padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;" align="right"><?php echo (($row['saldo_akhir']=='')?'':number_format($row['saldo_akhir'],2,',','.')) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td style="font-size:10px;padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;background-color:#EEEEEE;" align="right"><?php echo number_format($total_debit,2,',','.') ?></td>
        <td style="font-size:10px;padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;background-color:#EEEEEE;" align="right"><?php echo number_format($total_credit,2,',','.') ?></td>
        <td></td>
    </tr>
</table>
</page>
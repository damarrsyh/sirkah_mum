<div style="width:100%;">
<div style="text-align:center;padding-top:10px;font-family:Arial;font-size:22px;">
    <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
</div>
<div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
    <?php echo $branch_name; ?>
</div>
<div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
    LAPORAN JURNAL TRANSAKSI
</div>
<div style="text-align:left;padding-top:20px;font-family:Arial;font-size:13px;">
    Tanggal : <?php echo date('d-m-Y',strtotime($from_date)); ?> s/d <?php echo date('d-m-Y',strtotime($thru_date)); ?>
</div>
<hr>
</div>

<div style="width:100%">
    <table cellpadding="0" cellspacing="0" align="center">
        <thead>
            <tr>
                <th width="30" style="vertical-align:middle;font-size:11px;padding:5px 0;text-align:center;border-bottom:solid 1px #ccc;border-top:solid 1px #ccc;border-left:solid 1px #ccc;">No</th>
                <th width="80" style="vertical-align:middle;font-size:11px;padding:5px 0;text-align:center;border-bottom:solid 1px #ccc;border-top:solid 1px #ccc;border-left:solid 1px #ccc;">Tgl.<br>Transaksi</th>
                <th width="80" style="vertical-align:middle;font-size:11px;padding:5px 0;text-align:center;border-bottom:solid 1px #ccc;border-top:solid 1px #ccc;border-left:solid 1px #ccc;">Tgl.<br>Voucher</th>
                <th width="150" style="vertical-align:middle;font-size:11px;padding:5px 0;text-align:center;border-bottom:solid 1px #ccc;border-top:solid 1px #ccc;border-left:solid 1px #ccc;">Keterangan</th>
                <th width="180" style="vertical-align:middle;font-size:11px;padding:5px 0;text-align:center;border-bottom:solid 1px #ccc;border-top:solid 1px #ccc;border-left:solid 1px #ccc;">Account</th>
                <th width="90" style="vertical-align:middle;font-size:11px;padding:5px 0;text-align:center;border-bottom:solid 1px #ccc;border-top:solid 1px #ccc;border-left:solid 1px #ccc;">Debit</th>
                <th width="90" style="vertical-align:middle;font-size:11px;padding:5px 0;text-align:center;border:solid 1px #ccc;">Credit</th>
            </tr>
        </thead>
        <tbody>
            <?php echo $html; ?>
        </tbody>
    </table>
</div>
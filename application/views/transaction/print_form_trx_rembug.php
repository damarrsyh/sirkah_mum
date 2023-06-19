<page style="font-size: 8px;">
<table>
	<tr>
		<td>
			<img src="<?php echo site_url('assets/img/logo-mum.jpeg'); ?>" width="61" height="62" />
		</td>
		<td>
			<table>
				<tr>
					<td colspan="2">
						<strong>REKAP TRANSAKSI HARIAN KSP MUM</strong>
					</td>
				</tr>
				<tr>
					<td width="40" style="height:14px;font-weight:bold;" valign="bottom">CABANG</td>
					<td width="200" style="height:14px;font-weight:bold;" valign="bottom">:&nbsp; <?php echo str_replace('%20',' ',$cabang); ?></td>
				</tr>
				<tr>
					<td style="height:14px;font-weight:bold;" valign="bottom">MAJELIS</td>
					<td style="height:14px;font-weight:bold;" valign="bottom">:&nbsp; <?php echo str_replace('%20',' ',$majelis); ?></td>
				</tr>
			</table>
		</td>
		<td width="580">&nbsp;</td>
		<td>
			<table cellspacing="0">
				<thead>
					<tr>
						<th style="background:#F7F7F7;padding:5px;width:100px;text-align:center;border:solid 1px #777;">TANGGAL</th>
						<th style="background:#F7F7F7;padding:5px;width:150px;text-align:center;border-right:solid 1px #777;border-bottom:solid 1px #777;border-top:solid 1px #777;">NAMA TPL</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="height:25px;border-bottom:solid 1px #777;border-right:solid 1px #777;border-left:solid 1px #777;">&nbsp;</td>
						<td style="height:25px;border-bottom:solid 1px #777;border-right:solid 1px #777;">&nbsp;</td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
</table>
<table cellspacing="0">
		<tr>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-top:solid 1px #777; border-bottom:solid 1px #000; border-right:solid 1px #777; border-left:solid 1px #777; text-align:center;width:22px; font-size:8px;" rowspan="3">NO</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-top:solid 1px #777; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center; width:60px; font-size:8px;" rowspan="3">NAMA</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-top:solid 1px #777; border-bottom:solid 1px #000; border-right:solid 1px #000; text-align:center; width:20px; font-size:8px;" rowspan="3">ABS</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777; text-align:center; font-size:8px;" colspan="2">PEMBIAYAAN AKTIF</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #000; text-align:center; font-size:8px;" colspan="12">SETORAN</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777; text-align:center; font-size:8px; width:120px; " colspan="4">SALDO-SALDO</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #000; text-align:center; width:60px; font-size:8px;" rowspan="3">PENARIKAN<br />SUKARELA</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777; text-align:center; font-size:8px;" colspan="2">REALISASI PEMBIAYAAN</td>
		</tr>
		<tr>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center;width:50px;" rowspan="2">Plafon</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center;width:40px;" rowspan="2">Tgl Akad</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #777; border-right:solid 1px #777; text-align:center;" colspan="6">Angsuran</td>

			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #000; text-align:center;width:40px;" rowspan="2">Simp.<br>Wajib</td>
			
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #000; text-align:center;width:40px;" rowspan="2">Tab.<br>Sukarela</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #777; border-right:solid 1px #000; text-align:center;" colspan="4">Tab.Berencana</td>

			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-top:solid 1px #777; border-bottom:solid 1px #000; border-right:solid 1px #000; text-align:center; font-size:8px; " rowspan="2">Wajib/<br/>Minggon</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-top:solid 1px #777; border-bottom:solid 1px #000; border-right:solid 1px #000; text-align:center; font-size:8px; " rowspan="2">Sukarela</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-top:solid 1px #777; border-bottom:solid 1px #000; border-right:solid 1px #000; text-align:center; font-size:8px; " rowspan="2">DTK</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-top:solid 1px #777; border-bottom:solid 1px #000; border-right:solid 1px #000; text-align:center; font-size:8px; " rowspan="2">Simpok/<br/>LWK</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center;width:60px;" rowspan="2">Plafon</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center;width:50px;" rowspan="2">Asuransi</td>
		</tr>
		<tr>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center;width:20px;">Sld</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center;width:20px;">Byr</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center;width:20px;">Tgk</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center;width:40px;">@</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center;width:20px;">Ext</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center;width:40px;">Jml Ext</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center;width:50px;">Produk</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center;width:20px;">Sld</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom:solid 1px #000; border-right:solid 1px #777; text-align:center;width:20px;">Byr</td>
			<td style="font-weight: bold; color: #333; padding-top:3px; padding-bottom:3px; border-bottom: 1solidpx #000; border-right:solid 1px #777; text-align:center;width:20px;">Jml</td>
		</tr>
		<?php 
		$total_jumlah_angsuran = 0;
		$total_setoran_mingguan = 0;
		$total_setoran_berencana = 0;
		$total_tabungan_minggon = 0;
		$total_tabungan_sukarela = 0;
		$total_tabungan_lwk = 0;
		$total_tabungan_dtk = 0;
		$total_adm = 0;
		$total_droping = 0;
		$total_asuransi = 0;
		$no = 1;
		foreach($data as $row): 
			if($row['jumlah_angsuran']!=''){
				$freq_bayar = (($row['jumlah_angsuran']>0)?1:0);
				$total_jumlah_angsuran += $freq_bayar*$row['jumlah_angsuran'];	
			}else{
				$freq_bayar = '';
			}
			$total_setoran_mingguan += $row['setoran_mingguan'];
			$total_setoran_berencana += $row['setoran_berencana'];
			$total_tabungan_minggon += $row['tabungan_minggon'];
			$total_tabungan_sukarela += $row['tabungan_sukarela'];
			$total_tabungan_lwk += $row['saldo_lwk'];
			$total_tabungan_dtk += $row['saldo_dtk'];
			$total_adm += $row['adm'];
			$total_droping += $row['droping'];
			$total_asuransi += $row['asuransi'];
		?>
		<tr>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; border-left:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:center;"><?php echo $row['no_urut'] ?></td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px;"><?php echo $row['nama'] ?></td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #000; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px;">&nbsp;</td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;"><?php if($row['pokok_pembiayaan']!="") echo number_format($row['pokok_pembiayaan'],0,',','.'); ?></td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:center;"><?php echo $row['tanggal_akad'] ?></td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:center;"><?php echo $row['freq_saldo_outstanding'] ?></td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:center;"><?php echo $row['counter_angsuran'] ?></td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:center;"><?php echo ($row['jumlah_angsuran']>0)?$row['freq_tunggakan']:''; ?></td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;"><?php if($row['jumlah_angsuran']>0) echo number_format($row['jumlah_angsuran'],0,',','.'); else ''; ?></td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:center;">&nbsp;</td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;">&nbsp;</td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;"><?php echo $row['setoran_mingguan']; ?></td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #000; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;">&nbsp;</td> 
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:left;"><?php echo $row['nick_name']; ?></td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;"><?php echo $row['taber_saldo_bayar']; ?></td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;">&nbsp;</td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #000; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;"><?php if($row['setoran_berencana']!="") echo number_format($row['setoran_berencana'],0,',','.'); ?></td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #000; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;"><?php if($row['tabungan_minggon']!="") echo number_format($row['tabungan_minggon'],0,',','.'); ?></td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #000; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;"><?php if($row['tabungan_sukarela']!="") echo number_format($row['tabungan_sukarela'],0,',','.'); ?></td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #000; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;"><?php if($row['saldo_dtk']!="") echo number_format($row['saldo_dtk'],0,',','.'); ?></td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #000; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;"><?php if($row['saldo_lwk']!="") echo number_format($row['saldo_lwk'],0,',','.'); ?></td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #000; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;">&nbsp;</td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;"><?php if($row['droping']!="") echo number_format($row['droping'],0,',','.'); ?></td>
			<td style="font-size:8px; color: #333; border-bottom:solid 1px #777; border-right:solid 1px #777; padding-top:5px; padding-right:3px; padding-left:3px; padding-bottom:5px; text-align:right;"><?php if($row['asuransi']!="") echo number_format($row['asuransi'],0,',','.'); ?></td>
		</tr>
		<?php 
		$no++;
		endforeach; 
		?>
		<tr>
			<td style="font-size:8px; padding:3px 5px; border-left:solid 1px #777;border-right:solid 1px #777;border-bottom:solid 1px #777; font-weight:bold; text-align:right;" colspan="8">TOTAL</td>
			<td style="font-size:8px; padding:3px 3px; border-right:solid 1px #777;border-bottom:solid 1px #777; font-weight:bold; text-align:right;"><?php echo number_format($total_jumlah_angsuran,0,',','.') ?></td>
			<td style="font-size:8px; padding:3px 3px; border-right:solid 1px #777;border-bottom:solid 1px #777; font-weight:bold;">&nbsp;</td>
			<td style="font-size:8px; padding:3px 3px; border-right:solid 1px #777;border-bottom:solid 1px #777; font-weight:bold;">&nbsp;</td>
			<td style="font-size:8px; padding:3px 3px; border-right:solid 1px #777;border-bottom:solid 1px #777; font-weight:bold; text-align:right;"><?php echo number_format($total_setoran_mingguan,0,',','.') ?></td>
			<td style="font-size:8px; padding:3px 3px; border-right:solid 1px #777;border-bottom:solid 1px #777; font-weight:bold;">&nbsp;</td>
			<td style="font-size:8px; padding:3px 3px; border-right:solid 1px #777;border-bottom:solid 1px #777; font-weight:bold;">&nbsp;</td>
			<td style="font-size:8px; padding:3px 3px; border-right:solid 1px #777;border-bottom:solid 1px #777; font-weight:bold;">&nbsp;</td>
			<td style="font-size:8px; padding:3px 3px; border-right:solid 1px #000;border-bottom:solid 1px #777; font-weight:bold;">&nbsp;</td>
			<td style="font-size:8px; padding:3px 3px; border-right:solid 1px #000;border-bottom:solid 1px #777; font-weight:bold;">&nbsp;</td>
			<td style="font-size:8px; padding:3px 3px; border-right:solid 1px #000;border-bottom:solid 1px #777; font-weight:bold; text-align:right;"><?php echo number_format($total_tabungan_minggon,0,',','.'); ?></td>
			<td style="font-size:8px; padding:3px 3px; border-right:solid 1px #000;border-bottom:solid 1px #777; font-weight:bold; text-align:right;"><?php echo number_format($total_tabungan_sukarela,0,',','.'); ?></td>
			<td style="font-size:8px; padding:3px 3px; border-right:solid 1px #000;border-bottom:solid 1px #777; font-weight:bold; text-align:right;"><?php echo number_format($total_tabungan_dtk,0,',','.'); ?></td>
			<td style="font-size:8px; padding:3px 3px; border-right:solid 1px #000;border-bottom:solid 1px #777; font-weight:bold; text-align:right;"><?php echo number_format($total_tabungan_lwk,0,',','.'); ?></td>
			<td style="font-size:8px; padding:3px 3px; border-right:solid 1px #000;border-bottom:solid 1px #777; font-weight:bold;">&nbsp;</td>
			<td style="font-size:8px; padding:3px 3px; border-right:solid 1px #777;border-bottom:solid 1px #777; font-weight:bold;"><?php echo number_format($total_droping,0,',','.'); ?></td>
			<td style="font-size:8px; padding:3px 3px; border-right:solid 1px #777;border-bottom:solid 1px #777; font-weight:bold;"><?php echo number_format($total_asuransi,0,',','.'); ?></td>
		</tr>
		<tr>
			<td colspan="3" style="text-align:center;width:140px;border-bottom:solid 1px #777; height:20px; border-right:solid 1px #777; border-right:solid 1px #777; border-left:solid 1px #777">isilah absen dengan kode<br />
			  <table cellspacing="1" cellpadding="0" style="margin:auto;">
			    <tr>
			      <td style="text-align:center;border:solid 1px #777;" width="20">H</td>
			      <td align="left" valign="bottom">&nbsp; Hadir</td>
			      <td style="text-align:center;border:solid 1px #777;" width="20">I</td>
			      <td align="left" valign="bottom">&nbsp; Izin</td>
		        </tr>
			    <tr>
			      <td style="text-align:center;border:solid 1px #777;" width="20">S</td>
			      <td align="left" valign="bottom">&nbsp; Sakit</td>
			      <td style="text-align:center;border:solid 1px #777;" width="20">A</td>
			      <td align="left" valign="bottom">&nbsp; Alfa</td>
		        </tr>
	        </table></td>
			<td colspan="11">
			  <table cellspacing="0" cellpadding="0" style="padding-left:8px;">
					<tr>
						<td style="background:#F7F7F7; width:80px; font-size:8px; line-height:15px; height:15px; text-align:center; font-weight:bold; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777; border-left:solid 1px #777">KAS AWAL</td>
						<td style="background:#F7F7F7; width:80px; font-size:8px; line-height:15px; height:15px; text-align:center; font-weight:bold; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777;">INFAQ</td>
						<td style="background:#F7F7F7; width:80px; font-size:8px; line-height:15px; height:15px; text-align:center; font-weight:bold; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777;">SETORAN</td>
						<td style="background:#F7F7F7; width:80px; font-size:8px; line-height:15px; height:15px; text-align:center; font-weight:bold; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777;">PENARIKAN</td>
						<td style="background:#F7F7F7; width:80px; font-size:8px; line-height:15px; height:15px; text-align:center; font-weight:bold; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777;">SALDO KAS</td>
					</tr>
					<tr>
						<td style="border-bottom:solid 1px #777; height:20px; border-right:solid 1px #777; border-right:solid 1px #777; border-left:solid 1px #777">&nbsp;</td>
						<td style="border-bottom:solid 1px #777; height:20px; border-right:solid 1px #777;">&nbsp;</td>
						<td style="border-bottom:solid 1px #777; height:20px; border-right:solid 1px #777;">&nbsp;</td>
						<td style="border-bottom:solid 1px #777; height:20px; border-right:solid 1px #777;">&nbsp;</td>
						<td style="border-bottom:solid 1px #777; height:20px; border-right:solid 1px #777;">&nbsp;</td>
					</tr>
				</table>
			</td>
			<td colspan="7" style="padding-left:5px;">
				<table cellspacing="0" cellpadding="0" align="left" style="padding-top:5px;">
					<thead>
						<tr>
							<td style="background:#F7F7F7; width:96px; font-size:8px; line-height:15px; height:15px; text-align:center; font-weight:bold; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777; border-left:solid 1px #777">Ttd. TPL</td>
							<td style="background:#F7F7F7; width:96px; font-size:8px; line-height:15px; height:15px; text-align:center; font-weight:bold; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777;">Ttd. Ketua Majelis</td>
							<td style="background:#F7F7F7; width:96px; font-size:8px; line-height:15px; height:15px; text-align:center; font-weight:bold; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777;">Ttd. ADM</td>
							<td style="background:#F7F7F7; width:96px; font-size:8px; line-height:15px; height:15px; text-align:center; font-weight:bold; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777;">Ttd. Pemeriksa</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="border-bottom:solid 1px #777; height:30px; border-right:solid 1px #777; border-right:solid 1px #777; border-left:solid 1px #777;">&nbsp;</td>
							<td style="border-bottom:solid 1px #777; height:30px; border-right:solid 1px #777; border-right:solid 1px #777;">&nbsp;</td>
							<td style="border-bottom:solid 1px #777; height:30px; border-right:solid 1px #777; border-right:solid 1px #777;">&nbsp;</td>
							<td style="border-bottom:solid 1px #777; height:30px; border-right:solid 1px #777; border-right:solid 1px #777;">&nbsp;</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
</table>



</page>

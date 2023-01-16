<style>
    table {
        border-collapse: collapse;
    }

    td {
        display: table-cell;
    }
</style>
<page orientation="portrait" style="font-size: 16px" backtop="0mm" backbottom="0mm" backleft="10mm" backright="10mm">
    
    <table style="width: 100%;" cellspacing="0">
        <tr>           
            <td>
                <img style="text-align: left; margin-left: -60px;  margin-top: -33px;" src="<?= base_url('assets/img/kop_akad_baik.png'); ?>" />
            </td>
        </tr>
    </table>
    
    <h4 style="text-align: center; margin-top: 10px; margin-bottom: 10px;">Aplikasi Pengajuan Pembiayaan</h4>
    <table cellspacing="0" style="width: 100%; border-collapse: collapse;" align="center">
        <tr>
            <td style="width: 49%; vertical-align: top;">
                <table cellspacing="0" style="width: 100%; border: solid 1px #dee2e6; vertical-align: top;">
                    <tr style="border: solid 1px #dee2e6;">
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            No Anggota
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">
                            :
                        </td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            <?= $no_anggota; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">Nama Lengkap</td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;"><?= $nama_lengkap; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">No KTP</td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;"><?= $no_ktp; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">Alamat</td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;"><?= $alamat; ?></td>
                    </tr>
                </table>
            </td>
            <td style="width: 2%;">
            </td>
            <td style="width: 49% ">
                <table cellspacing="0" style="width: 100%; border: solid 1px #dee2e6; vertical-align: top;">
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            Pembiayaan Ke
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            <?= $pembiayaan_ke; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            Jumlah Pengajuan
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            <?= $jumlah_pengajuan; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            Jangka Waktu
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            <?= $jangka_waktu; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            Peruntukan
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            <?= $peruntukan; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            Sumber Pengembalian
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            <?= ucfirst($sumber_pengembalian); ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            Tanggal Pengajuan
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            <?= $tanggal_pengajuan; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">Rencana Pencairan</td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;"><?= $rencana_pencairan; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            Keterangan
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            <?= $keterangan; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <h4 style="text-align: center; margin-top: 20px; margin-bottom: 10px;">Memorandum Analisis Pembiayaan</h4>
    <table cellspacing="0" style="width: 100%; border-collapse: collapse;" align="center">
        <tr>
            <td style="width: 49%; vertical-align: top;">
                <table cellspacing="0" style="width: 100%; border: solid 1px #dee2e6; vertical-align: top;">
                    <tr style="border: solid 1px #dee2e6;">
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            No Telp Anggota
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">
                            :
                        </td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            <?= $no_telp_anggota; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">Pekerjaan Anggota</td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;"><?= $pekerjaan_anggota; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">No Telp Pasangan</td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;"><?= $no_telp_suami; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            Pekerjaan Pasangan
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            <?= $pekerjaan_suami; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            Pendapatan Gaji
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                            <?= $pendapatan_gaji; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            Pendapatan Usaha
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                            <?= $pendapatan_usaha; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            Pendapatan Lainnya
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                            <?= $pendapatan_lainnya; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            Total Pendapatan
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                            <?= $total_pendapatan; ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 2%;">
            </td>
            <td style="width: 49%; vertical-align: top;">
                <table cellspacing="0" style="width: 100%; border: solid 1px #dee2e6; vertical-align: top;">
                    <tr style="border: solid 1px #dee2e6;">
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            Jumlah Tanggungan
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">
                            :
                        </td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                            <?= $jumlah_tanggungan; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            Biaya Rumah Tangga
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                            <?= $biaya_rumah_tangga; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            Biaya Rekening
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                            <?= $biaya_rekening; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            Biaya Kontrakan
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                            <?= $biaya_kontrakan; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            Biaya Pendidikan
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                            <?= $biaya_pendidikan; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            Hutang Lainnya
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                            <?= $hutang_lainnya; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            Total Biaya
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                            <?= $total_biaya; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            Saving Power
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                            <?= $saving_power; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                            Repayment Capacity
                        </td>
                        <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                        <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                            <?= $repayment_capacity; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <?php
    if ($id_peruntukan == 1 || $id_pekerjaan_anggota == 3 || $id_pekerjaan_anggota == 4) {
    ?>
        <table cellspacing="0" style="width: 100%; border-collapse: collapse; margin-top: 10px;" align="center">
            <tr>
                <td style="width: 49%; vertical-align: top;">
                    <table cellspacing="0" style="width: 100%; border: solid 1px #dee2e6; vertical-align: top;">
                        <tr style="border: solid 1px #dee2e6;">
                            <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                Jenis Usaha
                            </td>
                            <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">
                                :
                            </td>
                            <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                <?= $jenis_usaha; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                Komoditi
                            </td>
                            <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                            <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                <?= $komoditi; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                Lama Usaha (Th)
                            </td>
                            <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                            <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                <?= $lama_usaha; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                Lokasi Usaha
                            </td>
                            <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                            <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                <?= $lokasi_usaha; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                Surat Ijin Usaha
                            </td>
                            <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                            <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                <?= $surat_ijin_usaha; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                Aset Usaha
                            </td>
                            <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                            <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                <?= $aset_usaha; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                Nilai Aset Rp
                            </td>
                            <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                            <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                                <?= $nilai_aset; ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 2%;">
                </td>
                <td style="width: 49%; vertical-align: top;">
                    <table cellspacing="0" style="width: 100%; border: solid 1px #dee2e6; vertical-align: top;">
                        <tr>
                            <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                Modal
                            </td>
                            <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                            <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                                <?= $modal; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                Omset
                            </td>
                            <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                            <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                                <?= $omset; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                HPP
                            </td>
                            <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                            <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                                <?= $hpp; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                Persediaan
                            </td>
                            <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                            <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                                <?= $persediaan; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                Piutang
                            </td>
                            <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                            <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                                <?= $piutang; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                Laba Kotor
                            </td>
                            <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                            <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                                <?= $laba_kotor; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                By Usaha
                            </td>
                            <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                            <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                                <?= $by_usaha; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                Sewa Tempat
                            </td>
                            <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                            <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                                <?= $sewa_tempat; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                Total Biaya Usaha
                            </td>
                            <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                            <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                                <?= $total_biaya_usaha; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 43%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px;">
                                Keuntungan Usaha
                            </td>
                            <td style="width: 3%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: center;">:</td>
                            <td style="width: 54%; font-size: 9pt; border: solid 1px #dee2e6; padding: 4px; text-align: right;">
                                <?= $keuntungan_usaha; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    <?php
    }
    ?>

    <br>
    
    <table cellspacing="0" style="width: 100%; border-collapse: collapse; vertical-align: top; margin-top: 15px;" align="center">
        <tr>
            <td style="width: 25%; font-size: 9pt; vertical-align: top; text-align: center; border: solid 1px #000; padding: 2px;">
                Pemohon
            </td>
            <td colspan="2" style="width: 25%; font-size: 9pt; vertical-align: top; text-align: center; border: solid 1px #000; padding: 2px;">
                Mengetahui
            </td>
        </tr>
        
        <tr>
            
            <td style="width: 33.33%; height: 60px; vertical-align: top; text-align: center; border-left: solid 1px #000; border-top: solid 1px #000; border-right: solid 1px #000; padding: 0px;">
                <?php
                if ($ttd_anggota != NULL) {
                    echo '<img src="' . $ttd_anggota . '" style="width:150px; vertical-align: middle; text-align: center;" />';
                }
                ?>
            </td>                       
            <td style="width: 33.33%; height: 60px; vertical-align: top; text-align: center; border-left: solid 1px #000; border-top: solid 1px #000; border-right: solid 1px #000; padding: 0px;">
                <?php
                if ($ttd_pasangan != NULL) {
                    echo '<img src="' . $ttd_pasangan . '" style="width:150px; vertical-align: middle; text-align: center;" />';
                }
                ?>
            </td>
            
        </tr>
        
        
        <tr>
            <td style="width: 33.33%; font-size: 9pt; vertical-align: top; text-align: center; border: solid 1px #000; padding: 2px;">
                <?= $nama_lengkap; ?><br>Anggota
            </td>
            <td style="width: 33.33%; font-size: 9pt; vertical-align: top; text-align: center; border: solid 1px #000; padding: 2px;">
                <?= $nama_pasangan; ?><br>Pasangan
            </td>
        </tr>
        
    </table>

</page>

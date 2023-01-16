<style>
    .logo {
        text-align: center;
        margin-bottom: 0px;
        padding: 0px;
    }

    .logo>img {
        width: 80px;
        height: 80px;
        margin-bottom: 0px;
    }

    hr.style8 {
        margin-top: 10px;
        text-align: center;
        border-top: 1px solid #000;
        border-bottom: 1px solid #fff;
    }

    hr.style8:after {
        content: '';
        display: block;
        margin-top: 4px;
        border-top: 3px solid #000;
        border-bottom: 1px solid #fff;
    }

    p {
        font-size: 16px;
    }

    table>tbody>tr>td {
        font-size: 18px;
    }

    table.kecil>tbody>tr>td {
        font-size: 13px;
    }

    table.kecil>thead>tr>th {
        font-size: 14px;
    }

    table.kecil>tfoot>tr>th {
        font-size: 14px;
    }
</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

<div class="container" style="padding-left: 70px; padding-right: 70px;">
    <div class="row mt-2">
        <div class="col-2 text-center logo">
            <img src="<?= base_url(); ?>assets/img/logo_koperasi.png">
        </div>
        <div class="col-8 text-center">
            <h4>KOPERASI SIMPAN PINJAM PEMBIAYAAN SYARIAH<br>BAYTUL IKHTIAR (KSPPS BAIK)</h4>
        </div>
        <div class="col-2 logo">
            <img src="<?= base_url(); ?>assets/img/logo_baik2.png">
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <hr class="style8">
            <!-- <hr> -->
        </div>
    </div>
    <div class="row mt-1">
        <div class="col-12">
            <h4 class="text-center">Aplikasi Pengajuan Pembiayaan</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <table class="table table-bordered table-sm kecil">
                <tbody>
                    <tr>
                        <td style="width: 160px !important;">No Anggota</td>
                        <td style="width: 20px !important;">:</td>
                        <td><?= $no_anggota; ?></td>
                    </tr>
                    <tr>
                        <td>Nama Lengkap</td>
                        <td>:</td>
                        <td><?= $nama_lengkap; ?></td>
                    </tr>
                    <tr>
                        <td>No KTP</td>
                        <td>:</td>
                        <td><?= $no_ktp; ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><?= $alamat; ?></td>
                    </tr>
                    <tr>
                        <td>Rembug</td>
                        <td>:</td>
                        <td><?= $rembug; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-6">
            <table class="table table-bordered table-sm kecil">
                <tbody>
                    <tr>
                        <td style="width: 160px !important;">Jenis Pembiayaan</td>
                        <td style="width: 20px !important;">:</td>
                        <td><?= $jenis_pembiayaan; ?></td>
                    </tr>
                    <tr>
                        <td>Pembiayaan Ke</td>
                        <td>:</td>
                        <td><?= $pembiayaan_ke; ?></td>
                    </tr>
                    <tr>
                        <td>Jumlah Pengajuan</td>
                        <td>:</td>
                        <td>Rp. <?= $jumlah_pengajuan; ?></td>
                    </tr>
                    <tr>
                        <td>Peruntukan</td>
                        <td>:</td>
                        <td><?= $peruntukan; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Pengajuan</td>
                        <td>:</td>
                        <td><?= $tanggal_pengajuan; ?></td>
                    </tr>
                    <tr>
                        <td>Rencana Pencairan</td>
                        <td>:</td>
                        <td><?= $rencana_pencairan; ?></td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td>:</td>
                        <td><?= $keterangan; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col-12">
            <h4 class="text-center">Memorandum Analisis Pembiayaan</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <table class="table table-bordered table-sm kecil">
                <tbody>
                    <tr>
                        <td style="width: 160px !important;">No Telp Anggota</td>
                        <td style="width: 20px !important;">:</td>
                        <td><?= $no_telp_anggota; ?></td>
                    </tr>
                    <tr>
                        <td>Pekerjaan Anggota</td>
                        <td>:</td>
                        <td><?= $pekerjaan_anggota; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 160px !important;">No Telp Suami</td>
                        <td style="width: 20px !important;">:</td>
                        <td><?= $no_telp_suami; ?></td>
                    </tr>
                    <tr>
                        <td>Pekerjaan Suami</td>
                        <td>:</td>
                        <td><?= $pekerjaan_suami; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 160px !important;">Pendapatan Gaji</td>
                        <td style="width: 20px !important;">:</td>
                        <td>Rp. <?= $pendapatan_gaji; ?></td>
                    </tr>
                    <tr>
                        <td>Pendapatan Usaha</td>
                        <td>:</td>
                        <td>Rp. <?= $pendapatan_usaha; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 160px !important;">Pendapatan Lainnya</td>
                        <td style="width: 20px !important;">:</td>
                        <td>Rp. <?= $pendapatan_lainnya; ?></td>
                    </tr>
                    <tr>
                        <td>Total Pendapatan</td>
                        <td>:</td>
                        <td>Rp. <?= $total_pendapatan; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-6">
            <table class="table table-bordered table-sm kecil">
                <tbody>
                    <tr>
                        <td style="width: 160px !important;">Jumlah Tanggungan</td>
                        <td style="width: 20px !important;">:</td>
                        <td><?= $jumlah_tanggungan; ?></td>
                    </tr>
                    <tr>
                        <td>Biaya Rumah Tangga</td>
                        <td>:</td>
                        <td>Rp. <?= $biaya_rumah_tangga; ?></td>
                    </tr>
                    <tr>
                        <td>Biaya Rekening</td>
                        <td>:</td>
                        <td>Rp. <?= $biaya_rekening; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 160px !important;">Biaya Kontrakan</td>
                        <td style="width: 20px !important;">:</td>
                        <td>Rp. <?= $biaya_kontrakan; ?></td>
                    </tr>
                    <tr>
                        <td>Hutang Lainnya</td>
                        <td>:</td>
                        <td>Rp. <?= $hutang_lainnya; ?></td>
                    </tr>
                    <tr>
                        <td>Total Biaya</td>
                        <td>:</td>
                        <td>Rp. <?= $total_biaya; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 160px !important;"><strong>Saving Power</strong></td>
                        <td style="width: 20px !important;"><strong>:</strong></td>
                        <td><strong>Rp. <?= $saving_power; ?></strong></td>
                    </tr>
                    <tr>
                        <td style="width: 160px !important;"><strong>Repayment Capacity</strong></td>
                        <td style="width: 20px !important;"><strong>:</strong></td>
                        <td><strong>Rp. <?= $repayment_capacity; ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    if ($id_peruntukan == 1 || $id_pekerjaan_anggota == 3 || $id_pekerjaan_anggota == 4) {
    ?>
        <div class="row">
            <div class="col-6">
                <table class="table table-bordered table-sm kecil">
                    <tbody>
                        <tr>
                            <td style="width: 160px !important;">Jenis Usaha</td>
                            <td style="width: 20px !important;">:</td>
                            <td><?= $jenis_usaha; ?></td>
                        </tr>
                        <tr>
                            <td>Komoditi</td>
                            <td>:</td>
                            <td><?= $komoditi; ?></td>
                        </tr>
                        <tr>
                            <td>Lama Usaha (Th)</td>
                            <td>:</td>
                            <td><?= $lama_usaha; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 160px !important;">Lokasi Usaha</td>
                            <td style="width: 20px !important;">:</td>
                            <td><?= $lokasi_usaha; ?></td>
                        </tr>
                        <tr>
                            <td>Aset Usaha</td>
                            <td>:</td>
                            <td><?= $aset_usaha; ?></td>
                        </tr>
                        <tr>
                            <td>Surat Ijin Usaha</td>
                            <td>:</td>
                            <td><?= $surat_ijin_usaha; ?></td>
                        </tr>
                        <tr>
                            <td>Nilai Aset Rp</td>
                            <td>:</td>
                            <td>Rp. <?= $nilai_aset; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-6">
                <table class="table table-bordered table-sm kecil">
                    <tbody>
                        <tr>
                            <td style="width: 160px !important;">Modal</td>
                            <td style="width: 20px !important;">:</td>
                            <td>Rp. <?= $modal; ?></td>
                        </tr>
                        <tr>
                            <td>Omset</td>
                            <td>:</td>
                            <td>Rp. <?= $omset; ?></td>
                        </tr>
                        <tr>
                            <td>HPP</td>
                            <td>:</td>
                            <td>Rp. <?= $hpp; ?></td>
                        </tr>
                        <tr>
                            <td>Persediaan</td>
                            <td>:</td>
                            <td>Rp. <?= $persediaan; ?></td>
                        </tr>
                        <tr>
                            <td>Piutang</td>
                            <td>:</td>
                            <td>Rp. <?= $piutang; ?></td>
                        </tr>
                        <tr>
                            <td>Laba Kotor</td>
                            <td>:</td>
                            <td>Rp. <?= $laba_kotor; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 160px !important;">By Usaha</td>
                            <td style="width: 20px !important;">:</td>
                            <td>Rp. <?= $by_usaha; ?></td>
                        </tr>
                        <tr>
                            <td>Sewa Tempat</td>
                            <td>:</td>
                            <td>Rp. <?= $sewa_tempat; ?></td>
                        </tr>
                        <tr>
                            <td>Total Biaya Usaha</td>
                            <td>:</td>
                            <td>Rp. <?= $total_biaya_usaha; ?></td>
                        </tr>
                        <tr>
                            <td>Keuntungan Usaha</td>
                            <td>:</td>
                            <td>Rp. <?= $keuntungan_usaha; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
    }
    ?>

    <div class="row mt-1">
        <div class="col-12">
            <h4 class="text-center">Profile Anggota Dan Majelis</h4>
        </div>
        <div class="col-6">
            <table class="table table-bordered table-sm kecil">
                <tbody>
                    <tr>
                        <td colspan="3"><strong>PRESTASI ANGGOTA</strong></td>
                    </tr>
                    <tr>
                        <td style="width: 160px !important;">Plafond Sebelumnya</td>
                        <td style="width: 20px !important;">:</td>
                        <td>Rp. <?= $plafond_sebelumnya; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 160px !important;">Prestasi Angsuran</td>
                        <td style="width: 20px !important;">:</td>
                        <td><?= $prestasi_angsuran; ?> Angsuran</td>
                    </tr>
                    <tr>
                        <td style="width: 160px !important;">Prestasi Kehadiran Anggota</td>
                        <td style="width: 20px !important;">:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="width: 160px !important;">Rataan Tabungan</td>
                        <td style="width: 20px !important;">:</td>
                        <td>
                            <ul>
                                <li>Total Setoran: Rp. <?= $total_setoran; ?></li>
                                <li>Total Penarikan: Rp. <?= $total_penarikan; ?></li>
                                <li>Rataan Setoran: Rp. <?= $rataan_setoran; ?></li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 160px !important;">Saldo Tabungan</td>
                        <td style="width: 20px !important;">:</td>
                        <td>
                            <ul>
                                <li>Tabungan Sukarela: Rp. <?= $tabungan_sukarela; ?></li>
                                <?php
                                if (count($taber) > 0) {
                                ?>
                                    <li>Taber: </li>
                                    <ul>
                                        <?php
                                        foreach ($taber as $item) {
                                        ?>
                                            <li><?= $item['product_name']; ?> <br /> Rp. <?= $item['saldo_memo']; ?></li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                <?php
                                }
                                ?>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 160px !important;">Pernah Ditanggung Renteng</td>
                        <td style="width: 20px !important;">:</td>
                        <td>
                            <div class="row">
                                <div class="col-1 mt-1 mr-1"><i class="fa fa-square-o fa-fw fa-2x"></i></div>
                                <div class="col-4 mt-2"> Pernah</div>
                                <div class="col-1 mt-1 mr-1"><i class="fa fa-square-o fa-fw fa-2x"></i></div>
                                <div class="col-4 mt-2"> Belum</div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-6">
            <table class="table table-bordered table-sm kecil">
                <tbody>
                    <tr>
                        <td colspan="3"><strong>KONDISI MAJELIS</strong></td>
                    </tr>
                    <tr>
                        <td style="width: 160px !important;">Lama Majelis</td>
                        <td style="width: 20px !important;">:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="width: 160px !important;">Rataan Kehadiran Majelis</td>
                        <td style="width: 20px !important;">:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="width: 160px !important;">Kekompakan</td>
                        <td style="width: 20px !important;">:</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
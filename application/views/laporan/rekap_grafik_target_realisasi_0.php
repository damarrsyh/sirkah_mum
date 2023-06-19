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
            Laporan Rekap Target vs Realisasi
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

<!-- BEGIN FORM-->


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
    <div class="portlet-title">
        <div class="caption"><i class="icon-globe"></i>Laporan Rekap Target vs Realisasi</div>
        <div class="tools">
            <a href="javascript:;" class="collapse"></a>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FILTER FORM -->
        <form action="<?php echo base_url('laporan/grafik_target_realisasi_proses'); ?>" method="post" class="form-horizontal">
            <input type="hidden" name="branch" id="branch" value="<?php echo $branch_name; ?>">
            <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $branch_code; ?>">
            <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $branch_id; ?>">
            <table id="filter-form">
                <tr>
                    <td width="100">Cabang</td>
                    <td>
                        <input type="text" name="branch" readonly class="m-wrap medium" style="background:#EEE;" value="<?php echo $branch_name; ?>">
                        <?php if ($this->session->userdata('flag_all_branch') == "1") { ?>
                            <a id="browse_branch" class="btn blue" data-toggle="modal" href="#dialog_branch">...</a>
                        <?php } ?>

                    </td>
                </tr>
                <tr>
                    <td>Jenis Target</td>
                    <td>
                        <select name="jenistarget" class="chosen m-wrap" id="jenistarget">
                            <option value="">Pilih</option>
                            <?php foreach ($jenistarget as $values) { ?>
                                <option value="<?php echo $values['code_value']; ?>" <?php echo ($values['code_value'] == $jenis_target) ? 'selected' : ''; ?>><?php echo $values['display_text']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Tahun Target</td>
                    <td>
                        <select name="tahuntarget" class="chosen m-wrap" id="tahuntarget">
                            <option value="">Pilih</option>
                            <?php foreach ($tahuntarget as $values) { ?>
                                <option value="<?php echo $values['tahun']; ?>" <?php echo ($values['tahun'] == $tahun_target) ? 'selected' : ''; ?>><?php echo $values['tahun']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">
                        <button type="submit" class="btn blue">Tampilkan</button>
                        <button type="button" class="red btn" id="previewpdf">PDF</button>
                        <button type="button" class="green btn" id="previewxls">Excel</button>
                    </td>
                </tr>
            </table>
        </form>
        <!-- END FILTER FORM -->
        <div class="table-scrollable">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kode</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Jan</th>
                        <th scope="col">Feb</th>
                        <th scope="col">Mar</th>
                        <th scope="col">Apr</th>
                        <th scope="col">Mei</th>
                        <th scope="col">Jun</th>
                        <th scope="col">Jul</th>
                        <th scope="col">Agt</th>
                        <th scope="col">Sep</th>
                        <th scope="col">Okt</th>
                        <th scope="col">Nov</th>
                        <th scope="col">Des</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($graphic as $graph) {
                    ?>
                        <tr>
                            <td scope="col">
                                <center><?php echo $no++; ?></center>
                            </td>
                            <td scope="col">
                                <center><?php echo $graph['kode']; ?></center>
                            </td>
                            <td scope="col">
                                <center><?php echo $graph['keterangan']; ?></center>
                            </td>
                            <td scope="col">
                                <center><?php echo $graph['b1']; ?></center>
                            </td>
                            <td scope="col">
                                <center><?php echo $graph['b2']; ?></center>
                            </td>
                            <td scope="col">
                                <center><?php echo $graph['b3']; ?></center>
                            </td>
                            <td scope="col">
                                <center><?php echo $graph['b4']; ?></center>
                            </td>
                            <td scope="col">
                                <center><?php echo $graph['b5']; ?></center>
                            </td>
                            <td scope="col">
                                <center><?php echo $graph['b6']; ?></center>
                            </td>
                            <td scope="col">
                                <center><?php echo $graph['b7']; ?></center>
                            </td>
                            <td scope="col">
                                <center><?php echo $graph['b8']; ?></center>
                            </td>
                            <td scope="col">
                                <center><?php echo $graph['b9']; ?></center>
                            </td>
                            <td scope="col">
                                <center><?php echo $graph['b10']; ?></center>
                            </td>
                            <td scope="col">
                                <center><?php echo $graph['b11']; ?></center>
                            </td>
                            <td scope="col">
                                <center><?php echo $graph['b12']; ?></center>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </div>
</div>

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/highcharts/highcharts.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/highcharts/modules/exporting.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/highcharts/modules/export-data.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script>
    $(document).ready(function() {
        App.init(); // initlayout and core plugins

        $("input#mask_date,.mask_date").livequery(function() {
            $(this).inputmask("d/m/y"); //direct mask
        });

        $("#browse_branch").click(function() {
            $.ajax({
                type: "POST",
                url: site_url + "cif/get_branch_by_keyword",
                dataType: "json",
                data: {
                    keyword: $("#keyword", "#dialog_branch").val()
                },
                success: function(response) {
                    html = '';
                    // html = '<option value="0000" branch_code="0000" branch_name="Semua Branch">Semua Branch</option>';
                    for (i = 0; i < response.length; i++) {
                        html += '<option value="' + response[i].branch_id + '" branch_code="' + response[i].branch_code + '" branch_name="' + response[i].branch_name + '">' + response[i].branch_code + ' - ' + response[i].branch_name + '</option>';
                    }
                    $("#result", "#dialog_branch").html(html);
                }
            })
        })

        $("#keyword", "#dialog_branch").keyup(function(e) {
            e.preventDefault();
            keyword = $(this).val();
            if (e.which == 13) {
                $.ajax({
                    type: "POST",
                    url: site_url + "cif/get_branch_by_keyword",
                    dataType: "json",
                    data: {
                        keyword: keyword
                    },
                    success: function(response) {
                        html = '';
                        // html = '<option value="0000" branch_code="0000" branch_name="Semua Branch">Semua Branch</option>';
                        for (i = 0; i < response.length; i++) {
                            html += '<option value="' + response[i].branch_id + '" branch_code="' + response[i].branch_code + '" branch_name="' + response[i].branch_name + '">' + response[i].branch_code + ' - ' + response[i].branch_name + '</option>';
                        }
                        $("#result", "#dialog_branch").html(html);
                    }
                })
            }
        });

        $("#select", "#dialog_branch").click(function() {
            branch_code = $("#result option:selected", "#dialog_branch").attr('branch_code');
            branch_name = $("#result option:selected", "#dialog_branch").attr('branch_name');
            branch_id = $("#result", "#dialog_branch").val();
            if (result != null) {
                $("input[name='branch']").val(branch_name);
                $("input[name='branch_code']").val(branch_code);
                $("input[name='branch_id']").val(branch_id);
                $("#close", "#dialog_branch").trigger('click');

                /*get tanggal closing*/
                get_tanggal_closing();
            }
        });

        function get_tanggal_closing() {
            $('#jenis').change(function(e) {
                e.preventDefault();
                var jenis = $(this).val();
                var conf = true;

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    data: {
                        branch_code: $("input[name='branch_code']").val()
                    },
                    async: false,
                    url: site_url + "laporan/get_tanggal_closing",
                    success: function(response) {
                        html = '<option value="">Pilih Tanggal</option>';
                        for (i = 0; i < response.length; i++) {
                            closing_thru_date = response[i].closing_thru_date;
                            closing_from_date = response[i].closing_from_date;
                            ta = closing_thru_date.split('-');
                            tp = closing_from_date.split('-');

                            if (jenis == '') {
                                var conf = false;
                            } else if (jenis == '30') {
                                html += '<option>' + tp[2] + '/' + tp[1] + '/' + tp[0] + ' - ' + ta[2] + '/' + ta[1] + '/' + ta[0] + '</option>';
                            } else if (jenis == '10' || jenis == '11' || jenis == '20' || jenis == '21') {
                                html += '<option>' + ta[2] + '/' + ta[1] + '/' + ta[0] + '</option>';
                            }
                        }
                        $("#date").html(html);
                        $(".chosen").trigger('liszt:updated')
                    }
                });
            });
        }

        get_tanggal_closing();
        $("#result option:selected", "#dialog_branch").live('dblclick', function() {
            $("#select", "#dialog_branch").trigger('click');
        })

        /* END DIALOG ACTION BRANCH */

        $("#previewpdf").click(function(e) {
            e.preventDefault();
            var branch_code = $("#branch_code").val();
            var jenistarget = $("#jenistarget").val();
            var tahuntarget = $('#tahuntarget').val();
            var conf = true;

            if (jenistarget == '') {
                alert('Jenis Target harus dipilih');
                conf = false;
            } else
            if (tahuntarget == '') {
                alert('Tahun Target harus dipilih');
                conf = false;
            } else {
                var url = '<?php echo site_url('laporan_to_pdf/export_rekap_target_realisasi'); ?>';
                conf = true;
            }

            if (conf == true) {
                window.open(url + '/' + branch_code + '/' + jenistarget + '/' + tahuntarget);
            }
        });

        $("#previewxls").click(function(e) {
            e.preventDefault();
            var branch_code = $("#branch_code").val();
            var jenistarget = $("#jenistarget").val();
            var tahuntarget = $('#tahuntarget').val();
            var conf = true;

            if (jenistarget == '') {
                alert('Jenis Target harus dipilih');
                conf = false;
            } else
            if (tahuntarget == '') {
                alert('Tahun Target harus dipilih');
                conf = false;
            } else {
                ///var url = '<?php echo site_url('laporan_to_pdf/export_keuangan_neraca_bulanan'); ?>'; 
                var url = '<?php echo site_url('laporan_to_excel/export_rekap_target_realisasi'); ?>';
                conf = true;
            }

            if (conf == true) {
                window.open(url + '/' + branch_code + '/' + jenistarget + '/' + tahuntarget);
            }
        });
    });

    Highcharts.chart('container', {
        chart: {
            type: 'line'
        },
        title: {
            text: '<?php echo $title; ?>'
        },
        subtitle: {
            text: 'KSPPS Mitra Usaha Mandiri'
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des']
        },
        yAxis: {
            title: {
                text: 'Pencapaian'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: <?php echo $detail; ?>
    });
</script>
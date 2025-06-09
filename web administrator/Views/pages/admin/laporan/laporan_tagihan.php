<?= $this->include('partials/main') ?>

<head>
    <?= view('partials/title-meta', array('title' => 'Dashboard')); ?>
    <?= $this->include('partials/head-css') ?>

</head>

<body>
    <div class="page-wrapper" id="pageWrapper">
        <?= $this->include('partials/topbar') ?>
        <div class="page-body-wrapper horizontal-menu">
            <?= $this->include('partials/sidebar') ?>
            <div class="page-body">
                <?php echo view('partials/page-title', array('pagetitle' => 'Home', 'title' => 'Laporan Data booking')); ?>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header mb-0 b-t-success border-2 align-items-center d-flex">
                                    <div class=" flex-grow-1">
                                        <h5 class="card-title mb-0">Laponran Data booking</h5>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <a href="<?= site_url('laporan/cetak_laporan_tagihan?periode_awal=' . $periode_awal . '&periode_akhir=' . $periode_akhir . ''); ?>" target="_blank" class="btn btn-primary"><i class="ri-add-line align-middle"></i> Cetak</a>
                                    </div>
                                </div>


                                <div class="card-body">

                                    <div class="col-md-12">
                                        <p class="box-title">Cari Berdasarkan</p>

                                        <form id="myForm" method="post" class="form-horizontal" action="<?php echo site_url('laporan/laporan_tagihan'); ?>" enctype="multipart/form-data">
                                            <div class="box-body">


                                                <div class="form-group">
                                                    <label class="control-label col-sm-2" for="periode_awal">Periode Awal</label>
                                                    <div class="col-sm-5">
                                                        <input type="date" class="form-control" id="periode_awal" name="periode_awal" placeholder="Pilih Periode Awal" value="<?php echo $periode_awal; ?>">
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label class="control-label col-sm-2" for="periode_akhir">Periode Akhir</label>
                                                    <div class="col-sm-5">
                                                        <input type="date" class="form-control" id="periode_akhir" name="periode_akhir" placeholder="Pilih Periode Akhir" value="<?php echo $periode_akhir; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <button type="submit" id="btn-proses" class="btn btn-md btn-primary">
                                                            <i class="ace-icon fa fa-refresh"></i> Proses
                                                        </button>
                                                        <a type="button" class="btn  btn-danger" href="<?php echo site_url('laporan/laporan_tagihan'); ?>">
                                                            <i class="ace-icon fa fa-ban"></i> Reset
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive table-striped align-top">
                                            <thead>
                                                <tr>
                                                    <th>No Invoice</th>
                                                    <th>Nama Customer</th>
                                                    <th>Nama Room</th>
                                                    <th>Periode (Bulan/Tahun)</th>
                                                    <th>Tanggal Bayar</th>
                                                    <th>Nominal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($tagihans as $tagihan) : ?>
                                                    <tr>
                                                        <td><?= $tagihan->no_invoice; ?></td>
                                                        <td><?= $tagihan->nama_customer; ?></td>
                                                        <td><?= $tagihan->nama_room; ?></td>
                                                        <td><?= bulan($tagihan->bulan) . ' ' . $tagihan->tahun; ?></td>
                                                        <td><?= date('d-m-Y', strtotime($tagihan->payment_date)); ?></td>
                                                        <td><?= number_format($tagihan->nominal); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                <tr>
                                                    <td colspan="5" class="text-end"><strong>Subtotal:</strong></td>
                                                    <td><strong><?= number_format($subtotal); ?></strong></td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->include('partials/footer') ?>
        </div>
    </div>
    <?= $this->include('partials/vendor-scripts') ?>
    <script src="<?= base_url() ?>/public/assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/public/assets/js/datatable/datatables/datatable.custom.js"></script>
    <script src="<?= base_url() ?>/public/assets/js/tooltip-init.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            showData();
        });
    </script>
</body>

</html>
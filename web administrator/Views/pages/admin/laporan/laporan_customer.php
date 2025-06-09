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
                <?php echo view('partials/page-title', array('pagetitle' => 'Home', 'title' => 'Laporan Data Customer')); ?>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header mb-0 b-t-success border-2 align-items-center d-flex">
                                    <div class=" flex-grow-1">
                                        <h5 class="card-title mb-0">Laponran Data Customer</h5>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <a href="<?= base_url('laporan/cetak_laporan_customer'); ?>" target="_blank" class="btn btn-primary"><i class="ri-add-line align-middle"></i> Cetak</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive table-striped align-top">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Email</th>
                                                    <th>Telepon</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Username</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($customers as $item) { ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= $item->nama_customer ?></td>
                                                        <td><?= $item->email ?></td>
                                                        <td><?= $item->telepon ?></td>
                                                        <td><?= $item->jenis_kelamin ?></td>
                                                        <td><?= $item->username ?></td>
                                                        <td><?= $item->status ?></td>

                                                    </tr>
                                                <?php } ?>


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
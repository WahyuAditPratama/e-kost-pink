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
                <?php echo view('partials/page-title', array('pagetitle' => 'Home', 'title' => 'Data Notifikasi')); ?>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header mb-0 b-t-success border-2 align-items-center d-flex">
                                    <div class=" flex-grow-1">
                                        <h5 class="card-title mb-0">Data Notifikasi</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive table-striped align-top">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>No</th>
                                                    <th>Penerima</th>
                                                    <th>Pengirim</th>
                                                    <th>Pesan</th>
                                                    <th>Parameter</th>
                                                    <th>Ref Id</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
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

        function showData() {
            var bu = $('#bu').val();
            if ($.fn.DataTable.isDataTable('#datatable')) {
                $('#datatable').DataTable().destroy();
            }
            $('#datatable').DataTable({
                "scrollX": true,
                "oLanguage": {
                    "sProcessing": "<img src='<?= base_url('public/assets/images/loader.gif') ?>'>",
                },
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    "url": "<?php echo base_url('notifikasi/load') ?>",
                    "type": "POST",
                },
                "columnDefs": [{
                        "orderable": false,
                        "width": "5%",
                        "class": "text-center",
                        "targets": 0,
                    }, {
                        "orderable": false,
                        "width": "20%",
                        "targets": 1,
                    }, {
                        "orderable": false,
                        "width": "20%",
                        "targets": 2,
                    },
                    {
                        "orderable": true,
                        "width": "10%",
                        "class": "text-center",
                        "targets": 4,
                    },
                    {
                        "orderable": false,
                        "width": "10%",
                        "class": "text-center",
                        "targets": 5,
                    },
                    {
                        "orderable": false,
                        "class": "text-center",
                        "width": "150px",
                        "targets": 6,
                    },
                ],
            });
        }
        $(document).on('click', '#Remove', function(e) {
            e.preventDefault();
            var link = $(this).attr('href');
            $('#modal-confirm-delete-footer').html("<form action='" + link + "' method='get'><button type='submit' class='btn btn-primary  btn-md mx-2'>Hapus</button><button type='button' class='btn btn-secondary btn-md' data-bs-dismiss='modal'>Batal</button></form>");
            $('#modal-confirm-delete').modal('show');
        });
    </script>
</body>

</html>
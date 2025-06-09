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
                <?php echo view('partials/page-title', array('pagetitle' => 'Home', 'title' => 'Role Pengguna')); ?>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header mb-0 b-t-success border-2 align-items-center d-flex">
                                    <div class=" flex-grow-1">
                                        <h5 class="card-title mb-0">Data Role Pengguna</h5>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <a href="<?= base_url('usersroles/create'); ?>" class="btn btn-primary"><i class="ri-add-line align-middle"></i> Tambah Data</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive table-striped align-top">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Roles</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
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
    <script src="<?= base_url(); ?>public/velzone/js/pages/datatables.init.js"></script>
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
                    "sProcessing": "<img src='<?= base_url('public/velzone/images/loader.gif') ?>'>",
                },
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    "url": "<?php echo base_url('usersroles/load') ?>",
                    "type": "POST",
                },
                "columnDefs": [{
                        "targets": [0],
                        "orderable": false,
                        "width": "5%",
                        "targets": 0,
                    },
                    {
                        "targets": [4],
                        "orderable": false,
                        "width": "12%",
                        "targets": 4,
                    },
                ],
            });
        }
        $(document).on('click', '#Remove', function(e) {
            e.preventDefault();
            var link = $(this).attr('href');
            $('#modal-confirm-delete-footer').html("<form action='" + link + "' method='get'><button type='submit' class='btn btn-primary btn-md mx-2'>Hapus</button><button type='button' class='btn btn-secondary btn-md' data-bs-dismiss='modal'>Batal</button></form>");
            $('#modal-confirm-delete').modal('show');
        });
    </script>
</body>

</html>
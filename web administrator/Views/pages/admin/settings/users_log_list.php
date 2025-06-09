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
                <?php echo view('partials/page-title', array('pagetitle' => 'Home', 'title' => 'Dashboard')); ?>
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card ">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Users Logs</h4>
                                    <div class="flex-shrink-0 noprint row">
                                        <div class="col-md-6">
                                            <select class="form-select mt-2 mb-2 select2" id="FilterYear" name="FilterYear" data-placeholder="Pilih Tahun..." required>
                                                <?php
                                                echo "<option value='All'> Filter By Tahun </option>";
                                                foreach ($mtahun as $i) {
                                                    if ($this->year == $i) {
                                                        echo '<option value=' . $i . ' selected>' . $i . '</option>';
                                                    } else {
                                                        echo '<option value=' . $i . '>' . $i . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <!--end col-->
                                        <div class="col-md-6">
                                            <select class="form-select mt-2 mb-2 select2" id="FilterMonth" name="FilterMonth" data-placeholder="Pilih Bulan..." required>
                                                <?php
                                                echo "<option value='All'>Filter By Month </option>";
                                                foreach ($mbulan as $key => $val) {
                                                    if ($this->month == $key) {
                                                        echo '<option value=' . $key . ' selected>' . $val . '</option>';
                                                    } else {
                                                        echo '<option value=' . $key . '>' . $val . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered dt-responsive  table-striped align-middle" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Username</th>
                                                <th>Nama</th>
                                                <th>IPAddress</th>
                                                <th>Date</th>
                                                <th>Url</th>
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
        $('#FilterYear').change(function() {
            showData();
        });

        $('#FilterMonth').change(function() {
            showData();
        });

        function showData() {
            var bu = $('#bu').val();
            var tahun = $("#FilterYear").val();
            var bulan = $("#FilterMonth").val();
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
                    "url": "<?php echo site_url('usersLog/load') ?>",
                    "type": "POST",
                    "data": {
                        'tahun': tahun,
                        'bulan': bulan,
                    }
                },
                "columnDefs": [{
                        "targets": [0],
                        "orderable": false,
                        "width": "5%",
                        "targets": 0,
                    },
                    {
                        "targets": [6],
                        "class": "text-center",
                        "orderable": false,
                        "width": "10%",
                        "targets": 6,
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
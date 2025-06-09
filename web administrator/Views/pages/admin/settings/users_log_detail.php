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
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Users Log Detail</h4>
                                    <div class="flex-shrink-0 noprint">
                                        <a href="<?= base_url('usersLog'); ?>" class="btn btn-secondary"><i class="ri-arrow-left-line align-middle"></i>Kembali</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-condensed">
                                            <tbody>
                                                <tr>
                                                    <td width="15%">Username</td>
                                                    <td width="5%" class="text-center">:</td>
                                                    <td><code><?php echo $mdata->username; ?></code></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">LogDate</td>
                                                    <td width="5%" class="text-center">:</td>
                                                    <td><code><?php echo $mdata->log_date; ?></code></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">LogAction</td>
                                                    <td width="5%" class="text-center">:</td>
                                                    <td><code><?php echo $mdata->log_action; ?></code></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">LogInfo</td>
                                                    <td width="5%" class="text-center">:</td>
                                                    <td><code><?php echo $mdata->log_info; ?></code></td>
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
</body>

</html>
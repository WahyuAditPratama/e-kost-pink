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
                <?php echo view('partials/page-title', array('pagetitle' => 'Home', 'title' => 'Tambah Role Pengguna')); ?>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <form class="form-horizontal" method="post" action="<?php echo site_url('usersroles/create'); ?>">
                                    <div class="card-header mb-0 b-t-success border-2 align-items-center d-flex">
                                        <div class=" flex-grow-1">
                                            <h5 class="card-title mb-0">Tambah Role Pengguna</h5>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="<?= base_url('usersroles'); ?>" class="btn btn-light"><i class="ri-add-line align-middle"></i> Kembali</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="nama">Nama Role</label>
                                            <div class="col-md-9">
                                                <input type="text" id="roles" name="roles" class="form-control" placeholder="Roles" value="<?= old('nama') ?>" required>
                                                <?php if ($this->validation->getError('roles')) { ?>
                                                    <div class='mt-2 input-error'>
                                                        <?= $this->validation->getError('roles'); ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="description">Description</label>
                                            <div class="col-md-9">
                                                <textarea type="description" id="description" name="description" class="form-control" placeholder="Description" required><?= old('description') ?></textarea>
                                                <?php if ($this->validation->getError('description')) { ?>
                                                    <div class='mt-2 input-error'>
                                                        <?= $this->validation->getError('description'); ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="card-footer text-end">
                                        <button type="submit" id="btn-save" class="btn btn-md btn-primary">
                                            <i class="ri-save-line"></i> Simpan
                                        </button>
                                        <a type="button" class="btn btn-md btn-light " href="<?= base_url('usersroles') ?>">
                                            <i class="ri-close-circle-line"></i> Batal
                                        </a>
                                    </div>
                                </form>
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
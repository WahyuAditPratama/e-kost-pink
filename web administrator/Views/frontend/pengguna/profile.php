<?= $this->include('partials/frontend/head-css') ?>

<body class="landing-wrraper">
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper">
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- header start-->


            <?= $this->include('partials/frontend/menu-header') ?>

            <!-- header end-->
            <!--home section start-->
            <section class=" section-py-space my-5" id="home"><img class="img-fluid bg-img-cover" src="<?= base_url() ?>/public/assets/images/landing/landing-home/home-bg2.jpg" alt="">
                <div class="custom-container">
                    <div class="row">
                        <!--  user profile first-style start-->
                        <div class="col-sm-12 box-col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="fw-bold">Akun Pengguna</h4>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="edit-profile">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <h4 class="card-title mb-0">My Profile</h4>
                                        <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="profile-title">
                                                <div class="media"> <img class="img-70 rounded-circle" alt="" src="<?= base_url() ?>/public/uploads/users/<?= $muser->avatar ? $muser->avatar : 'default.png'; ?>">
                                                    <div class="media-body">
                                                        <h3 class="mb-1 f-20 txt-primary"><?= $muser->nama_customer; ?></h3>
                                                        <p class="f-12"><?= $muser->email; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card py-3">
                                    <a class="btn btn-primary fs-6 mb-3 py-3 mx-3 text-start" href="<?= site_url('pengguna/profile'); ?>"> <i class="fa fa-user"></i> Update Profile</a>
                                    <a class="btn btn-outline-primary fs-6 mb-3 py-3 mx-3  text-start" href="<?= site_url('pengguna/order'); ?>"> <i class="fa fa-bookmark-o"></i> Pesanan Saya </a>
                                    <a class="btn btn-outline-primary fs-6 mb-3 py-3 mx-3  text-start" href="<?= site_url('pengguna/histori'); ?>"> <i class="fa fa-archive"></i> Histori</a>
                                    <a class="btn btn-outline-primary fs-6 mb-3 py-3 mx-3  text-start" href="<?= site_url('logout'); ?>"> <i class="fa fa-sign-out"></i> Logout</a>
                                </div>

                            </div>
                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <h4 class="card-title mb-0">Edit Profile</h4>
                                        <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
                                    </div>
                                    <form class="form-horizontal" method="post" action="<?php echo site_url('customer/edit'); ?>" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <input type="hidden" name="id" id="id" value="<?php echo $muser->id; ?>">
                                            <div class="form-group row mb-3">
                                                <label class="col-md-3 col-form-label" for="nama_customer">Nama Customer</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="email" name="nama_customer" class="form-control" placeholder="Nama Customer" value="<?= old('nama_customer', $muser->nama_customer) ?>" required>
                                                    <?php if ($this->validation->getError('nama_customer')) { ?>
                                                        <div class='mt-2 input-error'>
                                                            <?= $this->validation->getError('nama_customer'); ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <div class="form-group row mb-3">
                                                <label class="col-md-3 col-form-label" for="email">Email</label>
                                                <div class="col-md-9">
                                                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?= old('email', $muser->email) ?>" required>
                                                    <?php if ($this->validation->getError('email')) { ?>
                                                        <div class='mt-2 input-error'>
                                                            <?= $this->validation->getError('email'); ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                                <label class="col-md-3 col-form-label" for="telepon">Telepon</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="telepon" name="telepon" class="form-control" placeholder="Telepon" value="<?= old('telepon', $muser->telepon) ?>" required>
                                                    <?php if ($this->validation->getError('telepon')) { ?>
                                                        <div class='mt-2 input-error'>
                                                            <?= $this->validation->getError('telepon'); ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <div class="form-group row mb-3">
                                                <label class="col-md-3 col-form-label" for="tanggal_lahir">Tanggal Lahir</label>
                                                <div class="col-md-9">
                                                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" placeholder="Tanggal Lahir" value="<?= old('tanggal_lahir', $muser->tanggal_lahir) ?>" required>
                                                    <?php if ($this->validation->getError('tanggal_lahir')) { ?>
                                                        <div class='mt-2 input-error'>
                                                            <?= $this->validation->getError('tanggal_lahir'); ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>


                                            <div class="form-group row mb-3">
                                                <label class="col-md-3 col-form-label" for="jenis_kelamin">Jenis Kelamin</label>
                                                <div class="col-md-9">
                                                    <select name="jenis_kelamin" class="form-select" required>
                                                        <?php
                                                        echo '<option>Jenis Kelamin...</option>';
                                                        foreach ($mjk as $val) {
                                                            $selected = $val == $muser->jenis_kelamin ? 'selected' : '';
                                                            echo '<option value="' . $val . '" ' . $selected . '>' . $val . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-group row mb-3">
                                                <label class="col-md-3 col-form-label" for="alamat">Alamat</label>
                                                <div class="col-md-9">
                                                    <textarea type="alamat" id="alamat" name="alamat" class="form-control" placeholder="Alamat" required><?= old('alamat', $muser->alamat) ?></textarea>
                                                    <?php if ($this->validation->getError('alamat')) { ?>
                                                        <div class='mt-2 input-error'>
                                                            <?= $this->validation->getError('alamat'); ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>


                                            <div class="form-group row mb-3">
                                                <label class="col-md-3 col-form-label" for="username">Username</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" value="<?= old('username', $muser->username) ?>" required>
                                                    <?php if ($this->validation->getError('username')) { ?>
                                                        <div class='mt-2 input-error'>
                                                            <?= $this->validation->getError('username'); ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <div class="form-group row mb-3">
                                                <label class="col-md-3 col-form-label" for="avatar">avatar</label>
                                                <div class="col-md-9">
                                                    <input type="file" id="avatar" name="avatar" class="form-control" accept="image/*">
                                                    <small class="form-text text-muted">Maximum upload size: 2 mb</small>
                                                    <?php if ($this->validation->getError('avatar')) { ?>
                                                        <div class='mt-2 input-error'>
                                                            <?= $this->validation->getError('avatar'); ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <h6> Update Password </h6>


                                            <div class="form-group row mb-3">
                                                <label class="col-md-3 col-form-label" for="password">Password</label>
                                                <div class="col-md-9">
                                                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" value="">
                                                    <?php if ($this->validation->getError('password')) { ?>
                                                        <div class='mt-2 input-error'>
                                                            <?= $this->validation->getError('password'); ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>


                                            <div class="card-footer text-end">
                                                <button type="submit" id="btn-save" class="btn btn-md btn-primary">
                                                    <i class="ri-save-line"></i> Update Profile
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
            <!--footer start-->
            <?= $this->include('partials/frontend/footer') ?>
            <!--footer end-->
        </div>
    </div>

    <?= $this->include('partials//frontend/vendor-scripts') ?>
</body>

</html>


<!-- Container-fluid starts-->

<!-- Container-fluid Ends-->
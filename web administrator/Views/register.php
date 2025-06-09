<!DOCTYPE html>
<html lang="en">
<!-- ========== App Menu ========== -->
<?php
$this->validation = \Config\Services::validation();
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="E-KOST PINK - Aplikasi Manajemen Kost by afapedia" />
    <meta name="keywords" content="admin template, afapedia admin template, dashboard template, flat admin template, responsive admin template, web app afapedia" />
    <meta name="author" content="pixelstrap" />
    <link rel="icon" href="<?= base_url(); ?>/public/assets/images/favicon.png" type="image/x-icon" />
    <link rel="shortcut icon" href="<?= base_url(); ?>/public/assets/images/favicon.png" type="image/x-icon" />
    <title>E-KOST PINK - Aplikasi Manajemen Kost</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/public/assets/css/fontawesome.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/public/assets/css/icofont.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/public/assets/css/themify.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/public/assets/css/flag-icon.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/public/assets/css/feather-icon.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/public/assets/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/public/assets/css/style.css" />
    <link id="color" rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/color-1.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/public/assets/css/responsive.css" />
</head>

<body>
    <div class="loader-wrapper">
        <div class="theme-loader">
            <div class="loader-p"></div>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-7"><img class="bg-img-cover bg-center" src="<?= base_url(); ?>/public/assets/images/login/bg2.png" alt="looginpage" /></div>
                <div class="col-xl-5 p-0">

                    <div class="login-card">
                        <form class="theme-form login-form " method="post" action="<?php echo site_url('login/register'); ?>" enctype="multipart/form-data">
                            <h4>Register Akun</h4>
                            <h6>Buat Akun Untuk Melanjutkan</h6>

                            <?php if (!empty(session()->getFlashdata('error_login'))) : ?>
                                <div class="alert alert-danger alert-dismissible fade show mt-2 mb-2" role="alert">
                                    <?= session()->getFlashdata('error_login') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <div class="card-body">

                                <div class="form-group row mb-3">
                                    <label class="col-md-12 col-form-label" for="nama_customer">Nama Customer</label>
                                    <div class="col-md-12">
                                        <input type="text" id="email" name="nama_customer" class="form-control" placeholder="Nama Customer" value="<?= old('nama_customer') ?>" required>
                                        <?php if ($this->validation->getError('nama_customer')) { ?>
                                            <div class='mt-2 input-error'>
                                                <?= $this->validation->getError('nama_customer'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label class="col-md-12 col-form-label" for="email">Email</label>
                                    <div class="col-md-12">
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?= old('email') ?>" required>
                                        <?php if ($this->validation->getError('email')) { ?>
                                            <div class='mt-2 input-error'>
                                                <?= $this->validation->getError('email'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-md-12 col-form-label" for="telepon">Telepon</label>
                                    <div class="col-md-12">
                                        <input type="text" id="telepon" name="telepon" class="form-control" placeholder="Telepon" value="<?= old('telepon') ?>" required>
                                        <?php if ($this->validation->getError('telepon')) { ?>
                                            <div class='mt-2 input-error'>
                                                <?= $this->validation->getError('telepon'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label class="col-md-12 col-form-label" for="tanggal_lahir">Tanggal Lahir</label>
                                    <div class="col-md-12">
                                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" placeholder="Tanggal Lahir" value="<?= old('tanggal_lahir') ?>" required>
                                        <?php if ($this->validation->getError('tanggal_lahir')) { ?>
                                            <div class='mt-2 input-error'>
                                                <?= $this->validation->getError('tanggal_lahir'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>


                                <div class="form-group row mb-3">
                                    <label class="col-md-12 col-form-label" for="jenis_kelamin">Jenis Kelamin</label>
                                    <div class="col-md-12">
                                        <select name="jenis_kelamin" class="form-select" required>
                                            <?php
                                            echo '<option>Jenis Kelamin...</option>';
                                            foreach ($mjk as $val) {
                                                echo '<option value="' . $val . '">' . $val . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row mb-3">
                                    <label class="col-md-12 col-form-label" for="alamat">Alamat</label>
                                    <div class="col-md-12">
                                        <textarea type="alamat" id="alamat" name="alamat" class="form-control" placeholder="Alamat" required><?= old('alamat') ?></textarea>
                                        <?php if ($this->validation->getError('alamat')) { ?>
                                            <div class='mt-2 input-error'>
                                                <?= $this->validation->getError('alamat'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>


                                <div class="form-group row mb-3">
                                    <label class="col-md-12 col-form-label" for="username">Username</label>
                                    <div class="col-md-12">
                                        <input type="text" id="username" name="username" class="form-control" placeholder="Username" value="<?= old('username') ?>" required>
                                        <?php if ($this->validation->getError('username')) { ?>
                                            <div class='mt-2 input-error'>
                                                <?= $this->validation->getError('username'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>



                                <div class="form-group row mb-3">
                                    <label class="col-md-12 col-form-label" for="password">Password</label>
                                    <div class="col-md-12">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" value="<?= old('password') ?>" required>
                                        <?php if ($this->validation->getError('password')) { ?>
                                            <div class='mt-2 input-error'>
                                                <?= $this->validation->getError('password'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>




                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" id="btn-save" class="btn btn-md btn-primary">
                                    <i class="ri-save-line"></i> Register
                                </button>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="<?= base_url(); ?>/public/assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?= base_url(); ?>/public/assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="<?= base_url(); ?>/public/assets/js/icons/feather-icon/feather-icon.js"></script>
    <script src="<?= base_url(); ?>/public/assets/js/sidebar-menu.js"></script>
    <script src="<?= base_url(); ?>/public/assets/js/config.js"></script>
    <script src="<?= base_url(); ?>/public/assets/js/bootstrap/popper.min.js"></script>
    <script src="<?= base_url(); ?>/public/assets/js/bootstrap/bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>/public/assets/js/script.js"></script>
</body>

</html>
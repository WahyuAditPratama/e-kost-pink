<!DOCTYPE html>
<html lang="en">

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
                <!-- <div class="col-xl-7"><img class="bg-img-cover bg-center" src="<?= base_url(); ?>/public/assets/images/login/bg2.png" alt="looginpage" /></div> -->
                <div class="col-xl-5 p-0">
                    <div class="login-card">
                        <form class="theme-form login-form" id="loginForm" action="<?= base_url('login') ?>" method="post">
                            <h4>Login Aplikasi</h4>
                            <h6>Welcome back! Log in to your account.</h6>

                            <?php if (!empty(session()->getFlashdata('error_login'))) : ?>
                                <div class="alert alert-danger alert-dismissible fade show mt-2 mb-2" role="alert">
                                    <?= session()->getFlashdata('error_login') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <div class="form-group">
                                <label>Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="icon-user"></i></span>
                                    <input class="form-control" type="username" required="" name="username" placeholder="username" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="icon-lock"></i></span>
                                    <input class="form-control" type="password" name="password" required="" placeholder="*********" />
                                    <div class="show-hide"><span class="show"> </span></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit">Login</button>
                            </div>

                            <!-- <p>Belum Punya akun?<a class="ms-2" href="<?= site_url('login/register'); ?>">Buat Akun</a></p>
                            <a class="mt-3 btn btn-warning" href="<?= base_url(); ?>">Ke Halaman Utama</a> -->
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
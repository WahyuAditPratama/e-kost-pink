<?php
$db = db_connect();
$countcart = $db->query("select id from booking where status='draft'and id_customer='" . $this->auth->userid . "' ")->getNumRows();
?>

<header class="landing-header">
    <div class="custom-container">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-light p-0" id="navbar-example2"><a class="navbar-brand" href="javascript:void(0)"> <img class="img-fluid" src="<?= base_url() ?>/public/assets/images/logo.png" alt=""></a>

                    <?php if ($this->auth->roles() == "customer") { ?>
                        <ul class="landing-menu nav nav-pills">
                            <li class="nav-item menu-back">back<i class="fa fa-angle-right"></i></li>
                            <li class="nav-item"><a class="nav-link" href="<?= site_url('home'); ?>">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= site_url('home/room'); ?>">room</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= site_url('home/tentang'); ?>">Tentang Kami</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= site_url('home/lokasi'); ?>">Lokasi</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= site_url('home/faq'); ?>">FAQ</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= site_url('pengguna/booking'); ?>">Buat Pesanan</a></li>
                        </ul>

                        <div class="buy-block">
                            <a class="btn btn-outline-primary fs-6" href="<?= site_url('pengguna/cart'); ?>"><i class="fa fa-shopping-cart"></i> Cart <?= $countcart > 0 ? '<span class="text-danger fw-bold">(' . $countcart . ')</span>' : ''; ?></a>
                            &emsp;
                            <a class="btn btn-outline-primary fs-6" href="<?= site_url('pengguna/profile'); ?>"><i class="fa fa-user"></i> Profile </a><!-- <sup class="text-danger fw-bold" style="font-size: 32px;">.</sup> -->
                            &emsp;
                            <a class="btn-landing" href="<?= site_url('logout'); ?>">Logout</a>
                            <div class="toggle-menu"><i class="fa fa-bars"></i></div>
                        </div>
                    <?php   } else { ?>

                        <ul class="landing-menu nav nav-pills">
                            <li class="nav-item menu-back">back<i class="fa fa-angle-right"></i></li>
                            <li class="nav-item"><a class="nav-link" href="<?= site_url('home'); ?>">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= site_url('home/room'); ?>">room</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= site_url('home/tentang'); ?>">Tentang Kami</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= site_url('home/lokasi'); ?>">Lokasi</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= site_url('home/faq'); ?>">FAQ</a></li>
                        </ul>

                        <div class="buy-block"><a class="btn-landing" href="<?= site_url('login'); ?>">Login / Daftar</a>
                            <div class="toggle-menu"><i class="fa fa-bars"></i></div>
                        </div>
                </nav>
            <?php } ?>
            </div>
        </div>
    </div>
</header>
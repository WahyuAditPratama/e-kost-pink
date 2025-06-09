<!-- ========== App Menu ========== -->
<?php
$routeName = (is_null($this->uri->getSegment(2))) ? "dashboard" : $this->uri->getSegment(2);
?>


<header class="main-nav">
    <div class="sidebar-user text-center">
        <img class="img-90 rounded-circle" src="<?= base_url() ?>/public/assets/images/dashboard/1.png" alt="">
        <div class="badge-bottom ">
            <span class="badge badge-primary"><?= $this->auth->rolesdesc; ?></span>
        </div>
        <a href="user-profile.html">
            <h6 class="mt-3 pt-3 f-14 f-w-600"><?= $this->auth->nama; ?></h6>
        </a>
        <p class="mb-0 font-roboto"><?= $this->auth->email; ?></p>
    </div>
    <nav>
        <div class="main-navbar">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="mainnav">
                <ul class="nav-menu custom-scrollbar">


                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>
                    <li><a class="nav-link menu-title link-nav <?= $routeName == "dashboard" ? 'active' : '' ?>" href="<?= site_url('dashboard'); ?>"><i data-feather="airplay"></i><span> Dashboard </span></a></li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="mt-3 f-12 f-w-600">Master Data </h6>
                        </div>
                    </li>
                    <li><a class="nav-link menu-title link-nav <?= $routeName == "room" ? 'active' : '' ?>" href="<?= site_url('room'); ?>"><i data-feather="check-square"></i><span>Room</span></a></li>
                    <li><a class="nav-link menu-title link-nav <?= $routeName == "customer" ? 'active' : '' ?>" href="<?= site_url('customer'); ?>"><i data-feather="users"></i><span>Data Customer</span></a></li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="mt-3 f-12 f-w-600">Transaksi </h6>
                        </div>
                    </li>
                    <li><a class="nav-link menu-title link-nav <?= $routeName == "booking" ? 'active' : '' ?>" href="<?= site_url('booking'); ?>"><i data-feather="credit-card"></i><span>Booking</span></a></li>
                    <li><a class="nav-link menu-title link-nav <?= $routeName == "order" ? 'active' : '' ?>" href="<?= site_url('order'); ?>"><i data-feather="database"></i><span>Data Sewa Bulanan</span></a></li>
                    <li><a class="nav-link menu-title link-nav <?= $routeName == "notifikasi" ? 'active' : '' ?>" href="<?= site_url('notifikasi'); ?>"><i data-feather="bell"></i><span>Notifikasi</span></a></li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="mt-3 f-12 f-w-600">Laporan </h6>
                        </div>
                    </li>
                    <li><a class="nav-link menu-title link-nav <?= $routeName == "laporancustomer" ? 'active' : '' ?>" href="<?= site_url('laporan/laporan_customer'); ?>"><i data-feather="file-text"></i><span>Laporan Data Customer </span></a></li>
                    <li><a class="nav-link menu-title link-nav <?= $routeName == "laporanorder" ? 'active' : '' ?>" href="<?= site_url('laporan/laporan_tagihan'); ?>"><i data-feather="file-text"></i><span>Laporan Data Transaksi</span></a></li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="mt-3 f-12 f-w-600">Manajemen Akun</h6>
                        </div>
                    </li>
                    <li><a class="nav-link menu-title link-nav <?= $routeName == "users" ? 'active' : '' ?>" href="<?= site_url('users'); ?>"><i data-feather="user"></i><span>Akun Pengguna</span></a></li>
                    <li><a class="nav-link menu-title link-nav <?= $routeName == "usersroles" ? 'active' : '' ?>" href="<?= site_url('usersroles'); ?>"><i data-feather="briefcase"></i><span>Role Pengguna</span></a></li>


                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>
<?php
$this->session = \Config\Services::session();
$this->model = new \App\Models\AuthModel();
$this->auth = new \App\Libraries\Auth();
$this->validation = \Config\Services::validation();
$this->uri = new \CodeIgniter\HTTP\URI(current_url());


$db = db_connect();

$countnotif = $db->query("select id from notifikasi where dibaca='belum'")->getNumRows();
$notifikasi = $db->query("select * from notifikasi where  penerima='" . $this->auth->userid . "' and dibaca='belum'")->getResult();

?>

<div class="page-main-header">
    <div class="main-header-right row m-0">
        <div class="main-header-left">
            <div class="logo-wrapper" style="height:45px"><a href="<?= base_url(); ?>"><img class="img-fluid" src="<?= base_url() ?>/public/assets/images/logo.png" alt="" style="height:45px"></a></div>
            <div class="dark-logo-wrapper"><a href="<?= base_url(); ?>"><img class="img-fluid" src="<?= base_url() ?>/public/assets/images/logo/logo.png" alt="" style="height:45px"></a></div>
            <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="align-center" id="sidebar-toggle"></i></div>
        </div>

        <div class="nav-right col pull-right right-menu p-0">
            <ul class="nav-menus">
                <li class="onhover-dropdown">
                    <div class="notification-box"><i data-feather="bell"></i><?= $countnotif > 0 ? '<span class="dot-animated"></span>' : ''; ?> </div>
                    <ul class="notification-dropdown onhover-show-div">
                        <li>
                            <p class="f-w-700 mb-0">Notifikasi</p>
                        </li>
                        <li class="noti-primary">

                            <div class="media">
                                <div class="media-body">
                                    <?php foreach ($notifikasi as $item) { ?>
                                        <p><?= $item->judul; ?> </p><span><?= $item->created_at; ?> </span>

                                    <?php } ?>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
                <!-- <li>
                    <div class="mode"><i class="fa fa-moon-o"></i></div>
                </li> -->

                <li class="onhover-dropdown p-0">
                    <button class="btn btn-primary-light" type="button"><a href="<?= base_url('logout') ?>"><i data-feather="log-out"></i>Log out</a></button>
                </li>
            </ul>
        </div>
        <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
    </div>
</div>
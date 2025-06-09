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
                                    <h4 class="fw-bold">Histori Booking</h4>
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
                                    <a class="btn btn-outline-primary fs-6 mb-3 py-3 mx-3 text-start" href="<?= site_url('pengguna/profile'); ?>"> <i class="fa fa-user"></i> Update Profile</a>
                                    <a class="btn btn-outline-primary fs-6 mb-3 py-3 mx-3  text-start" href="<?= site_url('pengguna/order'); ?>"> <i class="fa fa-bookmark-o"></i> Pesanan Saya </a>
                                    <a class="btn btn-primary fs-6 mb-3 py-3 mx-3  text-start" href="<?= site_url('pengguna/histori'); ?>"> <i class="fa fa-archive"></i> Histori</a>
                                    <a class="btn btn-outline-primary fs-6 mb-3 py-3 mx-3  text-start" href="<?= site_url('logout'); ?>"> <i class="fa fa-sign-out"></i> Logout</a>
                                </div>

                            </div>
                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <h4 class="card-title mb-0">Booking</h4>
                                        <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
                                    </div>
                                    <div class="card-body">

                                    </div>
                                </div>
                                <?php foreach ($bookings as $booking) {

                                    $bgstatus = "badge-warning";
                                    if ($booking->status == "draft") {
                                        $bgstatus = "badge-warning";
                                    } elseif ($booking->status == "konfrmasi") {
                                        $bgstatus = "badge-secondary";
                                    } elseif ($booking->status == "proses") {
                                        $bgstatus = "badge-secondary";
                                    } elseif ($booking->status == "pickup") {
                                        $bgstatus = "badge-secondary";
                                    } elseif ($booking->status == "on_treatment") {
                                        $bgstatus = "badge-secondary";
                                    } elseif ($booking->status == "delivery") {
                                        $bgstatus = "badge-secondary";
                                    } elseif ($booking->status == "selesai") {
                                        $bgstatus = "badge-success";
                                    } elseif ($booking->status == "batal") {
                                        $bgstatus = "badge-danger";
                                    } else {
                                        $bgstatus = "badge-warning";
                                    }



                                ?>
                                    <div class="card">

                                        <div class="card-header pb-0 align-items-center d-flex">
                                            <div class=" flex-grow-1">
                                                <h6>Invoice No : <?= $booking->invoice; ?></h6>

                                            </div>
                                            <div class="flex-shrink-0">
                                                <span class="badge <?= $bgstatus; ?>">Status : <?= $booking->status; ?></span>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="order-history table-responsive wishlist">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th width="35%">Nama Produk</th>
                                                                <th class="text-end">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($booking->detail as $detail) { ?>
                                                                <tr>
                                                                    <td colspan="2" class="total-amount text-start align-top">
                                                                        <?= $detail->nama_barang; ?>
                                                                    </td>

                                                                </tr>

                                                            <?php } ?>

                                                            <tr>

                                                                <td colspan="2" class="total-amount">
                                                                    <h6 class="m-0 text-end"><span class="f-w-600">Rp <?= number_format($booking->total); ?> </span></h6>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-end" colspan="2"> <a class="btn btn-success cart-btn-transform" href="<?= site_url('pengguna/detail/' . $booking->invoice . ''); ?>">Detail</a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
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
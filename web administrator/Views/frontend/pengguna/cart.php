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
                                    <h4 class="fw-bold">Cart</h4>
                                </div>
                            </div>

                            <?php foreach ($bookings as $booking) { ?>
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <h5>Invoice No : <?= $booking->invoice; ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="order-history table-responsive wishlist">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th width="35%">Nama Produk</th>
                                                            <th>room</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($booking->detail as $detail) { ?>
                                                            <tr>
                                                                <td class="total-amount text-start align-top">
                                                                    <?= $detail->nama_barang; ?>
                                                                </td>
                                                                <td>
                                                                    <table class="table table-bordered">
                                                                        <?php foreach ($detail->room as $row) { ?>
                                                                            <tr>
                                                                                <td class="total-amount text-start" width="60%">
                                                                                    <p><?= $row->nama_room; ?></p>
                                                                                </td>
                                                                                <td><a id="Remove" type="button" class="btn btn-iconsolid btn-danger btn-xs" href="<?= site_url('pengguna/removeitem/' . trim(base64_encode($row->id), '=') . '') ?>" data-toggle="modal">
                                                                                        <i class="fa fa-trash-o"></i>
                                                                                    </a></td>
                                                                                <td class="total-amount text-end fw-bold">Rp <?= number_format($row->nominal); ?></td>
                                                                            </tr>

                                                                        <?php } ?>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" class="total-amount text-start">
                                                                    Catatan : <?= $detail->catatan; ?>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>

                                                        <tr>
                                                            <td class="total-amount">
                                                                <h6 class="m-0 text-end"><span class="f-w-600">Total Price :</span></h6>
                                                            </td>
                                                            <td class="total-amount">
                                                                <h6 class="m-0 text-end"><span class="f-w-600">Rp <?= number_format($booking->total); ?> </span></h6>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-end"><a class="btn btn-secondary cart-btn-transform" href="<?= site_url('pengguna/booking'); ?>">Lanjutkan Booking</a></td>
                                                            <td class="text-end"><a id="Cancel" class="btn btn-danger cart-btn-transform" href="<?= site_url('pengguna/cancel/' . $booking->invoice . ''); ?>">Batalkan Pesanan</a>
                                                                <a class="btn btn-success cart-btn-transform" href="<?= site_url('pengguna/checkout/' . $booking->invoice . ''); ?>">check out</a>
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
    <script>
        $(document).on('click', '#Remove', function(e) {
            e.preventDefault();
            var link = $(this).attr('href');
            $('#modal-confirm-delete-footer').html("<form action='" + link + "' method='get'><button type='submit' class='btn btn-primary  btn-md mx-2'>Hapus</button><button type='button' class='btn btn-secondary btn-md' data-bs-dismiss='modal'>Batal</button></form>");
            $('#modal-confirm-delete').modal('show');
        });


        $(document).on('click', '#Cancel', function(e) {
            e.preventDefault();
            var link = $(this).attr('href');
            $('#modal-confirm-cancel-footer').html("<form action='" + link + "' method='get'><button type='submit' class='btn btn-primary  btn-md mx-2'>Batalkan Pesanan</button><button type='button' class='btn btn-secondary btn-md' data-bs-dismiss='modal'>Batal</button></form>");
            $('#modal-confirm-cancel').modal('show');
        });
    </script>
</body>

</html>


<!-- Container-fluid starts-->

<!-- Container-fluid Ends-->
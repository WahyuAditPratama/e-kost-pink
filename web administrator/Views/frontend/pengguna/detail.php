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
                                    <h4 class="fw-bold">Detail Booking</h4>
                                </div>
                            </div>
                            <div class="card" id="print">
                                <div class="card-body">
                                    <div>
                                        <div>
                                            <div class="row invo-header">
                                                <div class="col-sm-6">
                                                    <div class="media">
                                                        <div class="media-body">
                                                            <h4 class="media-heading f-w-600">E-Kost Pink</h4>
                                                            <p>E-Kost Pinkshoecare@mail.com<br><span class="digits">0822-289-335-6503</span></p>
                                                        </div>
                                                    </div>
                                                    <!-- End Info-->
                                                </div>
                                                <div class="col-sm-6 ">
                                                    <div class="text-md-end text-xs-center">
                                                        <h3>Invoice No #<span class="digits counter"><?= $booking->invoice; ?></span></h3>
                                                        <p>Tanggal Invoice: <?= $booking->created_at; ?></span>
                                                            <br> Tanggal Pembayaran: <?= $bookingpayment ? $bookingpayment->created_at : 'Belum Konfrmasi Pembayaran'; ?></span>
                                                        </p>
                                                    </div>
                                                    <!-- End Title                                 -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End InvoiceTop-->
                                        <div class="row invo-profile my-3">
                                            <div class="col-xl-4">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <h4 class="media-heading f-w-600"><?= $muser->nama_customer; ?></h4>
                                                        <p><?= $muser->email; ?><br><span class="digits"><?= $muser->telepon; ?></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-8">
                                                <div class="text-xl-end" id="project">
                                                    <h6>Alamat Pickup :</h6>
                                                    <p><?= $muser->alamat; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Invoice Mid-->
                                        <div>
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

                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="text-center bg-secondary py-2 my-3">
                                                <p class="lead mb-0">
                                                    <span class="total-amount fw-bold">Total Pembayaran: </span>
                                                    <small class="total-amount align-top fw-bold">Rp </small><?= number_format($booking->total); ?>
                                                </p>
                                                <span class="total-amount">Terbilang: </span>
                                                <em class="total-amount"><?= terbilang($booking->total); ?> rupiah</em>
                                            </div>


                                            <div class="col-lg-12 mt-3">
                                                <div class="card border-1 p-3 shadow-0">

                                                    <div class="pb-0 align-items-center d-flex">
                                                        <div class=" flex-grow-1">
                                                            <h5 class="fw-bold">Satus Booking</h5>
                                                            <p>status pesanan kamu</p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <?php


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
                                                            <span class="badge <?= $bgstatus; ?>">
                                                                <p>Status : <?= $booking->status; ?></p>
                                                            </span>

                                                        </div>
                                                    </div>
                                                    <div class="row">


                                                        <?php if ($bookingpayment && $bookingpayment->payment_method == "cod") { ?>

                                                            <div class="col-sm-6">
                                                                <p class="fw-bold">Metode Pembayaran</p>

                                                                <div class="card">
                                                                    <div class="media p-20">
                                                                        <div class="media-body">
                                                                            <h6 class="mt-0 mega-title-badge">COD<span class="badge badge-primary pull-right digits">Cash On Delivery</span></h6>
                                                                            <p>Pembayaran dilakukan saat pesanan selesai</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>



                                                        <?php } elseif ($bookingpayment && $bookingpayment->payment_method == "transfer") { ?>



                                                            <div class="col-sm-6">
                                                                <p class="fw-bold">Metode Pembayaran</p>
                                                                <div class="card">
                                                                    <div class="media p-20">
                                                                        <div class="media-body">
                                                                            <h6 class="mt-0 mega-title-badge">Transfer Manual<span class="badge badge-secondary pull-right digits">Transfer Bank</span></h6>
                                                                            <p>Pembayaran via bank transfer dan upload pembayaran</p>
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <p class="fw-bold">Bank Transfer</p>
                                                                <div class="card">
                                                                    <div class="media p-20">
                                                                        <div class="media-body">
                                                                            <h6 class="mt-0 mega-title-badge">No Rekening: <?= $mbank->no_rek ?><span class="badge bg-primary pull-right digits"><?= $mbank->bank; ?></span></h6>
                                                                            <p>Atas Nama: <?= $mbank->nama; ?></p>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="pb-0 align-items-center d-flex">
                                                                    <div class=" flex-grow-1">
                                                                        <p class="fw-bold">Bukti Bayar</p>

                                                                    </div>
                                                                    <div class="flex-shrink-0">
                                                                        <?php
                                                                        $path = "public/uploads/bukti_bayar/";
                                                                        $file_path = ROOTPATH . $path . $bookingpayment->bukti_bayar;
                                                                        $bukti_bayar_url = base_url() . '/' . $path . $bookingpayment->bukti_bayar;

                                                                        if (file_exists($file_path)) {
                                                                            $pathfile = "<a href='" . $bukti_bayar_url . "' class='btn btn-sm btn-success' target='_blank'>Lihat Bukti Pembayaran</a>";
                                                                        } else {
                                                                            $pathfile = "<span class='badge bg-danger'>Tidak Ada File</span>";
                                                                        }
                                                                        echo $pathfile;
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>

                                                    </div>
                                                </div>


                                                <!-- End Table-->
                                                <div class="row mt-3">
                                                    <div class="col-md-8">
                                                        <div>
                                                            <p class="legal"><strong>Terimakasih telah menggunakan jasa room kami!!</strong> Setelah pembayaran dikonfirmasi agen kami akan mengambil dan mengantarkan pesanan kamu ketika telah selesai</p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- End InvoiceBot-->
                                        </div>

                                        <?php if ($booking->status == "batal" || $booking->status == "draft") { ?>

                                        <?php } else { ?>

                                            <div class="col-sm-12 text-end mt-3">
                                                <a class="btn btn-success cart-btn-transform" href="<?= site_url('pengguna/cetak_invoice/' . $booking->invoice . ''); ?>">Cetak Invoice</a>
                                            </div>

                                        <?php  } ?>
                                        <!-- End Invoice-->
                                        <!-- End Invoice Holder-->
                                    </div>
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




    <script>
        function myFunction() {
            window.print();
        }
    </script>

</body>

</html>


<!-- Container-fluid starts-->

<!-- Container-fluid Ends-->
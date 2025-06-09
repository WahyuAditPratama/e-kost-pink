<?= $this->include('partials/frontend/head-css') ?>
<style>
    @media print {
        .noprint {
            display: none;
        }
    }
</style>

<body style="font-size: 12px;">
    <!-- tap on top starts-->
    <div class="custom-container">
        <div class="row">
            <!--  user profile first-style start-->
            <div class="col-sm-12 box-col-12">
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
                                                <br> Tanggal Pembayaran: <?= $bookingpayment->created_at; ?></span>
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

                                                <span class="badge badge-warning">
                                                    <p>Status : <?= $booking->status; ?></p>
                                                </span>

                                            </div>
                                        </div>
                                        <div class="row">


                                            <?php if ($bookingpayment->payment_method == "cod") { ?>

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



                                            <?php } else { ?>



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
                            <div class="col-sm-12 text-end mt-3">
                                <button class="btn btn btn-primary me-2 noprint" type="button" onclick="myFunction()">Cetak Invoice</button>
                            </div>
                            <!-- End Invoice-->
                            <!-- End Invoice Holder-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?= $this->include('partials//frontend/vendor-scripts') ?> </body>
<script>
    function myFunction() {
        window.print();
    }
</script>

</html>


<!-- Container-fluid starts-->

<!-- Container-fluid Ends-->
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
                                    <h4 class="fw-bold">Checkout</h4>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Invoice No : <?= $mdata->invoice; ?></h5>
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
                                                    <?php foreach ($mdata->detail as $detail) { ?>
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
                                                            <h6 class="m-0 text-end"><span class="f-w-600">Rp <?= number_format($mdata->total); ?> </span></h6>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Konfirmasi Pembayaran</h5>
                                </div>

                                <form method="post" action="<?php echo site_url('pengguna/konfirmasi'); ?>" enctype="multipart/form-data">
                                    <input type="hidden" name="invoice" value="<?= $mdata->invoice; ?>">
                                    <input type="hidden" name="total" value="<?= $mdata->total; ?>">
                                    <div class="card-body">
                                        <div class="text-center bg-secondary py-2 my-3">
                                            <p class="lead mb-0">
                                                <span class="total-amount fw-bold">Total Pembayaran: </span>
                                                <small class="total-amount align-top fw-bold">Rp </small><?= number_format($mdata->total); ?>
                                            </p>
                                            <span class="total-amount">Terbilang: </span>
                                            <em class="total-amount"><?= terbilang($mdata->total); ?> rupiah</em>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 mt-3">
                                                <div class="card border-1 p-3 shadow-0">
                                                    <h5 class="fw-bold ">Detail Pemesan</h5>
                                                    <p> Pastikan data yang anda masukan sudah sesuai</p>

                                                    <div class="row">
                                                        <input type="hidden" name="id" id="id" value="<?php echo $muser->id; ?>">
                                                        <div class="form-group mb-3 col-lg-6">
                                                            <label class="col-md-12 col-form-label" for="nama_customer">Nama Customer</label>
                                                            <div class="col-md-12">
                                                                <input type="text" id="email" name="nama_customer" class="form-control py-2 " placeholder="Nama Customer" value="<?= old('nama_customer', $muser->nama_customer) ?>" required readonly>
                                                                <?php if ($this->validation->getError('nama_customer')) { ?>
                                                                    <div class='mt-2 input-error'>
                                                                        <?= $this->validation->getError('nama_customer'); ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>


                                                        <div class="form-group mb-3 col-lg-6">
                                                            <label class="col-md-12 col-form-label" for="email">Email</label>
                                                            <div class="col-md-12">
                                                                <input type="email" id="email" name="email" class="form-control py-2 " placeholder="Email" value="<?= old('email', $muser->email) ?>" required readonly>
                                                                <?php if ($this->validation->getError('email')) { ?>
                                                                    <div class='mt-2 input-error'>
                                                                        <?= $this->validation->getError('email'); ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label class="col-md-12 col-form-label" for="telepon">Telepon</label>
                                                            <div class="col-md-12">
                                                                <input type="text" id="telepon" name="telepon" class="form-control py-2 " placeholder="Telepon" value="<?= old('telepon', $muser->telepon) ?>" required readonly>
                                                                <?php if ($this->validation->getError('telepon')) { ?>
                                                                    <div class='mt-2 input-error'>
                                                                        <?= $this->validation->getError('telepon'); ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label class="col-md-12 col-form-label" for="alamat">Alamat</label>
                                                            <div class="col-md-12">
                                                                <textarea type="alamat" id="alamat" name="alamat" class="form-control py-2 " placeholder="Alamat" rows="5" required readonly><?= old('alamat', $muser->alamat) ?></textarea>
                                                                <?php if ($this->validation->getError('alamat')) { ?>
                                                                    <div class='mt-2 input-error'>
                                                                        <?= $this->validation->getError('alamat'); ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-lg-6 mt-3">
                                                <div class="card border-1 p-3 shadow-0">
                                                    <h5 class="fw-bold">Pilih Metode Pembayaran</h5>
                                                    <p>Pilih metode pembayaran yang kamu gunakan</p>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="card">
                                                                <div class="media p-20">
                                                                    <div class="radio radio-primary me-3">
                                                                        <input id="radio11" type="radio" name="payment_method" value="cod">
                                                                        <label for="radio11"></label>
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <h6 class="mt-0 mega-title-badge">COD<span class="badge badge-primary pull-right digits">Cash On Delivery</span></h6>
                                                                        <p>Pembayaran dilakukan saat pesanan selesai</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="card">
                                                                <div class="media p-20">
                                                                    <div class="radio radio-secondary me-3">
                                                                        <input id="radio12" type="radio" name="payment_method" value="transfer">
                                                                        <label for="radio12"></label>
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <h6 class="mt-0 mega-title-badge">Transfer Manual<span class="badge badge-secondary pull-right digits">Transfer Bank</span></h6>
                                                                        <p>Pembayaran via bank transfer dan upload pembayaran</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="pembayaran" class="pembayaran" style="display:none;">
                                                        <p class="mb-0">Silahkan Lakukan pembayaran ke salah satu no rekening dibawah lalu upload bukti pembayaran</p>
                                                        <?php foreach ($mbank as $item) { ?>
                                                            <div class="card">
                                                                <div class="media p-20">
                                                                    <div class="media-body">
                                                                        <h6 class="mt-0 mega-title-badge">No Rekening: <?= $item->no_rek ?><span class="badge bg-primary pull-right digits"><?= $item->bank; ?></span></h6>
                                                                        <p>Atas Nama: <?= $item->nama; ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="form-group row mb-3">
                                                            <label class="col-md-3 col-form-label" for="bukti_bayar">Bukti Pembayaran</label>
                                                            <div class="col-md-9">
                                                                <input type="file" id="bukti_bayar" name="bukti_bayar" class="form-control" accept="image/*">
                                                                <small class="form-text text-muted">Maximum upload size: 2 mb</small>
                                                                <?php if ($this->validation->getError('bukti_bayar')) { ?>
                                                                    <div class='mt-2 input-error'>
                                                                        <?= $this->validation->getError('bukti_bayar'); ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-end">
                                                        <button type="submit" id="btn-save" class="btn py-2 btn-primary"><i class="fa fa-shopping-cart"></i> Konfirmasi Pembayaran</button>
                                                    </div>
                                                </div>
                                            </div>

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
    <script>
        $(document).on('click', '#Remove', function(e) {
            e.preventDefault();
            var link = $(this).attr('href');
            $('#modal-confirm-delete-footer').html("<form action='" + link + "' method='get'><button type='submit' class='btn btn-primary  btn-md mx-2'>Hapus</button><button type='button' class='btn btn-secondary btn-md' data-bs-dismiss='modal'>Batal</button></form>");
            $('#modal-confirm-delete').modal('show');
        });
    </script>

    <script>
        $(document).ready(function() {
            $('input[name="payment_method"]').on('change', function() {
                if ($(this).val() === 'transfer') {
                    $('#pembayaran').show();
                    $('#bukti_bayar').prop('required', true);
                } else {
                    $('#pembayaran').hide();
                    $('#bukti_bayar').prop('required', false);
                }
            });
        });
    </script>

</body>

</html>


<!-- Container-fluid starts-->

<!-- Container-fluid Ends-->
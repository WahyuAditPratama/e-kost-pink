<?= $this->include('partials/frontend/head-css') ?>

<body class="landing-wrraper">
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <div class="page-wrapper">
        <div class="page-body-wrapper">


            <?= $this->include('partials/frontend/menu-header') ?>
            <section class=" section-py-space my-5" id="home"><img class="img-fluid bg-img-cover" src="<?= base_url() ?>/public/assets/images/landing/landing-home/home-bg2.jpg" alt="">
                <div class="custom-container">
                    <div class="row">


                        <div class="col-sm-lg-12">
                            <div class="card">

                                <div class="card-body">
                                    <div class="row row-lg">
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="u-step done bg-primary"><span class="u-step-number txt-primary"></span>
                                                <div class="u-step-desc"><span class="u-step-title">Buat Pesanan Kamu</span>
                                                    <p>Buat pesanan kamu sesuai dengan karakteristik sepatu dan room yang akan kamu pilih dengan melengkapi form dibawah ini</p>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <form method="post" action="<?php echo site_url('pengguna/addtocart'); ?>" enctype="multipart/form-data">

                                <div class="card">
                                    <div class="card-header pb-0">
                                        <h5>Detail Pemesan</h5>
                                        <p> Untuk mengubah data seperti alamat dan no telepon silahkan update profil kamu melalui menu profile</p>
                                    </div>

                                    <div class="card-body">
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
                                    <div class="card-footer text-end">
                                        <a class="btn btn-secondary py-2" href="<?= site_url('pengguna/profile'); ?>"> Update Profile</a>

                                    </div>

                                </div>


                                <div id="equipmentRows"></div>


                                <div class="card">
                                    <div class="card-header text-end">
                                        <button class="btn py-2 btn-secondary" type="button" id="addRow"><i class="fa fa-plus"></i> Tambah Produk</button>
                                        <button type="submit" id="btn-save" class="btn py-2 btn-primary"><i class="fa fa-shopping-cart"></i> Masukan Ke keranjang</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <?= $this->include('partials/frontend/footer') ?>
        </div>
    </div>
    <?= $this->include('partials//frontend/vendor-scripts') ?>


    <script>
        function addRow() {
            var rowCount = $('#equipmentRows').children('.equipment-row').length;

            const roomData = <?php echo json_encode($roomdata); ?>;
            let roomHtml = '';
            roomData.forEach(row => {
                roomHtml += `
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="media p-20">
                                <div class="checkbox checkbox-primary">
                                    <input id="checkbox${rowCount}_${row.id}" type="checkbox" name="room[${rowCount}][]" value="${row.id}">
                                    <label for="checkbox${rowCount}_${row.id}"></label>
                                </div>
                                <div class="media-body">
                                    <h6 class="mt-0 mega-title-badge">${row.nama_room}<span class="badge badge-primary pull-right digits">Rp ${Number(row.harga_bulanan).toLocaleString()}</span></h6>
                                    <p>${row.deskripsi}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            let newCard = `
                <div class="card equipment-row">
                    <div class="card-header pb-0 align-items-center d-flex">
                             <div class=" flex-grow-1">
								 <h5>Detail room ${rowCount +1}</h5>
                	         </div>
							<div class="flex-shrink-0">
								    <button type="button" class="btn btn-danger btn-sm remove-row">Hapus Data</button>
                   		    </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group row mb-3">
                                <label class="col-md-12 col-form-label" for="nama_barang${rowCount}">Nama Produk</label>
                                <div class="col-md-12">
                                    <input type="text" id="nama_barang${rowCount}" name="nama_barang[]" class="form-control py-2" placeholder="Nama Produk" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-12 col-form-label" for="deskripsi${rowCount}">Deskripsi</label>
                                <div class="col-md-12">
                                    <textarea id="deskripsi${rowCount}" name="deskripsi[]" class="form-control py-2" placeholder="Deskripsi" rows="5" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-md-12 col-form-label" for="catatan${rowCount}">Catatan</label>
                                <div class="col-md-12">
                                    <textarea id="catatan${rowCount}" name="catatan[]" class="form-control py-2" placeholder="Catatan" rows="5" required></textarea>
                                </div>
                            </div>
                            <p class="fw-bold">Pilih room</p>
                            <div class="row">
                                ${roomHtml}
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#equipmentRows').append(newCard);
        }


        function updateRowNumbers() {
            $('#equipmentRows .equipment-row').each(function(index) {
                $(this).find('label:first').text('#' + (index + 1));
            });
        }

        $(document).on('click', '.remove-row', function() {
            $(this).closest('.equipment-row').remove();
            updateRowNumbers();
        });

        $('#addRow').click(addRow);
        addRow();
    </script>


</body>

</html>
<section class="landing-footer section-py-space bg-dark" id="footer">
    <div class="custom-container">
        <div class="row">
            <div class="col-lg-4 mt-4">
                <div>
                    <div class=" fs-6">
                        <p class="fw-bold">E-Kost Pink</p>
                        <p class="ff-secondary">Kami menangani perawatan sepatu. Kami melakukan perawatan secara profesional, dengan teknik khusus, serta menggunakan alat dan bahan premium untuk melakukan perawatan. Atau gunakan room antar jemput sepatu sekarang. Free untuk 5 KM pertama.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 ms-lg-auto">
                <div class="row">
                    <div class="col-sm-6 mt-4">
                        <h5 class="text-white mb-0">Navigasi</h5>
                        <div class="text-white mt-3">
                            <ul>
                                <li class="text-white mt-2"><a href="<?php site_url() ?>"><span class="text-white">Home</span></a></li>
                                <li class="text-white  mt-2"><a href="<?php site_url() ?>"><span class="text-white">room</span></a></li>
                                <li class="text-white  mt-2"><a href="<?php site_url() ?>"><span class="text-white">Tentang Kami</span></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-sm-6 mt-4">
                        <h5 class="text-white mb-0">Bantuan</h5>
                        <div class=" mt-3">
                            <ul>
                                <li class="text-white mt-2"><a href="<?php site_url() ?>"><span class="text-white">Faq</span></a></li>
                                <li class="text-white  mt-2"><a href="<?php site_url() ?>"><span class="text-white">Lokasi</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="sub-footer">
    <div class="custom-container">
        <div class="row">
            <div class="col-md-6 col-sm-2">
                <div class="footer-contain"><img class="img-fluid" src="<?= base_url() ?>/public/assets/images/logo.png" alt=""></div>
            </div>
            <div class="col-md-6 col-sm-10">
                <div class="footer-contain">
                    <p class="mb-0"> Copyright &copy; <script>
                            document.write(new Date().getFullYear())
                        </script> E-Kost Pink </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                Apakah yakin akan menghapus data ini ?
            </div>
            <div class="modal-footer" id="modal-confirm-delete-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok btn-sm">Delete</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-confirm-cancel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                Apakah yakin akan membatalkan pesanan ini ?
            </div>
            <div class="modal-footer" id="modal-confirm-cancel-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok btn-sm">Batalkan Pesanan</a>
            </div>
        </div>
    </div>
</div>
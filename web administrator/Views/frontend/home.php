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

						<div class="col-lg-6 col-sm-12 mt-3">
							<div class="demo-box">
								<h6>E-Kost Pink </h6>
								<h2 class="fw-bold">Pilihan Terbaik untuk Perawatan <span class="fw-bold text-secondary">Sepatu Kesayangan Anda</span></h2>
								<p class="fs-6">Kami menangani perawatan sepatu. Kami melakukan perawatan secara profesional, dengan teknik khusus, serta menggunakan alat dan bahan premium untuk melakukan perawatan. Atau gunakan room antar jemput sepatu sekarang. Free untuk 5 KM pertama.</p>
								<a class="btn-landing btn-lg" href="<?= site_url('login'); ?>">Booking Sekarang</a>

							</div>
						</div>
						<div class="col-lg-6 col-sm-12 mt-3">
							<img class="img-fluid" src="<?= base_url() ?>/public/assets/images/landing/banner2.png" alt="">
						</div>
					</div>
				</div>
			</section>




			<section class="demo-section section-py-space" id="demo">
				<div class="title">
					<h2>room Kami</h2>
				</div>
				<div class="custom-container">
					<div class="row demo-block demo-imgs">
						<?php foreach ($roomdata as $row) { ?>
							<div class="col-lg-3 col-sm-6">
								<div class="demo-box">
									<div class="img-wrraper"><img class="img-fluid" style="width: 100%; heigt: 480px;" src="<?= base_url() ?>/public/uploads/room/<?= $row->gambar; ?>" alt="">
										<div class="overlay">

										</div>
									</div>
									<div class="demo-detail">
										<div class="demo-title">
											<h3 class="mb-3"><?= $row->nama_room; ?></h3>
											<p><?= $row->deskripsi; ?></p>
										</div>
									</div>
								</div>
							</div>

						<?php } ?>
					</div>
				</div>
			</section>


			<section class="demo-section">
				<div class="custom-container py-5">
					<div class="row">
						<div class="col-sm">
							<div>
								<h4 class=" mb-0 fw-bold">Hubungi kami</h4>
								<p class=" mb-0 fw-semibold">Ada kendala dengan sepatu anda? Konsultasikan masalah kamu </p>
							</div>
						</div>
						<!-- end col -->
						<div class="col-sm-auto">
							<div>
								<a href="https://wa.me/1234567890" target="_blank" class="btn btn-primary btn-lg"><i class="fa fa-whatsapp align-middle me-1"></i> Hubungi Via whatsapp</a>
							</div>
						</div>
						<!-- end col -->
					</div>

				</div>
			</section>
			<!--home section end-->

			<!--footer start-->
			<?= $this->include('partials/frontend/footer') ?>
			<!--footer end-->
		</div>
	</div>

	<?= $this->include('partials//frontend/vendor-scripts') ?>
</body>

</html>
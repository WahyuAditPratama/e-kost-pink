<?= $this->include('partials/main') ?>

<head>
	<?= view('partials/title-meta', array('title' => 'Dashboard')); ?>
	<?= $this->include('partials/head-css') ?>
</head>

<body>
	<div class="page-wrapper" id="pageWrapper">
		<?= $this->include('partials/topbar') ?>
		<div class="page-body-wrapper horizontal-menu">
			<?= $this->include('partials/sidebar') ?>
			<div class="page-body">
				<?php echo view('partials/page-title', array('pagetitle' => 'Home', 'title' => 'Tambah room')); ?>
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-8">
							<div class="card">
								<form class="form-horizontal" method="post" action="<?php echo site_url('room/create'); ?>" enctype="multipart/form-data">
									<div class="card-header mb-0 b-t-success border-2 align-items-center d-flex">
										<div class=" flex-grow-1">
											<h5 class="card-title mb-0">Tambah room</h5>
										</div>
										<div class="flex-shrink-0">
											<a href="<?= base_url('room'); ?>" class="btn btn-light"><i class="ri-add-line align-middle"></i> Kembali</a>
										</div>
									</div>
									<div class="card-body">

										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="deskripsi">Nama room</label>
											<div class="col-md-9">
												<input type="text" id="nama_room" name="nama_room" class="form-control" placeholder="Nama" value="<?= old('nama_room') ?>" required>
												<?php if ($this->validation->getError('nama_room')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('nama_room'); ?>
													</div>
												<?php } ?>
											</div>
										</div>

										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="fitur">Fitur</label>
											<div class="col-md-9">
												<textarea type="fitur" id="fitur" name="fitur" class="form-control" placeholder="Fitur" required><?= old('fitur') ?></textarea>
												<?php if ($this->validation->getError('fitur')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('fitur'); ?>
													</div>
												<?php } ?>
											</div>
										</div>

										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="deskripsi">Deskripsi</label>
											<div class="col-md-9">
												<textarea type="deskripsi" id="deskripsi" name="deskripsi" class="form-control" placeholder="Deskripsi" required><?= old('deskripsi') ?></textarea>
												<?php if ($this->validation->getError('deskripsi')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('deskripsi'); ?>
													</div>
												<?php } ?>
											</div>
										</div>


										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="harga_bulanan">harga_bulanan</label>
											<div class="col-md-9">
												<input type="number" id="harga_bulanan" name="harga_bulanan" class="form-control" placeholder="harga_bulanan" value="<?= old('harga_bulanan') ?>" required>
												<?php if ($this->validation->getError('harga_bulanan')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('harga_bulanan'); ?>
													</div>
												<?php } ?>
											</div>
										</div>

										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="gambar">gambar</label>
											<div class="col-md-9">
												<input type="file" id="gambar" name="gambar" class="form-control" accept="image/*" required>
												<small class="form-text text-muted">Maximum upload size: 2 mb</small>
												<?php if ($this->validation->getError('gambar')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('gambar'); ?>
													</div>
												<?php } ?>
											</div>
										</div>



									</div>
									<div class="card-footer text-end">
										<button type="submit" id="btn-save" class="btn btn-md btn-primary">
											<i class="ri-save-line"></i> Simpan
										</button>
										<a type="button" class="btn btn-md btn-light " href="<?= base_url('room') ?>">
											<i class="ri-close-circle-line"></i> Batal
										</a>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?= $this->include('partials/footer') ?>
		</div>
	</div>
	<?= $this->include('partials/vendor-scripts') ?>
</body>

</html>
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
				<?php echo view('partials/page-title', array('pagetitle' => 'Home', 'title' => 'Edit Booking')); ?>
				<div class="container-fluid">
					<div class="row">

						<div class="col-lg-8">
							<div class="card">
								<form class="form-horizontal" method="post" action="<?php echo site_url('booking/edit'); ?>" enctype="multipart/form-data">
									<div class="card-header mb-0 b-t-success border-2 align-items-center d-flex">
										<div class=" flex-grow-1">
											<h5 class="card-title mb-0">Edit Booking</h5>
										</div>
										<div class="flex-shrink-0">
											<a href="<?= base_url('booking'); ?>" class="btn btn-light"><i class="ri-add-line align-middle"></i> Kembali</a>
										</div>
									</div>
									<div class="card-body">
										<input type="hidden" name="id" id="id" value="<?php echo $mdata->id; ?>">
										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="nama_booking">Nama booking</label>
											<div class="col-md-9">
												<input type="text" id="email" name="nama_booking" class="form-control" placeholder="Nama booking" value="<?= old('nama_booking', $mdata->nama_booking) ?>" required>
												<?php if ($this->validation->getError('nama_booking')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('nama_booking'); ?>
													</div>
												<?php } ?>
											</div>
										</div>

										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="email">Email</label>
											<div class="col-md-9">
												<input type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?= old('email', $mdata->email) ?>" required>
												<?php if ($this->validation->getError('email')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('email'); ?>
													</div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="telepon">Telepon</label>
											<div class="col-md-9">
												<input type="text" id="telepon" name="telepon" class="form-control" placeholder="Telepon" value="<?= old('telepon', $mdata->telepon) ?>" required>
												<?php if ($this->validation->getError('telepon')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('telepon'); ?>
													</div>
												<?php } ?>
											</div>
										</div>

										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="tanggal_lahir">Tanggal Lahir</label>
											<div class="col-md-9">
												<input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" placeholder="Tanggal Lahir" value="<?= old('tanggal_lahir', $mdata->tanggal_lahir) ?>" required>
												<?php if ($this->validation->getError('tanggal_lahir')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('tanggal_lahir'); ?>
													</div>
												<?php } ?>
											</div>
										</div>


										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="jenis_kelamin">Jenis Kelamin</label>
											<div class="col-md-9">
												<select name="jenis_kelamin" class="form-select" required>
													<?php
													echo '<option>Jenis Kelamin...</option>';
													foreach ($mjk as $val) {
														$selected = $val == $mdata->jenis_kelamin ? 'selected' : '';
														echo '<option value="' . $val . '" ' . $selected . '>' . $val . '</option>';
													}
													?>
												</select>
											</div>
										</div>


										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="alamat">Alamat</label>
											<div class="col-md-9">
												<textarea type="alamat" id="alamat" name="alamat" class="form-control" placeholder="Alamat" required><?= old('alamat', $mdata->alamat) ?></textarea>
												<?php if ($this->validation->getError('alamat')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('alamat'); ?>
													</div>
												<?php } ?>
											</div>
										</div>


										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="username">Username</label>
											<div class="col-md-9">
												<input type="text" id="username" name="username" class="form-control" placeholder="Username" value="<?= old('username', $mdata->username) ?>" required>
												<?php if ($this->validation->getError('username')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('username'); ?>
													</div>
												<?php } ?>
											</div>
										</div>



										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="password">Password</label>
											<div class="col-md-9">
												<input type="password" id="password" name="password" class="form-control" placeholder="Password" value="<?= old('password', $mdata->password) ?>" required>
												<?php if ($this->validation->getError('password')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('password'); ?>
													</div>
												<?php } ?>
											</div>
										</div>

										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="gambar">gambar</label>
											<div class="col-md-9">
												<input type="file" id="gambar" name="gambar" class="form-control" accept="image/*">
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
										<a type="button" class="btn btn-md btn-light " href="<?= base_url('booking') ?>">
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
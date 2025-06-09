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
				<?php echo view('partials/page-title', array('pagetitle' => 'Home', 'title' => 'Edit Pengguna')); ?>
				<div class="container-fluid">
					<div class="row">

						<div class="col-lg-8">
							<div class="card">
								<form class="form-horizontal" method="post" action="<?php echo site_url('users/edit'); ?>">
									<div class="card-header mb-0 b-t-success border-2 align-items-center d-flex">
										<div class=" flex-grow-1">
											<h5 class="card-title mb-0">Edit Pengguna</h5>
										</div>
										<div class="flex-shrink-0">
											<a href="<?= base_url('users'); ?>" class="btn btn-light"><i class="ri-add-line align-middle"></i> Kembali</a>
										</div>
									</div>
									<div class="card-body">
										<input type="hidden" name="id" id="id" value="<?php echo $mdata->id; ?>">
										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="rolesid">Roles</label>
											<div class="col-md-9">
												<select style="width:100%" class="form-select" id="rolesid" data-choices name="rolesid" required>
													<option value="">Select Roles</option>
													<?php
													if ($mroles->getNumRows() > 0) {
														foreach ($mroles->getResult() as $row) {
															$selected = ($mdata->rolesid == $row->id) ? "selected" : "";
															echo '<option value="' . $row->id . '" ' . $selected . '>' . $row->description . '</option>';
														}
													}
													?>
												</select>
												<?php if ($this->validation->getError('rolesid')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('rolesid'); ?>
													</div>
												<?php } ?>
											</div>
										</div>

										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="nama">Nama</label>
											<div class="col-md-9">
												<input type="text" id="nama" name="nama" class="form-control" placeholder="Nama" value="<?= $mdata->nama ?>" required>
												<?php if ($this->validation->getError('nama')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('nama'); ?>
													</div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="email">Email</label>
											<div class="col-md-9">
												<input type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?= $mdata->email ?>" required>
												<?php if ($this->validation->getError('email')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('email'); ?>
													</div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="username">Username</label>
											<div class="col-md-9">
												<input type="text" id="username" name="username" class="form-control" placeholder="Username" value="<?= $mdata->username ?>" readonly>
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
												<input type="password" id="password" name="password" class="form-control" placeholder="Password">
												<?php if ($this->validation->getError('password')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('password'); ?>
													</div>
												<?php } ?>
											</div>
										</div>

									</div>
									<div class="card-footer text-end">
										<button type="submit" id="btn-save" class="btn btn-md btn-primary">
											<i class="ri-save-line"></i> Simpan
										</button>
										<a type="button" class="btn btn-md btn-light " href="<?= base_url('users') ?>">
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
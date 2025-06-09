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
				<?php echo view('partials/page-title', array('pagetitle' => 'Home', 'title' => 'Dashboard')); ?>
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12">
							<div class="card">
								<div class="card-header align-items-center d-flex">
									<h4 class="card-title mb-0 flex-grow-1">Edit Akun</h4>
								</div>
								<div class="card-body">
									<form class="form-horizontal" method="post" action="<?php echo site_url('account/create'); ?>">
										<input type="hidden" name="id" id="id" value="<?php echo $mdata->id; ?>">
										<div class="form-group row mb-2">
											<label class="col-md-2 col-form-label text-end" for="rolesid">Roles</label>
											<div class="col-md-5">
												<select style="width:100%" class='form-control select2' id='rolesid' name='rolesid' required>
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
										<div class="form-group row mb-2">
											<label class="col-md-2 col-form-label text-end" for="nama">Nama</label>
											<div class="col-md-5">
												<input type="text" id="nama" name="nama" class="form-control" placeholder="Nama" value="<?= $mdata->nama ?>" required>
												<?php if ($this->validation->getError('nama')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('nama'); ?>
													</div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group row mb-2">
											<label class="col-md-2 col-form-label text-end" for="email">Email</label>
											<div class="col-md-5">
												<input type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?= $mdata->email ?>" required>
												<?php if ($this->validation->getError('email')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('email'); ?>
													</div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group row mb-2">
											<label class="col-md-2 col-form-label text-end" for="username">Username</label>
											<div class="col-md-5">
												<input type="text" id="username" name="username" class="form-control" placeholder="Username" value="<?= $mdata->username ?>" readonly>
												<?php if ($this->validation->getError('username')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('username'); ?>
													</div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group row mb-2">
											<label class="col-md-2 col-form-label text-end" for="password">Password</label>
											<div class="col-md-5">
												<input type="password" id="password" name="password" class="form-control" placeholder="Password">
												<?php if ($this->validation->getError('password')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('password'); ?>
													</div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group row mb-2">
											<div class="offset-sm-2 col-sm-10">
												<button type="submit" id="btn-save" class="btn btn-md btn-primary btn-round">
													<i class="ace-icon fa fa-save"></i> Update
												</button>
												<button type="reset" class="btn btn-md btn-danger btn-round">
													<i class="ri-close-line align-bottom me-1"></i> Reset
												</button>
											</div>
										</div>
									</form>
								</div>
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
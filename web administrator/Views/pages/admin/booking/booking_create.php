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
				<?php echo view('partials/page-title', array('pagetitle' => 'Home', 'title' => 'Booking')); ?>
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-8">
							<div class="card">
								<form class="form-horizontal" method="post" action="<?php echo site_url('booking/create'); ?>" enctype="multipart/form-data">
									<div class="card-header mb-0 b-t-success border-2 align-items-center d-flex">
										<div class=" flex-grow-1">
											<h5 class="card-title mb-0">Booking</h5>
										</div>
										<div class="flex-shrink-0">
											<a href="<?= base_url('booking'); ?>" class="btn btn-light"><i class="ri-add-line align-middle"></i> Kembali</a>
										</div>
									</div>
									<div class="card-body">

										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="id_customer">Roles</label>
											<div class="col-md-9">
												<select style="width:100%" class="form-select" id="id_customer" data-choices name="id_customer" required>
													<option value="">Pilih Customer</option>
													<?php
													if ($customerdata->getNumRows() > 0) {
														foreach ($customerdata->getResult() as $row) {
															echo '<option value="' . $row->id . '">' . $row->nama_customer . '</option>';
														}
													}
													?>
												</select>
												<?php if ($this->validation->getError('id_customer')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('id_customer'); ?>
													</div>
												<?php } ?>
											</div>
										</div>

										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="id_room">Roles</label>
											<div class="col-md-9">
												<select style="width:100%" class="form-select" id="id_room" data-choices name="id_room" required>
													<option value="">Pilih Room</option>
													<?php
													if ($roomdata->getNumRows() > 0) {
														foreach ($roomdata->getResult() as $row) {
															echo '<option value="' . $row->id . '">' . $row->nama_room . '</option>';
														}
													}
													?>
												</select>
												<?php if ($this->validation->getError('id_room')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('id_room'); ?>
													</div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="start_date">Tanggal Mulai</label>
											<div class="col-md-9">
												<input type="date" id="start_date" name="start_date" class="form-control" placeholder="Tanggal Mulai" value="<?= old('start_date') ?>" required>
												<?php if ($this->validation->getError('start_date')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('start_date'); ?>
													</div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="end_date">Tanggal Selesai</label>
											<div class="col-md-9">
												<input type="date" id="end_date" name="end_date" class="form-control" placeholder="Tanggal Selesai" value="<?= old('end_date') ?>" required>
												<?php if ($this->validation->getError('end_date')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('end_date'); ?>
													</div>
												<?php } ?>
											</div>
										</div>

										<div class="form-group row mb-3">
											<label class="col-md-3 col-form-label" for="harga_bulanan">Harga Sewa Bulanan</label>
											<div class="col-md-9">
												<input type="number" id="harga_bulanan" name="harga_bulanan" class="form-control" placeholder="harga_bulanan" value="<?= old('harga_bulanan') ?>" required>
												<?php if ($this->validation->getError('harga_bulanan')) { ?>
													<div class='mt-2 input-error'>
														<?= $this->validation->getError('harga_bulanan'); ?>
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
<script>
	$('#id_room').change(function() {
		const id_room = $(this).val();
		if (id_room) {
			$.ajax({
				url: baseUrl + 'room/getroom',
				type: 'POST',
				data: {
					id: id_room
				},
				dataType: 'json',
				success: function(data) {
					if (data) {
						$('#harga_bulanan').val(data.harga_bulanan).prop('readonly', false);
					}
				}
			});
		}
	});
</script>

</html>
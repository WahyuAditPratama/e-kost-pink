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
				<?php echo view('partials/page-title', array('pagetitle' => 'Home', 'title' => 'Detail Invoice')); ?>
				<div class="container-fluid">
					<div class="card" id="print">
						<div class="card-body">


							<div class="mb-3">

								<table class="table table-bordered">


									<tr>
										<td>Tanggal </td>
										<td>:</td>
										<td><?= $booking->created_at; ?></td>

									</tr>

									<tr>
										<td>Nama Customer </td>
										<td>:</td>
										<td><?= $booking->nama_customer; ?></td>

									</tr>

									<tr>
										<td>Nama Kamar </td>
										<td>:</td>
										<td><?= $booking->nama_room; ?></td>

									</tr>

									<tr>
										<td>Tanggal Mulai </td>
										<td>:</td>
										<td><?= $booking->start_date; ?></td>

									</tr>

									<tr>
										<td>Tanggal_selesai </td>
										<td>:</td>
										<td><?= $booking->end_date; ?></td>

									</tr>

									<tr>
										<td>Harga Bulanan </td>
										<td>:</td>
										<td><?= number_format($booking->harga_bulanan); ?></td>

									</tr>
								</table>
							</div>

							<div class="order-history table-responsive wishlist">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th width="35%">No Invoice</th>
											<th>Bulan</th>
											<th>Tahun</th>
											<th>Tanggal Penagihan</th>
											<th>Nominal</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($booking->bulanan as $detail) { ?>
											<tr>
												<td class="total-amount text-start align-top">
													<?= $detail->no_invoice; ?>
												</td>
												<td class="total-amount text-start align-top">
													<?= $detail->bulan; ?>
												</td>
												<td class="total-amount text-start align-top">
													<?= $detail->tahun; ?>
												</td>
												<td class="total-amount text-start align-top">
													<?= $detail->due_date; ?>
												</td>
												<td class="total-amount text-start align-top">
													<?= $detail->nominal; ?>
												</td>
												<td class="total-amount text-start align-top">
													<?= $detail->status; ?>
												</td>
											</tr>


										<?php } ?>

										<tr>
											<td class="total-amount" colspan="5">
												<h6 class="m-0 text-end"><span class="f-w-600">Total Tagihan :</span></h6>
											</td>
											<td class="total-amount">
												<h6 class="m-0 text-end"><span class="f-w-600">Rp <?= number_format($booking->total); ?> </span></h6>
											</td>
										</tr>

									</tbody>
								</table>
							</div>



							<div class="col-lg-12 mt-3">
								<div class="card border-1 p-3 shadow-0">

									<div class="pb-0 align-items-center d-flex">
										<div class=" flex-grow-1">
											<h5 class="fw-bold">Satus Booking</h5>
											<p>status pesanan sewa kamar</p>
										</div>
										<div class="flex-shrink-0">
											<?php


											$bgstatus = "badge-warning";
											if ($booking->status == "draft") {
												$bgstatus = "badge-warning";
											} elseif ($booking->status == "konfrmasi") {
												$bgstatus = "badge-secondary";
											} elseif ($booking->status == "proses") {
												$bgstatus = "badge-secondary";
											} elseif ($booking->status == "aktif") {
												$bgstatus = "badge-primary";
											} elseif ($booking->status == "selesai") {
												$bgstatus = "badge-success";
											} elseif ($booking->status == "batal") {
												$bgstatus = "badge-danger";
											} else {
												$bgstatus = "badge-warning";
											}

											?>
											<span class="badge <?= $bgstatus; ?>">
												<p>Status : <?= $booking->status; ?></p>
											</span>

										</div>
									</div>
									<!-- <div class="row">
										<?php //if ($bookingpayment && $bookingpayment->payment_method == "cod") { 
										?>

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



										<?php //} elseif ($bookingpayment && $bookingpayment->payment_method == "transfer") { 
										?>



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
															
														</div>
													</div>
												</div>


												<div class="pb-0 align-items-center d-flex">
													<div class=" flex-grow-1">
														<p class="fw-bold">Bukti Bayar</p>

													</div>
													<div class="flex-shrink-0">
														<?php
														// $path = "public/uploads/bukti_bayar/";
														// $file_path = ROOTPATH . $path . $bookingpayment->bukti_bayar;
														// $bukti_bayar_url = base_url() . '/' . $path . $bookingpayment->bukti_bayar;

														// if (file_exists($file_path)) {
														// 	$pathfile = "<a href='" . $bukti_bayar_url . "' class='btn btn-sm btn-success' target='_blank'>Lihat Bukti Pembayaran</a>";
														// } else {
														// 	$pathfile = "<span class='badge bg-danger'>Tidak Ada File</span>";
														// }
														// echo $pathfile;
														?>
													</div>
												</div>
											</div>
										<?php //} 
										?>

									</div> -->
								</div>


							</div>


							<?php if ($booking->status == "proses") { ?>



								<div class="col-lg-12 mt-3">
									<div class="card border-1 p-3 shadow-0">

										<div class="pb-0 align-items-center d-flex">
											<div class=" flex-grow-1">
												<h5 class="fw-bold">Konfirmasi Booking</h5>
											</div>

										</div>
										<div class="row">
											<form method="post" action="<?php echo site_url('booking/konfirmasi'); ?>" enctype="multipart/form-data">

												<input type="hidden" name="id" value="<?= $booking->id; ?>">
												<div class="form-group row mb-3">
													<label class="col-md-3 col-form-label" for="status">Status Booking</label>
													<div class="col-md-9">
														<select name="status" class="form-select" required>
															<?php
															echo '<option>Pilih Status...</option>';
															$mst = [
																["name" => "aktif", "value" => "Terima"],
																["name" => "batal", "value" => "Tolak"]
															];
															foreach ($mst as $val) {
																echo '<option value="' . $val['name'] . '">' . $val['value'] . '</option>';
															}
															?>
														</select>
													</div>
												</div>

												<div class="form-group row mb-3">
													<label class="col-md-3 col-form-label" for="catatan">Catatan</label>
													<div class="col-md-9">
														<textarea type="catatan" id="catatan" name="catatan" class="form-control" placeholder="catatan" rows="5" required><?= old('catatan') ?></textarea>
														<?php if ($this->validation->getError('catatan')) { ?>
															<div class='mt-2 input-error'>
																<?= $this->validation->getError('catatan'); ?>
															</div>
														<?php } ?>
													</div>
												</div>
												<div class="text-end">
													<button type="submit" id="btn-save" class="btn btn-md btn-primary">
														<i class="ri-save-line"></i> Konfirmasi Pesanan
													</button>

												</div>
											</form>


										</div>
									</div>



								</div>

							<?php } ?>





							<?php if ($booking->status == "aktif") { ?>
								<div class="col-sm-12 text-end mt-3">
									<a class="btn btn-success cart-btn-transform" href="<?= site_url('booking/selesai/' . $booking->id . ''); ?>">Selesaikan Sewa</a>
									<a class="btn btn-primary cart-btn-transform" href="<?= site_url('pengguna/cetak_invoice/' . $booking->id . ''); ?>">Cetak Invoice</a>
								</div>
							<?php } ?>

							<?php if ($booking->status == "selesai") { ?>
								<div class="col-sm-12 text-end mt-3">
									<a class="btn btn-primary cart-btn-transform" href="<?= site_url('pengguna/cetak_invoice/' . $booking->id . ''); ?>">Cetak Invoice</a>
								</div>
							<?php } ?>
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
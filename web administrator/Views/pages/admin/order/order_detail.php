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
							<div class="table-responsive">
								<table id="datatable" class="table table-bordered dt-responsive table-striped align-top">
									<thead>
										<tr>
											<th>No Invoice</th>
											<th>Periode</th>
											<th>Tanggal Penagihan</th>
											<th>Nominal</th>
											<th>Metode Pembayaran</th>
											<th>Status</th>
											<th>Bukti Bayar</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($booking->bulanan as $detail) { ?>
											<tr>
												<td class="total-amount text-start align-top">
													<?= $detail->no_invoice; ?>
												</td>

												<td class="total-amount text-start align-top">
													<?= bulan($detail->bulan); ?> <?= $detail->tahun; ?>
												</td>
												<td class="total-amount text-start align-top">
													<?= $detail->due_date; ?>
												</td>
												<td class="total-amount text-start align-top">
													<?= number_format($detail->nominal); ?>
												</td>

												<td class="total-amount text-start align-top">
													<?= $detail->payment_method; ?>
												</td>
												<td class="total-amount text-start align-top">
													<?= $detail->status; ?>
												</td>
												<td class="total-amount text-start align-top">
													<?php
													$path = "public/uploads/bukti_bayar/";
													$file_path = ROOTPATH . $path . $detail->payment_proof;
													$payment_proof_url = base_url() . '/' . $path . $detail->payment_proof;

													if (file_exists($file_path) && $detail->payment_proof) {
														$pathfile = "<a href='" . $payment_proof_url . "' class='text-primary' target='_blank'>Lihat Bukti Pembayaran</a>";
													} else {
														$pathfile = "<span class='text-danger'>Tidak Ada File</span>";
													}
													echo $detail->payment_method === 'Cash' ? "Pembayaran Manual"  : $pathfile;
													?>
												</td>
												<td style="white-space: nowrap;" class="text-center align-top">
													<?php
													$due_date = new DateTime($detail->due_date);
													$current_date = new DateTime(); // Tanggal saat ini
													$is_overdue = $due_date < $current_date;
													?>

												<td style="white-space: nowrap;" class="text-center align-top">
													<?php if ($detail->status === 'proses') { ?>
														<a href="<?= base_url('order/konfirmasi/' . $detail->id); ?>" class="btn btn-sm btn-success" title="Konfirmasi">
															<i class="fa fa-check"></i>
														</a>
														<a href="<?= base_url('order/tolak/' . $detail->id); ?>" class="btn btn-sm btn-danger" title="Tolak">
															<i class="fa fa-times"></i>
														</a>
													<?php } elseif ($detail->status === 'lunas') { ?>
														<span class="text-success">Lunas</span>

													<?php } elseif ($is_overdue) { ?>
														<span class="text-danger">Overdue</span>
													<?php } elseif ($detail->status === 'pending') { ?>
														<span class="text-warning">Menunggu Pembayaran</span>
													<?php } else { ?>
														<span class="text-muted">Status: <?= $detail->status; ?></span>
													<?php } ?>
												</td>
												</td>
											</tr>
										<?php } ?>
										<tr>
											<td class="total-amount" colspan="7">
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
								</div>
							</div>
							<?php if ($booking->status == "aktif") { ?>
								<div class="col-sm-12 text-end mt-3">
									<a class="btn btn-success" href="<?= site_url('booking/selesai/' . $booking->id . ''); ?>">Selesaikan Sewa</a>
								</div>
							<?php } ?>
							<?php if ($booking->status == "selesai") { ?>
								<div class="col-sm-12 text-end mt-3">
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
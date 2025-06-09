<?= $this->include('partials/main') ?>

<head>
	<?php echo view('partials/title-meta', array('title' =>  $title)); ?>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
	<link href="<?= base_url(); ?>public/velzone/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
	<?= $this->include('partials/head-css') ?>
</head>

<body>
	<div id="layout-wrapper">
		<?= $this->include('partials/menu') ?>
		<div class="main-content">
			<div class="page-content">
				<div class="container-fluid">
					<?php echo view('partials/page-title', array('pagetitle' => 'Error', 'title' => 'Error 403')); ?>
					<div class="row">
						<div class="col-lg-12">
							<div class="card">
								<div class="card-header align-items-center d-flex">
									<h4 class="card-title mb-0 flex-grow-1">403</h4>
								</div>
								<div class="card-body">
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?= $this->include('partials/footer') ?>
		</div>
	</div>
	<?= $this->include('partials/customizer') ?>
	<?= $this->include('partials/vendor-scripts') ?>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
	<script src="<?= base_url(); ?>public/velzone/libs/sweetalert2/sweetalert2.min.js"></script>
	<script src="<?= base_url(); ?>public/velzone/js/pages/sweetalerts.init.js"></script>
	<script src="<?= base_url(); ?>public/velzone/libs/prismjs/prism.js"></script>
	<script src="<?= base_url(); ?>public/velzone/js/pages/notifications.init.js"></script>
	<script src="<?= base_url(); ?>public/velzone/js/app.js"></script>
</body>

</html>
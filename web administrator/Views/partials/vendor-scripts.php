<script src="<?= base_url() ?>/public/assets/js/jquery-3.5.1.min.js"></script>
<script src="<?= base_url() ?>/public/assets/js/icons/feather-icon/feather.min.js"></script>
<script src="<?= base_url() ?>/public/assets/js/icons/feather-icon/feather-icon.js"></script>
<script src="<?= base_url() ?>/public/assets/js/sidebar-menu.js"></script>
<script src="<?= base_url() ?>/public/assets/js/config.js"></script>
<script src="<?= base_url() ?>/public/assets/js/bootstrap/popper.min.js"></script>
<script src="<?= base_url() ?>/public/assets/js/bootstrap/bootstrap.min.js"></script>
<script src="<?= base_url() ?>/public/assets/js/script.js"></script>

<script>
	const baseUrl = "<?= base_url(); ?>";
	<?php if (session()->getFlashdata('info')) : ?>
		Swal.fire({
			title: 'Informasi !',
			text: '<?= session()->getFlashdata('info') ?>',
			icon: 'success',
			confirmButtonClass: 'btn btn-primary w-xs me-2 mt-2',
			buttonsStyling: false,
			showCloseButton: true
		})
	<?php endif; ?>
</script>
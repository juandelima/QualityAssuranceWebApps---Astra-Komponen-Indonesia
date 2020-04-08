<?php
	$this->simple_login->cek_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php $this->load->view('_partials/head.php'); ?>
	<style>
		.img-responsive {
			width: 100%;
		}
	</style>
</head>
<body class="page-body skin-facebook" data-url="http://neon.dev">
	<div class="page-container">
		<?php $this->load->view('_partials/navbar.php'); ?>
	
		<div class="main-content">
			<?php $this->load->view('_partials/navbar_head.php'); ?>
			<img class="img-responsive" src="<?php echo base_url('assets/images/coming_soon.jpg'); ?>">
			<?php $this->load->view('_partials/footer.php'); ?>
		</div>
		<?php $this->load->view('_partials/lists_chat.php'); ?>
	</div>
	<?php $this->load->view('_partials/js.php'); ?>
	<script src="<?php echo site_url('assets/js/chatting/chat.js'); ?>"></script>
	<?php $this->load->view('_partials/chatting'); ?>
</body>
</html>

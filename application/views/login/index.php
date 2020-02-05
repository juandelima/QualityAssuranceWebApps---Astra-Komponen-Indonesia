<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="SOBP Admin Panel" />
    <meta name="author" content="" />
    <link rel="icon" href="<?php echo base_url('assets/images/logo-QA.png'); ?>">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/skins/facebook.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/neon-core.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/neon-theme.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/neon-forms.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/custom.css">
    <script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.min.js"></script>
	<title>QUALITY ASSURANCE - PT.ASTRA KOMPONEN INDONESIA</title>
</head>
<body class="page-body login-page login-form-fall" data-url="http://neon.dev">

<!-- This is needed when you send requests via Ajax -->
<script type="text/javascript">
var baseurl = '';
</script>
<div class="login-container">
	<div class="login-header login-caret">
		<div class="login-content">
			<a class="logo">
				<img src="<?php echo base_url('assets/images/logo-QA.png'); ?>" width="200" alt="" />
			</a>
			<br>
			<h5 style="color:#FFFFFF">PT. ASTRA KOMPONEN INDONESIA</h5>
			<p class="description">Hallo admin, log in to access the dashboard</p>
			<!-- progress bar indicator -->
			<div class="login-progressbar-indicator">
				<h3>43%</h3>
				<span>logging in...</span>
			</div>
		</div>
	</div>

	<div class="login-progressbar">
		<div></div>
	</div>
	<div class="login-form">
		<div class="login-content">
			<div class="form-login-error">
				<h3>Invalid login</h3>
				<p>Enter <strong>demo</strong>/<strong>demo</strong> as login and password.</p>
			</div>
			<?php
				if($this->session->flashdata('warning')) {
			?>
					<script>
						jQuery(document).ready(function($) {
							var opts = {
								"closeButton": true,
								"debug": false,
								"positionClass": "toast-top-full-width",
								"onclick": null,
								"showDuration": "300",
								"hideDuration": "1000",
								"timeOut": "5000",
								"extendedTimeOut": "1000",
								"showEasing": "swing",
								"hideEasing": "linear",
								"showMethod": "fadeIn",
								"hideMethod": "fadeOut"
							};
				
							toastr.warning("<?php echo $this->session->flashdata('warning'); ?>", "SOMETHING WRONG!", opts);
						});
					</script>
			<?php
				}
			?>

			<?php
				if($this->session->flashdata('success')) {
			?>
					<script>
						jQuery(document).ready(function($) {
							var opts = {
								"closeButton": true,
								"debug": false,
								"positionClass": "toast-top-full-width",
								"onclick": null,
								"showDuration": "300",
								"hideDuration": "1000",
								"timeOut": "5000",
								"extendedTimeOut": "1000",
								"showEasing": "swing",
								"hideEasing": "linear",
								"showMethod": "fadeIn",
								"hideMethod": "fadeOut"
							};
				
							toastr.success("<?php echo $this->session->flashdata('success'); ?>", "SUCCESS", opts);
						});
					</script>
			<?php
				}
			?>

			<?php
				//form open login
				echo form_open(base_url('login'));
			?>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">
							<i class="entypo-user"></i>
						</div>
						<input type="text" class="form-control" name="username" id="username" placeholder="Username" autocomplete="off" />
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">
							<i class="entypo-key"></i>
						</div>
						<input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off" />
					</div>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block btn-primary">
						<i class="entypo-login"></i>
						Login In
					</button>
				</div>
			
			<?php echo form_close();?>
		</div>
	</div>
</div>
<!-- Imported styles on this page -->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/dropzone/dropzone.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/datatables/datatables.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/icheck/skins/minimal/_all.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/icheck/skins/square/_all.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/icheck/skins/flat/_all.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/icheck/skins/futurico/futurico.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/icheck/skins/polaris/polaris.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/select2/select2.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/font-icons/font-awesome/css/font-awesome.min.css">

<!-- Bottom scripts (common) -->
<script src="<?php echo base_url() ?>assets/js/gsap/TweenMax.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.js"></script>
<script src="<?php echo base_url() ?>assets/js/joinable.js"></script>
<script src="<?php echo base_url() ?>assets/js/resizeable.js"></script>
<script src="<?php echo base_url() ?>assets/js/neon-api.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/neon-login.js"></script>

<!-- Imported scripts on this page -->
<script src="<?php echo site_url('assets/js/toastr.js'); ?>"></script>
<script src="<?php echo base_url() ?>assets/js/fileinput.js"></script>
<script src="<?php echo base_url() ?>assets/js/dropzone/dropzone.js"></script>
<script src="<?php echo base_url() ?>assets/js/datatables/datatables.js"></script>
<script src="<?php echo base_url() ?>assets/js/select2/select2.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/typeahead.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.multi-select.js"></script>
<script src="<?php echo base_url() ?>assets/js/icheck/icheck.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/neon-chat.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap-switch.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url() ?>assets/js/ckeditor/adapters/jquery.js"></script>
</body>
</html>

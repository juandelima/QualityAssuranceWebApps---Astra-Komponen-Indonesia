<!-- Imported styles on this page -->
	<link rel="stylesheet" href="<?php echo base_url('assets/js/select2/select2-bootstrap.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/js/select2/select2.css'); ?>">
	<script src="<?php echo base_url('assets/js/jquery-ui.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/gsap/TweenMax.min.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/bootstrap.js'); ?>"></script>
	
	<script src="<?php echo site_url('assets/js/joinable.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/resizeable.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/neon-api.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>"></script>
	<script src="<?php echo site_url() ?>assets/js/dropzone/dropzone.js"></script>
	<script src="<?php echo site_url() ?>assets/js/fileinput.js"></script>
	<script src="<?php echo site_url() ?>assets/js/icheck/icheck.min.js"></script>

	<!-- Imported scripts on this page -->
	<script src="<?php echo site_url('assets/js/select2/select2.min.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/selectboxit/jquery.selectBoxIt.min.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/jquery.sparkline.min.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/rickshaw/vendor/d3.v3.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/rickshaw/rickshaw.min.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/raphael-min.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/morris.min.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/toastr.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/neon-chat.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/moment.min.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/bootstrap-datepicker.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/daterangepicker/daterangepicker.js'); ?>"></script>
	<!-- JavaScripts initializations and stuff -->
	<script src="<?php echo site_url('assets/js/neon-custom.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/activity/user_activity.js'); ?>"></script>

	<!-- Demo Settings -->
	<script src="<?php echo site_url('assets/js/neon-demo.js'); ?>"></script>
	<script>
		let base_url = "<?php echo base_url(); ?>";
		let count_aktivitas = <?php echo $count_aktivitas ?>;
		let id_user = <?php echo $this->session->userdata('id_users') ?>;
		let from_opponent = "<?php echo $this->session->userdata('full_name') ?>";
		user_activity(base_url, count_aktivitas, id_user);
	</script>

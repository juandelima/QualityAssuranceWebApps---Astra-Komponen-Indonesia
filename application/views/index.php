<?php
	$this->simple_login->cek_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php $this->load->view('_partials/head.php'); ?>
	<style>
		.select2-container .select2-choice {
			display: block!important;
			height: 30px!important;
			white-space: nowrap!important;
			line-height: 26px!important;
		}
		
		#container_year {
			margin: 0 auto;
			width: 100%;
		}

		#container_month {
			margin: 0 auto;
			width: 100%;
		}
	</style>
</head>
<body class="page-body skin-facebook" data-url="http://neon.dev">
	<div class="page-container">
		<?php
			if($this->session->flashdata('success')) {
		?>
			<script>
				jQuery(document).ready(function($) {
					var opts = {
						"closeButton": true,
						"debug": false,
						"positionClass": "toast-top-right",
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
			if($this->session->flashdata('error')) {
		?>
			<script>
				jQuery(document).ready(function($) {
					var opts = {
						"closeButton": true,
						"debug": false,
						"positionClass": "toast-top-right",
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
					toastr.error("<?php echo $this->session->flashdata('success'); ?>", "ERROR", opts);
				});
			</script>
		<?php
		}
		?>
		<?php $this->load->view('_partials/navbar.php'); ?>
	
		<div class="main-content">
		<?php $this->load->view('_partials/navbar_head.php'); ?>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary" id="charts_env">
						<div class="panel-body">
							<div class="tab-content">
								<div class="tab-pane active" id="ahm-chart">
									<div class="row">
										<div class="col-md-6">
											<div class="panel panel-primary">
												<div class="panel-heading">
													<div class="panel-title">Annual Rejection Graph</div>
													<div class="panel-options">
														<a href="#" data-rel="reload" id="reloading_year" class="loaded">
															<!-- <i class="entypo-arrows-ccw"></i> -->
														</a>
														<a href="#" data-rel="reload" id="reset_year" class="loaded">
															<i class="entypo-arrows-ccw"></i>
														</a>
													</div>
												</div>
												<div class="panel-body" id="body_annual_year">
													<form role="form" id="filter_year" class="form-horizontal form-groups-bordered">
														<div class="row">
															<div class="col-sm-6">
																<div class="form-group" id="year_list">
																	<label class="col-sm-2 control-label">From</label>
																	<div class="col-sm-10">
																		<select name="year_from" id="year_from" class="select2" data-allow-clear="true" data-placeholder="Select year...">
																			<option></option>
																			<?php
																				$firstYear = (int)date('Y') - 9;
																				$lastYear = $firstYear + 9;
																				for($i = $firstYear; $i <= $lastYear; $i++) { 
																			?>
																					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
																			<?php
																				}
																			?>
																		</select>
																	</div>
																</div>
															</div>

															<div class="col-sm-6">
																<div class="form-group" id="year_list">
																	<label class="col-sm-2 control-label">To</label>
																	<div class="col-sm-10">
																		<select name="year_to" id="year_to" class="select2" data-allow-clear="true" data-placeholder="Select year...">
																			<option></option>
																			<!-- <?php
																				$firstYear = (int)date('Y') - 9;
																				$lastYear = $firstYear + 9;
																				for($i = $firstYear; $i <= $lastYear; $i++) { 
																			?>
																					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
																			<?php
																				}
																			?> -->
																		</select>
																	</div>
																</div>
															</div>
														</div>
													</form>
													<div id="container_year"></div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="panel panel-primary">
												<div class="panel-heading">
													<div class="panel-title">Monthly Rejection Graph</div>
													<div class="panel-options">
														<a href="#" data-rel="reload" id="reloading_month" class="loaded">
															<!-- <i class="entypo-arrows-ccw"></i> -->
														</a>
														<a href="#" data-rel="reload" id="reset_month" class="loaded">
															<i class="entypo-arrows-ccw"></i>
														</a>
													</div>
												</div>
												<div class="panel-body" id="body_monthly">
													<form role="form" id="filter_month" class="form-horizontal form-groups-bordered">
														<div class="row">
															<div class="col-sm-6">
																<div class="form-group" id="year_list">
																	<label class="col-sm-2 control-label">Year</label>
																	<div class="col-sm-10">
																		<select name="year" id="year" class="select2" data-allow-clear="true" data-placeholder="Select year...">
																			<option></option>
																			<?php
																				$firstYear = (int)date('Y') - 9;
																				$lastYear = $firstYear + 9;
																				for($i = $firstYear; $i <= $lastYear; $i++) { 
																			?>
																					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
																			<?php
																				}
																			?>
																		</select>
																	</div>
																</div>
															</div>
														</div>
													</form>
													<div id="container_month"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="modal-error-ajax">
				<div class="modal-dialog" style="width: 50%;">
					<div class="modal-content">
						<div class="modal-body">						
							<div class="row">
								<div class="col-md-12">
									<div id="error_text"></div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
			<?php $this->load->view('_partials/footer.php'); ?>
		</div>
	</div>
	<?php $this->load->view('_partials/js.php'); ?>
	<script src="<?php echo site_url('assets/js/fusioncharts.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/fusioncharts.maps.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/fusioncharts.theme.fusion.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/fusioncharts.jqueryplugin.min.js'); ?>"></script>
	<?php $this->load->view('_partials/dashboard_chart.php'); ?>
</body>
</html>
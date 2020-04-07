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
		#chat, .chat-conversation, .sidebar-menu{
			z-index: 9999!important;
		}

		/* .daterangepicker {
			left: 800.903px!important;
		} */
	</style>
</head>
<body class="page-body skin-facebook" data-url="http://neon.dev">
	<div class="page-container sidebar-collapsed">
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
					toastr.error("<?php echo $this->session->flashdata('error'); ?>", "ERROR", opts);
				});
			</script>
		<?php
		}
		?>
		<?php $this->load->view('_partials/navbar.php'); ?>
	
		<div class="main-content">
		<?php $this->load->view('_partials/navbar_head.php'); ?>
			<div class="row">
				<div class="form-group" id="change_chart" style="margin-bottom: 50px;">
					<div class="col-sm-3">
						<select name="select_chart" id="select_chart" class="selectboxit" data-first-option="false">
							<option>select a chart...</option>
							<option value="3">Daily Chart</option>
							<option value="1">Annual & Monthly Chart</option>
							<option value="2">Parts & Defect Chart</option>
						</select>
					</div>
				</div>

				<div class="col-md-12" id="annual_monthly">
					<div class="panel panel-primary" id="charts_env">
						<div class="panel-body">
							<div class="row" style="margin-bottom: 15px;">
								<div class="col-sm-3">
									<form role="form" id="filter_status_claim" class="form-horizontal form-groups-bordered">
										<div class="form-group">
											<div class="col-sm-10">
												<select name="status_claim" id="status_claim1" class="selectboxit" data-first-option="false">
													<option>claim / tukar guling...</option>
													<option value="">All</option>
													<option value="Claim">Claim</option>
													<option value="Tukar Guling">Tukar Guling</option>
												</select>
											</div>
										</div>
									</form>
								</div>

								<div class="col-sm-3">
									<form role="form" id="filter_proses" class="form-horizontal form-groups-bordered">
										<div class="form-group">
											<div class="col-sm-10">
												<select name="proses" id="proses1" class="selectboxit" data-first-option="false">
													<option>proses...</option>
													<option value="" selected>Semua Proses</option>
													<?php foreach($proses as $data) { ?>
														<option value="<?php echo $data->proses; ?>"><?php echo $data->proses; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</form>
								</div>

								<div class="col-sm-3">
									<form role="form" id="filter_by_customer" class="form-horizontal form-groups-bordered">
										<div class="form-group">
											<div class="col-sm-10">
												<select name="by_customer" id="by_customer" class="selectboxit" data-first-option="false">
													<option>select customer...</option>
													<option value="">ALL</option>
													<?php 
														foreach($customer as $data) {
													?>
															<option value="<?php echo $data->id_customer; ?>"><?php echo $data->nama_customer; ?></option>
													<?php 
														}
													?>
												</select>
											</div>
										</div>	
									</form>
								</div>
							</div>
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
																<div class="form-group">
																	<label class="col-sm-2 control-label">From</label>
																	<div class="col-sm-10">
																		<input type="hidden" name="annual_proses" id="annual_proses">
																		<input type="hidden" name="annual_status_claim" id="annual_status_claim">
																		<input type="hidden" name="annual_customer" id="annual_customer">
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
																<div class="form-group">
																	<label class="col-sm-2 control-label">To</label>
																	<div class="col-sm-10">
																		<select name="year_to" id="year_to" class="select2" data-allow-clear="true" data-placeholder="Select year...">
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
																<div class="form-group">
																	<label class="col-sm-2 control-label">Year</label>
																	<div class="col-sm-10">
																	<input type="hidden" name="monthly_proses" id="monthly_proses">
																	<input type="hidden" name="monthly_customer" id="monthly_customer">
																	<input type="hidden" name="monthly_status_claim" id="monthly_status_claim">
																		<select name="year1" id="year1" class="select2" data-allow-clear="true" data-placeholder="Select year...">
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

				<div class="col-md-12" id="parts_defect">
					<div class="panel panel-primary" id="charts_defect">
						<div class="panel-body">
							<form role="form" id="filter_chart" class="form-horizontal form-groups-bordered">
								<input type="hidden" name="id_customer" id="id_customer" value=""/>
								<input type="hidden" name="part" id="part" value=""/>
								<div class="row" style="margin-bottom: 15px;">
									<div class="col-sm-2" id="choose_status">
										<div class="form-group">
											<div class="col-sm-10" style="text-align:left;">
												<select name="status_claim" id="status_claim" class="selectboxit" data-first-option="false">
													<option>claim / tukar guling...</option>
													<option value="" selected>All</option>
													<option value="Claim">Claim</option>
													<option value="Tukar Guling">Tukar Guling</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-2" id="choose_proses">
										<div class="form-group">
											<div class="col-sm-10" style="text-align:left;">
												<select name="proses" id="proses" class="selectboxit" data-first-option="false">
													<option>proses</option>
													<option value="" selected>Semua Proses</option>
													<?php foreach($proses as $data) { ?>
														<option value="<?php echo $data->proses; ?>"><?php echo $data->proses; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-2" id="choose_customer">
										<div class="form-group">
											<div class="col-sm-10" style="text-align:left;">
												<select name="ganti_customer" id="ganti_customer" class="select2" data-allow-clear="true" data-placeholder="Select a customer...">
													<option></option>
													<?php foreach($customer as $data) { ?>
															<option value="<?php echo $data->id_customer; ?>"><?php echo $data->nama_customer; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-2" id="year_list">
										<div class="form-group">
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
									<div class="col-sm-2" id="month_list">
										<div class="form-group">
											<div class="col-sm-10">
												<select name="month" id="month" class="select2" data-allow-clear="true" data-placeholder="Select month...">
													<option></option>
													<?php
														$months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", 
														"Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
														for($i = 0; $i < count($months); $i++) { 
													?>
															<option value="<?php echo $months[$i]; ?>-<?php echo date('Y'); ?>"><?php echo $months[$i]; ?></option>
													<?php
														}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-2" id="date_custome" style="display: none;">
										<div class="form-group">
											<label class="col-sm-2 control-label">Date</label>
											<div class="col-sm-10">
												<input type="hidden" name="start" id="start"/>
												<input type="hidden" name="end" id="end"/>
												<input type="text" id="date_ranges" class="form-control daterange"/>
											</div>
										</div>
									</div>
									<div class="col-sm-2" id="custome_range">
										<div class="form-group" style="margin-top: 5px;">
											<input type="checkbox" class="icheck" id="custom_date">
											<label for="minimal-checkbox-1">Custom Range</label>
										</div>
									</div>
								</div>
							</form>

							<div class="row">
								<div class="col-md-12">
									<ul class="nav nav-tabs">
										<li class="active">
											<a href="#chart_parts" data-toggle="tab">
												<span class="visible-xs"><i class="entypo-chart-line"></i></span>
												<span class="hidden-xs">Parts Chart</span>
											</a>
										</li>
										<li>
											<a href="#chart_rejections" data-toggle="tab">
												<span class="visible-xs"><i class="entypo-chart-bar"></i></span>
												<span class="hidden-xs">Defects Graph</span>
											</a>
										</li>
									</ul>

									<div class="tab-content">
										<div class="tab-pane active" id="chart_parts">
											<div class="panel panel-primary" id="chart_part" data-collapsed="0" style="margin-top: 25px;">
												<div class="panel-heading">
													<div class="panel-title">REJECTIONS PART CHART (QTY)</div>
													<div class="panel-options">
														<a href="#" id="part_chart" data-rel="collapse"><i class="entypo-down-open"></i></a>
														<a href="#" data-rel="reload" id="reloading_chart_part" class="loaded">
															<!-- <i class="entypo-arrows-ccw"></i> -->
														</a>
														<a href="#" data-rel="reload" id="reset_part" class="loaded">
															<i class="entypo-arrows-ccw"></i>
														</a>
													</div>
												</div>
												<div class="panel-body" id="body_chart_part">
													<div id="container_partChart"></div>
												</div>
											</div>
										</div>

										<div class="tab-pane" id="chart_rejections">
											<div class="panel panel-primary" data-collapsed="0" style="margin-top: 25px;">
												<div class="panel-heading">
													<div class="panel-title">DEFECTS CHART (QTY)</div>
													<div class="panel-options">
														<a href="#" id="part_chart" data-rel="collapse"><i class="entypo-down-open"></i></a>
														<a href="#" data-rel="reload" id="reloading" class="loaded">
															<!-- <i class="entypo-arrows-ccw"></i> -->
														</a>

														<a href="#" data-rel="reload" id="reset_rejection" class="loaded">
															<i class="entypo-arrows-ccw"></i>
														</a>
													</div>
												</div>
												<div class="panel-body" id="body_chart_rejection">
													<div class="col-sm-5" id="choose_part" style="margin-bottom: 10px;">
														<div class="form-group">
															<!-- <label class="col-sm-1 control-label" style="text-align:left;">Part</label> -->
															<div class="col-sm-10" style="text-align:left;">
																<select name="select_part" id="select_part" class="select2" data-allow-clear="true" data-placeholder="Select a part...">
																	<option></option>
																	<!-- <optgroup label="United States"> -->
																	<!-- <option value="">ALL PARTS</option> -->
																	<?php
																		foreach($select_part_distinct as $data) {
																	?>
																		<option value="<?php echo $data->nama_part; ?>"><?php echo $data->nama_part; ?></option>
																	<?php 
																		}
																	?>
																	</optgroup>
																</select>
															</div>
														</div>
													</div>
													<div id="container"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>														
				</div>

				<div class="col-md-12" id="daily">
					<div class="panel panel-primary" id="daily_chart">
						<div class="panel-body">
							<form role="form" id="filter_daily_chart" class="form-horizontal form-groups-bordered">
								<input type="hidden" id="d_year" name="daily_year">
								<input type="hidden" id="d_month" name="daily_month">
								<div class="row" style="margin-bottom: 15px;">
									<div class="col-sm-3" id="daily_choose_status">
										<div class="form-group">
											<div class="col-sm-10" style="text-align:left;">
												<select name="status_claim" id="daily_status_claim" class="selectboxit" data-first-option="false">
													<option>claim / tukar guling...</option>
													<option value="" selected>All</option>
													<option value="Claim">Claim</option>
													<option value="Tukar Guling">Tukar Guling</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-3" id="daily_choose_proses">
										<div class="form-group">
											<div class="col-sm-10" style="text-align:left;">
												<select name="proses" id="daily_proses" class="selectboxit" data-first-option="false">
													<option>proses</option>
													<option value="" selected>Semua Proses</option>
													<?php foreach($proses as $data) { ?>
														<option value="<?php echo $data->proses; ?>"><?php echo $data->proses; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-3" id="daily_choose_customer">
										<div class="form-group">
											<div class="col-sm-10" style="text-align:left;">
												<select name="ganti_customer" id="daily_ganti_customer" class="select2" data-allow-clear="true" data-placeholder="Select a customer...">
													<option></option>
													<?php foreach($customer as $data) { ?>
															<option value="<?php echo $data->id_customer; ?>"><?php echo $data->nama_customer; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>

									<div class="col-sm-3" id="daily_choose_part">
										<div class="form-group">
											<div class="col-sm-10" style="text-align:left;">
												<select name="ganti_part" id="daily_ganti_part" class="select2" data-allow-clear="true" data-placeholder="Select a part...">
													<option></option>
													<?php
														foreach($select_part_distinct as $data) {
													?>
														<option value="<?php echo $data->nama_part; ?>"><?php echo $data->nama_part; ?></option>
													<?php 
														}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
							</form>
							<div class="row">
								<div class="col-md-12">
									<div class="panel panel-primary">
										<div class="panel-heading">
											<div class="panel-title">Daily Chart</div>
											<div class="panel-options">
												<a href="#" data-rel="reload" id="reloading_daily" class="loaded">
													<!-- <i class="entypo-arrows-ccw"></i> -->
												</a>
												<a href="#" data-rel="reload" id="refresh_daily" class="loaded">
													<i class="entypo-arrows-ccw"></i>
												</a>
											</div>
										</div>

										<div class="panel-body" id="daily_body_chart">
											<div class="row" style="margin-bottom: 10px;">
												<div class="col-sm-4" id="year_daily_list">
													<div class="form-group">
														<div class="col-sm-10">
															<select name="year" id="year_daily" class="select2" data-allow-clear="true" data-placeholder="Select year...">
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
												<div class="col-sm-4" id="month_daily_list">
													<div class="form-group">
														<div class="col-sm-10">
															<select name="month" id="month_daily" class="select2" data-allow-clear="true" data-placeholder="Select month...">
																<option></option>
																<?php
																	$months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", 
																	"Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
																	for($i = 0; $i < count($months); $i++) { 
																?>
																		<option value="<?php echo $i+1; ?>"><?php echo $months[$i]; ?></option>
																<?php
																	}
																?>
															</select>
														</div>
													</div>
												</div>
											</div>
											<div id="daily_container"></div>
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
		<?php $this->load->view('_partials/lists_chat.php'); ?>
	</div>
	<?php $this->load->view('_partials/js.php'); ?>
	<link rel="stylesheet" href="<?php echo site_url('assets/js/daterangepicker/daterangepicker-bs3.css'); ?>">
	<script src="<?php echo site_url('assets/js/fusioncharts.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/fusioncharts.maps.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/fusioncharts.theme.fusion.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/fusioncharts.jqueryplugin.min.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/chart/change_chart.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/chart/daily_chart.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/chart/annual_monthly_chart.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/chart/detail_chart.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/chatting/chat.js'); ?>"></script>
	<?php $this->load->view('_partials/chatting'); ?>
	<?php $this->load->view('_partials/dashboard_chart.php'); ?>
</body>
</html>

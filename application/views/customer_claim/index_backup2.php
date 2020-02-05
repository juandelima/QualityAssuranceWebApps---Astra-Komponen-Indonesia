<?php
	$this->simple_login->cek_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php $this->load->view('_partials/head.php'); ?>
	<style>
		.col-sm-1 {
			width: 45px;
		}	
		.select2-container .select2-choice {
			display: block!important;
			height: 30px!important;
			white-space: nowrap!important;
			line-height: 26px!important;
		}
		#container {
			margin: 0 auto;
			width: 100%;
		}

		td.sorting_1 {
			text-align: center;
		}
		.raphael-group-cMNZkfEe {
			display: none!important;
		}
		.dataTables_wrapper.no-footer .dataTables_scrollBody {
    		border-bottom: 1px solid #fff;
		}
	</style>
</head>
<body class="page-body skin-facebook" data-url="http://neon.dev">
	<div class="page-container sidebar-collapsed">
		<?php $this->load->view('_partials/navbar.php'); ?>
			<div class="main-content">
				<?php $this->load->view('_partials/navbar_head.php'); ?>
				<?php
					if($this->session->flashdata('sukses')){
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
			
						toastr.success("<?php echo $this->session->flashdata('sukses'); ?>", "SUCCESS", opts);
					});
				</script>
				<?php
					}
				?>
				<?php
					if($this->session->flashdata('error')){
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
				<form role="form" id="filter_chart" class="form-horizontal form-groups-bordered">
					<div class="row" style="margin-bottom: 10px;">
						<?php if($this->session->userdata['role'] != 'User') { ?>
							<div class="col-sm-12">
								<a href="<?php echo base_url('claim/customerclaim/create_ahm'); ?>" class="btn btn-blue btn-icon btn-block">
									<i class="entypo-user-add"></i>
									ADD CUSTOMER CLAIM
								</a>
							</div>
						<?php } ?>
					</div>
					<div class="row">
						<div class="col-sm-4" id="choose_part">
							<div class="form-group">
								<label class="col-sm-1 control-label" style="text-align:left;">Part</label>
								<div class="col-sm-10" style="text-align:left;">
									<select name="part" id="part" class="select2" data-allow-clear="true" data-placeholder="Select one part...">
										<option></option>
										<!-- <optgroup label="United States"> -->
										<!-- <option value="">ALL PARTS</option> -->
										<?php
											foreach($customer_claim_dist as $data) {
										?>
											<option value="<?php echo $data->NAMA_PART; ?>"><?php echo $data->NAMA_PART; ?></option>
										<?php 
											}
										?>
										</optgroup>
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group" id="year_list">
								<label class="col-sm-2 control-label">Year</label>
								<div class="col-sm-10">
									<select name="year" id="year" class="select2" data-allow-clear="true" data-placeholder="Select year...">
										<option></option>
										<?php
											$firstYear = (int)date('Y') - 6;
											$lastYear = $firstYear + 6;
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
						<div class="col-sm-3">
							<div class="form-group" id="month_list">
								<label class="col-sm-2 control-label">Month</label>
								<div class="col-sm-10">
									<select name="month" id="month" class="select2" data-allow-clear="true" data-placeholder="Select month...">
										<option></option>
										<?php
											 $months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", 
											"Jul", "Aug", "Sep", "Okt", "Nov", "Dec"];
											for($i = 0; $i < count($months); $i++) { 
										?>
												<option value="<?php echo $months[$i]; ?>"><?php echo $months[$i]; ?></option>
										<?php
											}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-4" id="date_custome" style="display: none;">
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
						<div class="panel panel-primary" data-collapsed="0" style="margin-top: 25px;">
							<div class="panel-heading">
								<div class="panel-title">REJECTION GRAPH (QTY & PPM)</div>
								<div class="panel-options">
									<a href="#" data-rel="reload" id="reloading" class="loaded">
										<i class="entypo-arrows-ccw"></i>
									</a>
								</div>
							</div>
							<div class="panel-body">
								<div id="container"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 20px;">
					<div class="col-md-12">
						<table class="table table-bordered" id="table-1">
							<thead>
								<tr>
									<th width="1" style="text-align: center;">No</th>
									<th width="50" style="text-align: center;">Tgl</th>
									<th style="text-align: center;">No Surat Claim</th>
									<th style="text-align: center;">Nama Part</th>
									<th style="text-align: center;">Type</th>
									<th style="text-align: center;">Proses</th>
									<!-- <th width="10" style="text-align: center;">Rejection</th> -->
									<th width="50" style="text-align: center;">Due Date</th>
									<th width="200" style="text-align: center;">PICA</th>
									<th style="text-align: center;" width="40">Card</th>
									<!-- <th style="text-align: center;" width="40">Grafik</th> -->
								</tr>
							</thead>
							<tbody>
								<?php
									$no = 1;
									foreach($customer_claim as $data) {
										$date = strtotime($data->tgl_input);
										$card = $data->card;
										if($card == "Green Card") {
											$style_card = "background-color: #42b883; color: #ffffff";
										} elseif($card == "Red Card") {
											$style_card = "background-color: #ff0000; color: #ffffff";
										} elseif($card == "Yellow Card") {
											$style_card = "background-color: #ffd800; color: #222831";
										} else {
											$style_card = null;
										}

										$sum_rejection = $data->jml_qty_visual + $data->jml_qty_nonvisual;
										$overdue = date("Y-m-d", strtotime("+3 day", $date));
										$datenow = date("Y-m-d");
										if($datenow > $overdue) {
											if(!empty($data->ppt_file)) {
												$style = "background-color: #ffd800; color: #222831";
											} else {
												$style = "background-color: #ff0000; color: #ffffff";
											}
										} else {
											if(!empty($data->ppt_file)) {
												$style = "background-color: #42b883; color: #ffffff";
											} else {
												$style = "background-color: #ffffff; color: #222831";
											}
										}
								?>
								<tr>
									<td><?php echo $no++; ?></td>
									<td><?php echo date('d-m-Y', strtotime($data->tgl_input)); ?></td>
									<td><?php echo $data->no_surat_claim; ?></td>
									<td><?php echo $data->NAMA_PART; ?></td>
									<td><?php echo $data->TYPE; ?></td>
									<td><?php echo $data->PROSES; ?></td>
									
									<!-- <td style="text-align: center;">
										<a href="javascript:;" onclick="jQuery('#modal-data-non<?php echo $data->id_customer_claim; ?>').modal('show', {backdrop: 'static'});" class="popover-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="KLIK UNTUK MELIHAT DATA REJECTION <?php echo $data->NAMA_PART; ?>">
											<?php echo $sum_rejection; ?>
										</a>
									</td> -->
									<td style="<?php echo $style; ?>"><?php echo date('d-m-Y', strtotime($overdue)); ?></td>
									<td style="text-align: center;">
										<a href="javascript:;" onclick="jQuery('#modal-upload-ppt<?php echo $data->id_customer_claim; ?>').modal('show', {backdrop: 'static'});" class="btn btn-blue btn-icon icon-left">
												Upload
											<i class="entypo-upload"></i>
										</a>

									<a <?php if(empty($data->ppt_file)) { ?> disabled <?php } else { ?> href="<?php echo base_url('assets/claim_customer/ppt/'.$data->ppt_file)?>" <?php } ?>class="btn btn-success btn-icon icon-left" download="PART - <?php echo $data->NAMA_PART; ?>">
												Download
											<i class="entypo-download"></i>
										</a>
									</td>
									<td style="<?php echo $style_card; ?>"><?php echo $data->card; ?></td>
									<!-- <td style="text-align: center;">
										<a href="javascript:;" onclick="jQuery('#charts<?php echo $data->id_customer_claim; ?>').modal('show', {backdrop: 'static'});" class="btn btn-danger btn-icon icon-left popover-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="KLIK UNTUK MELIHAT GRAFIK REJECTION <?php echo $data->NAMA_PART; ?>">
												Grafik
											<i class="entypo-chart-line"></i>
										</a>
									</td> -->
								</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>
					<?php
						$index = 0;
						foreach($customer_claim as $data) {
							$id = $data->id_customer_claim;
					?>
					<div class="modal fade" id="modal-data-non<?php echo $data->id_customer_claim; ?>">
						<div class="modal-dialog" style="width: 50%;">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title">Rejection <?php echo $data->NAMA_PART; ?></h4>
								</div>
										
								<div class="modal-body">
									<div class="panel panel-default panel-shadow" data-collapsed="1">
										<div class="panel-heading">
											<div class="panel-title">Visual</div>
											<div class="panel-options">
												<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
											</div>
										</div>
										<div class="panel-body">
											<div class="row" id="spinners">
												<div class="col-md-12">
													<div class="form-group">
													<table class="table table-bordered" id="rejections<?php echo $data->id_customer_claim; ?>">
													<thead>
														<tr>
															<th style="text-align: center; width: 1%;">NO</th>
															<th style="text-align: center;">REJECTION</th>
															<th style="text-align: center; width: 4%;">QTY</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$limit_visual = count($show_visual[$index][$id]) / 2;
															$read_visual = 0;
															$no = 1;
															$qty = 0;
															for($i = 0; $i < $limit_visual; $i++) {
														?>
																<tr>
																	<td style="text-align: center;"><?php echo $no++; ?></td>
																	<td><?php echo $show_visual[$index][$id][$read_visual]; ?></td>
																	<td style="text-align: center;"><?php echo $show_visual[$index][$id][$read_visual + 1]; ?></td>
																	<?php $qty += $show_visual[$index][$id][$read_visual + 1]; ?>
																</tr>
														<?php
																$read_visual += 2;
															}
														?>
													</tbody>
													<tbody>
														<tr>
															<td colspan="2" style="text-align: right"><b>Jumlah Qty</b></td>
															<td style="text-align: center;"><?php echo $qty; ?></td>
														</tr> 
													</tbody>
												 </table> 
													</div>  
												</div>  
											</div>
										</div>
									</div>
									
									
									<div class="panel panel-default panel-shadow" data-collapsed="1">
										<div class="panel-heading">
											<div class="panel-title">Non Visual</div>
											<div class="panel-options">
												<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
											</div>
										</div>
										<div class="panel-body">
											<div class="row" id="spinners">
												<div class="col-md-12">
													<div class="form-group">
														<table class="table table-bordered" id="non<?php echo $data->id_customer_claim; ?>">
															<thead>
																<tr>
																	<th style="text-align: center; width: 1%;">NO</th>
																	<th style="text-align: center;">REJECTION</th>
																	<th style="text-align: center; width: 4%;">QTY</th>
																</tr>
															</thead>
															<tbody>
																<?php
																	$limit_non_visual = count($show_non_visual[$index][$id]) / 2;
																	$read_non_visual = 0;
																	$no = 1;
																	$qty = 0;
																	for($i = 0; $i < $limit_non_visual; $i++) {
																?>
																		<tr>
																			<td style="text-align: center;"><?php echo $no++; ?></td>
																			<td><?php echo $show_non_visual[$index][$id][$read_non_visual]; ?></td>
																			<td style="text-align: center;"><?php echo $show_non_visual[$index][$id][$read_non_visual + 1]; ?></td>
																			<?php $qty += $show_non_visual[$index][$id][$read_non_visual + 1]; ?>
																		</tr>
																<?php
																		$read_non_visual += 2;
																	}
																?>
															</tbody>
															<tbody>
																<tr>
																	<td colspan="2" style="text-align: right"><b>Jumlah Qty</b></td>
																	<td style="text-align: center;"><?php echo $qty; ?></td>
																</tr> 
															</tbody>
														</table> 
													</div>  
												</div>  
											</div>
										</div>
									</div>  
								</div> 
							</div> 
						</div>
					</div>

					<div class="modal fade" id="modal-upload-ppt<?php echo $data->id_customer_claim; ?>">
						<div class="modal-dialog" style="width: 50%;">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title">Upload PPT File</h4>
								</div>
								<form role="form" class="form-horizontal" enctype="multipart/form-data" action="<?php echo base_url('claim/powerpoint/upload_ppt/'.$data->id_customer_claim); ?>" method="POST">
								<div class="modal-body">
									<div class="row" id="spinners">
										<div class="col-md-12">
											<div class="form-group">
												<label class="col-sm-3 control-label">File PPT</label>
												<div class="col-sm-5">
													<input type="file" name="ppt_file" accept="*" class="form-control file2 inline btn btn-primary" required data-label="<i class='glyphicon glyphicon-file'></i> Browse" />
												</div>
											</div>
										</div>  
									</div>  
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
									<button type="submit" class="btn btn-primary">Upload</button>
								</div>
								</form>
							</div> 
						</div>
					</div>
					<div class="modal fade" id="charts<?php echo $data->id_customer_claim; ?>">
						<div class="modal-dialog" style="width: 90%;">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title">GRAFIK REJECTION <?php echo $data->NAMA_PART; ?></h4>
								</div>

								<div class="modal-body">						
									<div class="row">
										<div class="col-md-12">
											<div id="container<?php echo $id; ?>"></div>
										</div>
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
					<?php
						$index++;
					    }
					?>
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
	<link rel="stylesheet" href="<?php echo site_url('assets/js/daterangepicker/daterangepicker-bs3.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('assets/js/icheck/skins/minimal/_all.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('assets/js/icheck/skins/square/_all.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('assets/js/icheck/skins/flat/_all.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('assets/js/icheck/skins/futurico/futurico.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('assets/js/icheck/skins/polaris/polaris.css'); ?>">
	<?php $this->load->view('_partials/js.php'); ?>
	<script src="<?php echo site_url('assets/js/icheck/icheck.min.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/data.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/fusioncharts.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/fusioncharts.theme.fusion.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/fusioncharts.jqueryplugin.min.js'); ?>"></script>
	<!-- <script type="text/javascript" src="https://rawgit.com/fusioncharts/fusioncharts-jquery-plugin/develop/dist/fusioncharts.jqueryplugin.min.js"></script> -->
	<script>
		
		jQuery( document ).ready(function($) {
			$("#filter_chart :checkbox").change(function() {
				if ($(this).is(':checked')) {
					$("#year_list").css("display", "none");
					$("#month_list").css("display", "none");
					$("#date_custome").css("display", "block");
				} else {
					$("#year_list").css("display", "block");
					$("#month_list").css("display", "block");
					$("#date_custome").css("display", "none");
				}
			});
			
			$('#table-1').DataTable({
				"oLanguage": {
					"sSearch": "Search:",
					"oPaginate": {
						"sPrevious": "Previous",
						"sNext": "Next"
					}
				},
				"pageLength": 10,
				"lengthChange": true,
				"scrollX": false
			});
			<?php
				foreach($customer_claim as $data) {
			?>
			$('#rejections<?php echo $data->id_customer_claim; ?>').DataTable({
				"oLanguage": {
					"sSearch": "Search:",
					"oPaginate": {
						"sPrevious": "Previous",
						"sNext": "Next"
					}
				},
				"pageLength": 5,
				"lengthChange": false
			});

			$('#non<?php echo $data->id_customer_claim; ?>').DataTable({
				"oLanguage": {
					"sSearch": "Search:",
					"oPaginate": {
						"sPrevious": "Previous",
						"sNext": "Next"
					}
				},
				"pageLength": 5,
				"lengthChange": false
			});
			<?php
				}
			?>

			$("#filter_chart").on('change', 'select#part', function(e) {
				let part = $(e.target).val();
				let date_range = $("#date_ranges").val();
				const months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", 
				"Jul", "Aug", "Sep", "Okt", "Nov", "Dec"];
				let year = $("#year").val();
				let month = $("#month").val();
				let start = $("[name=daterangepicker_start]").val();
				let end = $("[name=daterangepicker_end]").val();
				let start_date = new Date(start);
				let end_date = new Date(end);
				let formart_start = start_date.getDate()+" "+months[start_date.getMonth()]+" "+start_date.getFullYear();
				let formart_end = end_date.getDate()+" "+months[end_date.getMonth()]+" "+end_date.getFullYear();
				let caption;
				if(part == "") {
					part = "ALL PARTS";
				}

				if(date_range != "") {
					if(year != "" && month != "") { 
						$("#start").val("");
						$("#end").val("");
						caption = year+" - "+month;
					} else if(year != "") {
						$("#start").val("");
						$("#end").val("");
						caption = year;
					} else if(month != "") {
						$("#start").val("");
						$("#end").val("");
						caption = month;
					} else {
						caption = caption = formart_start+" - "+formart_end;
					}
				} else {
					if(year != "" && month != "") { 
						caption = year+" - "+month;
					} else if(year != "") {
						caption = year;
					} else if(month != "") {
						caption = month;
					} else {
						caption = "<?php echo date("d M Y", strtotime($start)).' - '.date("d M Y", strtotime($end)); ?>";
					}
					
				}
				// console.log(caption);
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('claim/customerclaim/filter_chart'); ?>",
					data: $("#filter_chart").serialize(),
					dataType: "JSON",
					cache: false,
					beforeSend: function(data_filter) {
						$("#reloading").trigger('click');
					},
					success: function(data_filter) {
						console.log(data_filter);
						FusionCharts.ready(function() {
							const chartData = [];
							const chartValue = [];
							const chartPpm = [];
							let obj = data_filter;
							for(let key in obj) {
								let defect = parseInt(obj[key]);
								let tot_rejection = 0;
								if(obj[key] > 0) {
									for(let key2 in obj) {
										tot_rejection = parseInt(tot_rejection) + parseInt(obj[key2]);
									}
									let dataLabel = {
										"label": key,
									}
									let dataValue = {
										"value": obj[key],	
									}
									let ppm = (defect / parseInt(tot_rejection)) * 1000000;
									let dataPpm = {
										"value": ppm,
									}
									chartData.push(dataLabel);
									chartValue.push(dataValue);
									chartPpm.push(dataPpm);
								}
							}

							console.log(chartData.length);
							let label;
							if(chartData.length > 10) {
								label = "rotate";
							} else {
								label = "wrap";
							}
							var revenueChart = new FusionCharts({
								type: 'mscombidy2d',
								renderAt: 'container',
								width: '100%',
								height: '480',
								dataFormat: 'json',
								dataSource: {
								"chart": {
									"caption": "REJECTION "+part+" - QTY & PPM (AHM)",
									"subCaption": caption,
									"xAxisname": "Rejection Name",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"labelDisplay": label
								},
								"categories": [{
									"category": chartData
								}],
								"dataset": [{
									"seriesName": "Rejection",
									"showValues": "0",
									"numberSuffix": "",
									"data": chartValue
								}, {
									"seriesName": "PPM",
									"parentYAxis": "S",
									"renderAs": "line",
									"data": chartPpm
								}]
								}
							}).render();
						});
					},
					error: function(jqXHR, textStatus, errorThrown) {
						$("#error_text").text(textStatus +" "+errorThrown);
						$("#modal-error-ajax").show();
					}
				});
				
			});

			$("#filter_chart").on('change', 'select#year', function(e) {
				let part = $("#part").val();
				let year = $(e.target).val();
				let month = $("#month").val();
				let date_range = $("#date_ranges").val();
				if(part == "") {
					part = "ALL PARTS";
				}

				if(date_range != "") {
					$("#start").val(null);
					$("#end").val(null);
					$("#date_ranges").val(null);
					if(year != "" && month != "") { 
						caption = year+" - "+month;
					} else if(year != "") {
						caption = year;
					} else if(month != "") {
						caption = month;
					} else {
						caption = caption = formart_start+" - "+formart_end;
					}
				} else {
					if(year != "" && month != "") { 
						caption = year+" - "+month;
					} else if(year != "") {
						caption = year;
					} else if(month != "") {
						caption = month;
					} else {
						caption = "<?php echo date("d M Y", strtotime($start)).' - '.date("d M Y", strtotime($end)); ?>";
					}
				}
				// console.log(caption);
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('claim/customerclaim/filter_chart'); ?>",
					data: $("#filter_chart").serialize(),
					dataType: "JSON",
					cache: false,
					beforeSend: function(data_filter) {
						$("#reloading").trigger('click');
					},
					success: function(data_filter) {
						console.log(data_filter);
						FusionCharts.ready(function() {
							const chartData = [];
							const chartValue = [];
							const chartPpm = [];
							let obj = data_filter;
							for(let key in obj) {
								let defect = parseInt(obj[key]);
								let tot_rejection = 0;
								if(obj[key] > 0) {
									for(let key2 in obj) {
										tot_rejection = parseInt(tot_rejection) + parseInt(obj[key2]);
									}
									let dataLabel = {
										"label": key,
									}
									let dataValue = {
										"value": obj[key],	
									}
									let ppm = (defect / parseInt(tot_rejection)) * 1000000;
									let dataPpm = {
										"value": ppm,
									}
									chartData.push(dataLabel);
									chartValue.push(dataValue);
									chartPpm.push(dataPpm);
								}
							}

							console.log(chartData.length);
							let label;
							if(chartData.length > 10) {
								label = "rotate";
							} else {
								label = "wrap";
							}
							var revenueChart = new FusionCharts({
								type: 'mscombidy2d',
								renderAt: 'container',
								width: '100%',
								height: '480',
								dataFormat: 'json',
								dataSource: {
								"chart": {
									"caption": "REJECTION "+part+" - QTY & PPM (AHM)",
									"subCaption": caption,
									"xAxisname": "Rejection Name",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"labelDisplay": label
								},
								"categories": [{
									"category": chartData
								}],
								"dataset": [{
									"seriesName": "Rejection",
									"showValues": "0",
									"numberSuffix": "",
									"data": chartValue
								}, {
									"seriesName": "PPM",
									"parentYAxis": "S",
									"renderAs": "line",
									"data": chartPpm
								}]
								}
							}).render();
						});
					},
					error: function(jqXHR, textStatus, errorThrown) {
						$("#error_text").text(textStatus +" "+errorThrown);
						$("#modal-error-ajax").show();
					}
				});
			});

			$("#filter_chart").on('change', 'select#month', function(e) {
				let part = $("#part").val();
				let year = $("#year").val();
				let month = $(e.target).val();
				let date_range = $("#date_ranges").val();
				if(part == "") {
					part = "ALL PARTS";
				}
				if(date_range != "") {
					$("#start").val(null);
					$("#end").val(null);
					$("#date_ranges").val(null);
					// $("#date_ranges").attr("value", null);
					// $("#start").attr("value", null);
					// $("#end").attr("value", null);
					if(year != "" && month != "") { 
						caption = year+" - "+month;
					} else if(year != "") {
						caption = year;
					} else if(month != "") {
						caption = month;
					} else {
						caption = caption = formart_start+" - "+formart_end;
					}
				} else {
					if(year != "" && month != "") { 
						caption = year+" - "+month;
					} else if(year != "") {
						caption = year;
					} else if(month != "") {
						caption = month;
					} else {
						caption = "<?php echo date("d M Y", strtotime($start)).' - '.date("d M Y", strtotime($end)); ?>";
					}
				}
				// console.log(caption);
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('claim/customerclaim/filter_chart'); ?>",
					data: $("#filter_chart").serialize(),
					dataType: "JSON",
					cache: false,
					beforeSend: function(data_filter) {
						$("#reloading").trigger('click');
					},
					success: function(data_filter) {
						console.log(data_filter);
						FusionCharts.ready(function() {
							const chartData = [];
							const chartValue = [];
							const chartPpm = [];
							let obj = data_filter;
							for(let key in obj) {
								let defect = parseInt(obj[key]);
								let tot_rejection = 0;
								if(obj[key] > 0) {
									for(let key2 in obj) {
										tot_rejection = parseInt(tot_rejection) + parseInt(obj[key2]);
									}
									let dataLabel = {
										"label": key,
									}
									let dataValue = {
										"value": obj[key],	
									}
									let ppm = (defect / parseInt(tot_rejection)) * 1000000;
									let dataPpm = {
										"value": ppm,
									}
									chartData.push(dataLabel);
									chartValue.push(dataValue);
									chartPpm.push(dataPpm);
								}
							}

							console.log(chartData.length);
							let label;
							if(chartData.length > 10) {
								label = "rotate";
							} else {
								label = "wrap";
							}
							var revenueChart = new FusionCharts({
								type: 'mscombidy2d',
								renderAt: 'container',
								width: '100%',
								height: '480',
								dataFormat: 'json',
								dataSource: {
								"chart": {
									"caption": "REJECTION "+part+" - QTY & PPM (AHM)",
									"subCaption": caption,
									"xAxisname": "Rejection Name",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"labelDisplay": label
								},
								"categories": [{
									"category": chartData
								}],
								"dataset": [{
									"seriesName": "Rejection",
									"showValues": "0",
									"numberSuffix": "",
									"data": chartValue
								}, {
									"seriesName": "PPM",
									"parentYAxis": "S",
									"renderAs": "line",
									"data": chartPpm
								}]
								}
							}).render();
						});
					},
					error: function(jqXHR, textStatus, errorThrown) {
						$("#error_text").text(textStatus +" "+errorThrown);
						$("#modal-error-ajax").show();
					}
				});
			});

			$(".applyBtn").click(function() {
				$("#year").val(null);
				$("#month").val(null);
				var part = $("#part").val();
				$("select option[value='"+part+"']").attr("selected","selected");
				if(part == "") {
					part = "ALL PARTS";
				}
				const months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", 
				"Jul", "Aug", "Sep", "Okt", "Nov", "Dec"];
				var start = $("[name=daterangepicker_start]").val();
				var end = $("[name=daterangepicker_end]").val();
				var start_date = new Date(start);
				var end_date = new Date(end);
				var formart_start = start_date.getDate()+" "+months[start_date.getMonth()]+" "+start_date.getFullYear();
				var formart_end = end_date.getDate()+" "+months[end_date.getMonth()]+" "+end_date.getFullYear();
				$("#start").attr("value", start);
				$("#end").attr("value", end);
				console.log(part);
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('claim/customerclaim/filter_chart'); ?>",
					data: $("#filter_chart").serialize(),
					dataType: "JSON",
					cache: false,
					beforeSend: function(data_filter) {
						$("#reloading").trigger('click');
					},
					success: function(data_filter) {
						FusionCharts.ready(function() {
							const chartData = [];
							const chartValue = [];
							const chartPpm = [];
							let obj = data_filter;
							for(let key in obj) {
								let defect = parseInt(obj[key]);
								let tot_rejection = 0;
								if(obj[key] > 0) {
									for(let key2 in obj) {
										tot_rejection = parseInt(tot_rejection) + parseInt(obj[key2]);
									}
									let dataLabel = {
										"label": key,
									}
									let dataValue = {
										"value": obj[key],	
									}
									let ppm = (defect / parseInt(tot_rejection)) * 1000000;
									let dataPpm = {
										"value": ppm,
									}
									chartData.push(dataLabel);
									chartValue.push(dataValue);
									chartPpm.push(dataPpm);
								}
							}

							console.log(chartData.length);
							let label;
							if(chartData.length > 10) {
								label = "rotate";
							} else {
								label = "wrap";
							}
							var revenueChart = new FusionCharts({
								type: 'mscombidy2d',
								renderAt: 'container',
								width: '100%',
								height: '480',
								dataFormat: 'json',
								dataSource: {
								"chart": {
									"caption": "REJECTION "+part+" - QTY & PPM (AHM)",
									"subCaption": formart_start+" - "+formart_end,
									"xAxisname": "Rejection Name",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"labelDisplay": label
								},
								"categories": [{
									"category": chartData
								}],
								"dataset": [{
									"seriesName": "Rejection",
									"showValues": "0",
									"numberSuffix": "",
									"data": chartValue
								}, {
									"seriesName": "PPM",
									"parentYAxis": "S",
									"renderAs": "line",
									"data": chartPpm
								}]
								}
							}).render();
						});
					}
				});
			});


			$("#reloading").click(function() {
				FusionCharts.ready(function() {
					const chartData = [];
					const chartValue = [];
					const chartPpm = [];
					let dataChart = <?php echo $dataChart; ?>;
					let obj = dataChart;
					for(let key in obj) {
						let defect = parseInt(obj[key]);
						let tot_rejection = 0;
						if(obj[key] > 0) {
							for(let key2 in obj) {
								tot_rejection = parseInt(tot_rejection) + parseInt(obj[key2]);
							}
							let dataLabel = {
								"label": key,
							}
							let dataValue = {
								"value": obj[key],	
							}
							let ppm = (defect / parseInt(tot_rejection)) * 1000000;
							let dataPpm = {
								"value": ppm,
							}
							chartData.push(dataLabel);
							chartValue.push(dataValue);
							chartPpm.push(dataPpm);
						}
					}
					var revenueChart = new FusionCharts({
						type: 'mscombidy2d',
						renderAt: 'container',
						width: '100%',
						height: '480',
						dataFormat: 'json',
						dataSource: {
						"chart": {
							"caption": "ALL REJECTIONS - QTY & PPM",
							"subCaption": "<?php echo date("d M Y", strtotime($start)).' - '.date("d M Y", strtotime($end)); ?>",
							"xAxisname": "Rejection Name",
							"pYAxisName": "QTY",
							"sYAxisName": "PPM",
							"numberPrefix": "",
							"theme": "fusion",
							"showValues": "0",
							"labelDisplay": "rotate"
						},
						"categories": [{
							"category": chartData
						}],
						"dataset": [{
							"seriesName": "Rejection",
							"showValues": "0",
							"numberSuffix": "",
							"data": chartValue
						}, {
							"seriesName": "PPM",
							"parentYAxis": "S",
							"renderAs": "line",
							"data": chartPpm
						}]
						}
					}).render();
				});
				// console.log(chartData);
			});
			FusionCharts.ready(function() {
				const chartData = [];
				const chartValue = [];
				const chartPpm = [];
				let dataChart = <?php echo $dataChart; ?>;
				let obj = dataChart;
				for(let key in obj) {
					let defect = parseInt(obj[key]);
					let tot_rejection = 0;
					if(obj[key] > 0) {
						for(let key2 in obj) {
							tot_rejection = parseInt(tot_rejection) + parseInt(obj[key2]);
						}
						let dataLabel = {
							"label": key,
						}
						let dataValue = {
							"value": obj[key],	
						}
						let ppm = (defect / parseInt(tot_rejection)) * 1000000;
						let dataPpm = {
							"value": ppm,
						}
						chartData.push(dataLabel);
						chartValue.push(dataValue);
						chartPpm.push(dataPpm);
					}
				}
				var revenueChart = new FusionCharts({
					type: 'mscombidy2d',
					renderAt: 'container',
					width: '100%',
					height: '480',
					dataFormat: 'json',
					dataSource: {
					"chart": {
						"caption": "ALL REJECTIONS - QTY & PPM",
						"subCaption": "<?php echo date("d M Y", strtotime($start)).' - '.date("d M Y", strtotime($end)); ?>",
						"xAxisname": "Rejection Name",
						"pYAxisName": "QTY",
						"sYAxisName": "PPM",
						"numberPrefix": "",
						"theme": "fusion",
						"showValues": "0",
						"labelDisplay": "rotate"
					},
					"categories": [{
						"category": chartData
					}],
					"dataset": [{
						"seriesName": "Rejection",
						"showValues": "0",
						"numberSuffix": "",
						"data": chartValue
					}, {
						"seriesName": "PPM",
						"parentYAxis": "S",
						"renderAs": "line",
						"data": chartPpm
					}]
					}
				}).render();
			});
			<?php
				foreach($customer_claim as $data) {
					$id = $data->id_customer_claim;
			?>
					const chartData<?php echo $id;?> = [];
					let dataChart<?php echo $id; ?> = '<?php echo json_encode($chartByPart[$id]); ?>';
					let obj<?php echo $id; ?> = JSON.parse(dataChart<?php echo $id; ?>);
					for(let key in obj<?php echo $id; ?>) {
						if(obj<?php echo $id; ?>[key] > 0) {
							let data = {
								label: key,
								value: obj<?php echo $id; ?>[key],
							}
							chartData<?php echo $id;?>.push(data);
						}
					}
					//STEP 3 - Chart Configurations
					const chartConfigs<?php echo $id; ?> = {
						type: "column2d",
						width: "100%",
						height: "480",
						dataFormat: "json",
						dataSource: {
							// Chart Configuration
							"chart": {
								"caption": "REJECTION <?php echo $data->NAMA_PART; ?>",
								"subCaption": "",
								"xAxisName": "Rejection Name",
								"yAxisName": "Qty",
								"showValues": "1",
								"numberSuffix": "",
								"theme": "fusion",
								"exportenabled": "1",
							},
							// Chart Data
							"data": chartData<?php echo $id;?>
						}
					}
					$("#container<?php echo $id; ?>").insertFusionCharts(chartConfigs<?php echo $id; ?>);	
			<?php
				}
			?>
		});
	</script>
</body>
</html>

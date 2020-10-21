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
				<?php if($this->session->userdata['role'] != 'User') { ?>
				<div class="pull-right" style="margin-bottom: 20px;">
					<a href="<?php echo base_url('claim/customerclaim/create'); ?>" class="btn btn-blue btn-icon">
						Add Customer Claim
						<i class="entypo-user-add"></i>
					</a>
				</div>
				<?php } ?>
				<div class="row">
					<div class="col-md-12">
						<div id="container"></div>
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
									<th width="10" style="text-align: center;">Rejection</th>
									<th width="50" style="text-align: center;">Due Date</th>
									<th width="200" style="text-align: center;">PICA</th>
									<th style="text-align: center;" width="40">Card</th>
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
									
									<td style="text-align: center;">
										<a href="javascript:;" onclick="jQuery('#modal-data-non<?php echo $data->id_customer_claim; ?>').modal('show', {backdrop: 'static'});" class="popover-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="KLIK UNTUK MELIHAT DATA REJECTION <?php echo $data->NAMA_PART; ?>">
											<?php echo $sum_rejection; ?>
										</a>
									</td>
									
									
									<td style="text-align: center;">
										<a href="javascript:;" onclick="jQuery('#modal-upload-ppt<?php echo $data->id_customer_claim; ?>').modal('show', {backdrop: 'static'});" class="btn btn-blue btn-icon icon-left">
												Upload
											<i class="entypo-upload"></i>
										</a>
										<?php 
										
										?>
										<a <?php if(empty($data->ppt_file)) { ?> disabled <?php } else { ?> href="<?php echo base_url('assets/claim_customer/ppt/'.$data->ppt_file)?>" <?php } ?>class="btn btn-success btn-icon icon-left" download="PART - <?php echo $data->NAMA_PART; ?>">
												Download
											<i class="entypo-download"></i>
										</a>
									</td>
									<td style="<?php echo $style_card; ?>"><?php echo $data->card; ?></td>
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
					<?php
						$index++;
					    }
					?>
				</div>
				<?php $this->load->view('_partials/footer.php'); ?>
			</div>
	</div>
	<?php $this->load->view('_partials/js.php'); ?>
	<script src="<?php echo site_url('assets/js/data.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/drilldown.js'); ?>"></script>
	<script>
		jQuery( document ).ready(function($) {
			$('#table-1').DataTable({
				"oLanguage": {
					"sSearch": "Search:",
					"oPaginate": {
						"sPrevious": "Previous",
						"sNext": "Next"
					}
				},
				"pageLength": 10,
				"lengthChange": false
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
		});
		// Create the chart
		Highcharts.chart('container', {
			chart: {
				type: 'column'
			},
			title: {
				text: 'Customer Claim'
			},
			
			xAxis: {
				type: 'category'
			},
			yAxis: {
				allowDecimals: false,
				title: {
					text: 'Total percent customer claim'
				}

			},
			legend: {
				enabled: false
			},
			plotOptions: {
				series: {
					borderWidth: 0,
					dataLabels: {
						enabled: true,
						format: '{point.y:.0f}'
					}
				}
			},

			tooltip: {
				headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
				pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> of total rejection visual and non visual<br/>'
			},

			series: [
				{
					name: "ALL CUSTOMER",
					colorByPoint: true,
					data: [
						<?php
							foreach($customer as $data) { 
						?>
						{
							name: <?php echo json_encode($data->nama_customer) ?>,
							y: <?php echo json_decode($data->total_visual_and_nonvisual	) ?>,
							drilldown: <?php echo json_encode($data->nama_customer) ?>
						},
						<?php
						}
						?>
					]
				}
			],
			drilldown: {
				series: [
					{
						name: "AHM",
						id: "AHM",
						colorByPoint: true,
						data: [
							<?php
								$firstYear = (int)date('Y') - 6;
								$lastYear = $firstYear + 6;
							 	for($i = $firstYear; $i <= $lastYear; $i++) { 
							?>
							{
								name: <?php echo $i ?>,
								y: <?php echo rand(10, 1000) ?>,
								drilldown: <?php echo $i ?>
							},
							<?php } ?>
						]
					},
					<?php
						for($j = $firstYear; $j <= $lastYear; $j++) { 
					?>
							{
								name: <?php echo $j ?>,
								id: <?php echo $j ?>,
								colorByPoint: true,
								data: [
									<?php
										$bulan = array(
										"Januari", "Febuari", "Maret", 
										"April", "Mei", "Juni", "Juli", "Agustus",
										"September", "Oktober", "November", "Desember");  
										foreach($bulan as $b) {
									?>
									{
										name: <?php echo json_encode($b) ?>,
										y: <?php echo rand(10, 1000) / 10 ?>,
										drilldown: <?php echo json_encode($b) ?>   
									},			
									<?php 
										} 
									?>
								]
							},
					<?php
						}
					?>

					<?php
					foreach($bulan as $month) {
					?>
						{
							name: <?php echo json_encode($month) ?>,
							id: <?php echo json_encode($month) ?>,
							colorByPoint: true,
							data: [
								<?php for($i = 1; $i <= 31; $i++) {
								?>
									{
										name: <?php echo $i ?>,
										y: <?php echo rand(10, 90) / 6 ?>,
										colorByPoint: true,
										drilldown: <?php echo $i ?>,
									},
								<?php } ?>
							]
						},
					<?php
					}
					?>

					<?php
					for($a = 1; $a <= 31; $a++) {
					?>
						{
							name: <?php echo $a ?>,
							id: <?php echo $a ?>,
							colorByPoint: true,
							data: [
								<?php
								$rejection = ["VISUAL", "NON VISUAL"];
								foreach($rejection as $r) {
								?>
									{
										name: <?php echo json_encode($r) ?>,
										y: <?php echo rand(0, 15) / 3 ?>,
										drilldown: <?php echo json_encode($r) ?>
									},
								<?php
								}
								?>
							]
						},
					<?php
					}
					?>
					{
						name: "VISUAL",
						id: "VISUAL",
						data: [
							<?php
								$visual = ['Kotor', 'Lecet', 'Tipis', 'Meler', 'Nyerep', 'O Peel', 'Buram', 'Over Cut',
								'Burry', 'Belang', 'Ngeflek', 'Minyak', 'Dustray', 'Cat Kelupas', 'Bintik Air', 
								'Finishing Ng', 'Serat', 'Demotograph', 'Lifting', 'Kusam', 'Flow Mark', 'Legok',
								'Salah Type', 'Getting', 'Part Campur', 'Sinmark', 'Gores', 'Gloss', 'Patah Depan',
								'Patah Belakang', 'Patah Kanan', 'Patah Kiri', 'Silver', 'Burn Mark', 'Weld Line',
								'Bubble', 'Black Dot', 'White Dot', 'Isi Tidak Set', 'Gompal', 'Salah label', 'Sobek terkena cutter',
								'Terbentur (Sobek handling)', 'Kereta (Sobek handling)', 'Terjatuh (Sobek handling)', 'Terkena Gun (Sobek handling)',
								'Sobek Handling', 'Sobek Staples', 'Staples Lepas', 'Keriput', 'Seaming Ng', 'Nonjol', 'Seal Lepas', 'Cover Ng',
								'Belum Finishing', 'Foam Ng'];
								foreach($visual as $v) {
							?>
								[<?php echo json_encode($v) ?>, <?php echo rand(0, 35) / 2 ?>],
							<?php } ?>
						]
					},

					{
						name: "NON VISUAL",
						id: "NON VISUAL",
						data: [
							<?php 
								$non_visual = ['Deformasi', 'Patah / Crack', 'Part Tidak Lengkap', 'Elector Mark', 'Short Shot', 'Material Asing',
								'Pecah', 'Stay Lepas', 'Salah Ulir', 'Visual T/A', 'Ulir Ng', 'Rubber TA', 'Hole Ng'];
								foreach($non_visual as $non) {	
							?>
									[<?php echo json_encode($non) ?>, <?php echo rand(0, 35) / 2 ?>],
							<?php } ?>
						]
					}
				]
			}
		});
	</script>
</body>
</html>

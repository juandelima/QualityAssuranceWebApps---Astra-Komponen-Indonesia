<?php
	$this->simple_login->cek_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php $this->load->view('_partials/head.php'); ?>
	<style>
		@keyframes loading {
			40% {
				background-position: 100% 0;
			}
			100% {
				background-position: 100% 0;
			}
		}

		.tbody .loading {
			position: relative;
		}

		.tbody .loading .bar {
			background-color: #e7e7e7;
			height: 14px;
			border-radius: 7px;
			width: 80%;
		}

		.tbody .loading:after {
			position: absolute;
			transform: translateY(-50%);
			top: 50%;
			left: 0;
			content: "";
			display: block;
			width: 100%;
			height: 24px;
			background-image: linear-gradient(100deg, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.5) 60%, rgba(255, 255, 255, 0) 80%);
			background-size: 200px 24px;
			background-position: -100px 0;
			background-repeat: no-repeat;
			animation: loading 1s infinite;
		}

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

		body.modal-open .datepicker {
    		z-index: 99999 !important;
		}

		.sidebar-menu{
			z-index: 9999!important;
		}

		.red {
			background-color: #fa163f;
			color: #fff;
			text-align: center;
			font-weight: bold;
		}

		.kuning {
			background-color: #ffdc34;
			color: #1b262c;
			text-align: center;
			font-weight: bold;
		}
		.hijau {
			background-color: #21bf73;
			color: #fff;
			text-align: center;
			font-weight: bold;
		}

		.netral {
			text-align: center;
			font-weight: bolder;
			font-size: 20px;
		}
		.proses {
			width: 4%;
			text-align: center;
		}

		.no_surat_claim {
			width: 9%;
		}

		.pica {
			width: 19%;
			text-align: center;
		}

		.hide-main-table {
			display: none;
		}

		.show-main-table {
			display: block;
		}

		.remove-skeleton-table {
			display: none;
		}

		.show-skeleton-table {
			display: block;
		}
		
		.text-align {
			text-align: center;
			font-weight: bolder;
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
					<input type="hidden" name="id_customer" id="id_customer" value=""/>
					<div class="row" style="margin-bottom: 10px;">
						<?php if($this->session->userdata['role'] != 'User') { ?>
							<div class="col-sm-6">
								<a href="<?php echo base_url('claim/customerclaim/create_customerclaim'); ?>" class="btn btn-blue btn-icon btn-block">
									<i class="entypo-user-add"></i>
									ADD CUSTOMER CLAIM
								</a>
							</div>

							<div class="col-sm-6">
								<a href="javascript:;" onclick="jQuery('#form_delivery').modal('show', {backdrop: 'static', keyboard: false});" class="btn btn-success btn-icon btn-block">
									<i class="entypo-box"></i>
									ADD DELIVERY
								</a>
							</div>
						<?php } ?>
					</div>
					<div class="row">
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
						<div class="col-sm-3" id="choose_part">
							<div class="form-group">
								<!-- <label class="col-sm-1 control-label" style="text-align:left;">Part</label> -->
								<div class="col-sm-10" style="text-align:left;">
									<select name="part" id="part" class="select2" data-allow-clear="true" data-placeholder="Select a part...">
										<option></option>
										<!-- <optgroup label="United States"> -->
										<!-- <option value="">ALL PARTS</option> -->
										<?php
											foreach($customer_claim_dist as $data) {
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

						<div class="col-sm-2" id="year_list">
							<div class="form-group">
								<!-- <label class="col-sm-2 control-label">Year</label> -->
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
								<!-- <label class="col-sm-2 control-label">Month</label> -->
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
									<span class="hidden-xs">Parts Graph</span>
								</a>
							</li>
							<li>
								<a href="#chart_rejections" data-toggle="tab">
									<span class="visible-xs"><i class="entypo-chart-bar"></i></span>
									<span class="hidden-xs">Rejections Graph</span>
								</a>
							</li>
						</ul>

						<div class="tab-content">
							<div class="tab-pane active" id="chart_parts">
								<div class="panel panel-primary" id="chart_part" data-collapsed="0" style="margin-top: 25px;">
									<div class="panel-heading">
										<div class="panel-title">REJECTIONS PART GRAPH (QTY & PPM)</div>
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
										<div class="col-sm-4" id="choose_status" style="margin-bottom: 10px;">
											<div class="form-group">
												<div class="col-sm-10" style="text-align:left;">
													<select name="ganti_customer" id="ganti_customer" class="select2" data-allow-clear="true" data-placeholder="Select a customer...">
														<option></option>
														<?php foreach($customers as $data) { ?>
																<option value="<?php echo $data->id_customer; ?>"><?php echo $data->nama_customer; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
										<div id="container_partChart"></div>
									</div>
								</div>
							</div>

							<div class="tab-pane" id="chart_rejections">
								<div class="panel panel-primary" data-collapsed="0" style="margin-top: 25px;">
									<div class="panel-heading">
										<div class="panel-title">REJECTIONS GRAPH (QTY & PPM)</div>
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
										<div class="col-sm-4" id="choose_status" style="margin-bottom: 10px;">
											<div class="form-group">
												<div class="col-sm-10" style="text-align:left;">
													<select name="ganti_customer2" id="ganti_customer2" class="select2" data-allow-clear="true" data-placeholder="Select a customer...">
														<option></option>
														<?php foreach($customers as $data) { ?>
																<option value="<?php echo $data->id_customer; ?>"><?php echo $data->nama_customer; ?></option>
														<?php } ?>
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

				<form role="form" id="filter_table" class="form-horizontal form-groups-bordered" style="margin-top: 20px;">
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group">
								<div class="col-sm-10">
									<select name="table_ganti_customer" id="table_ganti_customer" class="select2" data-allow-clear="true" data-placeholder="Select a customer...">
										<option></option>
										<?php foreach($customers as $data) { ?>
											<option value="<?php echo $data->id_customer; ?>"><?php echo $data->nama_customer; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="form-group">
								<div class="col-sm-10">
									<select name="table_ganti_part" id="table_ganti_part" class="select2" data-allow-clear="true" data-placeholder="Select a part...">
										<option></option>
										<?php
											foreach($customer_claim_dist as $data) {
										?>
											<option value="<?php echo $data->nama_part; ?>"><?php echo $data->nama_part; ?></option>
										<?php 
											}
										?>
									</select>
								</div>
							</div>
						</div>

						<div class="col-sm-2">
							<div class="form-group">
								<!-- <label class="col-sm-2 control-label">Year</label> -->
								<div class="col-sm-10">
									<select name="table_year" id="table_year" class="select2" data-allow-clear="true" data-placeholder="Select year...">
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

				<div class="row">
					<div class="col-md-12">
						<div id="skeleton-table">
							<table class="table table-bordered" id="table_skeleton">
								<thead>
									<tr>
										<th width="1" style="text-align: center;">No</th>
										<th width="50" style="text-align: center;">Tgl</th>
										<th style="text-align: center;">No Surat Claim</th>
										<th style="text-align: center;">Nama Part</th>
										<th style="text-align: center;">Type</th>
										<th style="text-align: center;">Proses</th>
										<th width="50" style="text-align: center;">Due Date</th>
										<th width="180" style="text-align: center;">PICA</th>
										<th style="text-align: center;" width="40">Card</th>
									</tr>
								</thead>
								
								<tbody class="tbody">
									<?php for($i = 0; $i < 10; $i++) {

									?>
									<tr>
										<td class="loading">
											<div class="bar"></div>
										</td>
										<td class="loading">
											<div class="bar"></div>
										</td>
										<td class="loading">
											<div class="bar"></div>
										</td>
										<td class="loading">
											<div class="bar"></div>
										</td>
										<td class="loading">
											<div class="bar"></div>
										</td>
										<td class="loading">
											<div class="bar"></div>
										</td>
										<td class="loading">
											<div class="bar"></div>
										</td>
										<td class="loading">
											<div class="bar"></div>
										</td>
										<td class="loading">
											<div class="bar"></div>
										</td>
									</tr>
									<?php } ?>
								</tbody>
								
							</table>
						</div>
						<div id="main-table">
							<table class="table table-bordered" id="table_customer_claim">
								<thead>
									<tr>
										<th width="1" style="text-align: center;">No</th>
										<th width="50" style="text-align: center;">Tgl</th>
										<th style="text-align: center;">No Surat Claim</th>
										<th style="text-align: center;">Nama Part</th>
										<th style="text-align: center;">Type</th>
										<th style="text-align: center;">Proses</th>
										<th width="50" style="text-align: center;">Due Date</th>
										<th width="180" style="text-align: center;">PICA</th>
										<th style="text-align: center;" width="40">Card</th>
									</tr>
								</thead>
								
								<tbody>
									
								</tbody>
							</table>
						</div>
					</div>
					<?php
						$index = 0;
						foreach($customer_claim as $data) {
							$id = $data->id_customer_claim;
					?>
					<div class="modal fade" id="upload-ppt<?php echo $id; ?>">
						<div class="modal-dialog" style="width: 50%;">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title">Upload PPT File - <?php echo $data->nama_part; ?></h4>
								</div>
								<form role="form" class="form-horizontal" id="upload_file<?php echo $id; ?>" enctype="multipart/form-data" action="<?php echo base_url('claim/powerpoint/upload_ppt/'.$id); ?>" method="POST">
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
											<div class="col-md-12">
												<div class="progress progress-striped active">
													<div id="progress-bar<?php echo $id; ?>" class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
														<span id="progress<?php echo $id; ?>"></span>
													</div>
												</div>
											</div>  
										</div>  
									</div>
									<div class="modal-footer">
										<button type="button" id="modal_close<?php echo $id; ?>" class="btn btn-danger" data-dismiss="modal">Batal</button>
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
				<div class="modal fade" id="form_delivery">
						<div class="modal-dialog" style="width: 50%;">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title"><b>Delivery</b></h4>
									<h5>NB: Quantity akan mempengaruhi perubahan value grafik ppm berdasarkan tahun dan bulan di dashboard</h5>
								</div>
								<form role="form" class="form-horizontal" id="input_delivery" method="POST">
									<div class="modal-body">
										<div class="row" id="spinners">
											<div class="col-md-12">
												<div class="form-group">
													<label class="col-sm-3 control-label" style="text-align:left;">Tanggal Delivery</label>
													<div class="col-sm-4">
														<div class="input-group">
															<input type="text" class="form-control datepicker" name="tgl_deliv" id="tgl_deliv" data-format="dd MM yyyy" placeholder="tanggal delivery..." required>
															<div class="input-group-addon">
																<a href="#"><i class="entypo-calendar"></i></a>
															</div>
														</div>
													</div>
												</div>

												<div class="form-group">
													<label class="col-sm-3 control-label" style="text-align:left;">Quantity</label>
													<div class="input-spinner col-sm-3">
														<button type="button" class="btn btn-blue" id="btn_min">-</button>
														<input type="text" id="qty" name="qty" class="form-control size-1" value="1"/>
														<button type="button" class="btn btn-blue" id="btn_plus">+</button>
													</div>
												</div>
											</div>  
										</div>  
									</div>

									<div class="modal-footer">
										<button type="button" id="modal_close" class="btn btn-danger" data-dismiss="modal">Batal</button>
										<button type="submit" id="save_qty" class="btn btn-primary">Simpan</button>
									</div>
								</form>
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
	<link rel="stylesheet" href="<?php echo site_url('assets/js/daterangepicker/daterangepicker-bs3.css'); ?>">
	<?php $this->load->view('_partials/js.php'); ?>
	<script src="<?php echo site_url('assets/js/icheck/icheck.min.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/data.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/fusioncharts.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/fusioncharts.theme.fusion.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/fusioncharts.jqueryplugin.min.js'); ?>"></script>
	<script src="http://malsup.github.com/jquery.form.js"></script> 
	<?php $this->load->view('_partials/customer_claim_chart.php'); ?>
	<?php $this->load->view('_partials/filter_customerclaim_byCustomer.php'); ?>
	<script>
		// UPLOAD FILE
		jQuery(document).ready(function($) {
			$("#form_delivery").find("#btn_min").attr("disabled", true);
			$("#form_delivery").find("#btn_plus").click(function add() {
				$("#form_delivery").find("#btn_min").attr("disabled", false);
			});

			$("#form_delivery").find("#btn_min").click(function subst() {
				let val_qty = $("#qty").val();
				if(val_qty < 2) {
					$("#form_delivery").find("#btn_min").attr("disabled", true);
				}
			});
			$("#input_delivery").on('click', '#save_qty', function(e) {
				e.preventDefault();
				$.ajax({
					url: "<?php echo base_url('claim/customerclaim/ahm_delivery'); ?>",
					type: "POST",
					data: $("#input_delivery").serialize(),
					dataType: "JSON",
					cache: false,
					success: function(data) {
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
						toastr.success('DELIVERY SUKSES TERSIMPAN', "SUCCESS", opts);

					},
					complete: function() {
						$("#tgl_deliv").val(null);
						$("#qty").val(1);
						$("#form_delivery").find("#btn_min").attr("disabled", true);
						$("#form_delivery").modal('hide');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert(textStatus +" "+errorThrown);
						// $("#error_text").text(textStatus +" "+errorThrown);
						// $("#modal-error-ajax").modal('show');;
					}
				});
			});
			$.ajaxSu
			<?php
				$index = 0;
				foreach($customer_claim as $data) {
					$id = $data->id_customer_claim;
			?>
					$("#upload_file<?php echo $id; ?>").submit(function(e) {
						e.preventDefault();
						$(this).ajaxSubmit({
							beforeSubmit: () => {
								$('#progress-bar<?php echo $id; ?>').width('0%');
							},
							uploadProgress: (event, position, total, percentComplete) => {
								console.log(percentComplete);
								$("#progress-bar<?php echo $id; ?>").width(percentComplete + '%');
								$("span#progress<?php echo $id; ?>").text(percentComplete+"%");
							},
							success: (data) => {
								let data_json = JSON.parse(data);
								console.log(data_json);
								let select_claim = data_json.select_claim;
								let due_date = Date.parse(data_json.due_date);
								let dateNow = Date.parse(data_json.dateNow);
								function closeModal() {
									if(dateNow > due_date) {
										$("#status_color<?php echo $id; ?>").addClass('kuning');
									} else {
										$("#status_color<?php echo $id; ?>").addClass('hijau');
									}
									$("#upload-ppt"+select_claim.id_customer_claim).modal('hide');
								}
								setTimeout(closeModal, 1500);
							},
							complete: (data) => {
								let data_json = JSON.parse(data.responseText);
								let jsonResponse = data_json.select_claim;
								let fileName = data_json.file_name;
								console.log(jsonResponse);
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
								function successUpload() {
									toastr.success('FILE BERHASIL DIUPLOAD', "SUCCESS", opts);
									$("#download_ppt_file"+jsonResponse.id_customer_claim).removeAttr("disabled");
									$("#download_ppt_file"+jsonResponse.id_customer_claim).attr("href", "<?php echo base_url('assets/claim_customer/ppt/'); ?>"+fileName+"");
								}
								setTimeout(successUpload, 1500);
								$('#upload-ppt<?php echo $id; ?>').unbind();
							},
							error: function(jqXHR, textStatus, errorThrown) {
								alert(textStatus +" "+errorThrown);
								// $("#error_text").text(textStatus +" "+errorThrown);
								// $("#modal-error-ajax").modal('show');;
							}
						});
					});
			<?php 
				}
			?>
		});	

	</script>
</body>
</html>

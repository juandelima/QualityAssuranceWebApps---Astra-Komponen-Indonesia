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

		body.modal-open .datepicker {
    		z-index: 99999 !important;
		}

		.sidebar-menu{
			z-index: 9999!important;
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
							<div class="col-sm-6">
								<a href="<?php echo base_url('claim/customerclaim/create_ahm'); ?>" class="btn btn-blue btn-icon btn-block">
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
						<div class="col-sm-3" id="choose_status">
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
									<select name="part" id="part" class="select2" data-allow-clear="true" data-placeholder="Select one part...">
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
										<div id="container"></div>
									</div>
								</div>
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
										$id = $data->id_customer_claim;
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
									<td><?php echo $data->nama_part; ?></td>
									<td><?php echo $data->type; ?></td>
									<td><?php echo $data->proses; ?></td>
									
									<!-- <td style="text-align: center;">
										<a href="javascript:;" onclick="jQuery('#modal-data-non<?php echo $data->id_customer_claim; ?>').modal('show', {backdrop: 'static'});" class="popover-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="KLIK UNTUK MELIHAT DATA REJECTION <?php echo $data->nama_part; ?>">
											<?php echo $sum_rejection; ?>
										</a>
									</td> -->
									<td style="<?php echo $style; ?>" id="status_color<?php echo $id; ?>"><?php echo date('d-m-Y', strtotime($overdue)); ?></td>
									<td style="text-align: center;">
										<a href="javascript:;" onclick="jQuery('#modal-upload-ppt<?php echo $data->id_customer_claim; ?>').modal('show', {backdrop: 'static', keyboard: false});" class="btn btn-blue btn-icon icon-left">
												Upload
											<i class="entypo-upload"></i>
										</a>

										<a <?php if(empty($data->ppt_file)) { ?> disabled <?php } else { ?> href="<?php echo base_url('assets/claim_customer/ppt/'.$data->ppt_file)?>" <?php } ?> class="btn btn-success btn-icon icon-left" download="PART - <?php echo $data->nama_part; ?>" id="download_ppt_file<?php echo $id; ?>">
												Download
											<i class="entypo-download"></i>
										</a>
									</td>
									<td style="<?php echo $style_card; ?>"><?php echo $data->card; ?></td>
									<!-- <td style="text-align: center;">
										<a href="javascript:;" onclick="jQuery('#charts<?php echo $data->id_customer_claim; ?>').modal('show', {backdrop: 'static'});" class="btn btn-danger btn-icon icon-left popover-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="KLIK UNTUK MELIHAT GRAFIK REJECTION <?php echo $data->nama_part; ?>">
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
					<div class="modal fade" id="modal-upload-ppt<?php echo $data->id_customer_claim; ?>">
						<div class="modal-dialog" style="width: 50%;">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title">Upload PPT File - <?php echo $data->nama_part; ?></h4>
								</div>
								<form role="form" class="form-horizontal" id="upload_file<?php echo $id; ?>" enctype="multipart/form-data">
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
	<?php $this->load->view('_partials/customer_claim_chart.php'); ?>
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

			<?php
				$index = 0;
				foreach($customer_claim as $data) {
					$id = $data->id_customer_claim;
			?>
					$("#upload_file<?php echo $id; ?>").submit(function(e) {
						e.preventDefault();
						$.ajax({
							url: "<?php echo base_url('claim/powerpoint/upload_ppt/'.$id); ?>",
							type: "POST",
							data: new FormData(this),
							dataType: "JSON",
							processData: false,
							contentType: false,
							cache: false,
							beforeSend: function() {
								show_loading_bar(100);
							},
							success: function(data) {
								console.log(data);
								let select_claim = data.select_claim;
								let due_date = Date.parse(data.due_date);
								let dateNow = Date.parse(data.dateNow);
								// console.log(data);
								function closeModal() {
									if(dateNow > due_date) {
										$("#status_color<?php echo $id; ?>").css('background-color', '#ffd800');
										$("#status_color<?php echo $id; ?>").css('color', '#222831');
									} else {
										$("#status_color<?php echo $id; ?>").css('background-color', '#42b883');
										$("#status_color<?php echo $id; ?>").css('color', '#ffffff');
									}
									$("#modal-upload-ppt"+select_claim.id_customer_claim).modal('hide');
								}
								setTimeout(closeModal, 3000);
							},
							complete: function(data) {
								let jsonResponse = data.responseJSON.select_claim;
								let fileName = data.responseJSON.file_name;
								// console.log(jsonResponse);
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
								setTimeout(successUpload, 3000);
								$('#modal-upload-ppt<?php echo $id; ?>').unbind();
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

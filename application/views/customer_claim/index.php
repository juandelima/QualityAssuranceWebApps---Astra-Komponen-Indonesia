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

		#chat, .chat-conversation, .sidebar-menu{
			z-index: 9999!important;
		}

		.red {
			background-color: #fa163f!important;
			color: #fff!important;
			text-align: center;
			font-weight: bold;
		}

		.kuning {
			background-color: #ffdc34!important;
			color: #1b262c!important;
			text-align: center;
			font-weight: bold;
		}

		.hijau {
			background-color: #21bf73!important;
			color: #fff!important;
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
			text-align: center;
		}

		.pica {
			width: 19%;
			text-align: center;
		}

		.centered {
			width: 5%;
			text-align: center;
		}

		.centered1 {
			width: 30%;
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

		table.dataTable.no-footer {
    		border-bottom: 1px solid #f9f9f9 !important;
		}

		.label {
			font-size: 13px;
			margin-bottom: 8px;
		}

		.status {
			font-weight: bolder;
		}

		.modal-dialog {
			width: 80%;
		}

		/* 
		##Device = Tablets, Ipads (landscape)
		##Screen = B/w 768px to 1024px
		*/

		@media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {
			.modal-dialog {
				width: 95%!important;
			}
		
		}

		/* 
		##Device = Low Resolution Tablets, Mobiles (Landscape)
		##Screen = B/w 481px to 767px
		*/

		@media (min-width: 481px) and (max-width: 767px) {
			.modal-dialog {
				width: 95%!important;
			}
		}

		/* 
		##Device = Most of the Smartphones Mobiles (Portrait)
		##Screen = B/w 320px to 479px
		*/

		@media (min-width: 320px) and (max-width: 480px) {
			.modal-dialog {
				width: 95%!important;
			}
		}
	</style>
</head>
<body class="page-body skin-facebook" data-url="http://neon.dev">
	<div class="page-container sidebar-collapsed">
		<?php $this->load->view('_partials/navbar.php'); ?>
			<div class="main-content">
				<?php $this->load->view('_partials/navbar_head.php'); ?>
				<?php
					if($this->session->flashdata('sukses')) {
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
					<input type="hidden" name="part" id="part" value=""/>
					<div class="row" style="margin-bottom: 10px;">
						<div class="<?php if($this->session->userdata['role'] != 'User') { ?> col-sm-6 <?php } else { ?> col-sm-12 <?php } ?>">
							<a href="<?php echo base_url('claim/customerclaim/create_customerclaim'); ?>" class="btn btn-blue btn-icon btn-block">
								<i class="entypo-user-add"></i>
								ADD CUSTOMER CLAIM
							</a>
						</div>

						<?php if($this->session->userdata['role'] != 'User') { ?> 
							<div class="col-sm-6">
								<a href="javascript:;" id="add_delivery" onclick="jQuery('#form_delivery').modal('show', {backdrop: 'static', keyboard: false});" class="btn btn-success btn-icon btn-block">
									<i class="entypo-box"></i>
									ADD DELIVERY
								</a>
							</div>
						<?php } ?>
					</div>
				</form>
				

				<?php if($this->session->userdata['role'] != 'User') { ?> 
				<div class="panel panel-primary" id="charts_env">
					<div class="panel-body">
						<div class="row">
						
							<div class="col-md-12">
								<ul class="nav nav-tabs">
									<li class="active">
										<a href="#customer_claim" data-toggle="tab">
											<span class="visible-xs"><i class="entypo-chart-line"></i></span>
											<span class="hidden-xs">Customer Claim</span>
										</a>
									</li>

									<li>
										<a href="#delivery" data-toggle="tab">
											<span class="visible-xs"><i class="entypo-chart-line"></i></span>
											<span class="hidden-xs">Delivery</span>
										</a>
									</li>
								</ul>
								
								<div class="tab-content">
									<div class="tab-pane active" id="customer_claim">
									<form role="form" id="filter_table" class="form-horizontal form-groups-bordered" style="margin-top: 20px;">
											<div class="row">
												<div class="col-sm-3">
													<div class="form-group">
														<div class="col-sm-10">
															<select name="filter_customer" id="filter_customer" class="select2" data-allow-clear="true" data-placeholder="Pilih customer...">
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
											</div>										
										</form>
										<div class="row">
											<div class="col-md-12">
												<table class="table table-bordered nowrap" id="table_customer_claim">
													<thead>
														<tr>
															<th width="1" style="text-align: center;">No</th>
															<th width="50" style="text-align: center;">Tgl</th>
															<th class="no_surat_claim">No Surat Claim</th>
															<th style="text-align: center;">Nama Part</th>
															<th style="text-align: center;">Type</th>
															<th style="text-align: center;">Proses</th>
															<th width="50" style="text-align: center;">Due Date</th>
															<th style="text-align: center;">OFP</th>
															<th style="text-align: center;">Pergantian Part</th>
															<th style="text-align: center;">Sortir Stock</th>
															<th width="180" style="text-align: center;">PICA</th>
															<th style="text-align: center;">PFMEA</th>
															<th style="text-align: center;">Status</th>
															<th style="text-align: center;" width="40">Card</th>
														</tr>
													</thead>
												</table>
											</div>
											
											<?php
												$index = 0;
												foreach($customer_claim as $data) {
													$id = $data->id_customer_claim;
											?>
											<div class="modal fade" id="upload-ppt<?php echo $id; ?>">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title">Upload PICA File - <?php echo $data->nama_part; ?></h4>
														</div>
														<form role="form" class="form-horizontal" id="upload_file<?php echo $id; ?>" enctype="multipart/form-data" action="<?php echo base_url('claim/powerpoint/upload_ppt/'.$id); ?>" method="POST">
															<div class="modal-body">
																<div class="row" id="spinners">
																	<div class="col-md-12">
																		<div class="form-group">
																			<label class="col-sm-3 control-label">PICA File</label>
																			<div class="col-sm-5">
																				<input required type="file" id="nama_file<?php echo $id; ?>" name="ppt_file[]" class="form-control file2 inline btn btn-primary" multiple="1" data-label="<i class='glyphicon glyphicon-circle-arrow-up'></i> &nbsp;Browse Files" />
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

											<div class="modal fade" id="modal_view_pica_files<?php echo $id; ?>">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title">PICA FILES - <?php echo $data->nama_part; ?></h4>
														</div>
														<div class="modal-body">
															<table class="table table-bordered" id="table_file_pica<?php echo $id; ?>" width="100%">
																<thead>
																	<tr>
																		<th width="1" style="text-align: center;">No</th>
																		<th width="50" style="text-align: center;">Tgl Upload</th>
																		<th style="text-align: center;">Nama File</th>
																		<th width="1" style="text-align: center;">Link</th>
																	</tr>
																</thead>
																
																<tbody>
																	
																</tbody>
															</table>
														</div>
														<div class="modal-footer">
															<button type="button" id="close_table_pica<?php echo $id; ?>" class="btn btn-danger" data-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</div>

											<div class="modal fade" id="upload-ofp<?php echo $id; ?>">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title">Upload OFP File - <?php echo $data->nama_part; ?></h4>
														</div>
														<form role="form" class="form-horizontal" id="upload_ofpfile<?php echo $id; ?>" enctype="multipart/form-data" action="<?php echo base_url('claim/powerpoint/upload_ofp/'.$id); ?>" method="POST" accept-charset="utf-8">
															<div class="modal-body">
																<div class="row" id="spinners">
																	<div class="col-md-12">
																		<div class="form-group">
																			<label class="col-sm-3 control-label">File</label>
																			<div class="col-sm-5">
																				<input required type="file" id="nama_file_ofp<?php echo $id; ?>" name="nama_file_ofp[]" class="form-control file2 inline btn btn-primary" multiple="1" data-label="<i class='glyphicon glyphicon-circle-arrow-up'></i> &nbsp;Browse Files" />
																			</div>
																		</div>
																	</div>
																	<div class="col-md-12">
																		<div class="progress progress-striped active">
																			<div id="progress-bar-ofp<?php echo $id; ?>" class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
																				<span id="progress-ofp<?php echo $id; ?>"></span>
																			</div>
																		</div>
																	</div>  
																</div>  
															</div>
															<div class="modal-footer">
																<button type="button" id="modal_close_ofp<?php echo $id; ?>" class="btn btn-danger" data-dismiss="modal">Batal</button>
																<button type="submit" class="btn btn-primary">Upload</button>
															</div>
														</form>
													</div> 
												</div>
											</div>

											<div class="modal fade" id="modal_view_ofp_files<?php echo $id; ?>">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title">OFP FILES - <?php echo $data->nama_part; ?></h4>
														</div>
														<div class="modal-body">
															<table class="table table-bordered" id="table_file_ofp<?php echo $id; ?>" width="100%">
																<thead>
																	<tr>
																		<th width="1" style="text-align: center;">No</th>
																		<th width="50" style="text-align: center;">Tgl Upload</th>
																		<th style="text-align: center;">Nama File</th>
																		<th width="1" style="text-align: center;">Link</th>
																	</tr>
																</thead>
																
																<tbody>
																	
																</tbody>
															</table>
														</div>
														<div class="modal-footer">
															<button type="button" id="close_table_ofp<?php echo $id; ?>" class="btn btn-danger" data-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</div>

											<div class="modal fade" id="pergantian-part<?php echo $id; ?>">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title">Pergantian Part <?php echo $data->nama_part; ?></h4>
														</div>
														<form role="form" class="form-horizontal" id="upload_pergantian<?php echo $id; ?>" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
															<input type="hidden" name="id_customer_claim" value="<?php echo $id; ?>"/>
															<div class="modal-body">
																<div class="row">
																	<div class="col-md-12">
																		<div class="form-group">
																			<label class="col-sm-3 control-label" style="text-align:left;">Tanggal Pembayaran</label>
																			<div class="col-sm-4">
																				<div class="input-group">
																					<input type="text" class="form-control datepicker" name="tgl_pembayaran" id="tgl_pembayaran<?php echo $id; ?>" data-format="dd.mm.yyyy" placeholder="06.11.2019" required>
																					<div class="input-group-addon">
																						<a href="#"><i class="entypo-calendar"></i></a>
																					</div>
																				</div>
																			</div>
																		</div>

																		<div class="form-group">
																			<label class="col-sm-3 control-label" style="text-align:left;">NO GI 451</label>
																			<div class="col-sm-4">
																				<div class="input-group">
																					<input type="text" class="form-control" name="no_gi_451" id="no_gi_451<?php echo $id; ?>" placeholder="4953444424" required>
																				</div>
																			</div>
																		</div>

																		<div class="form-group">
																			<label class="col-sm-3 control-label" style="text-align:left;">NO GI 945</label>
																			<div class="col-sm-4">
																				<div class="input-group">
																					<input type="text" class="form-control" name="no_gi_945" id="no_gi_945<?php echo $id; ?>" placeholder="4953444428" required>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<button type="button" id="modal_close_pergantian<?php echo $id; ?>" class="btn btn-danger" data-dismiss="modal">Batal</button>
																<button type="submit" id="simpan_pergantian<?php echo $id; ?>" class="btn btn-primary">Simpan</button>
															</div>
														</form>
													</div> 
												</div>
											</div>

											<div class="modal fade" id="sortir-stock<?php echo $id; ?>">
												<div class="modal-dialog" style="width: 50%">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title">SORTIR / REPAIR PART <b><?php echo $data->nama_part; ?></b></h4>
														</div>

														<form role="form" class="form-horizontal" id="create_sortir_stock<?php echo $id; ?>" enctype="multipart/form-data" method="POST" action="#" accept-charset="utf-8">
															<div class="modal-body">
																<div class="row">
																	<div class="col-md-12">
																		<div class="form-group">
																			<label class="col-sm-2 control-label" style="text-align:left;">Tanggal</label>
																			<div class="col-sm-7">
																				<div class="input-group">
																					<input type="text" class="form-control datepicker" name="tgl_sortir" id="tgl_sortir<?php echo $id; ?>" data-format="dd.mm.yyyy" placeholder="06.11.2019" required>
																					<div class="input-group-addon">
																						<a href="#"><i class="entypo-calendar"></i></a>
																					</div>
																				</div>
																			</div>
																		</div>

																		<div class="form-group">
																			<label class="col-sm-2 control-label" style="text-align:left;">Nama Part</label>
																			<div class="col-sm-7">
																				<input type="text" class="form-control" name="nama_part_sortir" id="nama_part_sortir<?php echo $id; ?>" placeholder="4953444424" value="<?php echo $data->nama_part; ?>" required readonly>
																			</div>
																		</div>

																		<div class="form-group">
																			<label class="col-sm-2 control-label" style="text-align:left;">Type</label>
																			<div class="col-sm-7">
																				<input type="text" class="form-control" name="type" id="type<?php echo $id; ?>" placeholder="type..." value="<?php echo $data->type; ?>" required readonly>
																			</div>
																		</div>
																		<div class="form-group" style="padding: 10px;">
																			<table class="table table-bordered" id="table_sortir_problem<?php echo $id; ?>">
																				<thead>
																					<tr>
																						<th><b>Problem</b></th>
																					</tr>
																				</thead>
																				<tbody>
																					<tr>
																						<td class="padding-sm" id="problem_part<?php echo $id; ?>">
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</div>
																		<div class="form-group" style="padding: 10px;" style="margin-top: -10px;">
																			<table class="table table-bordered" id="table_sortir_stock<?php echo $id; ?>">
																				<thead>
																					<tr>
																						<th><b>Stock</b></th>
																						<th><b>Ok</b></th>
																						<th><b>Ng</b></th>
																						<th><b>Sisa</b></th>
																					</tr>
																				</thead>

																				<tbody>
																					<tr>
																						<td width="150">
																							<div class="input-spinner">
																								<button type="button" class="btn btn-success btn-sm" id="btn_min_stock<?php echo $id; ?>">-</button>
																									<input name="stock" id="stock<?php echo $id; ?>" type="text" class="form-control size-1 input-sm" value="0" data-min="0" />
																								<button type="button" class="btn btn-success btn-sm" id="btn_plus_stock<?php echo $id; ?>">+</button>
																							</div>
																						</td>
																						<td width="150">
																							<div class="input-spinner">
																								<button type="button" class="btn btn-success btn-sm" id="btn_min_ok<?php echo $id; ?>">-</button>
																								<input name="ok" id="ok<?php echo $id; ?>" type="text" class="form-control size-1 input-sm" value="0" data-min="0" />
																								<button type="button" class="btn btn-success btn-sm" id="btn_plus_ok<?php echo $id; ?>">+</button>
																							</div>
																						</td>
																						<td width="150">
																							<div class="input-spinner">
																								<button type="button" class="btn btn-success btn-sm" id="btn_min_ng<?php echo $id; ?>">-</button>
																								<input name="ng" id="ng<?php echo $id; ?>" type="text" class="form-control size-1 input-sm" value="0" data-min="0" />
																								<button type="button" class="btn btn-success btn-sm" id="btn_plus_ng<?php echo $id; ?>">+</button>
																							</div>
																						</td>
																						<td width="150">
																							<input name="sisa" id="sisa<?php echo $id; ?>" type="text" class="form-control input-sm" value="0" readonly/>
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</div>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<button type="button" id="close_sortir<?php echo $id; ?>" class="btn btn-danger" data-dismiss="modal">Batal</button>
																<button type="submit" id="simpan_sortir<?php echo $id; ?>" class="btn btn-primary">Simpan</button>
															</div>
														</form>
													</div>
												</div>
											</div>

											<div class="modal fade" id="pfmea<?php echo $id; ?>">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title">PFMEA - <?php echo $data->nama_part; ?></h4>
														</div>
														<form role="form" class="form-horizontal" id="pfmea_file<?php echo $id; ?>" enctype="multipart/form-data" method="POST" action="<?php echo base_url('claim/powerpoint/upload_pfmea/'.$id); ?>" accept-charset="utf-8">
															<input type="hidden" name="id_customer_claim" value="<?php echo $id; ?>"/>
															<div class="modal-body">
																<div class="row">
																	<div class="col-md-12" style="margin-bottom: 10px;">
																		<input required type="file" id="nama_file_pfmea<?php echo $id; ?>" name="file_pfmea[]" class="form-control file2 inline btn btn-primary" multiple="1" data-label="<i class='glyphicon glyphicon-circle-arrow-up'></i> &nbsp;Browse Files" />
																	</div>
																	<div class="col-md-12">
																		<div class="progress progress-striped active">
																			<div id="progress-bar-pfmea<?php echo $id; ?>" class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
																				<span id="progress-pfmea<?php echo $id; ?>"></span>
																			</div>
																		</div>
																	</div> 
																</div>
															</div>
															<div class="modal-footer">
																<button type="button" id="close_pfmea<?php echo $id; ?>" class="btn btn-danger" data-dismiss="modal">Batal</button>
																<button type="submit" class="btn btn-primary">Simpan</button>
															</div>
														</form>
													</div> 
												</div>
											</div>

											<div class="modal fade" id="modal_view_files<?php echo $id; ?>">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title">PFMEA FILES - <?php echo $data->nama_part; ?></h4>
														</div>
														<div class="modal-body">
															<table class="table table-bordered" id="table_file_pfmea<?php echo $id; ?>" width="100%">
																<thead>
																	<tr>
																		<th width="1" style="text-align: center;">No</th>
																		<th width="50" style="text-align: center;">Tgl Upload</th>
																		<th style="text-align: center;">Nama File</th>
																		<th width="1" style="text-align: center;">Link</th>
																	</tr>
																</thead>
																
																<tbody>
																	
																</tbody>
															</table>
														</div>
														<div class="modal-footer">
															<button type="button" id="close_table_pfmea<?php echo $id; ?>" class="btn btn-danger" data-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</div>
											<?php
												$index++;
												}
											?>
										</div>
									</div>
									<div class="tab-pane" id="delivery">
										<div class="row">
											<div class="col-md-12">
												<table class="table table-bordered nowrap" id="delivery_table" width="100%">
													<thead>
														<tr>
															<th width="1%" style="text-align: center;">No</th>
															<th width="50" style="text-align: center;">Tgl</th>
															<th style="text-align: center;">Quantity</th>
														</tr>
													</thead>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				<div class="modal fade" id="form_delivery">
						<div class="modal-dialog">
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
													<label class="col-sm-3 control-label" style="text-align:left;">Proses</label>
													<div class="col-sm-4">
														<select name="proses_deliv" id="proses_deliv" class="form-control">
															<option>proses</option>
															<?php foreach($proses as $data) { ?>
																<option value="<?php echo $data->proses; ?>"><?php echo $data->proses; ?></option>
															<?php } ?>
														</select>
													</div>
												</div>

												<div class="form-group">
													<label class="col-sm-3 control-label" style="text-align:left;">Customer</label>
													<div class="col-sm-4">
														<select name="customer_deliv" id="customer_deliv" class="form-control">
															<option>customer</option>
														</select>
													</div>
												</div>

												<div class="form-group">
													<label class="col-sm-3 control-label" style="text-align:left;">Quantity</label>
													<div class="input-spinner col-sm-3">
														<button type="button" class="btn btn-blue">-</button>
														<input type="text" id="qty" name="qty" class="form-control size-1" value="1" data-min="1"/>
														<button type="button" class="btn btn-blue">+</button>
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
					<div class="modal-dialog">
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
	<link rel="stylesheet" href="<?php echo site_url('assets/js/daterangepicker/daterangepicker-bs3.css'); ?>">
	<?php $this->load->view('_partials/js.php'); ?>
	<script src="<?php echo site_url('assets/js/customer_claim/new_customer_claim.js'); ?>"></script>
	<script src="<?php echo site_url('assets/js/customer_claim/new_delivery.js'); ?>"></script>
	<?php $this->load->view('_partials/customer_claim.php'); ?>
	<script src="<?php echo site_url('assets/js/icheck/icheck.min.js'); ?>"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
	<script src="<?php echo site_url('assets/js/chatting/chat.js'); ?>"></script>
	<?php $this->load->view('_partials/chatting'); ?>
</body>
</html>
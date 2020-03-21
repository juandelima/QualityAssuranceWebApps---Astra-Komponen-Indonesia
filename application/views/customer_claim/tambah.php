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
		.input-spinner {
			display: flex !important;
			flex-direction: row !important;
			justify-content: center !important;
		}

		td.sorting_1 {
			text-align: center;
		}
		.selectboxitTrigger {
    		visibility: visible !important;
		}
	</style>
</head>
<body class="page-body skin-facebook" data-url="http://neon.dev">
	<div class="page-container">
		<?php $this->load->view('_partials/navbar.php'); ?>
		<div class="main-content">
		<?php $this->load->view('_partials/navbar_head.php'); ?>
			<h2>Add Customer Claim</h2>
			<ol class="breadcrumb bc-3">
				<li>
					<a href="<?php echo base_url('claim/customerclaim') ?>"><i class="entypo-home"> Customer Claim</i></a>
				</li>
				<li class="active">
					<strong>Add Customer Claim</strong>
				</li>
			</ol>
			<div class="col-sm-3" style="margin-bottom: 20px;">
				<form role="form" id="filter_form" class="form-horizontal form-groups-bordered">
					<div class="form-group">
						<label for="field-1" class="col-sm-2 control-label" style="text-align:left;">Form</label>
						<div class="col-sm-10">
							<select name="change_customer" id="change_customer" class="selectboxit" data-first-option="false">
								<option>select customer...</option>
								<?php foreach($list_customer as $data) { ?>
										<option value="<?php echo $data->id_customer; ?>"><?php echo $data->nama_customer; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</form>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary" data-collapsed="0">
						<div class="panel-heading">
							<div class="panel-options">
								<a href="#" data-rel="reload" id="reloading"></a>
							</div>
						</div>
						<div class="panel-body">
							<form role="form" id="create_claim" class="form-horizontal" action="<?php echo base_url('claim/customerclaim/save'); ?>" method="post">
								<?php
									$id_name = ['kotor_visual', 'lecet_visual', 'tipis_visual', 'meler_visual', 'nyerep_visual', 'opeel_visual', 'buram_visual', 'overcut_visual', 'burry_visual', 'belang_visual', 'ngeflek_visual',
												'minyak_visual', 'dustray_visual', 'cat_kelupas_visual', 'b_air_visual', 'f_ng_visual', 'serat_visual', 'd_graph_visual', 'lifting_visual', 'kusam_visual', 'f_mark_visual', 'legok_visual',
												's_type_visual', 'getting_visual', 'part_campur_visual', 'sinmark_visual', 'gores_visual', 'gloss_visual', 'p_depan_visual', 'p_belakang_visual', 'p_kanan_visual', 'p_kiri_visual',
												'silver_visual', 'b_mark_visual', 'w_line_visual', 'bubble_visual', 'b_dot_visual', 'w_dot_visual', 'isi_tidak_set_visual', 'gompal_visual', 's_label_visual', 't_cutter_visual',
												'terbentur_visual', 'kereta_visual', 'terjatuh_visual', 'terkena_gun_visual', 's_handling_visual', 's_steples_visual', 's_lepas_visual', 'keriput_visual', 'seaming_ng_visual',
												'nonjol_visual', 'seal_lepas_visual', 'cover_ng_visual', 'b_finishing_visual', 'foam_ng_visual'];

									$name = ['deformasi_non', 'patah_non', 'incomplete_part_non', 'e_mark_non', 'short_shot_non', 'material_asing_non', 
											'pecah_non', 'stay_lepas_non', 'salah_ulir_non', 'visual_ta_non', 'ulir_ng_non', 'rubber_ta_non', 'hole_ng_non'];
									for($i = 0; $i < count($id_name); $i++) {
								?>
									<input type="hidden" class="form-control" id="<?php echo $id_name[$i]; ?>" name="<?php echo $id_name[$i]; ?>[]" value="0">
								<?php
								}
									for($i = 0; $i < count($name); $i++) {
								?>
									<input type="hidden" id="<?php echo $name[$i]; ?>" name="<?php echo $name[$i]; ?>[]" class="form-control" value="0"/>
								<?php
								}
								?>
									<div class="form-group">
										<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Tanggal</label>
										<div class="col-sm-5">
											<div class="input-group">
												<input type="text" class="form-control datepicker" name="tgl" id="tgl_input" data-format="dd MM yyyy" placeholder="tanggal" required>
											
												<div class="input-group-addon">
													<a href="#"><i class="entypo-calendar"></i></a>
												</div>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">No.Surat Claim</label>
										<div class="col-sm-5">
											<input type="text" class="form-control" id="no_surat_claim" name="no_surat_claim" placeholder="AHM/00155/1100078/11/2019" required/>
										</div>
									</div>

									<div class="form-group">
										<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Tanggal Surat Claim</label>
										<div class="col-sm-5">
											<div class="input-group">
												<input type="text" class="form-control datepicker" id="tgl_surat_claim" name="tgl_surat_claim" data-format="dd MM yyyy" placeholder="tanggal surat claim" required>
												<div class="input-group-addon">
													<a href="#"><i class="entypo-calendar"></i></a>
												</div>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">No Lkk Qro</label>
										<div class="col-sm-5">
											<input type="text" class="form-control" id="no_lkk_qro" name="no_lkk_qro[]" placeholder="EKT/31/QA/ASKI/11/2019" required/>
										</div>
									</div>

									<div class="form-group">
										<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Claim/Tukar Guling</label>
										<div class="col-sm-5">
											<select name="status_claim[]" class="form-control">
												<option value="Claim">Claim</option>
												<option value="Tukar Guling">Tukar Guling</option>
											</select>
										</div>
									</div>

									<div class="form-group" id="ahmPlant">
										<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">AHM Plant</label>
										<div class="col-sm-5">
											<select name="ahm_plant[]" class="form-control" id="ahm_plant">
												<option value="<?php echo null; ?>" selected>Select AHM plant...</option>
												<option value="AHM 1">AHM 1</option>
												<option value="AHM 2">AHM 2</option>
												<option value="AHM 3">AHM 3</option>
												<option value="AHM 4">AHM 4</option>
												<option value="AHM 5">AHM 5</option>
											</select>
										</div>
									</div>
									
									<div id="part_1" style="margin-top: 15px;">
										<div class="form-group">
											<input type="hidden" class="form-control" id="id_part" name="id_part[]" required>
											<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Nama Part</label>
											<div class="col-sm-5">
												<input type="text" class="form-control" id="nama_part" name="nama_part[]" placeholder="nama_part" required readonly />
											</div>
											<a class="btn btn-white icon-left" id="search_part_ahm" href="javascript:;" onclick="jQuery('#modal-1').modal('show', {backdrop: 'static'});">
												<i class="entypo-search" ></i>
											</a>
											<a class="btn btn-white icon-left" id="search_part_nonahm" href="javascript:;" onclick="jQuery('#modal-nonAhm').modal('show', {backdrop: 'static'});">
												<i class="entypo-search" ></i>
											</a>
										</div>

										<div class="form-group">
											<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Type</label>
											<div class="col-sm-5">
												<input type="text" class="form-control" id="type_part" name="type_part[]" placeholder="type" required readonly />
											</div>
										</div>

										<div class="form-group">
											<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">No.Part</label>
											<div class="col-sm-5">
												<input type="text" class="form-control" id="no_part" name="no_part[]" placeholder="no_part" required readonly />
											</div>
										</div>

										<div class="form-group" id="safety_grade">
											<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Safety Grade</label>
											<div class="col-sm-5">
												<input type="text" class="form-control" id="s_grade" name="s_grade[]" placeholder="safety_grade" required readonly />
											</div>
										</div>

										<div class="form-group">
											<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Proses</label>
											<div class="col-sm-5">
												<input type="text" class="form-control" id="proses" name="proses[]" placeholder="proses" required readonly />
											</div>
										</div>

										<div class="form-group">
											<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Customer</label>
											<div class="col-sm-5">
												<input type="text" class="form-control" id="customer" name="customer[]" placeholder="customer" required readonly />
											</div>
										</div>
										<hr>
										<div id="visual_and_nonvisual">
											<h4>Visual & Non Visual</h4>
											<p class="bs-example bs-baseline-top">
												<a class="btn btn-blue btn-block" id="btn_visual" href="javascript:;" onclick="jQuery('#modal-2').modal('show', {backdrop: 'static'}); ">VISUAL</a>
											</p>
											<p class="bs-example bs-baseline-top">
												<a class="btn btn-danger btn-block" id="btn_nonvisual" href="javascript:;" onclick="jQuery('#modal-3').modal('show', {backdrop: 'static'});">NON VISUAL</a>
											</p>
											<hr>
										</div>
										<div class="form-group">
											<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Total Claim Actual</label>
											<div class="col-sm-5">
												<input type="text" class="form-control" id="total_claim" name="total_claim[]" value="0" required readonly />
											</div>
										</div>

										<div class="form-group">
											<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Total Claim Actual Berdasarkan Surat Claim</label>
											<div class="col-sm-5">
												<input type="text" class="form-control" id="total_claim_surat" name="total_claim_surat[]" value="0" required />
											</div>
										</div>

										<div class="form-group">
											<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Status Part Claim</label>
											<div class="col-sm-5">
												<input type="text" class="form-control" id="status_part" name="status_part[]" placeholder="status_part_claim" required readonly/>
											</div>
										</div>

										<div class="panel panel-primary" id="gqi_control">
											<div class="panel-heading">
												<div class="panel-title">GQI CONTROL POINT (QTY POINT + RANK POINT)</div>
												<div class="panel-options">
													<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
													<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
													<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
													<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
												</div>
											</div>
											
											<table class="table table-bordered table-responsive" id="table-qgi-point">
												<thead>
													<tr>
														<th>HS</th>
														<th>HA</th>
														<th>HB</th>
														<th>NON</th>
														<th colspan="3"></th>
													</tr>
													<tr>
														<th>Qty Point</th>
														<th>Jumlah qty (visual)</th>
														<th>Rank Point (visual)</th>
														<th>Jumlah qty (nonvisual)</th>
														<th>Rank Point (non visual)</th>
														<th>GQI Point</th>
														<th>Card</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>
															<input type="text" class="form-control" id="qty_point" name="qty_point[]" required value="0" readonly />
														</td>
														<td>
															<input type="text" class="form-control" id="jumlah_qty_visual" name="jumlah_qty_visual[]" required value="0" readonly />
														</td>
														<td>
															<input type="text" class="form-control" id="rank_point_visual" name="rank_point_visual[]" required value="0" readonly />
														</td>
														<td>
															<input type="text" class="form-control" id="jumlah_qty_non" name="jumlah_qty_non[]" required value="0" readonly />
														</td>
														<td>
															<input type="text" class="form-control" id="rank_point_non" name="rank_point_non[]" required value="0" readonly />
														</td>
														<td>
															<input type="text" class="form-control" id="gqi_point" name="gqi_point[]" required value="#N/A" readonly />
														</td>
														<td>
															<input type="text" class="form-control" id="card" name="card[]" required value="#N/A" readonly />
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<?php $this->load->view('_partials/modal_visual_and_non.php'); ?>	
									</div>

									<div id="add_form_part"></div>

									<div class="form-group center-block pull-left" style="margin-left: 1px;">
										<button type="submit" id="tambah_part" class="btn btn-blue btn-icon icon-left col-left">
											Tambah Part
										<i class="entypo-plus-circled"></i>
										</button>
										<button type="submit" id="tambah_part_nonahm" class="btn btn-blue btn-icon icon-left col-left">
											Tambah Part
										<i class="entypo-plus-circled"></i>
										</button>
									</div>
									<div class="form-group center-block pull-right" style="margin-right: 1px;">
										<button type="submit" class="btn btn-green btn-icon icon-left col-left">
											Simpan
											<i class="entypo-check"></i>
										</button>
										<a href="<?php echo base_url('claim/customerclaim/ahm') ?>" class="btn btn-red btn-icon icon-left">
												Kembali
											<i class="entypo-cancel"></i>
										</a>
									</div>
							</form>
							
							<div id="parts_1" style="margin-top: 15px;">
								<div class="modal fade" id="modal-1">
									<div class="modal-dialog" style="width: 80%;">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title">Cari Nama Part</h4>
											</div>

											<div class="modal-body">
												<table class="table table-bordered datatable" id="table-1">
													<thead>
														<th width="1%">No.</th>
														<th>Nama Part</th>
														<th>Type</th>
														<th>No Part</th>
														<th>Safety Grade</th>
														<th>Proses</th>
														<th>Customer</th>
														<th>Aksi</th>
													</thead>
													<tbody>
														<?php
															$no = 1; 
															foreach($listpart as $data) {
																if($data->nama_customer == "AHM") {

														?>
																	<tr>
																		<td><?php echo $no; ?></td>
																		<td><?php echo $data->nama_part; ?></td>
																		<td><?php echo $data->type; ?></td>
																		<td><?php echo $data->no_sap; ?></td>
																		<td><?php echo $data->safety_grade; ?></td>
																		<td><?php echo $data->proses; ?></td>
																		<td><?php echo $data->nama_customer; ?></td>
																		<td>
																			<center>
																				<button type="button" class="btn btn-green btn-icon btn_add"  data-id="<?php echo $data->id_part; ?>" data-part="<?php echo $data->nama_part; ?>" data-type="<?php echo $data->type; ?>" data-no-part="<?php echo $data->no_sap; ?>" data-safety="<?php echo $data->safety_grade; ?>" data-proses="<?php echo $data->proses; ?>" data-customer="<?php echo $data->nama_customer; ?>" data-dismiss="modal">
																					PILIH
																					<i class="entypo-check"></i>
																				</button>
																			</center>
																		</td>
																	</tr>
														<?php
															$no += 1;
															} 
														}
														?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div id="parts_2" style="margin-top: 15px;">
								<div class="modal fade" id="modal-nonAhm">
									<div class="modal-dialog" style="width: 80%;">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title">Cari Nama Part</h4>
											</div>

											<div class="modal-body">
												<table class="table table-bordered datatable" id="table-non-ahm">
													<thead>
														<th width="1%">No.</th>
														<th>Nama Part</th>
														<th>Type</th>
														<th>No Part</th>
														<th>Safety Grade</th>
														<th>Proses</th>
														<th>Customer</th>
														<th>Aksi</th>
													</thead>
													<tbody id="data_parts_nonahm">
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div id="add_form_parts"></div>
						</div>
					</div>
				</div>
			</div>
			<?php $this->load->view('_partials/footer.php'); ?>	
		</div>
		<?php $this->load->view('_partials/lists_chat.php'); ?>
	</div>
	<?php $this->load->view('_partials/js.php'); ?>
	<?php $this->load->view('_partials/js_add_customerclaim.php'); ?>
	<?php $this->load->view('_partials/js_customer_non_ahm.php'); ?>
</body>
</html>


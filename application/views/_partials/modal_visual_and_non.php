<div class="modal fade" id="modal-2">
	<div class="modal-dialog" style="width: 90%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Pilih Visual</h4>
			</div>

			<div class="modal-body">
				<div class="row" id="spinners">
					<div class="col-md-12">
						<div class="panel panel-primary" data-collapsed="0">
							<div class="panel-heading">
								<div class="panel-title">
									Visual
								</div>
							</div>
							<div class="panel-body">
								<div class="form-group">
									<table class="table table-bordered" id="visual">
										<thead>
											<tr>
												<th style="text-align: center; width: 1%;">NO</th>
												<th style="text-align: center;">REJECTION</th>
												<th style="text-align: center;">QTY</th>
											</tr>
										</thead>
										<tbody>
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
												$id_name = ['kotor', 'lecet', 'tipis', 'meler', 'nyerep', 'opeel', 'buram', 'overcut', 'burry', 'belang', 'ngeflek',
															'minyak', 'dustray', 'cat_kelupas', 'b_air', 'f_ng', 'serat', 'd_graph', 'lifting', 'kusam', 'f_mark', 'legok',
															's_type', 'getting', 'part_campur', 'sinmark', 'gores', 'gloss', 'p_depan', 'p_belakang', 'p_kanan', 'p_kiri',
															'silver', 'b_mark', 'w_line', 'bubble', 'b_dot', 'w_dot', 'isi_tidak_set', 'gompal', 's_label', 't_cutter',
															'terbentur', 'kereta', 'terjatuh', 'terkena_gun', 's_handling', 's_steples', 's_lepas', 'keriput', 'seaming_ng',
															'nonjol', 'seal_lepas', 'cover_ng', 'b_finishing', 'foam_ng'];
												$no = 1;
												for($i = 0; $i < count($visual); $i++) {
											?>
											<tr>
												<td><?php echo $no++; ?></td>
												<td style="width: 80%; font-weight:bolder;"><?php echo $visual[$i]; ?></td>
												<td>
													<div class="input-spinner">
														<button type="button" class="btn btn-blue <?php echo $id_name[$i]; ?>">-</button>
														<input type="text" id="<?php echo $id_name[$i]; ?>" name="<?php echo $id_name[$i]; ?>" class="form-control size-1" value="0"/>
														<button type="button" class="btn btn-blue">+</button>
													</div>
												</td>
											</tr>
											<?php
												}
											?>
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

<div class="modal fade" id="modal-3">
	<div class="modal-dialog" style="width: 90%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Pilih Non-Visual</h4>
			</div>

			<div class="modal-body">
				<div class="row" id="spinners">
					<div class="col-md-12">
						<div class="panel panel-primary" data-collapsed="0">
							<div class="panel-heading">
								<div class="panel-title">
									Non Visual
								</div>
							</div>

							<div class="panel-body">
								<div class="form-group">
									<table class="table table-bordered" id="non_visual">
										<thead>
											<tr>
												<th style="text-align: center; width: 1%;">NO</th>
												<th style="text-align: center;">REJECTION</th>
												<th style="text-align: center;">QTY</th>
											</tr>
										</thead>
										<tbody>
											<?php 
												$non_visual = ['Deformasi', 'Patah / Crack', 'Part Tidak Lengkap', 'Elector Mark', 'Short Shot', 'Material Asing',
															'Pecah', 'Stay Lepas', 'Salah Ulir', 'Visual T/A', 'Ulir Ng', 'Rubber TA', 'Hole Ng'];
												$name = ['deformasi', 'patah', 'incomplete_part', 'e_mark', 'short_shot', 'material_asing', 
														'pecah', 'stay_lepas', 'salah_ulir', 'visual_ta', 'ulir_ng', 'rubber_ta', 'hole_ng'];
												$no = 1; 
												for($i = 0; $i < count($non_visual); $i++) {
											?>
											<tr>
												<td><?php echo $no++; ?></td>
												<td style="width: 80%; font-weight:bolder;"><?php echo $non_visual[$i]; ?></td>
												<td>
													<div class="input-spinner">
														<button type="button" class="btn btn-danger <?php echo $name[$i]; ?>">-</button>
														<input type="text" id="<?php echo $name[$i]; ?>" name="<?php echo $name[$i]; ?>" class="form-control size-1" value="0"/>
														<button type="button" class="btn btn-danger">+</button>
													</div>
												</td>
											</tr>
											<?php 
												}
											?>
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

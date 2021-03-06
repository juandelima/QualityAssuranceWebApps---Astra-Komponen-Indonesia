<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#tambah_part_nonahm").hide();
        let table2 = $('#table-non-ahm').DataTable({
			    "oLanguage": {
				"sSearch": "Search:",
				"oPaginate": {
					"sPrevious": "Previous",
					"sNext": "Next"
				}
			},
            "pageLength": 10,
			"lengthChange": false,
            "JQueryUI":true,
            "scrollCollapse":true,
            "initComplete": function (settings, json) {  
                $("#table-non-ahm").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
            },
		});
		
        $("#search_part_nonahm").hide();
        $("#change_customer").change((e) => {
            let customer = $(e.target).val();
            if(customer != 1) {
				$("#ahmPlant").css("display", "none");
				$("#ahm_plant").val(null);
				$("#status_form").val(customer);
                $("#safety_grade").hide();
                $("#gqi_control").hide();
                $("#search_part_ahm").hide();
                $("#search_part_nonahm").show();
                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url('masterdata/customer/getCustomer/'); ?>"+customer,
                    data: {
                        customer: customer,
                    },
                    dataType: "json",
                    success: (data) => {
                        let no = 1;
                        table2.clear().draw();
                        for(let i = 0; i < data.length; i++) {
                            let get_namaPart = data[i].nama_part.split(' ').join('-');
                            let get_Customer = data[i].nama_customer.split(' ').join('-');
                            let get_Proses = data[i].proses.split(' ').join('-');
                            let button = "<button type='button' class='btn btn-green btn-icon btn_add_nonahm' data-id="+data[i].id_part+" data-part="+get_namaPart+" data-type="+data[i].type+" data-no-part="+data[i].no_sap+" data-safety="+data[i].safety_grade+" data-proses="+get_Proses+" data-customer="+get_Customer+" data-dismiss='modal'>PILIH <i class='entypo-check'></i></button>";
                            table2.row.add([
                                ''+no+'',
                                ''+data[i].nama_part+'',
                                ''+data[i].type+'',
                                ''+data[i].no_sap+'',
                                ''+data[i].safety_grade+'',
                                ''+data[i].proses+'',
                                ''+data[i].nama_customer+'',
                                ''+button+'',
                            ]).draw(false);
                            no += 1;
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert(textStatus +" "+errorThrown)
                    },    
                });
            } else {
                $("#safety_grade").show();
                $("#gqi_control").show();
                $("#search_part_nonahm").hide();
                $("#search_part_ahm").show();
				$("#ahmPlant").css("display", "block");
            }
        });

		let loop_nonahm = 2;
        $("#tambah_part_nonahm").click((e)=> {
            e.preventDefault();
            let id_customer = $("#change_customer").val();
			// console.log(loop_nonahm);
            let html = '';
            let parts = '';
            html += 
            	'<div id="part_'+loop_nonahm+'">'+
				'<hr/>'+
				<?php
					$id_name_temp = ['kotor_visual', 'lecet_visual', 'tipis_visual', 'meler_visual', 'nyerep_visual', 'opeel_visual', 'buram_visual', 'overcut_visual', 'burry_visual', 'belang_visual', 'ngeflek_visual',
					'minyak_visual', 'dustray_visual', 'cat_kelupas_visual', 'b_air_visual', 'f_ng_visual', 'serat_visual', 'd_graph_visual', 'lifting_visual', 'kusam_visual', 'f_mark_visual', 'legok_visual',
					's_type_visual', 'getting_visual', 'part_campur_visual', 'sinmark_visual', 'gores_visual', 'gloss_visual', 'p_depan_visual', 'p_belakang_visual', 'p_kanan_visual', 'p_kiri_visual',
					'silver_visual', 'b_mark_visual', 'w_line_visual', 'bubble_visual', 'b_dot_visual', 'w_dot_visual', 'isi_tidak_set_visual', 'gompal_visual', 's_label_visual', 't_cutter_visual',
					'terbentur_visual', 'kereta_visual', 'terjatuh_visual', 'terkena_gun_visual', 's_handling_visual', 's_steples_visual', 's_lepas_visual', 'keriput_visual', 'seaming_ng_visual',
					'nonjol_visual', 'seal_lepas_visual', 'cover_ng_visual', 'b_finishing_visual', 'foam_ng_visual'];
					$name_temp = ['deformasi_non', 'patah_non', 'incomplete_part_non', 'e_mark_non', 'short_shot_non', 'material_asing_non', 
						'pecah_non', 'stay_lepas_non', 'salah_ulir_non', 'visual_ta_non', 'ulir_ng_non', 'rubber_ta_non', 'hole_ng_non'];
					for($i = 0; $i < count($id_name_temp); $i++) {
				?>
						'<input type="hidden" class="form-control" id="<?php echo $id_name_temp[$i]; ?>'+loop_nonahm+'" name="<?php echo $id_name_temp[$i]; ?>[]" value="0">'+
				<?php
					}
				?>

				<?php
					for($i = 0; $i < count($name_temp); $i++) {
				?>
						'<input type="hidden" id="<?php echo $name_temp[$i]; ?>'+loop_nonahm+'" name="<?php echo $name_temp[$i]; ?>[]" class="form-control" value="0"/>'+
				<?php
					}
				?>
				'<div class="form-group">'+
				'<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">No Lkk Qro</label>'+
				'<div class="col-sm-5">'+
				'<input type="text" class="form-control" id="no_lkk_qro_'+loop_nonahm+'" name="no_lkk_qro[]" placeholder="EKT/31/QA/ASKI/11/2019" required />'+
				'</div>'+
				'</div>'+
				
				'<div class="form-group">'+
				'<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Claim/Tukar Guling</label>'+
				'<div class="col-sm-5">'+
				'<select name="status_claim[]" id="upload_file_ppt'+loop_nonahm+'" class="form-control">'+
				'<option value="Claim">Claim</option>'+
				'<option value="Tukar Guling">Tukar Guling</option>'+
				'</select>'+
				'</div>'+
				'</div>'+

				'<div class="form-group" id="ahmPlantNon'+loop_nonahm+'">'+
				'<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">AHM Plant</label>'+
				'<div class="col-sm-5">'+
				'<select name="ahm_plant[]" id="ahm_plant'+loop_nonahm+'" class="form-control">'+
				'<option value="<?php echo null; ?>" selected>null</option>'+
				'<option value="AHM 1">AHM 1</option>'+
				'<option value="AHM 2">AHM 2</option>'+
				'<option value="AHM 3">AHM 3</option>'+
				'<option value="AHM 4">AHM 4</option>'+
				'<option value="AHM 5">AHM 5</option>'+
				'</select>'+
				'</div>'+
				'</div>'+

				'<div class="form-group">'+
				'<input type="hidden" class="form-control" id="id_part_'+loop_nonahm+'" name="id_part[]" required>'+
				'<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Nama Part</label>'+
				'<div class="col-sm-5">'+
				'<input type="text" class="form-control" id="nama_part_'+loop_nonahm+'" name="nama_part[]" placeholder="nama_part" required readonly />'+
				'</div>'+
				'<a class="btn btn-white icon-left" id="modal_parts_non_ahm_'+loop_nonahm+'">'+
				'<i class="entypo-search" ></i>'+
				'</a>'+
				'</div>'+

				'<div class="form-group">'+
				'<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Type</label>'+
				'<div class="col-sm-5">'+
				'<input type="text" class="form-control" id="type_part_'+loop_nonahm+'" name="type_part[]" placeholder="type" required readonly />'+
				'</div>'+
				'</div>'+

				'<div class="form-group">'+
				'<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">No.Part</label>'+
				'<div class="col-sm-5">'+
				'<input type="text" class="form-control" id="no_part_'+loop_nonahm+'" name="no_part[]" placeholder="no_part" required readonly />'+
				'</div>'+
				'</div>'+

				'<div class="form-group">'+
				'<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Proses</label>'+
				'<div class="col-sm-5">'+
				'<input type="text" class="form-control" id="proses_'+loop_nonahm+'" name="proses[]" placeholder="proses" required readonly />'+
				'</div>'+
				'</div>'+

				'<div class="form-group">'+
				'<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Customer</label>'+
				'<div class="col-sm-5">'+
				'<input type="text" class="form-control" id="customer_'+loop_nonahm+'" name="customer[]" placeholder="customer" required readonly />'+
				'</div>'+
				'</div>'+
				'<hr>'+
				'<div id="visual_and_nonvisual_'+loop_nonahm+'">'+
				'<h4>Visual & Non Visual</h4>'+
				'<p class="bs-example bs-baseline-top">'+
				'<a class="btn btn-blue btn-block" id="btn_visual_'+loop_nonahm+'">VISUAL</a>'+
				'</p>'+
				'<p class="bs-example bs-baseline-top">'+
				'<a class="btn btn-danger btn-block" id="btn_nonvisual_'+loop_nonahm+'">NON VISUAL</a>'+
				'</p>'+
				'<hr>'+
				'</div>'+

				'<div class="form-group">'+
				'<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Total Claim Actual</label>'+
				'<div class="col-sm-5">'+
				'<input type="text" class="form-control" id="total_claim_'+loop_nonahm+'" name="total_claim[]" value="0" required readonly />'+
				'</div>'+
				'</div>'+

				'<div class="form-group">'+
				'<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Total Claim Actual Berdasarkan Surat Claim</label>'+
				'<div class="col-sm-5">'+
				'<input type="text" class="form-control" id="total_claim_surat_'+loop_nonahm+'" name="total_claim_surat[]" value="0" required />'+
				'</div>'+
				'</div>'+

				'<div class="form-group">'+
				'<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Status Part Claim</label>'+
				'<div class="col-sm-5">'+
				'<input type="text" class="form-control" id="status_part_'+loop_nonahm+'" name="status_part[]" placeholder="status_part_claim" required readonly/>'+
				'</div>'+
				'</div>'+
				
				'<div class="panel panel-primary" id="gqi_control_noahm">'+
				'<div class="panel-heading">'+
				'<div class="panel-title">GQI CONTROL POINT (QTY POINT + RANK POINT)</div>'+
				'<div class="panel-options">'+
				'<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>'+
				'<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>'+
				'<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>'+
				'<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>'+
				'</div>'+
				'</div>'+

				'<table class="table table-bordered table-responsive">'+
				'<thead>'+
				'<tr>'+
				'<th>HS</th>'+
				'<th>HA</th>'+
				'<th>HB</th>'+
				'<th>NON</th>'+
				'<th colspan="3"></th>'+
				'</tr>'+
				'<tr>'+
				'<th>Qty Point</th>'+
				'<th>Jumlah qty (visual)</th>'+
				'<th>Rank Point (visual)</th>'+
				'<th>Jumlah qty (nonvisual)</th>'+
				'<th>Rank Point (non visual)</th>'+
				'<th>GQI Point</th>'+
				'<th>Card</th>'+
				'</tr>'+
				'</thead>'+
				'<tbody>'+
				'<tr>'+
				'<td>'+
				'<input type="text" class="form-control" id="qty_point_'+loop_nonahm+'" name="qty_point[]" required value="0" readonly />'+
				'</td>'+
				'<td>'+
				'<input type="text" class="form-control" id="jumlah_qty_visual_'+loop_nonahm+'" name="jumlah_qty_visual[]" required value="0" readonly />'+
				'</td>'+
				'<td>'+
				'<input type="text" class="form-control" id="rank_point_visual_'+loop_nonahm+'" name="rank_point_visual[]" required value="0" readonly />'+
				'</td>'+
				'<td>'+
				'<input type="text" class="form-control" id="jumlah_qty_non_'+loop_nonahm+'" name="jumlah_qty_non[]" required value="0" readonly />'+
				'</td>'+
				'<td>'+
				'<input type="text" class="form-control" id="rank_point_non_'+loop_nonahm+'" name="rank_point_non[]" required value="0" readonly />'+
				'</td>'+
				'<td>'+
				'<input type="text" class="form-control" id="gqi_point_'+loop_nonahm+'" name="gqi_point[]" required value="#N/A" readonly />'+
				'</td>'+
				'<td>'+
				'<input type="text" class="form-control" id="card_'+loop_nonahm+'" name="card[]" required value="#N/A" readonly />'+
				'</td>'+
				'</tr>'+
				'</tbody>'+
				'</table>'+
				'</div>'+

				'<div class="form-group">'+
				'<button type="button" class="btn btn-red btn-icon icon-left hapus" data-id="'+loop_nonahm+'" style="margin-left: 15px;">' +
				'Hapus' +
				'<i class="entypo-cancel"></i>' +
				'</button>' +
				'</div>'+

				'<div class="modal fade" id="modal-visual-non-ahm-'+loop_nonahm+'">'+
				'<div class="modal-dialog" style="width: 90%;">'+
				'<div class="modal-content">'+
				'<div class="modal-header">'+
				'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'+
				'<h4 class="modal-title">Pilih Visual</h4>'+
				'</div>'+
				
				'<div class="modal-body">'+
				'<div class="row" id="spinners">'+
				'<div class="col-md-12">'+
				'<div class="panel panel-primary" data-collapsed="0">'+
				'<div class="panel-heading">'+
				'<div class="panel-title">'+
				'Visual'+
				'</div>'+
				'</div>'+
				'<div class="panel-body">'+
				'<div class="form-group">'+
				'<table class="table table-bordered" id="visual-'+loop_nonahm+'">'+
				'<thead>'+
				'<tr>'+
				'<th style="text-align: center; width: 1%;">NO</th>'+
				'<th style="text-align: center;">REJECTION</th>'+
				'<th style="text-align: center;">QTY</th>'+
				'</tr>'+
				'</thead>'+
				'<tbody>'+
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
				$btn_plus = 1;
				$btn_min = 1;
				for($i = 0; $i < count($visual); $i++) {
				?>
				
				'<tr>'+
				'<td><?php echo $no++; ?></td>'+
				'<td style="width: 80%; font-weight:bolder;"><?php echo $visual[$i]; ?></td>'+
				'<td>'+
				'<div class="input-spinner">'+
				'<button type="button" id="btn_min_<?php echo $btn_min++; ?>'+loop_nonahm+'" class="btn btn-blue">-</button>'+
				'<input type="text" id="<?php echo $id_name[$i]; ?>'+loop_nonahm+'" name="<?php echo $id_name[$i]; ?>[]" class="form-control size-1" value="0"/>'+
				'<button type="button" id="btn_plus_<?php echo $btn_plus++; ?>'+loop_nonahm+'" class="btn btn-blue">+</button>'+
				'</div>'+
				'</td>'+
				'</tr>'+
				<?php
					}
				?>
				
				'</tbody>'+
				'</table>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'</div>'+

				'<div class="modal fade" id="modal-non-ahm-'+loop_nonahm+'">'+
				'<div class="modal-dialog" style="width: 90%;">'+
				'<div class="modal-content">'+
				'<div class="modal-header">'+
				'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'+
				'<h4 class="modal-title">Pilih Non-Visual</h4>'+
				'</div>'+

				'<div class="modal-body">'+
				'<div class="row" id="spinners">'+
				'<div class="col-md-12">'+
				'<div class="panel panel-primary" data-collapsed="0">'+
				'<div class="panel-heading">'+
				'<div class="panel-title">'+
				'Non Visual'+
				'</div>'+
				'</div>'+

				'<div class="panel-body">'+
				'<div class="form-group">'+
				'<table class="table table-bordered" id="non_visual_'+loop_nonahm+'">'+
				'<thead>'+
				'<tr>'+
				'<th style="text-align: center; width: 1%;">NO</th>'+
				'<th style="text-align: center;">REJECTION</th>'+
				'<th style="text-align: center;">QTY</th>'+
				'</tr>'+
				'</thead>'+
				'<tbody>'+
				<?php 
				$non_visual = ['Deformasi', 'Patah / Crack', 'Part Tidak Lengkap', 'Elector Mark', 'Short Shot', 'Material Asing',
								'Pecah', 'Stay Lepas', 'Salah Ulir', 'Visual T/A', 'Ulir Ng', 'Rubber TA', 'Hole Ng'];
				$name = ['deformasi', 'patah', 'incomplete_part', 'e_mark', 'short_shot', 'material_asing', 
						'pecah', 'stay_lepas', 'salah_ulir', 'visual_ta', 'ulir_ng', 'rubber_ta', 'hole_ng'];
				$no = 1;
				$btn_plus = 1;
				$btn_min = 1; 
				for($i = 0; $i < count($non_visual); $i++) {
				?>
				'<tr>'+
				'<td><?php echo $no++; ?></td>'+
				'<td style="width: 80%; font-weight:bolder;"><?php echo $non_visual[$i]; ?></td>'+
				'<td>'+
				'<div class="input-spinner">'+
				'<button type="button" id="btn_min_non_<?php echo $btn_min++; ?>'+loop_nonahm+'" class="btn btn-danger <?php echo $name[$i]; ?>">-</button>'+
				'<input type="text" id="<?php echo $name[$i]; ?>'+loop_nonahm+'" name="<?php echo $name[$i]; ?>[]" class="form-control size-1" value="0"/>'+
				'<button type="button" id="btn_plus_non_<?php echo $btn_plus++; ?>'+loop_nonahm+'" class="btn btn-danger">+</button>'+
				'</div>'+
				'</td>'+
				'</tr>'+
				<?php 
					}
				?>
				'</tbody>'+
				'</table>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'</div>';

                parts +=
				'<div id="parts_'+loop_nonahm+'">'+
				'<div class="modal fade modal_parts_tbl_non_ahm_'+loop_nonahm+'">'+
				'<div class="modal-dialog" style="width: 80%;">'+
				'<div class="modal-content">'+
				'<div class="modal-header">'+
				'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'+
				'<h4 class="modal-title">Cari Nama Part</h4>'+
				'</div>'+

				'<div class="modal-body">'+
				'<table class="table table-bordered datatable" id="parts_table_nonahm'+loop_nonahm+'">'+
				'<thead>'+
				'<th width="1%">No.</th>'+
				'<th>Nama Part</th>'+
				'<th>Type</th>'+
				'<th>No Part</th>'+
				'<th>Safety Grade</th>'+
				'<th>Proses</th>'+
				'<th>Customer</th>'+
				'<th>Aksi</th>'+
				'</thead>'+
				'<tbody>'+

				'</tbody>'+
				'</table>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'</div>';
                console.log(loop_nonahm);
                $("#add_form_part").append(html);
				$("#add_form_parts").append(parts);
				$("#visual_and_nonvisual_"+loop_nonahm).hide();
				$("#add_form_part").find("#gqi_control_noahm").hide();
				$("#add_form_part").find("#ahmPlantNon"+loop_nonahm).css("display", "none");
                let tableRedraw = $("#parts_table_nonahm"+loop_nonahm).DataTable({
                    "oLanguage": {
                        "sSearch": "Search:",
                        "oPaginate": {
                            "sPrevious": "Previous",
                            "sNext": "Next"
                        }
					},
					"JQueryUI":true,
           	 		"scrollCollapse":true,
					"initComplete": function (settings, json) {  
						$("#parts_table_nonahm"+loop_nonahm).wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
					},
			    });

				$("#visual-"+loop_nonahm).DataTable({
					"oLanguage": {
						"sSearch": "Search:",
						"oPaginate": {
							"sPrevious": "Previous",
							"sNext": "Next"
						}
					},
					"pageLength": 56,
					"JQueryUI":true,
           	 		"scrollCollapse":true,
					"initComplete": function (settings, json) {  
						$("#visual-"+loop_nonahm).wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
					},
				});
				$("#non_visual_"+loop_nonahm).DataTable({
					"oLanguage": {
						"sSearch": "Search:",
						"oPaginate": {
							"sPrevious": "Previous",
							"sNext": "Next"
						}
					},
					"pageLength": 56,
					"JQueryUI":true,
           	 		"scrollCollapse":true,
					"initComplete": function (settings, json) {  
						$("#non_visual_"+loop_nonahm).wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
					},
				});

                $("#add_form_part").on('click', '#modal_parts_non_ahm_'+loop_nonahm, function() {
					var loop_nonahm2 = loop_nonahm - 1;
					$.ajax({
						type: "GET",
						url: "<?php echo base_url('masterdata/customer/getCustomer/'); ?>"+id_customer,
						data: {
							customer: id_customer,
						},
						dataType: "json",
						success: (data)=> {
							let no = 1;
							let loop_nonahmRedraw = loop_nonahm - 1;
							tableRedraw.clear().draw();
							for(let i = 0; i < data.length; i++) {
								let get_namaPart = data[i].nama_part.split(' ').join('-');
								let get_Customer = data[i].nama_customer.split(' ').join('-');
								let get_Proses = data[i].proses.split(' ').join('-');
								let button = "<button type='button' class='btn btn-green btn-icon btn_add_nonahm_"+loop_nonahmRedraw+"' data-id="+data[i].id_part+" data-part="+get_namaPart+" data-type="+data[i].type+" data-no-part="+data[i].no_sap+" data-safety="+data[i].safety_grade+" data-proses="+get_Proses+" data-customer="+get_Customer+" data-dismiss='modal'>PILIH <i class='entypo-check'></i></button>";
								tableRedraw.row.add([
								''+no+'',
								''+data[i].nama_part+'',
								''+data[i].type+'',
								''+data[i].no_sap+'',
								''+data[i].safety_grade+'',
								''+data[i].proses+'',
								''+data[i].nama_customer+'',
								''+button+'',
								]).draw(false);
								no += 1;
							}
						},
						error: function(jqXHR, textStatus, errorThrown) {
							alert(textStatus +" "+errorThrown);
						},    
            		});
					$(".modal_parts_tbl_non_ahm_"+loop_nonahm2).modal('show');
				});

                $("#add_form_part").on('click', '#btn_visual_'+loop_nonahm, function() {
					var loop_nonahm_visual = loop_nonahm - 1;
					console.log(loop_nonahm_visual);
					$("#modal-visual-non-ahm-"+loop_nonahm_visual).modal('show');
				});

				$("#add_form_part").on('click', '#btn_nonvisual_'+loop_nonahm, function() {
					var loop_nonahm_non = loop_nonahm - 1;
					console.log(loop_nonahm_non);
					$("#modal-non-ahm-"+loop_nonahm_non).modal('show');
				});

                $("#total_claim_surat_"+loop_nonahm).keyup(function() {
					var value = $(this).val();
					var isNum = $.isNumeric(value);
					if($(this).val() == "" || $(this).val() <= 0 || !isNum) {
						$(this).val(0);
					} else if($(this).val() > 0) {
						$(this).val().replace(0,'');
					}

					if($(this).val()!=0) {
						var text = $(this).val();
						if(text.slice(0,1)==0) {
							$(this).val(text.slice(1,text.length));   
						}
					}
				});

                var loop_nonahm5 = loop_nonahm;
				<?php
					$merge_visual_non = array_merge($id_name, $name);
					for($i = 0; $i < count($visual); $i++) {
				?>
					$("#add_form_part").on('click', '#<?php echo $id_name[$i] ?>'+loop_nonahm5+'', function() {
						var loop_nonahm_copy = loop_nonahm - 1;
						var selectedText = getSelectedText($('#<?php echo $id_name[$i] ?>'+loop_nonahm_copy+'')[0]);
							if(getSelectedText($('#<?php echo $id_name[$i] ?>'+loop_nonahm_copy+'')[0]) != '') {
								copyToClipboard(selectedText);
							} else {
								$('#<?php echo $id_name[$i] ?>'+loop_nonahm_copy+'').focus().select();
							}
							document.execCommand('copy');
					});

					$("#add_form_part").find("#btn_min_<?php echo $i+1; ?>"+loop_nonahm5).attr("disabled", true);
					$("#add_form_part").find("#btn_plus_<?php echo $i+1; ?>"+loop_nonahm5).click(function add() {
						var loop_nonahm6 = loop_nonahm - 1;
						$("#add_form_part").find("#btn_min_<?php echo $i+1; ?>"+loop_nonahm6).attr("disabled", false);
						var $field_<?php echo $i+1; ?> = $("#<?php echo $id_name[$i] ?>"+loop_nonahm6);
						var a_<?php echo $i+1; ?> = $field_<?php echo $i+1; ?>.val();

						a_<?php echo $i+1; ?>++;
						$field_<?php echo $i+1; ?>.val(a_<?php echo $i+1; ?>);
						multiformCalculate();
					});
					
					$("#add_form_part").find("#btn_min_<?php echo $i+1; ?>"+loop_nonahm5).click(function subst() {
						var loop_nonahm7 = loop_nonahm - 1;
						var $field2_<?php echo $i+1; ?> = $("#<?php echo $id_name[$i] ?>"+loop_nonahm7);
						var b_<?php echo $i+1; ?> = $field2_<?php echo $i+1; ?>.val();
						if(b_<?php echo $i+1; ?> > 1) {
							b_<?php echo $i+1; ?>--;
							$field2_<?php echo $i+1; ?>.val(b_<?php echo $i+1; ?>);
							multiformCalculate();
						} else {
							b_<?php echo $i+1; ?>--;
							$field2_<?php echo $i+1; ?>.val(b_<?php echo $i+1; ?>);
							multiformCalculate();
							$("#add_form_part").find("#btn_min_<?php echo $i+1; ?>"+loop_nonahm7).attr("disabled", true);
						}
					});
				<?php 
					} 
				?>

                <?php
					for($j = 0; $j < count($non_visual); $j++) {
				?>

					$("#add_form_part").on('click', '#<?php echo $name[$j] ?>'+loop_nonahm5+'', function() {
						var loop_nonahm_copy_non = loop_nonahm - 1;
						var selectedText = getSelectedText($('#<?php echo $name[$j] ?>'+loop_nonahm_copy_non+'')[0]);
							if(getSelectedText($('#<?php echo $name[$j] ?>'+loop_nonahm_copy_non+'')[0]) != '') {
								copyToClipboard(selectedText);
							} else {
								$('#<?php echo $name[$j] ?>'+loop_nonahm_copy_non+'').focus().select();
							}
							document.execCommand('copy');
					});

					$("#add_form_part").find("#btn_min_non_<?php echo $j+1; ?>"+loop_nonahm5).attr("disabled", true);
					$("#add_form_part").find("#btn_plus_non_<?php echo $j+1; ?>"+loop_nonahm5).click(function add() {
						var loop_nonahm8 = loop_nonahm - 1;
						$("#add_form_part").find("#btn_min_non_<?php echo $j+1; ?>"+loop_nonahm8).attr("disabled", false);
						var $field_non<?php echo $j+1; ?> = $("#<?php echo $name[$j] ?>"+loop_nonahm8);
						var c_<?php echo $j+1; ?> = $field_non<?php echo $j+1; ?>.val();
						c_<?php echo $j+1; ?>++;
						$field_non<?php echo $j+1; ?>.val(c_<?php echo $j+1; ?>);
						multiformCalculate();
					});

					$("#add_form_part").find("#btn_min_non_<?php echo $j+1; ?>"+loop_nonahm5).click(function subst() {
						var loop_nonahm9 = loop_nonahm - 1;
						var $field2_non<?php echo $j+1; ?> = $("#<?php echo $name[$j] ?>"+loop_nonahm9);
						var d_<?php echo $j+1; ?> = $field2_non<?php echo $j+1; ?>.val();
						if(d_<?php echo $j+1; ?> > 1) {
							d_<?php echo $j+1; ?>--;
							$field2_non<?php echo $j+1; ?>.val(d_<?php echo $j+1; ?>);
							multiformCalculate();
						} else {
							d_<?php echo $j+1; ?>--;
							$field2_non<?php echo $j+1; ?>.val(d_<?php echo $j+1; ?>);
							multiformCalculate();
							$("#add_form_part").find("#btn_min_non_<?php echo $j+1; ?>"+loop_nonahm9).attr("disabled", true);
						}
					});
				<?php
				}
				?>

                $("#add_form_part").find(".input-spinner").find('[type="text"]').keyup(function() {
					var value = $(this).val();
					var isNum = $.isNumeric(value);
					if($(this).val() == "" || $(this).val() <= 0 || !isNum) {
						$(this).val(0);
					} else if($(this).val() > 0) {
						$(this).val().replace(0,'');
					}

					if($(this).val()!=0) {
						var text = $(this).val();
						if(text.slice(0,1)==0) {
							$(this).val(text.slice(1,text.length));   
						}
					}
				});

                // KEYUP VISUAL
				<?php
					for($i = 0; $i < count($id_name); $i++) {
				?>
						$("#add_form_part").on('keydown keyup', '#<?php echo $id_name[$i]; ?>'+loop_nonahm5+'', function() {
							var loop_nonahm10 = loop_nonahm - 1;
							if($(this).val() > 0) {
								$("#add_form_part").find("#btn_min_<?php echo $i+1; ?>"+loop_nonahm10).attr("disabled", false);
								multiformCalculate();
							} else {
								$("#add_form_part").find("#btn_min_<?php echo $i+1; ?>"+loop_nonahm10).attr("disabled", true);
								multiformCalculate();
							}
						});
				<?php
					}
				?>

				// KEYUP NON VISUAL
				<?php
					for($i = 0; $i < count($name); $i++) {
				?>
						$("#add_form_part").on('keydown keyup', '#<?php echo $name[$i]; ?>'+loop_nonahm5+'', function() {
							var loop_nonahm11 = loop_nonahm - 1;
							if($(this).val() > 0) {
								$("#add_form_part").find("#btn_min_non_<?php echo $i+1; ?>"+loop_nonahm11).attr("disabled", false);
								multiformCalculate();
							} else {
								$("#add_form_part").find("#btn_min_non_<?php echo $i+1; ?>"+loop_nonahm11).attr("disabled", true);
								multiformCalculate();
							}
						});
				<?php
					}
				?>

                <?php
					foreach($merge_visual_non as $data_field) {
				?>
					var keep_value_<?php echo $data_field; ?> = 0;
				<?php
					}
				?>

                function multiformCalculate() {
					var loop_nonahm12 = loop_nonahm -1 ;
					<?php
						foreach($merge_visual_non as $field_visual_non) {
					?>
						var <?php echo $field_visual_non; ?> = $("#<?php echo $field_visual_non; ?>"+loop_nonahm12).val();
					<?php
						}
					?>

					<?php
						foreach($id_name as $data_field_visual) {
					?>
							if(<?php echo $data_field_visual; ?> > 0) {
								keep_value_<?php echo $data_field_visual; ?> = <?php echo $data_field_visual; ?>;
								$("#<?php echo $data_field_visual; ?>_visual"+loop_nonahm12).val(keep_value_<?php echo $data_field_visual; ?>);
							}
					<?php
						}
					?>

					<?php
						foreach($name as $data_field_non) {
					?>
							if(<?php echo $data_field_non; ?> > 0) {
								keep_value_<?php echo $data_field_non; ?> = <?php echo $data_field_non; ?>;
								$("#<?php echo $data_field_non; ?>_non"+loop_nonahm12).val(keep_value_<?php echo $data_field_non; ?>);
							}
					<?php 
						}
					?>

					<?php
						foreach($merge_visual_non as $data_field) {
					?>
							if(isNaN(<?php echo $data_field; ?>)) {
								<?php echo $data_field; ?> = 0;
								if(keep_value_<?php echo $data_field; ?> > 0) {
									<?php echo $data_field; ?> = keep_value_<?php echo $data_field; ?>;
								}
							}
					<?php
						}
					?>

					var total_claim = parseInt(kotor) + parseInt(lecet) + 
								parseInt(tipis) + parseInt(meler) + 
								parseInt(nyerep) + parseInt(opeel) + 
								parseInt(buram) + parseInt(overcut) +
								parseInt(burry) + parseInt(belang) +
								parseInt(ngeflek) + parseInt(minyak) +
								parseInt(dustray) + parseInt(cat_kelupas) +
								parseInt(b_air) + parseInt(f_ng) +
								parseInt(serat) + parseInt(d_graph) +
								parseInt(lifting) + parseInt(kusam) +
								parseInt(f_mark) + parseInt(legok) +
								parseInt(s_type) + parseInt(getting) +
								parseInt(part_campur) + parseInt(sinmark) +
								parseInt(gores) + parseInt(gloss) +
								parseInt(p_depan) + parseInt(p_belakang) +
								parseInt(p_kanan) + parseInt(p_kiri) +
								parseInt(silver) + parseInt(b_mark) +
								parseInt(w_line) + parseInt(bubble) +
								parseInt(b_dot) + parseInt(w_dot) +
								parseInt(isi_tidak_set) + parseInt(gompal) +
								parseInt(s_label) + parseInt(t_cutter) +
								parseInt(terbentur) + parseInt(kereta) +
								parseInt(terjatuh) + parseInt(terkena_gun) +
								parseInt(s_handling) + parseInt(s_steples) +
								parseInt(s_lepas) + parseInt(keriput) +
								parseInt(seaming_ng) + parseInt(nonjol) +
								parseInt(seal_lepas) + parseInt(cover_ng) +
								parseInt(b_finishing) + parseInt(foam_ng) +
								parseInt(deformasi) + parseInt(patah) +
								parseInt(incomplete_part) + parseInt(e_mark) +
								parseInt(short_shot) + parseInt(material_asing) +
								parseInt(pecah) + parseInt(stay_lepas) +
								parseInt(salah_ulir) + parseInt(visual_ta) +
								parseInt(ulir_ng) + parseInt(rubber_ta) + parseInt(hole_ng);
					
					var jumlah_visual = parseInt(kotor) + parseInt(lecet) + 
								parseInt(tipis) + parseInt(meler) + 
								parseInt(nyerep) + parseInt(opeel) + 
								parseInt(buram) + parseInt(overcut) +
								parseInt(burry) + parseInt(belang) +
								parseInt(ngeflek) + parseInt(minyak) +
								parseInt(dustray) + parseInt(cat_kelupas) +
								parseInt(b_air) + parseInt(f_ng) +
								parseInt(serat) + parseInt(d_graph) +
								parseInt(lifting) + parseInt(kusam) +
								parseInt(f_mark) + parseInt(legok) +
								parseInt(s_type) + parseInt(getting) +
								parseInt(part_campur) + parseInt(sinmark) +
								parseInt(gores) + parseInt(gloss) +
								parseInt(p_depan) + parseInt(p_belakang) +
								parseInt(p_kanan) + parseInt(p_kiri) +
								parseInt(silver) + parseInt(b_mark) +
								parseInt(w_line) + parseInt(bubble) +
								parseInt(b_dot) + parseInt(w_dot) +
								parseInt(isi_tidak_set) + parseInt(gompal) +
								parseInt(s_label) + parseInt(t_cutter) +
								parseInt(terbentur) + parseInt(kereta) +
								parseInt(terjatuh) + parseInt(terkena_gun) +
								parseInt(s_handling) + parseInt(s_steples) +
								parseInt(s_lepas) + parseInt(keriput) +
								parseInt(seaming_ng) + parseInt(nonjol) +
								parseInt(seal_lepas) + parseInt(cover_ng) +
								parseInt(b_finishing) + parseInt(foam_ng);

					var jumlah_non_visual = parseInt(deformasi) + parseInt(patah) +
								parseInt(incomplete_part) + parseInt(e_mark) +
								parseInt(short_shot) + parseInt(material_asing) +
								parseInt(pecah) + parseInt(stay_lepas) +
								parseInt(salah_ulir) + parseInt(visual_ta) +
								parseInt(ulir_ng) + parseInt(rubber_ta) + parseInt(hole_ng);

				if(!isNaN(total_claim)) {
					$("#total_claim_"+loop_nonahm12).val(total_claim);
					$("#total_claim_surat_"+loop_nonahm12).val(total_claim);
					var total_claim = $("#total_claim_"+loop_nonahm12).val();
					var total_claim_surat = $("#total_claim_surat_"+loop_nonahm12).val();
					if(total_claim == total_claim_surat) {
						$("#status_part_"+loop_nonahm12).val("RECEIVED");
					}
				} 
			}

            function compare() {
				var loop_nonahm13 = loop_nonahm - 1;
				var t_claim = $("#total_claim_"+loop_nonahm13).val();
				var claim_surat = $("#total_claim_surat_"+loop_nonahm13).val();
				if(t_claim == claim_surat) {
					$("#status_part_"+loop_nonahm13).val("RECEIVED");
				} else {
					$("#status_part_"+loop_nonahm13).val("REJECTED");
				}
			}
                

            $("#parts_table_nonahm"+loop_nonahm).on('click', ".btn_add_nonahm_"+loop_nonahm, function() {
                let nama_part_loop_nonahm = $(this).data('part');
                let customer_loop_nonahm = $(this).data('customer');
                let proses_loop_nonahm = $(this).data('proses');
                let split_nama_part_loop_nonahm = nama_part_loop_nonahm.split('-').join(' ');
                let split_customer_loop_nonahm = customer_loop_nonahm.split('-').join(' ');
                let split_proses_loop_nonahm = proses_loop_nonahm.split('-').join(' ');
				let loop_nonahm3 = loop_nonahm - 1;
				console.log(loop_nonahm3);
				$("#id_part_"+loop_nonahm3).val($(this).data('id'));
				$("#nama_part_"+loop_nonahm3).val(split_nama_part_loop_nonahm);
				$("#type_part_"+loop_nonahm3).val($(this).data('type'));
				$("#no_part_"+loop_nonahm3).val($(this).data('no-part'));
				$("#s_grade_"+loop_nonahm3).val($(this).data('safety'));
				$("#proses_"+loop_nonahm3).val(split_proses_loop_nonahm);
				$("#customer_"+loop_nonahm3).val(split_customer_loop_nonahm);
                $("#visual_and_nonvisual_"+loop_nonahm3).show();
                $("#total_claim_surat_"+loop_nonahm3).prop("readonly", false);
                $("#tambah_part_nonahm").show();
            });
			
            $("#total_claim_surat_"+loop_nonahm).on("keydown keyup", function() {
				compare();
			});	
            $("#tambah_part_nonahm").hide();
			loop_nonahm++;
        });

        $('.datatable').on('click', '.btn_add_nonahm', function() {
			let nama_part = $(this).data('part');
			let customer = $(this).data('customer');
			let proses = $(this).data('proses');
			let split_nama_part = nama_part.split('-').join(' ');
			let split_customer = customer.split('-').join(' ');
			let split_proses = proses.split('-').join(' ');
			$("#id_part").val($(this).data('id'));
			$("#nama_part").val(split_nama_part);
			$("#type_part").val($(this).data('type'));
			$("#no_part").val($(this).data('no-part'));
			$("#s_grade").val($(this).data('safety'));
			$("#proses").val(split_proses);
			$("#customer").val(split_customer);
			$("#visual_and_nonvisual").show();
			$("#total_claim_surat").prop("readonly", false);
            $("#tambah_part_nonahm").show();
		});

		function compare() {
			var t_claim = $("#total_claim").val();
			var claim_surat = $("#total_claim_surat").val();
			if(t_claim == claim_surat) {
				$("#status_part").val("RECEIVED");
			} else {
				$("#status_part").val("REJECTED");
			}	
		}

		$("#total_claim_surat").on("keydown keyup", function() {
			compare();
		});
    });
</script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		<?php
			$id_name_json = ['kotor', 'lecet', 'tipis', 'meler', 'nyerep', 'opeel', 'buram', 'overcut', 'burry', 'belang', 'ngeflek',
			'minyak', 'dustray', 'cat_kelupas', 'b_air', 'f_ng', 'serat', 'd_graph', 'lifting', 'kusam', 'f_mark', 'legok',
			's_type', 'getting', 'part_campur', 'sinmark', 'gores', 'gloss', 'p_depan', 'p_belakang', 'p_kanan', 'p_kiri',
			'silver', 'b_mark', 'w_line', 'bubble', 'b_dot', 'w_dot', 'isi_tidak_set', 'gompal', 's_label', 't_cutter',
			'terbentur', 'kereta', 'terjatuh', 'terkena_gun', 's_handling', 's_steples', 's_lepas', 'keriput', 'seaming_ng',
			'nonjol', 'seal_lepas', 'cover_ng', 'b_finishing', 'foam_ng'];
			$name_json = ['deformasi', 'patah', 'incomplete_part', 'e_mark', 'short_shot', 'material_asing', 
			'pecah', 'stay_lepas', 'salah_ulir', 'visual_ta', 'ulir_ng', 'rubber_ta', 'hole_ng'];
			$merge_visual_non_json = array_merge($id_name_json, $name_json);
		?>
		$("#tambah_part_nonahm").hide();
		$("#search_part_nonahm").hide();

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

		$("#change_customer").change((e) => {
            let customer = $(e.target).val();
			
            if(customer != 1) {
				$("#tambah_part").css("display", "none");
				$("#tambah_part_nonahm").css("display", "block");
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
                            let button = "<button type='button' class='btn btn-green btn-icon btn_add_nonahm_' data-id="+data[i].id_part+" data-part="+get_namaPart+" data-type="+data[i].type+" data-no-part="+data[i].no_sap+" data-safety="+data[i].safety_grade+" data-proses="+get_Proses+" data-customer="+get_Customer+" data-dismiss='modal'>PILIH <i class='entypo-check'></i></button>";
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
				$("#tambah_part").css("display", "block");
				$("#tambah_part_nonahm").css("display", "hide");
            }
        });

		$("#total_claim_surat").keyup(function() {
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

		$(".input-spinner").find('[type="text"]').keyup(function() {
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

		block_text();
		function block_text() {
			$("#add_form_part").on('click', '#total_claim_surat', function() {
				var selectedText = getSelectedText($('#total_claim_surat')[0]);
				if(getSelectedText($('#total_claim_surat')[0]) != '') {
					copyToClipboard(selectedText);
				} else {
					$('#total_claim_surat').focus().select();
				}
				  
				document.execCommand('copy');
			});

			$("#total_claim_surat").click(function() {
				var selectedText = getSelectedText($('#total_claim_surat')[0]);
				if(getSelectedText($('#total_claim_surat')[0]) != '') {
					copyToClipboard(selectedText);
				} else {
					$('#total_claim_surat').focus().select();
				}
				  
				document.execCommand('copy');
			});

			<?php
				foreach($merge_visual_non_json as $data_field) {
			?>
				$("#<?php echo $data_field; ?>").click(function() {
						var selectedText = getSelectedText($('#<?php echo $data_field; ?>')[0]);
						if(getSelectedText($('#<?php echo $data_field; ?>')[0]) != '') {
							copyToClipboard(selectedText);
						} else {
							$('#<?php echo $data_field; ?>').focus().select();
						}
						
						document.execCommand('copy');
					});
			<?php
				}
			?>
		}

		function getSelectedText(e) {
    		var text   = "",
        	start  = e.selectionStart,
        	finish = e.selectionEnd;
    		text   = e.value.substring(start, finish);
    		return text;
		}

		function copyToClipboard(text){
			var et = $('<input/>',{
       			css:{ opacity: '0' }
    		});
    		$('body').append(et);
    		$(et)[0].value = text;
    		$(et).focus().select();
    		document.execCommand('copy');
    		$(et).remove();
		}

		$("#visual_and_nonvisual").hide();
		$("#total_claim_surat").prop("readonly", true);
		calculate();

		$("input[type=text]").keyup(function() {
			$(this).val($(this).val().toUpperCase());
		});

		<?php
			foreach($merge_visual_non_json as $data_field) {
		?>
				var keep_value_<?php echo $data_field; ?> = 0;
		<?php
			}
		?>

		<?php
			foreach($merge_visual_non_json as $data_field) {
		?>
				$(".<?php echo $data_field; ?>").attr("disabled", true);
		<?php
			}
		?>

		$('.datatable').on('click', '.btn_add_nonahm_', function() {
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
			var jumlah_qty_non = $("#jumlah_qty_non").val();
			var s_grade = $("#s_grade").val();
			if(s_grade === 'NON') {
				$("#rank_point_non").val('FALSE');
			} else if(s_grade === '#N/A') {
				$("#rank_point_non").val('#N/A');
			} else {
				if(s_grade === 'HS') {
					if(jumlah_qty_non > 0) {
						$("#rank_point_non").val(100);
					}
				} else if(s_grade === 'HA') {
					if(jumlah_qty_non > 0) {
						$("#rank_point_non").val(100);
					}
				} else if(s_grade === 'HB') {
					if(jumlah_qty_non > 0) {
						$("#rank_point_non").val(20);
					}
				} else if(s_grade === 'NON') {
					if(jumlah_qty_non > 0) {
						$("#rank_point_non").val(4);
					}
				} else {
					if(jumlah_qty_non <= 0) {
						$("#rank_point_non").val(0);
					}
				}
			}

			var qty_point = $("#qty_point").val();
			var rank_visual = $("#rank_point_visual").val();
			var rank_non = $("#rank_point_non").val();
			if(rank_non === 'FALSE') {
				var calculate = parseInt(qty_point) + parseInt(rank_visual);
				$("#gqi_point").val(calculate);
			} else if(rank_non === '#N/A') {
				$("#gqi_point").val('#N/A');
			} else {
				var calculate = parseInt(qty_point) + parseInt(rank_visual) + parseInt(rank_non);
				$("#gqi_point").val(calculate);
			}

			var gqi_point = $("#gqi_point").val();
			if(gqi_point > 114) {
				$("#card").css('background-color', '#ff0000').val('Red Card');
				$("#card").css('color', '#ffffff');
			} else if(gqi_point > 100) {
				$("#card").css('background-color', '#ffd800').val('Yellow Card');
				$("#card").css('color', '#222831');
			} else if(gqi_point > 0) {
				$("#card").css('background-color', '#42b883').val('Green Card');
				$("#card").css('color', '#ffffff');
			} else {
				$("#card").css('background-color', '#eeeeee').val('#N/A');
				$("#card").css('color', '#222831');
			}

			$("#visual_and_nonvisual").show();
			$("#total_claim_surat").prop("readonly", false);
		});

		function calculate() {
			<?php
				foreach($merge_visual_non_json as $data_field) {
			?>
					var <?php echo $data_field ?> = $("#<?php echo $data_field; ?>").val();
			<?php
				}
			?>


			<?php
				foreach($id_name_json as $data_field_visual) {
			?>
					if(<?php echo $data_field_visual; ?> > 0) {
						keep_value_<?php echo $data_field_visual; ?> = <?php echo $data_field_visual; ?>;
						$("#<?php echo $data_field_visual; ?>_visual").val(keep_value_<?php echo $data_field_visual; ?>);
						$(".<?php echo $data_field_visual; ?>").attr("disabled", false);
					} else {
						$(".<?php echo $data_field_visual; ?>").attr("disabled", true);
					}
			<?php
				}
			?>


			<?php
				foreach($name_json as $data_field_non) {
			?>
					if(<?php echo $data_field_non; ?> > 0) {
						keep_value_<?php echo $data_field_non; ?> = <?php echo $data_field_non; ?>;
						$("#<?php echo $data_field_non; ?>_non").val(keep_value_<?php echo $data_field_non; ?>);
						$(".<?php echo $data_field_non; ?>").attr("disabled", false);
					} else {
						$(".<?php echo $data_field_non; ?>").attr("disabled", true);
					}
			<?php 
				}
			?>


			<?php
				foreach($merge_visual_non_json as $data_field) {
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
				$("#total_claim").val(total_claim);
				$("#total_claim_surat").val(total_claim);
				var total_claim = $("#total_claim").val();
				var total_claim_surat = $("#total_claim_surat").val();
				if(total_claim == total_claim_surat) {
					$("#status_part").val("RECEIVED");
				}
					
				calculate_qty_point(total_claim_surat);
			}

			if(!isNaN(jumlah_visual)) {
				$("#jumlah_qty_visual").val(jumlah_visual);
				if(jumlah_visual > 0) {
					$("#rank_point_visual").val(4);
				} else {
					$("#rank_point_visual").val(0);
				}
			}

			if(!isNaN(jumlah_non_visual)) {
				$("#jumlah_qty_non").val(jumlah_non_visual);
				var s_grade = $("#s_grade").val();
				if(s_grade === 'NON') {
					$("#rank_point_non").val('FALSE');
				} else if(s_grade === '#N/A') {
					$("#rank_point_non").val('#N/A');
				} else {
					if(s_grade === 'HS') {
						if(jumlah_non_visual > 0) {
							$("#rank_point_non").val(100);
						}
					} else if(s_grade === 'HA') {
						if(jumlah_non_visual > 0) {
							$("#rank_point_non").val(100);
						}
					} else if(s_grade === 'HB') {
						if(jumlah_non_visual > 0) {
							$("#rank_point_non").val(20);
						}
					} else if(s_grade === 'NON') {
						if(jumlah_non_visual > 0) {
							$("#rank_point_non").val(4);
						}
					} else {
						if(jumlah_non_visual <= 0) {
							$("#rank_point_non").val(0);
						}
					}
				}
			}

			var qty_point = $("#qty_point").val();
			var rank_visual = $("#rank_point_visual").val();
			var rank_non = $("#rank_point_non").val();
			if(rank_non === 'FALSE') {
				var calculate = parseInt(qty_point) + parseInt(rank_visual);
				$("#gqi_point").val(calculate);
			} else if(rank_non === '#N/A') {
				$("#gqi_point").val('#N/A');
			} else {
				var calculate = parseInt(qty_point) + parseInt(rank_visual) + parseInt(rank_non);
				$("#gqi_point").val(calculate);
			}

			var gqi_point = $("#gqi_point").val();
			if(gqi_point > 114) {
				$("#card").css('background-color', '#ff0000').val('Red Card');
				$("#card").css('color', '#ffffff');
			} else if(gqi_point > 100) {
				$("#card").css('background-color', '#ffd800').val('Yellow Card');
				$("#card").css('color', '#222831');
			} else if(gqi_point > 0) {
				$("#card").css('background-color', '#42b883').val('Green Card');
				$("#card").css('color', '#ffffff');
			} else {
				$("#card").css('background-color', '#eeeeee').val('#N/A');
				$("#card").css('color', '#222831');
			}
		}

		function compare() {
			var t_claim = $("#total_claim").val();
			var claim_surat = $("#total_claim_surat").val();
			if(t_claim == claim_surat) {
				$("#status_part").val("RECEIVED");
			} else {
				$("#status_part").val("REJECTED");
			}	
		}

		function calculate_qty_point(total_claim_surat) {
			var clt = 0;
			if(total_claim_surat > 499) {
				clt = 115;
			} else if(total_claim_surat > 299) {
				clt = 70;
			} else if(total_claim_surat > 199) {
				clt = 50;
			} else if(total_claim_surat > 1) {
				clt = 10;
			} else if(total_claim_surat > 0) {
				clt = 2;
			} else {
				if(total_claim_surat <= 0) {
					clt = 0;
				}
			}

			$("#qty_point").val(clt);
		}

		$("#kotor, #lecet, #tipis, #meler, #nyerep, #opeel, #buram, #overcut, #burry, #belang,"+
			"#ngeflek, #minyak, #dustray, #cat_kelupas, #b_air, #f_ng, #serat, #d_graph, #lifting,"+
			"#kusam, #f_mark, #legok, #s_type, #getting, #part_campur, #sinmark, #gores, #gloss,"+
			"#p_depan, #p_belakang, #p_kiri, #p_kanan, #silver, #b_mark, #w_line, #bubble, #b_dot, #w_dot,"+
			"#isi_tidak_set, #gompal, #s_label, #t_cutter, #terbentur, #kereta, #terjatuh, #terkena_gun, #s_handling,"+
			"#s_steples, #s_lepas, #keriput, #seaming_ng, #nonjol, #seal_lepas, #cover_ng, #b_finishing, #foam_ng,"+
			"#deformasi, #short_shot, #patah, #incomplete_part, #e_mark, #material_asing, #pecah, #stay_lepas,"+
			"#salah_ulir, #visual_ta, #ulir_ng, #rubber_ta, #hole_ng").on("keydown keyup", function() {
			calculate();
		});

		$("#total_claim_surat").on("keydown keyup", function() {
			compare();
		});

		let loop_non_ahm = 2;
		$("#tambah_part_nonahm").click((e) => {
			e.preventDefault();
			let id_customer = $("#change_customer").val();
			let html = '';
			let parts = '';
			html += `
				<div id="part_${loop_non_ahm}">
					<hr/>
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
							<input type="hidden" class="form-control" id="<?php echo $id_name_temp[$i]; ?>_${loop_non_ahm}" name="<?php echo $id_name_temp[$i]; ?>[]" value="0">
					<?php
						}
					?>

					<?php
						for($i = 0; $i < count($name_temp); $i++) {
					?>
							<input type="hidden" id="<?php echo $name_temp[$i]; ?>_${loop_non_ahm}" name="<?php echo $name_temp[$i]; ?>[]" class="form-control" value="0"/>
					<?php
						}
					?>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">No Lkk Qro</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="no_lkk_qro_${loop_non_ahm}" name="no_lkk_qro[]" placeholder="EKT/31/QA/ASKI/11/2019" required />
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Claim/Tukar Guling</label>
						<div class="col-sm-5">
							<select name="status_claim[]" id="status_claim_${loop_non_ahm}" class="form-control">
								<option value="Claim">Claim</option>
								<option value="Tukar Guling">Tukar Guling</option>
							</select>
						</div>
					</div>

					<div class="form-group" id="ahmPlantNon_${loop_non_ahm}">
						<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">AHM Plant</label>
						<div class="col-sm-5">
							<select name="ahm_plant[]" id="ahm_plant_${loop_non_ahm}" class="form-control">
								<option value="<?php echo null; ?>" selected>null</option>
								<option value="AHM 1">AHM 1</option>
								<option value="AHM 2">AHM 2</option>
								<option value="AHM 3">AHM 3</option>
								<option value="AHM 4">AHM 4</option>
								<option value="AHM 5">AHM 5</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<input type="hidden" class="form-control" id="id_part_${loop_non_ahm}" name="id_part[]" required>
						<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Nama Part</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="nama_part_${loop_non_ahm}" name="nama_part[]" placeholder="nama_part" required readonly />
						</div>

						<a class="btn btn-white icon-left" id="modal_parts_${loop_non_ahm}">
							<i class="entypo-search" ></i>
						</a>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Type</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="type_part_${loop_non_ahm}" name="type_part[]" placeholder="type" required readonly />
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">No.Part</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="no_part_${loop_non_ahm}" name="no_part[]" placeholder="no_part" required readonly />
						</div>
					</div>
					

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Proses</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="proses_${loop_non_ahm}" name="proses[]" placeholder="proses" required readonly />
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Customer</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="customer_${loop_non_ahm}" name="customer[]" placeholder="customer" required readonly />
						</div>
					</div>

					<hr>

					<div id="visual_and_nonvisual_non_ahm_${loop_non_ahm}">
						<h4>Visual & Non Visual</h4>
						<p class="bs-example bs-baseline-top">
							<a class="btn btn-blue btn-block" id="btn_visual_${loop_non_ahm}">VISUAL</a>
						</p>

						<p class="bs-example bs-baseline-top">
							<a class="btn btn-danger btn-block" id="btn_nonvisual_${loop_non_ahm}">NON VISUAL</a>
						</p>
						<hr>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Total Claim Actual</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="total_claim_${loop_non_ahm}" name="total_claim[]" value="0" required readonly />
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Total Claim Actual Berdasarkan Surat Claim</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="total_claim_surat_${loop_non_ahm}" name="total_claim_surat[]" value="0" required />
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">Status Part Claim</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="status_part_${loop_non_ahm}" name="status_part[]" placeholder="status_part_claim" value="RECEIVED" required readonly/>
						</div>
					</div>
					
					<div class="panel panel-primary non_ahm_gqi_control">
						<div class="panel-heading">
							<div class="panel-title">GQI CONTROL POINT (QTY POINT + RANK POINT)</div>
						<div class="panel-options">
							<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
							<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
							<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
							<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
						</div>

						<table class="table table-bordered table-responsive" id="table-qgi-point_non_ahm_${loop_non_ahm}">
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
										<input type="text" class="form-control" id="qty_point_${loop_non_ahm}" name="qty_point[]" required value="0" readonly />
									</td>
									<td>
										<input type="text" class="form-control" id="jumlah_qty_visual_${loop_non_ahm}" name="jumlah_qty_visual[]" required value="0" readonly />
									</td>
									<td>
										<input type="text" class="form-control" id="rank_point_visual_${loop_non_ahm}" name="rank_point_visual[]" required value="0" readonly />
									</td>
									<td>
										<input type="text" class="form-control" id="jumlah_qty_non_${loop_non_ahm}" name="jumlah_qty_non[]" required value="0" readonly />
									</td>
									<td>
										<input type="text" class="form-control" id="rank_point_non_${loop_non_ahm}" name="rank_point_non[]" required value="0" readonly />
									</td>
									<td>
										<input type="text" class="form-control" id="gqi_point_${loop_non_ahm}" name="gqi_point[]" required value="#N/A" readonly />
									</td>
									<td>
										<input type="text" class="form-control" id="card_${loop_non_ahm}" name="card[]" required value="#N/A" readonly />
									</td>
								</tr>
							</tbody>
						</table>
					</div>

					<br/>
					<div class="form-group" style="margin-left: 2px;">
						<button type="button" class="btn btn-red btn-icon icon-left" id="hapus_non_${loop_non_ahm}" style="margin-left: 15px;">
							Hapus
							<i class="entypo-cancel"></i>
						</button>
					</div>
					
					<div class="modal fade" id="tai-dah-${loop_non_ahm}">
						<div class="modal-dialog" style="width: 90%;">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title">Tai</h4>
								</div>

								<div class="modal-body">

								</div>
							</div>
						</div>
					</div>

					<div class="modal fade" id="modal-visual-${loop_non_ahm}">
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
														<table class="table table-bordered" id="visual-${loop_non_ahm}">
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
																	$btn_plus = 1;
																	$btn_min = 1;
																	for($i = 0; $i < count($visual); $i++) {
																?>
																<tr>
																	<td><?php echo $no++; ?></td>
																	<td style="width: 80%; font-weight:bolder;"><?php echo $visual[$i]; ?></td>
																	<td>
																		<div class="input-spinner">
																			<button type="button" id="btn_min_<?php echo $btn_min++; ?>_${loop_non_ahm}" class="btn btn-blue">-</button>
																			<input type="text" id="<?php echo $id_name[$i]; ?>_${loop_non_ahm}" name="<?php echo $id_name[$i]; ?>[]" class="form-control size-1" value="0"/>
																			<button type="button" id="btn_plus_<?php echo $btn_plus++; ?>_${loop_non_ahm}" class="btn btn-blue">+</button>
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
								
					<div class="modal fade modal-non-ahm-${loop_non_ahm}">
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
														<table class="table table-bordered" id="non_visual_${loop_non_ahm}">
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
																	$btn_plus = 1;
																	$btn_min = 1; 
																	for($i = 0; $i < count($non_visual); $i++) {
																?>
																<tr>
																	<td><?php echo $no++; ?></td>
																	<td style="width: 80%; font-weight:bolder;"><?php echo $non_visual[$i]; ?></td>
																	<td>
																		<div class="input-spinner">
																			<button type="button" id="btn_min_non_<?php echo $btn_min++; ?>_${loop_non_ahm}" class="btn btn-danger <?php echo $name[$i]; ?>">-</button>
																			<input type="text" id="<?php echo $name[$i]; ?>_${loop_non_ahm}" name="<?php echo $name[$i]; ?>[]" class="form-control size-1" value="0"/>
																			<button type="button" id="btn_plus_non_<?php echo $btn_plus++; ?>_${loop_non_ahm}" class="btn btn-danger">+</button>
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
				</div>
			`;

			parts += `
				<div id="parts_${loop_non_ahm}">
					<div class="modal fade modal_parts_tbl_${loop_non_ahm}">
						<div class="modal-dialog" style="width: 80%;">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title">Cari Nama Part</h4>
								</div>

								<div class="modal-body">
									<table class="table table-bordered datatable" id="parts_table_non_${loop_non_ahm}">
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
										
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			`;

			$("#add_form_part").append(html);
			$("#add_form_parts").append(parts);
			$(".non_ahm_gqi_control").css("display", "none");
			$(`#visual_and_nonvisual_non_ahm_${loop_non_ahm}`).hide();
			$("#add_form_part").find(`#ahmPlantNon_${loop_non_ahm}`).css("display", "none");
			$(`#total_claim_surat_${loop_non_ahm}`).prop("readonly", true);

			let table_non_ahm = $(`#parts_table_non_${loop_non_ahm}`).DataTable({
				"oLanguage": {
					"sSearch": "Search:",
					"oPaginate": {
						"sPrevious": "Previous",
						"sNext": "Next"
					}
				},
				"lengthChange": true,
                "JQueryUI":true,
                "scrollCollapse":true,
                "initComplete": function (settings, json) {  
                    $(`#parts_table_non_${loop_non_ahm}`).wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
                },
			});

			$(`#visual-${loop_non_ahm}`).DataTable({
				"oLanguage": {
					"sSearch": "Search:",
					"oPaginate": {
						"sPrevious": "Previous",
						"sNext": "Next"
					}
				},
				"pageLength": 56,
				"lengthChange": false,
                "JQueryUI":true,
                "scrollCollapse":true,
                "initComplete": function (settings, json) {  
                    $(`#visual-${loop_non_ahm}`).wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
                },
			});

			$(`#non_visual_${loop_non_ahm}`).DataTable({
				"oLanguage": {
					"sSearch": "Search:",
					"oPaginate": {
						"sPrevious": "Previous",
						"sNext": "Next"
					}
				},
				"pageLength": 13,
				"lengthChange": false,
                "JQueryUI":true,
                "scrollCollapse":true,
                "initComplete": function (settings, json) {  
                    $(`#non_visual_${loop_non_ahm}`).wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
                },
			});

			$(`#table-qgi-point_non_ahm_${loop_non_ahm}`).DataTable({
				"oLanguage": {
					"sSearch": "Search:",
					"oPaginate": {
						"sPrevious": "Previous",
						"sNext": "Next"
					}
				},
				"pageLength": 13,
				"lengthChange": false,
                "JQueryUI":true,
                "scrollCollapse":true,
                "initComplete": function (settings, json) {  
                    $(`#table-qgi-point_non_ahm_${loop_non_ahm}`).wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
                },
			});

			$("#add_form_part").on('click', `#no_lkk_qro_${loop_non_ahm}`, function() {
				let id_qro = $(this).attr('id');
				$(`#${id_qro}`).keyup(function() {
					$(this).val($(this).val().toUpperCase());
				});
			});


			$("#add_form_part").on('click', `#modal_parts_${loop_non_ahm}`, function() {
				let id_btn_modal = $(this).attr('id');
				let split_id_btn_modal = id_btn_modal.split('_');
				let last_element = split_id_btn_modal[split_id_btn_modal.length - 1];
				$.ajax({
						type: "GET",
						url: "<?php echo base_url('masterdata/customer/getCustomer/'); ?>"+id_customer,
						data: {
							customer: id_customer,
						},
						dataType: "json",
						success: (data)=> {
							let no = 1;
							table_non_ahm.clear().draw();
							for(let i = 0; i < data.length; i++) {
								let get_namaPart = data[i].nama_part.split(' ').join('-');
								let get_Customer = data[i].nama_customer.split(' ').join('-');
								let get_Proses = data[i].proses.split(' ').join('-');
								let button = `<button type='button' class='btn btn-green btn-icon' id='btn_add_nonahm_${last_element}' data-id='${data[i].id_part}' data-part="${get_namaPart}" data-type="${data[i].type}" data-no-part="${data[i].no_sap}" data-safety="${data[i].safety_grade}" data-proses="${get_Proses}" data-customer="${get_Customer}" data-dismiss='modal'>PILIH <i class='entypo-check'></i></button>`;
								table_non_ahm.row.add([
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
				$(`.modal_parts_tbl_${last_element}`).modal('show');
			});

			$("#add_form_part").on('click', `#btn_visual_${loop_non_ahm}`, function() {
				let id_btn_visual = $(this).attr('id');
				let split_id_btn_visual = id_btn_visual.split('_');
				let last_element = split_id_btn_visual[split_id_btn_visual.length - 1];
				$(`#tai-dah-${last_element}`).modal('show');
				<?php
					$merge_visual_non = array_merge($id_name, $name);
					for($i = 0; $i < count($visual); $i++) {
				?>
					
					let $field_visual<?php echo $i+1; ?> = $(`#<?php echo $id_name[$i] ?>_${last_element}`);
					let init_value_visual<?php echo $i+1; ?> = parseInt($field_visual<?php echo $i+1; ?>.val());

					if(init_value_visual<?php echo $i+1; ?> <= 0) {
						$("#add_form_part").find(`#btn_min_<?php echo $i+1; ?>_${last_element}`).attr("disabled", true);
					}
					
					
					$("#add_form_part").find(`#btn_plus_<?php echo $i+1; ?>_${last_element}`).click(function add() {
						$("#add_form_part").find(`#btn_min_<?php echo $i+1; ?>_${last_element}`).attr("disabled", false);
						let $field_visual_<?php echo $i+1; ?> = $(`#<?php echo $id_name[$i] ?>_${last_element}`);
						let init_value_visual_<?php echo $i+1; ?> = parseInt($field_visual_<?php echo $i+1; ?>.val());
						
						if(init_value_visual<?php echo $i+1; ?> >= 1) {
							init_value_visual_<?php echo $i+1; ?>--;
						}
						
						init_value_visual_<?php echo $i+1; ?>++;
						
						// console.log(init_value_visual<?php echo $i+1; ?>);
						$field_visual_<?php echo $i+1; ?>.val(init_value_visual_<?php echo $i+1; ?>);
						multiformCalculate(last_element);
					});

					$("#add_form_part").find(`#btn_min_<?php echo $i+1; ?>_${last_element}`).click(function subst() {
						let $field_visual_<?php echo $i+1; ?> = $(`#<?php echo $id_name[$i] ?>_${last_element}`);
						let init_value_visual_<?php echo $i+1; ?> = parseInt($field_visual_<?php echo $i+1; ?>.val());
						if(init_value_visual<?php echo $i+1; ?> >= 1) {
							init_value_visual_<?php echo $i+1; ?>++;
						}
						init_value_visual_<?php echo $i+1; ?>--;
						if(init_value_visual_<?php echo $i+1; ?> <= 0) {
							$field_visual_<?php echo $i+1; ?>.val(0);
							$("#add_form_part").find(`#btn_min_<?php echo $i+1; ?>_${last_element}`).attr("disabled", true);
						}
						$field_visual_<?php echo $i+1; ?>.val(init_value_visual_<?php echo $i+1; ?>);
						multiformCalculate(last_element);
					});

				<?php
					}
				?>

				// KEYUP VISUAL
				<?php
					for($i = 0; $i < count($id_name); $i++) {
				?>
						$("#add_form_part").on('keyup', `#<?php echo $id_name[$i] ?>_${last_element}`, function() {
							if($(this).val() > 0) {
								$("#add_form_part").find(`#btn_min_<?php echo $i+1; ?>_${last_element}`).attr("disabled", false);
							} else {
								$("#add_form_part").find(`#btn_min_<?php echo $i+1; ?>_${last_element}`).attr("disabled", true);
							}
							multiformCalculate(last_element);
						});
				<?php
					}
				?>
			});

			$("#add_form_part").on('click', `#btn_nonvisual_non_ahm_${loop_non_ahm}`, function() {
				let id_btn_non_visual = $(this).attr('id');
				let split_id_btn_non_visual = id_btn_non_visual.split('_');
				let last_element = split_id_btn_non_visual[split_id_btn_non_visual.length - 1];
				$(`.modal-non-ahm-${last_element}`).modal('show');
				<?php
					for($j = 0; $j < count($non_visual); $j++) {
				?>
						let $field_non_visual<?php echo $j+1; ?> = $(`#<?php echo $name[$j] ?>_${last_element}`);
						let init_value_non_visual<?php echo $j+1; ?> = parseInt($field_non_visual<?php echo $j+1; ?>.val());
						if(init_value_non_visual<?php echo $j+1; ?> <= 0) {
							$("#add_form_part").find(`#btn_min_non_<?php echo $j+1; ?>_${last_element}`).attr("disabled", true);
						}
						
						$("#add_form_part").find(`#btn_plus_non_<?php echo $j+1; ?>_${last_element}`).click(function add() {
							$("#add_form_part").find(`#btn_min_non_<?php echo $j+1; ?>_${last_element}`).attr("disabled", false);
							let $field_non_visual_<?php echo $j+1; ?> = $(`#<?php echo $name[$j] ?>_${last_element}`);
							let init_value_non_visual_<?php echo $j+1; ?> = parseInt($field_non_visual_<?php echo $j+1; ?>.val());
							if(init_value_non_visual<?php echo $j+1; ?> >= 1) {
								init_value_non_visual_<?php echo $j+1; ?>--;
								
							} 
							init_value_non_visual_<?php echo $j+1; ?>++;
							
							$field_non_visual_<?php echo $j+1; ?>.val(init_value_non_visual_<?php echo $j+1; ?>);
							multiformCalculate(last_element);
						});

						$("#add_form_part").find(`#btn_min_non_<?php echo $j+1; ?>_${last_element}`).click(function subst() {
							let $field_non_visual_<?php echo $j+1; ?> = $(`#<?php echo $name[$j] ?>_${last_element}`);
							let init_value_non_visual_<?php echo $j+1; ?> = parseInt($field_non_visual_<?php echo $j+1; ?>.val());
							if(init_value_non_visual<?php echo $j+1; ?> >= 1) {
								init_value_non_visual_<?php echo $j+1; ?>++;
							}

							init_value_non_visual_<?php echo $j+1; ?>--;

							if(init_value_non_visual_<?php echo $j+1; ?> <= 0) {
								$field_non_visual_<?php echo $j+1; ?>.val(0);
								$("#add_form_part").find(`#btn_min_non_<?php echo $j+1; ?>_${last_element}`).attr("disabled", true);
							}

							$field_non_visual_<?php echo $j+1; ?>.val(init_value_non_visual_<?php echo $j+1; ?>);
							multiformCalculate(last_element);
						});

				<?php
					}
				?>

				// KEYUP NON VISUAL
				<?php
					for($i = 0; $i < count($name); $i++) {
				?>
						$("#add_form_part").on('keyup', `#<?php echo $name[$i] ?>_${last_element}`, function() {
							if($(this).val() > 0) {
								$("#add_form_part").find(`#btn_min_non_<?php echo $i+1; ?>_${last_element}`).attr("disabled", false);
							} else {
								$("#add_form_part").find(`#btn_min_non_<?php echo $i+1; ?>_${last_element}`).attr("disabled", true);
							}
							multiformCalculate(last_element);
						});
				<?php
					}
				?>
			});

			<?php
				foreach($merge_visual_non as $data_field) {
			?>
				var keep_value_<?php echo $data_field; ?> = 0;
			<?php
				}
			?>

			function multiformCalculate(current_loop_non_ahm) {
				<?php
					foreach($merge_visual_non as $field_visual_non) {
				?>
						var <?php echo $field_visual_non; ?> = $(`#<?php echo $field_visual_non; ?>_${current_loop_non_ahm}`).val();
				<?php
					}
				?>


				<?php
					foreach($id_name as $data_field_visual) {
				?>
						if(<?php echo $data_field_visual; ?> > 0) {
							keep_value_<?php echo $data_field_visual; ?> = <?php echo $data_field_visual; ?>;
							$(`#<?php echo $data_field_visual; ?>_visual_${current_loop_non_ahm}`).val(keep_value_<?php echo $data_field_visual; ?>);
						}
				<?php
					}
				?>

				<?php
					foreach($name as $data_field_non) {
				?>
						if(<?php echo $data_field_non; ?> > 0) {
							keep_value_<?php echo $data_field_non; ?> = <?php echo $data_field_non; ?>;
							$(`#<?php echo $data_field_non; ?>_non_${current_loop_non_ahm}`).val(keep_value_<?php echo $data_field_non; ?>);
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
					$(`#total_claim_${current_loop_non_ahm}`).val(total_claim);
					$(`#total_claim_surat_${current_loop_non_ahm}`).val(total_claim);
					var total_claim = $(`#total_claim_${current_loop_non_ahm}`).val();
					var total_claim_surat = $(`#total_claim_surat_${current_loop_non_ahm}`).val();
					if(total_claim == total_claim_surat) {
						$(`#status_part_${current_loop_non_ahm}`).val("RECEIVED");
					}
					calculate_qty_point(total_claim_surat);
				}

				if(!isNaN(jumlah_visual)) {
					$(`#jumlah_qty_visual_${current_loop_non_ahm}`).val(jumlah_visual);
					if(jumlah_visual > 0) {
						$(`#rank_point_visual_${current_loop_non_ahm}`).val(4);
					} else {
						$(`#rank_point_visual_${current_loop_non_ahm}`).val(0);
					}
				}

				if(!isNaN(jumlah_non_visual)) {
					$(`#jumlah_qty_non_${current_loop_non_ahm}`).val(jumlah_non_visual);
					var s_grade = $(`#s_grade_${current_loop_non_ahm}`).val();
					if(s_grade === 'NON') {
						$(`#rank_point_non_${current_loop_non_ahm}`).val('FALSE');
					} else if(s_grade === '#N/A') {
						$(`#rank_point_non_${current_loop_non_ahm}`).val('#N/A');
					} else {
						if(s_grade === 'HS') {
							if(jumlah_non_visual > 0) {
								$(`#rank_point_non_${current_loop_non_ahm}`).val(100);
							}
						} else if(s_grade === 'HA') {
							if(jumlah_non_visual > 0) {
								$(`#rank_point_non_${current_loop_non_ahm}`).val(100);
							}
						} else if(s_grade === 'HB') {
							if(jumlah_non_visual > 0) {
								$(`#rank_point_non_${current_loop_non_ahm}`).val(20);
							}
						} else if(s_grade === 'NON') {
							if(jumlah_non_visual > 0) {
								$(`#rank_point_non_${current_loop_non_ahm}`).val(4);
							}
						} else {
							if(jumlah_non_visual <= 0) {
								$(`#rank_point_non_${current_loop_non_ahm}`).val(0);
							}
						}
					}
				}

				var qty_point = $(`#qty_point_${current_loop_non_ahm}`).val();
				var rank_visual = $(`#rank_point_visual_${current_loop_non_ahm}`).val();
				var rank_non = $(`#rank_point_non_${current_loop_non_ahm}`).val();
				if(rank_non === 'FALSE') {
					var calculate = parseInt(qty_point) + parseInt(rank_visual);
					$(`#gqi_point_${current_loop_non_ahm}`).val(calculate);
				} else if(rank_non === '#N/A') {
					$(`#gqi_point_${current_loop_non_ahm}`).val('#N/A');
				} else {
					var calculate = parseInt(qty_point) + parseInt(rank_visual) + parseInt(rank_non);
					$(`#gqi_point_${current_loop_non_ahm}`).val(calculate);
				}

				var gqi_point = $(`#gqi_point_${current_loop_non_ahm}`).val();
				if(gqi_point > 114) {
					$(`#card_${current_loop_non_ahm}`).css('background-color', '#ff0000').val('Red Card');
					$(`#card_${current_loop_non_ahm}`).css('color', '#ffffff');
				} else if(gqi_point > 100) {
					$(`#card_${current_loop_non_ahm}`).css('background-color', '#ffd800').val('Yellow Card');
					$(`#card_${current_loop_non_ahm}`).css('color', '#222831');
				} else if(gqi_point > 0) {
					$(`#card_${current_loop_non_ahm}`).css('background-color', '#42b883').val('Green Card');
					$(`#card_${current_loop_non_ahm}`).css('color', '#ffffff');
				} else {
					$(`#card_${current_loop_non_ahm}`).css('background-color', '#eeeeee').val('#N/A');
					$(`#card_${current_loop_non_ahm}`).css('color', '#222831');
				}
			}


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

			$(`#total_claim_surat_${loop_non_ahm}`).keyup(function() {
				let value = $(this).val();
				let isNum = $.isNumeric(value);
				if($(this).val() == "" || $(this).val() <= 0 || !isNum) {
					$(this).val(0);
				} else if($(this).val() > 0) {
					$(this).val().replace(0,'');
				}

				if($(this).val()!=0) {
					let text = $(this).val();
					if(text.slice(0,1)==0) {
						$(this).val(text.slice(1,text.length));   
					}
				}
			});
			

			$(`#parts_table_non_${loop_non_ahm}`).on('click', `#btn_add_nonahm_${loop_non_ahm}`, function() {
				let	current_id = $(this).attr('id');
				let split_current_id = current_id.split('_');
				let last_element_current_id = split_current_id[split_current_id.length - 1];
				$(`#id_part_${last_element_current_id}`).val($(this).data('id'));
				$(`#nama_part_${last_element_current_id}`).val($(this).data('part'));
				$(`#type_part_${last_element_current_id}`).val($(this).data('type'));
				$(`#no_part_${last_element_current_id}`).val($(this).data('no-part'));
				$(`#s_grade_${last_element_current_id}`).val($(this).data('safety'));
				$(`#proses_${last_element_current_id}`).val($(this).data('proses'));
				$(`#customer_${last_element_current_id}`).val($(this).data('customer'));
				let jumlah_qty_non = $(`#jumlah_qty_non_${last_element_current_id}`).val();
				let s_grade = $(`#s_grade_${last_element_current_id}`).val();
				if(s_grade === 'NON') {
					$(`#rank_point_non_${last_element_current_id}`).val('FALSE');
				} else if(s_grade === '#N/A') {
					$(`#rank_point_non_${last_element_current_id}`).val('#N/A');
				} else {
					if(s_grade === 'HS') {
						if(jumlah_qty_non > 0) {
							$(`#rank_point_non_${last_element_current_id}`).val(100);
						}
					} else if(s_grade === 'HA') {
						if(jumlah_qty_non > 0) {
							$(`#rank_point_non_${last_element_current_id}`).val(100);
						}
					} else if(s_grade === 'HB') {
						if(jumlah_qty_non > 0) {
							$(`#rank_point_non_${last_element_current_id}`).val(20);
						}
					} else if(s_grade === 'NON') {
						if(jumlah_qty_non > 0) {
							$(`#rank_point_non_${last_element_current_id}`).val(4);
						}
					} else {
						if(jumlah_qty_non <= 0) {
							$(`#rank_point_non_${last_element_current_id}`).val(0);
						}
					}
				}

				let qty_point = $(`#qty_point_${last_element_current_id}`).val();
				let rank_visual = $(`#rank_point_visual_${last_element_current_id}`).val();
				let rank_non = $(`#rank_point_non_${last_element_current_id}`).val();

				if(rank_non === 'FALSE') {
					var calculate = parseInt(qty_point) + parseInt(rank_visual);
					$(`#gqi_point_${last_element_current_id}`).val(calculate);
				} else if(rank_non === '#N/A') {
					$(`#gqi_point_${last_element_current_id}`).val('#N/A');
				} else {
					var calculate = parseInt(qty_point) + parseInt(rank_visual) + parseInt(rank_non);
					$(`#gqi_point_${last_element_current_id}`).val(calculate);
				}

				var gqi_point = $(`#gqi_point_${last_element_current_id}`).val();
				if(gqi_point > 114) {
					$(`#card_${last_element_current_id}`).css('background-color', '#ff0000').val('Red Card');
					$(`#card_${last_element_current_id}`).css('color', '#ffffff');
				} else if(gqi_point > 100) {
					$(`#card_${last_element_current_id}`).css('background-color', '#ffd800').val('Yellow Card');
					$(`#card_${last_element_current_id}`).css('color', '#222831');
				} else if(gqi_point > 0) {
					$(`#card_${last_element_current_id}`).css('background-color', '#42b883').val('Green Card');
					$(`#card_${last_element_current_id}`).css('color', '#ffffff');
				} else {
					$(`#card_${last_element_current_id}`).css('background-color', '#eeeeee').val('#N/A');
					$(`#card_${last_element_current_id}`).css('color', '#222831');
				}

				$(`#visual_and_nonvisual_non_ahm_${last_element_current_id}`).show();

				$(`#total_claim_surat_${last_element_current_id}`).prop("readonly", false);
			});


			
			function compare(current_id_surat) {
				
				var t_claim = $(`#total_claim_${current_id_surat}`).val();
				var claim_surat = $(`#total_claim_surat_${current_id_surat}`).val();
				if(t_claim == claim_surat) {
					$(`#status_part_${current_id_surat}`).val("RECEIVED");
				} else {
					$(`#status_part_${current_id_surat}`).val("REJECTED");
				}
				calculate_qty_point(claim_surat, current_id_surat);
			}

			function calculate_qty_point(total_claim_surat, current_id_surat) {
				var clt = 0;
				if(total_claim_surat > 499) {
					clt = 115;
				} else if(total_claim_surat > 299) {
					clt = 70;
				} else if(total_claim_surat > 199) {
					clt = 50;
				} else if(total_claim_surat > 1) {
					clt = 10;
				} else if(total_claim_surat > 0) {
					clt = 2;
				} else {
					if(total_claim_surat > 0 == 0) {
						clt = 0;
					}
				}
				$(`#qty_point_${current_id_surat}`).val(clt);
			}

			$(`#total_claim_surat_${loop_non_ahm}`).on("keyup", function() {
				let id_total_claim_surat = $(this).attr('id');
				let split_id_total_claim_surat = id_total_claim_surat.split('_');
				let last_element_split_id_claim_surat = split_id_total_claim_surat[split_id_total_claim_surat.length - 1];
				compare(last_element_split_id_claim_surat);
			});

			$("#add_form_part").on('click',`#hapus_non_${loop_non_ahm}`, function(e){
				e.preventDefault();
				let id_hapus = $(this).attr('id');
				let split_id_hapus = id_hapus.split('_');
				let last_element = split_id_hapus[split_id_hapus.length - 1];
				$(`#part_${last_element}`).remove();
				$(`#parts_${last_element}`).remove();
			});

			loop_non_ahm++;
		});
	});				
</script>
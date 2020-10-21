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
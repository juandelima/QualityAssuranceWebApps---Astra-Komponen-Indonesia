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
	</style>
</head>
<body class="page-body skin-facebook" data-url="http://neon.dev">
	<div class="page-container">
		<?php $this->load->view('_partials/navbar.php'); ?>
		<div class="main-content">
			<?php $this->load->view('_partials/navbar_head.php'); ?>
			<h2>Add List Part</h2>
			<ol class="breadcrumb bc-3">
				<li>
					<a href="<?php echo base_url('masterdata/listpart') ?>"><i class="entypo-home"> List Part</i></a>
				</li>
				<li class="active">
					<strong>Add New List Part</strong>
				</li>
			</ol>
			<div class="row">
				<div class="col-md-12">
				<div class="panel panel-primary" data-collapsed="0">
						<div class="panel-body">
							<form role="form" class="form-horizontal" action="<?php echo base_url('masterdata/listpart/add_new_data_part'); ?>" method="post">
								<div class="form-group">
									<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">&emsp;&emsp;NO SAP</label>
									<div class="col-sm-5">
										<input type="text" class="autocomplete form-control" id="no_sap" name="no_sap" placeholder="QS2SCO-GCBO81BK01" required>
									</div>
									<span id="empty-message"></span>
								</div>
								<div class="form-group">
									<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">&emsp;&emsp;SAFETY GRADE</label>
									<div class="col-sm-5">
										<input type="text" class="autocomplete form-control" id="s_grade" name="s_grade" placeholder="NON/HB/HA/HS" required>
									</div>
								</div>
								<div class="form-group">
									<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">&emsp;&emsp;NAMA PART</label>
									<div class="col-sm-5">
										<input type="text" class="autocomplete form-control" id="nama_part" name="nama_part" placeholder="COVER L UNDER SIDE SET K60R" required>
									</div>
								</div>
								<div class="form-group">
									<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">&emsp;&emsp;TYPE</label>
									<div class="col-sm-5">
										<input type="text" class="autocomplete form-control" id="type_part" name="type_part" placeholder="K60R" required>
									</div>
								</div>
								<div class="form-group">
									<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">&emsp;&emsp;PROSES</label>
									<div class="col-sm-5">
										<input type="text" class="autocomplete form-control" id="proses" name="proses" placeholder="PI" required>
									</div>
								</div>
								<div class="form-group">
									<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">&emsp;&emsp;CUSTOMER</label>
									<div class="col-sm-5">
										<input type="text" class="autocomplete form-control" id="customer" name="customer" placeholder="AHM/AHD/AVI" required>
									</div>
								</div>
								<div class="form-group center-block pull-left" style="margin-left: 20px;">
									<button type="submit" id="simpan" class="btn btn-green btn-icon icon-left col-left">
									Simpan
									<i class="entypo-check"></i>
									</button>
									<a href="<?php echo base_url('masterdata/listpart') ?>" class="btn btn-red btn-icon icon-left">
											Kembali
										<i class="entypo-cancel"></i>
									</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view('_partials/js.php'); ?>
	<script>
		jQuery(document).ready( function($) {
			$('#customer').autocomplete({
				source: "<?php echo site_url('masterdata/listpart/get_customer');?>",
				select: function (event, ui) {
					$("#customer").val(ui.item.value);
                }
			});


			// $("#no_sap").on('change', function() {
			// 	var no_sap = $("#no_sap").val();
			// 	$.ajax({
			// 		url: "<?php echo base_url('masterdata/listpart/get_autofill'); ?>",
			// 		data: '&no_sap='+no_sap,
			// 		success: function(data) {
			// 			var hasil = JSON.parse(data);
			// 			$.each(hasil, function(key ,val) {
			// 				$("#no_sap").val(val.NO_SAP);
			// 				$("#s_grade").val(val.SAFETY_GRADE);
			// 				$("#nama_part").val(val.NAMA_PART);
			// 				$("#type_part").val(val.TYPE);
			// 				$("#proses").val(val.PROSES);
			// 				$("#customer").val(val.CUSTOMER);
			// 			});
			// 		}

			// 	});
			// });
			var type_part = ["ANF","K03S","K07A","K0JA","K0WA",
							"K15A","K15G","K15M","K18H","K25A",
							"K41A","K44F","K46A","K46F","K47A",
							"K47G","K56A","K56F","K59","K59A",
							"K59J","K60A","K60R","K60V","K61A",
							"K64","K64A","K66","K81A","K84A",
							"K93","K93A","K97F","K97G","KVB",
							"KVY","KWBF","KWCA","KWW","KWWF",
							"KWWX","KYEA","KYZA","KZL","KZLG", "KZRA", "17880", "1110", "17870"];
							
			$("#nama_part, #no_sap, #s_grade, #type_part, #proses, #customer").keyup(function() {
				$(this).val($(this).val().toUpperCase());
				var get_val = $("#nama_part").val();

				if(get_val.length === 0) {
					$("#type_part").val("");
				}
				
				for(var i = 0; i < type_part.length; i++) {
					if(get_val.indexOf(type_part[i]) > -1) {
						$("#type_part").val(type_part[i]);
					}
				}
			});	
		});
	</script>
</body>
</html>

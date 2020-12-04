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
										
										<select name="proses" id="proses" class="form-control">
											<option>proses</option>
											<?php foreach($proses as $data) { ?>
												<option value="<?php echo $data->proses; ?>"><?php echo $data->proses; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>


								<div class="form-group">
									<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">&emsp;&emsp;CUSTOMER</label>
									<div class="col-sm-5">
										<select name="customer" id="customer" class="form-control">
											<option>customer</option>
											
										</select>
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
			<?php $this->load->view('_partials/footer.php'); ?>
		</div>
		<?php $this->load->view('_partials/lists_chat.php'); ?>
	</div>
	<?php $this->load->view('_partials/js.php'); ?>
	<script src="<?php echo site_url('assets/js/chatting/chat.js'); ?>"></script>
	<?php $this->load->view('_partials/chatting'); ?>
	<script>
		jQuery(document).ready( function($) {
				selectProses();
		});

		function selectProses() {
			const proses = $("#proses");
			proses.change(() => {
				getProsesVal = proses.val();
				selectCustomer(getProsesVal);
			});
		}

		function selectCustomer(proses) {
			let customer_deliv = $("#customer");
			customer_deliv.empty();
			if(proses === "PI") {
				customer_deliv.append($('<option></option>').val("AHM").html("AHM"));
				customer_deliv.append($('<option></option>').val("AVI").html("AVI"));
				customer_deliv.append($('<option></option>').val("ADM").html("ADM"));
				customer_deliv.append($('<option></option>').val("DNIA").html("DNIA"));
				customer_deliv.append($('<option></option>').val("HMMI").html("HMMI"));
				customer_deliv.append($('<option></option>').val("YUTAKA").html("YUTAKA"));
				customer_deliv.append($('<option></option>').val("TACI").html("TACI"));
				customer_deliv.append($('<option></option>').val("TAM").html("TAM"));
				customer_deliv.append($('<option></option>').val("TMMIN").html("TMMIN"));
				customer_deliv.append($('<option></option>').val("AWP").html("AWP"));
			} else if(proses === "PT") {
				customer_deliv.append($('<option></option>').val("AHM").html("AHM"));
				customer_deliv.append($('<option></option>').val("AVI").html("AVI"));
				customer_deliv.append($('<option></option>').val("YUTAKA").html("YUTAKA"));
				customer_deliv.append($('<option></option>').val("TAM").html("TAM"));
				customer_deliv.append($('<option></option>').val("ADM").html("ADM"));
			} else if(proses === "SB") {
				customer_deliv.append($('<option></option>').val("AHM").html("AHM"));
				customer_deliv.append($('<option></option>').val("IAMI").html("IAMI"));
				customer_deliv.append($('<option></option>').val("SUZUKI").html("SUZUKI"));
				customer_deliv.append($('<option></option>').val("ADM").html("ADM"));
			} else if(proses === "BM") {
				customer_deliv.append($('<option></option>').val("SUZUKI").html("SUZUKI"));
				customer_deliv.append($('<option></option>').val("ADM").html("ADM"));
			}
		}
	</script>
</body>
</html>

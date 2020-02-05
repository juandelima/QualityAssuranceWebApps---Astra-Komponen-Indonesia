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
		td.sorting_1 {
			text-align: center;
		}
	</style>
</head>
<body class="page-body skin-facebook" data-url="http://neon.dev">
	<div class="page-container">
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
				} elseif($this->session->flashdata('hapus')) {
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
						toastr.error("<?php echo $this->session->flashdata('hapus'); ?>", "SUCCESS", opts);
					});
				</script>
			<?php 
				}
			?>
			<?php if($this->session->userdata['role'] != 'User') { ?>
			<div class="pull-left" style="margin-bottom: 20px;">
				<a href="<?php echo base_url('masterdata/listpart/create_new_part'); ?>" class="btn btn-blue btn-icon">
					Add New List Part
					<i class="entypo-user-add"></i>
				</a>
			</div>
			<?php } ?>
			<table class="table table-bordered" id="table-1">
				<thead>
					<tr>
						<th width="1">No</th>
						<th>NO SAP</th>
						<th>SAFETY GRADE</th>
						<th>NAMA PART</th>
						<th>TYPE</th>
						<th>PROSES</th>
						<th>CUSTOMER</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no = 1; 
						foreach($listpart as $data) {
					?>
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo $data->NO_SAP; ?></td>
						<td><?php echo $data->SAFETY_GRADE; ?></td>
						<td><?php echo $data->NAMA_PART; ?></td>
						<td><?php echo $data->TYPE; ?></td>
						<td><?php echo $data->PROSES; ?></td>
						<td><?php echo $data->nama_customer; ?></td>
					</tr>
					<?php 
						$no += 1;
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
<?php $this->load->view('_partials/js.php'); ?>
<script>
	jQuery( document ).ready( function($) {
		$('#table-1').DataTable({
			"oLanguage": {
				"sSearch": "Search:",
				"oPaginate": {
					"sPrevious": "Previous",
					"sNext": "Next"
				}
			},
			"pageLength": 10,
			"lengthChange": false
		});
	});
</script>
</body>
</html>
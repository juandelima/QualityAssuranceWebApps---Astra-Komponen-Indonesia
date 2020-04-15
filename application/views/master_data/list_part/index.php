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
				<a href="<?php echo base_url('masterdata/listpart/create'); ?>" class="btn btn-blue btn-icon">
					Add List Part
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
						<th width="90">AKSI</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no = 1; 
						foreach($listpart as $data) {
					?>
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo $data->no_sap; ?></td>
						<td><?php echo $data->safety_grade; ?></td>
						<td><?php echo $data->nama_part; ?></td>
						<td><?php echo $data->type; ?></td>
						<td><?php echo $data->proses; ?></td>
						<td><?php echo $data->customer_name; ?></td>
						<td style="text-align: center;">
							<a href="<?php echo base_url('masterdata/listpart/edit/'.$data->id_part); ?>" class="btn btn-info btn-sm">
								Ubah
							</a>
							<a href="javascript:;" onclick="jQuery('#modal-5<?php echo $data->id_part; ?>').modal('show', {backdrop: 'static'});" class="btn btn-danger btn-sm">
								Delete
							</a>
						</td>
					</tr>
					<?php 
						$no += 1;
						}
					?>
				</tbody>
			</table>
		</div>
		</div>
			<?php
				foreach($listpart as $data) {
			?>
				<div class="modal fade" id="modal-5<?php echo $data->id_part; ?>">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title">Hapus part</h4>
							</div>
							<div class="modal-body">
								<strong>Anda yakin menghapus part <?php echo $data->nama_part?>? </strong>
							</div>
							<div class="modal-footer">
								<input type="hidden" name="id_customer_delete" id="id_customer_delete" class="form-control">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
								<a href="<?php echo base_url('masterdata/listpart/delete/'.$data->id_part); ?>" class="btn btn-primary">Yes</a>
							</div>
						</div>
					</div>
				</div>
			<?php 
				}
			?>
<?php $this->load->view('_partials/js.php'); ?>
<script src="<?php echo site_url('assets/js/chatting/chat.js'); ?>"></script>
<?php $this->load->view('_partials/chatting'); ?>
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
			"pageLength": 6,
			"lengthChange": false,
			"JQueryUI":true,
            "scrollCollapse":true,
            "initComplete": function (settings, json) {  
                $("#table-1").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
            },
		});
	});
</script>
</body>
</html>

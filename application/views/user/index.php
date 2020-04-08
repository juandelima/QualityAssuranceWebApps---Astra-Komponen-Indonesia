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
			
						toastr.error("<?php echo $this->session->flashdata('hapus'); ?>", "ERROR", opts);
					});
				</script>
			<?php 
				}
			?>

			<div class="pull-left" style="margin-bottom: 20px;">
				<a href="<?php echo base_url('datauser/user/create'); ?>" class="btn btn-blue btn-icon">
					Add User
					<i class="entypo-user-add"></i>
				</a>
			</div>
			
			<table class="table table-bordered" id="table-1">
				<thead>
					<tr>
						<th width="1">No</th>
						<th>FULL NAME</th>
						<th>USERNAME</th>
						<th>ROLE</th>
						<th>LAST LOGIN</th>
						<?php if($this->session->userdata['role'] == 'Super Admin') { ?>
						<th>AKSI</th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php
						$no = 1;
						$id = $this->session->userdata['id_users']; 
						foreach($users as $data) {

							if($id != $data->id_users and ($data->role == 'Admin' or $data->role == 'User' or $data->role == 'Super Admin')) {
					?>
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo $data->full_name; ?></td>
						<td><?php echo $data->username; ?></td>
						<td><?php echo $data->role; ?></td>
						<td><?php echo $data->updated_at; ?></td>
						<?php if($this->session->userdata['role'] == 'Super Admin') { ?>
						<td style="text-align: center;">
							<?php if($this->session->userdata['role'] != $data->role ) { ?>
							<a href="<?php echo base_url('datauser/user/edit/'.$data->id_users); ?>" class="btn btn-info btn-sm">
								Ubah
							</a>
							<?php } ?>
							<?php if($data->role != 'Super Admin') { ?>
							<a href="javascript:;" onclick="jQuery('#modal-5<?php echo $data->id_users; ?>').modal('show', {backdrop: 'static'});" class="btn btn-danger btn-sm">
								Delete
							</a>
							<?php } ?>
						</td>
						<?php } ?>
					</tr>
					<?php 		$no += 1;
							}
						}
					?>
				</tbody>
			</table>
			<?php
				foreach($users as $data) {
			?>
				<div class="modal fade" id="modal-5<?php echo $data->id_users; ?>">
					<div class="modal-dialog" style="width: 50%;">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title">Hapus user</h4>
							</div>
							<form role="form" class="form-horizontal" action="<?php echo base_url('datauser/user/delete/'.$data->id_users); ?>" method="post">
								<div class="modal-body">
									<strong>Anda yakin menghapus user <?php echo $data->full_name?>? </strong>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
									<button type="submit" class="btn btn-primary">Yes</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			<?php 
				}
			?>
		<?php $this->load->view('_partials/footer.php'); ?>
		</div>
	<?php $this->load->view('_partials/lists_chat.php'); ?>
	</div>
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
			}
		});
	});
</script>
</body>
</html>

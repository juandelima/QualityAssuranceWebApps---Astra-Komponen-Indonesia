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
			<?php if($this->session->userdata['role'] != 'User') { ?>
			<div class="pull-right" style="margin-bottom: 20px;">
				<a class="btn btn-blue btn-icon" href="javascript:;" onclick="jQuery('#modal-4').modal('show', {backdrop: 'static'});">
					Add Customer
					<i class="entypo-user-add"></i>
				</a>
			</div>
			<?php } ?>
			<table class="table table-bordered" id="table-2">
				<thead>
					<tr>
						<th style="text-align: center; width: 1%;">NO</th>
						<th style="text-align: center;">CUSTOMER</th>
					</tr>
				</thead>
			</table>
			<?php $this->load->view('_partials/modal.php'); ?>
		</div>
	</div>
	<?php $this->load->view('_partials/js.php'); ?>
	<script>

		jQuery(document).ready(function($) {
			var t = $('#table-2').DataTable(
					{
					"oLanguage": {
						"sSearch": "Search:",
						"oPaginate": {
							"sPrevious": "Previous",
							"sNext": "Next"
						}
					},
					"pageLength": 10,
					"lengthChange": false,
					// "createdRow": function(row, data, dataIndex) {
					// 	$(row).addClass('edit');
					// }
					"JQueryUI":true,
					"scrollCollapse":true,
					"initComplete": function (settings, json) {  
						$("#table-2").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
					},
				}	
			);

			show_customers();
			var no = 1;
			var no2 = 1;
			function show_customers() {
				$.ajax({
					type: "GET",
					url: "<?php echo base_url('masterdata/customer/data_customer'); ?>",
					async: true,
					dataType: "json",
					success: function(data) {
						var add_html = '';
						var i;
						for(i = 0; i < data.length; i++) {
							t.row.add([
								''+no+'',
								''+data[i].nama_customer+''
							]).draw(false);
							no += 1;
							// add_html += '<tr>'+
							// 			'<td>'+no+'</td>'+
							// 			'<td>'+data[i].nama_customer+'</td>'+
							// 			'<td style="text-align:center;">'+
							// 			'<a href="javascript:void(0);" class="btn btn-info btn-sm item_edit" data-customer_code="'+data[i].id_customer+'" data-customer_name="'+data[i].nama_customer+'" style="margin-right: 20px;">EDIT</a>'+
							// 			'<a href="javascript:void(0);" class="btn btn-danger btn-sm item_delete" data-customer_code="'+data[i].id_customer+'" data-customer_name="'+data[i].nama_customer+'">DELETE</a>'+
							// 			'</td>'+
							// 		'</tr>';
							// no += 1;
						}
						console.log(no2, no);
						// $("#show_data").html(add_html);
					}
				});
			}
			// console.log(t.row(parents('tr')).data());
			$("#nama_customer, #nama_customer_edit").keyup(function() {
				$(this).val($(this).val().toUpperCase());
			});
			$("#btn_save").on('click', function() {
				if(no > 1) {
					no2 = 0;
					no2 += no;
				}
				var nama_customer = $("#nama_customer").val();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('masterdata/customer/save_customer/'); ?>"+nama_customer,
					dataType: "json",
					data: {
						nama_customer:nama_customer
					},
					
					success: function(data) {
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
						toastr.success('CUSTOMER '+nama_customer+' TELAH DISIMPAN!', "SUCCESS", opts);
						// console.log(nama_customer);
						$('[name="nama_customer"]').val("");
						$('#modal-4').modal('hide');
						t.row.add([
							''+no2+'',
							''+nama_customer+''
						]).draw(false);
						if(no == 1) {
							no2++;
						} else {
							no++;
						}
					}
				});
				return false;
			});

			$("#table-2 tbody").on('click', '.item_edit', function() {
				var id_customer = $(this).data("customer_code");
				var nama_customer = $(this).data("customer_name");
				$("#edit").modal('show');
				$('[name="id_customer_edit"]').val(id_customer);
				$('[name="nama_customer_edit"]').val(nama_customer);
			});

			$("#btn_update").on('click', function() {
				var id_customer = $("#id_customer_edit").val();
				var nama_customer = $("#nama_customer_edit").val();
				// console.log(nama_customer);
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('masterdata/customer/update_customer'); ?>",
					dataType: "json",
					data: {
						id_customer:id_customer,
						nama_customer:nama_customer
					},
					success: function(data) {
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
						toastr.success('CUSTOMER '+nama_customer+' TELAH DIUBAH!', "SUCCESS", opts);
						$('[name="id_customer_edit"]').val("");
						$('[name="nama_customer_edit"]').val("");
						$("#edit").modal('hide');
					}
				});
				return false;
			});

			var cs_hapus;
			$("#show_data").on('click', '.item_delete', function() {
				var id_customer = $(this).data("customer_code");
				var nama_customer = $(this).data("customer_name");
				cs_hapus = nama_customer;
				$("#Modal_Delete").modal('show');
				$('[name="id_customer_delete"]').val(id_customer);
				$('#customer_name_delete').text(nama_customer);
			});

			$("#btn_delete").on('click', function() {
				var id_customer = $("#id_customer_delete").val();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('masterdata/customer/delete_customer'); ?>",
					dataType: "json",
					data: {
						id_customer: id_customer
					},
					success: function(data) {
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
						toastr.error('CUSTOMER '+cs_hapus+' TELAH DIHAPUS!', "SUCCESS", opts);
						$('[name="id_customer_delete"]').val("");
						$("#Modal_Delete").modal('hide');
						show_customers();
					}
				});
				return false;
			});
		});
	</script>
</body>
</html>

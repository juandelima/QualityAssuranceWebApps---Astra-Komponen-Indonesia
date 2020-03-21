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
			<h2>Add User</h2>
			<ol class="breadcrumb bc-3">
				<li>
					<a href="<?php echo base_url('datauser/user') ?>"><i class="entypo-home"> Data User</i></a>
				</li>
				<li class="active">
					<strong>Add User</strong>
				</li>
			</ol>
			<div class="row">
				<div class="col-md-12">
				<div class="panel panel-primary" data-collapsed="0">
						<div class="panel-body">
							<form role="form" id="create_user" class="form-horizontal" enctype="multipart/form-data" action="<?php echo base_url('datauser/user/tambah'); ?>" method="post">
								<div class="form-group">
									<label class="col-sm-3 control-label" style="text-align:left;">&emsp;&emsp;FOTO PROFILE	</label>
									<div class="col-sm-5">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
												<img src="http://placehold.it/200x150" alt="...">
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
											<div>
												<span class="btn btn-white btn-file">
													<span class="fileinput-new">Pilih Photo</span>
													<span class="fileinput-exists">Ubah</span>
													<input type="file" name="photo" accept="image/*">
												</span>
												<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Hapus</a>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">&emsp;&emsp;FULL NAME</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="full_name" name="full_name" placeholder="ex: juan valerian delima" required>
									</div>
								</div>
								<div class="form-group">
									<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">&emsp;&emsp;USERNAME</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="username" name="username" placeholder="ex: juandelima" required>
									</div>
									<div id="msg"></div>
								</div>
								<div class="form-group">
									<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">&emsp;&emsp;PASSWORD</label>
									<div class="col-sm-5">
										<input type="password" class="form-control" id="password" name="password" placeholder="******" required>
									</div>
									<input tabindex="6" type="checkbox" class="icheck-4" id="show">
								    <label for="minimal-checkbox-2-4">Show Password</label>
								</div>
								<div class="form-group">
									<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">&emsp;&emsp;PASSWORD CONFIRMATION</label>
									<div class="col-sm-5">
										<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="******" required>
									</div>
									<div style="color:red;padding-top: 8px;" id="not_match"></div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-12">
											<label class="col-sm-3 control-label" style="text-align:left;">&emsp;&emsp;ROLE</label>
											<div class="col-sm-5">
												<select name="role" class="form-control">
													<option value="Super Admin">Super Admin</option>
													<option value="Admin">Admin</option>
													<option value="User">User</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group center-block pull-left" style="margin-left: 20px;">
									<button type="submit" id="simpan" class="btn btn-green btn-icon icon-left col-left">
									Simpan
									<i class="entypo-check"></i>
									</button>
									<a href="<?php echo base_url('datauser/user') ?>" class="btn btn-red btn-icon icon-left">
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
	<script>
		jQuery(document).ready( function($) {
			$('#show').click(function(){
				if($(this).is(':checked')) {
					$('#password').attr('type','text');
					$('#password_confirmation').attr('type','text');
				}else{
					$('#password').attr('type','password');
					$('#password_confirmation').attr('type','password');
				}
    		});

			$("#password_confirmation").keyup(function() {
				var pas1 = $('#password').val();
				var pas2 = $('#password_confirmation').val();
				var get_text = $("#msg").text();

				if (pas1 != pas2) {
					$('#not_match').text('Password Tidak Cocok');
					$('#simpan').prop('disabled', true);
				} else {
					if(pas1 != pas2 || get_text == "Username sudah digunakan!") {
						$('#not_match').text(' ');
						$('#simpan').prop('disabled', true);	
					} else {
						$('#not_match').text(' ');
						$('#simpan').removeProp('disabled');
					}
				}
			});

			$("#username").on("input", function(e) {
				$('#msg').hide();
				if($("#username").val() == null || $("#username").val() == "") {
					$("#msg").show();
					$("#msg").html("Username is required field.").css("color", "red");
				} else {
					$.ajax({
						type: "POST",
						url: "<?php echo base_url('datauser/user/get_username_availability'); ?>",
						data: $("#create_user").serialize(),
						dataType: "html",
						cache: false,
						success: function(msg) {
							$("#msg").show();
							$("#msg").html(msg);
							var get_text = $("#msg").text();
							var pas1 = $('#password').val();
							var pas2 = $('#password_confirmation').val();
							console.log(pas1);
							if(pas1 != pas2 || get_text == "Username sudah digunakan!") {
								$('#not_match').text(' ');
								$('#simpan').prop('disabled', true);	
							} else {
								$('#not_match').text(' ');
								$('#simpan').removeProp('disabled');
							}
						},
						error: function(jqXHR, textStatus, errorThrown) {
							$("#msg").show();
							$("#msg").html(textStatus +" "+errorThrown);
						}
					});
				}
			});
		});
	</script>
</body>
</html>

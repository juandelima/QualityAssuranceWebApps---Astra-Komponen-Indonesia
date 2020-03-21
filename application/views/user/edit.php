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
			<?php if($this->session->flashdata('error')) {
			?>
				<script>
					jQuery(document).ready(function($) {
						var opts = {
							"closeButton": true,
							"debug": false,
							"positionClass": "toast-top-full-width",
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
			
						toastr.error("<?php echo $this->session->flashdata('error'); ?>", "ERROR", opts);
					});
				</script>
			<?php 
				}
			?>
			<h2>Edit User</h2>
			<ol class="breadcrumb bc-3">
				<li>
					<a href="<?php echo base_url('datauser/user') ?>"><i class="entypo-home"> Data User</i></a>
				</li>
				<li class="active">
					<strong>Edit User</strong>
				</li>
			</ol>
			<div class="row">
				<div class="col-md-12">
				<div class="panel panel-primary" data-collapsed="0">
						<div class="panel-body">
							<form role="form" id="create_user" class="form-horizontal" enctype="multipart/form-data" action="<?php echo base_url('datauser/user/edit/'.$user->id_users); ?>" method="post">
								<div class="form-group">
									<label class="col-sm-3 control-label" style="text-align:left;">&emsp;&emsp;FOTO PROFILE	</label>
									<div class="col-sm-5">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
												<img <?php if(!empty($user->photo)) { ?> src="<?php echo base_url()?>assets/images/foto_profile/<?php echo $user->photo; ?>" <?php } else { ?> src="http://placehold.it/200x150" <?php } ?>alt="...">
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
											<div>
												<span class="btn btn-white btn-file" <?php if($this->session->userdata['role'] == 'Super Admin') { ?> disabled <?php } ?>>
													<span class="fileinput-new">Pilih Photo</span>
													<span class="fileinput-exists">Ubah</span>
													<input type="file" name="photo" accept="image/*" <?php if($this->session->userdata['role'] == 'Super Admin') { ?> disabled <?php } ?>>
												</span>
												<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Hapus</a>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">&emsp;&emsp;FULL NAME</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo $user->full_name; ?>" placeholder="ex: juan valerian delima" required <?php if($this->session->userdata['role'] == 'Super Admin') { ?> readonly <?php } ?>>
									</div>
								</div>
								<div class="form-group">
									<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">&emsp;&emsp;USERNAME</label>
									<div class="col-sm-5">
												<input type="text" class="form-control" id="username" name="username" value="<?php echo $user->username; ?>" placeholder="ex: juandelima" required <?php if($this->session->userdata['role'] == 'Super Admin') { ?> readonly <?php } ?>>
									</div>
									<div id="msg"></div>
								</div>
									
									<?php if($this->session->userdata['role'] == 'Super Admin') { ?>
										<!-- <div class="form-group">
											<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">&emsp;&emsp;RESET PASSWORD</label>
											<div class="col-sm-5">
												<a href="javascript:;" onclick="jQuery('#reset_password').modal('show', {backdrop: 'static'});" class="btn btn-danger btn-block" href="#">RESET PASSWORD</a>
											</div>
										</div> -->
									<?php } else { ?>
										<div class="form-group">
											<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">&emsp;&emsp;OLD PASSWORD</label>
											<div class="col-sm-5">
												<input type="password" class="form-control" id="old_password" name="old_password" placeholder="******">
											</div>
											<div id="old_pass"></div>
										</div>
										<div class="form-group">
											<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">&emsp;&emsp;NEW PASSWORD</label>
											<div class="col-sm-5">
												<input type="password" class="form-control" id="password" name="password" placeholder="******">
											</div>
											<input tabindex="6" type="checkbox" class="icheck-4" id="show">
											<label for="minimal-checkbox-2-4">Show Password</label>
										</div>
										<div class="form-group">
											<label for="field-1" class="col-sm-3 control-label" style="text-align:left;">&emsp;&emsp;CONFIRM NEW PASSWORD</label>
											<div class="col-sm-5">
												<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="******">
											</div>
											<div style="color:red;padding-top: 8px;" id="not_match"></div>
										</div>
									<?php } ?>
								<div class="form-group">
									<div class="row">
										<div class="col-md-12">
											<label class="col-sm-3 control-label" style="text-align:left;">&emsp;&emsp;ROLE</label>
											<div class="col-sm-5">
												<select name="role" class="form-control">
													<?php 
														$arr_option = ["Super Admin", "Admin", "User"];
														for($i = 0; $i < count($arr_option); $i++) { 
													?>
														<option <?php if($user->role == $arr_option[$i]) { ?> selected <?php } ?>value="<?php echo $arr_option[$i]; ?>"><?php echo $arr_option[$i]; ?></option>
													<?php 
														}
													?>
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
							<div class="modal fade" id="reset_password">
								<div class="modal-dialog" style="width: 50%;">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h4 class="modal-title">Reset Password</h4>
										</div>
										<form role="form" class="form-horizontal" action="<?php echo base_url('datauser/user/reset_password/'.$user->id_users); ?>" method="post">
											<div class="modal-body">
												<strong>ANDA YAKIN RESET PASSWORD USER <?php echo strtoupper($user->full_name); ?>? </strong>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
												<button type="submit" class="btn btn-danger">Yes</button>
											</div>
										</form>
									</div>
								</div>
							</div>
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
			$("#password").attr('readonly', true);
			$("#password_confirmation").attr('readonly', true);
			// $('#simpan').prop('disabled', true);	
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

			$("#username").keyup(function() {
				$('#msg').hide();
				if($("#username").val() == null || $("#username").val() == "") {
					$("#msg").show();
					$("#msg").html("Username tidak boleh kosong!").css("color", "red");
					$('#simpan').prop('disabled', true);
				} else {
					$.ajax({
						type: "POST",
						url: "<?php echo base_url('datauser/user/change_username_whenLoged/'.$user->id_users); ?>",
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

			$("#old_password").keyup(function() {
				$("#old_pass").hide();
				if($("#old_password").val() == null || $("#old_password").val() == "") { 
					$("#password").attr('readonly', true);
					$("#password_confirmation").attr('readonly', true);
				} else {
					var old_password = $("#old_password").val();
					$.ajax({
						type: "POST",
						url: "<?php echo base_url('datauser/user/cek_old_password/'.$user->id_users); ?>",
						data: $("#create_user").serialize(),
						dataType: "html",
						cache: false,
						success: function(msg) { 
							$("#old_pass").show();
							$("#old_pass").html(msg);
							var get_pas1 = $("#password").val();
							var get_pas2 = $("#password_confirmation").val();
							var get_text_pass = $("#old_pass").text();
							if(get_text_pass === "OLD PASSWORD IS CORRECT!") {
								$("#password").attr('readonly', false);
								$("#password_confirmation").attr('readonly', false);
								// $('#simpan').prop('disabled', true);
							} else {
								$("#password").attr('readonly', true);
								$("#password_confirmation").attr('readonly', true);
								// $('#simpan').prop('disabled', true);
							}
						},
						error: function(jqXHR, textStatus, errorThrown) {
							$("#old_pass").show();
							$("#old_pass").html(textStatus +" "+errorThrown);
						}
					});
				}
			});
		});
	</script>
</body>
</html>

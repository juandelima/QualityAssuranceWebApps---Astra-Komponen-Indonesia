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
        table.dataTable.no-footer {
    		border-bottom: 1px solid #f9f9f9 !important;
		}

        @keyframes loading {
			40% {
				background-position: 100% 0;
			}
			100% {
				background-position: 100% 0;
			}
		}

		.tbody .loading {
			position: relative;
		}

		.tbody .loading .bar {
			background-color: #e7e7e7;
			height: 14px;
			border-radius: 7px;
			width: 80%;
		}

		.tbody .loading:after {
			position: absolute;
			transform: translateY(-50%);
			top: 50%;
			left: 0;
			content: "";
			display: block;
			width: 100%;
			height: 24px;
			background-image: linear-gradient(100deg, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.5) 60%, rgba(255, 255, 255, 0) 80%);
			background-size: 200px 24px;
			background-position: -100px 0;
			background-repeat: no-repeat;
			animation: loading 1s infinite;
		}

        .hide-main-table {
			display: none;
		}

		.show-main-table {
			display: block;
		}

		.remove-skeleton-table {
			display: none;
		}

		.show-skeleton-table {
			display: block;
		}
	</style>
</head>
<body class="page-body skin-facebook" data-url="http://neon.dev">
	<div class="page-container">
		<?php $this->load->view('_partials/navbar.php'); ?>
		<div class="main-content">
            <?php $this->load->view('_partials/navbar_head.php'); ?>
            <div class="row">
                <div class="col-md-12">
                    <div id="skeleton-table2">
						<table class="table table-bordered" id="table_skeleton2">
							<thead>
								<tr>
									<th style="text-align: center;" width="1">No</th>
									<th style="text-align: center;">Nama User</th>
									<th style="text-align: center;">Aktivitas</th>
									<th style="text-align: center;">Tanggal</th>
                                    <th style="text-align: center;">Jam</th>
								</tr>
							</thead>
								
							<tbody class="tbody">
								<?php for($i = 0; $i < 10; $i++) {

								?>
								<tr>
									<td class="loading">
										<div class="bar"></div>
									</td>
									<td class="loading">
										<div class="bar"></div>
									</td>
									<td class="loading">
										<div class="bar"></div>
									</td>
									<td class="loading">
									    <div class="bar"></div>
									</td>
									<td class="loading">
										<div class="bar"></div>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
                    <div id="main-table2" class="hide-main-table">
                        <table class="table table-bordered" id="table-aktivitas">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" width="1">No</th>
									<th style="text-align: center;">Nama User</th>
									<th style="text-align: center;">Aktivitas</th>
									<th style="text-align: center;" width="80%">Tanggal</th>
									<th style="text-align: center;" width="10%">Jam</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
</body>
</html>
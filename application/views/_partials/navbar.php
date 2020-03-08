<div class="sidebar-menu">
		<div class="sidebar-menu-inner">

			<header class="logo-env">

				<!-- logo -->
				<div class="logo">
					<a href="<?php echo base_url('dashboard') ?>">
						<img src="<?php echo base_url('assets/images/logo-QA.png'); ?>" width="160" alt="" />
					</a>
				</div>

				<!-- logo collapse icon -->
				<div class="sidebar-collapse">
					<a href="#" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
						<i class="entypo-menu"></i>
					</a>
				</div>


				<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
				<div class="sidebar-mobile-menu visible-xs">
					<a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
						<i class="entypo-menu"></i>
					</a>
				</div>

			</header>

			


			<ul id="main-menu" class="main-menu">
				<!-- add class "multiple-expanded" to allow multiple submenus to open -->
				<!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
				<li <?php if($slug == 'dashboard') { ?> class="active" <?php } ?>>
					<a href="<?php echo base_url('dashboard') ?>">
						<i class="entypo-monitor"></i>
						<span class="title">Dashboard</span>
					</a>
				</li>
				<li class="<?php if($slug == 'listpart' || $slug == 'create_new_part'){ ?>opened active <?php } ?>has-sub">
					<a href="#">
						<i class="entypo-layout"></i>
						<span class="title">Master Data</span>
					</a>
					<ul <?php if($slug == 'listpart' || $slug == 'create_new_part') { ?>class="visible"<?php } ?>>
						<li <?php if($slug == 'listpart' || $slug == 'create_new_part') { ?>class="active"<?php } ?>>
							<a href="<?php echo base_url('masterdata/listpart'); ?>">
								<span class="title">List Part</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="<?php if($slug == 'ahm' || $slug == 'create_customerclaim' || $slug == 'comingsoon'){ ?>opened active <?php } ?>has-sub">
					<a href="#">
						<i class="entypo-newspaper"></i>
						<span class="title">Claim</span>
					</a>
					<ul <?php if($slug == 'ahm' || $slug == 'customerclaim' || $slug == 'comingsoon') { ?>class="visible"<?php } ?>>
						<li class="<?php if($slug == 'ahm' || $slug == 'customerclaim'){ ?>active <?php } ?>">
							<a href="<?php echo base_url('claim/customerclaim') ?>">
								<span class="title">Customer Claim</span>
							</a>
							<!-- <ul>
								<li <?php if($slug == 'ahm' || $slug == 'create_customerclaim') { ?>class="active"<?php } ?>>
									<a href="<?php echo base_url('claim/customerclaim/ahm') ?>">
										<span class="title">AHM</span>
									</a>
								</li>
							</ul> -->
						</li>
						<li <?php if($slug == 'comingsoon') { ?>class="active"<?php } ?>>
							<a href="<?php echo base_url('comingsoon'); ?>" >
								<span class="title">Vendor Claim</span>
							</a>
						</li>
						<li <?php if($slug == 'comingsoon') { ?>class="active"<?php } ?>>
							<a href="<?php echo base_url('comingsoon'); ?>">
								<span class="title">Internal Claim</span>
							</a>
						</li>
						<li <?php if($slug == 'comingsoon') { ?>class="active"<?php } ?>>
							<a href="<?php echo base_url('comingsoon'); ?>">
								<span class="title">Quality Project</span>
							</a>
						</li>
						<li <?php if($slug == 'comingsoon') { ?>class="active"<?php } ?>>
							<a href="<?php echo base_url('comingsoon'); ?>">
								<span class="title">Laboratory</span>
							</a>
						</li>
						<li <?php if($slug == 'comingsoon') { ?>class="active"<?php } ?>>
							<a href="<?php echo base_url('comingsoon'); ?>">
								<span class="title">Others</span>
							</a>
						</li>
					</ul>
				</li>
				<?php if($this->session->userdata['role'] != 'User') { ?>
					<li <?php if($slug == 'user' || $slug == 'create') { ?>class="active"<?php } ?>>
						<a href="<?php echo base_url('datauser/user'); ?>">
							<i class="entypo-users"></i>
							<span class="title">Data User</span>
						</a>
					</li>
				<?php } ?>
				<li>
					<a href="<?php echo base_url('login/logout'); ?>">
						<i class="entypo-logout"></i>
						<span class="title">Log Out</span>
					</a>
				</li>
			</ul>
		</div>
	</div>

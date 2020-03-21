<div class="row">
			<!-- Profile Info and Notifications -->
				<div class="col-md-6 col-sm-8 clearfix">
					<ul class="user-info pull-left pull-none-xsm">
						<!-- Profile Info -->
						<li class="profile-info dropdown"><!-- add class "pull-right" if you want to place this from right -->
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="<?php echo base_url()?>assets/images/foto_profile/<?php echo $this->session->userdata['photo']; ?>" alt="" class="img-circle" width="44" />
								<?php 
                    				echo $this->session->userdata('full_name');
                    			?>
							</a>
							<ul class="dropdown-menu">
								<!-- Reverse Caret -->
								<li class="caret"></li>
								<!-- Profile sub-links -->
								<li>
									<a href="<?php echo base_url('datauser/user/edit_profile/'.$this->session->userdata('id_users')); ?>">
										<i class="entypo-user"></i>
										Edit Profile
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>

				<div class="col-md-6 col-sm-4 clearfix hidden-xs">
					<ul class="list-inline links-list pull-right">
						<li>
							<a href="#" data-toggle="chat" data-collapse-sidebar="1" id="open_chatting">
								<i class="entypo-chat"></i>
								Chat
			
								<span class="badge badge-success chat-notifications-badge is-hidden">0</span>
							</a>
						</li>
						
						<li class="sep"></li>

						<li>
							<a href="<?php echo base_url('login/logout'); ?>">
								Log Out <i class="entypo-logout right"></i>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<hr />

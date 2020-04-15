<div id="chat" class="fixed" data-current-user="<?php echo $this->session->userdata('full_name'); ?>" data-order-by-status="1" data-max-chat-history="25">
	<div class="chat-inner">
		<h2 class="chat-header">
			<a href="#" class="chat-close"><i class="entypo-cancel"></i></a>
            <i class="entypo-users"></i>
			Chat
			<span class="badge badge-success is-hidden">0</span>
		</h2>

        <div class="chat-group">
			<!-- <strong>Work</strong> -->
			<!-- <a href="#"><span class="user-status is-offline"></span><em>Robert J. Garcia</em></a>
			<a href="#"><span class="user-status is-offline"></span><em>Daniel A. Pena</em></a>
			<a href="#"><span class="user-status is-offline"></span><em>Rodrigo E. Lozano</em></a> -->
		</div>
    </div>
    
	<div class="chat-conversation">
        <div class="conversation-header" id="conversation">
            <a href="#" class="conversation-close"><i class="entypo-cancel"></i></a>
            <span class="user-status"></span>
            <span class="display-name"></span>
            <small class="status_login"></small>
        </div>

        <ul class="conversation-body">
            
        </ul>

        <div class="chat-textarea">
            <textarea name="message" class="form-control autogrow" placeholder="Type a message" id="message"></textarea>
        </div>
    </div>
</div>

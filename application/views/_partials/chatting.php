<script>
    jQuery(document).ready(function($) {
        let cek_it = <?php echo $count_user; ?>;
        let current_user = <?php echo $this->session->userdata('id_users'); ?>;
        let root_url = "<?php echo base_url() ?>";
        chatting(root_url, current_user, cek_it);
    });
</script>
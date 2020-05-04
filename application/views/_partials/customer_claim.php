<script>
	jQuery(document).ready(function($) {
		let root_url = "<?php echo base_url(); ?>";
		let count_delivery = <?php echo $count_delivery; ?>;
		let role = "<?php echo $this->session->userdata['role']; ?>";
		let get_data_delivery = '<?php echo $get_data_delivery; ?>';
		customer_claim_table(root_url);
		delivery(root_url, count_delivery, role, get_data_delivery);
    });
</script>
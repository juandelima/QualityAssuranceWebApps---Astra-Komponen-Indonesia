<script>
	jQuery(document).ready(function($) {
		let last_year = "<?php echo $year[count($year) - 1]; ?>";
		let full_year = "<?php echo $year[0]; ?> - <?php echo $year[count($year) - 1]; ?>";
		let count_customer_claim = <?php echo $count_customer_claim; ?>;
		let count_deliv = <?php echo $count_deliv; ?>;
		let root_url = "<?php echo base_url() ?>";
		let full_date = "<?php echo date("d M Y", strtotime($start)).' - '.date("d M Y", strtotime($end)); ?>";
		let date_start = "<?php echo date("Y", strtotime($start)); ?> ";
		let date_end = "<?php echo date("Y", strtotime($end)); ?> ";
		annual_monthly_chart(root_url, last_year, full_year, count_customer_claim, count_deliv);
		detail_chart(root_url, full_date, date_start, date_end, count_customer_claim);
		daily_chart(root_url);
	});
</script>
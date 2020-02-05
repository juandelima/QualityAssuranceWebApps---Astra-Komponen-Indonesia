<script>
<?php
	$index = 0;
	foreach($customer_claim as $data) {
		$id = $data->id_customer_claim;
?>
	var dataStore = (new FusionCharts.DataStore([
		["02-Jan-20", 3],
		["08-Jan-20", 6, 2, 1],
	],[
	{
		"name": "Date",
		"type": "date",
		"format": "%d-%b-%y"
	},
	{
		"name": "Lecet",
		"type": "number"
	},
	{
		"name": "Kotor",
		"type": "number"
	},
	{
		"name": "Tipis",
		"type": "number"
	}
	]
	).getDataTable());
		var chart = new FusionCharts({
		type: 'timeseries',
		renderAt: 'container<?php echo $id; ?>',
		width: '100%',
		height: 450,
		dataSource: {
			data: dataStore,
			caption: {
				text: '<?php echo $data->NAMA_PART; ?>'
			},
			chart: {
				exportEnabled: 1
			},
			subcaption: {
				text: 'Visual & Non Visual'
			},
			yAxis: {
				plot: ['Lecet', 'Kotor', 'Tipis'],
				plottype: 'column',
				title: 'Qty Rejection',
				format: {
						prefix: ''
				}
			}
		}
	}).render();
<?php
		}
?>
</script>

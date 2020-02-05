<script>
	jQuery.noConflict
	var fusionCharts = jQuery.noConflict();
	fusionCharts(document).ready(function($) {
		$("#filter_year").on('change', 'select#year_from', function(e) {
			$("#year_to").empty();
			let year_from = new Date();
			let get_year_from = year_from.getFullYear() - 9;
			let year_now = get_year_from + 9;
			let year_to = $(e.target).val();
			for(let year_from_ = get_year_from; year_from_ <= year_now; year_from_++) {
				$("#year_to").append("<option value='"+year_from_+"'>"+year_from_+"</option>");
			}

			for(let year_from_disable = get_year_from; year_from_disable <= year_to; year_from_disable++) {
				$("#year_to option:contains("+year_from_disable+")").attr("disabled","disabled");
			}

			if(year_to === "" || year_to === null) {
				$("#year_to").val(null);
				for(let year_from_del = get_year_from; year_from_del <= year_now; year_from_del++) {
					$("#year_to option[value="+year_from_del+"]").remove();
				}
				
			}
		});

		$("#filter_year").on('change', 'select#year_to', function(e) {
			let year_from = $('#year_from').val();
			let year_to = $(e.target).val();
			// console.log(year_to);
			if(year_from == "" && year_to == "") {
				year = "<?php echo $year[0]; ?> - <?php echo $year[count($year) - 1]; ?>";
			} else {
				year = year_from+" - "+year_to;
			} 

			$.ajax({
				type: "GET",
				url: "<?php echo base_url('dashboard/filter_by_year'); ?>",
				data: $("#filter_year").serialize(),
				dataType: "JSON",
				cache: false,
				beforeSend: function() {
					$("#reloading_year").trigger("click");
				},
				success: function(data_year) {
					FusionCharts.ready(function() {
						const chartDataYear = [];
						const chartValueYear = [];
						const chartPpmYear = [];
						let obj = data_year.dataYears;
						for(let key in obj) {
							let defect = parseInt(obj[key]);
							let tot_rejection = 0;
							for(let key2 in obj) {
								tot_rejection = parseInt(tot_rejection) + parseInt(obj[key2]);
							}
							let dataLabel = {
								"label": key,
							}
							let dataValue = {
								"value": obj[key],	
							}
							let ppm = (defect / parseInt(tot_rejection)) * 1000000;
							let dataPpm = {
								"value": ppm,
							}
							chartDataYear.push(dataLabel);
							chartValueYear.push(dataValue);
							chartPpmYear.push(dataPpm);
						}
						var revenueChart = new FusionCharts({
							type: 'mscombidy2d',
							renderAt: 'container_year',
							width: '100%',
							height: '380',
							dataFormat: 'json',
							dataSource: {
							"chart": {
								"caption": "Annual Rejection Graph - QTY & PPM (AHM)",
								"subCaption": year,
								"xAxisname": "Year",
								"pYAxisName": "QTY",
								"sYAxisName": "PPM",
								"numberPrefix": "",
								"theme": "fusion",
								"showValues": "0",
								"labelDisplay": "rotate",
								"lineColor": "#fc3c3c",
								"palettecolors": "#29c3be"
							},
							"categories": [{
								"category": chartDataYear
							}],
							"dataset": [{
								"seriesName": "Total annual rejection",
								"showValues": "0",
								"numberSuffix": "",
								"data": chartValueYear
							}, {
								"seriesName": "PPM",
								"parentYAxis": "S",
								"renderAs": "line",
								"data": chartPpmYear
							}]
							}
						}).render();
					});

				},
				error: function(jqXHR, textStatus, errorThrown) {
					$("#error_text").text(textStatus +" "+errorThrown);
					$("#modal-error-ajax").show();
				}
			});
		});

		$("#filter_month").on('change', 'select#year', function(e) {
			let year = $(e.target).val();
			if(year == "" || year == null) {
				year ="<?php echo $year[count($year) - 1]; ?>";
			}
			$.ajax({
				type: "GET",
				url: "<?php echo base_url('dashboard/filter_by_month'); ?>",
				data: $("#filter_month").serialize(),
				dataType: "JSON",
				cache: false,
				beforeSend: function(data_filter) {
					$("#reloading_month").trigger("click");
				},
				success: function(data_filter) {
						FusionCharts.ready(function() {
							const chartDataMonth = [];
							const chartValueMonth = [];
							const chartPpmMonth = [];
							let obj = data_filter.dataMonthly;
							for(let key in obj) {
								let defect = parseInt(obj[key]);
								let tot_rejection = 0;
								for(let key2 in obj) {
									tot_rejection = parseInt(tot_rejection) + parseInt(obj[key2]);
								}
								let dataLabel = {
									"label": key,
								}
								let dataValue = {
									"value": obj[key],	
								}
								let ppm = (defect / parseInt(tot_rejection)) * 1000000;
								let dataPpm = {
									"value": ppm,
								}
								chartDataMonth.push(dataLabel);
								chartValueMonth.push(dataValue);
								chartPpmMonth.push(dataPpm);
							}
							var revenueChart = new FusionCharts({
								type: 'mscombidy2d',
								renderAt: 'container_month',
								width: '100%',
								height: '380',
								dataFormat: 'json',
								dataSource: {
								"chart": {
									"caption": "Monthly Rejection Graph - QTY & PPM (AHM)",
									"subCaption": year,
									"xAxisname": "Month",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"labelDisplay": "rotate",
									"animation": "1" 
								},
								"categories": [{
									"category": chartDataMonth
								}],
								"dataset": [{
									"seriesName": "Total monthly rejection",
									"showValues": "0",
									"numberSuffix": "",
									"data": chartValueMonth
								}, {
									"seriesName": "PPM",
									"parentYAxis": "S",
									"renderAs": "line",
									"data": chartPpmMonth
								}]
								}
							}).render();
						});
				},
				error: function(jqXHR, textStatus, errorThrown) {
					$("#error_text").text(textStatus +" "+errorThrown);
					$("#modal-error-ajax").show();
				}
			});
		});

		var monthly_count_customer_claim = <?php echo $count_customer_claim; ?>;
		function monthly_chart() {
			$.ajax({
				type: "GET",
				url: "<?php echo base_url('dashboard/filter_by_month'); ?>",
				data: $("#filter_month").serialize(),
				dataType: "JSON",
				cache: false,
				beforeSend: function() {
					$("#reloading_month").trigger("click");
				},
				success: function(data_filter_monthly) {
					let customer_claim_monthly = data_filter_monthly.count_customer_claim_monthly;
					if(monthly_count_customer_claim != customer_claim_monthly) {
						monthly_count_customer_claim = customer_claim_monthly;
						FusionCharts.ready(function() {
							const chartDataMonth = [];
							const chartValueMonth = [];
							const chartPpmMonth = [];
							let obj = data_filter_monthly.dataMonthly;
							for(let key in obj) {
								let defect = parseInt(obj[key]);
								let tot_rejection = 0;
								for(let key2 in obj) {
									tot_rejection = parseInt(tot_rejection) + parseInt(obj[key2]);
								}
								let dataLabel = {
									"label": key,
								}
								let dataValue = {
									"value": obj[key],	
								}
								let ppm = (defect / parseInt(tot_rejection)) * 1000000;
								let dataPpm = {
									"value": ppm,
								}
								chartDataMonth.push(dataLabel);
								chartValueMonth.push(dataValue);
								chartPpmMonth.push(dataPpm);
							}
							var revenueChart = new FusionCharts({
								type: 'mscombidy2d',
								renderAt: 'container_month',
								width: '100%',
								height: '380',
								dataFormat: 'json',
								dataSource: {
									"chart": {
										"caption": "Monthly Rejection Graph - QTY & PPM (AHM)",
										"subCaption": "<?php echo $year[count($year) - 1]; ?>",
										"xAxisname": "Month",
										"pYAxisName": "QTY",
										"sYAxisName": "PPM",
										"numberPrefix": "",
										"theme": "fusion",
										"showValues": "0",
										"labelDisplay": "rotate",
										"animation": "1" 
									},
									"categories": [{
										"category": chartDataMonth
									}],
									"dataset": [{
										"seriesName": "Total monthly rejection",
										"showValues": "0",
										"numberSuffix": "",
										"data": chartValueMonth
									}, {
										"seriesName": "PPM",
										"parentYAxis": "S",
										"renderAs": "line",
										"data": chartPpmMonth
									}]
								}
							}).render();
						});
					} else {
						monthly_count_customer_claim = customer_claim_monthly;
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					$("#error_text").text(textStatus +" "+errorThrown);
					$("#modal-error-ajax").show();
				}
			});
		}

		var annual_count_customer_claim = <?php echo $count_customer_claim; ?>;
		function annual_chart() {
			$.ajax({
				type: "GET",
				url: "<?php echo base_url('dashboard/filter_by_year'); ?>",
				data: $("#filter_year").serialize(),
				dataType: "JSON",
				cache: false,
				beforeSend: function() {
					$("#reloading_year").trigger("click");
				},
				success: function(data_year) {
					let get_count_customer_claim = data_year.count_customer_claim;
					if(annual_count_customer_claim != get_count_customer_claim) {
						annual_count_customer_claim = get_count_customer_claim;
						FusionCharts.ready(function() {
							const chartDataYear = [];
							const chartValueYear = [];
							const chartPpmYear = [];
							let obj = data_year.dataYears;
							for(let key in obj) {
								let defect = parseInt(obj[key]);
								let tot_rejection = 0;
								for(let key2 in obj) {
									tot_rejection = parseInt(tot_rejection) + parseInt(obj[key2]);
								}
								let dataLabel = {
									"label": key,
								}
								let dataValue = {
									"value": obj[key],	
								}
								let ppm = (defect / parseInt(tot_rejection)) * 1000000;
								let dataPpm = {
									"value": ppm,
								}
								chartDataYear.push(dataLabel);
								chartValueYear.push(dataValue);
								chartPpmYear.push(dataPpm);
							}
							var revenueChart = new FusionCharts({
								type: 'mscombidy2d',
								renderAt: 'container_year',
								width: '100%',
								height: '380',
								dataFormat: 'json',
								dataSource: {
								"chart": {
									"caption": "Annual Rejection Graph - QTY & PPM (AHM)",
									"subCaption": "<?php echo $year[0]; ?> - <?php echo $year[count($year) - 1]; ?>",
									"xAxisname": "Year",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"labelDisplay": "rotate",
									"lineColor": "#fc3c3c",
									"palettecolors": "#29c3be",
									"animation": "1" 
								},
								"categories": [{
									"category": chartDataYear
								}],
								"dataset": [{
									"seriesName": "Total annual rejection",
									"showValues": "0",
									"numberSuffix": "",
									"data": chartValueYear
								}, {
									"seriesName": "PPM",
									"parentYAxis": "S",
									"renderAs": "line",
									"data": chartPpmYear
								}]
								}
							}).render();
						});	
					} else {
						annual_count_customer_claim = get_count_customer_claim;
					}
				},

				error: function(jqXHR, textStatus, errorThrown) {
					$("#error_text").text(textStatus +" "+errorThrown);
					$("#modal-error-ajax").show();
				}
			});
		}

		function start_year_chart() {
			$.ajax({
				type: "GET",
				url: "<?php echo base_url('dashboard/filter_by_year'); ?>",
				data: $("#filter_year").serialize(),
				dataType: "JSON",
				cache: false,
				beforeSend: function() {
					$("#reloading_year").trigger("click");
				},
				success: function(data_year) {
					function load_chart_annual() {
						FusionCharts.ready(function() {
							const chartDataYear = [];
							const chartValueYear = [];
							const chartPpmYear = [];
							let obj = data_year.dataYears;
							for(let key in obj) {
								let defect = parseInt(obj[key]);
								let tot_rejection = 0;
								for(let key2 in obj) {
									tot_rejection = parseInt(tot_rejection) + parseInt(obj[key2]);
								}
								let dataLabel = {
									"label": key,
								}
								let dataValue = {
									"value": obj[key],	
								}
								let ppm = (defect / parseInt(tot_rejection)) * 1000000;
								let dataPpm = {
									"value": ppm,
								}
								chartDataYear.push(dataLabel);
								chartValueYear.push(dataValue);
								chartPpmYear.push(dataPpm);
							}
							var revenueChart = new FusionCharts({
								type: 'mscombidy2d',
								renderAt: 'container_year',
								width: '100%',
								height: '380',
								dataFormat: 'json',
								dataSource: {
								"chart": {
									"caption": "Annual Rejection Graph - QTY & PPM (AHM)",
									"subCaption": "<?php echo $year[0]; ?> - <?php echo $year[count($year) - 1]; ?>",
									"xAxisname": "Year",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"labelDisplay": "rotate",
									"lineColor": "#fc3c3c",
									"palettecolors": "#29c3be"
								},
								"categories": [{
									"category": chartDataYear
								}],
								"dataset": [{
									"seriesName": "Total annual rejection",
									"showValues": "0",
									"numberSuffix": "",
									"data": chartValueYear
								}, {
									"seriesName": "PPM",
									"parentYAxis": "S",
									"renderAs": "line",
									"data": chartPpmYear
								}]
								}
							}).render();
						});
					}
					load_chart_annual();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					$("#error_text").text(textStatus +" "+errorThrown);
					$("#modal-error-ajax").show();
				}
			});
		}

		function start_monthly_chart() {
			$.ajax({
				type: "GET",
				url: "<?php echo base_url('dashboard/filter_by_month'); ?>",
				data: $("#filter_month").serialize(),
				dataType: "JSON",
				cache: false,
				beforeSend: function(data_filter) {
					$("#reloading_month").trigger("click");
				},
				success: function(data_filter) {
					function load_data_monthly() {
						FusionCharts.ready(function() {
							const chartDataMonth = [];
							const chartValueMonth = [];
							const chartPpmMonth = [];
							let obj = data_filter.dataMonthly;
							for(let key in obj) {
								let defect = parseInt(obj[key]);
								let tot_rejection = 0;
								for(let key2 in obj) {
									tot_rejection = parseInt(tot_rejection) + parseInt(obj[key2]);
								}
								let dataLabel = {
									"label": key,
								}
								let dataValue = {
									"value": obj[key],	
								}
								let ppm = (defect / parseInt(tot_rejection)) * 1000000;
								let dataPpm = {
									"value": ppm,
								}
								chartDataMonth.push(dataLabel);
								chartValueMonth.push(dataValue);
								chartPpmMonth.push(dataPpm);
							}
							var revenueChart = new FusionCharts({
								type: 'mscombidy2d',
								renderAt: 'container_month',
								width: '100%',
								height: '380',
								dataFormat: 'json',
								dataSource: {
								"chart": {
									"caption": "Monthly Rejection Graph - QTY & PPM (AHM)",
									"subCaption": "<?php echo $year[count($year) - 1]; ?>",
									"xAxisname": "Month",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"labelDisplay": "rotate",
									"animation": "1" 
								},
								"categories": [{
									"category": chartDataMonth
								}],
								"dataset": [{
									"seriesName": "Total monthly rejection",
									"showValues": "0",
									"numberSuffix": "",
									"data": chartValueMonth
								}, {
									"seriesName": "PPM",
									"parentYAxis": "S",
									"renderAs": "line",
									"data": chartPpmMonth
								}]
								}
							}).render();
						});
					}
					load_data_monthly();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					$("#error_text").text(textStatus +" "+errorThrown);
					$("#modal-error-ajax").show();
				}
			});
		}

		start_year_chart();
		start_monthly_chart();

		let timer_annual = setInterval(annual_chart, 5000);
		$("#body_annual_year").hover(
			function() {
				clearInterval(timer_annual);
			},
			function() {
				timer_annual = setInterval(annual_chart, 5000);
			}
		);

		let timer_monthly = setInterval(monthly_chart, 5000);
		$("#body_monthly").hover(
			function() {
				clearInterval(timer_monthly);
			},
			function() {
				timer_monthly = setInterval(monthly_chart, 5000);
			}
		);

		$("#reset_year").click(function() {
			$("#year_from").val(null);
			// $("#year_to").val(null);
			start_year_chart();
		});

		$("#reset_month").click(function() {
			$("#year").val(null);
			start_monthly_chart();
		});
});
</script>

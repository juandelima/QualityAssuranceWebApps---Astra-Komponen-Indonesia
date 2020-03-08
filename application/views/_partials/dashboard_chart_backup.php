<script>
	jQuery.noConflict
	var fusionCharts = jQuery.noConflict();
	fusionCharts(document).ready(function($) {
		$("#filter_year").on('change', 'select#year_from', function(e) {
			// $("#year_to").empty();
			let year_from = new Date();
			let get_year_from = year_from.getFullYear() - 9;
			let year_now = get_year_from + 9;
			let year_to = $(e.target).val();
			// for(let year_from_ = get_year_from; year_from_ <= year_now; year_from_++) {
			// 	$("#year_to").append("<option value='"+year_from_+"'>"+year_from_+"</option>");
			// }

			for(let year_from_disable = get_year_from; year_from_disable <= year_to; year_from_disable++) {
				$("#year_to option:contains("+year_from_disable+")").attr("disabled","disabled");
			}

			// if(year_to === "" || year_to === null) {
			// 	$("#year_to").val(null);
			// 	for(let year_from_del = get_year_from; year_from_del <= year_now; year_from_del++) {
			// 		$("#year_to option[value="+year_from_del+"]").remove();
			// 	}
			// }
		});

		$("#filter_year").on('change', 'select#year_to', function(e) {
			let year_from = $('#year_from').val();
			let year_to = $(e.target).val();
			let year;
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
						let ppm;
						let obj = data_year.dataYears;
						let index = 0;
						for(let key in obj) {
							let defect = parseInt(obj[key]);
							let dataLabel = {
								"label": key,
							}
							let dataValue = {
								"value": obj[key],	
							}
							if(data_year.ppm[index] > 0) {
								ppm = (defect / parseInt(data_year.ppm[index])) * 1000000;
							} else {
								ppm = 0;
							}
								
							let dataPpm = {
								"value": ppm,
							}
							chartDataYear.push(dataLabel);
							chartValueYear.push(dataValue);
							chartPpmYear.push(dataPpm);
							index += 1;
						}
						
						var revenueChart = new FusionCharts({
							type: 'mscombidy2d',
							renderAt: 'container_year',
							width: '100%',
							height: '380',
							dataFormat: 'json',
							dataSource: {
							"chart": {
								"caption": "Annual Rejection Graph - QTY & PPM",
								"subCaption": year,
								"xAxisname": "Year",
								"pYAxisName": "QTY",
								"sYAxisName": "PPM",
								"numberPrefix": "",
								"theme": "fusion",
								"showValues": "0",
								"exportenabled": "1",
								"exportfilename": "Annual Rejection Graph - QTY & PPM",
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
								"exportenabled": "1",
								"exportfilename": "Annual Rejection Graph - QTY & PPM",
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
							let index = 0;
							let ppm;
							for(let key in obj) {
								// console.log(index);
								let defect = parseInt(obj[key]);
								
								let dataLabel = {
									"label": key,
								}
								let dataValue = {
									"value": obj[key],	
								}
								if(data_filter.ppm[index] > 0) {
									ppm = (defect / parseInt(data_filter.ppm[index])) * 1000000;
								} else {
									ppm = 0;
								}
								let dataPpm = {
									"value": ppm,
								}
								index += 1;
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
									"caption": "Monthly Rejection Graph - QTY & PPM",
									"subCaption": year,
									"xAxisname": "Month",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"exportenabled": "1",
									"exportfilename": "Monthly Rejection Graph - QTY & PPM",
									"labelDisplay": "rotate",
									"animation": "1" 
								},
								"categories": [{
									"category": chartDataMonth
								}],
								"dataset": [{
									"seriesName": "Total monthly rejection",
									"showValues": "0",
									"exportenabled": "1",
									"exportfilename": "Monthly Rejection Graph - QTY & PPM",
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
		var monthly_count_deliv = <?php echo $count_deliv; ?>;
		function monthly_chart() {
			let year_from = $('#year_from').val();
			let year_to = $('#year_to').val();
			let caption_year;
			if(year_from == "" && year_to == "") {
				caption_year = "<?php echo $year[0]; ?> - <?php echo $year[count($year) - 1]; ?>";
			} else {
				caption_year = year_from+" - "+year_to;
			}

			let year = $("#year").val();
			let caption;
			if(year != "") {
				caption = year;
			} else {
				caption = "<?php echo $year[count($year) - 1]; ?>";
			}
			$.ajax({
				type: "GET",
				url: "<?php echo base_url('dashboard/filter_by_month'); ?>",
				data: $("#filter_month").serialize(),
				dataType: "JSON",
				cache: false,
				beforeSend: function() {
					$("#reloading_month").trigger("click");
				},
				success: function(data_filter) {
					let customer_claim_monthly = data_filter.count_customer_claim_monthly;
					let get_count_deliv = data_filter.count_deliv;
					// console.log(monthly_count_customer_claim);
					// console.log(customer_claim_monthly);
					if(monthly_count_customer_claim != customer_claim_monthly || monthly_count_deliv != get_count_deliv) {
						monthly_count_customer_claim = customer_claim_monthly;
						monthly_count_deliv = get_count_deliv;
						FusionCharts.ready(function() {
							const chartDataMonth = [];
							const chartValueMonth = [];
							const chartPpmMonth = [];
							let obj = data_filter.dataMonthly;
							let index = 0;
							let ppm;
							for(let key in obj) {
								// console.log(index);
								let defect = parseInt(obj[key]);
								
								let dataLabel = {
									"label": key,
								}
								let dataValue = {
									"value": obj[key],	
								}
								if(data_filter.ppm[index] > 0) {
									ppm = (defect / parseInt(data_filter.ppm[index])) * 1000000;
								} else {
									ppm = 0;
								}
								let dataPpm = {
									"value": ppm,
								}
								index += 1;
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
									"caption": "Monthly Rejection Graph - QTY & PPM",
									"subCaption": caption,
									"xAxisname": "Month",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"exportenabled": "1",
									"exportfilename": "Monthly Rejection Graph - QTY & PPM",
									"labelDisplay": "rotate",
									"animation": "1" 
								},
								"categories": [{
									"category": chartDataMonth
								}],
								"dataset": [{
									"seriesName": "Total monthly rejection",
									"showValues": "0",
									"exportenabled": "1",
									"exportfilename": "Monthly Rejection Graph - QTY & PPM",
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
						monthly_count_deliv = get_count_deliv;
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					$("#error_text").text(textStatus +" "+errorThrown);
					$("#modal-error-ajax").show();
				}
			});
		}

		var annual_count_customer_claim = <?php echo $count_customer_claim; ?>;
		var annual_count_deliv = <?php echo $count_deliv; ?>;
		function annual_chart() {
			let year_from = $('#year_from').val();
			let year_to = $('#year_to').val();
			let caption_year;
			if(year_from == "" && year_to == "") {
				caption_year = "<?php echo $year[0]; ?> - <?php echo $year[count($year) - 1]; ?>";
			} else {
				caption_year = year_from+" - "+year_to;
			}

			let year = $("#year").val();
			let caption;
			if(year != "") {
				caption = year;
			} else {
				caption = "<?php echo $year[count($year) - 1]; ?>";
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
					let get_count_customer_claim = data_year.count_customer_claim;
					let get_count_deliv = data_year.count_deliv;
					if(annual_count_customer_claim != get_count_customer_claim || annual_count_deliv != get_count_deliv) {
						annual_count_customer_claim = get_count_customer_claim;
						annual_count_deliv = get_count_deliv;
						FusionCharts.ready(function() {
							const chartDataYear = [];
							const chartValueYear = [];
							const chartPpmYear = [];
							let ppm;
							let obj = data_year.dataYears;
							let index = 0;
							for(let key in obj) {
								let defect = parseInt(obj[key]);
								let dataLabel = {
									"label": key,
								}
								let dataValue = {
									"value": obj[key],	
								}
								if(data_year.ppm[index] > 0) {
									ppm = (defect / parseInt(data_year.ppm[index])) * 1000000;
								} else {
									ppm = 0;
								}
								
								let dataPpm = {
									"value": ppm,
								}
								chartDataYear.push(dataLabel);
								chartValueYear.push(dataValue);
								chartPpmYear.push(dataPpm);
								index += 1;
							}
							var revenueChart = new FusionCharts({
								type: 'mscombidy2d',
								renderAt: 'container_year',
								width: '100%',
								height: '380',
								dataFormat: 'json',
								dataSource: {
								"chart": {
									"caption": "Annual Rejection Graph - QTY & PPM",
									"subCaption": caption_year,
									"xAxisname": "Year",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"exportenabled": "1",
									"exportfilename": "Annual Rejection Graph - QTY & PPM",
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
									"exportenabled": "1",
									"exportfilename": "Annual Rejection Graph - QTY & PPM",
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
						annual_count_deliv = get_count_deliv;
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
					// console.log(data_year.ppm);
					function load_chart_annual() {
						FusionCharts.ready(function() {
							const chartDataYear = [];
							const chartValueYear = [];
							const chartPpmYear = [];
							let ppm;
							let obj = data_year.dataYears;
							let index = 0;
							for(let key in obj) {
								let defect = parseInt(obj[key]);
								let dataLabel = {
									"label": key,
								}
								let dataValue = {
									"value": obj[key],	
								}
								if(data_year.ppm[index] > 0) {
									ppm = (defect / parseInt(data_year.ppm[index])) * 1000000;
								} else {
									ppm = 0;
								}
								
								let dataPpm = {
									"value": ppm,
								}
								chartDataYear.push(dataLabel);
								chartValueYear.push(dataValue);
								chartPpmYear.push(dataPpm);
								index += 1;
							}
							var revenueChart = new FusionCharts({
								type: 'mscombidy2d',
								renderAt: 'container_year',
								width: '100%',
								height: '380',
								dataFormat: 'json',
								dataSource: {
								"chart": {
									"caption": "Annual Rejection Graph - QTY & PPM",
									"subCaption": "<?php echo $year[0]; ?> - <?php echo $year[count($year) - 1]; ?>",
									"xAxisname": "Year",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"exportenabled": "1",
									"exportfilename": "Annual Rejection Graph - QTY & PPM",
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
									"exportenabled": "1",
									"exportfilename": "Annual Rejection Graph - QTY & PPM",
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
					// console.log(data_filter.ppm);
					function load_data_monthly() {
						FusionCharts.ready(function() {
							const chartDataMonth = [];
							const chartValueMonth = [];
							const chartPpmMonth = [];
							let obj = data_filter.dataMonthly;
							let index = 0;
							let ppm;
							for(let key in obj) {
								// console.log(index);
								let defect = parseInt(obj[key]);
								
								let dataLabel = {
									"label": key,
								}
								let dataValue = {
									"value": obj[key],	
								}
								if(data_filter.ppm[index] > 0) {
									ppm = (defect / parseInt(data_filter.ppm[index])) * 1000000;
								} else {
									ppm = 0;
								}
								let dataPpm = {
									"value": ppm,
								}
								index += 1;
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
									"caption": "Monthly Rejection Graph - QTY & PPM",
									"subCaption": "<?php echo $year[count($year) - 1]; ?>",
									"xAxisname": "Month",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"exportenabled": "1",
									"exportfilename": "Monthly Rejection Graph - QTY & PPM",
									"labelDisplay": "rotate",
									"animation": "1" 
								},
								"categories": [{
									"category": chartDataMonth
								}],
								"dataset": [{
									"seriesName": "Total monthly rejection",
									"showValues": "0",
									"exportenabled": "1",
									"exportfilename": "Monthly Rejection Graph - QTY & PPM",
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
					$("#modal-error-ajax").modal('show');
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
			let year_from = new Date();
			let get_year_from = year_from.getFullYear() - 9;
			let year_now = get_year_from + 9;
			// console.log(year_now);
			$("#annual_customer").val(null);
			$("#annual_status_claim").val(null);
			$("#year_from").val(get_year_from);
			$("#year_to").val(year_now);
			start_year_chart();
		});


		$("#reset_month").click(function() {
			let year_from = new Date();
			let get_year_from = year_from.getFullYear() - 9;
			let year_now = get_year_from + 9;
			$("#monthly_customer").val(null);
			$("#monthly_status_claim").val(null);
			$("#year").val(year_now);
			start_monthly_chart();
		});

		function filter_status_claim() {
			$("#filter_status_claim").on('change', "#status_claim", function() {
				let status_claim = $("#status_claim").val();
				// console.log(status_claim);
				let year_from = $('#year_from').val();
				let year_to = $('#year_to').val();
				let caption_year;
				if(year_from == "" && year_to == "") {
					caption_year = "<?php echo $year[0]; ?> - <?php echo $year[count($year) - 1]; ?>";
				} else {
					caption_year = year_from+" - "+year_to;
				}

				let year = $("#year").val();
				let caption;
				
				if(year != "") {
					caption = year;
				} else {
					caption = "<?php echo $year[count($year) - 1]; ?>";
				}

				$("#annual_status_claim").val(status_claim);
				$("#monthly_status_claim").val(status_claim);
				// ANNUAL FILTER
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
								let ppm;
								let obj = data_year.dataYears;
								let index = 0;
								for(let key in obj) {
									let defect = parseInt(obj[key]);
									let dataLabel = {
										"label": key,
									}
									let dataValue = {
										"value": obj[key],	
									}
									if(data_year.ppm[index] > 0) {
										ppm = (defect / parseInt(data_year.ppm[index])) * 1000000;
									} else {
										ppm = 0;
									}
									
									let dataPpm = {
										"value": ppm,
									}
									chartDataYear.push(dataLabel);
									chartValueYear.push(dataValue);
									chartPpmYear.push(dataPpm);
									index += 1;
								}
								var revenueChart = new FusionCharts({
									type: 'mscombidy2d',
									renderAt: 'container_year',
									width: '100%',
									height: '380',
									dataFormat: 'json',
									dataSource: {

									"chart": {
										"caption": "Annual Rejection Graph - QTY & PPM",
										"subCaption": caption_year,
										"xAxisname": "Year",
										"pYAxisName": "QTY",
										"sYAxisName": "PPM",
										"numberPrefix": "",
										"theme": "fusion",
										"showValues": "0",
										"exportenabled": "1",
										"exportfilename": "Annual Rejection Graph - QTY & PPM",
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
										"exportenabled": "1",
										"exportfilename": "Annual Rejection Graph - QTY & PPM",
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
						$("#modal-error-ajax").modal('show');
					}
				});

				// MONTHLY FILTER
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
								let index = 0;
								let ppm;
								for(let key in obj) {
									// console.log(index);
									let defect = parseInt(obj[key]);
									
									let dataLabel = {
										"label": key,
									}
									let dataValue = {
										"value": obj[key],	
									}
									if(data_filter.ppm[index] > 0) {
										ppm = (defect / parseInt(data_filter.ppm[index])) * 1000000;
									} else {
										ppm = 0;
									}
									let dataPpm = {
										"value": ppm,
									}
									index += 1;
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
										"caption": "Monthly Rejection Graph - QTY & PPM",
										"subCaption": caption,
										"xAxisname": "Month",
										"pYAxisName": "QTY",
										"sYAxisName": "PPM",
										"numberPrefix": "",
										"theme": "fusion",
										"showValues": "0",
										"exportenabled": "1",
										"exportfilename": "Monthly Rejection Graph - QTY & PPM",
										"labelDisplay": "rotate",
										"animation": "1" 
									},
									"categories": [{
										"category": chartDataMonth
									}],
									"dataset": [{
										"seriesName": "Total monthly rejection",
										"showValues": "0",
										"exportenabled": "1",
										"exportfilename": "Monthly Rejection Graph - QTY & PPM",
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
				});
			});
		}

		function filter_by_customer() {
			$("#filter_by_customer").on('change', "#by_customer", function() {
				let customer = $("#by_customer").val();
				// let customer_text = $("#by_customer").text();
				
				let year_from = $('#year_from').val();
				let year_to = $('#year_to').val();
				let caption_year;
				if(year_from == "" && year_to == "") {
					caption_year = "<?php echo $year[0]; ?> - <?php echo $year[count($year) - 1]; ?>";
				} else {
					caption_year = year_from+" - "+year_to;
				}

				let year = $("#year").val();
				let caption;
				if(year != "") {
					caption = year;
					console.log(year);
				} else {
					caption = "<?php echo $year[count($year) - 1]; ?>";
				}

				$("#annual_customer").val(customer);
				$("#monthly_customer").val(customer);

				// ANNUAL FILTER
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
								let ppm;
								let obj = data_year.dataYears;
								let index = 0;
								let caption;
								for(let key in obj) {
									let defect = parseInt(obj[key]);
									let dataLabel = {
										"label": key,
									}
									let dataValue = {
										"value": obj[key],	
									}
									if(data_year.ppm[index] > 0) {
										ppm = (defect / parseInt(data_year.ppm[index])) * 1000000;
									} else {
										ppm = 0;
									}
									
									let dataPpm = {
										"value": ppm,
									}
									chartDataYear.push(dataLabel);
									chartValueYear.push(dataValue);
									chartPpmYear.push(dataPpm);
									index += 1;
								}
								var revenueChart = new FusionCharts({
									type: 'mscombidy2d',
									renderAt: 'container_year',
									width: '100%',
									height: '380',
									dataFormat: 'json',
									dataSource: {
									"chart": {
										"caption": "Annual Rejection Graph - QTY & PPM",
										"subCaption": caption_year,
										"xAxisname": "Year",
										"pYAxisName": "QTY",
										"sYAxisName": "PPM",
										"numberPrefix": "",
										"theme": "fusion",
										"showValues": "0",
										"exportenabled": "1",
										"exportfilename": "Annual Rejection Graph - QTY & PPM",
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
										"exportenabled": "1",
										"exportfilename": "Annual Rejection Graph - QTY & PPM",
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
						$("#modal-error-ajax").modal('show');
					}
				});

				// MONTHLY FILTER
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
								let index = 0;
								let ppm;
								for(let key in obj) {
									// console.log(index);
									let defect = parseInt(obj[key]);
									
									let dataLabel = {
										"label": key,
									}
									let dataValue = {
										"value": obj[key],	
									}
									if(data_filter.ppm[index] > 0) {
										ppm = (defect / parseInt(data_filter.ppm[index])) * 1000000;
									} else {
										ppm = 0;
									}
									let dataPpm = {
										"value": ppm,
									}
									index += 1;
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
										"caption": "Monthly Rejection Graph - QTY & PPM",
										"subCaption": caption,
										"xAxisname": "Month",
										"pYAxisName": "QTY",
										"sYAxisName": "PPM",
										"numberPrefix": "",
										"theme": "fusion",
										"showValues": "0",
										"exportenabled": "1",
										"exportfilename": "Monthly Rejection Graph - QTY & PPM",
										"labelDisplay": "rotate",
										"animation": "1" 
									},
									"categories": [{
										"category": chartDataMonth
									}],
									"dataset": [{
										"seriesName": "Total monthly rejection",
										"showValues": "0",
										"exportenabled": "1",
										"exportfilename": "Monthly Rejection Graph - QTY & PPM",
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
				});
			});
		}
		filter_status_claim();
		filter_by_customer();
});
</script>

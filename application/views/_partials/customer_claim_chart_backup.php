<script>
	jQuery(document).ready(function($) {
		$("#filter_chart :checkbox").change(function() {
			if ($(this).is(':checked')) {
				$("#year_list").css("display", "none");
				$("#month_list").css("display", "none");
				$("#date_custome").css("display", "block");
			} else {
				$("#year_list").css("display", "block");
				$("#month_list").css("display", "block");
				$("#date_custome").css("display", "none");
			}
		});

		$('#table-1').DataTable({
			"oLanguage": {
				"sSearch": "Search:",
				"oPaginate": {
					"sPrevious": "Previous",
					"sNext": "Next"
				}
			},
			"pageLength": 10,
			"lengthChange": true,
			"scrollX": true
		});
		<?php
			foreach($customer_claim as $data) {
		?>
			$('#rejections<?php echo $data->id_customer_claim; ?>').DataTable({
				"oLanguage": {
					"sSearch": "Search:",
					"oPaginate": {
						"sPrevious": "Previous",
						"sNext": "Next"
					}
				},
				"pageLength": 5,
				"lengthChange": false
			});

			$('#non<?php echo $data->id_customer_claim; ?>').DataTable({
				"oLanguage": {
					"sSearch": "Search:",
					"oPaginate": {
						"sPrevious": "Previous",
						"sNext": "Next"
					}
				},
				"pageLength": 5,
				"lengthChange": false
			});
		<?php
			}
		?>
		$("#filter_chart").on('change', 'select#part', function(e) {
			let part = $(e.target).val();
			let date_range = $("#date_ranges").val();
			const months = ["Jan", "Feb", "Mar","Apr", "May", "Jun",
			"Jul", "Aug", "Sep", "Okt", "Nov", "Dec"];
			let year = $("#year").val();
			let month = $("#month").val();
			let start = $("[name=daterangepicker_start]").val();
			let end = $("[name=daterangepicker_end]").val();
			let start_date = new Date(start);
			let end_date = new Date(end);
			let formart_start = start_date.getDate()+" "+months[start_date.getMonth()]+" "+start_date.getFullYear();
			let formart_end = end_date.getDate()+" "+months[end_date.getMonth()]+" "+end_date.getFullYear();
			let caption;
			if(date_range != "") {
				if(year != "" && month != "") {
						$("#start").val("");
						$("#end").val("");
						caption = year+" - "+month;
					} else if(year != "") {
						$("#start").val("");
						$("#end").val("");
						caption = year;
					} else if(month != "") {
						$("#start").val("");
						$("#end").val("");
						caption = month;
					} else {
						caption = caption = formart_start+" - "+formart_end;
					}
				} else {
					if(year != "" && month != "") {
						caption = year+" - "+month;
					} else if(year != "") {
						caption = year;
					} else if(month != "") {
						caption = month;
					} else {
						caption = "<?php echo date("d M Y", strtotime($start)).' - '.date("d M Y", strtotime($end)); ?>";
					}

				}
				$.ajax({
					type: "GET",
					url: "<?php echo base_url('claim/customerclaim/filter_chart'); ?>",
					data: $("#filter_chart").serialize(),
					dataType: "JSON",
					cache: false,
					beforeSend: function() {
						$("#reloading").trigger('click');
					},
					success: function(data_filter) {
						FusionCharts.ready(function() {
							const chartData = [];
							const chartValue = [];
							const chartPpm = [];
							let obj = data_filter.result;
							for(let key in obj) {
								let defect = parseInt(obj[key]);
								let tot_rejection = 0;
								if(obj[key] > 0) {
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
									chartData.push(dataLabel);
									chartValue.push(dataValue);
									chartPpm.push(dataPpm);
								}
							}

							let label;
							if(chartData.length > 10) {
								label = "rotate";
							} else {
								label = "wrap";
							}
							var revenueChart = new FusionCharts({
								type: 'mscombidy2d',
								renderAt: 'container',
								width: '100%',
								height: '490',
								dataFormat: 'json',
								dataSource: {
								"chart": {
									"caption": "REJECTIONS "+part+" - QTY & PPM (AHM)",
									"subCaption": caption,
									"xAxisname": "Rejection Name",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"labelDisplay": label
								},
								"categories": [{
									"category": chartData
								}],
								"dataset": [{
									"seriesName": "Rejection",
									"showValues": "0",
									"numberSuffix": "",
									"data": chartValue
								}, {
									"seriesName": "PPM",
									"parentYAxis": "S",
									"renderAs": "line",
									"data": chartPpm
								}]
								}
							}).render();
						});
					},
					error: function(jqXHR, textStatus, errorThrown) {
						$("#error_text").text(textStatus +" "+errorThrown);
						$("#modal-error-ajax").modal('show');
					}
				});

			});

			$("#filter_chart").on('change', 'select#year', function(e) {
				$("#date_ranges").val(null);
				$("#start").val(null);
				$("#end").val(null);
				let part = $("#part").val();
				let year = $(e.target).val();
				let month = $("#month").val();
				
				let date_range = $("#date_ranges").val();
				if(date_range != "") {
					if(year != "" && month != "") {
						caption = year+" - "+month;
					} else if(year != "") {
						caption = year;
					} else if(month != "") {
						caption = month;
					} else {
						caption = caption = formart_start+" - "+formart_end;
					}
				} else {
					if(year != "" && month != "") {
						caption = year+" - "+month;
					} else if(year != "") {
						caption = year;
					} else if(month != "") {
						caption = month;
					} else {
						caption = "<?php echo date("d M Y", strtotime($start)).' - '.date("d M Y", strtotime($end)); ?>";
					}
				}
				
				$.ajax({
					type: "GET",
					url: "<?php echo base_url('claim/customerclaim/filter_chart'); ?>",
					data: $("#filter_chart").serialize(),
					dataType: "JSON",
					cache: false,
					beforeSend: function(data_filter) {
						$("#reloading").trigger('click');
					},
					success: function(data_filter) {
						FusionCharts.ready(function() {
							const chartData = [];
							const chartValue = [];
							const chartPpm = [];
							let obj = data_filter.result;
							for(let key in obj) {
								let defect = parseInt(obj[key]);
								let tot_rejection = 0;
								if(obj[key] > 0) {
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
									chartData.push(dataLabel);
									chartValue.push(dataValue);
									chartPpm.push(dataPpm);
								}
							}

							let label;
							if(chartData.length > 10) {
								label = "rotate";
							} else {
								label = "wrap";
							}
							var revenueChart = new FusionCharts({
								type: 'mscombidy2d',
								renderAt: 'container',
								width: '100%',
								height: '490',
								dataFormat: 'json',
								dataSource: {
								"chart": {
									"caption": "REJECTIONS "+part+" - QTY & PPM (AHM)",
									"subCaption": caption,
									"xAxisname": "Rejection Name",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"labelDisplay": label,
								},
								"categories": [{
									"category": chartData
								}],
								"dataset": [{
									"seriesName": "Rejection",
									"showValues": "0",
									"numberSuffix": "",
									"data": chartValue
								}, {
									"seriesName": "PPM",
									"parentYAxis": "S",
									"renderAs": "line",
									"data": chartPpm
								}]
								}
							}).render();
						});
					},
					error: function(jqXHR, textStatus, errorThrown) {
						$("#error_text").text(textStatus +" "+errorThrown);
						$("#modal-error-ajax").modal('show');
					}
				});


				$.ajax({
					type: "GET",
					url: "<?php echo base_url('claim/customerclaim/chart_per_part'); ?>",
					data: $("#filter_chart").serialize(),
					dataType: "JSON",
					cache: false,
					beforeSend: function() {
						$("#reloading_chart_part").trigger('click');
					},
					success: function(data_filter) {
						FusionCharts.ready(function() {
							const chartDataPart = [];
							const chartValuePart = [];
							const chartPpmPart = [];
							let obj = data_filter.result;
							for(let key in obj) {
								let defect = parseInt(obj[key]);
								let tot_rejection = 0;
								if(obj[key] > 0) {
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
									chartDataPart.push(dataLabel);
									chartValuePart.push(dataValue);
									chartPpmPart.push(dataPpm);
								}
							}

							let label;
							if(chartDataPart.length > 6) {
								label = "rotate";
							} else {
								label = "wrap";
							}
							var revenueChart = new FusionCharts({
								type: 'mscombidy2d',
								renderAt: 'container_partChart',
								width: '100%',
								height: '490',
								dataFormat: 'json',
								dataSource: {
								"chart": {
									"caption": "ALL REJECTION PARTS - QTY & PPM (AHM)",
									"subCaption": caption,
									"xAxisname": "Part Name",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"labelDisplay": label,
									"lineColor": "#fc3c3c",
									"palettecolors": "#29c3be"
								},
								"categories": [{
									"category": chartDataPart
								}],
								"dataset": [{
									"seriesName": "Rejection",
									"showValues": "0",
									"numberSuffix": "",
									"data": chartValuePart
								}, {
									"seriesName": "PPM",
									"parentYAxis": "S",
									"renderAs": "line",
									"data": chartPpmPart
								}]
								}
							}).render();
						});
					},
					error: function(jqXHR, textStatus, errorThrown) {
						$("#error_text").text(textStatus +" "+errorThrown);
						$("#modal-error-ajax").modal('show');
					}
				});

			});

			$("#filter_chart").on('change', 'select#month', function(e) {
				$("#date_ranges").val(null);
				$("#start").val(null);
				$("#end").val(null);
				let part = $("#part").val();
				let year = $("#year").val();
				let month = $(e.target).val();
				let date_range = $("#date_ranges").val();
				if(date_range != "") {
					if(year != "" && month != "") {
						caption = year+" - "+month;
					} else if(year != "") {
						caption = year;
					} else if(month != "") {
						caption = month;
					} else {
						caption = caption = formart_start+" - "+formart_end;
					}
				} else {
					if(year != "" && month != "") {
						caption = year+" - "+month;
					} else if(year != "") {
						caption = year;
					} else if(month != "") {
						caption = month;
					} else {
						caption = "<?php echo date("d M Y", strtotime($start)).' - '.date("d M Y", strtotime($end)); ?>";
					}
				}

				$.ajax({
					type: "GET",
					url: "<?php echo base_url('claim/customerclaim/filter_chart'); ?>",
					data: $("#filter_chart").serialize(),
					dataType: "JSON",
					cache: false,
					beforeSend: function(data_filter) {
						$("#reloading").trigger('click');
					},
					success: function(data_filter) {
						FusionCharts.ready(function() {
							const chartData = [];
							const chartValue = [];
							const chartPpm = [];
							let obj = data_filter.result;
							for(let key in obj) {
								let defect = parseInt(obj[key]);
								let tot_rejection = 0;
								if(obj[key] > 0) {
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
									chartData.push(dataLabel);
									chartValue.push(dataValue);
									chartPpm.push(dataPpm);
								}
							}

							let label;
							if(chartData.length > 10) {
								label = "rotate";
							} else {
								label = "wrap";
							}
							var revenueChart = new FusionCharts({
								type: 'mscombidy2d',
								renderAt: 'container',
								width: '100%',
								height: '490',
								dataFormat: 'json',
								dataSource: {
								"chart": {
									"caption": "REJECTIONS "+part+" - QTY & PPM (AHM)",
									"subCaption": caption,
									"xAxisname": "Rejection Name",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"labelDisplay": label,
								},
								"categories": [{
									"category": chartData
								}],
								"dataset": [{
									"seriesName": "Rejection",
									"showValues": "0",
									"numberSuffix": "",
									"data": chartValue
								}, {
									"seriesName": "PPM",
									"parentYAxis": "S",
									"renderAs": "line",
									"data": chartPpm
								}]
								}
							}).render();
						});
					},
					error: function(jqXHR, textStatus, errorThrown) {
						$("#error_text").text(textStatus +" "+errorThrown);
						$("#modal-error-ajax").modal('show');
					}
				});

				$.ajax({
					type: "GET",
					url: "<?php echo base_url('claim/customerclaim/chart_per_part'); ?>",
					data: $("#filter_chart").serialize(),
					dataType: "JSON",
					cache: false,
					beforeSend: function() {
						$("#reloading_chart_part").trigger('click');
					},
					success: function(data_filter) {
						FusionCharts.ready(function() {
							const chartDataPart = [];
							const chartValuePart = [];
							const chartPpmPart = [];
							let obj = data_filter.result;
							for(let key in obj) {
								let defect = parseInt(obj[key]);
								let tot_rejection = 0;
								if(obj[key] > 0) {
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
									chartDataPart.push(dataLabel);
									chartValuePart.push(dataValue);
									chartPpmPart.push(dataPpm);
								}
							}

							let label;
							if(chartDataPart.length > 6) {
								label = "rotate";
							} else {
								label = "wrap";
							}
							var revenueChart = new FusionCharts({
								type: 'mscombidy2d',
								renderAt: 'container_partChart',
								width: '100%',
								height: '490',
								dataFormat: 'json',
								dataSource: {
								"chart": {
									"caption": "ALL REJECTION PARTS- QTY & PPM (AHM)",
									"subCaption": caption,
									"xAxisname": "Part Name",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"labelDisplay": label,
									"lineColor": "#fc3c3c",
									"palettecolors": "#29c3be"
								},
								"categories": [{
									"category": chartDataPart
								}],
								"dataset": [{
									"seriesName": "Rejection",
									"showValues": "0",
									"numberSuffix": "",
									"data": chartValuePart
								}, {
									"seriesName": "PPM",
									"parentYAxis": "S",
									"renderAs": "line",
									"data": chartPpmPart
								}]
								}
							}).render();
						});
					},
					error: function(jqXHR, textStatus, errorThrown) {
						$("#error_text").text(textStatus +" "+errorThrown);
						$("#modal-error-ajax").modal('show');
					}
				});

			});

			$(".applyBtn").click(function() {
				$("#year").val(null);
				$("#month").val(null);
				var part = $("#part").val();
				$("select option[value='"+part+"']").attr("selected","selected");
				const months = ["Jan", "Feb", "Mar","Apr", "May", "Jun",
				"Jul", "Aug", "Sep", "Okt", "Nov", "Dec"];
				var start = $("[name=daterangepicker_start]").val();
				var end = $("[name=daterangepicker_end]").val();
				var start_date = new Date(start);
				var end_date = new Date(end);
				var formart_start = start_date.getDate()+" "+months[start_date.getMonth()]+" "+start_date.getFullYear();
				var formart_end = end_date.getDate()+" "+months[end_date.getMonth()]+" "+end_date.getFullYear();
				$("#start").attr("value", start);
				$("#end").attr("value", end);
				$.ajax({
					type: "GET",
					url: "<?php echo base_url('claim/customerclaim/filter_chart'); ?>",
					data: $("#filter_chart").serialize(),
					dataType: "JSON",
					cache: false,
					beforeSend: function(data_filter) {
						$("#reloading").trigger('click');
					},
					success: function(data_filter) {
						FusionCharts.ready(function() {
							const chartData = [];
							const chartValue = [];
							const chartPpm = [];
							let obj = data_filter.result;
							for(let key in obj) {
								let defect = parseInt(obj[key]);
								let tot_rejection = 0;
								if(obj[key] > 0) {
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
									chartData.push(dataLabel);
									chartValue.push(dataValue);
									chartPpm.push(dataPpm);
								}
							}
							let label;
							if(chartData.length > 10) {
								label = "rotate";
							} else {
								label = "wrap";
							}
							var revenueChart = new FusionCharts({
								type: 'mscombidy2d',
								renderAt: 'container',
								width: '100%',
								height: '490',
								dataFormat: 'json',
								dataSource: {
								"chart": {
									"caption": "REJECTIONS "+part+" - QTY & PPM (AHM)",
									"subCaption": formart_start+" - "+formart_end,
									"xAxisname": "Rejection Name",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"labelDisplay": label,
								},
								"categories": [{
									"category": chartData
								}],
								"dataset": [{
									"seriesName": "Rejection",
									"showValues": "0",
									"numberSuffix": "",
									"data": chartValue
								}, {
									"seriesName": "PPM",
									"parentYAxis": "S",
									"renderAs": "line",
									"data": chartPpm
								}]
								}
							}).render();
						});
					},

					error: function(jqXHR, textStatus, errorThrown) {
						$("#error_text").text(textStatus +" "+errorThrown);
						$("#modal-error-ajax").modal('show');
					}
				});

				$.ajax({
					type: "GET",
					url: "<?php echo base_url('claim/customerclaim/chart_per_part'); ?>",
					data: $("#filter_chart").serialize(),
					dataType: "JSON",
					cache: false,
					beforeSend: function() {
						$("#reloading_chart_part").trigger('click');
					},
					success: function(data_filter) {
						FusionCharts.ready(function() {
							const chartDataPart = [];
							const chartValuePart = [];
							const chartPpmPart = [];
							let obj = data_filter.result;
							for(let key in obj) {
								let defect = parseInt(obj[key]);
								let tot_rejection = 0;
								if(obj[key] > 0) {
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
									chartDataPart.push(dataLabel);
									chartValuePart.push(dataValue);
									chartPpmPart.push(dataPpm);
								}
							}
							let label;
							if(chartDataPart.length > 6) {
								label = "rotate";
							} else {
								label = "wrap";
							}
							var revenueChart = new FusionCharts({
								type: 'mscombidy2d',
								renderAt: 'container_partChart',
								width: '100%',
								height: '490',
								dataFormat: 'json',
								dataSource: {
								"chart": {
									"caption": "ALL REJECTION PARTS - QTY & PPM (AHM)",
									"subCaption": formart_start+" - "+formart_end,
									"xAxisname": "Part Name",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"labelDisplay": label,
									"lineColor": "#fc3c3c",
									"palettecolors": "#29c3be"
								},
								"categories": [{
									"category": chartDataPart
								}],
								"dataset": [{
									"seriesName": "Rejection",
									"showValues": "0",
									"numberSuffix": "",
									"data": chartValuePart
								}, {
									"seriesName": "PPM",
									"parentYAxis": "S",
									"renderAs": "line",
									"data": chartPpmPart
								}]
								}
							}).render();
						});
					},
					error: function(jqXHR, textStatus, errorThrown) {
						$("#error_text").text(textStatus +" "+errorThrown);
						$("#modal-error-ajax").modal('show');
					}
				});
			});

			function initChartPart() {
				$.ajax({
					type: "GET",
					url: "<?php echo base_url('claim/customerclaim/chart_per_part'); ?>",
					data: $("#filter_chart").serialize(),
					dataType: "JSON",
					cache: false,
					beforeSend: function() {
						$("#reloading_chart_part").trigger('click');
					},
					success: function(data_filter) {
						FusionCharts.ready(function() {
							const chartDataPart = [];
							const chartValuePart = [];
							const chartPpmPart = [];
							let obj = data_filter.result;
							for(let key in obj) {
								let defect = parseInt(obj[key]);
								let tot_rejection = 0;
								if(obj[key] > 0) {
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
									chartDataPart.push(dataLabel);
									chartValuePart.push(dataValue);
									chartPpmPart.push(dataPpm);
								}
							}
							let label;
							if(chartDataPart.length > 6) {
								label = "rotate";
							} else {
								label = "wrap";
							}
							var revenueChart = new FusionCharts({
								type: 'mscombidy2d',
								renderAt: 'container_partChart',
								width: '100%',
								height: '490',
								dataFormat: 'json',
								dataSource: {
								"chart": {
									"caption": "ALL REJECTION PARTS - QTY & PPM (AHM)",
									"subCaption": "<?php echo date("d M Y", strtotime($start)).' - '.date("d M Y", strtotime($end)); ?>",
									"xAxisname": "Part Name",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"labelDisplay": label,
									"lineColor": "#fc3c3c",
									"palettecolors": "#29c3be"
								},
								"categories": [{
									"category": chartDataPart
								}],
								"dataset": [{
									"seriesName": "Rejection",
									"showValues": "0",
									"numberSuffix": "",
									"data": chartValuePart
								}, {
									"seriesName": "PPM",
									"parentYAxis": "S",
									"renderAs": "line",
									"data": chartPpmPart
								}]
								}
							}).render();
						});
					},
					error: function(jqXHR, textStatus, errorThrown) {
						$("#error_text").text(textStatus +" "+errorThrown);
						$("#modal-error-ajax").modal('show');
					}
				});
			}

			function initChartRejection() {
				$.ajax({
					type: "GET",
					url: "<?php echo base_url('claim/customerclaim/filter_chart'); ?>",
					data: $("#filter_chart").serialize(),
					dataType: "JSON",
					cache: false,
					beforeSend: function(data_filter) {
						$("#reloading").trigger('click');
					},
					success: function(data_filter) {
						FusionCharts.ready(function() {
							const chartData = [];
							const chartValue = [];
							const chartPpm = [];
							let obj = data_filter.result;
							for(let key in obj) {
								let defect = parseInt(obj[key]);
								let tot_rejection = 0;
								if(obj[key] > 0) {
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
									chartData.push(dataLabel);
									chartValue.push(dataValue);
									chartPpm.push(dataPpm);
								}
							}

							let label;
							if(chartData.length > 10) {
								label = "rotate";
							} else {
								label = "wrap";
							}
							var revenueChart = new FusionCharts({
								type: 'mscombidy2d',
								renderAt: 'container',
								width: '100%',
								height: '490',
								dataFormat: 'json',
								dataSource: {
								"chart": {
									"caption": "REJECTIONS - QTY & PPM (AHM)",
									"subCaption": "<?php echo date("d M Y", strtotime($start)).' - '.date("d M Y", strtotime($end)); ?>",
									"xAxisname": "Rejection Name",
									"pYAxisName": "QTY",
									"sYAxisName": "PPM",
									"numberPrefix": "",
									"theme": "fusion",
									"showValues": "0",
									"labelDisplay": label,
								},
								"categories": [{
									"category": chartData
								}],
								"dataset": [{
									"seriesName": "Rejection",
									"showValues": "0",
									"numberSuffix": "",
									"data": chartValue
								}, {
									"seriesName": "PPM",
									"parentYAxis": "S",
									"renderAs": "line",
									"data": chartPpm
								}]
								}
							}).render();
						});
					},
					error: function(jqXHR, textStatus, errorThrown) {
						$("#error_text").text(textStatus +" "+errorThrown);
						$("#modal-error-ajax").modal('show');
					}
				});
			}

			$("#reset_part").click(function() {
				$("#year").val(null);
				$("#month").val(null);
				$("#start").val(null);
				$("#end").val(null);
				$("#date_ranges").val(null);
				initChartPart();
			});

			$("#reset_rejection").click(function() {
				$("#part").val(null);
				$("#year").val(null);
				$("#month").val(null);
				$("#start").val(null);
				$("#end").val(null);
				$("#date_ranges").val(null);
				initChartRejection();
			});

			initChartPart();
			initChartRejection();

			var countInitChartRejection = <?php echo $count_customer_claim; ?>;
			function initRealTimeChartRejection() {
				$.ajax({
					type: "GET",
					url: "<?php echo base_url('claim/customerclaim/filter_chart'); ?>",
					data: $("#filter_chart").serialize(),
					dataType: "JSON",
					cache: false,
					beforeSend: function(data_filter) {
						$("#reloading").trigger('click');
					},
					success: function(data_filter) {
						let get_count_customer_claim = data_filter.count_customer_claim;
						if(countInitChartRejection != get_count_customer_claim) {
							countInitChartRejection = get_count_customer_claim;
							FusionCharts.ready(function() {
								const chartData = [];
								const chartValue = [];
								const chartPpm = [];
								let obj = data_filter.result;
								for(let key in obj) {
									let defect = parseInt(obj[key]);
									let tot_rejection = 0;
									if(obj[key] > 0) {
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
										chartData.push(dataLabel);
										chartValue.push(dataValue);
										chartPpm.push(dataPpm);
									}
								}

								let label;
								if(chartData.length > 10) {
									label = "rotate";
								} else {
									label = "wrap";
								}
								var revenueChart = new FusionCharts({
									type: 'mscombidy2d',
									renderAt: 'container',
									width: '100%',
									height: '490',
									dataFormat: 'json',
									dataSource: {
									"chart": {
										"caption": "REJECTIONS - QTY & PPM (AHM)",
										"subCaption": "<?php echo date("d M Y", strtotime($start)).' - '.date("d M Y", strtotime($end)); ?>",
										"xAxisname": "Rejection Name",
										"pYAxisName": "QTY",
										"sYAxisName": "PPM",
										"numberPrefix": "",
										"theme": "fusion",
										"showValues": "0",
										"labelDisplay": label,
									},
									"categories": [{
										"category": chartData
									}],
									"dataset": [{
										"seriesName": "Rejection",
										"showValues": "0",
										"numberSuffix": "",
										"data": chartValue
									}, {
										"seriesName": "PPM",
										"parentYAxis": "S",
										"renderAs": "line",
										"data": chartPpm
									}]
									}
								}).render();
							});
						} else {
							countInitChartRejection = get_count_customer_claim;
						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
						$("#error_text").text(textStatus +" "+errorThrown);
						$("#modal-error-ajax").modal('show');
					}
				});
			}

			var countInitChartPart = <?php echo $count_customer_claim; ?>;
			function initRealTimeChartPart() {
				$.ajax({
					type: "GET",
					url: "<?php echo base_url('claim/customerclaim/chart_per_part'); ?>",
					data: $("#filter_chart").serialize(),
					dataType: "JSON",
					cache: false,
					beforeSend: function() {
						$("#reloading_chart_part").trigger('click');
					},
					success: function(data_filter) {
						let get_count_customer_claim = data_filter.count_customer_claim;
						if(countInitChartPart != get_count_customer_claim) {
							countInitChartPart = get_count_customer_claim;
							FusionCharts.ready(function() {
								const chartDataPart = [];
								const chartValuePart = [];
								const chartPpmPart = [];
								let obj = data_filter.result;
								for(let key in obj) {
									let defect = parseInt(obj[key]);
									let tot_rejection = 0;
									if(obj[key] > 0) {
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
										chartDataPart.push(dataLabel);
										chartValuePart.push(dataValue);
										chartPpmPart.push(dataPpm);
									}
								}
								let label;
								if(chartDataPart.length > 6) {
									label = "rotate";
								} else {
									label = "wrap";
								}
								var revenueChart = new FusionCharts({
									type: 'mscombidy2d',
									renderAt: 'container_partChart',
									width: '100%',
									height: '490',
									dataFormat: 'json',
									dataSource: {
									"chart": {
										"caption": "ALL REJECTION PARTS - QTY & PPM (AHM)",
										"subCaption": "<?php echo date("d M Y", strtotime($start)).' - '.date("d M Y", strtotime($end)); ?>",
										"xAxisname": "Part Name",
										"pYAxisName": "QTY",
										"sYAxisName": "PPM",
										"numberPrefix": "",
										"theme": "fusion",
										"showValues": "0",
										"labelDisplay": label,
										"lineColor": "#fc3c3c",
										"palettecolors": "#29c3be"
									},
									"categories": [{
										"category": chartDataPart
									}],
									"dataset": [{
										"seriesName": "Rejection",
										"showValues": "0",
										"numberSuffix": "",
										"data": chartValuePart
									}, {
										"seriesName": "PPM",
										"parentYAxis": "S",
										"renderAs": "line",
										"data": chartPpmPart
									}]
									}
								}).render();
							});
						} else {
							countInitChartPart = get_count_customer_claim;
						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
						$("#error_text").text(textStatus +" "+errorThrown);
						$("#modal-error-ajax").modal('show');
					}
				});
			}

			let timer_part = setInterval(initRealTimeChartPart, 5000);
			$("#body_chart_part").hover(
				function() {
					clearInterval(timer_part);
				},
				function() {
					timer_part = setInterval(initRealTimeChartPart, 5000);
				}
			);

			let timer_rejection = setInterval(initRealTimeChartRejection, 5000);
			$("#body_chart_rejection").hover(
				function() {
					clearInterval(timer_rejection);
				},
				function() {
					timer_rejection = setInterval(initRealTimeChartRejection, 5000);
				}
			);			
		});
</script>

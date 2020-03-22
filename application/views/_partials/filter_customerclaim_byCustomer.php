<script>
	jQuery(document).ready(function($) {
		let table_customer_claim = $("#table_customer_claim").DataTable({
										"oLanguage": {
											"sSearch": "Search:",
											"oPaginate": {
												"sPrevious": "Previous",
												"sNext": "Next"
											}
										},
										"JQueryUI":true,
										"lengthChange": false,
										"scrollCollapse":true,
										"paging": false,
										"initComplete": function (settings, json) {  
    										$("#table_customer_claim").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  										},
									});
		$("#table_customer_claim").on( 'column-sizing.dt', function ( e, settings ) {
			$(".dataTables_scrollHeadInner").css( "width", "100%" );
		});
		let table_skeleton = $("#table_skeleton").DataTable({
										"oLanguage": {
											"sSearch": "Search:",
											"oPaginate": {
												"sPrevious": "Previous",
												"sNext": "Next"
											}
										},
										"lengthChange": false,
									});
        $("#ganti_customer, #ganti_customer2").change((e) => {
            let val_id_customer = $(e.target).val();
            let set_Id_Customer = $("#id_customer").val(val_id_customer);
            let idCustomer = $("#id_customer").val();
            $("#date_ranges").val(null);
			$("#start").val(null);
			$("#end").val(null);
			let part = $("#part").val();
			let year = $("#year").val();
			let nama_customer = $("#ganti_customer option:selected").text();
			let month = $("#month option:selected").text();
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
						let obj = data_filter.result;
						for(let key in obj) {
							if(obj[key] > 0) {
								let initData = {
								    "label": key,
									"value": obj[key],
								}
								chartData.push(initData);
							}
						}

						let label;
						if(chartData.length > 10) {
							label = "rotate";
						} else {
							label = "wrap";
						}
						var revenueChart = new FusionCharts({
							type: 'column2d',
							renderAt: 'container',
							width: '100%',
							height: '490',
							dataFormat: 'json',
							dataSource: {
                                "chart": {
                                    "caption": "REJECTIONS "+part+" - QTY ("+nama_customer+")",
                                    "subCaption": caption,
                                    "xAxisname": "Rejection Name",
                                    "pYAxisName": "QTY",
                                    "sYAxisName": "",
                                    "numberPrefix": "",
                                    "theme": "fusion",
                                    "showValues": "0",
                                    "exportenabled": "1",
                                    "exportfilename": "Customer Claim Chart",
                                    "labelDisplay": label,
                                },
                                "data": chartData
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
						let obj = data_filter.result;
						for(let key in obj) {
							let defect = parseInt(obj[key]);
							if(obj[key] > 0) {
								let initData = {
									"label": key,
									"value": obj[key],
								}
								let dataValue = {
									"value": obj[key],
								}
								chartDataPart.push(initData);
							}
						}
						let label;
						if(chartDataPart.length > 6) {
							label = "rotate";
						} else {
							label = "wrap";
						}
						var revenueChart = new FusionCharts({
							type: 'column2d',
							renderAt: 'container_partChart',
							width: '100%',
							height: '490',
							dataFormat: 'json',
							dataSource: {
								"chart": {
                                    "caption": "ALL REJECTION PARTS - QTY ("+nama_customer+")",
                                    "subCaption": caption,
                                    "xAxisname": "Part Name",
                                    "pYAxisName": "QTY",
                                    "sYAxisName": "",
                                    "numberPrefix": "",
                                    "theme": "fusion",
                                    "showValues": "0",
                                    "exportenabled": "1",
                                    "exportfilename": "Customer Claim Chart",
                                    "labelDisplay": label,
                                    "palettecolors": "#29c3be"
							    },
							    "data":chartDataPart		
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

		function formatDate(date) {
			let d = new Date(date),
				month = '' + (d.getMonth() + 1),
				day = '' + d.getDate(),
				year = d.getFullYear();

			if (month.length < 2) 
				month = '0' + month;
			if (day.length < 2) 
				day = '0' + day;

			return [year, month, day].join('-');
		}

		// FILTER TABLE USING AJAX
		function load_all_customer_claim() {
			let new_date = new Date();
			let dateNow = formatDate(new_date);
			$.ajax({
				type: "GET",
				url: "<?php echo base_url('claim/customerclaim/filter_table'); ?>",
				data: $("#filter_table").serialize(),
				dataType: "JSON",
				beforeSend: () => {
					$("#main-table").addClass("hide-main-table");
					table_customer_claim.clear().draw();
				},
				success: (data) => {
					function show_table() {
						$("#skeleton-table").addClass("remove-skeleton-table");
						$("#main-table").removeClass("hide-main-table");
						$("#main-table").addClass("show-main-table");
					}
					let uniq = 1;
					for(let i in data) {
						let no = parseInt(i) + 1;
						let create_date = new Date(data[i].tgl_input);
						create_date.setDate(create_date.getDate() + 3);
						let year = create_date.getFullYear();
						let increment_month = create_date.getMonth() + 1
						let month = ('0' + increment_month).slice(-2);
						let day = ('0' + create_date.getDate()).slice(-2);
						let due_date = `${year}-${month}-${day}`;
						let date_now = Date.parse(dateNow);
						let parse_due_date = Date.parse(due_date);
						let ofp_upload = "<a href='javascript:;' id='modal-upload-ofp"+data[i].id_customer_claim+"' class='btn btn-blue btn-icon icon-left'> Upload<i class='entypo-upload'></i></a>";
						let button_upload = "<a href='javascript:;' id='modal-upload-ppt"+data[i].id_customer_claim+"' class='btn btn-blue btn-icon icon-left'> Upload<i class='entypo-upload'></i></a>";
						let pergantian_part;
						let button_download;
						let ofp_download;
						let upload_pfmea = "<a href='javascript:;' id='modal-pfmea"+data[i].id_customer_claim+"' class='btn btn-blue'><i class='entypo-upload'></i></a>";
						let see_pfmea;
						let sortir_stock;
						if(data[i].ppt_file == null) {
							button_download = "<a disabled class='btn btn-success btn-icon icon-left' id='download_ppt_file"+data[i].id_customer_claim+"'> Download<i class='entypo-download'></i></a>";
						} else {
							if(data[i].ppt_file != null) {
								button_download = "<a target='_blank' href='<?php echo base_url('assets/claim_customer/ppt/')?>"+data[i].ppt_file+"' class='btn btn-success btn-icon icon-left' download='PART - "+data[i].nama_part+"' id='download_ppt_file"+data[i].id_customer_claim+"'>Download <i class='entypo-download'></i></a>";
							}		
						}

						if(data[i].ofp == null) {
							ofp_download = "<a disabled class='btn btn-success btn-icon icon-left' id='download_ofp_file"+data[i].id_customer_claim+"'> Download<i class='entypo-download'></i></a>";
						} else {
							if(data[i].ofp != null) {
								ofp_download = "<a target='_blank' href='<?php echo base_url('assets/claim_customer/ofp/')?>"+data[i].ofp+"' class='btn btn-success btn-icon icon-left' download='OFP - "+data[i].nama_part+"' id='download_ofp_file"+data[i].id_customer_claim+"'>Download <i class='entypo-download'></i></a>";
							}		
						}

						if(data[i].id_pergantian_part == null) {
							pergantian_part = "<a href='javascript:;' id='modal-pergantian-part"+data[i].id_customer_claim+"' class='btn btn-info btn-icon icon-left'><i class='entypo-pencil'></i> Pergantian part</a>";
						} else {
							if(data[i].id_pergantian_part != null) {
								pergantian_part = "<i id='ganti-part"+data[i].id_customer_claim+"' class='entypo-check' style='color: #21bf73; font-weight: bold; font-size: 15px;'></i> Sudah melakukan pergantian part";
							}
						}

						if(data[i].id_sortir_stock == null) {
							sortir_stock = "<a href='javascript:;' id='modal-sortir-stock"+data[i].id_customer_claim+"' class='btn btn-blue'><i class='entypo-pencil'></i></a>";
						} else {
							if(data[i].id_sortir_stock != null) {
								sortir_stock = "<i id='ganti-part"+data[i].id_customer_claim+"' class='entypo-check' style='color: #21bf73; font-weight: bold; font-size: 15px;'></i>";
							}
						}

						if(data[i].id_pfmea == null) {
							see_pfmea = "<a class='btn btn-info enable_pfmea"+data[i].id_customer_claim+"' disabled><i class='entypo-eye'></i></a>";
						} else {
							if(data[i].id_pfmea != null) {
								see_pfmea  = "<a href='javascript:;' id='modal_files"+data[i].id_customer_claim+"' class='btn btn-info'><i class='entypo-eye'></i></a>";
							}
						}

						if(data[i].ofp != null && data[i].id_pergantian_part != null && data[i].id_sortir_stock != null && data[i].ppt_file != null && data[i].id_pfmea != null) {
							data[i].status = 'CLOSE';
						}

						if(data[i].card == "#N/A") {
							data[i].card = '-'
						}
						table_customer_claim.row.add([
							''+uniq+'',
							''+data[i].tgl_input+'',
							''+data[i].no_surat_claim+'',
							''+data[i].nama_part+'',
							''+data[i].type+'',
							''+data[i].proses+'',
							''+due_date+'',
							''+ofp_upload+' '+ofp_download+'',
							''+pergantian_part+'',
							''+sortir_stock+'',
							''+button_upload+' '+button_download+'',
							''+upload_pfmea+' '+see_pfmea+'',
							''+data[i].status+'',
							''+data[i].card+''
						]).draw(false);
						uniq += 1;
					}

					setTimeout(show_table, 1500);
				},
				error: (jqXHR, textStatus, errorThrown) => {
					alert(textStatus +" "+errorThrown);
				},
				complete: (data) => {
					function load_uniqID() {
							let sign = 1;
							for(let i in data.responseJSON) {
								let create_date = new Date(data.responseJSON[i].tgl_input);
								create_date.setDate(create_date.getDate() + 3);
								let year = create_date.getFullYear();
								let increment_month = create_date.getMonth() + 1
								let month = ('0' + increment_month).slice(-2);
								let day = ('0' + create_date.getDate()).slice(-2);
								let due_date = `${year}-${month}-${day}`;
								let date_now = Date.parse(dateNow);
								let parse_due_date = Date.parse(due_date);
								let id_claim = data.responseJSON[i].id_customer_claim;
								let uniqID = "status_color"+id_claim;
								let id_card = "card-"+sign;
								let status = "status_claim"+id_claim;
								let card = data.responseJSON[i].card;
								let pergantian_part = "pergantian_part"+id_claim;
								let status_sortir_stock = "status-sortir-stock"+id_claim;
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(7)").attr("id", uniqID);
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(14)").attr("id", id_card);
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(6)").attr("class", "proses");
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(5)").attr("class", "proses");
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(3)").attr("class", "no_surat_claim");
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(11)").attr("class", "pica");
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(9)").attr("class", "centered");
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(9)").attr("id", pergantian_part);
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(10)").attr("class", "centered");
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(10)").attr("id", status_sortir_stock);
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(13)").attr("class", "centered");
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(13)").attr("id", status);
								$("#status_claim"+id_claim+"").addClass("status");
								if(date_now > parse_due_date) {
									if(data.responseJSON[i].ppt_file != null) {
										$("#"+uniqID).addClass("kuning");
									} else {
										$("#"+uniqID).addClass("red");
									}
								} else {
									if(data.responseJSON[i].ppt_file != null) {
										$("#"+uniqID).addClass("hijau");
									} else {
										$("#"+uniqID).addClass("text-align");
									}
								}

								if(card == 'Green Card') {
									$("#"+id_card).addClass("hijau");
								} else if(card == 'Yellow Card') {
									$("#"+id_card).addClass("kuning");
								} else {
									if(card == 'Red Card') {
										$("#"+id_card).addClass("red");
									} else {
										$("#"+id_card).addClass("netral");
									}
								}
								sign += 1;

								let table_file_pfmea = $("#table_file_pfmea"+id_claim).DataTable({
										"oLanguage": {
											"sSearch": "Search:",
											"oPaginate": {
												"sPrevious": "Previous",
												"sNext": "Next"
											}
										},
										"lengthChange": false,
								});

								$("#table_customer_claim").on('click', '#modal-upload-ppt'+id_claim+'', function() {
									$("#upload-ppt"+id_claim).modal('show');
								});

								$("#table_customer_claim").on('click', '#modal-upload-ofp'+id_claim+'', function() {
									$("#upload-ofp"+id_claim).modal('show');
								});

								$("#table_customer_claim").on('click', '#modal-pergantian-part'+id_claim+'', function() {
									$("#pergantian-part"+id_claim).modal('show');
								});

								$("#table_customer_claim").on('click', '#modal-pfmea'+id_claim+'', () => {
									$("#pfmea"+id_claim).modal('show');
								});

								$("#table_customer_claim").on('click', '#modal-sortir-stock'+id_claim+'', function() {
									$.ajax({
										type: "GET",
										url: "<?php echo base_url('claim/customerclaim/sortir_part/'); ?>"+id_claim+"",
										dataType: "JSON",
										cache: false,
										beforeSend: () => {
											$("#problem_part"+id_claim).html("");
										},
										success: (data_sortir) => {
											let mod = data_sortir.sisa;
											if(mod != 0) {
												let Initstock = $("#stock"+id_claim+"").val(mod);
											} else {
												let Initstock = $("#stock"+id_claim+"").val(0);
											}
											let ok = $("#ok"+id_claim+"").val();
											let ng = $("#ng"+id_claim+"").val();
											let sisa = $("#sisa"+id_claim+"").val();
											let stock = $("#stock"+id_claim+"").val();
											let keep_stock = stock;
											let keep_value = null;
											$("#stock"+id_claim+"").keyup((e) => {
											    var stock_value = $(e.target).val();
											    keep_stock = stock_value;
											    stock = stock_value;
											    if(parseInt(stock_value) > 0) {
													if(ok != '0' || ng != '0') {
														sisa = Math.abs(parseInt(stock_value) - (parseInt(ok) + parseInt(ng)));
														if(sisa == 0) {
															$("#btn_plus_ok"+id_claim+", #btn_plus_ng"+id_claim+"").attr("disabled", true);
														} else {
															$("#btn_min_stock"+id_claim+", #btn_plus_ok"+id_claim+", #btn_plus_ng"+id_claim+"").attr("disabled", false);
														}
														$("#sisa"+id_claim+"").val(sisa);
														stock = sisa;
													} else {
														$("#btn_min_stock"+id_claim+", #btn_plus_ok"+id_claim+", #btn_plus_ng"+id_claim+"").attr("disabled", false);
													}
											    } else {
											        $("#btn_min_stock"+id_claim+", #btn_min_ok"+id_claim+", #btn_plus_ok"+id_claim+", #btn_min_ng"+id_claim+", #btn_plus_ng"+id_claim+"").attr("disabled", true);
											        $("#ok"+id_claim+", #ng"+id_claim+"").attr("readonly", true);
											        $("#ok"+id_claim+"").val(0);
											        $("#ng"+id_claim+"").val(0);
													$("#sisa"+id_claim+"").val(0);
											    }
											});

											if(ok === '0') {
                								$("#btn_min_ok"+id_claim+"").attr("disabled", true);
            								}

											if(ng === '0') {
												$("#btn_min_ng"+id_claim+"").attr("disabled", true);
											}

											if(mod != 0) {
												$("#btn_plus_ok"+id_claim+"").click(function add() {
												    let ok_value = $("#ok"+id_claim+"").val();
													ok = ok_value;
												    if(parseInt(ok_value) > 0) {
												        sisa = parseInt(stock) - 1;
												        stock = sisa;
														if(sisa == 0) {
															$("#btn_plus_ok"+id_claim+"").attr("disabled", true);
															$("#btn_plus_ng"+id_claim+"").attr("disabled", true);
														}
												        $("#btn_min_ok"+id_claim+"").attr("disabled", false);
												        $("#sisa"+id_claim+"").val(sisa);
												    } else {
												        sisa = keep_stock;
												        $("#btn_min_ok"+id_claim+"").attr("disabled", true);
												        $("#sisa"+id_claim+"").val(sisa);
												    }
												});

												$("#btn_min_ok"+id_claim+"").click(function subst() {
												    let ok_value = $("#ok"+id_claim+"").val();
													ok = ok_value;
													$("#btn_plus_ng"+id_claim+"").attr("disabled", false);
												    if(parseInt(ok_value) > 0) {
												        sisa++;
														stock = sisa;
														$("#btn_plus_ok"+id_claim+"").attr("disabled", false);
												        $("#sisa"+id_claim+"").val(sisa);
												    } else {
												        sisa = keep_stock;
														
														if(parseInt(ng) != 0) {
															sisa = Math.abs(parseInt(sisa) - parseInt(ng));
															stock = sisa;
															$("#sisa"+id_claim+"").val(sisa); 
														} else {
															stock = sisa;
															$("#sisa"+id_claim+"").val(0); 
														}
												        
												        $("#btn_min_ok"+id_claim+"").attr("disabled", true);
												    }
												});
												
												$("#btn_plus_ng"+id_claim+"").click(function add() {
												    let ng_value = $("#ng"+id_claim+"").val();
													ng = ng_value;
												    if(parseInt(ng_value) > 0) {
												        sisa = parseInt(stock) - 1;
												        stock = sisa;
														if(sisa == 0) {
															$("#btn_plus_ok"+id_claim+"").attr("disabled", true);
															$("#btn_plus_ng"+id_claim+"").attr("disabled", true);
														}
												        $("#btn_min_ng"+id_claim+"").attr("disabled", false);
												        $("#sisa"+id_claim+"").val(sisa);
												    } else {
												        sisa = keep_stock;
												        $("#btn_min_ng"+id_claim+"").attr("disabled", true);
												        $("#sisa"+id_claim+"").val(sisa);
												    }
												});

												$("#btn_min_ng"+id_claim+"").click(function subst() {
												    let ng_value = $("#ng"+id_claim+"").val();
													ng = ng_value;
													$("#btn_plus_ok"+id_claim+"").attr("disabled", false);
												    if(parseInt(ng_value) > 0) {
												        sisa++;
												        stock = sisa;
														$("#btn_plus_ng"+id_claim+"").attr("disabled", false);
												        $("#sisa"+id_claim+"").val(sisa);
												    } else {
												        sisa = keep_stock;
														if(parseInt(ok) != 0) {
															sisa = Math.abs(parseInt(sisa) - parseInt(ok));
															stock = sisa;
															$("#sisa"+id_claim+"").val(sisa);
														} else {
															stock = sisa;
															$("#sisa"+id_claim+"").val(0);
														}
														$("#btn_min_ng"+id_claim+"").attr("disabled", true);
												    }
												});

												$("#stock"+id_claim+"").attr("readonly", true);
												$("#btn_min_stock"+id_claim+"").attr("disabled", true);
												$("#btn_plus_stock"+id_claim+"").attr("disabled", true);
												$("#btn_plus_ok"+id_claim+"").attr("disabled", false);
												$("#btn_plus_ng"+id_claim+"").attr("disabled", false);

											} else {
												$("#btn_plus_ok"+id_claim+"").click(function add() {
												    let ok_value = $("#ok"+id_claim+"").val();
													ok = ok_value;
												    if(parseInt(ok_value) > 0) {
												        sisa = parseInt(stock) - 1;
												        stock = sisa;
														if(sisa == 0) {
															$("#btn_plus_ok"+id_claim+"").attr("disabled", true);
															$("#btn_plus_ng"+id_claim+"").attr("disabled", true);
														}
												        $("#btn_min_ok"+id_claim+"").attr("disabled", false);
												        $("#sisa"+id_claim+"").val(sisa);
												    } else {
												        sisa = keep_stock;
												        $("#btn_min_ok"+id_claim+"").attr("disabled", true);
												        $("#sisa"+id_claim+"").val(sisa);
												    }
												});

												$("#btn_min_ok"+id_claim+"").click(function subst() {
												    let ok_value = $("#ok"+id_claim+"").val();
													ok = ok_value;
													$("#btn_plus_ng"+id_claim+"").attr("disabled", false);
												    if(parseInt(ok_value) > 0) {
												        sisa++;
														stock = sisa;
														$("#btn_plus_ok"+id_claim+"").attr("disabled", false);
												        $("#sisa"+id_claim+"").val(sisa);
												    } else {
												        sisa = keep_stock;
														if(parseInt(ng) != 0) {
															sisa = Math.abs(parseInt(sisa) - parseInt(ng));
															stock = sisa;
															$("#sisa"+id_claim+"").val(sisa); 
														} else {
															stock = sisa;
															$("#sisa"+id_claim+"").val(0); 
														}
												        $("#btn_min_ok"+id_claim+"").attr("disabled", true);
												    }
												});
												
												$("#btn_plus_ng"+id_claim+"").click(function add() {
												    let ng_value = $("#ng"+id_claim+"").val();
													ng = ng_value;
												    if(parseInt(ng_value) > 0) {
												        sisa = parseInt(stock) - 1;
												        stock = sisa;
														if(sisa == 0) {
															$("#btn_plus_ok"+id_claim+"").attr("disabled", true);
															$("#btn_plus_ng"+id_claim+"").attr("disabled", true);
														}
												        $("#btn_min_ng"+id_claim+"").attr("disabled", false);
												        $("#sisa"+id_claim+"").val(sisa);
												    } else {
												        sisa = keep_stock;
												        $("#btn_min_ng"+id_claim+"").attr("disabled", true);
												        $("#sisa"+id_claim+"").val(sisa);
												    }
												});

												$("#btn_min_ng"+id_claim+"").click(function subst() {
												    let ng_value = $("#ng"+id_claim+"").val();
													ng = ng_value;
													$("#btn_plus_ok"+id_claim+"").attr("disabled", false);
												    if(parseInt(ng_value) > 0) {
												        sisa++;
												        stock = sisa;
														$("#btn_plus_ng"+id_claim+"").attr("disabled", false);
												        $("#sisa"+id_claim+"").val(sisa);
												    } else {
												        sisa = keep_stock;
														if(parseInt(ok) != 0) {
															sisa = Math.abs(parseInt(sisa) - parseInt(ok));
															stock = sisa;
															$("#sisa"+id_claim+"").val(sisa);
														} else {
															stock = sisa;
															$("#sisa"+id_claim+"").val(0);
														}
														$("#btn_min_ng"+id_claim+"").attr("disabled", true);
												    }
												});

												$("#stock"+id_claim+"").attr("readonly", false);
												$("#btn_min_stock"+id_claim+"").attr("disabled", true);
												$("#btn_plus_stock"+id_claim+"").attr("disabled", false);
												$("#btn_plus_ok"+id_claim+"").attr("disabled", true);
												$("#btn_plus_ng"+id_claim+"").attr("disabled", true);
											}
											$("#ok"+id_claim+"").attr("readonly", true);
											$("#ng"+id_claim+"").attr("readonly", true);
											let label = ["label-primary", "label-secondary", "label-success",
											"label-info", "label-warning", "label-danger"];
											for(i in data_sortir.problem_part) {
												let problem = "<div class='label "+label[Math.floor(Math.random() * label.length)]+" tooltip-primary' data-toggle='tooltip' data-placement='top' title='' data-original-title='Tooltip on top'>"+data_sortir.problem_part[i]+"</div>";
												$("#problem_part"+id_claim).append(problem);
											}

											$("#sortir-stock"+id_claim).modal('show');
										},
										error: (jqXHR, textStatus, errorThrown) => {
											alert(textStatus +" "+errorThrown);
										}
									});
								});

								$("#table_customer_claim").on('click', '#modal_files'+id_claim+'', function() {
									$.ajax({
										type: "GET",
										url: "<?php echo base_url('claim/customerclaim/get_pfmea_files/'); ?>"+id_claim+"",
										dataType: "JSON",
										beforeSend: () => {
											table_file_pfmea.clear().draw();
										},
										success: (data) => {
											for(let index in data) {
												let nomor = parseInt(index) + 1;
												let button_download_files = "<a target='_blank' href='<?php echo base_url('assets/claim_customer/pfmea/')?>"+data[index].nama_file+"' class='btn btn-blue'><i class='entypo-download'></i></a>";
												table_file_pfmea.row.add([
													''+nomor+'',
													''+data[index].tgl_upload+'',
													''+data[index].nama_file+'',
													''+button_download_files+''
												]).draw(false);
											}
										},
										error: (jqXHR, textStatus, errorThrown) => {
											alert(textStatus +" "+errorThrown);
										}
									});
									$("#modal_view_files"+id_claim).modal('show');
								});

								$("#upload_file"+id_claim+"").submit(function(e) {
									e.preventDefault();
									$(this).ajaxSubmit({
										beforeSubmit: () => {
											$("#progress-bar"+id_claim+"").width('0%');
										},
										uploadProgress: (event, position, total, percentComplete) => {
											$("#progress-bar"+id_claim+"").width(percentComplete + '%');
											$("span#progress"+id_claim+"").text(percentComplete+"%");
										},
										success: (data) => {
											let data_json = JSON.parse(data);
											let select_claim = data_json.select_claim;
											let due_date = Date.parse(data_json.due_date);
											let dateNow = Date.parse(data_json.dateNow);
											function closeModal() {
												if(dateNow > due_date) {
													$("#status_color"+id_claim+"").addClass('kuning');
												} else {
													$("#status_color"+id_claim+"").addClass('hijau');
												}
												$("#upload-ppt"+select_claim.id_customer_claim).modal('hide');
											}
											setTimeout(closeModal, 1500);
										},
										complete: (data) => {
											let data_json = JSON.parse(data.responseText);
											let jsonResponse = data_json.select_claim;
											let fileName = data_json.file_name;
											var opts = {
												"closeButton": true,
												"debug": false,
												"positionClass": "toast-top-right",
												"onclick": null,
												"showDuration": "300",
												"hideDuration": "1000",
												"timeOut": "5000",
												"extendedTimeOut": "1000",
												"showEasing": "swing",
												"hideEasing": "linear",
												"showMethod": "fadeIn",
												"hideMethod": "fadeOut"
											};
											function successUpload() {
												toastr.success('FILE PICA BERHASIL DIUPLOAD', "SUCCESS", opts);
												$("#download_ppt_file"+jsonResponse.id_customer_claim).removeAttr("disabled");
												$("#download_ppt_file"+jsonResponse.id_customer_claim).attr("href", "<?php echo base_url('assets/claim_customer/ppt/'); ?>"+fileName+"");
												if(jsonResponse.ppt_file != null && jsonResponse.ofp != null && jsonResponse.id_pergantian_part != null && jsonResponse.id_sortir_stock != null && jsonResponse.id_pfmea != null) {
													$("#status_claim"+jsonResponse.id_customer_claim).text("");
													$("#status_claim"+jsonResponse.id_customer_claim).text("CLOSE");
												}
											}
											function afterUpload() {
												$("span.file-input-name").text("");
												$("#progress-bar"+id_claim+"").width('0%');
												$("#nama_file"+id_claim+"").val(null);
											}
											setTimeout(successUpload, 1500);
											setTimeout(afterUpload, 2000);
											$("#upload-ppt"+id_claim+"").unbind();
										},
										error: function(jqXHR, textStatus, errorThrown) {
											alert(textStatus +" "+errorThrown);
											// $("#error_text").text(textStatus +" "+errorThrown);
											// $("#modal-error-ajax").modal('show');;
										}
									});
								});


								$("#upload_ofpfile"+id_claim+"").submit(function(e) {
									e.preventDefault();
									$(this).ajaxSubmit({
										beforeSubmit: () => {
											$("#progress-bar-ofp"+id_claim+"").width('0%');
										},
										uploadProgress: (event, position, total, percentComplete) => {
											
											$("#progress-bar-ofp"+id_claim+"").width(percentComplete + '%');
											$("span#progress-ofp"+id_claim+"").text(percentComplete+"%");
										},
										success: (data) => {
											let data_json = JSON.parse(data);
											let select_claim = data_json.select_claim;
											let due_date = Date.parse(data_json.due_date);
											let dateNow = Date.parse(data_json.dateNow);
											function closeModal() {
												$("#upload-ofp"+select_claim.id_customer_claim).modal('hide');
											}
											setTimeout(closeModal, 1500);
										},
										complete: (data) => {
											let data_json = JSON.parse(data.responseText);
											let jsonResponse = data_json.select_claim;
											let fileName = data_json.file_name;
											var opts = {
												"closeButton": true,
												"debug": false,
												"positionClass": "toast-top-right",
												"onclick": null,
												"showDuration": "300",
												"hideDuration": "1000",
												"timeOut": "5000",
												"extendedTimeOut": "1000",
												"showEasing": "swing",
												"hideEasing": "linear",
												"showMethod": "fadeIn",
												"hideMethod": "fadeOut"
											};
											function successUpload() {
												toastr.success('FILE OFP BERHASIL DIUPLOAD', "SUCCESS", opts);
												$("#download_ofp_file"+jsonResponse.id_customer_claim).removeAttr("disabled");
												$("#download_ofp_file"+jsonResponse.id_customer_claim).attr("href", "<?php echo base_url('assets/claim_customer/ofp/'); ?>"+fileName+"");
												if(jsonResponse.ppt_file != null && jsonResponse.ofp != null && jsonResponse.id_pergantian_part != null && jsonResponse.id_sortir_stock != null && jsonResponse.id_pfmea != null) {
													$("#status_claim"+jsonResponse.id_customer_claim).text("");
													$("#status_claim"+jsonResponse.id_customer_claim).text("CLOSE");
												}
											}
											function afterUpload() {
												$("span.file-input-name").text("");
												$("#progress-bar-ofp"+id_claim+"").width('0%');
												$("#nama_file_ofp"+id_claim+"").val(null);
											}
											setTimeout(successUpload, 1500);
											setTimeout(afterUpload, 2000);
										},
										error: function(jqXHR, textStatus, errorThrown) {
											alert(textStatus +" "+errorThrown);
											// $("#error_text").text(textStatus +" "+errorThrown);
											// $("#modal-error-ajax").modal('show');;
										}
									});
								});

								$("#simpan_pergantian"+id_claim+"").click((e) => {
									e.preventDefault();
									let tgl_pembayaran = $("#tgl_pembayaran"+id_claim+"").val();
									let no_gi_451 = $("#no_gi_451"+id_claim+"").val();
									let no_gi_945 = $("#no_gi_945"+id_claim+"").val();
									if(tgl_pembayaran != "" && no_gi_451 != "" && no_gi_945 != "") {
										$.ajax({
											url: "<?php echo base_url('claim/customerclaim/pergantian_part'); ?>",
											type: "POST",
											data: $("#upload_pergantian"+id_claim+"").serialize(),
											dataType: "JSON",
											cache: false,
											success: (data) => {
												var opts = {
													"closeButton": true,
													"debug": false,
													"positionClass": "toast-top-right",
													"onclick": null,
													"showDuration": "300",
													"hideDuration": "1000",
													"timeOut": "5000",
													"extendedTimeOut": "1000",
													"showEasing": "swing",
													"hideEasing": "linear",
													"showMethod": "fadeIn",
													"hideMethod": "fadeOut"
												};
												toastr.success('PERGANTIAN PART BERHASIL DILAKUKAN!', "SUCCESS", opts);

											},
											complete: (data) => {
												let responseJSON = data.responseJSON.select_claim;
												let status_pergantian = "<i id='ganti-part"+id_claim+"' class='entypo-check' style='color: #21bf73; font-weight: bold; font-size: 15px;'></i> Sudah melakukan pergantian part"
												$("#tgl_pembayaran"+id_claim+"").val(null);
												$("#no_gi_451"+id_claim+"").val("");
												$("#no_gi_945"+id_claim+"").val("");
												$("#modal-pergantian-part"+id_claim+"").remove();
												$("#pergantian_part"+id_claim+"").html(status_pergantian);
												$("#pergantian-part"+id_claim+"").modal('hide');
												if(responseJSON.ppt_file != null && responseJSON.ofp != null && responseJSON.id_pergantian_part != null && responseJSON.id_sortir_stock != null && responseJSON.id_pfmea != null) {
													$("#status_claim"+responseJSON.id_customer_claim).text("");
													$("#status_claim"+responseJSON.id_customer_claim).text("CLOSE");
												}
											},
											error: (jqXHR, textStatus, errorThrown) => {
												alert(textStatus +" "+errorThrown);
												// $("#error_text").text(textStatus +" "+errorThrown);
												// $("#modal-error-ajax").modal('show');;
											}
										});
									} else {
										alert("SEMUA FIELD HARUS DI ISI TERLEBIH DAHULU!!!");
									}
								});

								$("#simpan_sortir"+id_claim+"").click((e) => {
									e.preventDefault();
									let tgl_sortir = $("#tgl_sortir"+id_claim+"").val();
									let stock = $("#stock"+id_claim+"").val();
									let ok = $("#ok"+id_claim+"").val();
									let ng = $("#ng"+id_claim+"").val();
									if(tgl_sortir != "" && stock != "" && ok != "" && ng != "") {
										$.ajax({
											url: "<?php echo base_url('claim/customerclaim/simpan_sortir/'); ?>"+id_claim+"",
											type: "POST",
											data: $("#create_sortir_stock"+id_claim+"").serialize(),
											dataType: "JSON",
											cache: false,
											success: (data) => {
												var opts = {
													"closeButton": true,
													"debug": false,
													"positionClass": "toast-top-right",
													"onclick": null,
													"showDuration": "300",
													"hideDuration": "1000",
													"timeOut": "5000",
													"extendedTimeOut": "1000",
													"showEasing": "swing",
													"hideEasing": "linear",
													"showMethod": "fadeIn",
													"hideMethod": "fadeOut"
												};
												toastr.success('SORTIR STOCK BERHASIL DILAKUKAN!', "SUCCESS", opts);
											},
											complete: (data) => {
												let responseJSON = data.responseJSON.select_claim;
												let status_complete = "<i id='ganti-part"+id_claim+"' class='entypo-check' style='color: #21bf73; font-weight: bold; font-size: 15px;'></i>"
												$("#modal-sortir-stock"+id_claim+"").remove();
												$("#tgl_sortir"+id_claim+"").val(null);
												$("#type"+id_claim+"").val("");
												$("#stock"+id_claim+"").val(0);
												$("#ok"+id_claim+"").val(0);
												$("#ng"+id_claim+"").val(0);
												$("#sisa"+id_claim+"").val(0);
												$("#status-sortir-stock"+id_claim+"").html(status_complete);
												$("#sortir-stock"+id_claim+"").modal('hide');
												if(responseJSON.ppt_file != null && responseJSON.ofp != null && responseJSON.id_pergantian_part != null && responseJSON.id_sortir_stock != null && responseJSON.id_pfmea != null) {
													$("#status_claim"+responseJSON.id_customer_claim).text("");
													$("#status_claim"+responseJSON.id_customer_claim).text("CLOSE");
												}
											},
											error: (jqXHR, textStatus, errorThrown) => {
												alert(textStatus +" "+errorThrown);
												// $("#error_text").text(textStatus +" "+errorThrown);
												// $("#modal-error-ajax").modal('show');;
											}
										});
									} else {
										alert("SEMUA FIELD HARUS DI ISI TERLEBIH DAHULU!!!")
									}	
								});

								$("#pfmea_file"+id_claim+"").submit(function(e) {
									e.preventDefault();
									$(this).ajaxSubmit({
										beforeSubmit: () => {
											$("#progress-bar-pfmea"+id_claim+"").width('0%');
										},
										uploadProgress: (event, position, total, percentComplete) => {
											$("#progress-bar-pfmea"+id_claim+"").width(percentComplete + '%');
											$("span#progress-pfmea"+id_claim+"").text(percentComplete+"%");
										},

										success: (data) => {
											let data_json = JSON.parse(data);
											let select_claim = data_json.select_claim;
											let due_date = Date.parse(data_json.due_date);
											let dateNow = Date.parse(data_json.dateNow);
											function closeModal() {
												$("#pfmea"+select_claim.id_customer_claim).modal('hide');
											}
											setTimeout(closeModal, 1500);
										},
										complete: (data) => {
											let data_json = JSON.parse(data.responseText);
											let jsonResponse = data_json.select_claim;
											let fileName = data_json.file_name;
											let id_pfmea = jsonResponse.id_pfmea;
											var opts = {
												"closeButton": true,
												"debug": false,
												"positionClass": "toast-top-right",
												"onclick": null,
												"showDuration": "300",
												"hideDuration": "1000",
												"timeOut": "5000",
												"extendedTimeOut": "1000",
												"showEasing": "swing",
												"hideEasing": "linear",
												"showMethod": "fadeIn",
												"hideMethod": "fadeOut"
											};
											function successUpload() {
												toastr.success('FILE PFMEA BERHASIL DIUPLOAD', "SUCCESS", opts);
												$(".enable_pfmea"+jsonResponse.id_customer_claim).removeAttr("disabled");
												$(".enable_pfmea"+jsonResponse.id_customer_claim).attr("id", "modal_files"+id_pfmea+"");
												if(jsonResponse.ppt_file != null && jsonResponse.ofp != null && jsonResponse.id_pergantian_part != null && jsonResponse.id_sortir_stock != null && jsonResponse.id_pfmea != null) {
													$("#status_claim"+jsonResponse.id_customer_claim).text("");
													$("#status_claim"+jsonResponse.id_customer_claim).text("CLOSE");
												}
											}
											function afterUpload() {
												$("span.file-input-name").text("");
												$("#progress-bar-pfmea"+id_claim+"").width('0%');
												$("#nama_file_pfmea"+id_claim+"").val(null);
											}
											setTimeout(successUpload, 1500);
											setTimeout(afterUpload, 2000);
										},
										error: function(jqXHR, textStatus, errorThrown) {
											alert(textStatus +" "+errorThrown);
											// $("#error_text").text(textStatus +" "+errorThrown);
											// $("#modal-error-ajax").modal('show');;
										}
									});
								});
							}	
						}

					load_uniqID();
				},
			});
		}

		function filter_customer_in_table() {
			$("#table_ganti_customer, #table_ganti_part, #table_year").change((e)=> {
				let new_date = new Date();
				let dateNow = formatDate(new_date);
				$.ajax({
					type: "GET",
					url: "<?php echo base_url('claim/customerclaim/filter_table'); ?>",
					data: $("#filter_table").serialize(),
					dataType: "JSON",
					beforeSend: () => {
						$("#main-table").removeClass("show-main-table");
						$("#main-table").addClass("hide-main-table");
						$("#skeleton-table").addClass("show-skeleton-table");
						table_customer_claim.clear().draw();
					},
					success: (data) => {
						function show_table() {
							$("#skeleton-table").removeClass("show-skeleton-table");
							$("#skeleton-table").addClass("remove-skeleton-table");
							$("#main-table").removeClass("hide-main-table");
							$("#main-table").addClass("show-main-table");
						}

						let uniq = 1;
						for(let i in data) {
							let no = parseInt(i) + 1;
							let create_date = new Date(data[i].tgl_input);
							create_date.setDate(create_date.getDate() + 3);
							let year = create_date.getFullYear();
							let increment_month = create_date.getMonth() + 1
							let month = ('0' + increment_month).slice(-2);
							let day = ('0' + create_date.getDate()).slice(-2);
							let due_date = `${year}-${month}-${day}`;
							let date_now = Date.parse(dateNow);
							let parse_due_date = Date.parse(due_date);
							let ofp_upload = "<a href='javascript:;' id='modal-upload-ofp"+data[i].id_customer_claim+"' class='btn btn-blue btn-icon icon-left'> Upload<i class='entypo-upload'></i></a>";
							let button_upload = "<a href='javascript:;' id='modal-upload-ppt"+data[i].id_customer_claim+"' class='btn btn-blue btn-icon icon-left'> Upload<i class='entypo-upload'></i></a>";
							let pergantian_part;
							let button_download;
							let ofp_download;
							let upload_pfmea = "<a href='javascript:;' id='modal-pfmea"+data[i].id_customer_claim+"' class='btn btn-blue'><i class='entypo-upload'></i></a>";
							let see_pfmea;
							let sortir_stock;
							if(data[i].ppt_file == null) {
								button_download = "<a disabled class='btn btn-success btn-icon icon-left' id='download_ppt_file"+data[i].id_customer_claim+"'> Download<i class='entypo-download'></i></a>";
							} else {
								if(data[i].ppt_file != null) {
									button_download = "<a target='_blank' href='<?php echo base_url('assets/claim_customer/ppt/')?>"+data[i].ppt_file+"' class='btn btn-success btn-icon icon-left' download='PART - "+data[i].nama_part+"' id='download_ppt_file"+data[i].id_customer_claim+"'>Download <i class='entypo-download'></i></a>";
								}		
							}

							if(data[i].ofp == null) {
								ofp_download = "<a disabled class='btn btn-success btn-icon icon-left' id='download_ofp_file"+data[i].id_customer_claim+"'> Download<i class='entypo-download'></i></a>";
							} else {
								if(data[i].ofp != null) {
									ofp_download = "<a target='_blank' href='<?php echo base_url('assets/claim_customer/ofp/')?>"+data[i].ofp+"' class='btn btn-success btn-icon icon-left' download='OFP - "+data[i].nama_part+"' id='download_ofp_file"+data[i].id_customer_claim+"'>Download <i class='entypo-download'></i></a>";
								}		
							}

							if(data[i].id_pergantian_part == null) {
								pergantian_part = "<a href='javascript:;' id='modal-pergantian-part"+data[i].id_customer_claim+"' class='btn btn-info btn-icon icon-left'><i class='entypo-pencil'></i> Pergantian Part</a>";
							} else {
								if(data[i].id_pergantian_part != null) {
									pergantian_part  = "<i id='ganti-part"+data[i].id_customer_claim+"' class='entypo-check' style='color: #21bf73; font-weight: bold; font-size: 15px;'></i> Sudah melakukan pergantian part";
								}
							}

							if(data[i].id_sortir_stock == null) {
								sortir_stock = "<a href='javascript:;' id='modal-sortir-stock"+data[i].id_customer_claim+"' class='btn btn-blue'><i class='entypo-pencil'></i></a>";
							} else {
								if(data[i].id_sortir_stock != null) {
									sortir_stock = "<i id='ganti-part"+data[i].id_customer_claim+"' class='entypo-check' style='color: #21bf73; font-weight: bold; font-size: 15px;'></i>";
								}
							}

							if(data[i].id_pfmea == null) {
								see_pfmea = "<a class='btn btn-info enable_pfmea"+data[i].id_customer_claim+"' class='btn btn-info' disabled><i class='entypo-eye'></i></a>";
							} else {
								if(data[i].id_pfmea != null) {
									see_pfmea  = "<a href='javascript:;' id='modal_files"+data[i].id_customer_claim+"' class='btn btn-info'><i class='entypo-eye'></i></a>";
								}
							}

							if(data[i].ofp != null && data[i].id_pergantian_part != null && data[i].id_sortir_stock != null && data[i].ppt_file != null && data[i].id_pfmea != null) {
								data[i].status = 'CLOSE';
							}

							if(data[i].card == "#N/A") {
								data[i].card = '-'
							}
							table_customer_claim.row.add([
								''+uniq+'',
								''+data[i].tgl_input+'',
								''+data[i].no_surat_claim+'',
								''+data[i].nama_part+'',
								''+data[i].type+'',
								''+data[i].proses+'',
								''+due_date+'',
								''+ofp_upload+' '+ofp_download+'',
								''+pergantian_part+'',
								''+sortir_stock+'',
								''+button_upload+' '+button_download+'',
								''+upload_pfmea+' '+see_pfmea+'',
								''+data[i].status+'',
								''+data[i].card+''
							]).draw(false);
								uniq += 1;
						}

						setTimeout(show_table, 1500);

					},
					error: (jqXHR, textStatus, errorThrown) => {
						alert(textStatus +" "+errorThrown);
					},

					complete: (data) => {
						function load_uniqID() {
							let sign = 1;
							for(let i in data.responseJSON) {
								let create_date = new Date(data.responseJSON[i].tgl_input);
								create_date.setDate(create_date.getDate() + 3);
								let year = create_date.getFullYear();
								let increment_month = create_date.getMonth() + 1
								let month = ('0' + increment_month).slice(-2);
								let day = ('0' + create_date.getDate()).slice(-2);
								let due_date = `${year}-${month}-${day}`;
								let date_now = Date.parse(dateNow);
								let parse_due_date = Date.parse(due_date);
								let id_claim = data.responseJSON[i].id_customer_claim;
								let uniqID = "status_color"+id_claim;
								let id_card = "card-"+sign;
								let card = data.responseJSON[i].card;
								let status = "status_claim"+id_claim;
								let pergantian_part = "pergantian_part"+id_claim;
								let status_sortir_stock = "status-sortir-stock"+id_claim;
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(7)").attr("id", uniqID);
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(14)").attr("id", id_card);
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(6)").attr("class", "proses");
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(5)").attr("class", "proses");
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(3)").attr("class", "no_surat_claim");
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(11)").attr("class", "pica");
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(9)").attr("class", "centered");
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(9)").attr("id", pergantian_part);
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(10)").attr("class", "centered");
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(10)").attr("id", status_sortir_stock);
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(13)").attr("class", "centered");
								$("#table_customer_claim tr:nth-child("+sign+") td:nth-child(13)").attr("id", status);
								$("#status_claim"+id_claim+"").addClass("status");
								if(date_now > parse_due_date) {
									if(data.responseJSON[i].ppt_file != null) {
										$("#"+uniqID).addClass("kuning");
									} else {
										$("#"+uniqID).addClass("red");
									}
								} else {
									if(data.responseJSON[i].ppt_file != null) {
										$("#"+uniqID).addClass("hijau");
									} else {
										$("#"+uniqID).addClass("text-align");
									}
								}

								if(card == 'Green Card') {
									$("#"+id_card).addClass("hijau");
								} else if(card == 'Yellow Card') {
									$("#"+id_card).addClass("kuning");
								} else {
									if(card == 'Red Card') {
										$("#"+id_card).addClass("red");
									} else {
										$("#"+id_card).addClass("netral");
									}
								}
								sign += 1;
								$("#table_customer_claim").on('click', '#modal-upload-ppt'+id_claim+'', function() {
									$("#upload-ppt"+id_claim).modal('show');
								});

								$("#table_customer_claim").on('click', '#modal-upload-ofp'+id_claim+'', function() {
									$("#upload-ofp"+id_claim).modal('show');
								});

								$("#table_customer_claim").on('click', '#modal-pergantian-part'+id_claim+'', function() {
									$("#pergantian-part"+id_claim).modal('show');
								});
								
								$("#table_customer_claim").on('click', '#modal-sortir-stock'+id_claim+'', function() {
									$("#sortir-stock"+id_claim).modal('show');
								});
							}	
						}

						load_uniqID();	
					},
				});
			});
		}

		filter_customer_in_table();
		load_all_customer_claim();
		
    });
</script>
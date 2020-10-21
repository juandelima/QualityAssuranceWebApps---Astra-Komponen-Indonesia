<script>
	jQuery(document).ready(function($) {
		const root_url = "<?php echo base_url(); ?>";
		const sortir_part = root_url.concat("claim/customerclaim/sortir_part/");
        const get_ofp_files = root_url.concat("claim/customerclaim/get_ofp_files/");
        const get_pica_files = root_url.concat("claim/customerclaim/get_pica_files/");
        const get_pfmea_files = root_url.concat("claim/customerclaim/get_pfmea_files/");
		const simpan_pergantian_part = root_url.concat("claim/customerclaim/pergantian_part");
		const simpan_sortir = root_url.concat("claim/customerclaim/simpan_sortir/");
        const role = "<?php echo $this->session->userdata['role']; ?>";
        const get_data_delivery = '<?php echo $get_data_delivery; ?>';
        const count_delivery = <?php echo $count_delivery; ?>;
        const customerClaim = new CustomerClaim(root_url);
        delivery(root_url, role);
		customerClaim.main();
		<?php
			foreach($customer_claim as $data) {
				$id = $data->id_customer_claim;
		?>			
				$("#table_customer_claim").on('click', '#modal-upload-ppt<?php echo $id; ?>', function() {
                    $("#upload-ppt<?php echo $id; ?>").modal('show');
                });

                $("#table_customer_claim").on('click', '#modal-upload-ofp<?php echo $id; ?>', function() {
                	$("#upload-ofp<?php echo $id; ?>").modal('show');
                });

                $("#table_customer_claim").on('click', '#modal-pergantian-part<?php echo $id; ?>', function() {
                    $("#pergantian-part<?php echo $id; ?>").modal('show');
                });

                $("#table_customer_claim").on('click', '#modal-pfmea<?php echo $id; ?>', () => {
                    $("#pfmea<?php echo $id; ?>").modal('show');
				});

				$("#table_customer_claim").on('click', '#modal-sortir-stock<?php echo $id; ?>', () => {
                    $.ajax({
                        type: "GET",
                        url: `${sortir_part}<?php echo $id; ?>`,
                        dataType: "JSON",
                        cache: false,
                        beforeSend: () => {
                            $("#problem_part<?php echo $id; ?>").html("");
                        },
                        success: (data_sortir) => {
                            let mod = data_sortir.sisa;
                        	let stock = data_sortir.stock;
                            let ok = data_sortir.ok;
                            let ng = data_sortir.ng;
                            parseInt($("#ok<?php echo $id; ?>").val(ok));
                            parseInt($("#ng<?php echo $id; ?>").val(ng));
                            parseInt($("#sisa<?php echo $id; ?>").val(mod));
                            ok = parseInt($("#ok<?php echo $id; ?>").val());
                            ng = parseInt($("#ng<?php echo $id; ?>").val());
                            if(mod != 0) {
                                ok = parseInt($("#ok<?php echo $id; ?>").val());
                                ng = parseInt($("#ng<?php echo $id; ?>").val());
                                if(ok > 0) {
                                    $("#btn_min_ok<?php echo $id; ?>").attr("disabled", false);
                                } else {
                                    $("#btn_min_ok<?php echo $id; ?>").attr("disabled", true);
                                }

                                if(ng > 0) {
                                    $("#btn_min_ng<?php echo $id; ?>").attr("disabled", false);
                                } else {
                                    $("#btn_min_ng<?php echo $id; ?>").attr("disabled", true);
                                }
                                $("#btn_plus_ok<?php echo $id; ?>").attr("disabled", false);
                                $("#btn_plus_ng<?php echo $id; ?>").attr("disabled", false);
                                parseInt($("#stock<?php echo $id; ?>").val(stock));
                            } else {
                                $("#btn_plus_ok<?php echo $id; ?>").attr("disabled", true);
                                $("#btn_plus_ng<?php echo $id; ?>").attr("disabled", true);
                                $("#btn_min_ok<?php echo $id; ?>").attr("disabled", true);
                                $("#btn_min_ng<?php echo $id; ?>").attr("disabled", true);
                                parseInt($("#stock<?php echo $id; ?>").val(0));
                            }

                            stock = parseInt($("#stock<?php echo $id; ?>").val());
                            let sisa = parseInt($("#sisa<?php echo $id; ?>").val());

                            $("#stock<?php echo $id; ?>").keyup((e) => {
                                stock = parseInt($(e.target).val());
                                if(stock > 0) {
                                    $("#ok<?php echo $id; ?>").attr('readonly', false);
                                    $("#ng<?php echo $id; ?>").attr('readonly', false);
                                    $("#btn_plus_ok<?php echo $id; ?>").attr("disabled", false);
                                    $("#btn_plus_ng<?php echo $id; ?>").attr("disabled", false);
                                    } else {
                                        $("#ok<?php echo $id; ?>").attr('readonly', true);
                                        $("#ng<?php echo $id; ?>").attr('readonly', true);
                                        $("#btn_plus_ok<?php echo $id; ?>").attr("disabled", true);
                                        $("#btn_plus_ng<?php echo $id; ?>").attr("disabled", true);
                                        parseInt($("#sisa<?php echo $id; ?>").val(0));
                                        parseInt($(e.target).val(0));
                                    }
                                    if(ok > 0 || ng > 0) {
                                        sisa = stock - Math.abs(ok + ng);
                                        if(sisa > 0) {
                                            parseInt($("#sisa<?php echo $id; ?>").val(sisa));
                                        }
                                        if(stock < Math.abs(ok + ng)) {
                                            // parseInt($(e.target).val(Math.abs(ok + ng)));
                                            sisa = parseInt($("#sisa<?php echo $id; ?>").val(0));
                                        }

                                        if(stock >= Math.abs(ok + ng)) {
                                            sisa = stock - Math.abs(ok + ng);
                                            sisa = parseInt($("#sisa<?php echo $id; ?>").val(sisa));
                                        }
                                    }
                            });

                            $("#ok<?php echo $id; ?>").keyup((e) => {
                                ok = parseInt($(e.target).val());
                                ng = parseInt($("#ng<?php echo $id; ?>").val());
                                if(ok > 0) {
                                    $("#btn_min_ok<?php echo $id; ?>").attr("disabled", false);
                                } else {
                                    $("#btn_min_ok<?php echo $id; ?>").attr("disabled", true);
                                }
                                if(Math.abs(ok + ng) >= stock) {
                                    $("#btn_plus_ok<?php echo $id; ?>").attr("disabled", true);
                                    $("#btn_plus_ng<?php echo $id; ?>").attr("disabled", true);
                                    parseInt($("#sisa<?php echo $id; ?>").val(0));
                                    $("#stock<?php echo $id; ?>").val(Math.abs(ok + ng));
                                } else {
                                    $("#btn_plus_ok<?php echo $id; ?>").attr("disabled", false);
                                    $("#btn_plus_ng<?php echo $id; ?>").attr("disabled", false);
                                    sisa = stock - Math.abs(ok + ng);
                                    parseInt($("#sisa<?php echo $id; ?>").val(sisa));
                                }
                                        
                            });


                            $("#ng<?php echo $id; ?>").keyup((e) => {
                                ng = parseInt($(e.target).val());
                                if(ng > 0) {
                                    $("#btn_min_ng<?php echo $id; ?>").attr("disabled", false);
                                } else {
                                    $("#btn_min_ng<?php echo $id; ?>").attr("disabled", true);
                                }
                                if(Math.abs(ok + ng) >= stock) {
                                    $("#btn_plus_ng<?php echo $id; ?>").attr("disabled", true);
                                	$("#btn_plus_ok<?php echo $id; ?>").attr("disabled", true);
                                    parseInt($("#sisa<?php echo $id; ?>").val(0));
                                    $("#stock<?php echo $id; ?>").val(Math.abs(ok + ng));
                                } else {
                                    $("#btn_plus_ng<?php echo $id; ?>").attr("disabled", false);
                                    $("#btn_plus_ok<?php echo $id; ?>").attr("disabled", false);
                                    sisa = stock - Math.abs(ok + ng);
                                    parseInt($("#sisa<?php echo $id; ?>").val(sisa));
                                }
                                        
                            });

                            $("#problem_part<?php echo $id; ?>").text(data_sortir.problem_part).css("color", "#000");
                            $("#problem_part<?php echo $id; ?>").text(data_sortir.problem_part).css("font-weight", "bolder");
                            $("#sortir-stock<?php echo $id; ?>").modal('show');
                        },
                        error: (jqXHR, textStatus, errorThrown) => {
                            alert(textStatus +" "+errorThrown);
                        }
                    });
				});
				
				$("#upload_ofpfile<?php echo $id; ?>").submit(function(e) {
					e.preventDefault();
                    $(this).ajaxSubmit({
                        beforeSubmit: () => {
                            $("#progress-bar-ofp<?php echo $id; ?>").width('0%');
                        },
                        uploadProgress: (event, position, total, percentComplete) => {
                            $("#progress-bar-ofp<?php echo $id; ?>").width(percentComplete + '%');
                            $("span#progress-ofp<?php echo $id; ?>").text(percentComplete+"%");
                        },
                        success: (data) => {
                            let data_json = JSON.parse(data);
                            let select_claim = data_json.select_claim;
                            function closeModal() {
                                $("#upload-ofp"+select_claim.id_customer_claim).modal('hide');
                            }
                            setTimeout(closeModal, 1500);
                        },
                        complete: (data) => {
                            let data_json = JSON.parse(data.responseText);
                            let jsonResponse = data_json.select_claim;
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
                                $(".enable_ofp"+jsonResponse.id_customer_claim).removeAttr("disabled");
                                $(".enable_ofp"+jsonResponse.id_customer_claim).attr("id", `download_ofp_file${jsonResponse.id_customer_claim}`);
                                if(jsonResponse.ppt_file != null && jsonResponse.ofp != null && jsonResponse.id_pergantian_part != null && jsonResponse.id_sortir_stock != null && jsonResponse.id_pfmea != null) {
                                    $("#status_claim"+jsonResponse.id_customer_claim).text("");
                                    $("#status_claim"+jsonResponse.id_customer_claim).text("CLOSE");
                                }
                            }
                            function afterUpload() {
                                $("span.file-input-name").text("");
                                $("#progress-bar-ofp"+jsonResponse.id_customer_claim+"").width('0%');
                                $("#nama_file_ofp"+jsonResponse.id_customer_claim+"").val(null);
                            }
                            setTimeout(successUpload, 1500);
                            setTimeout(afterUpload, 2000);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert(textStatus +" "+errorThrown);
                        }
                    });
				});
				
				$("#table_customer_claim").on('click', '#download_ofp_file<?php echo $id; ?>', () => {
					$("#table_file_ofp<?php echo $id; ?>").DataTable({
                        "oLanguage": {
                            "sSearch": "Search:",
                            "oPaginate": {
                                "sPrevious": "Previous",
                                "sNext": "Next"
                            }
                        },
                        "lengthChange": false,
                        "JQueryUI":true,
                        "scrollCollapse":true,
                        "paging": true,
                        "initComplete": function (settings, json) {  
                            $("#table_file_ofp<?php echo $id; ?>").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
                        },
						ajax: {
							"url": `${get_ofp_files}<?php echo $id; ?>`,
							"type": "GET"
						},
						destroy: true,
						processing: true,
						deferRender: true,
						columns: [
							{
                    			data: 'no'
							},
							{
								data: 'tgl_upload'
							},
							{
								data: 'nama_file'
							},
							{
								data: 'download'
							}
						]
					});
                    $("#modal_view_ofp_files<?php echo $id; ?>").modal('show');
				});
				
				$("#simpan_pergantian<?php echo $id; ?>").click((e) => {
                    e.preventDefault();
                    let tgl_pembayaran = $("#tgl_pembayaran<?php echo $id; ?>").val();
                    let no_gi_451 = $("#no_gi_451<?php echo $id; ?>").val();
                    let no_gi_945 = $("#no_gi_945<?php echo $id; ?>").val();
                    if(tgl_pembayaran != "" && no_gi_451 != "" && no_gi_945 != "") {
                        $.ajax({
                            url: simpan_pergantian_part,
                            type: "POST",
                            data: $("#upload_pergantian<?php echo $id; ?>").serialize(),
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
                                let status_pergantian = "<i class='entypo-check' style='color: #21bf73; font-weight: bold; font-size: 15px;'></i> Sudah melakukan pergantian part"
                                $("#tgl_pembayaran"+responseJSON.id_customer_claim+"").val(null);
                                $("#no_gi_451"+responseJSON.id_customer_claim+"").val("");
                                $("#no_gi_945"+responseJSON.id_customer_claim+"").val("");
                                $("#modal-pergantian-part"+responseJSON.id_customer_claim+"").remove();
                            	$("#pergantian_part"+responseJSON.id_customer_claim+"").html(status_pergantian);
                                $("#pergantian-part"+responseJSON.id_customer_claim+"").modal('hide');
                                if(responseJSON.ppt_file != null && responseJSON.ofp != null && responseJSON.id_pergantian_part != null && responseJSON.id_sortir_stock != null && responseJSON.id_pfmea != null) {
                                    $("#status_claim"+responseJSON.id_customer_claim).text("");
                                    $("#status_claim"+responseJSON.id_customer_claim).text("CLOSE");
                                }
                            },
                            error: (jqXHR, textStatus, errorThrown) => {
                                alert(textStatus +" "+errorThrown);
                            }
                		});
                    } else {
                        alert("SEMUA FIELD HARUS DI ISI TERLEBIH DAHULU!!!");
                    }
				});
				
				$("#simpan_sortir<?php echo $id; ?>").click((e) => {
                    e.preventDefault();
                    let tgl_sortir = $("#tgl_sortir<?php echo $id; ?>").val();
                    let stock = $("#stock<?php echo $id; ?>").val();
                    let ok = $("#ok<?php echo $id; ?>").val();
                    let ng = $("#ng<?php echo $id; ?>").val();
                    if(tgl_sortir != "" && stock != "" && ok != "" && ng != "") {
                        $.ajax({
                            url: `${simpan_sortir}<?php echo $id; ?>`,
                            type: "POST",
                            data: $("#create_sortir_stock<?php echo $id; ?>").serialize(),
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
                                let sisa_stock = data.responseJSON.sisa_stock;
                                let status_complete;
                                if(parseInt(sisa_stock) > 0) {
                                    status_complete = "<a href='javascript:;' id='modal-sortir-stock"+responseJSON.id_customer_claim+"' class='btn btn-success'><i class='entypo-pencil'></i></a>"
                                } else {
                                    status_complete = "<i id='ganti-part"+responseJSON.id_customer_claim+"' class='entypo-check' style='color: #21bf73; font-weight: bold; font-size: 15px;'></i>"
                                }
                                        
                                $("#modal-sortir-stock"+responseJSON.id_customer_claim+"").remove();
                                $("#tgl_sortir"+responseJSON.id_customer_claim+"").val(null);
                                $("#stock"+responseJSON.id_customer_claim+"").val(0);
                                $("#ok"+responseJSON.id_customer_claim+"").val(0);
                                $("#ng"+responseJSON.id_customer_claim+"").val(0);
                                $("#sisa"+responseJSON.id_customer_claim+"").val(0);
                                $("#status-sortir-stock"+responseJSON.id_customer_claim+"").html(status_complete);
                                $("#sortir-stock"+responseJSON.id_customer_claim+"").modal('hide');
                                if(responseJSON.ppt_file != null && responseJSON.ofp != null && responseJSON.id_pergantian_part != null && responseJSON.id_sortir_stock != null && responseJSON.id_pfmea != null) {
                                    $("#status_claim"+responseJSON.id_customer_claim).text("");
                                    $("#status_claim"+responseJSON.id_customer_claim).text("CLOSE");
                                }
                            },
                            error: (jqXHR, textStatus, errorThrown) => {
                                alert(textStatus +" "+errorThrown);
                            }
                        });
                    } else {
                        alert("SEMUA FIELD HARUS DI ISI TERLEBIH DAHULU!!!")
                    }	
                });

                $("#upload_file<?php echo $id; ?>").submit(function(e) {
                    e.preventDefault();
                    $(this).ajaxSubmit({
                        beforeSubmit: () => {
                            $("#progress-bar<?php echo $id; ?>").width('0%');
                        },
                        uploadProgress: (event, position, total, percentComplete) => {
                            $("#progress-bar<?php echo $id; ?>").width(percentComplete + '%');
                            $("span#progress<?php echo $id; ?>").text(percentComplete+"%");
                        },
                        success: (data) => {
                            let data_json = JSON.parse(data);
                            let select_claim = data_json.select_claim;
                            let due_date = Date.parse(data_json.due_date);
                            let dateNow = Date.parse(data_json.dateNow);
                            function closeModal() {
                                if(dateNow > due_date) {
                                    $("#status_color"+select_claim.id_customer_claim).addClass('kuning');
                                } else {
                                    $("#status_color"+select_claim.id_customer_claim).addClass('hijau');
                                }
                                $("#upload-ppt"+select_claim.id_customer_claim).modal('hide');
                            }
                            setTimeout(closeModal, 1500);
                        },
                        complete: (data) => {
                            let data_json = JSON.parse(data.responseText);
                            let jsonResponse = data_json.select_claim;
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
                                $(".enable_pica"+jsonResponse.id_customer_claim).removeAttr("disabled");
                                $(".enable_pica"+jsonResponse.id_customer_claim).attr("id", `download_ppt_file${jsonResponse.id_customer_claim}`);
                                if(jsonResponse.ppt_file != null && jsonResponse.ofp != null && jsonResponse.id_pergantian_part != null && jsonResponse.id_sortir_stock != null && jsonResponse.id_pfmea != null) {
                                    $("#status_claim"+jsonResponse.id_customer_claim).text("");
                                    $("#status_claim"+jsonResponse.id_customer_claim).text("CLOSE");
                                }
                            }
                            function afterUpload() {
                                $("span.file-input-name").text("");
                                $("#progress-bar"+jsonResponse.id_customer_claim+"").width('0%');
                                $("#nama_file"+jsonResponse.id_customer_claim+"").val(null);
                            }
                            setTimeout(successUpload, 1500);
                            setTimeout(afterUpload, 2000);
                            $("#upload-ppt"+jsonResponse.id_customer_claim+"").unbind();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert(textStatus +" "+errorThrown);
                         }
                    });
                });

                $("#table_customer_claim").on('click', "#download_ppt_file<?php echo $id; ?>", () => {
                    $("#table_file_pica<?php echo $id; ?>").DataTable({
                        "oLanguage": {
                            "sSearch": "Search:",
                            "oPaginate": {
                                "sPrevious": "Previous",
                                "sNext": "Next"
                            }
                        },
                        "lengthChange": false,
                        "JQueryUI":true,
                        "scrollCollapse":true,
                        "paging": true,
                        "initComplete": function (settings, json) {  
                            $("#table_file_pica<?php echo $id; ?>").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
                        },
						ajax: {
							"url": `${get_pica_files}<?php echo $id; ?>`,
							"type": "GET"
						},
						destroy: true,
						processing: true,
						deferRender: true,
						columns: [
							{
                    			data: 'no'
							},
							{
								data: 'tgl_upload'
							},
							{
								data: 'nama_file'
							},
							{
								data: 'download'
							}
						]
					});
                    $("#modal_view_pica_files<?php echo $id; ?>").modal('show');
                });

                $("#pfmea_file<?php echo $id; ?>").submit(function(e) {
                    e.preventDefault();
                    $(this).ajaxSubmit({
                        beforeSubmit: () => {
                            $("#progress-bar-pfmea<?php echo $id; ?>").width('0%');
                        },
                        uploadProgress: (event, position, total, percentComplete) => {
                            $("#progress-bar-pfmea<?php echo $id; ?>").width(percentComplete + '%');
                            $("span#progress-pfmea<?php echo $id; ?>").text(percentComplete+"%");
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
                                $(".enable_pfmea"+jsonResponse.id_customer_claim).attr("id", "modal_files"+jsonResponse.id_customer_claim+"");
                                if(jsonResponse.ppt_file != null && jsonResponse.ofp != null && jsonResponse.id_pergantian_part != null && jsonResponse.id_sortir_stock != null && jsonResponse.id_pfmea != null) {
                                    $("#status_claim"+jsonResponse.id_customer_claim).text("");
                                    $("#status_claim"+jsonResponse.id_customer_claim).text("CLOSE");
                                }
                            }
                            function afterUpload() {
                                $("span.file-input-name").text("");
                                $("#progress-bar-pfmea"+jsonResponse.id_customer_claim+"").width('0%');
                                $("#nama_file_pfmea"+jsonResponse.id_customer_claim+"").val(null);
                            }
                            setTimeout(successUpload, 1500);
                            setTimeout(afterUpload, 2000);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert(textStatus +" "+errorThrown);
                        }
                    });
                });

                $("#table_customer_claim").on('click', "#modal_files<?php echo $id; ?>", () => {
                    $("#table_file_pfmea<?php echo $id; ?>").DataTable({
                        "oLanguage": {
                            "sSearch": "Search:",
                            "oPaginate": {
                                "sPrevious": "Previous",
                                "sNext": "Next"
                            }
                        },
                        "lengthChange": false,
                        "JQueryUI":true,
                        "scrollCollapse":true,
                        "paging": true,
                        "initComplete": function (settings, json) {  
                            $("#table_file_pfmea<?php echo $id; ?>").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
                        },
						ajax: {
							"url": `${get_pfmea_files}<?php echo $id; ?>`,
							"type": "GET"
						},
						destroy: true,
						processing: true,
						deferRender: true,
						columns: [
							{
                    			data: 'no'
							},
							{
								data: 'tgl_upload'
							},
							{
								data: 'nama_file'
							},
							{
								data: 'download'
							}
						]
					});
                    $("#modal_view_files<?php echo $id; ?>").modal('show');
                });
		<?php
		}
		?>
	});
</script>
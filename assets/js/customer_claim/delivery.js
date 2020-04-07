function delivery(root_url) {
    let save_delivery = root_url.concat('claim/customerclaim/save_delivery');
    jQuery(document).ready(($) => {
        $("#form_delivery").find("#btn_min").attr("disabled", true);
		$("#form_delivery").find("#btn_plus").click(function add() {
			$("#form_delivery").find("#btn_min").attr("disabled", false);
		});

		$("#form_delivery").find("#btn_min").click(function subst() {
			let val_qty = $("#qty").val();
			if(val_qty < 2) {
				$("#form_delivery").find("#btn_min").attr("disabled", true);
			}
        });
		$("#input_delivery").on('click', '#save_qty', function(e) {
			e.preventDefault();
            let qty_val = $("#qty").val();
            let tgl_deliv = $("#tgl_deliv").val();
            if(qty_val != "" && tgl_deliv != "") {
                $.ajax({
                    url: save_delivery,
                    type: "POST",
                    data: $("#input_delivery").serialize(),
                    dataType: "JSON",
                    cache: false,
                    success: function(data) {
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
                        toastr.success('DELIVERY SUKSES TERSIMPAN', "SUCCESS", opts);
                    },
                    complete: function() {
                        $("#tgl_deliv").val(null);
                        $("#qty").val(1);
                        $("#form_delivery").find("#btn_min").attr("disabled", true);
                        $("#form_delivery").modal('hide');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert(textStatus +" "+errorThrown);
                        // $("#error_text").text(textStatus +" "+errorThrown);
                        // $("#modal-error-ajax").modal('show');;
                    }
                });
            } else {
                alert("TANGGAL DELIVERY TIDAK BOLEH KOSONG!");
            }
		});

		$('.input-spinner').find('[type="text"]').keyup(function() {
			var value = $(this).val();
			var isNum = $.isNumeric(value);
			if($(this).val() == "" || $(this).val() <= 0 || !isNum) {
				$(this).val(0);
			} else if($(this).val() > 0) {
 				$(this).val().replace(0,'');
   			}

    		if($(this).val()!=0) {
        		var text = $(this).val();
        		if(text.slice(0,1)==0) {
					$(this).val(text.slice(1,text.length));   
        		}
      		}
		});
    });
}
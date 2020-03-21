<script>
	jQuery(document).ready(function($) {
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
                    url: "<?php echo base_url('claim/customerclaim/ahm_delivery'); ?>",
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

        <?php
			$index = 0;
			foreach($customer_claim as $data) {
				$id = $data->id_customer_claim;
	    ?>
            // var stock = $("#stock<?php echo $id; ?>").val();

            // var ok = $("#ok<?php echo $id; ?>").val();
            // var ng = $("#ng<?php echo $id; ?>").val();
            // var sisa = $("#sisa<?php echo $id; ?>").val();
            // var keep_value = null;
            // var keep_stock;
            // if(ok === '0') {
            //     $("#btn_min_ok<?php echo $id ?>").attr("disabled", true);
            // }

            // if(ng === '0') {
            //     $("#btn_min_ng<?php echo $id ?>").attr("disabled", true);
            // }

            // if(stock === '0') {
            //     $("#btn_min_stock<?php echo $id ?>, #btn_plus_ok<?php echo $id ?>, #btn_plus_ng<?php echo $id; ?>").attr("disabled", true);
            //     $("#ok<?php echo $id ?>, #ng<?php echo $id; ?>").attr("readonly", true);
            // }

            // $("#stock<?php echo $id; ?>").keyup((e) => {
            //     var stock_value = $(e.target).val();
            //     keep_stock = stock_value;
            //     stock = stock_value;
            //     if(parseInt(stock_value) > 0) {
            //         $("#btn_min_stock<?php echo $id ?>, #btn_plus_ok<?php echo $id ?>, #btn_plus_ng<?php echo $id; ?>").attr("disabled", false);
            //     } else {
            //         $("#btn_min_stock<?php echo $id ?>, #btn_min_ok<?php echo $id ?>, #btn_plus_ok<?php echo $id ?>, #btn_min_ng<?php echo $id; ?>, #btn_plus_ng<?php echo $id; ?>").attr("disabled", true);
            //         $("#ok<?php echo $id ?>, #ng<?php echo $id; ?>").attr("readonly", true);
            //         $("#ok<?php echo $id; ?>").val(0);
            //         $("#ng<?php echo $id; ?>").val(0);
            //     }
            // });

            // $("#btn_plus_ok<?php echo $id; ?>").click(function add() {
            //     var ok_value = $("#ok<?php echo $id; ?>").val();
            //     if(parseInt(ok_value) > 0) {
            //         sisa = parseInt(stock) - 1;
            //         stock = sisa;
            //         $("#btn_min_ok<?php echo $id ?>").attr("disabled", false);
            //         $("#sisa<?php echo $id; ?>").val(sisa);
            //     } else {
            //         sisa = keep_stock;
            //         $("#btn_min_ok<?php echo $id ?>").attr("disabled", true);
            //         $("#sisa<?php echo $id; ?>").val(sisa);
            //     }
            // }); 
            
            // $("#btn_min_ok<?php echo $id; ?>").click(function subst() {
			//     var ok_value = $("#ok<?php echo $id; ?>").val();
            //     if(parseInt(ok_value) > 0) {
            //         sisa++;
            //         $("#sisa<?php echo $id; ?>").val(sisa);
            //     } else {
            //         stock = keep_stock;
            //         $("#sisa<?php echo $id; ?>").val(0); 
            //         $("#btn_min_ok<?php echo $id ?>").attr("disabled", true);
            //     }
            // });

            // $("#btn_plus_ng<?php echo $id; ?>").click(function add() {
            //     var ng_value = $("#ng<?php echo $id; ?>").val();
            //     if(parseInt(ng_value) > 0) {
            //         sisa = parseInt(stock) - 1;
            //         stock = sisa;
            //         $("#btn_min_ng<?php echo $id ?>").attr("disabled", false);
            //         $("#sisa<?php echo $id; ?>").val(sisa);
            //     } else {
            //         sisa = keep_stock;
            //         $("#btn_min_ng<?php echo $id ?>").attr("disabled", true);
            //         $("#sisa<?php echo $id; ?>").val(sisa);
            //     }
            // });

            // $("#btn_min_ng<?php echo $id; ?>").click(function subst() {
            //     console.log("MIN");
            // });          
        <?php
            }
        ?>
	});	
</script>
<script>
    jQuery(document).ready(function($) {
        let banyak_data = 0;
        let banyak_data_realTime = 0;
        let cek_it = <?php echo $count_user; ?>;
        $("#open_chatting").click((e) => {
            function load_chatting() {
                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url('chatting/chat/get_users'); ?>",
                    dataType: "JSON",
                    cache: false,
                    beforeSend: () => {

                    },
                    success: (data_users) => {
                        banyak_data += cek_it;
                        let current_user = <?php echo $this->session->userdata('id_users'); ?>;
                        let user_status;
                        let cnt = 0;
                        console.log(banyak_data);
                        for(i in data_users) {
                            if(current_user != data_users[i].id_users) {
                                cnt += 1;
                            }
                        }


                        if(cek_it === cnt) {
                            if(cnt === banyak_data) {
                                for(i in data_users) {
                                    if(current_user != data_users[i].id_users) {
                                        if(data_users[i].online == '1') {
                                            user_status = "is-online";
                                        } else {
                                            if(data_users[i].online == '0') {
                                                user_status = "is-offline";
                                            }
                                        }
                                        let href_user = "<a href='#' id='"+data_users[i].id_users+"'><span class='user-status "+user_status+"'></span><em>"+data_users[i].full_name+"</em></a>";
                                        $("#group-2").append(href_user);
                                    }
                                }
                            }
                        } else {
                            cek_it = cnt;
                            banyak_data = cek_it;
                        }
                    },
                    error: (jqXHR, textStatus, errorThrown) => {

                    },
                    complete: () => {

                    }
                });
            }
            // load_chatting();
        });

        function load_data_chatting_real_time() {
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('chatting/chat/get_users'); ?>",
                dataType: "JSON",
                cache: false,
                beforeSend: () => {

                },
                success: (data_users) => {
                    $("#group-2").html("");
                    banyak_data_realTime += cek_it;
                    let current_user = <?php echo $this->session->userdata('id_users'); ?>;
                    let user_status;
                    let cnt = 0;
                    console.log(banyak_data_realTime);
                    for(i in data_users) {
                        if(current_user != data_users[i].id_users) {
                            cnt += 1;
                        }
                    }

                    if(cek_it === cnt) {
                        for(i in data_users) {
                            if(current_user != data_users[i].id_users) {
                                $(".status").attr("id", "user-"+data_users[i].id_users);
                                if(data_users[i].online == '1') {
                                    user_status = "is-online";
                                    $("#user-"+data_users[i].id_users).addClass("is-online");
                                } else {
                                    if(data_users[i].online == '0') {
                                        user_status = "is-offline";
                                        $("#user-"+data_users[i].id_users).addClass("is-offline");
                                    }
                                }
                                let href_user = "<a href='#' id='"+data_users[i].id_users+"'><span class='user-status "+user_status+"'></span><em>"+data_users[i].full_name+"</em></a>";
                                $("#group-2").append(href_user);
                            }
                        }
                    } else {
                        cek_it = cnt;
                    }
                },
                error: (jqXHR, textStatus, errorThrown) => {

                },
                complete: () => {

                }
            });
        }

        setInterval(load_data_chatting_real_time, 5000);
    });
</script>
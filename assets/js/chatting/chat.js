function chatting(root_url, current_user, cek_it) {
    jQuery(document).ready(($) => {
        let banyak_data = 0;
        let banyak_data_realTime = 0;
        let get_users = root_url.concat('chatting/chat/get_users');
        function load_data_chatting_real_time() {
            $.ajax({
                type: "GET",
                url: get_users,
                dataType: "JSON",
                cache: false,
                beforeSend: () => {

                },
                success: (data_users) => {
                    $("#group-2").html("");
                    banyak_data_realTime += cek_it;
                    let user_status;
                    let status_login;
                    let cnt = 0;
                    for(i in data_users) {
                        if(current_user != data_users[i].id_users) {
                            cnt += 1;
                        }
                    }

                    if(cek_it === cnt) {
                        for(i in data_users) {
                            if(current_user != data_users[i].id_users) {
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
}
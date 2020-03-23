<script>
    jQuery(document).ready(($) => {
        $("#parts_defect").css("display", "none");
        $("#select_chart").change((e) => {
            let get_value = $(e.target).val();
            if(get_value === '1') {
                $("#annual_monthly").css("display", "block");
                $("#parts_defect").css("display", "none");
            } else {
                if(get_value === '2') {
                    $("#annual_monthly").css("display", "none");
                    $("#parts_defect").css("display", "block");
                }
            }
        });
    });
</script>
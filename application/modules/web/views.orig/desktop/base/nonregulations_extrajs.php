<script type="text/javascript">
    function doclike(group, id) {
        $.ajax({
            type: "GET",
            url: "<?php echo site_url("web/nonregulations/like/") ?>" + group + "/" + id,
            dataType: 'JSON',
            async: false,
            success: function (data) {
                if (data.status === "success") {
                    $("#countliked").html(data.like);
                }
            },
            error: function (error) {
                console.log("cannot send like");
            }
        });

    }
    function docdownloaded(group, id) {
        $.ajax({
            type: "GET",
            url: "<?php echo site_url("web/nonregulations/downloadcount/") ?>" + group + "/" + id,
            dataType: 'JSON',
            async: false,
            success: function (data) {
                if (data.status === "success") {
                    $("#countdownloaded").html(data.downloaded);
                }
            },
            error: function (error) {
                console.log("cannot count downloaded");
            }
        });

    }
</script>
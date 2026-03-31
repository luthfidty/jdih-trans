<script type="text/javascript">
    function doclike(id) {
        $.ajax({
            type: "GET",
            url: "<?php echo site_url("web/documents/like/") ?>" + id,
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
    function docdownloaded(id) {
        $.ajax({
            type: "GET",
            url: "<?php echo site_url("web/documents/downloadcount/") ?>" + id,
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
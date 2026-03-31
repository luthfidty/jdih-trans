<script type="text/javascript">
    function postlike(id, type) {
        let url = '';
        switch (type) {
            case 'page':
                url = "<?php echo site_url("web/pages/like/") ?>";
                break;
            default:
                url = "<?php echo site_url("web/posts/like/") ?>";
        }
        $.ajax({
            type: "GET",
            url: url + id,
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
</script>
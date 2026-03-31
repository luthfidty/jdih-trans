<script type="text/javascript">
    function doclike(id) {
        $.ajax({
            type: "GET",
            url: "<?php echo site_url("web/regulations/like/") ?>" + id,
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
            url: "<?php echo site_url("web/regulations/downloadcount/") ?>" + id,
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

    function openURLInPopup(url, width, height, name) {
        if (typeof (width) == "undefined") {
            width = 800;
            height = 600;
        }
        if (typeof (height) == "undefined") {
            height = 600;
        }
        popup(url, name || 'window' + Math.floor(Math.random() * 10000 + 1), width, height, 'menubar=0,location=0,toolbar=0,status=0,scrollbars=1');
    }
</script>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<script type="text/javascript">
    function filterchar(e) {
        if (e.shiftKey || e.ctrlKey || e.altKey) {
            e.preventDefault();
        } else {
            var key = e.keyCode;
            if (!((key === 8) || (key === 46))) {
                e.preventDefault();
            } else {
                return;
            }
        }
    }
    function getRandomFloat(min, max, decimals) {
        const str = (Math.random() * (max - min) + min).toFixed(
                decimals,
                );
        return parseFloat(str);
    }

    const randomRgbColor = () => {
        let r = Math.floor(Math.random() * 256); // Random between 0-255
        let g = Math.floor(Math.random() * 256); // Random between 0-255
        let b = Math.floor(Math.random() * 256); // Random between 0-255
        return 'rgb(' + r + ',' + g + ',' + b + ',' + getRandomFloat(0, 1, 1) + ')';
    };
    function show_documents(data) {

    }


    $(document).ready(function () {
        $("#alertblock").hide();
    });
    $("#getdatagraph").on('click', function () {
        $("#summaryopt").submit();
    });
    $("#summaryopt").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData($("#summaryopt")[0]);
        $.ajax({
            type: "POST",
            url: "<?php echo site_url("app/summaries/ajax_summary") ?>",
            data: formData,
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                console.log(data);
                if (data.status === "success") {
                    $("#alertblock").removeAttr('class');
                    $("#alertmessage").html('');
                    $("#alertblock").attr('class', 'alert alert-success margin-bottom-30');
                    $("#alertmessage").html(data.msg);
                    $("#alertblock").show();
                    setTimeout(function () {
                        $("#alertblock").hide();
                    }, 5000);
                    $("#<?php echo $this->security->get_csrf_token_name() ?>").val(data.csrftoken);
                } else {
                    $("#alertblock").attr('class', 'alert alert-danger margin-bottom-30');
                    $("#alertmessage").html(data.msg);
                    $("#alertblock").show();
                    setTimeout(function () {
                        $("#alertblock").hide();
                    }, 5000);
                    $("#<?php echo $this->security->get_csrf_token_name() ?>").val(data.csrftoken);
                }
                $("#<?php echo $this->security->get_csrf_token_name() ?>").val(data.csrftoken);
            },
            error: function (error) {
                console.log(error);
                $("#alertblock").attr('class', 'alert alert-danger margin-bottom-30');
                $("#alertmessage").html('Gagal Menampilkan Data. ' + error.responseText);
                $("#alertblock").show();
                $("#<?php echo $this->security->get_csrf_token_name() ?>").val(data.csrftoken);
            }
        });
    });
</script>
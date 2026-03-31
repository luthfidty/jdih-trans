<script>
    $("#checkall").on('click', function () {
        var aa = document.getElementsByTagName("input");
        for (var i = 0; i < aa.length; i++) {
            if (aa[i].type === 'checkbox')
                aa[i].checked = true;
        }
    });

    $("#uncheckall").on('click', function () {
        var aa = document.getElementsByTagName("input");
        for (var i = 0; i < aa.length; i++) {
            if (aa[i].type === 'checkbox')
                aa[i].checked = false;
        }
    });
</script>
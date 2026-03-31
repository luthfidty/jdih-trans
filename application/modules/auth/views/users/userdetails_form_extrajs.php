<script>
    $("#fileimage").change(function () {
        $("#image").val(this.value.replace(/C:\\fakepath\\/i, ''));
    });
</script>
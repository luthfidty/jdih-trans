<script type='text/javascript'>
    jQuery(document).ready(function () {
        let id = $("#catid").val();
        if (!id) {
            $("#clickforedit").hide();
            $("#category").on('keyup', function () {
                let cat = this.value;
                let slug = cat.replace(/ /g, "-");
                $("#slug").val(slug.toLowerCase());
            });
        } else {
            $("#clickforedit").html("Klik kolom Alias untuk mengganti alias!");
            $("#clickforedit").show();
            $("#slug").on('focus', function () {
                let cat = $("#category").val();
                let slug = cat.replace(/ /g, "-");
                $("#slug").val(slug.toLowerCase());
            });
        }

    });
</script>
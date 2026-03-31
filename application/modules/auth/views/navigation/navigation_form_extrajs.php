<script type="text/javascript" src="<?php echo base_url() ?>assets/app/plugins/nestable2/jquery.nestable2.js"></script>
<script>
    $(document).ready(function () {

        var updateOutput = function (e) {
            var list = e.length ? e : $(e.target),
                    output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };

        // pages
        $('#nestable_pages').nestable({
            group: 1
        }).on('change', this.updateOutput);

        // categories
        $('#nestable_category').nestable({
            group: 1
        }).on('change', this.updateOutput);

        //modules
        $('#nestable_modules').nestable({
            group: 1
        }).on('change', this.updateOutput);

        // list menu
        $('#nestable_menu').nestable({
            group: 1
        }).on('change', this.updateOutput);

        $('#menusave').on('click', function (e) {
            updateOutput($('#nestable_menu').data('output', $('#nestable_menu_output')));
            $("#savemenu").submit();
        });

        $("#savemenu").on("submit", function (e) {
            e.preventDefault();
            updateOutput($('#nestable_menu').data('output', $('#nestable_menu_output')));
            $("#savemenu")[0].submit();
        });
    });
</script>
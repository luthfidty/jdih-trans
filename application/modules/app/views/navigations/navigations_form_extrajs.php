<script type="text/javascript" src="<?php echo base_url() ?>assets/app/plugins/nestable2/jquery.nestable2.js"></script>
<script>
$(document).ready(function () {
    // Function to check for duplicate items
    function isDuplicateItem(dataId) {
        return $('#nestable_menu .dd-item[data-id="' + dataId + '"]').length > 0;
    }

    // Function to update the hidden input with the serialized menu structure
    var updateOutput = function () {
        var menuData = $('#nestable_menu').nestable('serialize');
        $('#nestable_menu_output').val(window.JSON ? JSON.stringify(menuData) : 'JSON browser support required.');
        console.log('Serialized menu:', menuData);
    };

    // Initialize Nestable for source panels (left side, read-only)
    const sourcePanels = ['nestable_pages', 'nestable_category', 'nestable_documentcategory', 'nestable_modules', 'nestable_nonreg'];
    sourcePanels.forEach(function(panelId) {
        $('#' + panelId).nestable({
            group: 1,
            maxDepth: 1,
            onDragStart: function(l, e) {
                // Prevent moving source items, only allow copying
                return true;
            }
        });
    });

    // Initialize nestable_menu (right side, editable)
    $('#nestable_menu').nestable({
        group: 1,
        maxDepth: 5,
        beforeDrop: function(l, source, target, position) {
            console.log('Before drop in nestable_menu:', {
                source: source[0],
                target: target[0],
                position: position,
                targetIsTrash: target.closest('#nestable_trash').length,
                targetIsTrashList: target.is('#nestable_trash .trash-list')
            });

            // Handle drops into nestable_menu
            if (target.closest('#nestable_menu').length && position === 'child' && !target.find('> ol.dd-list').length) {
                target.append('<ol class="dd-list"></ol>');
            }

            // Prevent duplicates in nestable_menu
            if (target.closest('#nestable_menu').length && isDuplicateItem(source.data('id'))) {
                alert('Item "' + source.data('id').split(';')[0] + '" already exists in the menu.');
                return false;
            }

            return true;
        },
        callback: function(l, e) {
            // Ensure the dropped item can accept children
            if (!e.find('> ol.dd-list').length) {
                e.append('<ol class="dd-list"></ol>');
            }
            updateOutput();
        }
    }).on('change', updateOutput);

    // Initialize trash bin
    $('#nestable_trash').nestable({
        group: 1,
        maxDepth: 0,
        acceptDrop: function(l, source, target, position) {
            console.log('Trash acceptDrop:', {
                source: source[0],
                target: target[0],
                position: position
            });
            // Only allow drops from nestable_menu
            if (source.closest('#nestable_menu').length) {
                if (confirm('Delete this item?')) {
                    console.log('Removing item:', source[0]);
                    source.remove();
                    $('#nestable_trash .trash-list').empty();
                    updateOutput();
                }
                return false; // Prevent adding to trash
            }
            return false; // Prevent drops from source panels
        }
    });

    // Ensure all items in nestable_menu can accept children
    function ensureNestableStructure() {
        $('#nestable_menu .dd-item').each(function() {
            if (!$(this).find('> ol.dd-list').length) {
                $(this).append('<ol class="dd-list"></ol>');
            }
        });
    }

    // Run on page load
    ensureNestableStructure();

    // Handle "Add Text" button click
    $('#btnaddmenu').on('click', function () {
        var name = $('#nameurl').val();
        var url = $('#url').val();
        var dataId = name + ';' + url;

        if (name && url) {
            if (isDuplicateItem(dataId)) {
                alert('Item "' + name + '" already exists in the menu.');
                return;
            }
            var newItem = $('<li class="dd-item bg-white border rounded shadow-sm p-2" data-id="' + dataId + '">' +
                            '<div class="dd-handle cursor-move">' + name + '</div>' +
                            '<ol class="dd-list"></ol></li>');
            $('#nestable_menu ol#main-list').append(newItem);
            $('#nameurl').val('');
            $('#url').val('');
            updateOutput();
        } else {
            alert('Please enter both Text Name and Text URL.');
        }
    });

    // Handle form submission
    $('#savemenu').on('submit', function (e) {
        e.preventDefault();
        updateOutput();
        this.submit();
    });

    // Initialize the output on page load
    updateOutput();
});
</script>
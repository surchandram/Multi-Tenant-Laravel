<script type="text/javascript">
    document.addEventListener('alpine:init', function () {
        var $selectAll = document.querySelectorAll("input[type=checkbox].select-all");

        if (!$selectAll) {
            return
        }

        [].forEach.call($selectAll, function(selector) {
            let $boxes = document.querySelectorAll(`input[type="checkbox"][data-toggle="${selector.dataset.target}"]`);
            let $boxesCount = $boxes.length;
    
            selector.addEventListener('change', function () {
                var checked = this.checked;

                [].forEach.call($boxes, function(item) {
                    item.checked = checked;
                });
            });

            // boxes event listener
            [].forEach.call($boxes, function(item) {
                item.addEventListener('change', function () {
                    let $checkedBoxes = _.filter($boxes, (item) => item.checked).length;
                    let $uncheckedBoxes = _.filter($boxes, (item) => !item.checked).length;
    
                    if ($checkedBoxes === 0) {
                        selector.indeterminate = false;
                        selector.checked = false;
                    } else if ($checkedBoxes < $boxesCount) {
                        selector.indeterminate = true;
                    } else if ($uncheckedBoxes === 0) {
                        if (selector.indeterminate === true) {
                            selector.indeterminate = false;
                            selector.checked = true;
                        }
                    }
               });
            });
        });

    });
</script>

@stack('scripts')

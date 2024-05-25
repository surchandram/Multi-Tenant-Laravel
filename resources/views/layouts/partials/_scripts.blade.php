<!-- Scripts -->
<script src="https://js.stripe.com/v3/"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        let $selectAll = $("input[type=checkbox]#selectAll");
        let $boxes = $(`input[type="checkbox"][data-toggle="${$selectAll.data('target')}"]`);
        let $boxesCount = $boxes.length;

        $selectAll.change(function () {
            $boxes.prop('checked', $(this).prop('checked'));
        });

        $boxes.change(function () {
            let $checkedBoxes = $boxes.filter(":checked").length;
            let $uncheckedBoxes = $boxes.not(":checked").length;

            if ($checkedBoxes === 0) {
                $selectAll.prop('indeterminate', false);
                $selectAll.prop('checked', false);
            } else if ($checkedBoxes < $boxesCount) {
                $selectAll.prop('indeterminate', true);
            } else if ($uncheckedBoxes === 0) {
                if ($selectAll.prop('indeterminate') === true) {
                    $selectAll.prop('indeterminate', false);
                    $selectAll.prop('checked', true);
                }
            }
        });
    });
</script>

@stack('scripts')

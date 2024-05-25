import { ref, onMounted } from "vue";

export function useFlatpickr(options = {}) {
    const pickrOptions = ref(options);

    const defaultsOptions = {
        pickers: ['all'],
        startDateSelector: '.datepicker-from',
        endDateSelector: '.datepicker-to',
        singleDateSelector: '.datepicker-date',
    };

    var fpckrStartDate;
    var fpckrEndDate;
    var fpckrSingleDate;

    // startDate setup
    const startDatePicker = () => {
        var startDateOptions = {
            dateFormat: "Y-m-d",
            onClose: [
                (selectedDates, dateStr, instances) => {
                    if (_.isEmpty(dateStr)) {
                        return;
                    }

                    fpckrEndDate.set('minDate', dateStr);
                }
            ]
        };

        startDateOptions = Object.assign({}, startDateOptions, pickrOptions.value.startDate || {});

        fpckrStartDate = flatpickr(
            _.get(pickrOptions, 'startDateSelector', defaultsOptions.startDateSelector), startDateOptions
        );

        return fpckrStartDate;
    };

    // endDate setup
    const endDatePicker = () => {
        var endDateOptions = {
            dateFormat: "Y-m-d",
            onClose: [
                (selectedDates, dateStr, instances) => {
                    if (_.isEmpty(dateStr)) {
                        return;
                    }

                    fpckrStartDate.set('maxDate', dateStr);
                }
            ],
        };

        endDateOptions = Object.assign({}, endDateOptions, pickrOptions.value.endDate || {});

        fpckrEndDate = flatpickr(
            _.get(pickrOptions, 'endDateSelector', defaultsOptions.endDateSelector), endDateOptions
        );

        return fpckrEndDate;
    };

    // single date setup
    const singleDatePicker = (elSelector) => {
        var singleDateOptions = {
            dateFormat: "Y-m-d",
        };

        singleDateOptions = Object.assign({}, singleDateOptions, pickrOptions.value.singleDate || {});

        const dateselector = elSelector || _.get(
            pickrOptions.value, 'singleDateSelector', defaultsOptions.endDateSelector
        );

        fpckrSingleDate = flatpickr(
            dateselector, singleDateOptions
        );

        return fpckrSingleDate;
    };

    /**
     * Handle flatpickr setup on component mount.
     */
    onMounted(() => {
        // boot pickers if allowed, default: 'true'
        if (_.get(pickrOptions.value, 'boot', true)) {

            // show range pickers if allowed
            if (
                (_.has(pickrOptions.value, 'pickers') && _.includes(pickrOptions.value.pickers, 'fromToPicker')) ||
                !_.has(pickrOptions.value, 'pickers')
            ) {
                startDatePicker();
                endDatePicker();
            }

            // show single date picker
            if (_.has(pickrOptions.value, 'pickers') && _.includes(pickrOptions.value.pickers, 'date')) {
                singleDatePicker();
            }
        }
    });

    return {
        fpckrStartDate,
        fpckrEndDate,
        fpckrSingleDate,
        startDatePicker,
        endDatePicker,
        singleDatePicker,
    }
};

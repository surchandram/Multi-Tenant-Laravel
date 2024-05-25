// flatpickr
import flatpickr from "flatpickr";

let altInputClass = "w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50";

// datetime picker
flatpickr(".datetimepicker", {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    // wrap: true,
    allowInput: true,
    // static: true,
    altFormat: "l F J, Y H:i K",
    altInput: true,
    altInputClass: altInputClass
});

// date picker
flatpickr(".datepicker", {
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "F j, Y",
    altInputClass: altInputClass
});

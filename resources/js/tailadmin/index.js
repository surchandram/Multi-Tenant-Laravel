// import "../../node_modules/prismjs/themes/prism.min.css";
// import "jsvectormap/dist/css/jsvectormap.css";
import "flatpickr/dist/flatpickr.min.css";
// import "../css/style.css";

import Slugify from 'slugify';
import Currency from 'currency.js';
import Choices from 'choices.js';

var currencyFormatter = function (value, options = {}) {
    return Currency(value, options)
}

var domainSlugger = function(word) {
    return Slugify(word, {
        lower: true,
        remove: new RegExp(/[*+~.()'"!:@#^\\//]/g)
    })
}

var domainNamer = function(word) {
    return word.replace(new RegExp(/[*+~.()'"!:@#^%,\\//]/g), '')
}

window.Choices = Choices
window.slugify = Slugify
window.domainNamer = domainNamer
window.domainSlugger = domainSlugger
window.currencyFormatter = currencyFormatter

import Alpine from 'alpinejs';

import FiltersMap from '../filters-map';
import scrollTo from 'alpinejs-scroll-to';
import intersect from "@alpinejs/intersect";

import Prism from "prismjs";
import flatpickr from "flatpickr";

import chart01 from "./components/chart-01";
import chart02 from "./components/chart-02";
import chart03 from "./components/chart-03";
import chart04 from "./components/chart-04";
import map01 from "./components/map-01";

Alpine.plugin(intersect);
Alpine.plugin(scrollTo);
Alpine.data('FiltersMap', FiltersMap);
Alpine.directive('choicesjs', (el, {}, { cleanup }) => {
  const choice = new window.Choices(el, {
      removeItemButton: true
    });

    let handler = function (event) {
      if (typeof el._x_model !== 'undefined') {
        el._x_model.set(choice.getValue(true));
      }
    };

    window.addEventListener('change', handler)

    cleanup(() => {
        window.removeEventListener('click', handler)
    })

});
window.Alpine = Alpine;
Alpine.start();

// Init flatpickr
flatpickr(".datepicker", {
  mode: "range",
  static: true,
  monthSelectorType: "static",
  dateFormat: "M j, Y",
  defaultDate: [new Date().setDate(new Date().getDate() - 6), new Date()],
  prevArrow:
    '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
  nextArrow:
    '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
  onReady: (selectedDates, dateStr, instance) => {
    // eslint-disable-next-line no-param-reassign
    instance.element.value = dateStr.replace("to", "-");
    const customClass = instance.element.getAttribute("data-class");
    instance.calendarContainer.classList.add(customClass);
  },
  onChange: (selectedDates, dateStr, instance) => {
    // eslint-disable-next-line no-param-reassign
    instance.element.value = dateStr.replace("to", "-");
  },
});

// Document Loaded
document.addEventListener("DOMContentLoaded", () => {
  chart01();
  chart02();
  chart03();
  chart04();
  map01();
});
